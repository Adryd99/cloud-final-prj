<?php
declare(strict_types=1);

namespace App\Controller\Actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Helper\HashMsg;
use App\Api\Upload\ShareImageApi;
use App\Middleware\Api\ApiPostRequestMiddleware;
use App\Middleware\Api\Api2HtmlResponseMiddleware;
use App\Middleware\Auth\NeedsAuthMiddleware;
use App\Controller\AbsController;
use App\Middleware\InjectableMiddleware;

class ShareImageAction extends AbsController implements \App\Controller\IController {
    use \App\Traits\SetMessageTrait;
    use \App\Traits\GetCookieTrait;

    protected $apiAction;

    public function __construct(
        ShareImageApi $apiAction, 
        NeedsAuthMiddleware $auth,
        ApiPostRequestMiddleware $apiRequestMiddleware,
        Api2HtmlResponseMiddleware $apiResponseMiddleware
    ) {
        $this->apiAction = $apiAction;

        $middlewares = [
            new InjectableMiddleware($auth),
            new InjectableMiddleware($apiRequestMiddleware,
                function($request) {
                    return $this->handleRequest($request);
                }
            ),
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

    /**
     * adds fields for user to current request body (needed to store userId on Image collection)
     */
    protected function handleRequest($request) {
        $cookies = $this->getCookies($request);
        $postParams = $request->getParsedBody();
        $postParams['user'] = $cookies['user'];

        return $request->withParsedBody($postParams);
    }


    protected function handleResponse($response) {
        $this->setResultMessage($response);
        $filename = (string) $response->getHeaderLine('Referer');
        $landing = sprintf('photodetails/%s', str_replace('.', '%20', $filename));
        
        header(sprintf('Location: /%s', $landing));
        exit;
    }
}