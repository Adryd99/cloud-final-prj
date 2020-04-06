<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Middleware\IMiddleware;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbsRequestMiddleware implements IMiddleware{
    protected abstract function middlewareAction(ServerRequestInterface $request);

    public function handle($data, ?callable $next=null) {
        if (! is_null($next)) {
            $data = $next($data);
        }

        return $this->middlewareAction($data);
    }
}