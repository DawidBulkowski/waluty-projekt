<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{

    const API_NBP = 'https://api.nbp.pl/api/exchangerates/tables/A/today/?format=json';

    public function index(CurrencyRepository $currencyRepository)
    {
        $currencies = $currencyRepository->getAll();
        return view('index', ['currencies' => $currencies]);
    }

    public function update(CurrencyRepository $currencyRepository)
    {
        $nbp_content = json_decode(file_get_contents($this::API_NBP));
        $currencies = $nbp_content ? $nbp_content[0]->rates : [];

        foreach ($currencies as $currency) {
            if($currencyRepository->getByCode($currency->code))
                $currencyRepository->update($currency->code, $currency->mid);
            else $currencyRepository->add($currency->currency, $currency->code, $currency->mid);
        }

        echo 'Update zakończony powodzeniem';
    }
}
