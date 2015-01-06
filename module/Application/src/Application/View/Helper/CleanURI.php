<?php

namespace Application\View\Helper;

use \Zend\View\Helper\AbstractHelper;

setlocale(LC_ALL, 'pt_BR.UTF8');

class CleanURI extends AbstractHelper
{

    public function __invoke($url)
    {
        return $this->clean($url);
    }

    public static function clean($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }

}
