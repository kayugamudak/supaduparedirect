<?php

namespace models;

/**
 * Class LeadCategory
 * @package models
 */
class LeadCategory
{
    static $list = [
        'Buy auto',
        'Buy house',
        'Get loan',
        'Cleaning',
        'Learning',
        'Car wash',
        'Repair smth',
        'Barbershop',
        'Pizza',
        'Car insurance',
        'Life insurance'
    ];

    private function __construct(){
        throw new \Exception("Can't get an instance of constants");
    }
}