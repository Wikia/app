<?php

// php compareCaches.php

error_reporting(E_ALL);
ini_set('display_errors','On');
define(MESSAGE_CACHE_DIR, './messageCache');

function checkLang($lang) {
    $s1 = unserialize(file_get_contents(MESSAGE_CACHE_DIR . '/messageCache-new.dump.' . $lang . '.php'));
    $s2 = unserialize(file_get_contents(MESSAGE_CACHE_DIR . '/messageCache-orig.dump.' . $lang . '.php'));

    $k1 = array_keys($s1);
    $k2 = array_keys($s2);

    if(count(array_diff($k1,$k2)) == 0) {
        echo $lang . ' has all the keys expected' . PHP_EOL;
        $diffs = 0;

        foreach(array_intersect($k1,$k2) as $key) {
            if($s1[$key] !== $s2[$key]) {
                $diffs++;
                # uncomment to see keys / differing values
                # print PHP_EOL . $key;
                # print PHP_EOL. PHP_EOL . $s1[$key] . PHP_EOL . ' vs ' . PHP_EOL . $s2[$key] . PHP_EOL . PHP_EOL;
            }
        }

        echo $lang . ' has ' . $diffs . ' differing values' . PHP_EOL;
    } else {
        echo $lang . ' has ' . count(array_diff($k1,$k2)) . ' missing keys' . PHP_EOL;
        if ( count($k2) > count($k1) ) {
            echo 'OLD is larger' . PHP_EOL;
        }
        if ( count($k1) > count($k2) ) {
            echo 'NEW is larger' . PHP_EOL;

            $a = [];

            foreach(array_diff($k1,$k2) as $k => $v) {
                $a[] = $v;
            }

            file_put_contents(MESSAGE_CACHE_DIR . '/diff.'.$lang.'.txt', implode(PHP_EOL, $a));
        }
    }

    if(count(array_diff($k2,$k1)) == 0) {
        echo $lang . ' has no excess keys' . PHP_EOL;
    } else {
        echo $lang . ' has ' . count(array_diff($k2,$k1)) . ' excess keys' . PHP_EOL;
        if ( count($k2) > count($k1) ) {
            echo 'OLD is larger' . PHP_EOL;
        }
        if ( count($k1) > count($k2) ) {
            echo 'NEW is larger' . PHP_EOL;
        }
    }
}

$langCodes = [ 'en', 'pl', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'pt', 'ru', 'zh-hans', 'zh-tw' ];

foreach($langCodes as $code) {
    echo '========' . PHP_EOL;
    checkLang($code);
}
