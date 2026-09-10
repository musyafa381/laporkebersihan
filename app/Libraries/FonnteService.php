<?php

namespace App\Libraries;

class FonnteService
{
    protected string $token;

    public function __construct(?string $token = null)
    {
        if ($token !== null && trim($token) !== '') {
            $this->token = trim($token);
        } else {
            $pengaturanModel = new \App\Models\PengaturanModel();
            $settings = $pengaturanModel->getAllAsMap();
            $this->token = trim($settings['fonnte_token'] ?? (env('FONNTE_TOKEN') ?: ''));
        }
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Send text message via Fonnte API
     * @param string $target Destination WhatsApp number
     * @param string $message Text message
     * @return array Status, message, and details
     */
    public function sendMessage(string $target, string $message): array
    {
        if (empty($this->token)) {
            return [
                'status'  => false,
                'message' => 'Token API Fonnte belum dikonfigurasi di Pengaturan Sistem atau file .env.',
            ];
        }

        // Clean & normalize phone number
        $cleanPhone = preg_replace('/[^0-9]/', '', $target);
        if (empty($cleanPhone) || strlen($cleanPhone) < 9) {
            return [
                'status'  => false,
                'message' => 'Nomor WhatsApp tujuan tidak valid.',
            ];
        }

        // Format to 62 if starts with 0
        if (substr($cleanPhone, 0, 1) === '0') {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => [
                'target'      => $cleanPhone,
                'message'     => $message,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER     => [
                'Authorization: ' . $this->token,
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($err) {
            return [
                'status'  => false,
                'message' => 'Gagal menghubungi server Fonnte: ' . $err,
            ];
        }

        $resJson = json_decode($response, true);
        if (isset($resJson['status']) && $resJson['status'] === true) {
            return [
                'status'  => true,
                'message' => 'Pesan WhatsApp berhasil dikirim.',
                'data'    => $resJson,
            ];
        }

        $reason = $resJson['reason'] ?? ($resJson['message'] ?? 'Respon gateway tidak valid');
        return [
            'status'   => false,
            'message'  => 'Gagal mengirim pesan WhatsApp: ' . $reason,
            'raw'      => $response,
            'httpCode' => $httpCode,
        ];
    }
}
