<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class IndividualThreadHistoryView extends ThreadPermalinkView {
	protected $oldid;

	function customizeTabs( $skintemplate, &$content_actions ) {
		$content_actions['history']['class'] = 'selected';
		parent::customizeTabs( $skintemplate, $content_actions );
		return true;
	}

	function customizeNavigation( $skin, &$links ) {
		$links['views']['history']['class'] = 'selected';
		parent::customizeNavigation( $skin, $links );
		return true;
	}

	/* This customizes the subtitle of a history *listing* from the hook,
	and of an old revision from getSubtitle() below. */
	function customizeSubtitle() {
		$msg = wfMsgExt( 'lqt_hist_view_whole_thread', 'parseinline' );
		$threadhist = $this->permalink(
			$this->thread->topmostThread(),
			$msg,
			'thread_history'
		);
		$this->output->setSubtitle(
			parent::getSubtitle() . '<br />' .
			$this->output->getSubtitle() .
			"<br />$threadhist"
		);
		return true;
	}

	/* */
	function getSubtitle() {
		$this->article->setOldSubtitle( $this->oldid );
		$this->customizeSubtitle();
		return $this->output->getSubtitle();
	}

	function show() {
		global $wgHooks;

		if ( !$this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}

		$wgHooks['PageHistoryBeforeList'][] = array( $this, 'customizeSubtitle' );

		return true;
	}
}
