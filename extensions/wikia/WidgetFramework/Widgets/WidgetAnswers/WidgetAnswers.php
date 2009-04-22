<?php
/**
 * @author Nick Sullivan nick at wikia inc.com
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetAnswers'] = array(
	'callback' => 'WidgetAnswers',
	'title' => array(
		'en' => ''
	),
	'desc' => array(
		'en' => 'See a list of top un answered questions'
    ),
    'closeable' => true,
    'editable' => false,
    'listable' => true
);


function WidgetAnswers($id, $params) {

    wfProfileIn(__METHOD__);

	static $languageLoaded;
	if (empty($languageLoaded)){
		include ( "/usr/wikia/source/answers/Answers.i18n.php" );
		global $wgMessageCache;
		foreach( $messages as $lang => $message_array ){
			$wgMessageCache->addMessages( $message_array, $lang );
		}
		$languageLoaded = true;
	}

	global $wgUser;
	
	// HTML for the Ask a Question 
	$askform = '<form method="get" action="" onsubmit="return false" name="ask_form" id="ask_form">
			<input type="text" id="answers_ask_field" value="' . htmlspecialchars(wfMsg("ask_a_question")) . '" class="alt" />
		</form>';
	
	$h = ''; //html output

	if ( $wgUser->isLoggedIn() ) {
		if ( in_array( 'sysop', $wgUser->getGroups() ) ) {
			$h .= '<div class="widget_answers_note">'. wfMsg( "answers_widget_admin_note" ). '</div>';
		} else {
			$h .= '<div class="widget_answers_note">'. wfMsg( "answers_widget_user_note" ). '</div>';
		}
	} else {
		$h .= $askform;
	}
	
	$h .= '<div style="padding: 7px;">';
	$h .= '<b>' . wfMsg("recent_asked_questions") . '</b>';
	$h .= '<ul id="recent_unanswered_questions"></ul>';
	/* Note that varnish_answer_redirect is a proxy to work around cross domain limitations
	/* In a Apache environment you can use ProxyPass
	*
	    <Proxy *>
	    Order deny,allow
	    Deny from all
	    Allow from yournet
	    </Proxy>
	    ProxyRequests On
	    ProxyPass       /varnish_answer_redirect.php  http://answers.wikia.com/api.php
	*/

	global $wgSitename, $wgUser;
	$apiparams = array(
		'smaxage'=>300,
		'maxage'=> 300,
		'action'=> 'query',
		'list'=>'wkpagesincat',
		'wkcategory'=> wfMsg("unanswered_category") . '|' . $wgSitename,
		'format'=>'json',
		'wklimit'=>'5'
	);
	$domain = "";
	if( $wgUser->getOption("language") != "en" ){
		$domain = $wgUser->getOption("language") . ".";
	}
	
	$url = 'http://' . $domain . 'answers.wikia.com/api.php?' . http_build_query($apiparams);

	$h .= '<script>
jQuery("#recent_unanswered_questions").ready(function() {
	
	url = "'. $url .'";
	jQuery.get( url, "", function( j ){
		//eval("j=" + oResponse);
		if( j.query.wkpagesincat ){
			html = "";
			for( var recent_q in j.query.wkpagesincat ){
				var page = j.query.wkpagesincat[recent_q];
				var text = page.title.replace(/_/g," ") + "?";
				if (text.length > 100){
					text = text.substring(0,100) + "...";
				}
				html += "<li><a href=\"" + page.url + "\" target=\"_blank\">" + text + "</a></li>";
			}
			jQuery("#recent_unanswered_questions").prepend( html );
		}
		
	},"jsonp");
});
	</script>
	<noscript><A href="http://answers.wikia.com">Get your questions answered on answers.wikia.com</a></noscript>';
	$h .= '</div>';

	if ( $wgUser->isLoggedIn() ) {
		$h .= $askform;
	} else {
		$h .= '<div class="widget_answers_note">'. wfMsg( "answers_widget_anon_note" ). '</div>';
	}

    wfProfileOut( __METHOD__ );
    
    return $h;
}
