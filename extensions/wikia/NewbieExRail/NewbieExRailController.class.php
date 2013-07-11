<?php
class NewbieExRailController extends WikiaController {

	public function executeIndex() {
		$app = F::app();
		$user = $app->wg->User;

		// basic user info
		$this->userName = $user->getName();
		$this->userEmail = $user->getEmail();
		$this->userEditCount = $user->getEditCount();

		// get url to user profile page
		$title = $user->getUserPage();
		// fall back to # for non Title class instances
		$this->userPageUrl = ($title instanceof Title) ? $title->getLocalURL() : '#';

		// get full url to special page: Contributions
		$spPage =  F::build('specialPage', array('Contributions', NS_SPECIAL));
		$spPageTitle = ($spPage instanceof specialPage) ? $spPage->getTitle() : '';
		$contribUrl = ($spPageTitle instanceof Title) ? $spPageTitle->getLocalURL() : '#';
		$this->userContributionsLink = $contribUrl.'/'.$this->userName;
	}
}
