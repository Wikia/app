<?php

class CodeEditorHooks {
	static function getPageLanguage( $title ) {
		// Try CSS/JS
		if( $title->isCssOrJsPage() ) {
			if( preg_match( '/\.js$/', $title->getText() ) )
				return 'javascript';
			if( preg_match( '/\.js$/', $title->getText() ) )
				return 'css';
		}
		
		// Give extensions a chance
		$lang = null;
		wfRunHooks( 'CodeEditorGetPageLanguage', array( $title, &$lang ) );
		
		return $lang;
	}
	
	public static function editPageShowEditFormInitial( &$toolbar ) {
		global $wgOut, $wgTitle;
		$lang = self::getPageLanguage( $wgTitle );
		if ( $lang ) {
			$wgOut->addModules( 'ext.codeEditor' );
		}
		return true;
	}

	public static function onMakeGlobalVariablesScript( &$vars, $output ) {
		global $wgTitle;
		
		$lang = self::getPageLanguage( $wgTitle );
		if( $lang ) {
			$vars['wgCodeEditorCurrentLanguage'] = $lang;
		}
		return true;
	}
	
	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgCodeEditorGeshiIntegration;
		if ( $wgCodeEditorGeshiIntegration ) {
			$out->addModules( 'ext.codeEditor.geshi' );
		}
		return true;
	}
}
