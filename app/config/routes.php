<?php
/**
 * Created by PhpStorm.
 * User: sparrow
 * Date: 12/3/16
 * Time: 9:09 AM
 */

return [

    'category/([0-9]+)/page-([0-9]+)' => 'index/show/$1/$2',
    'page/([0-9]+)' => 'index/show/$1',
    '404' => 'index/404',
    '' => 'index/show',

];
