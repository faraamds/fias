<?php


namespace faraamds\fias\database;


use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;

class Generator
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
     * @param string|null $targetPath
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run(string $targetPath = null) : array
    {
        $createdFiles = [];

        $files = $this->getMigrationFiles();

        $targetPath = $targetPath ?: $this->getTargetPath();

        foreach ($files as $file) {
            $timestamp = Carbon::now();
            $newFileName = $timestamp->format('Y_m_d_His') . '_'
                . pathinfo($file, PATHINFO_FILENAME)
                . '.php';
            $this->filesystem->put(
                $targetPath . DIRECTORY_SEPARATOR .  $newFileName,
                $this->filesystem->get($file)
            );
            $createdFiles[] = $newFileName;
        }

        return $createdFiles;
    }

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    protected function getMigrationFiles()
    {
        return $this->filesystem->files($this->getSubPath());
    }

    /**
     * @return string
     */
    protected function getSubPath() : string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'migrations';
    }

    /**
     * @return string
     */
    protected function getTargetPath() : string
    {
        return 'database' . DIRECTORY_SEPARATOR . 'migrations';
    }
}