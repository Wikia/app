<?php
/**
 * @author Maciej Brencz
 * @author Inez Korczyński <inez@wikia.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetTopContent'] = array(
	'callback' => 'WidgetTopContent',
	'title' => array(
		'en' => 'Top content',
		'pl' => 'Najlepsze na wiki'
	),
	'desc' => array(
		'en' => 'Four widgets in one: Most Popular, Most Visited, Newly Changed, Highest Ratings.',
		'pl' => '4 w 1: Najpopularniejsze, Najczęściej odwiedzane, Ostatnie zmiany, Najwyżej ocenianie'
    ),
    'params' => array (
	'at' => array(
	    'type'    => 'text',
	    'default' => 'most_visited'
	    ),
    ),
    'closeable' => true,
    'editable' => false,
);


function WidgetTopContent($id, $params) {

    wfProfileIn(__METHOD__);
    
    // select active section
    $active = $params['at'];
    list ($sections, $default) = WidgetTopContentGetSectionsList();
    if (!array_key_exists($active, $sections)) {
        $active = $default;
    }
    
    // ...and get its content
    $section = WidgetTopContentGetSection($active, $sections[$active]);
    
    // select box
    $provider = & DataProvider::singleton();
    
	// don't show select box when being rendered by WidgetTag
	if ( !isset($params['_widgetTag']) ) {
		$out_selector = '<select onchange="WidgetTopContentSwitchSection(this);" id="'.$id.'-select">';
		$out_sections = '';
		foreach ( $sections as $key => $val ) {
			$out_selector .= '<option value="'. $key .'"'.($key == $active ? ' selected="selected"' : '').'>' . $provider->Translate( $key ) . '</option>';
		}
		$out_selector .= '</select>';
	}
	else {
		$out_selector = '';
	}
    
    // more link
    $more = Title::makeTitle( NS_SPECIAL, 'Top' )->getLocalURL().'/'.$active;
    
    wfProfileOut(__METHOD__);
    
    return array( 'body' => $section . $out_selector . WidgetFrameworkMoreLink($more) );
}

// AJAX support for dynamic change of widget "tabs"
function WidgetTopContentGetSection($id, $functionName) {

	wfProfileIn(__METHOD__);

	// get list from DataProvider
	$provider = & DataProvider::singleton();
	$articles =& $provider->$functionName();
    
	// make items list    
	$items = array();
    
	if ( is_array($articles) && count($articles) > 0 ) {
		foreach ($articles as $article) {
			if ($article['text'] != 'Not a valid Wikia') {
				$items[] = array( 'href' => $article['url'], 'name' => $article['text'] );
			}
		}
	}
    
	wfProfileOut(__METHOD__);

	return WidgetFrameworkWrapLinks($items);
}

// get list of sections
function WidgetTopContentGetSectionsList() {

    wfProfileIn(__METHOD__);

    $provider = & DataProvider::singleton();
    list( $links, $active ) = $provider->GetTopFiveArray();
    unset($links['community']);
    
    wfProfileOut(__METHOD__);
    
    return array(0 => $links,1 => $active);
}

