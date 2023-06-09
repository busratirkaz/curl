<!DOCTYPE html>
<html>
<head>
    <title>Döviz Kuru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .result {
            margin-top: 20px;
            text-align: center;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Döviz Kuru</h1>
        <?php
        function getExchangeRate($fromCurrency, $toCurrency) {
            $url = "https://www.tcmb.gov.tr/kurlar/today.xml";

            $xml = simplexml_load_file($url);

            $currencyCodes = $xml->Currency;

            $fromRate = 1;
            $toRate = 1;

            foreach ($currencyCodes as $currency) {
                if ($currency->attributes()->Kod == $fromCurrency) {
                    $fromRate = str_replace(",", ".", $currency->BanknoteBuying);
                }
                if ($currency->attributes()->Kod == $toCurrency) {
                    $toRate = str_replace(",", ".", $currency->BanknoteSelling);
                }
            }

            $rate = $toRate / $fromRate;

            return $rate;
        }

        $fromCurrency = 'TRY'; // Dönüştürülecek para birimi
        $toCurrency = 'USD'; // Hedef para birimi

        $exchangeRate = getExchangeRate($fromCurrency, $toCurrency);

        if ($exchangeRate) {
            echo "<div class=\"result\">1 {$fromCurrency} = {$exchangeRate} {$toCurrency}</div>";
        } else {
            echo "<div class=\"result\">Döviz kuru alınamadı.</div>";
        }
        ?>
    </div>
</body>
</html>
