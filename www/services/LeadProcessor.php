<?php

namespace services;

use models\Lead;

/**
 * Class LeadProcessor
 * @package services
 * Собственно, сама нагрузка, которую мы распараллеливаем, тот самый handler. Реализация сейчас одна, по мере расхождения логики обработки разных лидов
 * сначала эволюционирует в фабричный метод, затем в абстрактную фабрику, а выбирать фабрику мы будем при помощи стратегии.
 */
class LeadProcessor extends AbstractProcessor
{

    /**
     * Не уверен, стоит ли каким-то образом "фиксировать" поломку определенной категории,
     * или нужно ограничить количество потоков на каждую, или еще как-то балансировать неравномерно запросы.
     * Допустим, мы в каком-то месте всё-таки понимаем, что категория "отвалилась"
     * и потом в другой момент времени поймём, что она "ожила", так что пока просто воткнём такую заглушку.
     */
    private $brokenCategory = 'Barbershop';

    /**
     * @param Lead $lead
     * @return bool
     * Сама задача, ради которой мы всё это затеяли
     */
    protected function processLead(Lead $lead): bool
    {
        $logData = [
            $lead->id,
            $lead->categoryName,
            date('Y-m-d H:i:s'),
        ];
        if ($lead->categoryName === $this->brokenCategory)
        {
            $this->logger->log('error', implode(' | ', $logData));
        } else {
            /*
             * Нагрузку считаем только на "рабочих" категориях. Наверное, в реальных условиях нужно на упавшее апи понижать приоритет,
             * т.е. балансировать очередь так, чтобы попытки отработать по отвалившейся категории шли максимум в 1 поток, а лучше с интервалами.
             */
            sleep(2);
            $this->logger->log('info', implode(' | ', $logData));
        }
        return true;
    }

}