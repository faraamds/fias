<?php


namespace faraamds\fias\Models\Import;


use Carbon\Carbon;
use faraamds\fias\Exceptions\FiasImportFileNotFoundException;
use faraamds\fias\Exceptions\FiasImportTooManyFilesException;
use faraamds\fias\Exceptions\FiasXmlModelNotFoundException;
use faraamds\fias\Models\ImportedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use XMLReader;

abstract class FiasImport
{
    /** @var string */
    protected $xml_file_prefix;

    /** @var string */
    protected $xml_object_tag_name;

    /** @var array ['db_field_name' => 'XML_field_name'] */
    protected $import_fields;

    /** @var array ['db_key_field_name'] */
    protected $index_fields;

    /** @var string <p>Primary key field name</p> */
    protected $fias_key_field;

    /** @var int */
    protected $mass_insert_row_count = 1000;

    /** @var XMLReader */
    protected $xmlReader;

    /** @var array */
    protected $import_files;

    /** @var string */
    protected $current_file_name;

    /** @var string */
    protected $path;

    /** @var string */
    protected $table_name;

    abstract protected function getModelObject() : Model;

    public static function import(string $path=null) : void
    {
        (new static())->process_import($path);
    }

    public static function update(string $path=null) : void
    {
        (new static())->process_update($path);
    }

    protected function additionalImportActions() : void
    {
        //Do nothing
    }

    /**
     * @param string|null $path
     */
    protected function process_import(string $path=null) : void
    {
        $this->findFiles($path);
        if (count($this->import_files) > 1) {
            throw new FiasImportTooManyFilesException('Too many files for import. Must be only one.');
        }
        $this->current_file_name = Arr::first($this->import_files);
        $this->initXmlReader();

        DB::table($this->getTable())->truncate();

        $rows = [];

        while ($this->hasMoreModels())
        {
            $rows[] = $this->getArrayOfRowsAndRewindToNext();

            if (count($rows) === $this->mass_insert_row_count) {
                DB::table($this->getTable())->insert($rows);
                $rows = [];
            }
        }

        if (count($rows) > 0) {
            DB::table($this->getTable())->insert($rows);
        }

        $this->createIndexes();
        $this->additionalImportActions();
        $this->writeFilename();
    }

    protected function process_update(string $path=null) : void
    {

        $this->findFiles($path);
        array_walk($this->import_files, function ($file) {
            $this->current_file_name = $file;
            $this->initXmlReader();

            while ($this->hasMoreModels()) {
                $rows = $this->getArrayOfRowsAndRewindToNext();

                DB::table($this->getTable())->updateOrInsert([$this->fias_key_field => $rows[$this->fias_key_field]], $rows);
            }

            $this->writeFilename();
        });
    }

    /**
     * @param string|null $path
     */
    protected function findFiles(string $path = null) : void
    {
        $this->path = $path ?: 'import';
        $filename = $this->xml_file_prefix;
        $files = glob(storage_path( $this->path . DIRECTORY_SEPARATOR . "{$filename}*"));

        $files = Arr::sort(array_filter($files, function ($file_name) {
            return ! ImportedFile::where('filename', pathinfo($file_name, PATHINFO_BASENAME))->exists();
        }));

        $this->import_files = $files;
    }

    protected function initXmlReader(): void
    {
        if (!$this->current_file_name) {
            throw new FiasImportFileNotFoundException("Import file with prefix {$this->xml_file_prefix} not found in {$this->path}");
        }

        $this->createXmlReader();
        $this->openXmlFile();
        $this->rewindCursorToFirstModel();
    }

    protected function createXmlReader() : void
    {
        $this->xmlReader = new XMLReader;
    }

    protected function openXmlFile() : void
    {
        $this->xmlReader->open($this->current_file_name);
    }

    protected function rewindCursorToFirstModel() : void
    {
        $i = 0;
        while ($this->xmlReader->read() && $this->xmlReader->name !== $this->xml_object_tag_name) {
            if ($i++ > 10) {
                throw new FiasXmlModelNotFoundException("Element {$this->xml_object_tag_name} not found in {$this->current_file_name} after 10 iterations");
            }
        }
    }

    /**
     * @return bool
     */
    protected function hasMoreModels(): bool
    {
        return $this->xmlReader->name === $this->xml_object_tag_name;
    }

    /**
     * @return array
     */
    protected function getArrayOfRowsAndRewindToNext(): array
    {
        $row = [];
        $now = Carbon::now();

        foreach ($this->import_fields as $field => $xml_field) {

            $row[$field] = $this->xmlReader->getAttribute($xml_field);
        }
        $row['created_at'] = $now;
        $row['updated_at'] = $now;

        $this->xmlReader->next($this->xml_object_tag_name);

        return $row;
    }

    protected function createIndexes() : void
    {
        try {

            Schema::table($this->getTable(), function (Blueprint $table) {

                foreach ($this->index_fields as $field) {

                    $table->index($field);
                }
            });

        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());
        }
    }

    protected function writeFilename() : void
    {
        ImportedFile::create([
            'timestamp' => Carbon::now(),
            'filename' => pathinfo($this->current_file_name, PATHINFO_BASENAME),
        ]);
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        if (!$this->table_name) {

            $this->table_name = $this->getModelObject()->getTable();
        }

        return $this->table_name;
    }

}