<?php


/**
 * Generated parameters:
 *  lang=en
 *  dir=ltr
 *  count=10,549 # localized
 *  percent=10.549 # percentage
 *
 * Template defaults could be, eg:
 *  progress=<tspan class="count">{{{count}}}</tspan> have donated
 *  headline=<tspan class="you">You</tspan> can help Wikipedia change the world!
 *  button=» Donate now!
 *  font=Gill Sans
 *  boldfont=Gill Sans Ultra Bold
 *  
 * Per-language overrides for each...
 *
 * {{#expr:ceil(20*{{{rawcount}}}/{{{rawmax}}})}}
 */
class SpecialNoticeRender extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( "NoticeRender" );
	}
	
	function execute( $par ) {
		global $wgOut;
		$wgOut->disable();
		$this->sendHeaders();
		echo $this->getSvgOutput( $par );
	}
	
	private function sendHeaders() {
		header( "Content-type: image/svg+xml" );
		//header( "Content-type: image/png" );
	}
	
	private function getSvgOutput( $par ) {
		$render = new NoticeRender();
		$template = wfMsgForContentNoTrans( 'centralnotice-svg-template' );
		$svg = $render->expandTemplate( $template );
		$pngUrl = $render->rasterize( $svg );
		return $svg;
	}
}