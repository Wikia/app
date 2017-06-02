<?php

namespace Wikia\PageHeader;

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

	public function __construct( \WikiaApp $app ) {
		$this->suppressPageSubtitle = $app->wg->SuppressPageSubtitle;
		if ( !$this->suppressPageSubtitle ) {
			$this->subtitle = $this->getSubtitle();
			//watch list uses that, pageSubject?
			$this->pageSubtitle = $this->handlePageSubtitle();
		}
	}

	private function getSubtitle() {
		$wgOutput = \RequestContext::getMain()->getOutput();

		return $wgOutput->getSubtitle();
	}

	private function handleTalkPage() {
		$title = \RequestContext::getMain()->getTitle();

		if ( $title->isTalkPage() ) {
			$namespace = $title->getNamespace();

			// back to subject article link
			switch ( $namespace ) {
				case NS_TEMPLATE_TALK:
					$msgKey = 'oasis-page-header-back-to-template';
					break;

				case NS_MEDIAWIKI_TALK:
					$msgKey = 'oasis-page-header-back-to-mediawiki';
					break;

				case NS_CATEGORY_TALK:
					$msgKey = 'oasis-page-header-back-to-category';
					break;

				case NS_FILE_TALK:
					$msgKey = 'oasis-page-header-back-to-file';
					break;

				default:
					$msgKey = 'oasis-page-header-back-to-article';
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
				$pageType = wfMessage( 'oasis-page-header-subtitle-mediawiki' )->escaped();
				break;

			case NS_TEMPLATE:
				$pageType = wfMessage( 'oasis-page-header-subtitle-template' )->escaped();
				break;

			case NS_SPECIAL:
				if ( !$title->isSpecial('Forum') &&
					!$title->isSpecial('ThemeDesignerPreview')
				) {
					$pageType = wfMessage( 'oasis-page-header-subtitle-special' )->escaped();
				}
				break;

			case NS_CATEGORY:
				$pageType = wfMessage( 'oasis-page-header-subtitle-category' )->escaped();
				break;

			case NS_FORUM:
				$pageType = wfMessage( 'oasis-page-header-subtitle-forum' )->escaped();
				break;
		}
		//Todo: do not pass $this, or maybe whole hook?
		//wfRunHooks( 'PageHeaderPageTypePrepared', [ $this, $this->getContext()->getTitle() ] );

		return $pageType;
	}

	/**
	 * support for language variants
	 * this adds links which automatically convert the content to that variant
	 *
	 * @author tor@wikia-inc.com
	 * @author macbre@wikia-inc.com
	 */
	private function languageVariants() {

		$variants = $this->skinTemplate->get( 'content_navigation' )['variants'];

		if ( !empty( $variants ) ) {
			foreach ( $variants as $variant ) {
				$subtitle[] = Xml::element(
					'a',
					[
						'href' => $variant['href'],
						'rel' => 'nofollow',
						'id' => $variant['id'],
					],
					$variant['text']
				);
			}
		}

		return $variants;
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

		//if ( !$isPreview && !$isShowChanges ) {
			return \Wikia::link(
				$title,
				wfMessage( 'oasis-page-header-back-to-article' )->escaped(),
				[ 'accesskey' => 'c' ],
				[ ],
				'known'
			);
		//}

	}

	private function getSubPageLinks() {
		return \RequestContext::getMain()->getSkin()->subPageSubtitle();
	}

	/**
	 * render pageType, pageSubject and pageSubtitle as one message
	 *
	 * @return string
	 */
	private function handlePageSubtitle() {
		$additional = '';
		wfRunHooks('BeforePageHeaderSubtitle', [&$additional]);

		$subtitle = array_filter( [
			$this->getPageType(),
			$this->handleTalkPage(),
			$this->getSubject(),
			$this->getSubPageLinks(),
			$additional
		] );

		$pipe = wfMessage( 'pipe-separator' )->escaped();

		return implode( " {$pipe} ", $subtitle );
	}

}
