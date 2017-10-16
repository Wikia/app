<?php

/**
 * Use a custom class (set via StaticUserPagesHooks::onArticleFromTitle) to render a user page using i18n message.
 */
class StaticUserPagesArticle extends Article {

	public function view() {
		$out = $this->getContext()->getOutput();

		$out->setPageTitle( $this->getTitle()->getPrefixedText() );
		$out->setArticleFlag( true );
		$this->showNamespaceHeader();

		// render a content from i18n messages
		$out->addHTML(
			wfMessage( StaticUserPagesHooks::getMessageForTitle( $this->getTitle() ) )->inContentLanguage()->parseAsBlock()
		);
	}

	public function getContent() {
		return '';
	}
}
