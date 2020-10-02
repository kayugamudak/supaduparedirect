<?php

require __DIR__ . '/vendor/autoload.php';

use services\LeadService;
use dataProviders\GeneratedLeadDataProvider;
use services\Logger;
use services\LeadProcessor;

if (!extension_loaded("pthreads")) {
    throw new Exception('Install pthreads module');
}

$config = require __DIR__ . '/config/common.php';

$threadsCount = $config['threads_count'];

$leadsCount = 10000;

//Выбираем dataProvider. Мы генерим лидов вручную, но тут может быть любой провайдер, например, который получает данные из бд.
$dataProvider = new GeneratedLeadDataProvider($leadsCount);

//Создаем логгер
$logger = new Logger($config['log_file']);

//Вперёд и с песней
$leadService = new LeadService($dataProvider, LeadProcessor::class, $leadsCount, $threadsCount, $logger);
$leadService->processLeads();
