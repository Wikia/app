<?php

/**
 * Class for the 'CALLER' variable-style parser function.
 * 
 * @since 0.2
 * 
 * @file PFun_Caller.php
 * @ingroup ParserFun
 * 
 * @author Daniel Werner
 */
class ParserFunCaller extends ParserHook {
	
	public function __construct() {
		// make this a parser function extension (no tag extension) only:
		parent::__construct( false, true, ParserHook::FH_NO_HASH );
	}
	
	/**
	 * No LSB in pre-5.3 PHP, to be refactored later
	 */	
	public static function staticInit( Parser &$parser ) {
		global $egParserFunEnabledFunctions;
		if( in_array( ExtParserFun::MAG_CALLER, $egParserFunEnabledFunctions ) ) {
			// only register function if not disabled by configuration
			$instance = new self;
			$instance->init( $parser );
		}
		return true;
	}
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'CALLER';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = array();
		
		# what to get, index (any number) or certain mode (count, list)
		# since 0.2
		$params['mode'] = new Parameter( 'mode', Parameter::TYPE_STRING );
		$params['mode']->addAliases( 'index' );
		
		# where in the stack to start returning.
		# negative value will return that many elements from the top-level caller
		# since 0.2
		$params['offset'] = new Parameter( 'offset', Parameter::TYPE_INTEGER );
		$params['offset']->setDefault( false, false );
		
		# max return, if negative stop that many elements from end
		# since 0.2
		$params['limit'] = new Parameter( 'limit', Parameter::TYPE_INTEGER );
		$params['limit']->setDefault( false, false );
		$params['limit']->addAliases( 'len', 'length' );
		
		# whether to link the page names
		# since 0.2
		$params['linked'] = new Parameter( 'linked', Parameter::TYPE_BOOLEAN );
		$params['linked']->setDefault( false );
		
		# separator between list items
		# since 0.2
		$params['sep'] = new Parameter( 'sep', Parameter::TYPE_STRING );
		$params['sep']->setDefault( ', ', false );
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array(
			array( 'mode' ),
		);
	}
		
	/**
	 * Renders and returns the output.
	 * @see ParserHook::renderTag
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		
		$mode   = $parameters['mode'];
		$linked = $parameters['linked'];
		$limit  = $parameters['limit'];
		$offset = $parameters['offset'];
		
		if( is_numeric( $mode ) ) {
			// get specific caller
			/*
			 * do not just set $offset to $mode, $mode to 'list' and $limit to 1 here since handling
			 * for negative offset is different in 'list' mode. Here non-existant negative index will
			 * return '', in 'list' mode it will jump to the 0 element.
			 */
			$index = (int)$mode;
			$frame = self::getFrameStackItem( $this->frame, $index );
			
			if( $frame === null ) {
				return '';
			}
			return self::createSiteList(
					array( $frame ),
					$linked
			);	
		}
		
		$mode = strtolower( $mode );
		switch( $mode ) {
			case 'level':
				// synnonym for 'count'
				$mode = 'count';
			case 'count':
			case '':
				/*
				 * '{{CALLER:}}', perhaps with additional parameters, but not in list mode except limit
				 * is set. Otherwise tread it similar to '{{CALLER}}' variable but with parameters.
				 */
				if( $mode !== 'count' && $limit === false ) {
					$limit = 1;
				}
				if( $offset === false ) {
					// '{{CALLER}}' equals '{{CALLER:1}}', not 0, in count mode ignore current page.
					$offset = 1;
				}
				// no-break, evaluate parameters in 'list' mode but count only			
			case 'list':			
				$stack = self::getFrameStack( $this->frame );
				$offset = ( $offset === false ) ? 0 : $offset;
				$limit = ( $limit === false ) ? null : $limit; // Validator can't have null as default...
					
				$stack = array_slice( $stack, $offset, $limit );
				
				if( $mode === 'count' ) {
					// in 'count' mode, return the level
					return count( $stack );
				} else {
					// normal list mode
					return self::createSiteList(
							$stack,
							$linked,
							$parameters['sep']
					);
				}
		}
		
		/*
		 * No valid operation mode or index given to first parameter!
		 * Return error message
		 */
		$error = new ValidationError( wfMsgForContent( 'parserfun-invalid-caller-mode' ) );
		return $this->renderFatalError( $error );
	}
	
	/**
	 * Returns a string, exactly like '{{CALLER}}' as variable would return it.
	 * 
	 * @param PPFrame $frame
	 * 
	 * @return string
	 */
	static function getCallerVar( PPFrame $frame ) {
		$siteFrame = ParserFunCaller::getFrameStackItem( $frame, 1 );
		return ( $siteFrame !== null )
				? self::createSiteList( array( $siteFrame ), false )
				: '';
	}
	
	/**
	 * Returns a certain parent caller from a given frame by index. 0 returns the given frame, 1 would return
	 * the frame of the site which was calling the given frame and so on.
	 * 
	 * @param PPFrame $frame
	 * @param int     $index can be negative to return the element from the top-level caller. -1 would return
	 *                the same as {{FULLPAGENAME}} would be. If the index doesn't exist, null will be returned.
	 * 
	 * @return PPFrame|null
	 */
	static function getFrameStackItem( PPFrame $frame, $index ) {
		// get the whole stack or just till some certain index
		$stack = self::getFrameStack( $frame, $index );
		
		if( $index >= 0 ) {
			if( array_key_exists( $index, $stack ) ) {
				return $stack[ $index ];
			}
		} else {
			// negative index, return from top-level
			$index = count( $stack ) + $index;
			if( $index >= 0 ) {
				return $stack[ $index ];
			}
		}
		
		// index doesn't exist!
		return null;
	}
	
	/**
	 * Gets all parent frames from a frame and returns them as array with the given frame as first element.
	 * 
	 * @param PPFrame $frame
	 * @param int     $limit how many parent frames should be returned as maximum (in addition to given frame).
	 *                Limit below 0 means no limit. 0 will just return an array with the given frame.
	 * 
	 * @return PPFrame[]
	 */
	static function getFrameStack( PPFrame $frame, $limit = -1 ) {		
		$frames = array();
		if( $limit >= 0 ) {
			$limit++; // given $frame doesn't count so this will be returned if 0 is given
		}
		
		while( $frame !== null && $limit !== 0 ) {
			$frames[] = $frame;
			$limit--;
			
			if( $frame instanceof PPTemplateFrame_DOM ) {
				$frame = $frame->parent;
			} else {
				// frame is no template, so this is the top-level frame (page being rendered)
				$frame = null;
			}
		};
		
		return $frames;
	}
	
	/**
	 * Create a list with page titles from a given array of frames, optionally linked output.
	 * The output ist un-parsed wiki markup, no HTML.
	 * 
	 * @param array  $frames the titles represented as frames
	 * @param bool   $link whether or not to link the pages in the list
	 * @param string $sep glue between the pages
	 * 
	 * @return string
	 */
	protected static function createSiteList( $frames, $link = false, $sep = ', ' ) {
		$out = array();
		foreach( $frames as $frame ) {			
			$text = $frame->title->getPrefixedText();
			if( $link ) {
				$out[] = "[[:{$text}]]";
			} else {
				$text = wfEscapeWikiText( $text );
				$out[] = $text;
			}
		}
		return implode( $sep, $out );
	}
	
}
