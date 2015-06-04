<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

abstract class BlogPostController extends EmailController {

	/** @var \Title */
	protected $pageTitle;

	/** @var \Title */
	protected $postTitle;

	public function initEmail() {
		// This title is for the BlogListing page where a new blog post was just added/updated
		$titleText = $this->request->getVal( 'pageTitle' );
		$titleNamespace = $this->request->getVal( 'namespace' );

		$this->pageTitle = \Title::newFromText( $titleText, $titleNamespace );

		// This revision ID is for the blog post
		$childArticleID = $this->getVal( 'childArticleID', false );
		if ( $childArticleID ) {
			$this->postTitle = \Title::newFromID( $childArticleID, \Title::GAID_FOR_UPDATE );
		}

		$this->assertValidParams();
	}

	/**
	 * Validate the params passed in by the client
	 */
	private function assertValidParams() {
		$this->assertValidTitle();
		$this->assertValidPostTitle();
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidTitle() {
		if ( !$this->pageTitle instanceof \Title ) {
			throw new Check( "Invalid value passed for title" );
		}

		if ( !$this->pageTitle->exists() ) {
			throw new Check( "Title doesn't exist." );
		}
	}

	/**
	 * @throws \Email\Check
	 */
	private function assertValidPostTitle() {
		if ( !$this->postTitle instanceof \Title ) {
			$articleID = $this->getVal( 'childArticleID', false );
			throw new Check( "Could not find post for article ID '$articleID' given by childArticleID" );
		}

		if ( !$this->postTitle->exists() ) {
			throw new Check( "Post doesn't exist." );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getSummary(),
			'detailsHeader' => $this->getDetailsHeader(),
			'details' => $this->getDetails(),
			'buttonText' => $this->getPostLabel(),
			'buttonLink' => $this->getPostLink(),
			'contentFooterMessages' => [
				$this->getPostListingLink(),
			],
			'hasContentFooterMessages' => true
		] );
	}

	protected function getSummary() {
		$blogURL = $this->pageTitle->getFullURL();
		$listingTitle = $this->pageTitle->getText();

		return wfMessage( $this->getSummaryKey(), $blogURL, $listingTitle )
			->inLanguage( $this->targetLang )
			->parse();
	}

	abstract protected function getSummaryKey();

	protected function getDetails() {
		$article = \Article::newFromTitle( $this->postTitle, \RequestContext::getMain() );
		$service = new \ArticleService( $article );
		$snippet = $service->getTextSnippet();

		return $snippet;
	}

	protected function getDetailsHeader() {
		$post = $this->postTitle;
		return $post->getSubpageText();
	}

	protected function getPostLabel() {
		return wfMessage( 'emailext-blogpost-link-label')
			->inLanguage( $this->targetLang )
			->parse();
	}

	protected function getPostLink() {
		$post = $this->postTitle;
		return $post->getFullURL();
	}

	protected function getFooterMessages() {
		$parentUrl = $this->pageTitle->getFullURL( 'action=unwatch' );
		$parentTitleText = $this->pageTitle->getPrefixedText();

		$footerMessages = [
			wfMessage( 'emailext-unfollow-text', $parentUrl, $parentTitleText )
				->inLanguage( $this->targetLang )
				->parse()
		];
		return array_merge( $footerMessages, parent::getFooterMessages() );
	}

	protected function getPostListingLink() {
		$url = $this->pageTitle->getFullURL();
		$name = $this->pageTitle->getText();

		return wfMessage( 'emailext-blogpost-view-all', $url, $name )
			->inLanguage( $this->targetLang )
			->parse();
	}

	/**
	 * Form fields required for this email for Special:SendEmail. See
	 * EmailController::getEmailSpecificFormFields for more info.
	 * @return array
	 */
	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'currentRevId',
					'label' => "Post Revision ID"
				]
			]
		];

		return $formFields;
	}
}

/**
 * Class UserBlogPostController
 *
 * This class represents emails sent for updates to a user blog, i.e., in the
 * "User_blog:XXX" namespace.
 *
 * @package Email\Controller
 */
class UserBlogPostController extends BlogPostController {
	public function getSubject() {
		$authorName = $this->getCurrentUserName();
		$postTitle = $this->postTitle->getSubpageText();

		return wfMessage( 'emailext-blogpost-user-subject', $authorName, $postTitle )
			->inLanguage( $this->targetLang )
			->text();
	}

	protected function getSummaryKey() {
		return 'emailext-blogpost-user-summary';
	}
}

/**
 * Class ListBlogPostController
 *
 * This class represents emails sent for updates to a blog listing page, i.e. in
 * the "Blog:XXX" namespace
 *
 * @package Email\Controller
 */
class ListBlogPostController extends BlogPostController {
	public function getSubject() {
		$authorName = $this->getCurrentUserName();
		$listingTitle = $this->pageTitle->getText();
		$postTitle = $this->postTitle->getSubpageText();

		return wfMessage( 'emailext-blogpost-list-subject', $authorName, $listingTitle, $postTitle )
			->inLanguage( $this->targetLang )
			->text();
	}

	protected function getSummaryKey() {
		return 'emailext-blogpost-list-summary';
	}
}