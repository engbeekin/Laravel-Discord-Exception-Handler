<?php

namespace App\Http\Controllers;

use App\Helpers\DataLogger;

use App\Logger\DiscordLogger;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class DiscordTest extends Controller
{
    public function __construct(private readonly DataLogger $dataLogger
    )
    {
    }

    /**
     * @return Application|Factory|View|string
     */
    public function index(): Application|Factory|View|string
    {
        try {
            return view('discord.index');
        } catch (Exception $e) {
            $this->dataLogger->logException($e, [
                __LINE__,
                __CLASS__,
                __METHOD__,
            ]);

            return 'Not found';
        }
    }

    /**
     * @return string
     */
    public function sendMessageToDiscord(): string
    {
        $this->dataLogger->addMessage('The Cron is successfully completed.');
        $this->dataLogger->logMessages();
        return 'completed';

    }
}
