<?php

	/*
	 * Generate event emails and send them to a developer in a chosen language
	 * Email types: user-registered, anon-edit, general-edit, first-edit, lot-happening, views-digest, complete-digest
	 * Command = SERVER_ID=12345 php generate.php --email=me@wikia-inc.com --lang=de
	 */

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );

	$dir = dirname(__FILE__).'/';
	$wgAutoloadClasses['FounderEmailsController'] = $dir . 'FounderEmailsController.class.php';

	 // get options
	$long_opts = array("email:","lang:");
	$params = getopt("e:l:", $long_opts);

	if (!array_key_exists('email', $params))
		die("Invalid format. Format: SERVER_ID=12345 php generate.php --email=me@wikia-inc.com --lang=th\n");

	if (!Sanitizer::validateEmail($params['email']))
		die("Invalid email address.\n");

	// set variables
	global $wgTitle, $wgCityId, $wgPasswordSender, $wgContLang, $wgEnableAnswers;

	$params['name'] = strstr($params['email'], '@', TRUE);

	if (!array_key_exists('lang',$params) || empty($params['lang']))
		$params['language'] = 'en';
	else
		$params['language'] = $params['lang'];

	$wgTitle = Title::newMainPage();
	$wgContLang = wfGetLangObj($params['language']);
	$city_id = ($wgCityId) ? $wgCityId : 177;
	$foundingWiki = WikiFactory::getWikiById($city_id);
	$wikiType = (!empty($wgEnableAnswers)) ? '-answers' : '' ;

	$emailParams = array(
						'$USERNAME' => $params['name'],
						'$WIKINAME' => $foundingWiki->city_title,
						'$WIKIURL' => $foundingWiki->city_url,
						'$UNIQUEVIEWS' => 789,
						'$USERJOINS' => 456,
						'$USEREDITS' => 123,
						'$EDITORNAME' => 'Someone',
						'$EDITORURL' => 'http://www.wikia.com',
						'$PAGETITLE' => 'Main Page',
						'$PAGEURL' => 'http://www.wikia.com',
						'$EDITORTALKPAGEURL' => 'http://www.wikia.com',
						'$MYHOMEURL' => 'http://www.wikia.com',
						'$ADDAPAGEURL' => 'http://www.wikia.com',
						'$ADDAPHOTOURL' => 'http://www.wikia.com',
						'$CUSTOMIZETHEMEURL' => 'http://www.wikia.com',
						'$EDITMAINPAGEURL' => 'http://www.wikia.com',
						'$EXPLOREURL' => 'http://www.wikia.com',
						'$WIKIMAINPAGEURL' => 'http://www.wikia.com',
						'$USERPAGEEDITURL' => 'http://www.wikia.com',
					);

	$content_types = array('html', 'text');
	$types = array('user-registered', 'anon-edit', 'general-edit', 'first-edit', 'lot-happening', 'views-digest', 'complete-digest','DayZero','DayThree','DayTen');
	$days_passed_events = array('DayZero','DayThree','DayTen');

	$to = new MailAddress($params['email'], $params['name'], $params['name']);
	$sender = new MailAddress($wgPasswordSender);

	foreach($content_types as $content_type) {
		foreach($types as $type) {
			// get messages
			$params['type'] = $type;
			$html_template = 'GeneralUpdate';
			switch($params['type']) {
				case 'user-registered':
					$msg_key_subj = 'founderemails'.$wikiType.'-email-user-registered-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-user-registered-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-user-registered-body-HTML';
					break;
				case 'anon-edit' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-page-edited-anon-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-page-edited-anon-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-page-edited-anon-body-HTML';
					break;
				case 'general-edit' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-page-edited-reg-user-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-page-edited-reg-user-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-page-edited-reg-user-body-HTML';
					break;
				case 'first-edit' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-page-edited-reg-user-first-edit-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-page-edited-reg-user-first-edit-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-page-edited-reg-user-first-edit-body-HTML';
					break;
				case 'lot-happening' :
					$msg_key_subj = 'founderemails-lot-happening-subject';
					$msg_key_body = 'founderemails-lot-happening-body';
					$msg_key_body_html = 'founderemails-lot-happening-body-HTML';
					break;
				case 'views-digest' :
					$msg_key_subj = 'founderemails-email-views-digest-subject';
					$msg_key_body = 'founderemails-email-views-digest-body';
					$msg_key_body_html = '';
					break;
				case 'complete-digest' :
					$msg_key_subj = 'founderemails-email-complete-digest-subject';
					$msg_key_body = 'founderemails-email-complete-digest-body';
					$msg_key_body_html = '';
					break;
				case 'DayZero' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-0-days-passed-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-0-days-passed-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-0-days-passed-body-HTML';
					$html_template = 'DayZero';
					break;
				case 'DayThree' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-3-days-passed-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-3-days-passed-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-3-days-passed-body-HTML';
					$html_template = 'DayThree';
					break;
				case 'DayTen' :
					$msg_key_subj = 'founderemails'.$wikiType.'-email-10-days-passed-subject';
					$msg_key_body = 'founderemails'.$wikiType.'-email-10-days-passed-body';
					$msg_key_body_html = 'founderemails'.$wikiType.'-email-10-days-passed-body-HTML';
					$html_template = 'DayTen';
					break;
			}

			$mailBody = $mailBodyHTML = '';
			// send email
			$subject = "Founder Email Test for $params[type] ($params[language]/$content_type): ";
			$subject .= strtr(wfMsgExt($msg_key_subj, array('content')), $emailParams);
			if ($content_type=='html') {
				if ($params['language'] == 'en' && empty($wgEnableAnswers) || empty($msg_key_body_html)) { // FounderEmailv2.1
					$links = array(
								'$WIKINAME' => $emailParams['$WIKIURL'],
								'$EDITORNAME' => $emailParams['$EDITORURL'],
								'$PAGETITLE' => $emailParams['$PAGEURL'],
							);
					$emailParams_new = FounderEmails::addLink($emailParams, $links);
					$emailParams_new['$HDWIKINAME'] = str_replace('#2C85D5', '#fa5c1f', $emailParams_new['$WIKINAME']);	// header color = #fa5c1f
					$mailBodyHTML = F::app()->renderView("FounderEmails", $html_template, array_merge($emailParams_new, $params));
					$mailBodyHTML = strtr($mailBodyHTML, $emailParams_new);
				} else {	// old emails
					$mailBodyHTML = strtr(wfMsgExt($msg_key_body_html, array('content', 'parseinline')), $emailParams);
				}
			} else {
				if($params['type']=='views-digest') {
					$mailBody = strtr(wfMsgExt($msg_key_body, array('content','parsemag'), $emailParams['$UNIQUEVIEWS']), $emailParams);
				} else if ($params['type']=='complete-digest') {
					$mailBody = strtr(wfMsgExt($msg_key_body, array('content','parsemag'), $emailParams['$UNIQUEVIEWS'], $emailParams['$USEREDITS'], $emailParams['$USERJOINS']), $emailParams);
				} else {
					$mailBody = strtr(wfMsgExt($msg_key_body, array('content')), $emailParams);
				}
			}

			$body = array( 'text' => $mailBody, 'html' => $mailBodyHTML );
			UserMailer::send( $to, $sender, $subject, $body );
		}
	}

