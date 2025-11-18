<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyService extends BaseService
{

    public function __construct()
{
    $this->model = Currency::class;
    parent::__construct();
}
    /**
     * new currency
     */
    public function create($data): Currency
    {
        $currency = new Currency($data);
        $currency->fill($data);
        $currency->save();
        return $currency;
    }

    /**
    * update exist currency
     */
    public function update($data, Currency|Model $currency): Currency
    {
        $currency->update($data);
        $currency->fill($data);
        return $currency;
    }
    /**
     * update publish status
     * */
    public function togglePublish(Currency|Model $currency, bool $status): Currency
    {
        $currency->publish = $status;
        $currency->save();
        return $currency;
    }

}
