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

class IndexController extends \Core\AbstractController
{
    /**
     * @return View
     */
    public function actionShow()
    {
        echo 'indexController/actionShow';

        //Пример использования View

        $this->loadView('test', [
            'fruit1' => 'apelsin',
            'fruit2' => 'banan'
        ]);

        $this->loadBlock('subtemplate', [
            'first' => 'This ',
            'second' => ' is ',
            'third' => ' subtemplate'
        ]);

        $this->display();
    }
    public function action404()
    {
        echo '404 nor found';
    }
}
