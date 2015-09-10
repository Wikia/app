<?php

class TwitterTagController extends WikiaParserTagController {

	/**
	 * onParserFirstCallInit
	 *
	 * Registers the <twitter> tag with the parser and sets its callback.
	 *
	 * @param Parser $parser
	 * @return bool - hooks aways have to return true
	 */
	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'twitter', [ new static(), 'parseTag' ] );
		return true;
	}

	/**
	 * parseTag
	 *
	 * Parses the twitter tag. Checks to ensure the required attributes are there.
	 * Then constructs the HTML after seeing which attributes are in use.
	 *
	 * @param string $input - not used
	 * @param array $args - attributes to the tag in an assoc array
	 * @param Parser $parser - not used
	 * @param PPFrame $frame - not used
	 * @return string $html - HTML output for the twitter tag
	 */
	public function parseTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		global $wgSkinName;

		if ( empty( $args['screen-name'] ) ) {
			$html = wfMessage( 'twittertag-screen-name' )->parse();
			return "<strong class='error'>$html</strong>";
		} else if ( empty( $args['widget-id'] ) ) {
			$html = wfMessage( 'twittertag-widget-id' )->parse();
			return "<strong class='error'>$html</strong>";
		}

		if ( $this->app->checkSkin( [ 'wikiamobile', 'mercury' ] ) ) {
			$attributes['data-wikia-widget'] = 'twitter';
		} else {
			$attributes['class'] = 'twitter-timeline';
		}

		$attributes['href'] = 'https://twitter.com/' . urlencode( $args['screen-name'] );
		$attributes['data-widget-id'] = $args['widget-id'];
		$attributes['data-screen-name'] = $args['screen-name'];

		if ( !empty( $args['alt-text'] ) ) {
			$html = Html::element( 'a', $attributes, $args['alt-text'] );
		} else {
			$html = Html::element(
				'a',
				$attributes,
				wfMessage( 'twittertag-alt-text' )->params( $args['screen-name'] )->plain()
			);
		}

		if ( !$this->app->checkSkin( [ 'wikiamobile', 'mercury' ] ) ) {
			$html .= <<<EOT
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
EOT;
		}

		return $html;
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
