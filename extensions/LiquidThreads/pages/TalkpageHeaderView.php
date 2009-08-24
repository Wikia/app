<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class TalkpageHeaderView extends LqtView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset( $content_actions['edit'] );
		unset( $content_actions['addsection'] );
		unset( $content_actions['history'] );
		unset( $content_actions['watch'] );
		unset( $content_actions['move'] );

		$content_actions['talk']['class'] = false;
		$content_actions['header'] = array( 'class' => 'selected',
		'text' => 'header',
		'href' => '' );

		return true;
	}

	function show() {
		global $wgHooks, $wgOut, $wgTitle, $wgRequest;
		// Why is a hook added here?
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );

		if ( $wgRequest->getVal( 'action' ) === 'edit' ) {
			wfLoadExtensionMessages( 'LiquidThreads' );
			$warn_bold = '<strong>' . wfMsg( 'lqt_header_warning_bold' ) . '</strong>';
			$warn_link = '<a href="' . $this->talkpageUrl( $wgTitle, 'talkpage_new_thread' ) . '">' .
			wfMsg( 'lqt_header_warning_new_discussion' ) . '</a>';
			$wgOut->addHTML( '<p class="lqt_header_warning">' .
			wfMsg( 'lqt_header_warning_before_big', $warn_bold, $warn_link ) .
			'<big>' . wfMsg( 'lqt_header_warning_big', $warn_bold, $warn_link ) . '</big>' .
			wfMsg( 'word-separator' ) .
			wfMsg( 'lqt_header_warning_after_big', $warn_bold, $warn_link ) .
			'</p>' );
		}

		return true;
	}
}
