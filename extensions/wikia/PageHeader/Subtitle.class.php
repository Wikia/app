<?php

namespace Wikia\PageHeader;

use AvatarService;
use FakeSkin;
use Html;
use PageStatsService;
use RequestContext;
use Title;
use WikiaApp;

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
	 * @var Title
	 */
	private $title;

	/**
	 * @var bool
	 */
	private static $onEditPage = false;

	public function __construct( WikiaApp $app ) {
		$this->suppressPageSubtitle = $app->wg->SuppressPageSubtitle;
		$this->request = RequestContext::getMain()->getRequest();
		$this->skinTemplate = $app->getSkinTemplateObj();
		$this->title = RequestContext::getMain()->getTitle();

		if ( !$this->suppressPageSubtitle ) {
			$this->subtitle = $this->getSubtitle( $app );
			//watch list uses that, pageSubject?
			$this->pageSubtitle = $this->getPageSubtitle();
		}
	}

	/**
	 * Detect we're on edit (or diff) page
	 *
	 * @return bool
	 */
	public static function isEditPage() {
		$request = RequestContext::getMain()->getRequest();

		return !empty( Hooks::$onEditPage ) ||
			!is_null( $request->getVal( 'diff' ) ) ||
			in_array(
				$request->getVal( 'action', 'view' ),
				[
					/* view source page */
					'edit',
					/* SMW edit pages */
					'formedit',
					/* history pages */
					'history',
					/* conflicts, etc */
					'submit'
				]
			);
	}

	private function getSubtitle( WikiaApp $app ) {
		$output = RequestContext::getMain()->getOutput();

		if ( self::isEditPage() ) {
			return $this->getEditPageSubtitle();
		} else if ( defined( 'NS_BLOG_ARTICLE' ) && $this->title->getNamespace() === NS_BLOG_ARTICLE ) {
			return $this->getBlogArticleSubtitle( $app );
		}

		return $output->getSubtitle();
	}

	private function getEditPageSubtitle() {
		$wgOutput = RequestContext::getMain()->getOutput();

		$subtitle = [
			$this->getBackLink(),
			$wgOutput->getSubtitle(),
		];

		if ( $this->request->getVal( 'action', 'view' ) === 'history' ) {
			$sk = new FakeSkin();
			$sk->setRelevantTitle( $this->title );

			$undeleteLink = $sk->getUndeleteLink();
			if ( $undeleteLink ) {
				$subtitle[] = $undeleteLink;
			}
		}

		$pipe = wfMessage( 'pipe-separator' )->escaped();

		return implode( $pipe, $subtitle );
	}

	private function getTalkPageBackLink() {
		if ( $this->title->isTalkPage() ) {
			$namespace = $this->title->getNamespace();

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
				$this->title->getSubjectPage(),
				wfMessage( $msgKey )->escaped(),
				[ 'accesskey' => 'c' ]
			);
		}

		return null;
	}

	private function getPageType() {
		$namespace = $this->title->getNamespace();

		$pageType = null;

		if ( $namespace === NS_MEDIAWIKI ) {
			$pageType = wfMessage( 'page-header-subtitle-mediawiki' )->escaped();
		} else if ( $namespace === NS_TEMPLATE ) {
			$pageType = wfMessage( 'page-header-subtitle-template' )->escaped();
		} else if (
			$namespace === NS_SPECIAL &&
			!$this->title->isSpecial( 'Forum' ) &&
			!$this->title->isSpecial( 'ThemeDesignerPreview' )
		) {
			$pageType = wfMessage( 'page-header-subtitle-special' )->escaped();
		} else if ( $namespace === NS_CATEGORY ) {
			$pageType = wfMessage( 'page-header-subtitle-category' )->escaped();
		} else if ( $namespace === NS_FORUM ) {
			$pageType = wfMessage( 'page-header-subtitle-forum' )->escaped();
		} else if ( defined( 'NS_BLOG_LISTING' ) && $namespace === NS_BLOG_LISTING ) {
			$pageType = wfMessage( 'page-header-subtitle-blog-category' )->escaped();
		}

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

	// FIXME
	private function getSubject() {
		return null;
	}

	/**
	 * back to article link
	 * @return string
	 */
	private function getBackLink() {
		return \Wikia::link(
			$this->title,
			wfMessage( 'oasis-page-header-back-to-article' )->escaped(),
			[ 'accesskey' => 'c' ],
			[],
			'known'
		);
	}

	private function getSubPageLinks() {
		return RequestContext::getMain()->getSkin()->subPageSubtitle();
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

	private function getBlogArticleSubtitle( WikiaApp $app ) {
		$language = RequestContext::getMain()->getLanguage();

		$userName = $this->title->getBaseText();
		$avatar = AvatarService::renderAvatar( $userName, 30 );
		$userPageUrl = AvatarService::getUrl( $userName );
		$userBlogPageUrl = AvatarService::getUrl( $userName, NS_BLOG_ARTICLE );
		$namespaceText = $language->getFormattedNsText( $this->title->getNamespace() );
		$userBlogPageText = $namespaceText . ':' . $userName;
		$pageStatsService = new PageStatsService( $this->title->getArticleId() );
		$pageCreatedDate = $language->date( $pageStatsService->getFirstRevisionTimestamp() );

		return $app->renderPartial('Wikia\PageHeader\PageHeader', 'subtitle_blogPost', [
			'avatar' => $avatar,
			'pageCreatedDate' => $pageCreatedDate,
			'userName' => $userName,
			'userPageUrl' => $userPageUrl,
			'userBlogPageUrl' => $userBlogPageUrl,
			'userBlogPageText' => $userBlogPageText,
		] );
	}
}
