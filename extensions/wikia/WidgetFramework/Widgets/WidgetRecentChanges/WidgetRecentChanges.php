<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetRecentChanges'] = array(
	'callback' => 'WidgetRecentChanges',
	'title' => array(
		'en' => 'Recent changes',
		'pl' => 'Ostatnie zmiany'
	),
	'desc' => array(
		'en' => 'List of recent changes',
		'pl' => 'Lista ostatnich zmian'
    ),
	'params' => array(
		'limit' => array(
			'type' => 'text',
			'default' => 10
		),
		'hidebots' => array
		(
			'type' => 'checkbox',
			'default' => 1,
		),
	),
    'closeable' => true,
    'editable' => true,
);

function WidgetRecentChanges($id, $params) {
	wfProfileIn(__METHOD__);

    $limit = intval($params['limit']);
    $limit = ($limit <=0 || $limit > 50) ? 15 : $limit;

	$api_params = array
	(
		'action'  => 'query',
		'list'    => 'recentchanges',
		'rclimit' => $limit,
	);

	if (!empty($params['hidebots'])) {
		$api_params['rcshow'] = '!bot';
	}

    $res = WidgetFrameworkCallAPI($api_params);

    $ret = '<ul>';

    if(!empty($res) && is_array($res['query']['recentchanges'])) {
	    foreach ( $res['query']['recentchanges'] as $change ) {
		if ( $change['pageid'] > 0 ) {
		    $title = Title::newFromText( $change['title'], $change['ns'] );

			if ( is_object($title) ) {
		    		$display = htmlspecialchars( $change['title'] );
		    		$ret .= '<li><a href="' . $title->getLocalURL() . '" title="' . $display . '">' . $display . '</a>'.
					'<a class="WidgetRecentChangesDiffLink" href="'.htmlspecialchars($title->getLocalURL('diff='.$change['revid'])).'">diff</a></li>';
		
			}
		   }
	    }
    }
    
    $ret .= '</ul>';
    
    wfProfileOut( __METHOD__ );

    return $ret;
}
