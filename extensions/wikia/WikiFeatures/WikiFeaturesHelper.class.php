<?php

/**
 * Wiki Features Helper
 * @author Hyun
 * @author Owen
 * @author Saipetch
 */
class WikiFeaturesHelper extends WikiaModel {

	protected static $instance = NULL;

	const FEEDBACK_FREQUENCY = 60;

	/**
	 * @var array with feedback categories and its title and priority
	 */

	public static $feedbackCategories = array(
		0 => array('title' => null, 'msg' => 'wikifeatures-category-choose-one'),
		1 => array('title' => 'Love', 'msg' => 'wikifeatures-love-this-project'),
		2 => array('title' => 'Hate', 'msg' => 'wikifeatures-hate-this-project'),
		3 => array('title' => 'Problem', 'msg' => 'wikifeatures-problem-with-project'),
		4 => array('title' => 'Idea', 'msg' => 'wikifeatures-an-idea-for-project'),
	);

	// These numbers are totally arbitrary and not used for anything other than to exist in this array.  This mostly
	// exists to verify that feedback from labs is for a known feature.
	public static $feedbackAreaIDs = array (
		'wgEnableAjaxPollExt' => 280,
		'wgShowTopListsInCreatePage' => 199,
		'wgEnableAchievementsExt' => 247,
		'wgEnableBlogArticles' => 281,
		'wgEnableArticleCommentsExt' => 200,
		'wgEnableCategoryExhibitionExt' => 201,
		'wgEnableChat' => 258,
		'wgEnableWallExt' => 258,
		'wgEnableForumExt' => 259,
		'wgEnableWikiaInteractiveMaps' => 260,
		'wgEnableMediaGalleryExt' => 1
	);

	// no need to add feature to $release_date if not require "new" flag
	public static $release_date = array (
		'wgEnableChat' => '2011-08-01',
		'wgShowTopListsInCreatePage' => '2012-02-12',
		'wgEnableAchievementsExt' => '2012-02-12',
		'wgEnableForumExt' => '2012-11-29',
		'wgEnableWikiaInteractiveMaps' => '2014-07-23',
	);

	/**
	 * @static
	 * @return WikiFeaturesHelper
	 */
	public static function getInstance() {
		if (self::$instance === NULL) {
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	/**
	 * @desc get a list of regular features
	 * @return array $list
	 */
	public function getFeatureNormal() {
		$list = array();

		if (isset($this->wg->WikiFeatures['normal']) && is_array($this->wg->WikiFeatures['normal'])) {
			//allow adding features in runtime
			wfrunHooks( 'WikiFeatures::onGetFeatureNormal' );

			foreach ($this->wg->WikiFeatures['normal'] as $feature) {
				$list[] = array(
					'name' => $feature,
					'enabled' => $this->getFeatureEnabled($feature),
					'imageExtension' => '.png'
				);
			}
		}
		return $list;
	}

	/**
	 * @desc get a list of labs features
	 * @return array $list
	 */
	public function getFeatureLabs() {
		$list = array();
		if (isset($this->wg->WikiFeatures['labs']) && is_array($this->wg->WikiFeatures['labs'])) {
			//allow adding features in runtime
			wfrunHooks( 'WikiFeatures::onGetFeatureLabs' );

			foreach ($this->wg->WikiFeatures['labs'] as $feature) {
				$list[] = array(
					'name' => $feature,
					'enabled' => $this->getFeatureEnabled($feature),
					'new' => self::isNew($feature),
					'active' => $this->wg->Lang->formatNum( $this->getNumActiveWikis( $feature ) ),
					'imageExtension' => '.png'
				);
			}
		}
		return $list;
	}

	/**
	 * @desc get number of active wikis for specified feature
	 * @param string $feature
	 * @return int $num
	 */
	protected function getNumActiveWikis($feature) {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemcKeyNumActiveWikis($feature);
		$num = $this->wg->Memc->get($memKey);
		if ( !is_numeric($num) ) {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);

			$result = $db->selectRow(
				array('city_variables_pool', 'city_variables'),
				'count(distinct cv_city_id) as cnt',
				array('cv_name' => $feature),
				__METHOD__,
				array(),
				array(
					'city_variables' => array(
						'LEFT JOIN',
						array('cv_id=cv_variable_id', 'cv_value' => serialize(true))
					)
				)
			);

			$num = ($result) ? intval($result->cnt) : 0 ;
			$this->wg->Memc->set($memKey, $num, 3600*24);
		}

		wfProfileOut( __METHOD__ );

		return intval($num);
	}

	/**
	 * @desc get memcache key of the number of active wikis for specified feature
	 * @param string $feature
	 * @return string
	 */
	public function getMemcKeyNumActiveWikis($feature) {
		return wfSharedMemcKey('wikifeatures', 'active_wikis', $feature);
	}

	protected function getFeatureEnabled($feature) {
		if ($this->app->getGlobal($feature)==true)
			return true;
		else
			return false;
	}

	/**
	 * @desc checks if this is new or not (new if release_date <= 14 days). Note: return false if not in the $release_date.
	 * @param string $feature
	 * @return boolean
	 */
	protected static function isNew($feature) {
		$result = false;
		if (isset(self::$release_date[$feature])) {
			$release = strtotime(self::$release_date[$feature]);
			if ($release != false) {
				if (floor((time()-$release)/86400) < 15)
					$result = true;
			}
		}

		return $result;
	}

	/**
	 * @brief checks if this is not a spam attempt
	 *
	 * @param string $userName name retrived from user object
	 * @param string $feature name of wikifeatures variable
	 *
	 * @return true | Array array when an error occurs
	 */
	public function isSpam($userName, $feature) {

		// it didn't work without urlencode($userName) maybe because of multibyte signs
		$memcKey = wfMemcKey('wikifeatures', urlencode($userName), $feature, 'spamCheckTime' );
		$result = $this->wg->Memc->get($memcKey);

		if( empty($result) ) {
			$this->wg->Memc->set($memcKey, true, self::FEEDBACK_FREQUENCY);
			return false;
		} else {
			return true;
		}
	}


	/**
	 * Helper that actually sends the feedback to a specified e-mail address
	 *
	 * @param string $feature name of the feature
	 * @param string $message feedback message
	 * @param User $user user object
	 * @param integer $feedbackCat feedback category which is defined above in $feedbackCategories property
	 *
	 * @return \Status
	 */
	public function sendFeedback( $feature, $user, $message, $category, $priority = 5 ) {

		$title = $feature .' - '.self::$feedbackCategories[$category]['title'];

		$message = <<<MSG
User name: {$user->getName()}
Wiki name: {$this->app->getGlobal('wgSitename')}
Wiki address: {$this->app->getGlobal('wgServer')}
Feature: $feature

$message
MSG;

		$message .= "\n\n---\nBrowser data: " . $_SERVER['HTTP_USER_AGENT'];

		$mailUser = new MailAddress( $user->getEmail() );
		$mailCommunity = new MailAddress( $this->wg->SpecialContactEmail, 'Wikia Support' );

		return UserMailer::send( $mailCommunity, $mailUser, $title, $message, $mailUser, null, 'WikiFeatures' );
	}

}
