<?php

class UserProfilePageHelper {
	/**
	 * @brief Get user object from given title
	 *
	 * @desc getUserFromTitle() is sometimes called in hooks therefore I added returnUser flag and when
	 * it is set to true getUserFromTitle() will assign $this->user variable with a user object
	 *
	 * @return User
	 *
	 * @author ADi
	 * @author nAndy
	 */
	static public function getUserFromTitle($title = null) {
		global $UPPNamespaces;

		wfProfileIn(__METHOD__);
		$wg = F::app()->wg;
		if( is_null($title) ) {
			$title = $wg->Title;
		}

		$user = null;
		if ($title instanceof Title && in_array($title->getNamespace(), $UPPNamespaces)) {
			// get "owner" of this user / user talk / blog page
			$parts = explode('/', $title->getText());
		} else {
			if ($title instanceof Title && $title->getNamespace() == NS_SPECIAL && ($title->isSpecial('Following') || $title->isSpecial('Contributions'))) {
				$target = $wg->Request->getVal('target');

				if (!empty($target)) {
					// Special:Contributions?target=FooBar (RT #68323)
					$parts = array($target);
				} else {
					// get user this special page referrs to
					$titleVal = $wg->Request->getVal('title', false);
					$parts = explode('/', $titleVal);

					// remove special page name
					array_shift($parts);
				}

				if ($title->isSpecial('Following') && !isset($parts[0])) {
					//following pages are rendered only for profile owners
					$user = $wg->User;
					wfProfileOut(__METHOD__);
					return $user;
				}
			}
		}


		if (!empty($parts[0])) {
			$userName = str_replace('_', ' ', $parts[0]);
			$user = User::newFromName($userName);
		}

		if (!($user instanceof User) && !empty($userName)) {
			//it should work only for title=User:AAA.BBB.CCC.DDD where AAA.BBB.CCC.DDD is an IP address
			//in previous user profile pages when IP was passed it returned false which leads to load
			//"default" oasis data to Masthead; here it couldn't be done because of new User Identity Box
			$user = new User();
			$user->mName = $userName;
			$user->mFrom = 'name';
		}

		if (!($user instanceof User) && empty($userName)) {
			//this is in case Blog:Recent_posts or Special:Contribution will be called
			//then in title there is no username and "default" user instance is $wgUser
			$user = $wg->User;
		}

		wfProfileOut(__METHOD__);
		return $user;
	}


}