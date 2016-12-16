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
        $params = [];
        $params['temp'] = 'zarabotalo!';
        //передаем подшаблон и массив данных в основной шаблон
        $this->view->addTemplate(ROOT.'/app/templates/home.phtml', $params);
        $this->view->display();

    }
}
