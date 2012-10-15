set _my_datetime=%date%_%time% 
set _my_datetime=%_my_datetime: =_% 
set _my_datetime=%_my_datetime::=% 
set _my_datetime=%_my_datetime:/=_% 
set _my_datetime=%_my_datetime:.=_% 

Start pybot --variable DELAY:80 --variable LongDelay:100 --variable BROWSER:*iexplore --variable wbLang:nl --variable wbURL:http://www.wikibhasha.org/wikibhasha/install.htm -d reports\%_my_datetime% "wbTestCasesIE"


