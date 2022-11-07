@foreach($currencies as $currency)
<p><b>{{ $currency->name }}</b> ({{ $currency->currency_code }}) - wartość: {{ $currency->exchange_rate }}</p>
@endforeach
