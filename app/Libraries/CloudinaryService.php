<?php

namespace App\Libraries;

class CloudinaryService
{
    protected string $cloudName;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct()
    {
        $this->cloudName = env('cloudinary.cloudName', 'mqnzqvfe');
        $this->apiKey    = env('cloudinary.apiKey', '366815464184382');
        $this->apiSecret = env('cloudinary.apiSecret', 'mUQy3spyZDKNyn6YuPijQCcGRiM');
    }

    /**
     * Upload an image file or filepath to Cloudinary
     *
     * @param string|\CodeIgniter\HTTP\Files\UploadedFile $file Filepath or UploadedFile
     * @param string $folder Cloudinary folder prefix (e.g. 'cs_reports')
     * @param string|null $customName Custom name for the file / public_id
     * @return array [ 'success' => bool, 'url' => string|null, 'public_id' => string|null, 'error' => string|null ]
     */
    public function upload($file, string $folder = 'cs_reports', ?string $customName = null): array
    {
        if (empty($this->cloudName) || empty($this->apiKey) || empty($this->apiSecret)) {
            return [
                'success' => false,
                'url'     => null,
                'error'   => 'Kredensial Cloudinary belum lengkap di konfigurasi.'
            ];
        }

        $filePath = '';
        if ($file instanceof \CodeIgniter\HTTP\Files\UploadedFile) {
            if (!$file->isValid() || $file->hasMoved()) {
                return ['success' => false, 'url' => null, 'error' => 'File upload tidak valid.'];
            }
            $filePath = $file->getTempName();
        } elseif (is_string($file) && file_exists($file)) {
            $filePath = $file;
        } else {
            return ['success' => false, 'url' => null, 'error' => 'Path file tidak ditemukan.'];
        }

        $timestamp = time();
        
        // Parameter upload yang disign
        $paramsToSign = [
            'folder'    => $folder,
            'timestamp' => $timestamp,
        ];

        if (!empty($customName)) {
            // Bersihkan nama file agar aman untuk Cloudinary URL
            $cleanName = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $customName);
            $cleanName = preg_replace('/\s+/', '_', trim($cleanName));
            if (!empty($cleanName)) {
                $paramsToSign['public_id'] = $cleanName . '_' . substr(uniqid(), -4);
            }
        }

        ksort($paramsToSign);
        $signString = '';
        foreach ($paramsToSign as $k => $v) {
            $signString .= "{$k}={$v}&";
        }
        $signString = rtrim($signString, '&') . $this->apiSecret;
        $signature = sha1($signString);

        $apiUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";

        $postFields = [
            'file'      => new \CURLFile($filePath),
            'api_key'   => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder'    => $folder,
        ];

        if (!empty($paramsToSign['public_id'])) {
            $postFields['public_id'] = $paramsToSign['public_id'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'url'     => null,
                'error'   => 'cURL error: ' . $curlError
            ];
        }

        $result = json_decode($response, true);

        if ($httpCode === 200 && !empty($result['secure_url'])) {
            return [
                'success'   => true,
                'url'       => $result['secure_url'],
                'public_id' => $result['public_id'] ?? null,
                'raw'       => $result,
            ];
        }

        $errMsg = $result['error']['message'] ?? 'Gagal upload ke Cloudinary (HTTP ' . $httpCode . ')';
        return [
            'success' => false,
            'url'     => null,
            'error'   => $errMsg,
            'raw'     => $result
        ];
    }

    /**
     * Extract public_id from a Cloudinary URL
     *
     * @param string $url
     * @return string|null
     */
    public function extractPublicId(string $url): ?string
    {
        if (empty($url) || !str_contains($url, 'res.cloudinary.com')) {
            return null;
        }

        // Example URL: https://res.cloudinary.com/demo/image/upload/v1234567890/cs_reports/sample_1234.jpg
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) return null;

        // Strip upload path prefix e.g. /image/upload/v1234567890/ or /image/upload/
        if (preg_match('#/image/upload/(?:v\d+/)?(.+?)(?:\.[a-zA-Z0-9]+)?$#', $path, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Delete an image from Cloudinary by public_id or full URL
     *
     * @param string $publicIdOrUrl
     * @return array [ 'success' => bool, 'result' => string|null, 'error' => string|null ]
     */
    public function delete(string $publicIdOrUrl): array
    {
        if (empty($this->cloudName) || empty($this->apiKey) || empty($this->apiSecret)) {
            return [
                'success' => false,
                'error'   => 'Kredensial Cloudinary belum lengkap.'
            ];
        }

        $publicId = $this->extractPublicId($publicIdOrUrl) ?: $publicIdOrUrl;

        $timestamp = time();
        $paramsToSign = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];

        ksort($paramsToSign);
        $signString = "public_id={$publicId}&timestamp={$timestamp}" . $this->apiSecret;
        $signature = sha1($signString);

        $apiUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy";

        $postFields = [
            'public_id' => $publicId,
            'api_key'   => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'error'   => 'cURL error: ' . $curlError
            ];
        }

        $result = json_decode($response, true);
        if ($httpCode === 200 && ($result['result'] ?? '') === 'ok') {
            return [
                'success' => true,
                'result'  => 'ok'
            ];
        }

        return [
            'success' => false,
            'result'  => $result['result'] ?? 'not_found',
            'error'   => $result['error']['message'] ?? 'Gagal menghapus file dari Cloudinary'
        ];
    }
}
