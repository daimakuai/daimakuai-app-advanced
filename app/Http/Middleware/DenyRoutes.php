<?php

namespace App\Http\Middleware;


use Symfony\Component\HttpFoundation\Request;
use Jblv\Admin\Auth\Permission;

class DenyRoutes
{
    protected $denyDeleteMethod = true;

    protected $routes = [
        'post' => [
            'demo/media/upload',
            'demo/helpers/terminal/database',
            'demo/helpers/terminal/artisan',
            'demo/helpers/scaffold',
        ],
        'delete' => [
            'demo/media/delete',

        ],
        'put' => [

        ],
    ];

    public function handle(Request $request, \Closure $next)
    {
        if ($this->denyDeleteMethod && $request->isMethod('delete')) {
            Permission::error();
        }

        foreach ($this->routes as $method => $route) {
            if ($request->isMethod($method) && $request->is(...$route)) {
                Permission::error();
            }
        }

        return $next($request);
    }
}