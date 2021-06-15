<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniqueCodeRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;

class UniqueCodeController extends Controller
{
    public function index()
    {
        return view('unique-code');
    }

    public function generateUniqueCode(UniqueCodeRequest $request)
    {
        $uniqueCode = array();
        for ($i = 0; $i < $request->number; $i++) {
            $uniqueCode[]['unique_code'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 7);
        }

        return $this->sendToApi($uniqueCode);
    }

    private function sendToApi(array $uniqueCodes)
    {
        $server = config('app.unique_code_api_base_url');
        $request = config('app.unique_code_api_request_url');

        try {
            $client = new Client([
                'base_uri' => $server,
                'headers' => [
                    'Accept' => 'application/json'
                ],
            ]);

            $response = $client->post($request, [
                'json' => [
                    "unique_codes" => $uniqueCodes
                ],
            ]);

            return new JsonResponse(
                json_decode((string) $response->getBody()),
                $response->getStatusCode()
            );

        } catch (RequestException $requestException) {
            if ($requestException->hasResponse()) {
                return new JsonResponse(
                    json_decode((string) $requestException->getResponse()->getBody()),
                    $requestException->getCode()
                );
            } else {
                return new JsonResponse(
                    ["message" => $requestException->getMessage()],
                    503
                );
            }
        }
    }
}
