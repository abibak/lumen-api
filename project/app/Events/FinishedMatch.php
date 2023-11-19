<?php

namespace App\Events;

class FinishedMatch
{
    public $lottery_match;
    public $match_id;
    public function __construct($lottery_match, $match_id)
    {
        $this->lottery_match = $lottery_match;
        $this->match_id = $match_id;
    }
}
