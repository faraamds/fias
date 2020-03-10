<?php


namespace faraamds\fias\Console\Commands;


use Illuminate\Console\Command;
use faraamds\fias\database\Generator;

class MakeMigrations extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fias:make-migrations';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'fias:make-migrations {--dir= : Where create migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new migrations for FIAS tables';

    /** @var Generator */
    protected $generator;

    /**
     * MakeMigrations constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    /**
     * Executes console command.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle() : void
    {
        $migrations = $this->generator->run($this->option('dir'));

        foreach ($migrations as $migration) {
            $this->line("      <fg=green;options=bold>create</fg=green;options=bold>  $migration");
        }
    }
}
