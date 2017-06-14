<?php

namespace Wikia\PageHeader;

use \RequestContext;
use \Title;
use \WallMessage;
use \WikiaGlobalRegistry;
use \WikiaApp;
use \WikiaPageType;

class PageTitle {

	/* @var string */
	public $title;

	/* @var string */
	public $prefix;

	/* @var WikiaGlobalRegistry */
	private $wg;

	/* @var int */
	private $namespace;

	/* @var Title */
	private $MWTitle;

	const PREFIX_LESS_NAMESPACES = [ NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE ];

	public function __construct( WikiaApp $app ) {
		$this->wg = $app->wg;
		$this->MWTitle = RequestContext::getMain()->getTitle();
		$this->request = RequestContext::getMain()->getRequest();

		$this->namespace = $this->MWTitle->getNamespace();
		$this->title = $this->handleTitle( $app );
		$this->prefix = $this->handlePrefix();
	}

	private function handleTitle( WikiaApp $app ): string {
		$titleText = $app->getSkinTemplateObj()->data['title'];

		if ( WikiaPageType::isMainPage() ) {
			$titleText = $this->titleMainPage();
		} else if ( $this->shouldNotDisplayNamespacePrefix( $this->namespace ) ) {
			$titleText = htmlspecialchars( $this->MWTitle->getText() );
		} else if ( $this->MWTitle->isTalkPage() ) {
			$titleText = $this->isWallMessage() ?
				$this->getTitleForWallMessage() :
				htmlspecialchars( $this->MWTitle->getText() );
		} else if ( $this->request->getCheck( 'diff' ) ) {
			$titleText = $this->prefixedTitle( 'page-header-title-prefix-changes' );
		} else if ( $this->request->getVal( 'action', 'view' ) == 'history' ) {
			$titleText = $this->prefixedTitle( 'page-header-title-prefix-history' );
		} else if (
			defined( 'NS_BLOG_ARTICLE' ) &&
			$this->MWTitle->getNamespace() == NS_BLOG_ARTICLE &&
            $this->MWTitle->isSubpage()
		) {
			// remove User_blog:xxx from title
			$titleParts = explode( '/', $this->MWTitle->getText() );
			array_shift( $titleParts );

			$titleText = implode( '/', $titleParts );
		}

		return $titleText;
	}

	private function handlePrefix() {
		if ( $this->MWTitle->isTalkPage() && !$this->isWallMessage() ) {
			return $this->wg->ContLang->getNsText( NS_TALK );
		}

		return null;
	}

	private function shouldNotDisplayNamespacePrefix( $namespace ): bool {
		return in_array( $namespace,
			array_merge(
				self::PREFIX_LESS_NAMESPACES,
				defined( 'NS_BLOG_LISTING' ) ? [ NS_BLOG_LISTING ] : [],
				$this->wg->SuppressNamespacePrefix
			)
		);
	}

	private function isWallMessage(): bool {
		//It's needed to check if WallMessage is a number to prevent loading new header on single thread comment page.
		//Example: community.wikia.com/wiki/Thread:PyroNacht/@comment-A_Google_User-20170607070811/@comment-C.Syde65-20170607082828?oldid=2213679
		return $this->MWTitle->getNamespace() === NS_USER_WALL_MESSAGE && is_numeric( $this->MWTitle->getText() );
	}

	private function titleMainPage(): string {
		return wfMessage( 'oasis-home' )->escaped();
	}

	private function prefixedTitle( $prefixKey ): string {
		return wfMessage( $prefixKey, $this->MWTitle->getPrefixedText() )->escaped();
	}

	private function getTitleForWallMessage(): string {
		$messageKey = $this->MWTitle->getText();
		$message = WallMessage::newFromId( $messageKey );
		if ( !empty( $message ) ) {
			$message->load();
			return $message->getMetaTitle();
		}
		return '';
	}
}
