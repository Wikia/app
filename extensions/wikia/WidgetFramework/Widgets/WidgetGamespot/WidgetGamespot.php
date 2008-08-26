<?php
/**
 * @author Przemek Piotrowski
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetGamespot'] = array(
	'callback' => 'WidgetGamespot',
	'title' => array(
		'en' => 'Gamespot updates'
	),
	'desc' => array(
		'en' => 'Info feed from Gamespot'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

define('WIDGET_ADVERTISER_NO_OF_STORIES', 5);
define('WIDGET_ADVERTISER_CACHE_PERIOD', 324000); // 90 mins.

function WidgetGamespot($id, $params) {

    global $wgShowGamespotWidget;
    
    if (!$wgShowGamespotWidget) {
	return '';
    }

    wfProfileIn(__METHOD__);
    $more = '';

    global $wgPartnerWikiData;
    if (!empty($wgPartnerWikiData['feed-more'])) {
	$more = $wgPartnerWikiData['feed-more'];
    }

    $tmpl = new EasyTemplate(dirname( __FILE__ ));
    $tmpl->set_vars( array( 'data' => WidgetGamespotGetData(), 'more' => $more, 'id' => $id ) );
    $output = $tmpl->execute('gamespot_list_quartz');

    wfProfileOut(__METHOD__);

    // 'nowrap': ask widget framework not to add wrapping HTML    
    return array('nowrap' => true, 'body' => $output);
}




function WidgetGamespotGetData() {

    global $wgMemc, $wgPartnerWikiName;

    wfProfileIn(__METHOD__);

    $data = array();
    
    $key  =  wfMemcKey('widget:gamespot:feed', $wgPartnerWikiName);
    
    $data = $wgMemc->get($key);

    wfDebug( 'Gamespot widget: from cache: ' . print_r($data, true) . "\n" );
    
    if (empty($data)) {
	
	global $wgPartnerWikiData;
	if (!empty($wgPartnerWikiData['feed'])) {
		$url = $wgPartnerWikiData['feed'];

		$data = Http::get($url);

		$data = WidgetGamespotParseGamespotFeed($data);
		wfDebug( 'Gamespot Widget: parsed feed: ' . print_r($data, true) . "\n" );
	}

	$wgMemc->add($key, $data, WIDGET_ADVERTISER_CACHE_PERIOD);
	
    }

    wfProfileOut(__METHOD__);
    return $data;
}

function WidgetGamespotParseGamespotFeed($feed) {
		wfProfileIn(__METHOD__);

		$allowed_tags = array('headline', 'deck', 'gs_story_link', 'post_date', 'story_id');

		$data = array();
		if (preg_match_all('/<story>(.+)<\/story>/sU', $feed, $preg, PREG_SET_ORDER))
		{
			foreach ($preg as $match)
			{
				$row = array();
				if (preg_match_all('/<([^\/][^>]+)>([^<]+)<\/([^>]+)>/sU', $match[1], $preg2, PREG_SET_ORDER))
				{
					foreach ($preg2 as $match2)
					{
						if (($match2[1] == $match2[3]) && in_array($match2[1], $allowed_tags))
						{
							$value = $match2[2];
							$value = str_replace(array('&lt;', '&gt;', '&amp;'), array('<', '>', '&'), $value);
							$value = strip_tags($value);

							$row[$match2[1]] = $value;
						}
					}
				}

				$data[] = $row;
			}
		}

		$data = array_slice($data, 0, WIDGET_ADVERTISER_NO_OF_STORIES);

		wfProfileOut(__METHOD__);
		return $data;
}
