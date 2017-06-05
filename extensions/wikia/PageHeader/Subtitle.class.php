<?php

namespace Wikia\PageHeader;

use FakeSkin;
use RequestContext;
use Swagger\Client\ContentEntity\Models\Body;
use Xml;
use Html;

class Subtitle {
	/**
	 * @var string
	 */
	public $subtitle;

	/**
	 * @var string
	 */
	public $pageSubtitle;

	/**
	 * @var mixed|null
	 */
	public $suppressPageSubtitle;

	/**
	 * @var \SkinTemplate
	 */
	private $skinTemplate;

	/**
	 * @var bool
	 */
	private static $onEditPage = false;

	public function __construct( \WikiaApp $app ) {
		$this->suppressPageSubtitle = $app->wg->SuppressPageSubtitle;
		$this->request = RequestContext::getMain()->getRequest();
		$this->skinTemplate = $app->getSkinTemplateObj();
		if ( !$this->suppressPageSubtitle ) {
			$this->subtitle = $this->getSubtitle();
			//watch list uses that, pageSubject?
			$this->pageSubtitle = $this->getPageSubtitle();
		}
	}

	/**
	 * Detect we're on edit (or diff) page
	 */
	public static function isEditPage() {
		$wg = \F::app()->wg;
		return !empty( Hooks::$onEditPage ) ||
		       !is_null( $wg->Request->getVal( 'diff' ) ) /* diff pages - RT #69931 */ ||
		       in_array( $wg->Request->getVal( 'action', 'view' ), [ 'edit' /* view source page */, 'formedit' /* SMW edit pages */, 'history' /* history pages */, 'submit' /* conflicts, etc */ ] );
	}

	private function getSubtitle() {
		$wgOutput = \RequestContext::getMain()->getOutput();

		if(self::isEditPage()) {
			return $this->getEditPageSubtitle();
		}

		return $wgOutput->getSubtitle();
	}

	private function getEditPageSubtitle() {
		$wgOutput = \RequestContext::getMain()->getOutput();
		$title = \RequestContext::getMain()->getTitle();

		$subtitle = [
			$this->getBackLink(),
			$wgOutput->getSubtitle(),
		];

		if ( $this->request->getVal( 'action', 'view' ) === 'history' ) {
			$sk = new FakeSkin();
			$sk->setRelevantTitle( $title );

			$undeleteLink = $sk->getUndeleteLink();
			if ( $undeleteLink ) {
				$subtitle[] = $undeleteLink;
			}
		}

		$pipe = wfMessage( 'pipe-separator' )->escaped();

		return implode( $pipe, $subtitle );
	}

	private function getTalkPageBackLink() {
		$title = \RequestContext::getMain()->getTitle();

		if ( $title->isTalkPage() ) {
			$namespace = $title->getNamespace();

			// back to subject article link
			switch ( $namespace ) {
				case NS_TEMPLATE_TALK:
					$msgKey = 'page-header-subtitle-back-to-template';
					break;

				case NS_MEDIAWIKI_TALK:
					$msgKey = 'page-header-subtitle-back-to-mediawiki';
					break;

				case NS_CATEGORY_TALK:
					$msgKey = 'page-header-subtitle-back-to-category';
					break;

				case NS_FILE_TALK:
					$msgKey = 'page-header-subtitle-back-to-file';
					break;

				default:
					$msgKey = 'page-header-subtitle-back-to-article';
			}

			return \Linker::link(
				$title->getSubjectPage(),
				wfMessage( $msgKey )->escaped(),
				[ 'accesskey' => 'c' ]
			);
		}

		return null;
	}

	private function getPageType() {
		$title = \RequestContext::getMain()->getTitle();
		$namespace = $title->getNamespace();

		$pageType = null;
		// render page type info
		switch ( $namespace ) {
			case NS_MEDIAWIKI:
				$pageType = wfMessage( 'page-header-subtitle-mediawiki' )->escaped();
				break;

			case NS_TEMPLATE:
				$pageType = wfMessage( 'page-header-subtitle-template' )->escaped();
				break;

			case NS_SPECIAL:
				if (
					!$title->isSpecial('Forum') &&
					!$title->isSpecial('ThemeDesignerPreview')
				) {
					$pageType = wfMessage( 'page-header-subtitle-special' )->escaped();
				}
				break;

			case NS_CATEGORY:
				$pageType = wfMessage( 'page-header-subtitle-category' )->escaped();
				break;

			case NS_FORUM:
				$pageType = wfMessage( 'page-header-subtitle-forum' )->escaped();
				break;
		}
		//Todo: do not pass $this, or maybe whole hook?
		//wfRunHooks( 'PageHeaderPageTypePrepared', [ $this, $this->getContext()->getTitle() ] );

		return $pageType;
	}

	/**
	 * @return array
	 */
	private function languageVariants() {
		$variants = $this->skinTemplate->get( 'content_navigation' )['variants'];
		if ( !empty( $variants ) ) {
			return array_map( function ( $variant ) {
				return Html::element( 'a', [
					'href' => $variant['href'],
					'rel' => 'nofollow',
					'id' => $variant['id'],
				], $variant['text'] );
			}, $variants );
		}

		return [];
	}

	private function getSubject() {
		return null;
	}

	/**
	 * back to article link
	 * @return string
	 */
	private function getBackLink() {
		$title = \RequestContext::getMain()->getTitle();

		return \Wikia::link( $title, wfMessage( 'oasis-page-header-back-to-article' )->escaped(),
			[ 'accesskey' => 'c' ], [], 'known' );
	}

	private function getSubPageLinks() {
		return \RequestContext::getMain()->getSkin()->subPageSubtitle();
	}

	/**
	 * render pageType, pageSubject and pageSubtitle as one message
	 *
	 * @return string
	 */
	private function getPageSubtitle() {
		$additional = '';
		wfRunHooks( 'BeforePageHeaderSubtitle', [ &$additional ] );

		$subtitle = [
			$this->getPageType(),
			$this->getTalkPageBackLink(),
			$this->getSubject(),
			$this->getSubPageLinks(),
		];

		$subtitle =
			array_filter( array_merge( $subtitle, $this->languageVariants(), [ $additional ] ) );

		$pipe = wfMessage( 'pipe-separator' )->escaped();

		return implode( " {$pipe} ", $subtitle );
	}

}
