<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class SummaryPageView extends LqtView {
	function show() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		$thread = Threads::withSummary( $this->article );
		if ( $thread ) {
			$url = $thread->root()->getTitle()->getFullURL();
			$name = $thread->root()->getTitle()->getPrefixedText();
			$this->output->setSubtitle(
			wfMsg( 'lqt_summary_subtitle',
			'<a href="' . $url . '">' . $name . '</a>' ) );
		}
		return true;
	}
}
