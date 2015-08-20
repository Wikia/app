<?php

class TwitterTagHooks {
	
	static public function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'twitter', array( __CLASS__, 'parseTwitterTag' ));
		return true;
	}
	
	static public function parseTwitterTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		if( empty( $args['user'] ) ) {
			$html = $parser->recursiveTagParse( wfMessage("twittertag-nouser")->escaped(), $frame);
			return "<p class='error'>" . $html . "</p>";
			
		} else if ( empty( $args['id'] ) ) {
			$html = $parser->recursiveTagParse( wfMessage( 'twittertag-noid' )->escaped(), $frame);
			return "<p class='error'>" . $html . "</p>";
		}
		
		$html = '<a class="twitter-timeline" href="https://twitter.com/' . htmlspecialchars( $args['user'] ) . '"';
		$html .= ' data-widget-id="' . htmlspecialchars( $args['id'] ) . '"';
		
		if( !empty( $args['height'] ) ) {
			$html .= ' height="' . htmlspecialchars( $args['height'] ) . '"';
		}
		
		if( !empty( $args['width'] ) ) {
			$html .= ' width="' . htmlspecialchars( $args['width'] ) . '"';
		}
		
		if( !empty( $args['data-chrome'])) {
			$html .= ' data-chrome="' . htmlspecialchars( $args['data-chrome'] ) . '"';
		}
		
		if( !empty ( $args['limit'] ) )  {
			$html .= ' data-tweet-limit="' . htmlspecialchars( $args['limit'] ) . '"';
		}
		
		if( !empty ( $args['aria-polite'] ) ) {
			$html .= ' data-aria-polite="' . htmlspecialchars( $args['aria-polite'] ) . '"';
		}
		
		if( !empty( $args['alt-text'] ) ) {
			$html .= '>' . htmlspecialchars( $args['alt-text'] );
		} else {
			$html .= '>' . wfMessage( 'twittertag-alt-text' )->params( htmlspecialchars( $args['user'] ) )->escaped();
		}
		
		$html .= '</a>';
			
		$html .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		
		return $html;
	}
}