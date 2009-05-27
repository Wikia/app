<?php
/**
 * @author Nick Sullivan nick at wikia inc.com
 * @author Inez Korczynski <inez@wikia-inc.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets, $wgAvailableAnswersLang;
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
    'listable' => true,
    'languages' => $wgAvailableAnswersLang,
);

function WidgetAnswers($id, $params) {
    wfProfileIn(__METHOD__);

	# TODO: should be handled directly in WidgetFramework, probably Draw/DrawOne method
	global $wgLanguageCode, $wgAvailableAnswersLang;
	if (!in_array($wgLanguageCode, $wgAvailableAnswersLang))	{
		return '';
	}

	global $wgExtensionMessagesFiles;
	if( empty( $wgExtensionMessagesFiles['Answers'] ) ) {
		global $IP;
		$wgExtensionMessagesFiles['Answers'] = "$IP/../answers/Answers.i18n.php";
	}
	wfLoadExtensionMessages( 'Answers' );

	global $wgSitename, $wgUser;

	// This HTML for the Ask a Question is used for both logged in and logged out users
	// but in different place - top or the bottom of the widget
	$ask_a_question = htmlspecialchars(wfMsg("ask_a_question"));
	$askform = <<<EOD
<form method="get" action="" onsubmit="return false" name="ask_form" class="ask_form">
	<input type="text" value="$ask_a_question" class="answers_ask_field"/>
</form>
EOD;

	if($wgUser->isLoggedIn()) {
		if(in_array('sysop', $wgUser->getGroups())) {
			$output = '<div class="widget_answers_note">'.wfMsg('answers_widget_admin_note').'</div>';
		} else {
			$output = '<div class="widget_answers_note">'.wfMsg('answers_widget_user_note').'</div>';
		}
	} else {
		$output = $askform;
	}

	$output .= '<div style="padding: 7px;"><b>'.wfMsg('recent_asked_questions').'</b><ul></ul></div>';

	$apiparams = array(
		'smaxage'=>300,
		'maxage'=> 300,
		'action'=> 'query',
		'list'=>'wkpagesincat',
		'wkcategory'=> wfMsg('unanswered_category') . '|' . $wgSitename,
		'format'=>'json',
		'wklimit'=>'5',
		'callback'=>'WidgetAnswers_load'
	);
	if($wgUser->getOption('language') != 'en') {
		$domain = $wgUser->getOption('language').'.';
	} else {
		$domain = '';
	}
	$url = 'http://'.$domain.'answers.wikia.com/api.php?'.http_build_query($apiparams);

	$output .= <<<EOD
<script type="text/javascript">
if(typeof WidgetAnswers_html == 'undefined') var WidgetAnswers_html = '';
var WidgetAnswers_url = '$url';
if(WidgetAnswers_html == '') {
	jQuery.getScript(WidgetAnswers_url, function() {
		if(WidgetAnswers_html != '') jQuery('#{$id}_content').children('div').children('ul').prepend(WidgetAnswers_html);
	});
} else jQuery('#{$id}_content').children('div').children('ul').prepend(WidgetAnswers_html);
</script>
EOD;

	if($wgUser->isLoggedIn()) {
		$output .= $askform;
	} else {
		$output .= '<div class="widget_answers_note">'.wfMsg('answers_widget_anon_note').'</div>';
	}

	wfProfileOut(__METHOD__);
	return $output;
}
