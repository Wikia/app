<?php

class Answer {

	public $title;
	static $special_categories = array();

	function __construct( Title $title ){
		$this->title = $title;
	}

	public static function newFromTitle( $title ){
		$a = new Answer( $title );
		return $a;
	}

	public function isQuestion( $check_exists = false, $check_action = true ){
		if( $check_exists ){
			if( $this->title->getArticleID() == 0 )return false;
		}
		if( $check_action ){
			global $wgRequest;

			$action = $wgRequest->getVal('action', 'view');

			if ( !in_array($action, array('view', 'purge')) ) {
				return false;
			}
		}
		if( $this->title->getText() == wfMsgForContent("mainpage") )return false;
		if( $this->title->getNamespace() == NS_MAIN )return true;
		return false;
	}

	protected static function setSpecialCategories() {
		self::$special_categories = array(
			'unanswered' => wfMsgForContent("unanswered_category"),
			'answered' => wfMsgForContent("answered_category")
		);
	}

	public static function getSpecialCategory( $category_key ){
		self::setSpecialCategories();
		return self::$special_categories[ $category_key ];
	}

	public static function getSpecialCategoryTag( $category_key ){
		global $wgContLang;
		$category_tag = "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . self::getSpecialCategory($category_key) . "]]";
		return $category_tag;
	}

	public function stripCategories( $content ){
		global $wgContLang;
		$content =  preg_replace("@\[\[" . $wgContLang->getNsText( NS_CATEGORY ) . ":[^\]]*?].*?\]@si", '', $content);
		$content = trim( $content );
		return $content;
	}

	public function stripImages( $content ){
		global $wgContLang;
		$content =  preg_replace("@\[\[" . $wgContLang->getNsText( NS_IMAGE ) . ":[^\]]*?].*?\]@si", '', $content);
		$content = trim( $content );
		return $content;
	}

	public function stripInterlang( $content ){
		global $wgContLang;
		$lang_mask = "(" . join("|", array_keys(Language::getLanguageNames())) . ")";
		$content =  preg_replace("@\[\[" . $lang_mask . ":[^\]]*?].*?\]@si", '', $content);
		$content = trim( $content );
		return $content;
	}

	public function isArticleAnswered(){
		global $wgContLang;

		if( !self::isQuestion() )return false;

		$article = new Article( $this->title );
		$content = $article->getContent();

		return self::isContentAnswered( $content );
	}

	public function getDeletionTemplateName(){
		$delete_name_title = Title::makeTitle( NS_MEDIAWIKI, "DeleteTemplate");
		$delete_name_article = new Article( $delete_name_title );
		$delete_template = $delete_name_article->followRedirect();
		if( is_object( $delete_template ) ){
			return $delete_template->getText();
		}
		return false;
	}

	public static function isMarkedForDeletion( $content ){
		$marked = preg_match('/\s{{' . self::getDeletionTemplateName() . '(\|.*?)?}}/i', $content );
		if( $marked ){
			return true;
		}else{
			return false;
		}

	}

	public static function isContentAnswered( $content ){
		$content = self::stripCategories( $content );
		$content = self::stripImages( $content );
		$content = self::stripInterlang( $content );
		if( $content != "" ){
			return true;
		}else{
			return false;
		}
	}

	function getOriginalAuthor(){
		global $wgMemc;

		$page_title_id = $this->title->getArticleID();

		$key = wfMemcKey('answer_author', $page_title_id, 3);
		$data = $wgMemc->get( $key );

		$author = array();
		if (empty($data)) {
			wfDebug( "loading author for question {$page_title_id} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );

			$params['ORDER BY'] = "rev_id  ASC";
			$params['LIMIT'] = 1;
			$row = $dbr->selectRow( 'revision',
					array( 'rev_user', 'rev_timestamp' ),
					array( 'rev_page' =>  $page_title_id )
					, __METHOD__,
					$params
			);

			$userName = User::newFromId( $row->rev_user )->getName();
			$avatarImg = AvatarService::renderAvatar( $userName, 30 );

			$user_title = Title::makeTitle( NS_USER, $userName );

			$author = array( "user_id" => $row->rev_user, "user_name" => $userName, "title" => $user_title, "avatar" => $avatarImg, "ts" => $row->rev_timestamp );

			$wgMemc->set( $key, $author, 60 * 60 );
		}else{
			wfDebug( "loading author for question for page {$page_title_id} from cache\n" );
			$author = $data;
		}
		return $author;
	}

	public function getContributors() {
		return AttributionCache::getInstance()->getArticleContribs($this->title);
	}

	public static function getUserEditPoints($user_id) {
		return AttributionCache::getInstance()->getUserEditPoints($user_id);
	}

	/**
	 * Convenience function for getting the non-image version of the badge.
	 */
	public static function getSmallUserBadge($userData){
		return self::getUserBadge($userData, false);
	}

	/**
	 * Given an array of user-data, returns the HTML for a badge representation.  If largeFormat is true (default),
	 * then the larger format including the avatar image will be used; otherwise, a compact version will be used.
	 *
	 * The userData is expected to be an associative array containing the keys 'user_id', 'user_name', and 'edits'.
	 */
	public static function getUserBadge($userData, $largeFormat = true){
		$ret = "";

		// get avatar
		$ret .= Xml::openElement('div', array('class' => 'userInfoBadge'));
		if($largeFormat){
			$ret .= Xml::openElement('div', array('class' => 'userInfoBadgeAvatarWrapper'));
			$avatarImg = AvatarService::renderAvatar($userData['user_id'], 50);
			$ret .= $avatarImg;
			$ret .= Xml::closeElement('div');
		}

		// render user info
		$class = "userInfo";
		$class .= ($largeFormat?"":" userInfoNoAvatar");
		$ret .= Xml::openElement('div', array('class' => $class));

		if ($userData['user_name'] == 'helper') {
			// anonymous users
			$ret .= Xml::element('span', array('class' => 'userPageLink'), wfMsg('unregistered'));
			$ret .= Xml::element('span', array('class' => 'anonEditPoints'), wfMsgExt('anonymous_edit_points', array('parsemag'), array($userData['edits'])));
		} else {
			// link to user page
			$userPage = Title::newFromText($userData['user_name'], NS_USER);
			$userPageLink = !empty($userPage) ? $userPage->getLocalUrl() : '';

			if($largeFormat){
				$ret .= Xml::element('a', array('href' => $userPageLink, 'class' => 'userPageLink'), $userData['user_name']);

				// user points
				$ret .= Xml::openElement('div', array('class' => 'userEditPoints'));
				$ret .= Xml::openElement('nobr');
				$ret .= Xml::element('span', array('class' => "userPoints userDatas-user-points-{$userData['user_id']}", 'timestamp' => wfTimestampNow()), $userData['edits']);
				$ret .= ' '; // space for graceful degradation
				$ret .= wfMsgExt('edit_points', array('parsemag'), array($userData['edits']));
				$ret .= Xml::closeElement('nobr');
				$ret .= Xml::closeElement('div'); // END .userEditPoints
			} else {
				$ret .= Xml::openElement('div', array('style' => 'float:left;'));
				$ret .= Xml::element('a', array('href' => $userPageLink, 'class' => 'userPageLink'), $userData['user_name']);
				$ret .= Xml::closeElement('div'); // END .userEditPoints

				$ret .= ' '; // space for graceful degradation
				$ret .= Xml::element('div', array('class' => "userPoints userDatas-user-points-{$userData['user_id']}",
												  'style' => 'display:inline',
												  'timestamp' => wfTimestampNow()),
											$userData['edits']);
			}
		}

		$ret .= Xml::closeElement('div'); // END .userInfo
		$ret .= Xml::closeElement('div'); // END .userInfoBadge
		return $ret;
	}

	/**
	 * Converts a string to a question (adds language-appropriate question marks).
	 */
	static public function s2q($string) {
		$string = self::q2s($string);

		global $wgCityId;
		if (64026 /* reviews.wikia */ == $wgCityId) return $string;
#if (43965 /* techteam-qa7.wikia */ == $wgCityId) return "¿" . $string . "?";

		global $wgContLang;
		$lang = $wgContLang->getCode();
		if ("es" == $lang) return "¿" . $string . "?";
		if ("fr" == $lang) return $string . " ?";

		return $string . "?";
	}

	/**
	 * Converts a question to a string w/out question marks.
	 */
	static public function q2s($question) {
		return ucfirst(trim($question, "¿? \t\n\r\0\x0B"));
	}
}
