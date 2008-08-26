<?php
/**
 * @author Emil Podlaszewski <emil@wikia.com>
 * @author Inez Korczynski <inez@wikia.com>
 * @author Tomasz Klim <tomek@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWikiaToolbox'] = array(
	'callback' => 'WidgetWikiaToolbox',
	'title' => array(
		'en' => 'Toolbox'
	),
	'desc' => array(
		'en' => 'Toolbox'
    ),
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

function WidgetWikiaToolbox($id, $params) {
	if($params['skinname'] != 'quartz') {
		return '';
	}

	wfProfileIn( __METHOD__ );

	$id = "toolbox";  // skin integration; delete this

	$article_tools = array(	'permalink', 'whatlinkshere', 'recentchangeslinked', 'contributions', 'blockip', 'emailuser', 'rss', 'atom' );


	//$skin =& $this->getContext()->data['skin'];
	global $wgTitle;

	$provider =& DataProvider::singleton();
	$links =& $provider->GetExpertTools();  // TODO: rewrite and move to BaseExpertTools
	$widget_name = $provider->Translate( 'toolbox' );

	if ( $wgTitle->isTalkPage() ) {
	    $header = 'this_discussion';
	} else {
	    $header = str_replace( 'nstab-', 'this_', $wgTitle->getNamespaceKey() );
	    switch( $header ) {
	    	case 'this_main' :
			$header = 'this_article';
			break;
		case 'this_mediawiki' :
			$header = 'this_message';
			break;
	    }
	}

	$this_wiki_out_temp = $this_article_out_temp = '';
	$this_wiki_out_i = $this_article_out_i = 0;

	foreach( $links as $link ) {
		if( $link['id'] == 'createpage' ) {
			continue;
		}

		if( in_array( $link['id'], $article_tools ) ) {
			$this_article_out_temp .= "\n<li><a href=\"" . $link['url'] . "\" id=\"tb_" . $link['id'] . "\">" . $link['text'] . "</a></li>";
			$this_article_out_i++;
		} else {
			$this_wiki_out_temp .= "\n<li><a href=\"" . $link['url'] . "\" id=\"tb_" . $link['id'] . "\">" . $link['text'] . "</a></li>";
			$this_wiki_out_i++;
		}
	}

	$paddingBottom = 30;
	$buttonPaddingBottom = 12;

	/*
	 * user engagement
	 */
	$user_messages = "";
	if (!empty($GLOBALS['wgEnableSystemEvents']))
	{
		#---
		$userMessages =& $provider->GetUserEventMessages();
		#---
		$to_display = array();
		#---
		$loop = 0;
		$js_added = false;

		$user_messages = WikiaEventsConditions::displayMessage($userMessages);
		#---
		if ( !empty($user_messages) )
		{
			$paddingBottom = 75;
			$buttonPaddingBottom = 55;
		}
	}
	#----

	$this_article_out = "\n<div class=\"listLeft\" style='".( $this_article_out_i >= $this_wiki_out_i ? "margin-right: 10px; border-right: 1px solid #999999;" : "")."padding-bottom: {$paddingBottom}px;'>\n<h2>".strtolower(wfMsg( $header ))."</h2>";
	$this_wiki_out = "\n<div class=\"listRight\" style='".( $this_article_out_i < $this_wiki_out_i ? "padding-left: 10px; border-left: 1px solid #999999;" : "")."padding-bottom: {$paddingBottom}px;'>\n<h2>".wfMsg( 'this_wiki' )."</h2>";

	$this_article_out .= '<ul>'.$this_article_out_temp.'</ul>';
	$this_wiki_out .= '<ul>'.$this_wiki_out_temp.'</ul>';

	$this_article_out .= "\n<div style='display: none; position: absolute; bottom: {$buttonPaddingBottom}px;' class=\"gelButton addButton\"><a id=\"tb_new_article\" href=\"".Skin::makeSpecialUrl( 'Createpage' )."\">".wfMsg( 'new_article' )."</a></div>\n</div>";
	$this_wiki_out .= "\n<div style='position: absolute; bottom: {$buttonPaddingBottom}px;' class=\"gelButton addButton\"><a id=\"tb_new_wiki\" href=\"http://requests.wikia.com\">".wfMsg( 'new_wiki' )."</a></div>\n</div>";

	$body = "
    <li id=\"{$id}_wg\" class='widget WidgetWikiaToolbox'>
	<div id='{$id}' class='sidebar WidgetWikiaToolbox'>
	<h1 id='{$id}_header'>" . $widget_name . "</h1>
	<div id=\"{$id}_content\" class=\"widgetContent WidgetWikiaToolbox\">{$this_article_out}{$this_wiki_out}{$user_messages}</div>
    	<div style=\"clear: both;\"></div>
    </div></li>";

	wfProfileOut( __METHOD__ );

	return array('nowrap' => true, 'body' => $body);
}
