<?php


namespace faraamds\fias\Console\Commands;


use faraamds\fias\database\ProcedureLoader;
use Illuminate\Console\Command;
use faraamds\fias\database\Generator;

class LoadProcedures extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fias:load-procedures';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'fias:load-procedures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load postgresql procedures';

    /** @var Generator */
    protected $loader;

    /**
     * MakeMigrations constructor.
     * @param ProcedureLoader $loader
     */
    public function __construct(ProcedureLoader $loader)
    {
        parent::__construct();

        $this->loader = $loader;
    }

    /**
     * Executes console command.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle() : int
    {
        $this->loader->run();

        return 0;
    }
}
