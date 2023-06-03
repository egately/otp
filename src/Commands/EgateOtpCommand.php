<?php

namespace Egate\EgateOtp\Commands;

use Illuminate\Console\Command;

class EgateOtpCommand extends Command
{
    public $signature = 'egate-otp';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
