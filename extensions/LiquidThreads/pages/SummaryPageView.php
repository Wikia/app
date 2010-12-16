<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class SummaryPageView extends LqtView {
	function show() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$thread = Threads::withSummary( $this->article );
		if ( $thread && $thread->root() ) {
			global $wgUser;

			$t = $thread->root()->getTitle();
			$link = $wgUser->getSkin()->link( $t );
			$this->output->setSubtitle(
				wfMsgExt(
					'lqt_summary_subtitle',
					array( 'parseinline', 'replaceafter' ),
					$link
				)
			);
		}
		return true;
	}
}
