<?php
class LqtParserFunctions {
	static function useLiquidThreads( &$parser, $param = '1' ) {
		$offParams = array( 'no', 'off', 'disable' );
		// Figure out if they want to turn it off or on.
		$param = trim( strtolower( $param ) );
		
		if ( in_array( $param, $offParams ) || !$param ) {
			$param = 0;
		} else {
			$param = 1;
		}
		
		$parser->mOutput->setProperty( 'use-liquid-threads', $param );
	}
	
	static function lqtPageLimit( &$parser, $param = null ) {
		if ( $param && $param > 0 ) {
			$parser->mOutput->setProperty( 'lqt-page-limit', $param );
		}
	}
	
	/** To bypass the parser cache just for the LiquidThreads part, we have a cute trick.
	  * We leave a placeholder comment in the HTML, which we expand out in a hook. This way,
	  * most of the page can be cached, but the LiquidThreads dynamism still works.
	  * Thanks to Tim for the idea. */
	static function lqtTalkPage( $parser, $args, $parser, $frame ) {
		$pout = $parser->getOutput();
		
		// Prepare information.
		$title = null;
		if ( !empty($args['talkpage']) ) {
			$title = Title::newFromText( $args['talkpage'] );
		}
		if ( is_null($title) ) {
			$title = $parser->getTitle();
		}
		
		$talkpage = new Article( $title, 0 );
		$article = new Article( $parser->getTitle(), 0 );
		
		$data = array(
			'type' => 'talkpage',
			'args' => $args,
			'article' => $article,
			'title' => $article->getTitle(),
			'talkpage' => $talkpage,
		);
		
		if ( !isset( $pout->mLqtReplacements ) ) {
			$pout->mLqtReplacements = array();
		}
		
		// Generate a token
		$tok = wfGenerateToken();
		$text = '<!--LQT-PAGE-'.$tok.'-->';
		$pout->mLqtReplacements[$text] = $data;
		
		return $text;
	}
	
	static function lqtThread( $parser, $args, $parser, $frame ) {
		$pout = $parser->getOutput();
		
		// Prepare information.
		$title = Title::newFromText( $args['thread'] );
		$thread = null;
		if ( $args['thread'] ) {
			if ( is_numeric( $args['thread'] ) ) {
				$thread = Threads::withId( $args['thread'] );
			} elseif ( $title ) {
				$article = new Article( $title, 0 );
				$thread = Threads::withRoot( $article );
			}
		}
		
		if ( is_null( $thread ) ) {
			return '';
		}
		
		$data = array(
			'type' => 'thread',
			'args' => $args,
			'thread' => $thread->id(),
			'title' => $thread->title(),
		);
		
		if ( !isset( $pout->mLqtReplacements ) ) {
			$pout->mLqtReplacements = array();
		}
		
		// Generate a token
		$tok = wfGenerateToken();
		$text = '<!--LQT-THREAD-'.$tok.'-->';
		$pout->mLqtReplacements[$text] = $data;
		
		return $text;
	}
	
	static function runLqtTalkPage( $details ) {
		$title = $details["title"];
		$article = $details["article"];
		$talkpage = $details["talkpage"];
		$args = $details["args"];
		
		global $wgUser, $wgRequest, $wgOut;
		$oldOut = $wgOut->getHTML();
		$wgOut->clearHTML();
		
		$view = new TalkpageView( $wgOut, $article, $title, $wgUser, $wgRequest );
		$view->setTalkpage( $talkpage );
		
		// Handle show/hide preferences. Header gone by default.
		$view->hideItems( 'header' );
		
		if ( array_key_exists( 'show', $args ) ) {
			$show = explode( ' ', $args['show'] );
			$view->setShownItems( $show );
		}
		
		$view->show();
		
		$html = $wgOut->getHTML();
		$wgOut->clearHTML();
		$wgOut->getHTML( $oldOut );
		
		return $html;
	}
	
	static function showLqtThread( $details ) {
		$title = $details["title"];
		$article = $details["article"];
		
		global $wgUser, $wgRequest, $wgOut;
		$oldOut = $wgOut->getHTML();
		$wgOut->clearHTML();
		
		$root = new Article( $title, 0 );
		$thread = Threads::withRoot( $root );
		
		$view = new LqtView( $wgOut, $article, $title, $wgUser, $wgRequest );
		
		$view->showThread( $thread );
		
		$html = $wgOut->getHTML();
		$wgOut->clearHTML();
		$wgOut->getHTML( $oldOut );
		
		return $html;
	}
	
	static function onAddParserOutput( &$out, $pout ) {
		if ( !isset($pout->mLqtReplacements ) ) {
			return true;
		}
		
		if ( !isset($out->mLqtReplacements) ) {
			$out->mLqtReplacements = array();
		}
		
		foreach( $pout->mLqtReplacements as $text => $details ) {
			$result = '';
			
			if ( ! is_array($details) ) {
				continue;
			}
			
			if ( $details['type'] == 'talkpage' ) {
				$result = self::runLqtTalkPage( $details );
			} elseif ( $details['type'] == 'thread' ) {
				$result = self::showLqtThread( $details );
			}
			
			$out->mLqtReplacements[$text] = $result;
			$out->addModules( 'ext.liquidThreads' );
		}
		
		return true;
	}
	
	static function onAddHTML( &$out, &$text ) {
		if ( !isset($out->mLqtReplacements) || !count($out->mLqtReplacements) ) {
			return true;
		}
		
		$replacements = $out->mLqtReplacements;
	
		$replacer = new ReplacementArray( $replacements );
		$text = $replacer->replace( $text );
	
		return true;
	}
}
