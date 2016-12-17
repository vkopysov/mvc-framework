<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/3/16
 * Time: 7:07 AM
 */
namespace Controllers;

use Components\View;
use Core\Controller;

class IndexController extends Controller
{
    /**
     * @return View
     */
    public function actionShow()
    {
        echo 'indexController/actionShow';

        //создаем шаблон передаем параметры
        $this->view = new \Core\View('main');
        //передаем параметры
        $this->view->up = "This is main template";
        $this->view->down = "This is again main template";

        //формируем параметры для подшаблона
        $params ['first']= 'This ';
        $params ['second']= ' is ';
        $params ['third']= ' subtemplate!';
        //создаем подшаблон
        $this->view->block('home', $params);
        //отображаем результат
        $this->view->render();
    }
}
