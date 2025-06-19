<?php
namespace App\Lib\Router;

use Exception;
require dirname(__DIR__,3).'/config/routes.php';
class Router {
    private $routes;
    private $availablePaths;
    private $requestedPath;

    public function __construct() {
        $this->routes = ROUTES;
        $this->availablePaths=array_keys($this->routes);
        $this->requestedPath=isset($_GET["path"]) ? $_GET['path'] : "/";
        $this->parseRoutes();
    }

    private function parseRoutes() {
        $explodedRequestedPath=$this->explodePath($this->requestedPath);
        $params=[];
        foreach($this->availablePaths as $candidatePath) {
            $foundMatch=true;
            $explodedCandidatePath=$this->explodePath($candidatePath);
            if (count($explodedCandidatePath)== count($explodedRequestedPath)) {
                foreach ($explodedRequestedPath as $key => $requestedPathPart) {
                    
                    $candidatePathPart = $explodedCandidatePath[$key];
					if ($this->isParam($candidatePathPart)) {
						$params[substr($candidatePathPart, 1, -1)] = $requestedPathPart;
					}
                    else if ($candidatePathPart !== $requestedPathPart) {
                        $foundMatch = false;
                        break;
                    }
                }
                if ($foundMatch) {
                    $route = $this->routes[$candidatePath];
                    break;
                }
            }
        }

        if (isset($route)) {
            $controller = new $route['controller'];
            $controller->{$route['method']}(...$params);
            return null;
        }
        return $this->setError404();
    }

    private function explodePath(string $path) {
        return explode('/',rtrim(ltrim($path,'/'),'/'));
    }
    private function isParam(string $candidatePathPart) {
        return str_contains($candidatePathPart, '{') && str_contains($candidatePathPart, '}');
    }

    private function setError404() {
        require_once dirname(__DIR__,2).'/Views/errors/404.php';
        exit;
    }
}