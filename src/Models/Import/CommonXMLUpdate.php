<?php


namespace faraamds\fias\Models\Import;


use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use faraamds\fias\Models\ImportFile;
use XMLReader;

trait CommonXMLUpdate
{
    abstract function getTable();

    public static function update_table(string $path=null) : void
    {
        (new static())->process_update($path);
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    protected function process_update(string $path=null) : void
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

        while ($z->name === $this->xml_object_tag_name)
        {
            $row = [];

            foreach ($this->import_fields as $field => $xml_field) {

                $row[$field] = $z->getAttribute($xml_field);
            }
            $row['updated_at'] = $now;

            if (static::where($this->fias_key_field, $row[$this->fias_key_field])->count() > 0) {
                static::where($this->fias_key_field, $row[$this->fias_key_field])->update($row);
            } else {
                $row['created_at'] = $now;
                static::create($row);
            }

            $z->next($this->xml_object_tag_name);
        }

        $this->writeFilename($files[0]);
    }
}