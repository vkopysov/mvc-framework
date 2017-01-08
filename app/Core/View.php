<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/3/16
 * Time: 12:50 PM
 */

namespace Core;

/**
 * Class View
 * Формирует шаблоны и подшаблоны представления
 * @package Core
 */
class View
{
    /**
     * @var string view  шаблоны оформления
     */
    protected $template;
    /**
     * @var array данные из контроллера
     */
    protected $data = [];

    /**
     * Создание основного шаблона страницы, Передаем темплейт и массив данных
     * View constructor.
     * @param string $template
     */
    public function __construct($template = 'main', array $data = null)
    {
        $this->template = $this->loadFile($template);
        if ($data !== null) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * Метод динамического создания параметров (данных и подшаблонов)
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Метод для создания подшаблона в основном шаблоне
     * Подшаблон хранится как элемент массива data
     * @param $templateBlock
     * @param array|null $data
     */
    public function block($templateBlock, array $data = null)
    {
        if ($data !== null) {
            extract($data, EXTR_SKIP);
        }
        ob_start();
        require $this->loadFile($templateBlock);
        $out = ob_get_contents();
        ob_end_clean();
        //return $out;
        $this->$templateBlock = $out;
    }

    /**
     * Подключение шаблона с параметрами и подшаблонами (если есть)
     */
    public function render()
    {
        extract($this->data);
        require($this->template);
    }

    /**
     * Проверка наличия файла шаблона
     * @param $file
     * @return string
     */
    private function loadFile($file)
    {
        $path = ROOT.'/app/templates/'.$file.'.phtml';
        if (file_exists($path)) {
            return $path;
        } else {
            exit('File '.$path.' not found.');
           // throw new \Exception("'Template file '.$path.' not found.'")
        }
    }
}
