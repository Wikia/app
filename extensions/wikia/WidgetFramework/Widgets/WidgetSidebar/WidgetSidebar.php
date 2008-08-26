<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetSidebar'] = array(
	'callback' => 'WidgetSidebar',
	'title' => array(
		'en' => 'Sidebar'
	),
	'desc' => array(
		'en' => 'Sidebar'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

function WidgetSidebar($id, $params) {
	if($params['skinname'] != 'quartz') {
		return '';
	}
    wfProfileIn( __METHOD__ );

    $sidebars = GetLinksArrayFromMessage('quartzsidebar');

    if(!is_array($sidebars) || count($sidebars) == 0) {
	$sidebars = GetLinksArrayFromMessage('sidebar');
    }

    $out = '';
    $i = 0;

    $sd_title = '';

    foreach($sidebars as $key => $val) {

	$sectionTemp = WidgetSidebarGetLinksHtml($val);

	if ( ! empty ( $sectionTemp ) ) {
	    $_out = wfMsg ($key);
	    if (!wfEmptyMsg( $key, $_out)) {
		$key = $_out;
	    }
	    if ( empty ($sd_title) ) {
		$sd_title = $key;
	    } else {
		$out .= '<h1 style="clear: both; padding-top: 5px;">'.$key.'</h1>';
	    }
	    $out .= $sectionTemp;
	}
    }

    wfProfileOut( __METHOD__ );

    return array('body' => $out, 'title' => $sd_title);
}


function WidgetSidebarGetLinksHtml($links) {

    wfProfileIn( __METHOD__ );
    $linksCount = count( $links );

    if ( $linksCount > 0 ) {

	$part1 = round( $linksCount / 2 );
	$part2 = $linksCount - $part1;

	$out = '<ul class="listLeft">';

	for ( $i = 0; $i < $part1; $i++ ) {
    	    $out .= '<li><a href=" '.htmlspecialchars($links[$i]['href']).'" id="'.$links[$i]['id'].'">'.htmlspecialchars($links[$i]['text'] ).'</a></li>';
	}

	$out .= '</ul><ul class="listRight">';

	for ( $i = $part1; $i < $linksCount; $i++ ) {
	    $out .= '<li><a href=" '.htmlspecialchars($links[$i]['href']).'" id="'.$links[$i]['id'].'">'.htmlspecialchars($links[$i]['text'] ).'</a></li>';
	}

	$out .= '</ul>';

	wfProfileOut( __METHOD__ );
	return $out;
    } else {
    	wfProfileOut( __METHOD__ );
	return null;
    }
}
