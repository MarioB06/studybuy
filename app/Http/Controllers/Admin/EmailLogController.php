<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class EmailLogController extends Controller
{
    /**
     * Display email logs from Laravel log file.
     */
    public function index(Request $request): View
    {
        $logFile = storage_path('logs/laravel.log');
        $emails = [];
        $rawLog = '';

        if (File::exists($logFile)) {
            $rawLog = File::get($logFile);

            // Parse log entries for email-related content
            $emails = $this->parseEmailLogs($rawLog);

            // Reverse to show newest first
            $emails = array_reverse($emails);

            // Limit to last 50 emails for performance
            $emails = array_slice($emails, 0, 50);
        }

        return view('admin.email-logs', compact('emails', 'rawLog'));
    }

    /**
     * Parse email logs from Laravel log content.
     */
    private function parseEmailLogs(string $logContent): array
    {
        $emails = [];
        $lines = explode("\n", $logContent);

        $currentEmail = null;
        $inMessage = false;
        $messageContent = '';

        foreach ($lines as $line) {
            // Detect start of new log entry
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2}[T\s]\d{2}:\d{2}:\d{2})/', $line, $matches)) {
                // Save previous email if exists
                if ($currentEmail && $inMessage) {
                    $currentEmail['content'] = $messageContent;
                    $emails[] = $currentEmail;
                    $currentEmail = null;
                    $inMessage = false;
                    $messageContent = '';
                }

                // Check if this is an email-related log entry
                if (stripos($line, 'local.INFO: Message-ID:') !== false ||
                    stripos($line, 'Message-ID:') !== false) {

                    $currentEmail = [
                        'timestamp' => $matches[1],
                        'to' => '',
                        'subject' => '',
                        'content' => '',
                        'raw' => $line
                    ];

                    // Extract To address
                    if (preg_match('/To:\s*([^\r\n]+)/', $line, $toMatch)) {
                        $currentEmail['to'] = trim($toMatch[1]);
                    }

                    // Extract Subject
                    if (preg_match('/Subject:\s*([^\r\n]+)/', $line, $subjectMatch)) {
                        $currentEmail['subject'] = trim($subjectMatch[1]);
                    }

                    $inMessage = true;
                    $messageContent = $line;
                }
            } elseif ($inMessage) {
                // Continue collecting message content
                $messageContent .= "\n" . $line;

                // Try to extract To if not found yet
                if (empty($currentEmail['to']) && preg_match('/To:\s*([^\r\n]+)/', $line, $toMatch)) {
                    $currentEmail['to'] = trim($toMatch[1]);
                }

                // Try to extract Subject if not found yet
                if (empty($currentEmail['subject']) && preg_match('/Subject:\s*([^\r\n]+)/', $line, $subjectMatch)) {
                    $currentEmail['subject'] = trim($subjectMatch[1]);
                }
            }
        }

        // Save last email if exists
        if ($currentEmail && $inMessage) {
            $currentEmail['content'] = $messageContent;
            $emails[] = $currentEmail;
        }

        return $emails;
    }

    /**
     * Clear email logs.
     */
    public function clear(): \Illuminate\Http\RedirectResponse
    {
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            File::put($logFile, '');
        }

        return redirect()->route('admin.email-logs.index')
            ->with('success', 'E-Mail-Logs wurden erfolgreich gelöscht.');
    }
}
