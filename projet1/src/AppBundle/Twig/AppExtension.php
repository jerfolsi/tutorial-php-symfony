<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('myupper', array($this, 'upperCase')),
        );
    }

    public function upperCase($string)
    {
        return strtoupper($string);
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ' ')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price . '€';

        return $price;
    }

    public function getName()
    {
        return 'app_extension';
    }
}