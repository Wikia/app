<?php

if (!defined("MEDIAWIKI")) die(1);

global $wgWidgets;
$wgWidgets["WidgetFounderBadge"] = array(
	"callback"  => "WidgetFounderBadge",
	"title"     => "widget-title-founderbadge",
	"desc"      => "widget-desc-founderbadge",
	"closeable" => false,
	"editable"  => false,
	"listable"  => false,
);

function WidgetFounderBadge($id, $params) {
	$output = "";

	wfProfileIn( __METHOD__ );

	global $wgMemc;
	$key = wfMemcKey("WidgetFounderBadge", "user");
	$user = $wgMemc->get($key);
	if (is_null($user)) {
		global $wgCityId;
		$user = WikiFactory::getWikiById($wgCityId)->city_founding_user;
		$wgMemc->set($key, $user, 3600);
	}

	if (0 == $user) return wfMsgForContent("widget-founderbadge-notavailable");

	$key = wfMemcKey("WidgetFounderBadge", "edits");
	$edits = $wgMemc->get($key);
	if (empty($edits)) {
		$edits = AttributionCache::getInstance()->getUserEditPoints($user);
		$wgMemc->set($key, $edits, 300);
	}

	$author = array(
		"user_id"   => $user,
		"user_name" =>  User::newFromId($user)->getName(),
		"edits"     => $edits,
	);

	$output = Answer::getUserBadge($author);

	wfProfileOut(__METHOD__);
	return $output;
}
