<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetLanguages'] = array(
	'callback' => 'WidgetLanguages',
	'title' => array(
		'en' => 'Languages',
		'pl' => 'Wersje językowe'
	),
	'desc' => array(
		'en' => 'Languages'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

function WidgetLanguages($id, $params) {
    wfProfileIn( __METHOD__ );
    global $wgUser,$wgContLang, $wgLanguageCode;
    $skin = $wgUser->getSkin();
    $out = '';
    if(isset($skin->language_urls)) {
    	$language = $wgContLang->getLanguageName($wgLanguageCode);
		$out = '<select onchange="WidgetLanguagesHandleRedirect(this);"><option value="0">'.$language.'</option>';
		if(is_array($skin->language_urls)) {
			foreach($skin->language_urls as $key => $val) {
				$out .= '<option value="'.htmlspecialchars($val['href']).'">'.$val['text'].'</option>';
			}
		}
		$out .= '</select>';
    }
    wfProfileOut(__METHOD__);
    return $out;
}
