<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

// Pass-through wrapper
class ThreadProtectionFormView extends LqtView {
	function customizeTabs( $skintemplate, &$content_actions ) {
		ThreadPermalinkView::customizeThreadTabs( $skintemplate, $content_actions, $this );

		if ( array_key_exists( 'protect', $content_actions ) )
		$content_actions['protect']['class'] = 'selected';
		elseif ( array_key_exists( 'unprotect', $content_actions ) )
		$content_actions['unprotect']['class'] = 'selected';
	}

	function customizeNavigation( $skintemplate, &$links ) {
		ThreadPermalinkView::customizeThreadNavigation( $skintemplate, $links, $this );

		if ( isset( $links['actions']['protect'] ) ) {
			$links['actions']['protect']['class'] = 'selected';
		}

		if ( isset( $links['actions']['unprotect'] ) ) {
			$links['actions']['unprotect']['class'] = 'selected';
		}
	}

	function __construct( &$output, &$article, &$title, &$user, &$request ) {
		parent::__construct( $output, $article, $title, $user, $request );

		$t = Threads::withRoot( $this->article );

		$this->thread = $t;
		if ( !$t ) {
			return;
		}

		$this->article = $t->article();
	}
}
