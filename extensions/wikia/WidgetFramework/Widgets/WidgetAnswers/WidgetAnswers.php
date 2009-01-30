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
		'en' => 'Wikia Answers'
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

	// HTML for the Ask a Question 
	$h = '
	<style type="text/css">
	</style>
		<div id="answers_ask">
			<form method="get" action="" onsubmit="return false" name="ask_form" id="ask_form">
				<input type="text" id="answers_ask_field" value="Ask a question" class="alt" /><span>?</span>
				<a href="javascript:void(0);" id="ask_button" class="huge_button green"><div></div>Ask</a>
			</form>
		</div>';
	
	$h .= '<b>Recent Questions</b>';
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

	$apiparams = array(
		'smaxage'=>300,
		'maxage'=> 300,
		'action'=> 'query',
		'list'=>'wkpagesincat',
		'wkcategory'=> 'un-answered questions',
		'format'=>'json',
		'wklimit'=>'5'
	);
	$url = '/varnish_answer_redirect.php?' . http_build_query($apiparams);

	$h .= '<script>
jQuery("#recent_unanswered_questions").ready(function() {
	
	url = "'. $url .'";
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse);
		if( j.query.wkpagesincat ){
			html = "";
			for( recent_q in j.query.wkpagesincat ){
				page = j.query.wkpagesincat[recent_q];
				html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>";
			}
			jQuery("#recent_unanswered_questions").prepend( html );
		}
		
	});
});
	</script>
	<noscript><A href="http://answers.wikia.com">Get your questions answered on answers.wikia.com</a></noscript>';


    wfProfileOut( __METHOD__ );
    
    return $h;
}
