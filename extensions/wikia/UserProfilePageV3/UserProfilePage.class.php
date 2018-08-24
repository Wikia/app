<?php

class UserProfilePage {

	const INTERVIEW_PAGE_TITLE = 'Interview';

	/**
	 * @var WikiaApp
	 */
	private $app = null;
	/**
	 * user object
	 * @var User
	 */
	private $user = null;

	public function __construct( User $user, WikiaApp $app = null ) {
		if ( is_null( $app ) ) {
			$app = F::app();
		}
		$this->app = $app;
		$this->user = $user;
	}
	protected function getInterviewArticle() {
		$title = Title::makeTitle( NS_USER, $this->user->getName() . '/' . self::INTERVIEW_PAGE_TITLE );
		return new Article( $title );
	}

	protected function invalidateCache() {
		$title = $this->user->getUserPage();
		$title->invalidateCache();
		$title->purgeSquid();

		$article = new Article( $title );
		$article->doPurge();
	}

}
