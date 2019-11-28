<?php


namespace faraamds\fias\Console\Commands;


use faraamds\fias\Facades\Fias;
use Illuminate\Console\Command;

class FiasImport extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fias:import';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'fias:import {--path= : storage subdir path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from xml';

    public function handle()
    {
        $path = $this->option('path');

        Fias::import($path);
    }
}