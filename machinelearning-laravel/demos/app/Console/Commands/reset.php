<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;

class reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ml:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset ML databases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Connection $db)
    {
        $db->statement("DELETE FROM occurrences;");
    }
}
