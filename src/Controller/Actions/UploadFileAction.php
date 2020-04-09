<?php
declare(strict_types=1);

namespace App\Controller\Actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Helper\HashMsg;
use App\Api\Upload\UploadFileApi;
use App\Middleware\Api\ApiPostRequestMiddleware;
use App\Middleware\Api\Api2HtmlResponseMiddleware;
use App\Controller\AbsController;
use App\Middleware\InjectableMiddleware;

class UploadFileAction extends AbsController implements \App\Controller\IController {
    use \App\Controller\Traits\SetMessageTrait;

    protected $apiAction;

    public function __construct(
        UploadFileApi $apiAction, 
        ApiPostRequestMiddleware $apiRequestMiddleware,
        Api2HtmlResponseMiddleware $apiResponseMiddleware
    ) {
        $this->apiAction = $apiAction;

        $middlewares = [
            new InjectableMiddleware($apiRequestMiddleware),
            new InjectableMiddleware($apiResponseMiddleware,
                function($response) {
                    $this->handleResponse($response);
                }
            ),
        ];

        parent::__construct($middlewares);
    }


    protected function controllerResponse($request) {
        return $this->apiAction->execute($request);
    }


    protected function handleResponse($response) {
        $landing = 'photomanager';
        $this->setResultMessage($response);
        
        header(sprintf('Location: /%s', $landing));
        exit;
    }
}