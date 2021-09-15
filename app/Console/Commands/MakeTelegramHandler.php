<?php

namespace App\Console\Commands;

use App\Telegram\Handlers\AbstractHandler;
use Illuminate\Console\GeneratorCommand;

class MakeTelegramHandler extends GeneratorCommand
{
    protected $type = AbstractHandler::class;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected function getStub()
    {
        return __DIR__ . '\\stubs\\newhandler.stub';
    }
}
