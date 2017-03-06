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

	if (!class_exists('ActivityFeedHelper')) {
		return '';
	}
	wfProfileIn(__METHOD__);

	$parameters = ActivityFeedHelper::parseParameters($attributes);
	$feedHTML = ActivityFeedHelper::getList($parameters);

	$tag = Html::element( 'div', [ 'style' => getStyle( $parameters ) ], $feedHTML ) .
	       getSnippets( $parameters );
	wfProfileOut( __METHOD__ );

	return $tag;
}

function getStyle( $parameters ) {
	$style = empty($parameters['style']) ? '' : $parameters['style'];
	return sprintf(' style="%s"',  $style);
}

function getSnippets( &$parameters ) {
	global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;

	$jsParams = "size={$parameters['maxElements']}";
	if (!empty($parameters['includeNamespaces'])) $jsParams .= "&ns={$parameters['includeNamespaces']}";
	if (!empty($parameters['flags'])) $jsParams .= '&flags=' . implode('|', $parameters['flags']);

	$tagid = str_replace('.', '_', uniqid('activitytag_', true));	//jQuery might have a problem with . in ID
	$parameters['tagid'] = $tagid;

	$snippetsDependencies = array('/extensions/wikia/MyHome/ActivityFeedTag.js', '/extensions/wikia/MyHome/ActivityFeedTag.css');

	if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
		array_push($snippetsDependencies, '/extensions/wikia/AchievementsII/css/achievements_sidebar.css');
	}

	return JSSnippets::addToStack(
		$snippetsDependencies,
		null,
		'ActivityFeedTag.initActivityTag',
		array(
			'tagid' => $tagid,
			'jsParams' => $jsParams,
			'timestamp' => wfTimestampNow()
		)
	);

}
