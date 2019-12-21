<?php


namespace faraamds\fias\database;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class ProcedureLoader
{
    /** @var Filesystem */
    protected $filesystem;

    /**
     * Generator constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        $files = $this->getProcedureFiles();

        foreach ($files as $file) {
            DB::unprepared('DROP FUNCTION IF EXISTS ' . pathinfo($file, PATHINFO_FILENAME));
            DB::unprepared($this->filesystem->get($file));
        }
    }

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    protected function getProcedureFiles()
    {
        return $this->filesystem->files($this->getSubPath());
    }

    /**
     * @return string
     */
    protected function getSubPath() : string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'procedures' . DIRECTORY_SEPARATOR . 'postgresql';
    }

}
