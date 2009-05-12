<?php
/**
 * @author Nick Sullivan nick at wikia inc.com
 * @author Inez Korczynski <inez@wikia-inc.com>
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
    'listable' => true,
    'languages' => array( 'en' ), # only show in carousel on EN wikis
);


function WidgetAnswers($id, $params) {
    wfProfileIn(__METHOD__);

	// Hide widget if wiki content language is not english
	# TODO: should be handled directly in WidgetFramework, probably Draw/DrawOne method
	global $wgLanguageCode;
	if($wgLanguageCode != 'en')	{
		return '';
	}

	# TODO: explain what's going on here and make it production environment independent
	static $languageLoaded;
	if(empty($languageLoaded)) {
		$messages = array();
		$messages['en'] = array
        (
                'answer_title' => 'Answer',
                'ask_a_question' => 'Ask a question',
                'ask_button' => 'Ask',
                'ask_thanks' => 'Thanks for the rockin\' question!',
                'question_asked_by' => 'Question asked by',
                'new_question_comment' => 'new question',
                'answers_toolbox' => 'Wikianswers toolbox',
                'improve_this_answer' => 'Improve this answer',
                'answer_this_question' => 'Answer this question',
                'notify_improved' => 'Email me when improved',
                'research_this' => 'Research this',
                'notify_answered' => 'Email me when answered',
                'recent_asked_questions' => 'Recently Asked Questions',
                'recent_answered_questions' => 'Recently Answered Questions',
                'unanswered_category' => 'un-answered questions',
                'answered_category' => 'answered questions',
                'related_answered_questions' => 'Related answered questions',
                'recent_unanswered_questions' => 'Recent Unanswered Questions',
                'popular_categories' => 'Popular Categories',
                'createaccount-captcha' => 'Please type the word below',
                'inline-register-title' => 'Notify me when my question is answered!',
                'inline-welcome' => 'Welcome to Wikianswers',
                'skip_this' => 'Skip this',
                'see_all_changes' => 'See all changes',
                'toolbox_anon_message' => '<i>"Wikianswers leverages the unique characterstics of a wiki to form the very best answers to any question."</i><br /><br /> <b>Jimmy Wales</b><br /> founder of Wikipedia and Wikianswers',
                'no_questions_found' => 'No questions found',
                'widget_settings'       => 'Question Settings',
                'style_settings'        => 'Style Settings',
                'get_widget_title' => 'Add Questions to your site',
                'background_color' => 'Background color',
                'widget_category' => 'Type of Questions',
                'category' => 'Category Name',
                'custom_category' => 'Custom Category',
                'number_of_items' => 'Number of items to show',
                'width'         => 'Width',
                'next_page'             => 'Next &raquo;',
                'prev_page'             => '&laquo; Prev',
                'see_all'               => 'See all',
                'get_code'      => 'Grab Code',
                'link_color'    => 'Question Link Color',
                'widget_order' => 'Question Order',
                'widget_ask_box' => 'Include ask box',
                'question_redirected_help_page' => 'Why was my question redirected here',
                'twitter_hashtag' => 'wikianswers',
                'twitter_ask' => 'Ask on Twitter',
                'facebook_ask' => 'Ask on Facebook',
                'facebook_send_request' => 'Send Directly to Friends',
                'ask_friends' => 'Ask your friends to help answer:',
                'facebook_send_request_content' => 'Can you help answer this? $1',
                'facebook_signed_in' => 'You are signed into Facebook Connect',
                'ads_by_google' => 'Ads by Google',
                'research_wikipedia_title' => 'Research your answer on Wikipedia',
                'research_this' => 'Research this',
                'magic_answer_headline' => 'Does this answer your question?',
                'magic_answer_yes' => 'Yes, use this as a starting point',
                'magic_answer_no' => 'No, don\'t use this',
                'magic_answer_credit' => 'Provided by Yahoo Answers',
                'rephrase' => 'Rephrase this question',
                'question_not_answered' => 'This question has not been answered',
                'you_can' => 'You can:',
                'answer_this' => '<a href="$1">Answer this question</a>, even if you don\'t know the whole answer',
                'research_this_on_wikipedia' => '<a href="$1">Research this question</a> on Wikipedia',
                'receive_email' => '<a href="$1">Receive an email</a> when this question is answered',
                'ask_friends_on_twitter' => 'Ask Friends on <a href="$1">Twitter</a>',
                'quick_action_panel' => 'Quick Action Panel',
                'categorize' => 'Categorize',
                'categorize_help' => 'One category per line',
                'answers_widget_admin_note' => '<b>Admins:</b> If you\'d like to be an admin on <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin" target="_blank">click here</a>.',
                'answers_widget_user_note' => 'Can you help by becoming a <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category" target="_blank">category editor</a> on <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>?',
                'answers_widget_anon_note' => '<a href="http://answers.wikia.com" target="_blank">Wikianswers</a> is a Q&amp;A wiki where answers are improved, wiki-style.'
        );
		global $wgMessageCache;
		foreach( $messages as $lang => $message_array ) {
			$wgMessageCache->addMessages($message_array, $lang);
		}
		$languageLoaded = true;
	}

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
	$output .= '<script type="text/javascript">var WidgetAnswers_url = "'.$url.'"; if(typeof WidgetAnswers_ids == "undefined") var WidgetAnswers_ids = []; WidgetAnswers_ids.push('.$id.');</script>';

	if($wgUser->isLoggedIn()) {
		$output .= $askform;
	} else {
		$output .= '<div class="widget_answers_note">'.wfMsg('answers_widget_anon_note').'</div>';
	}

	wfProfileOut(__METHOD__);
	return $output;
}