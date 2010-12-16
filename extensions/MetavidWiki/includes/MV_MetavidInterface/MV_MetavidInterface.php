<?php
/*
 * Created on Jun 28, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 *
 * The metavid interface class
 * provides the metavid interface for Metavid: requests
 * provides the base metadata
 *
 */
 if ( !defined( 'MEDIAWIKI' ) )  die( 1 );


 class MV_MetavidInterface {
	var $components = array();
	var $context = null;
	var $page_title = '';
	var $page_header = '';
	// list the properties we are set and there default values:
	var $smwProperties = array( 'playback_resolution' => null );
	function __construct( $contextType, & $contextArticle = null ) {
		global $mv_default_view;
		$this->context = $contextType;
		if ( $contextArticle )
			$this->article = & $contextArticle;
		// set up base layout for each context:
		switch( $contextType ) {
			case 'special':
				$this->setupSpecialView();
			break;
			case 'sequence':
				$this->setupSequenceView();
			break;
			case 'stream':
				$this->setupStreamView();
			break;
		}
	}
	/*function setupSequenceView(){
		global $mvgIP;
		//set up the base sequence:
		foreach(array('MV_VideoPlayer', ''
		/*foreach(array('MV_VideoPlayer') as $cp_name){
			require_once($mvgIP . '/includes/MV_MetavidInterface/'.$cp_name.'.php');
			$this->components[$cp_name] = new $cp_name(
				array('mv_interface'=>&$this)
			);
		}
	}*/
	function setupStreamView() {
		global $mvgIP, $mvDefaultStreamViewLength, $wgOut, $mvgScriptPath, $wgUser, $mvDispROEicon, $mvEnableStreamNotice;

		// set default time range if null time range request
		$this->article->mvTitle->setStartEndIfEmpty();
		// grab relevant article semantic properties (so far playback_resolution) for user overwriting playback res
		$this->grabSemanticProp();

		// set up the interface objects:
		foreach ( array( 'MV_VideoPlayer', 'MV_Navigator', 'MV_Overlay', 'MV_Tools' ) as $cp_name ) {
			$this->components[$cp_name] = new $cp_name(
				array( 'mv_interface' => &$this )
			);
		}
		// process track request:
		$this->components['MV_Overlay']->procMVDReqSet();
		// add in title & tracks var:
		global $mvgScriptPath, $wgRequest;
		$advs = $wgRequest->getVal( 'advs' );
		$advSearch = ( $advs == '' || $advs == 0 ) ? '0' : '1';

		$wgOut->addScript( '<script type="text/javascript">/*<![CDATA[*/' . '
			var mvTitle = \'' . htmlspecialchars( $this->article->mvTitle->getWikiTitle() ) . '\';
			var mvTracks = \'' . htmlspecialchars( $this->components['MV_Overlay']->getMVDReqString() ) . '\';
			var mvgScriptPath = \'' . htmlspecialchars( $mvgScriptPath ) . '\';
		/*]]>*/</script>' );

		$sk = $wgUser->getSkin();

		global $wgTitle;
		// also add prev next paging
		$this->page_header = '<h1 class="videoHeader">' .
			$this->article->mvTitle->getStreamNameDate() . ' :: ' .
			$this->components['MV_Tools']->stream_paging_links( 'prev' ) .
				' <span title="' . htmlspecialchars( wfMsg( 'mv_click_to_edit' ) ) .
				'" id="mv_stream_time">' . $this->article->mvTitle->getTimeDesc( $span_separated = true ) .' '.
					'</span>'.
				'</span>' .
			$this->components['MV_Tools']->stream_paging_links( 'next' ) .
			'<br /><span style="font-size:80%">' .
				wfMsg( 'mv_stream_length' ) . seconds2Description( $this->article->mvTitle->getDuration(), true ) . ' <i>'.
			'<span style="font-size:90%">';
		$this->page_header .= wfMsg('mv_stream_tool_heading'). ':</i></span> <span style="font-size:70%">';
		if( $wgRequest->getVal('view') != 'overview' )
			$this->page_header.= $sk->makeKnownLinkObj( $wgTitle, wfMsg( 'mv_stream_overview' ), 'view=overview' ) . ' | ';
		$this->page_header.=' <a id="mv_edit_time" style="color:#2060C1;" href="#" onclick="return false;" alt=" ' .
						wfMsg('mv_edit_time'). '" >'. wfMsg('mv_edit_time') . '</a></span></h1>';

		if($mvEnableStreamNotice){
			$wgOut->addWikiText( wfMsg('mv_warning_wiki'));
			$this->page_header.=$wgOut->getHTML();
			$wgOut->clearHTML();
		}
		//clear no robots flag:
		$wgOut->setRobotpolicy( '' );

		// add export roe icon:
		if($mvDispROEicon){
			$this->page_header .= '<span id="cmml_link"/>';
				$sTitle = Title::makeTitle( NS_SPECIAL, 'MvExportStream' );
				$this->page_header .= $sk->makeKnownLinkObj( $sTitle,
					'<img style="width:28px;height:28px;" src="' . htmlspecialchars( $mvgScriptPath ) . '/skins/images/Feed-icon_cmml_28x28.png">',
					'feed_format=roe&stream_name=' . htmlspecialchars( $this->article->mvTitle->getStreamName() ) . '&t=' . htmlspecialchars( $this->article->mvTitle->getTimeRequest() ),
					'', '', 'title="' . htmlspecialchars( wfMsg( 'mv_export_cmml' ) ) . '"' );
		}
		$this->page_header .= '</span>';
		$this->page_title = $this->article->mvTitle->getStreamNameText() . ' ' . $this->article->mvTitle->getTimeDesc();
	}
	// grab semantic properties if available:
	// @@todo we need to think this through a bit
	function grabSemanticProp() {
		if ( SMW_VERSION ) {
			// global $smwgIP;
			$smwStore =& smwfGetStore();
			foreach ( $this->smwProperties as $propKey => $val ) {
				$propTitle = Title::newFromText( $propKey, SMW_NS_PROPERTY );
				$smwProps = $smwStore->getPropertyValues( $this->article->mTitle, $propTitle );
				// just a temp hack .. we need to think about this abstraction a bit...
				if ( count( $smwProps ) != 0 ) {
					$v = current( $smwProps );
					$this->smwProperties[$propKey] = $v->getXSDValue();
				}
			}
		}
	}
	/*
	 * renders the full page  to the wgOut object
	 */
	function render_full() {
		global $wgOut;
		// add some variables for the interface:

		// output title and header:
		$wgOut->setHTMLTitle( $this->page_title );

		if ( $this->page_header == '' )$this->page_header = '<span style="position:relative;top:-12px;font-weight:bold">' .
			htmlspecialchars( $this->page_title ) . '</span>';
		$wgOut->addHTML( $this->page_header );

		// @@todo dynamic re-size page_spacer:
		$wgOut->addHTML( '<div id="mv_interface_container">' );
		foreach ( $this->components as $cpKey => &$component ) {
			if ( $cpKey == 'MV_Tools' )
				$wgOut->addHTML( "<div style=\"clear:left\"></div>");

			if ( $cpKey == 'MV_Navigator' )
				$wgOut->addHTML( "<div id=\"videoSideBar\">" );

			$component->render_full();
			if ( $cpKey == 'MV_Overlay' )
				$wgOut->addHTML( "</div>" );

		}
		$wgOut->addHTML( '</div>' );
		// for now output spacers
		// @@todo output a dynamic spacer javascript layout
		// $out='';
		// for($i=0;$i<28;$i++)$out.="<br />";
		// $wgOut->addHTML($out);
		// }
	}
}
