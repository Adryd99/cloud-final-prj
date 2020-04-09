<?php

declare(strict_types=1);

namespace App\Middleware\Cookie;

use App\Middleware\IMiddleware;
use App\Middleware\AbsResponseMiddleware;
use Psr\Http\Message\ResponseInterface;
use App\Helper\CryptMsg;

class CookieMiddleware extends AbsResponseMiddleware implements IMiddleware{
    protected $crypt;
    const BODY_GET_COOKIE_PARAM = 'storage';
    protected $toEncrypt = ['token', 'user'];

    public function __construct(CryptMsg $crypt){
        $this->crypt = $crypt;
    }

    protected function middlewareAction (ResponseInterface $response) {
        $body = $response->getBody();
        return $response;      $body->getContents();
// var_dump($body->read(1024)); die();
 //       $json = json_decode($body->read(1024), true);
   

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            return $response;
        }
   
        if (isset($json[self::BODY_GET_COOKIE_PARAM])) {
            foreach($json[self::BODY_GET_COOKIE_PARAM] AS $name => $cookie) {
     /*         $response->withHeader(
                    'Set-Cookie',
                    sprintf(
                        '%s=$s; HttpOnly', 
                        $name, 
                        in_array($name, $this->toEncrypt) ? $this->crypt->encrypt($cookie, $this->crypt:: nonce()) : $cookie
                    )
                );
  */              //Set-Cookie: <cookie-name>=<cookie-value>; Domain=<domain-value>; Secure; HttpOnly
   /*             setcookie(
                    $name,
                    in_array($name, $this->toEncrypt) ? $this->crypt->encrypt($cookie, $this->crypt:: nonce()) : $cookie,
                    0,
                    '',
                    '',
                    false,
                    true
                );*/
            }
        }
// var_dump('cookie');
// var_dump($body->read(1024));
        return $response;
    }
}