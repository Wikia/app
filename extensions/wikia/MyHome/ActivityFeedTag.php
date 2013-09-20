<?php

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'ActivityFeedTag',
	'author' => array('Inez Korczyński', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'version' => '1.0',
	'description' => 'Provides wiki activity data'
);

$wgHooks['ParserFirstCallInit'][] = 'ActivityFeedTag_setup';

function ActivityFeedTag_setup(Parser $parser) {
	$parser->setHook('activityfeed', 'ActivityFeedTag_render');
	return true;
}

function ActivityFeedTag_render($content, $attributes, $parser, $frame) {
	global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;

	if (!class_exists('ActivityFeedHelper')) {
		return '';
	}
	wfProfileIn(__METHOD__);

	$parameters = ActivityFeedHelper::parseParameters($attributes);

	$tagid = str_replace('.', '_', uniqid('activitytag_', true));	//jQuery might have a problem with . in ID
	$jsParams = "size={$parameters['maxElements']}";
	if (!empty($parameters['includeNamespaces'])) $jsParams .= "&ns={$parameters['includeNamespaces']}";
	if (!empty($parameters['flags'])) $jsParams .= '&flags=' . implode('|', $parameters['flags']);
	$parameters['tagid'] = $tagid;

	$feedHTML = ActivityFeedHelper::getList($parameters);

	$style = empty($parameters['style']) ? '' : ' style="' . $parameters['style'] . '"';
	$timestamp = wfTimestampNow();

	$snippetsDependencies = array('/extensions/wikia/MyHome/ActivityFeedTag.js', '/extensions/wikia/MyHome/ActivityFeedTag.css');

	if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
		array_push($snippetsDependencies, '/extensions/wikia/AchievementsII/css/achievements_sidebar.css');
	}

	$snippets = JSSnippets::addToStack(
		$snippetsDependencies,
		null,
		'ActivityFeedTag.initActivityTag',
		array(
			'tagid' => $tagid,
			'jsParams' => $jsParams,
			'timestamp' => $timestamp
		)
	);

	wfProfileOut(__METHOD__);
	return "<div$style>$feedHTML</div>$snippets";
}
