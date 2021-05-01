<?php

namespace App\Facades\Header;

use App\Facades\Http\Router\Route;

class Header
{
    public static function set(): void
    {
        header('Content-Type: text/html; charset=utf-8');
        header('X-Frame-Options: sameorigin');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Referrer-Policy: no-referrer');
        
        if (app('security.enabled')) {
	        header('Content-Security-Policy: '.app('security.protection'));
        }
	
	    header('Access-Control-Allow-Origin: '.Route::checkProtocol().'://'.getenv('HTTP_HOST'));
	    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
        header('Strict-Transport-Security: max-age=31536000');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('X-Permitted-Cross-Domain-Policies: none');
    }
}
