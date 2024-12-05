<?php


namespace App\Helpers;

use App\Interfaces\ILogger;
use Illuminate\Support\Facades\Http;

class DataLogger implements ILogger
{
    private array $messages = [];

    public function addMessage(string $message, bool $showDate = false): void
    {
        $this->messages[] = ["message" => $message, "showDate" => $showDate];
    }

    /**
     * adding a message to log discord
     * @return void
     */
    public function logMessages(): void
    {
        $output = "";
        foreach ($this->messages as $message) {
            $thisMessage = "";

            if ($message["showDate"]) {
                $thisMessage = date("Y/m/d h:i:s") . " | " . $message["message"];
            } else {
                $thisMessage = $message["message"];
            }

            if (strlen($thisMessage) + strlen($output) < 2000) {
                $output .= $thisMessage . "\n";
            } else {
                $this->logToDiscord($output);
                $output = $thisMessage . "\n";
            }
        }
        $this->logToDiscord($output);
    }

    public function logException($exception, array|null $errorLocation = []): void
    {
        $this->addMessage("⚠️⚠️ Class: " . get_class($exception), true);
        $this->addMessage("⚠️⚠️ Message: " . substr($exception->getMessage(), 0, 1000), true);
        $this->addMessage('Line: ' . $exception->getLine(), true);
        if (!empty($errorLocation)) {
            $this->addMessage("Exception Line Number: " . $errorLocation[0], true);
            $this->addMessage("Class Line Number: " . $errorLocation[1], true);
            $this->addMessage("Method Line Number: " . $errorLocation[2], true);
        }
        $this->logMessages();
    }

    /**
     * push the message to the channel
     * @param string $message
     * @return void
     */
    private function logToDiscord(string $message): void
    {
        // Retrieve Discord webhook URL from the environment
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        try {
            Http::post($webhookUrl, [
                'content' => $message
            ]);
        } catch (\Throwable $th) {
            echo "Failed to log message to Discord";
        }
    }
}