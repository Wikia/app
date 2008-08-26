<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetReferrers'] = array(
	'callback' => 'WidgetReferrers',
	'title' => array(
		'en' => 'Top referrers',
		'pl' => 'Strony odsyłające'
	),
	'desc' => array(
		'en' => 'A "cloud" of the sites that link to this wiki. Bigger text means more refers',
		'pl' => 'Chmura stron odsylajacych na ta Wikie'
    ),
    'params' => array(
		'wt_show_referrers' => array(
			'type' => 'select',
			'values' => array
			(
			    0 => wfMsg('wt_show_internal_urls'),
			    1 => wfMsg('wt_show_external_urls'),
			),
			'default' => 1
		),
		'limit' => array(
		    'type'    => 'select',
		    'values'  => array_slice(range(0, 30), 10, 21, true),
		    'default' => 25
		),
		'wt_show_period' => array(
		    'type'    => 'select',
		    'values'   => array(
		        date('Ymd', strtotime('-1 month')) => 'last month',
		        date('Ymd', strtotime('-3 month')) => 'last 3 months',
		        date('Ymd', strtotime('-6 month')) => 'last 6 months',
		    ),
		    'default' => date('Ymd', strtotime('-1 month'))
		),
	),
    
    'closeable' => true,
    'editable' => true,
);


function WidgetReferrers($id, $params) {

    wfProfileIn(__METHOD__);

	global $wgUser, $wgLang, $wgMemc, $wgCityId;
	
	$limit = (array_key_exists('limit', $params) && !empty($params['limit'])) ? $params['limit'] : 25;
	$wkuseext = (array_key_exists('wt_show_referrers', $params)) ? $params['wt_show_referrers'] : 1;
	$wkparamdate = $wkfromdate = (array_key_exists('wt_show_period', $params) && !empty($params['wt_show_period'])) ? $params['wt_show_period'] : "";
	if (!empty($wkfromdate)) {
	    $m = array(); if (preg_match('/^(20\d{2}|21\d{2})(0?[1-9]|1[0-2])(0?[1-9]|[12][0-9]|3[01])$/', $wkfromdate, $m)) {
	        $wkfromdate = $m[1]."-".$m[2]."-".$m[3];
        } else {
            unset($wkfromdate);
        }
    } else {
        unset($wkfromdate);
    }
	
	$memcKey = wfMemcKey('widgets:referers:cloud:'.$limit.':'.$wkuseext.':'.$wkparamdate);
	
	$cloud = $wgMemc->get($memcKey);
	
	if (is_string($cloud)) {
	//if ( false ) {
	    wfProfileOut(__METHOD__);
	    return '<!-- using memcache: yes ("'.$memcKey.'") -->'.$cloud;
	}
	
	wfProfileIn(__METHOD__.'::miss');
	
	// get last edits from API
	$api_param = array(
		'action'	=> 'query',
		'list'		=> 'wkreferer',
		
		// take per-wiki referrers stats
		'wkcity'        => $wgCityId,
		
		// get full hostnames
		'wkusefulldomain' => 1,
		'wkuseext'        => $wkuseext, // wikia hosts will be filtered out (wkuseext = 1 returns the same for different cities)...
		'wknodomain'      => 'Unneeded_referrers',
		'wklimit'         => $limit,
		'wkoffset'	      => 0,
		'wkfromdate'      => $wkfromdate,		
	);

	$results = WidgetFrameworkCallAPI($api_param);
	
	if (count($results['query']['wkreferer']) == 0) {
	    # show default link to wikia.com
	    $default = '<span title="www.wikia.com/1" class="widgetReferrersDomainTag" style="font-size:1em">';
	    $default .= '<a href="http://www.wikia.com">www.wikia.com</a></span>';

	    return '<div style="text-align:center">'.$default.'</div>';
	}
	
	$domains = array();
	
	// prevent showing the IP'like and "wikia.com" domain names
	foreach($results['query']['wkreferer'] as $domain) {
	    if ( !User::isIP($domain['domain']) && User::isIP(gethostbyname(trim($domain['domain']))) ) {
	        if ( ($wkuseext == 1) && strpos($domain['domain'], 'wikia.com') !== false ) {
	            continue;
            }
            $domains[ $domain['domain'] ] = $domain['count']; 
	    }
	}
	
	ksort($domains);
	
	//print_pre($wgCityId);print_pre($results);print_pre($domains);
	
	// sizing (high math - oh yes ;)
	$min = log(min($domains));
	$max = log(max($domains));
	
	$min_size = 1;
	$max_size = 3;
	
	$tags = array();
	
	// prepare cloud elements
	foreach($domains as $name => $count) {
	    $tags[$name] = array (
		// remove prefixes & suffixes from domain names
		'name'  =>  str_replace(array('.com', '.org', '.net', 'www.'), '', $name),
		'url'   => 'http://'.$name,
		'count' => number_format($count, 0, ',', ' '),
		'size'  => round($min_size + ((log($count) - $min) / $max) * ($max_size-$min_size), 3),
	    );
	}
	
	//print_pre($tags);
	
	$ret = '<!-- city: '.$wgCityId.' -->';
	
	foreach($tags as $tag) {
	    $ret .= '<span title="'.htmlspecialchars($tag['name']).' / '.$tag['count'].'" class="widgetReferrersDomainTag" style="font-size:'.$tag['size'].'em">'.
	            '<a href="'.$tag['url'].'">'.htmlspecialchars($tag['name']).'</a></span> ';
	}
	
	$cloud = '<div style="text-align:center">'.$ret.'</div>';
	
	$wgMemc->set($memcKey, $cloud, 7200); // store for 2h

	wfProfileOut(__METHOD__.'::miss');
	wfProfileOut(__METHOD__);
	
	return $cloud;
}

