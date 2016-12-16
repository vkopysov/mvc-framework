<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/3/16
 * Time: 8:36 AM
 */

namespace Components;

class Router
{
    // Хранит конфигурацию маршрутов.
    private $routes;

    public function __construct()
    {
        // Получаем конфигурацию из файла.
        $routesPath = ROOT.'/app/config/routes.php';
        $this->routes = include($routesPath);
    }

    // Метод получает URI. Несколько вариантов представлены для надёжности.
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        if (!empty($_SERVER['PATH_INFO'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }

        if (!empty($_SERVER['QUERY_STRING'])) {
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }

    public function run()
    {
        // Получаем URI.
        $uri = $this->getURI();
        // Пытаемся применить к нему правила из конфигуации.
        foreach ($this->routes as $pattern => $routeArray) {
            // Если правило совпало.
            if (preg_match("~$pattern~", $uri)) {
                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$pattern~", $routeArray['route'], $uri);
                // Разбиваем внутренний путь на сегменты.
                $segments = explode('/', $internalRoute);
                // Первый сегмент — контроллер.
                $controller = ucfirst(array_shift($segments)).'Controller';
                $controller = $routeArray['namespace'].'\\'.$controller;
                // Второй — действие.
                $action = 'action'.ucfirst(array_shift($segments));
                // Остальные сегменты — параметры.
                $params = $segments;

                //создаем объект класса
                $controllerObject = new $controller;

                // Вызываем действие контроллера с параметрами
                $res = call_user_func_array(array($controllerObject, $action), $params);
                if ($res != null) {
                    break;
                }
            }
        }
    }
}
