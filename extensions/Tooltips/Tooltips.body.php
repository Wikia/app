<?php

class Tooltips {
	static function setupParserFunctions( $parser ) {
		$parser->setFunctionHook(
			'tooltip',
			array( 'Tooltips', 'tooltip')
		);
		
		return true;
	}
	
	static function tooltip( $parser, $tooltip = null, $text = null ) {
		if ( !$text ) {
			return;
		}
		
		$tooltip = Xml::tags( 'span',
			array( 'style' => 'display: none', 'class' => 'mw-tooltip' ),
			$tooltip );
		
		$text .= "\n$tooltip";
		$text = Xml::tags( 'span',
			array( 'class' => 'mw-tooltip-text' ), $text );
			
		// Script for hover behaviour hacked in by Andrew Garrett, 2010-08-09
		static $scriptDone = false;
		if ( ! $scriptDone ) {
			$scriptDone = true;
		global $wgOut, $IP, $wgScriptPath;
		$output = $parser->getOutput();
		
		// Figure out the web-accessible path to the extension.
		$dir = dirname( __FILE__ );
		if ( strpos( $dir, $IP ) === 0 ) {
			$dir = substr( $dir, strlen($IP) );
			$dir = $wgScriptPath . $dir;
			
			$output->addHeadItem( "<link rel=\"stylesheet\" type=\"text/css\" href=\"$dir/jquery-tooltip/jquery.tooltip.css\"/>" );
			$output->addHeadItem( Html::linkedScript( "$dir/jquery-tooltip/jquery.tooltip.pack.js" ) );
			$output->addHeadItem( Html::linkedScript( "$dir/hover.js" ) );
		}
		}
		
		return $text;
	}
}
