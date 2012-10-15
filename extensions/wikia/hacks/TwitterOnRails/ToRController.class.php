<?php

class ToRController extends WikiaController {
	const DEFAULT_TWEETS_LIMIT = 5;
	const DEFAULT_REFRESH_INTERVAL = 5;

	public function executeIndex() {
		$this->keywords = wfMsg( 'tor-module-default-keywords' );
		$this->limit = self::DEFAULT_TWEETS_LIMIT;
		$this->refreshInterval = self::DEFAULT_REFRESH_INTERVAL;
	}

	public function onGetRailModuleList( &$railModuleList ) {
		$jsMimeType = $this->app->getGlobal('wgJsMimeType');
		$extensionsPath = $this->app->getGlobal('wgExtensionsPath');
		$styleVersion = $this->app->getGlobal('wgStyleVersion');
		$out = $this->app->getGlobal('wgOut');

		$out->addScript( "<script type=\"{$jsMimeType}\" src=\"{$extensionsPath}/wikia/hacks/TwitterOnRails/js/jquery.tweet.js?{$styleVersion}\"></script>\n" );
		$out->addStyle( "{$extensionsPath}/wikia/hacks/TwitterOnRails/css/ToR.css?{$styleVersion}" );

		$railModuleList[1333] = array( 'ToR', 'Index', null );
		return true;
	}

	public function onParserFirstCallInit( &$parser ) {
		$parser->setHook( 'twitteronrails', 'ToRController::twitterOnRailsParserHook' );
		return true;
	}

	/**
	 * parser hook for <twitteronrails> tag
	 * @return string tag body
	 */
	public static function twitterOnRailsParserHook( $input, $args, $parser ) {
		$keywords = wfMsg( 'tor-module-default-keywords' );
		$limit = self::DEFAULT_TWEETS_LIMIT;
		$refreshInterval = self::DEFAULT_REFRESH_INTERVAL;

		if( !empty( $args['keywords'] ) ) {
			$keywords = $args['keywords'];
		}
		if( !empty( $args['limit'] ) ) {
			$limit = $args['limit'];
		}
		if( !empty( $args['refresh'] ) ) {
			$refreshInterval = $args['refresh'];
		}
		if( !empty( $args['username'] ) ) {
			$userName = $args['username'];
		}

		if( !empty( $userName ) ) {
			$query = 'TwitterOnRailsData.userName = "' . $userName . '";';
		}
		else {
			$query = 'TwitterOnRailsData.keywords = "' . $keywords . '";';
		}

		$tagBody = <<<SCRIPT
<script type="text/javascript">/*<![CDATA[*/
 window.TwitterOnRailsData = {};
	{$query}
	TwitterOnRailsData.limit = {$limit};
	TwitterOnRailsData.refreshInterval = {$refreshInterval};
/*]]>*/</script>
SCRIPT;

		// remove whitespaces from inline JS code
		$tagBody = preg_replace("#[\n\t]+#", '', $tagBody);
		return $tagBody;
	}
}
