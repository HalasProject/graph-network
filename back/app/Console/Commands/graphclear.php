<?php

namespace App\Console\Commands;

use App\Node;
use App\Relation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class graphclear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graphs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all graphs (Delete all nodes & relations)';

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
    public function handle()
    {
        if ($this->confirm('Are you sure to delete all Nodes !')) {
            DB::statement("SET foreign_key_checks=0");
            Relation::truncate();
            Node::truncate();
            DB::statement("SET foreign_key_checks=1");
        }
    }
}
