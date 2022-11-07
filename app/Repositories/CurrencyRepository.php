<?php


namespace App\Repositories;


use App\Models\Currency;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CurrencyRepository
{
    public function __construct(Currency $model){
        $this->model = $model;
    }

    public function getAll(){
        return $this->model->orderBy("currency_code", 'desc')->get();
    }

    public function add($name, $code, $value) {
        $currency = new Currency();
        $currency->name = $name;
        $currency->currency_code = $code;
        $currency->exchange_rate = $value;
        $currency->save();
        return $code;
    }

    public function update($code, $value) {
        $currency = $this->getByCode($code);
        if($currency){
            $currency->exchange_rate = $value;
            $currency->save();
        }
    }

    public function getByCode($code) {
        return $this->model
            ->where('currency_code', $code)
            ->first();
    }

}
