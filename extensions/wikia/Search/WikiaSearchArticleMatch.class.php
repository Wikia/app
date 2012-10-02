<?php 

class WikiaSearchArticleMatch {
	
	/**
	 * The original article match
	 * @var Article
	 */
	private $article;
	
	/**
	 * The article the original article redirected to
	 * @var Article
	 */
	private $redirect;
	
	/**
	 * Accepts an article and performs all necessary logic to also store a redirect
	 * @param Article $article
	 */
	public function __construct( Article $article ) {
		$this->article = $article;
		if ( $article->isRedirect() ) {
			$target = $article->getRedirectTarget();
			if ( $target instanceOf Title ) {
				$this->redirect = F::build( 'Article', array( $target ) );
			}
		}
	}
	
	/**
	 * Says whether we found a redirect during construct
	 * @return boolean
	 */
	public function hasRedirect() {
		return $this->redirect !== null;
	}
	
	/**
	 * Returns the canonical article
	 * @return Article
	 */
	public function getArticle() {
		return $this->hasRedirect() ? $this->redirect : $this->article;
	}
	
	/**
	 * Always returns the article passed during construction
	 * @return Article
	 */
	public function getOriginalArticle() {
		return $this->article;
	}
	
	/**
	 * Always returns the redirect, if there is one
	 * @return Article|null
	 */
	public function getRedirect() {
		return $this->redirect;
	}
}