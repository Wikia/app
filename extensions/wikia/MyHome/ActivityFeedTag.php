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
	$tagid = str_replace('.', '_', uniqid('activitytag_', true));	//jQuery might have a problem with . in ID
	$parameters['tagid'] = $tagid;

	$content = ActivityFeedHelper::getList( $parameters );
	$attributes = getAttributes( $parameters );

	wfProfileOut( __METHOD__ );

	return Html::rawElement( 'div', $attributes, $content ) . getSnippets( $parameters );
}

function getAttributes( $parameters ) {
	$attribs = [
		'id' => $parameters['tagid']
	];

	if ( !empty( $parameters['style'] ) ) {
		$attribs['style'] = $parameters['style'];
	}

	return $attribs;
}

function getSnippets( &$parameters ) {
	global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;

	$jsParams = "size={$parameters['maxElements']}";
	if (!empty($parameters['includeNamespaces'])) $jsParams .= "&ns={$parameters['includeNamespaces']}";
	if (!empty($parameters['flags'])) $jsParams .= '&flags=' . implode('|', $parameters['flags']);

	$snippetsDependencies = array('/extensions/wikia/MyHome/ActivityFeedTag.js', '/extensions/wikia/MyHome/ActivityFeedTag.css');

	if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
		array_push($snippetsDependencies, '/extensions/wikia/AchievementsII/css/achievements_sidebar.css');
	}

	return JSSnippets::addToStack(
		$snippetsDependencies,
		null,
		'ActivityFeedTag.initActivityTag',
		array(
			'tagid' => $parameters['tagid'],
			'jsParams' => $jsParams,
			'timestamp' => wfTimestampNow()
		)
	);

}
