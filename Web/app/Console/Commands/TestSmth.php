<?php

namespace App\Console\Commands;

use App\Http\Services\Utils;
use Illuminate\Console\Command;

class TestSmth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-smth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        die(Utils::generate_user_id('h01oc0st225@gmail.com'));
    }
}
