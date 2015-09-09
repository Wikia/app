<?php

class TwitterTagHooks {
	
	/*
	 * onParserFirstCallInit
	 *
	 * Registers the <twitter> tag with the parser and sets its callback
	 *
	 * @param $parser - The parser
	 * @return true
	 */
	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'twitter', [ __CLASS__, 'parseTwitterTag' ] );
		return true;
	}
	
	/*
	 * parseTwitterTag
	 *
	 * Parses the twitter tag. Checks to ensure the required attributes are there. 
	 *   Then constructs the HTML after seeing which attributes are in use. 
	 *
	 * @param $input - not used
	 * @param $args - The attributes to the tag in an assoc array
	 * @param $parser - not used
	 * @param $frame - not used
	 * @return $html - The HTML for the twitter tag
	 */
	static public function parseTwitterTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( empty( $args['user'] ) ) {
			$html = wfMessage( 'twittertag-nouser' )->parse();
			return "<strong class='error'>$html</strong>";
			
		} else if ( empty( $args['id'] ) ) {
			$html = wfMessage( 'twittertag-noid' )->parse();
			return "<strong class='error'>$html</strong>";
		}
		
		$quickChecks = [
			'height' => '',
			'width' => '',
			'data-chrome' => '',
		];
		
		$attributes = array_intersect_key( $args, $quickChecks );
		
		$attributes['class'] = 'twitter-timeline';
		$attributes['href'] = 'https://twitter.com/' . urlencode( $args['user'] );
		$attributes['data-widget-id'] = $args['id'];
		
		if ( !empty ( $args['limit'] ) )  {
			$attributes['data-tweet-limit'] = $args['limit'];
		}
		
		if ( !empty ( $args['aria-polite'] ) ) {
			$attributes['data-aria-polite'] = $args['aria-polite'];
		}
		
		if ( !empty( $args['alt-text'] ) ) {
			$html = Html::element( 'a', $attributes, $args['alt-text'] );
		} else {
			$html = Html::element( 
				'a', 
				$attributes, 
				wfMessage( 'twittertag-alt-text' )->params( $args['user'] )->plain() 
			);
		}

		$parser->getOutput()->addModules( 'ext.TwitterTag' );

		return $html;
	}
}
