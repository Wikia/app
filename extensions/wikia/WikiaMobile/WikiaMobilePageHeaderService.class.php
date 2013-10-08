<?php
/**
 * WikiaMobile page header
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobilePageHeaderService extends WikiaService {
	static $skipRendering = false;

	static function setSkipRendering( $value = false ){
		self::$skipRendering = $value;
	}

	/**
	 * @var array Holding namespaces for which first part of title should not be displayed
	 * ie Blog:Me/Test -> Test
	 */
	private $namespaces = [
		NS_BLOG_ARTICLE,
		NS_BLOG_ARTICLE_TALK,
		NS_BLOG_LISTING,
		NS_BLOG_LISTING_TALK
	];
	/**
	 * Function to remove first part of title
	 * ie Blog:Me/Test -> Test
	 *
	 * @param String $title
	 *
	 * @return string
	 */
	function getTitleText( $title, $namespace ){
		if ( in_array( $namespace, $this->namespaces ) ) {
			$titleParts = explode( '/', $title );
			array_shift( $titleParts );
			return implode( '/', $titleParts );
		}

		return $title;
	}

	public function index() {
		if ( self::$skipRendering ) {
			return false;
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$out = $this->wg->Out;
		$titleText = $out->getPageTitle();
		$title = $out->getTitle();
		$namespace = ($title instanceof Title) ? $title->getNamespace() : -1;

		$this->response->setVal( 'pageTitle', $this->getTitleText( $titleText, $namespace ) );

		$article = $this->wg->Article;

		if ( $article instanceof Article ) {
			$revision = $article->getPage()->getRevision();

			$user = User::newFromId( $revision->getRawUser() );

			$userName = $user->getName();

			if ( User::isIP( $userName ) ) {
				//For anonymous users don't display IP
				$userName = wfMessage( 'wikiamobile-anonymous-edited-by' )->text();
			} else {
				//Wrap username in a link to user page
				$userName = '<a href="' . $user->getUserPage()->getFullURL() . '">' . $userName . '</a>';
			}

			$this->response->setVal(
				'lastEdited',
				wfMessage( 'wikiamobile-last-edited-by' )
					->params( $userName, $this->wg->Lang->date( $revision->getTimestamp() ) )
					->text()
			);
		}

		return true;
	}
}
