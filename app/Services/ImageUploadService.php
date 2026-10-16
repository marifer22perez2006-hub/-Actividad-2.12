<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageUploadService
{
    /**
     * Sube un archivo de imagen a una API externa de almacenamiento de imágenes.
     *
     * @param UploadedFile $file
     * @return string|null Retorna la URL pública proporcionada por la API externa o null si falla.
     */
    public static function upload(UploadedFile $file): ?string
    {
        try {
            $base64Image = base64_encode(file_get_contents($file->getRealPath()));
            $apiKey = env('IMGBB_API_KEY');

            // 1. Intentar con la API externa FreeImage.host
            $response = Http::asForm()
                ->withOptions(['verify' => false])
                ->timeout(20)
                ->post('https://freeimage.host/api/1/upload', [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $base64Image,
                    'format' => 'json'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['image']['url'])) {
                    return $data['image']['url'];
                }
            }

            // 2. Intentar con ImgBB API si se colocó una clave en .env
            if (!empty($apiKey) && $apiKey !== 'vuestra_clave_de_api_imgbb') {
                $imgbbResponse = Http::asForm()
                    ->withOptions(['verify' => false])
                    ->timeout(20)
                    ->post('https://api.imgbb.com/1/upload', [
                        'key' => $apiKey,
                        'image' => $base64Image,
                    ]);

                if ($imgbbResponse->successful()) {
                    $imgbbData = $imgbbResponse->json();
                    if (isset($imgbbData['data']['url'])) {
                        return $imgbbData['data']['url'];
                    }
                }
            }

            // 3. Respaldo adicional con la API ImgHippo
            $hippoResponse = Http::asMultipart()
                ->withOptions(['verify' => false])
                ->timeout(20)
                ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.imghippo.com/v1/upload', [
                    'api_key' => '3f03b2241cf1d244f77c3a0df470a7df'
                ]);

            if ($hippoResponse->successful()) {
                $hippoData = $hippoResponse->json();
                if (isset($hippoData['data']['url'])) {
                    return $hippoData['data']['url'];
                }
            }

            Log::error('Fallaron los intentos de subida en las APIs externas.');
            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al comunicarse con la API externa de imágenes: ' . $e->getMessage());
            return null;
        }
    }
}
