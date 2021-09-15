<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeBotBaseCommand extends Command
{
    protected const COMMANDS_PATH = 'app/Console/Commands/';
    protected const STUB_PATH = 'app/Console/Commands/stubs/';
    protected const CONTROLLERS_PATH = 'app/Http/Controllers/';
    protected const SERVICES_PATH = 'app/Services/';
    protected const HANDLERS_PATH = 'app/Telegram/Handlers/';

    protected const STUBS = [
        'AbstractHandler' => self::HANDLERS_PATH,
        'PollingCommand' => self::COMMANDS_PATH,
        'TelegramService' => self::SERVICES_PATH,
        'WebhookController' => self::CONTROLLERS_PATH,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates base files for bot';

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
     * @return int
     */
    public function handle()
    {
        $this->output->info("Processing stub files");

        foreach (self::STUBS as $name => $path) {
            $stubData = file_get_contents(__DIR__ . '\\stubs\\' . $name . '.stub');
            file_put_contents(base_path() . '\\' . $path . $name . '.php', $stubData);

            $this->output->info("{$name} has been processed");
        }

        $this->output->info("Processing complete");

        return 0;
    }
}
