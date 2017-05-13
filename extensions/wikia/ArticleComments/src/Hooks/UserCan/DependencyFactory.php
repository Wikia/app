<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Check\CheckFactory;

class DependencyFactory {
	public function getCommentsNamespaces(): array {
		global $wgArticleCommentsNamespaces;
		return array_map( 'MWNamespace::getTalk', $wgArticleCommentsNamespaces );
	}

	public function newCheckFactory(): CheckFactory {
		return new CheckFactory( $this );
	}

	public function newArticleComment( \Title $title ): \ArticleComment {
		return new \ArticleComment( $title );
	}
}
