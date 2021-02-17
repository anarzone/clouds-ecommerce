<?php


namespace App\Repositories;


use App\Models\Products\Currency;

class CurrencyRepository extends BaseRepository
{
    public function __construct(Currency $currency)
    {
        parent::__construct($currency);
    }
}
