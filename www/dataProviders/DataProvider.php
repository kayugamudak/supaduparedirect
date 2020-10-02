<?php

namespace dataProviders;

use models\Lead;

/**
 * Interface DataProvider
 * @package dataProviders
 */
interface DataProvider
{
    public function getNext(): ?Lead;
}