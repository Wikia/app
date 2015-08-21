<?php

class TwitterTagHooks {
	
	static public function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'twitter', array( __CLASS__, 'parseTwitterTag' ));
		return true;
	}
	
	static public function parseTwitterTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if( empty( $args['user'] ) ) {
			$html = wfMessage("twittertag-nouser")->parse();
			return "<p class='error'>" . $html . "</p>";
			
		} else if ( empty( $args['id'] ) ) {
			$html = wfMessage( 'twittertag-noid' )->parse();
			return "<p class='error'>" . $html . "</p>";
		}
		
		$attributes = [];
		$attributes['class'] = "twitter-timeline";
		$attributes['href'] = "https://twitter.come/" . $args['user'];
		$attributes['data-widget-id'] = $args['id'];
		
		if( !empty( $args['height'] ) ) {
			$attributes['height'] = $args['height'];
		}
		
		if( !empty( $args['width'] ) ) {
			$attributes['width'] = $args['width'];
		}
		
		if( !empty( $args['data-chrome'])) {
			$attributes['data-chrome'] = $args['data-chrome'];
		}
		
		if( !empty ( $args['limit'] ) )  {
			$attributes['data-tweet-limit'] = $args['limit'];
		}
		
		if( !empty ( $args['aria-polite'] ) ) {
			$attributes['data-aria-polite'] = $args['aria-polite'];
		}
		
		if( !empty( $args['alt-text'] ) ) {
			$html = Html::element( 'a', $attributes, $args['alt-text'] );
		} else {
			$html = Html::element( 'a', 
									$attributes, 
									wfMessage( 'twittertag-alt-text' )->params( $args['user'] )->parse() 
					);
		}

		$parser->getOutput()->addModules( 'ext.TwitterTag' );
		
		return $html;
	}
}
