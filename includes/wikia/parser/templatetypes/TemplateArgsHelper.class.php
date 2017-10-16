<?php

class TemplateArgsHelper {
	/**
	 * Parse template args to associative array
	 *
	 * @param PPNode_DOM $args
	 * @param PPFrame_DOM $frame
	 *
	 * @return array
	 */
	public static function getTemplateArgs( $args, $frame ) {
		$templateArgs = [ ];

		for ( $i = 0; $i < $args->getLength(); $i++ ) {
			$bits = $args->item( $i )->splitArg();
			$name = $frame->expand( $bits[ 'name' ] );
			$index = !empty( $name ) ? $name : $bits[ 'index' ];
			$templateArgs[ $index ] = $frame->expand( $bits[ 'value' ] );
		}

		return $templateArgs;
	}

	/**
	 * @desc If curly brackets found, means that template contain some not yet
	 * expanded templates and arguments.
	 *
	 * @param $wikitext
	 * @return bool
	 */
	public static function containsUnexpandedArgs( $wikitext ) {
		return preg_match( '/{{.+}}/', $wikitext );
	}
}
