<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'A/B testing',
	'author' => 'Inez Korczynski'
);

// This is the default expiration time for cookie set by getABtest function. AB test should takes no
// longer then 60 days, otherwise after 60 days user can get different version of test then had before
$wgABexpirationTime = 60*60*24*60;

$wgABtests = array();

/* CONFIGURATION - BEGIN */

// This is configuration of example test
// 10% of user will get version 1st (getABtest return 0)
// 30% of user will get version 2nd (getABtest return 1)
// 60% of user will get version 3rd (getABtest return 2)
$wgABtests['exampleTest'] = array('variants' => array(1, 3, 6));

/* CONFIGURATION - END */

function getABtest($name) {
	global $wgABtests;

	if(empty($wgABtests[$name])) {
		return 0;
	}

	if(!isset($wgABtests[$name]['variant'])) {
		global $wgRequest;

		// try to read AB test mode from web request parameters
		if(null == ($wgABtests[$name]['variant'] = $wgRequest->getIntOrNull('ab'.$name))) {

			// if AB mode cookie is not set then randomize it
			// using probability from configuration and save in cookie
			if(!isset($_COOKIE['ab'.$name])) {

				global $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgABexpirationTime;
				$limit = array_sum($wgABtests[$name]['variants']);
				$number = rand(1, $limit);
				$j = 0;
				for($i = 0; $i < count($wgABtests[$name]['variants']); $i++) {
					if($number <= $wgABtests[$name]['variants'][$i] + $j) {
						$wgABtests[$name]['variant'] = $i;
						break;
					}
					$j += $wgABtests[$name]['variants'][$i];
				}
				$exp = time()+$wgABexpirationTime; // 60 days
				setcookie('ab'.$name, $wgABtests[$name]['variant'], $exp, $wgCookiePath, $wgCookieDomain, $wgCookieSecure);
			} else {
				$wgABtests[$name]['variant'] = (int) $_COOKIE['ab'.$name];
			}
		}
	}
	return $wgABtests[$name]['variant'];
}