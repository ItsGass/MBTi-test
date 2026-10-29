<?php

namespace App\Console\Commands;

use App\Enums\SessionStatus;
use App\Models\UserTest;
use Illuminate\Console\Command;

class ExpireTestSessions extends Command
{
    protected $signature = 'mbti:expire-sessions';

    protected $description = 'Mark unfinished MBTI attempts past their resume window as expired';

    public function handle(): int
    {
        $expired = UserTest::query()
            ->where('status', SessionStatus::InProgress)
            ->where('expires_at', '<', now())
            ->update(['status' => SessionStatus::Expired]);

        $this->info("{$expired} sesi tes ditandai kedaluwarsa.");

        return self::SUCCESS;
    }
}
