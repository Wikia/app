<?php

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'ActivityFeedTag',
	'author' => array('Inez Korczyński', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'version' => '1.0',
	'description' => 'Provides wiki activity data'
);

$wgHooks['ParserFirstCallInit'][] = 'ActivityFeedTag_setup';

function ActivityFeedTag_setup(&$parser) {
	$parser->setHook('activityfeed', 'ActivityFeedTag_render');
    return true;
}

function ActivityFeedTag_render($content, $attributes, &$parser) {
	global $wgOut, $wgStyleVersion, $wgExtensionsPath;

	if (!class_exists('ActivityFeedHelper')) {
		return '';
	}

	$parameters = ActivityFeedHelper::parseParameters($attributes);

	$tagid = str_replace('.', '_', uniqid('activitytag_', true));	//jQuery might have a problem with . in ID
	$jsParams = "size={$parameters['maxElements']}";
	if (!empty($parameters['includeNamespaces'])) $jsParams .= "&ns={$parameters['includeNamespaces']}";
	if (!empty($parameters['flags'])) $jsParams .= '&flags=' . implode('|', $parameters['flags']);
	$parameters['tagid'] = $tagid;

	wfLoadExtensionMessages('MyHome');
	$feedHTML = ActivityFeedHelper::getList($parameters);

	return $feedHTML . "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/MyHome/ActivityFeedTag.js?{$wgStyleVersion}\"></script><script>wgAfterContentAndJS.push(function() {ActivityFeedTag.initActivityTag('$tagid', '$jsParams');});</script><style type=\"text/css\">@import url({$wgExtensionsPath}/wikia/MyHome/ActivityFeedTag.css?{$wgStyleVersion});</style>";
}

