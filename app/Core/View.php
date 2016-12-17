<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/3/16
 * Time: 12:50 PM
 */

namespace Core;

class View
{
    protected $template;
    protected $data = [];

    //создаем основной шаблон
    public function __construct($template = 'main')
    {
            $this->template = $this->loadFile($template);
    }

    //формируем параметры (данные, подшаблоны)
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

     //формируем подшаблон с параметрами
    public function block($templateBlock, array $data = null)
    {
            if ($data !== null ) {
                extract($data, EXTR_SKIP);
            }
            ob_start();
            require $this->loadFile($templateBlock);
            $out = ob_get_contents();
             ob_end_clean();
            //return $out;
            $this->$templateBlock = $out;

    }

    //отображаем шаблон с параметрами
    public function render()
    {
        extract($this->data);
        require($this->template);
    }

    //проверяем наличие шаблона
    private function loadFile($file)
    {
        $path = ROOT.'/app/templates/'.$file.'.phtml';
        if (file_exists($path)) {
            return $path;
        } else {
            exit('File '.$path.' not found.');
        }

    }
}
