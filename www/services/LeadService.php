<?php

namespace services;

use dataProviders\DataProvider;
use Psr\Log\LoggerInterface;
use services\LeadProcessor;
use workers\LeadWorker;

class LeadService
{
    private $dataProvider;
    private $leadProcessor;
    private $count;
    private $leadWorker = LeadWorker::class;
    private $threads;
    private $logger;

    public function __construct(
        DataProvider $dataProvider,
        $leadProcessor,
        int $count,
        int $threads,
        LoggerInterface $logger
        )
    {
        $this->dataProvider = $dataProvider;
        $this->leadProcessor = $leadProcessor;
        $this->count = $count;
        $this->threads = $threads;
        $this->logger = $logger;
    }

    public function processLeads()
    {
        // Выбираем dataProvider. Мы генерим лидов вручную, но тут может быть любой провайдер, например, который получает данные из бд.
        $dataProvider = new $this->dataProvider($this->count);

        // Создадим пул воркеров
        $pool = new \Pool($this->threads, $this->leadWorker, [$dataProvider]);

        //собственно, параллелим
        for ($i = 0; $i < $this->threads; $i++) {
            $pool->submit(new $this->leadProcessor($this->logger));
        }

        $pool->shutdown();
    }
}
