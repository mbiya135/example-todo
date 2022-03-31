<?php

namespace App\Console\Commands;

use App\Email\Infrastructure\ProviderEmailApi;
use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CheckEmailStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-email-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private ProviderEmailApi $emailApi
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // use query to search by status, all just for time
        $emails = Email::all();
        foreach ($emails as $email) {
            $this->info('Stat check email status  : ' . $email->messageId);
            $status = $this->emailApi->getEmailStatus(
                $email
            );
            if ($status) {
                $email->saveDelivered($status);
            }
        }
        return 0;
    }
}
