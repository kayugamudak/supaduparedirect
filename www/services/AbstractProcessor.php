<?php

namespace services;

use models\Lead;
use Psr\Log\LoggerInterface;

abstract class AbstractProcessor extends \Threaded
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function run()
    {
        do {
            $lead = null;

            $provider = $this->worker->getProvider();

            // Синхронизируем получение данных
            $provider->synchronized(function ($provider) use (&$lead) {
                $lead = $provider->getNext();
            }, $provider);

            if ($lead === null) {
                continue;
            }

            $this->processLead($lead);

        } while ($lead !== null);
    }

    /**
     * @param Lead $lead
     * @return bool
     * процессим лида, конкретные реализации оставим потомкам
     */
    abstract protected function processLead(Lead $lead): bool;
}