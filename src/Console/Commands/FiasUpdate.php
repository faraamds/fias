<?php


namespace faraamds\fias\Console\Commands;


use faraamds\fias\Facades\Fias;
use Illuminate\Console\Command;

class FiasUpdate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fias:update';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'fias:update {--path= : storage subdir path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data from xml';

    public function handle() : void
    {
        $path = $this->option('path');

        Fias::update($path);
    }
}