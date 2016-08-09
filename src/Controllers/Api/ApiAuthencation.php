<?php

namespace Controllers\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiAuthencation
{

    public function authenticate(Request $request)
    {
        if ($this->checkUrlSegment($request->server->get('REQUEST_URI'))) {
            $apiKey = $request->headers->get('apiKey');
            $apiSecret = $request->headers->get('apiSecret');
            if (empty($apiKey) || empty($apiSecret)) {
                return new JsonResponse(array(
                    'message' => 'you do not have permission to access the API',
                    'data' => ''
                        ), 402);
            }
            if ($apiKey !== API_KEY || $apiSecret !== API_SECRET) {
                return new JsonResponse(array(
                    'message' => 'you do not have permission to access the API',
                    'data' => ''
                        ), 402);
            }

            if ($request->headers->get('content-type') !== 'application/x-www-form-urlencoded') {
                return new JsonResponse(array(
                    'message' => 'request header content type must be: application/x-www-form-urlencoded',
                    'data' => ''
                        ), 500);
            }
        }
    }

    private function checkUrlSegment($url)
    {
        if (strpos($url, 'api') == true) {
            return true;
        }
        return false;
    }
}
