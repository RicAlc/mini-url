<?php

namespace App\Http\Controllers;

use App\Custom\ResponseManager;
use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Exception;

class ShortenedUrlController extends Controller {
    private $location = "ShortenedUrlController.php";
    private $baseUrl = "http://localhost:8000/";


    public function getAllByUser(Request $req) {
        try {
            $user = $req->user();
            $myUrls = ShortenedUrl::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            return response([
                "status"    => true,
                "data"      => $myUrls,
            ],);
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'getAllByUser', true);
        }
    }

    public function getOne(Request $req) {
        try {
            $shortenedUrl = ShortenedUrl::where('id', $req->id)->first();
            if ($shortenedUrl) {
                return response([
                    "status"    => true,
                    "data"      => $shortenedUrl,
                ], 200);
            } else {
                return response([
                    "status"    => false,
                    "message"   => 'Error getting Url',
                ], 500);
            }
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'getOne', true);
        }
    }

    public function addOne(Request $req) {
        try {
            $user = $req->user();
            //  Validación de parámetros
            $validation = $this->validateParams($req->only(
                'name',
                'original_url'
            ));
            if ($validation->fails()) return response([
                "message"   => "Parameter validation failed.",
                "errors"    => $validation->errors()
            ], 400);

            $shortenedUrl = new ShortenedUrl();
            $shortenedUrl->original_url = $req->original_url;
            $shortenedUrl->shortened_url = "Temporary";
            $shortenedUrl->name = $req->name;
            $shortenedUrl->user_id = $user->id;

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

    public function update(Request $req) {
        try {
            $shortenedUrl = ShortenedUrl::where('id', $req->id)->first();
            if ($shortenedUrl) {
                $shortenedUrl->name = $req->name;
                $shortenedUrl->original_url = $req->original_url;
                $shortenedUrl->save();
                return response([
                    "status"    => true,
                    "message"   => 'Url updated successfully',
                ], 200);
            } else {
                return response([
                    "status"    => false,
                    "message"   => 'Error updating Url',
                ], 500);
            }
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'update', true);
        }
    }

    public function delete(Request $req) {
        try {
            $shortenedUrl = ShortenedUrl::where('id', $req->id)->first();
            if ($shortenedUrl) {
                $shortenedUrl->delete();
                return response([
                    "status"    => true,
                    "message"   => 'Url deleted successfully',
                ], 200);
            } else {
                return response([
                    "params" => $req->all(),
                    "status"    => false,
                    "message"   => 'Error deleting Url',
                ], 500);
            }
        } catch (Exception $exception) {
            return ResponseManager::setErrorServerResponse($exception, $this->location, 'delete', true);
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

    private function validateParams($params) {
        $required = [
            'name'    => "required|string",
            'original_url'    => "required|string",
        ];

        return validator($params, $required, [
            'required'            => 'Field is required.',
            'min'                 => 'Field is required.',
            'numeric'             => 'Field must be numeric.',
            'string'              => 'Field must be string.',
        ]);
    }
}
