<?php

namespace App\Http\Controllers;

use App\Custom\ResponseManager;
use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Exception;

class ShortenedUrlController extends Controller {
    private $location = "ShortenedUrlController.php";
    private $baseUrl = "http://localhost:8000/";

    public function addOne(Request $req) {
        try {

            $shortenedUrl = new ShortenedUrl();
            $shortenedUrl->original_url = $req->original_url;
            $shortenedUrl->shortened_url = "Temporary";
            $shortenedUrl->user_id = 1;

            if ($shortenedUrl->save()) {
                $shortenedUrl->shortened_url = $this->pathGenerator($shortenedUrl->id);
                $shortenedUrl->save();
                return response([
                    "status"    => true,
                    "url"       => $this->baseUrl . $shortenedUrl->shortened_url,
                    "message"   => 'Shortened URL created successfully',
                ], 200);
            } else {
                return response([
                    "status"    => false,
                    "message"   => 'Error creating Shortened URL',
                ], 500);
            }
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'addOne', true);
        }
    }

    public function redirect(Request $req) {
        try {
            $shortenedUrl = ShortenedUrl::where('shortened_url', $req->shortened_url)->first();
            if ($shortenedUrl) {
                return redirect()->away($shortenedUrl->original_url, 301);
            } else {
                return response([
                    "status"    => false,
                    "message"   => 'URL not found',
                ], 404);
            }
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'redirect', true);
        }
    }

    // FUNCIÓN PARA GENERAR EL PATH DE LA URL A PARTIR DEL ID
    private function pathGenerator($number) {
        #17576 ES LA CANTIDAD MÁXIMA POR LA COMBINACIÓN
        if ($number < 1 || $number > 17576) {
            return false;
        }

        $result = '';
        $number--;

        for ($i = 0; $i < 3; $i++) {
            $charIndex = $number % 26;
            $result = chr($charIndex + ord('a')) . $result;
            $number = floor($number / 26);
        }

        return base64_encode($result);
    }

    private function validateUrl($url) {
    }
}
