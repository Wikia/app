<?php
if (!defined('MEDIAWIKI')) die();

class LinkNewsChannel {
	static function ExtensionFeeds() {
		global $wgOut, $wgNewsChannelTitle;

		$title = Title::newFromText( 'NewsChannel', NS_SPECIAL );
		$wgOut->addLink( array(
			'rel' => 'alternate',
			'type' => 'application/rss+xml',
			'title' => $wgNewsChannelTitle . ' - RSS 2.0',
			'href' => $title->getLocalURL( 'format=rss20' ) ) );
		$wgOut->addLink( array(
			'rel' => 'alternate',
			'type' => 'application/atom+xml',
			'title' => $wgNewsChannelTitle . ' - Atom 1.0',
			'href' => $title->getLocalURL( 'format=atom10' ) ) );

		return true;
	}
}