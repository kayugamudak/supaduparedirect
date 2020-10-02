<?php

namespace workers;

use dataProviders\DataProvider;

/**
 * Class LeadWorker
 * @package workers
 * Используется чтоб расшарить dataProvider между потоками
 */
class LeadWorker extends \Worker implements IWorker
{
    private $provider;

    /**
     * @param DataProvider $provider
     */
    public function __construct(DataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Вызывается при отправке в Pool.
     */
    public function run()
    {
        // делать ничего не надо
    }

    /**
     * Возвращает провайдера
     * @return DataProvider
     */
    public function getProvider(): DataProvider
    {
        return $this->provider;
    }
}