<?php

	/*
	 * Generate event emails and send them to a developer in a chosen language
	 * Email types: user-registered, anon-edit, general-edit, first-edit, lot-happening, views-digest, complete-digest
	 * Command = SERVER_ID=12345 php generate.php --email=me@wikia-inc.com --lang=de
	 * Command(dev) = SERVER_ID=79860 php generate.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php --email=me@wikia-inc.com --lang=th
	 */

	ini_set( "include_path", dirname( __FILE__ ) . "/../../../maintenance/" );

	require_once( "commandLine.inc" );

	$dir = dirname(__FILE__).'/';
	$wgAutoloadClasses['FounderEmailsModule'] = $dir . 'FounderEmailsModule.class.php';
	
	 // get options
	$long_opts = array("email:","lang:");
	$params = getopt("e:l:", $long_opts);

	if (!array_key_exists('email', $params))
		die("Invalid format. Format: SERVER_ID=12345 php generate.php --email=me@wikia-inc.com --lang=th\n");
	
	if (!User::isValidEmailAddr($params['email']))
		die("Invalid email address.\n");

	// set variables
	global $wgTitle, $wgCityId, $wgPasswordSender, $wgContLang;
	
	$params['name'] = strstr($params['email'], '@', TRUE);

	if (!array_key_exists('lang',$params) || empty($params['lang']))
		$params['language'] = 'en';
	else
		$params['language'] = $params['lang'];

	$wgTitle = Title::newMainPage();
	$wgContLang = wfGetLangObj($params['language']);
	if (!$wgCityId)
		$wgCityId = 177;
	$foundingWiki = WikiFactory::getWikiById($wgCityId);
	
	$emailParams = array(
						'$FOUNDERNAME' => $params['name'],
						'$WIKINAME' => $foundingWiki->city_sitename,
						'$WIKIURL' => $foundingWiki->city_url,
						'$UNIQUEVIEWS' => 789,	
						'$USERJOINS' => 456,
						'$USEREDITS' => 123,
						'$USERNAME' => 'Someone',
						'$PAGETITLE' => 'Main Page',
						'$PAGEURL' => 'http://www.wikia.com',
						'$USERTALKPAGEURL' => 'http://www.wikia.com',
						'$MYHOMEURL' => 'http://www.wikia.com',
					);
	
	$types = array('user-registered', 'anon-edit', 'general-edit', 'first-edit', 'lot-happening', 'views-digest', 'complete-digest');
	
	foreach($types as $type) {
		// get messages
		$params['type'] = $type;
		$mailBodyHTML = wfRenderModule("FounderEmails", "GeneralUpdate", array_merge($emailParams, $params));
		$mailBodyHTML = strtr($mailBodyHTML, $emailParams);
		
		// send email
		$to = new MailAddress($params['email'], $params['name'], $params['name']);
		$sender = new MailAddress($wgPasswordSender);
		$subject = 'Test for '.$type;
		UserMailer::sendHTML($to, $sender, $subject, '', $mailBodyHTML);
	}

?>
