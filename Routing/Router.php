<?php

namespace Routing;
use Cool\DBManager;

class Router
{
    public function execute($request)
    {
        global $config;
        if (preg_match($config['profile'], $request))
        {
            $data = explode(':', $config['routes']['profile']);
            $controller_name = "Controller\\".'UsersController';
            $method_name = 'userProfileAction';
            
            $controller = new $controller_name;
            $response = call_user_func([$controller, $method_name]);
            
            return $response;
        }
        else if (isset($config['routes'][$request]))
        {
            $data = explode(':', $config['routes'][$request]);
            $controller_name = "Controller\\".$data[0].'Controller';
            $method_name = $data[1].'Action';
            
            $controller = new $controller_name;
            $response = call_user_func([$controller, $method_name]);
            return $response;
        }
        else
        {
            header("HTTP/1.0 404 Not Found");
            http_response_code(404);
            $data = explode(':', $config['routes']['error404']);
            $controller_name = "Controller\\".'MainController';
            $method_name = 'error404Action';
            
            $controller = new $controller_name;
            $response = call_user_func([$controller, $method_name]);
            return $response;
        }
    }
}
