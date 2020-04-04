<?php
declare(strict_types=1);

namespace App\Controller\Views;
use Psr\Http\Message\ServerRequestInterface;
use League\Plates\Engine;

class Register implements \App\Controller\IController {
    protected $plates;

    public function __construct(Engine $plates)
    {
        $this->plates  = $plates;
    }


    public function execute(ServerRequestInterface $request) :void {
        $cookies = $request->getCookieParams();
        $message = '';
        if (isset($cookies['message']))
        {
            $message = $cookies['message'];
        }

        echo $this->plates->render('register', [
           'message' => $message
        ]);
    }
}