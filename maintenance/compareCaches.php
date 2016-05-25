<?php

// php compareCaches.php

error_reporting(E_ALL);
ini_set('display_errors','On');
define(MESSAGE_CACHE_DIR, './messageCache');

function checkLang($lang) {
    $s1 = unserialize(file_get_contents(MESSAGE_CACHE_DIR . '/messageCache-orig.dump.' . $lang . '.php'));
    $s2 = unserialize(file_get_contents(MESSAGE_CACHE_DIR . '/messageCache-new.dump.' . $lang . '.php'));

    $k1 = array_keys($s1);
    $k2 = array_keys($s2);
    $diff_details = [];

    if(count(array_diff($k1,$k2)) == 0) {
        echo $lang . ' has all the keys expected' . PHP_EOL;
        $diffs = 0;

        foreach(array_intersect($k1,$k2) as $key) {
            if($s1[$key] !== $s2[$key]) {
                $diffs++;

                $diff_details['DIFFERENCES'][$key] = [$s1[$key], $s2[$key]];
            }
        }

        echo $lang . ' has ' . $diffs . ' differing values' . PHP_EOL;
    } else {
        echo $lang . ' has ' . count(array_diff($k1,$k2)) . ' missing keys' . PHP_EOL;

        foreach ( array_diff($k1,$k2) as $key ) {
            $diff_details['MISSING-IN-NEW'][$key] = [$s1[$key], null];
        }
    }

    if(count(array_diff($k2,$k1)) == 0) {
        echo $lang . ' has no excess keys' . PHP_EOL;
    } else {
        echo $lang . ' has ' . count(array_diff($k2,$k1)) . ' excess keys' . PHP_EOL;

        foreach ( array_diff($k2,$k1) as $key ) {
            $diff_details['EXCESS-IN-NEW'][$key] = [null, $s2[$key]];
        }
    }

    // log differences

    $diff_content = [ $lang ];
    foreach ($diff_details as $section => $diff ) {
        $diff_content[] = '----------------------'. $section . ' [ ' . count($diff) . ' differences ]';
        foreach ($diff as $k => $part) {
            $diff_content[] = '<<<<<';
            $diff_content[] = '* ' . $k;
            if ( isset($part[0]) ) {
                $diff_content[] = '- ' . $part[0];
            }
            $diff_content[] = '----';
            if ( isset($part[1]) ) {
                $diff_content[] = '+ ' . $part[1];
            }
            $diff_content[] = '>>>>>' . PHP_EOL;
        }
    }

    file_put_contents ( MESSAGE_CACHE_DIR . '/diff.'.$lang.'.txt', join ( PHP_EOL, $diff_content ) );
}

$langCodes = [ 'en', 'pl', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'pt', 'ru', 'zh-hans', 'zh-tw' ];

foreach($langCodes as $code) {
    echo '========' . PHP_EOL;
    checkLang($code);
}

