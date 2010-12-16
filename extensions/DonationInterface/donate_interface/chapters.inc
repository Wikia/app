<?php

function fnDonateGetChapter($country = NULL) {
  
  switch ($country) {
          
            case 'AR':
                    return 'www.wikimedia.org.ar';
            case 'AU':
                    return 'www.wikimedia.org.au';
            case 'AT':
                    return 'www.wikimedia.at';
            case 'BR':
                    return 'www.wikimedia.org.br';
            case 'CZ':
                    return 'www.wikimedia.cz';
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
    
    return NULL;
    
    //http://wikimediafoundation.org/wiki/Local_chapters
}