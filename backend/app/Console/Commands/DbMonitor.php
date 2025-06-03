<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDOException;

class DbMonitor extends Command
{
    protected $signature = 'db:monitor';
    protected $description = 'Check if database is ready';

    public function handle()
    {
        $maxAttempts = 30;
        $attempt = 0;
        $connected = false;

        while (!$connected && $attempt < $maxAttempts) {
            try {
                DB::connection()->getPdo();
                $connected = true;
                $this->info('Database connection successful!');
                return 0;
            } catch (PDOException $e) {
                $attempt++;
                $this->warn("Attempt $attempt/$maxAttempts: " . $e->getMessage());
                sleep(1);
            }
        }

        $this->error('Could not connect to the database after ' . $maxAttempts . ' attempts');
        return 1;
    }
}
