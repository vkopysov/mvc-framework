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
    public function __construct($template = ROOT.'/app/templates/main.phtml')
    {
        if (file_exists($template)) {
            $this->template = $template;
        } else {
            exit('File ' . $template . ' not exists.');
        }
    }

    //установливаем параметры (данные, подшаблоны)
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    //подгружаем подшаблон в параметры
    function addTemplate($subTemplate, $params){
       $this->data[] = $this->block($subTemplate, $params);
      // var_dump( $this->data );
    }

    //формируем подшаблон
    private function block($templateBlock, array $data = null)
    {
        var_dump($data);
        if (file_exists($templateBlock)) {
            if ($data !== null) {
                extract($data, EXTR_SKIP);
            }
            ob_start();
            require $templateBlock;
            $out = ob_get_contents();
             ob_end_clean();
            return $out;
        } else {
            return 'File ' . $templateBlock . ' not exists.';
        }
    }

    //подключаем итог
    public function display()
    {   var_dump($this->data);
        extract($this->data);
        require($this->template);
    }
}
