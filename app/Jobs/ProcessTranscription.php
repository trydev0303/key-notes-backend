<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\Recording;

class ProcessTranscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recordingId;

    /**
     * Create a new job instance.
     *
     * @param int $recordingId
     */
    public function __construct($recordingId)
    {
        $this->recordingId = $recordingId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Processing transcription for recording ID: {$this->recordingId}");

        try {
            $recording = Recording::findOrFail($this->recordingId);

            $audioFilePath = public_path('recordings') . DIRECTORY_SEPARATOR . $recording->recording;
            if (!file_exists($audioFilePath)) {
                throw new \Exception("Audio file not found at: {$audioFilePath}");
            }

            $audioContent = base64_encode(file_get_contents($audioFilePath));
            $apiKey = config('services.google.api_key');

            $data = [
                'config' => [
                    'encoding' => 'MP3',
                    'sampleRateHertz' => 16000,
                    'languageCode' => 'en-US',
                ],
                'audio' => [
                    'content' => $audioContent,
                ],
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://speech.googleapis.com/v1p1beta1/speech:recognize?key={$apiKey}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => json_encode($data),
            ]);

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            // if ($error) {
            //     throw new \Exception("Google Speech-to-Text API error: {$error}");
            // }

            // $responseDecoded = json_decode($response, true);
            // $transcriptionText = '';

            // foreach ($responseDecoded['results'] ?? [] as $result) {
            //     foreach ($result['alternatives'] ?? [] as $alternative) {
            //         $transcriptionText .= $alternative['transcript'] . " ";
            //     }
            // }

            // $recording->transcription_box = trim($transcriptionText);
            // $recording->save();

            // Log::info("Transcription completed for recording ID: {$this->recordingId}");
            if ($error) {
                Log::error("Transcription cURL Error: {$error}");
            } else {
                $responseDecoded = json_decode($response, true);
                $text = '';
                foreach ($responseDecoded['results'] as $result) {
                    foreach ($result['alternatives'] as $alternative) {
                        $text .= $alternative['transcript'] . " ";
                    }
                }

                $recording->transcription_box = trim($text);
                $recording->save();
            }

        } catch (\Exception $e) {
            Log::error("Error processing transcription: " . $e->getMessage());
            throw $e; // Ensure the job is marked as failed
        }
    }

    /**
     * Handle failed job.
     *
     * @param \Exception $exception
     */
    public function failed(\Exception $exception)
    {
        Log::error("Transcription job failed for recording ID: {$this->recordingId}. Error: {$exception->getMessage()}");
    }
}
