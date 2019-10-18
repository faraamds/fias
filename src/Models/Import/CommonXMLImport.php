<?php


namespace faraamds\fias\Models\Import;


use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use faraamds\fias\Models\ImportFile;
use XMLReader;

trait CommonXMLImport
{
    abstract function getTable();

    public static function import(string $path=null) : void
    {
        (new static())->process_import($path);
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    protected function process_import(string $path=null) : void
    {
        $path = $path ?: 'import';
        $filename = $this->xml_file_prefix;
        $files = glob(storage_path( $path . DIRECTORY_SEPARATOR . "{$filename}*"));
        if (count($files) === 0) {
            return;
        }
        $z = new XMLReader;
        $z->open($files[0]);

        $now = Carbon::now()->toDateTimeString();

        DB::table($this->getTable())->truncate();

        $i = 0;
        while ($z->read() && $z->name !== $this->xml_object_tag_name) {
            if ($i++ > 10) {
                throw new \Exception("Element {$$this->xml_object_tag_name} not found in {$files[0]} after 10 iterations");
            }
        }

        $rows = [];

        while ($z->name === $this->xml_object_tag_name)
        {
            $row = [];

            foreach ($this->import_fields as $field => $xml_field) {

                $row[$field] = $z->getAttribute($xml_field);
            }
            $row['created_at'] = $now;
            $row['updated_at'] = $now;

            $rows[] = $row;

            if (count($rows) === 1000) {
                DB::table($this->getTable())->insert($rows);
                $rows = [];
            }

            $z->next($this->xml_object_tag_name);
        }

        if (count($rows) > 0) {
            DB::table($this->getTable())->insert($rows);
            $rows = [];
        }

        $this->createIndexes();
        $this->additionalImportActions();
        $this->writeFilename(pathinfo($files[0], PATHINFO_BASENAME));
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

    /**
     * @param string $filename
     */
    protected function writeFilename(string $filename) : void
    {
        ImportFile::create([
            'timestamp' => Carbon::now(),
            'filename' => $filename,
        ]);
    }

    protected function additionalImportActions() : void
    {

    }
}