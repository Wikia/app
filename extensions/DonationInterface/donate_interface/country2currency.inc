<?php

function fnCountry2Currency($country = NULL) {
  
  switch ($country) {
            case 'CA':
                    return 'CAD';
            case 'US':
                    return 'USD';
            //euro countries
            case 'FR':
            case 'DE':
            case 'BE':
            case 'IE':
            case 'GR':
            case 'ES':
            case 'FR':
            case 'IT':
            case 'CY':
            case 'LU':
            case 'MT':
            case 'NL':
            case 'AT':
            case 'PT':
            case 'SI':
            case 'SK':
            case 'FI':
            case 'MC':
            case 'SM':
            case 'VA':
            case 'AD':
            case 'ME':
                    return 'EUR';
            case 'GB':
            case 'UK':
                    return 'GBP';
            case 'AU':
                    return 'AUD';
            case 'CH':
                    return 'CHF';
            case 'CZ':
                    return 'CZK'; 
            case 'DK':
                    return 'DKK';
            case 'HK':
                    return 'HKD';
            case 'HU':
                    return 'HUF';
            case 'JP':
                    return 'JPY';
            case 'NZ':
                    return 'NZD';
            case 'NO':
                    return 'NOK';
            case 'PL':
                    return 'PLN';
            case 'SG':
                    return 'SGD';
            case 'SE':
                    return 'SEK';
            case 'IL':
                    return 'ILS';                 
    }
    
    return 'USD';
}