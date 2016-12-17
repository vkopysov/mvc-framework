<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/17/16
 * Time: 2:32 PM
 */

namespace Core;


class Application
{
    protected $router;

    public function __construct()
    {
        // создаем объект маршрутизатора
        $this->router = new \Components\Router();
        $this->router->run();

    }

}