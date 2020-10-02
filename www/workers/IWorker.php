<?php

namespace workers;

use dataProviders\DataProvider;

interface IWorker
{
    public function __construct(DataProvider $provider);

    public function run();

    public function getProvider(): DataProvider;
}