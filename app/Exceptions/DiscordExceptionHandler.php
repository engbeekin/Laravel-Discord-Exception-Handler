<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DiscordExceptionHandler extends ExceptionHandler
{
    /**
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        if ($this->shouldReport($e)) {
            $this->sendToDiscord($e);
        }

        parent::report($e);
    }

    /**
     * @param $exception
     * @return void
     */
    private function sendToDiscord($exception): void
    {
        // Retrieve Discord webhook URL from the environment
        $webhookUrl = env('DISCORD_WEBHOOK_URL');
        if (!$webhookUrl) {
            // Log a warning if the webhook URL is not configured
            Log::warning('Discord webhook URL not configured.');
            return;
        }

        $message = date("Y/m/d h:i:s") . " | " . "️⚠️ Exception: " . get_class($exception) . "\n";
        $message .= date("Y/m/d h:i:s") . " | " . "️⚠️ Message: " . $exception->getMessage() . "\n";
        $message .= date("Y/m/d h:i:s") . " | " . "File: " . $exception->getFile() . "\n";
        if (!empty($exception->getTrace())) {
            $message .= date("Y/m/d h:i:s") . " | " . "Method: " . $exception->getTrace()[0]['function'] . "\n";
        }
        $message .= "Line: " . $exception->getLine() . "\n";

        Http::post($webhookUrl, [
            'content' => $message,
        ]);
    }
}
