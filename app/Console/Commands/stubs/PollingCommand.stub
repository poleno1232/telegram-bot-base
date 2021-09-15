<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use BadMethodCallException;
use Illuminate\Console\Command;
use Telegram\Bot\Api as TelegramBot;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class PollingCommand extends Command
{
    protected TelegramService $service;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:polling {bot?} {--once} {--stop-if-error}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Long-polling, that handles all updates';

    protected TelegramBot $bot;

    public function __construct()
    {
        parent::__construct();

        $this->service = new TelegramService();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = Telegram::bot($this->argument('bot'));
        $triggerable = collect(Telegram::getBotConfig($this->argument('bot'))['commands']);
        $isEndless = !((bool) $this->option('once'));
        $stopIfError = (bool) $this->option('stop-if-error');

        $offset = 0;
        $updates = [];

        $this->info('Long-polling started...');

        do {
            try {
                $updates = $bot->getUpdates(['offset' => $offset + 1, 'limit' => 100]);

                if (empty($updates)) {
                    continue;
                }

                $this->info("\nNew updates...");

                foreach ($updates as $update) {
                    $this->service->setData($bot, $update);

                    if ($update->hasCommand()) {
                        $this->info("Command detected");
                        $bot->processCommand($update);
                    } else {
                        $this->info("Update detected ");

                        if (isset($update['callback_query'])) {
                            $this->service->handleUpdates($update['callback_query']['data']);
                        }
                    }

                    $this->nextUpdate($update, $bot);
                }
            } catch (TelegramSDKException $e) {
                $this->alert('API-side error detected or Telegram bot was\'t set up. Bailing out.');
                $this->warn("Error message:\n\t" . $e->getMessage());

                if ($stopIfError) {
                    break;
                }

                $this->nextUpdate($update, $bot);
            } catch (BadMethodCallException $e) {
                $this->alert('Command called non-existent or unsupported API-method. Bailing out.');
                $this->warn("Error message:\n\t" . $e->getMessage());

                if ($stopIfError) {
                    break;
                }

                $this->nextUpdate($update, $bot);
            }
        } while ($isEndless);

        $this->info("\nLong-polling finished");
    }

    private function nextUpdate($update, $bot)
    {
        $offset = $update->updateId;
        $bot->getUpdates(['offset' => $offset + 1, 'limit' => 1]);
    }
}
