<?php 

class AVS {
	public static function parser_hook_video() {
		return 'parser_hook_video';
	}
	
	public static function parser_hook_image() {
		return 'parser_hook_image';
	}
	
	public static function initHooks(&$parser) {
		$parser->setHook('avs_video', 'AVS::parser_hook_video');
		$parser->setHook('avs_image_link', 'AVS::parser_hook_image');
		return true;
	}
}

class AVSSpecialPage extends SpecialPage {
 	
	function __construct() {
		wfLoadExtensionMessages( 'AVS' );
		parent::__construct( 'AVS', '' );
	}
	
	function execute() {
		global $wgRequest, $wgOut;
		$wgOut->addHTML( "TEST123" );
	}
}