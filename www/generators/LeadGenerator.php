<?php

namespace generators;

use models\Lead;
use models\LeadCategory;

/**
 * Class LeadGenerator
 * @package generators
 */
class LeadGenerator
{

    /**
     * @param int $count
     * @return Lead[]
     */
    public function generateLeads(int $count): array
    {
        $leads = [];
        for($i = 1; $i <= $count; $i++) {
            $lead = new Lead();
            $lead->id = $i;
            $lead->categoryName = $this->getRandCategory();
            $leads[] = $lead;
        }
        return $leads;
    }

    /**
     * @return string
     */
    private function getRandCategory(): string
    {
        $categories = LeadCategory::$list;
        return $categories[array_rand($categories)];
    }
}