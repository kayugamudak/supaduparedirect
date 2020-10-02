<?php

namespace dataProviders;

use models\Lead;
use generators\LeadGenerator;

/**
 * Class GeneratedLeadDataProvider
 * @package dataProviders
 */
class GeneratedLeadDataProvider extends \Threaded implements DataProvider
{
    /**
     * @var int Сколько лидов всего
     */
    private $total = 0;

    /**
     * @var int Сколько лидов было обработано
     */
    private $processed = 0;

    /**
     * @var Lead[]
     */
    private $data;

    public function __construct(int $count)
    {
        $this->data = $this->fetchData($count);
        $this->total = count($this->data);
    }

    /**
     * получаем данные из источника
     * @param int $count
     */
    protected function fetchData(int $count): ?array
    {
        $generator = new LeadGenerator();
        return $generator->generateLeads($count);
    }

    /**
     * Получаем лида для обработки
     * @return Lead|null
     */
    public function getNext(): ?Lead
    {
        if ($this->processed >= $this->total || empty($this->data)) {
            return null;
        }
        $lead = $this->data->shift();
        $this->processed++;

        return $lead;
    }
}
