<?php

class UserIdentityBox {
	/**
	 * Used in User Profile Page extension; 
	 * It's a kind of category of rows stored in page_wikia_props table 
	 * -- it's a value of propname column;
	 * If a data row from this table has this field set to 10 it means that
	 * in props value you should get an unserialized array of wikis' ids.
	 * 
	 * @var integer
	 */
	const PAGE_WIKIA_PROPS_PROPNAME = 10;
	
	private $user = null;
	private $app = null;
	private $title = null;
	private $hiddenWikis = null;
	private $topWikisLimit = 5;
	
	/**
	 * @param WikiaApp $app wikia appliacation object
	 * @param User $user core user object
	 * @param integer $topWikisLimit limit of top wikis
	 */
	public function __construct(WikiaApp $app, $user, $topWikisLimit) {
		$this->app = $app;
		$this->user = $user;
		$this->topWikisLimit = $topWikisLimit;
		
		if( is_null($this->app->wg->Title) ) {
			$this->app->wg->Title = $this->user->getUserPage();
		}
		
		$this->title = $this->app->wg->Title;
	}
	
	/**
	 * Creates an array with user's data
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function setData() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$userName = $this->user->getName();
		
		$data = array();
		$data['id'] = $this->user->getId();
		$data['avatar'] = F::build( 'AvatarService', array( $userName, 150 ), 'getAvatarUrl' );
		$data['name'] = $userName;
		$data['realName'] = $this->user->getRealName();
		$data['userPage'] = $this->user->getUserPage()->getFullURL();
		$data['location'] = $this->user->getOption('location');
		$data['occupation'] = $this->user->getOption('occupation');
		$data['gender'] = $this->user->getOption('UserProfilePagesV3_gender');
		$data['registration'] = $this->user->getRegistration();
		$data['birthday'] = $this->user->getOption('UserProfilePagesV3_birthday');
		$data['website'] = $this->user->getOption('website');
		$data['twitter'] = $this->user->getOption('twitter');
		$data['fbPage'] = $this->user->getOption('fbPage');
		$data['topWikis'] = $this->getTopWikis();
		
		$iEdits = $this->user->getEditCount();
		$data['edits'] = is_null($iEdits) ? 0 : intval($iEdits);
		
		$this->getUserGroup($data);
		
		$birthdate = $data['birthday'];
		$birthdate = explode('-', $birthdate);
		if( !empty($birthdate[0]) && !empty($birthdate[1]) ) {
			$data['birthday'] = array('month' => $birthdate[0], 'day' => ltrim($birthdate[1], '0'));
		} else {
			$data['birthday'] = '';
		}
		
		$data['showZeroStates'] = $this->checkIfDisplayZeroStates($data);
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $data;
	}
	
	/**
	 * Saves user data
	 * 
	 * @param object $data an user data
	 * 
	 * @return true
	 */
	public function saveUserData($data) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$changed = false;
		$prefix = 'UserProfilePagesV3';
		
		foreach(array('location', 'occupation', 'birthday', 'gender', 'website', 'twitter', 'avatar', 'fbPage') as $option) {
			if( isset($data->$option) ) {
				$data->$option = str_replace('*', '&asterix;', $data->$option);
				$data->$option = $this->app->wg->Parser->parse($data->$option, $this->user->getUserPage(), new ParserOptions($this->user))->getText();
				$data->$option = str_replace('&amp;asterix;', '*', $data->$option);
				$data->$option = strip_tags($data->$option);
				
				//if( in_array($option, array('gender', 'birthday')) ) { -- just an example how can it be used later
				if( $option === 'gender' ) {
					$this->user->setOption($prefix.'_'.$option, $data->$option);
				} else {
					$this->user->setOption($option, $data->$option);
				}
				
				$changed = true;
			}
		}
		
		if( isset($data->month) && isset($data->day) ) {
			$this->user->setOption($prefix.'_birthday', $data->month.'-'.$data->day);
			$changed = true;
		}
		
		if( isset($data->name) ) {
			$this->user->setRealName($data->name);
			$changed = true;
		}
		
		if( true === $changed ) {
			$this->user->saveSettings();
			
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return false;
	}
	
	/**
	 * Gets DB object
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getDb($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type, array(), $this->app->wg->SharedDB);
	}
	
	/**
	 * Gets user group and additionaly sets other user's data (blocked, founder)
	 * 
	 * @param array reference to user data array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getUserGroup(&$data) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$isBlocked = $this->user->getBlockId();
		
		if( empty($isBlocked) ) {
			$data['blocked'] = false;
			
			if( true !== $this->isFounder() ) {
				$group = $this->getUserGroups($this->user);
				if( false !== $group ) {
					$data['group'] = $this->app->wf->Msg('user-identity-box-group-'.$group);
				} else {
					$data['group'] = '';
				}
			} else {
				$data['group'] = $this->app->wf->Msg('user-identity-box-group-founder');
			}
		} else {
			$data['group'] = $this->app->wf->Msg('user-identity-box-group-blocked');
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Returns false if any of "important" fields is not empty -- then it means not to display zero states
	 * 
	 * @param array reference to user data array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function checkIfDisplayZeroStates($data) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$result = true;
		$fieldsToCheck = array('location', 'occupation', 'birthday', 'gender', 'website', 'twitter', 'topWikis');
		
		foreach($data as $property => $value) {
			if( in_array($property, $fieldsToCheck) && !empty($value) ) {
				$result = false;
				break;
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $result;
	}
	
	/**
	 * @brief Gets string with user most important group
	 * 
	 * @return string | false
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getUserGroups() {
		$this->app->wf->ProfileIn( __METHOD__ );
		$userGroup = '';
		
		$userGroups = $this->user->getEffectiveGroups();
		foreach($userGroups as $group) {
			//most important -- admin
			if( $group == 'sysop') {
				$userGroup = 'sysop';
				break;
			}
			
			//less important
			if( $group == 'staff') {
				$userGroup = 'staff';
				break;
			}
			
			if( $group == 'chatmoderator') {
				$userGroup = 'chatmoderator';
				break;
			}
		}
		
		if( empty($userGroup) ) {
		//just a member
			$this->app->wf->ProfileOut( __METHOD__ );
			return false;
		} else {
			$this->app->wf->ProfileOut( __METHOD__ );
			return $userGroup;
		}
	}
	
	/**
	 * @brief Gets top edited wikis for a user; code from UPP2
	 * 
	 * @param Boolean $refreshHidden a flag which says to clear hidden wikis, by default equals false
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getTopWikis($refreshHidden = false) {
		$this->app->wf->ProfileIn( __METHOD__ );
		$wikis = false;
		
		if ( !$this->user->isAnon() ) {
			$cachedData = $this->app->wg->Memc->get( $this->getMemcTopWikisId() );
			$cachedData = null;
			
			if( !empty( $cachedData) ) {
				$this->app->wf->ProfileOut(__METHOD__);
				return $cachedData;
			}
			
			$where = array( 'user_id' => $this->user->getId() );
			
			if( true === $refreshHidden ) {
				$this->clearHiddenTopWikis();
			} else {
				$hiddenTopWikis = $this->getHiddenTopWikis();
				
				if( count($hiddenTopWikis) ) {
					$where[] = 'wiki_id NOT IN ('.join(',', $hiddenTopWikis).')';
				}
			}
			
			$dbs = $this->app->wf->GetDB(DB_SLAVE, array(), $this->app->wg->StatsDB);
			$res = $dbs->select(
				array( 'specials.events_local_users' ),
				array( 'wiki_id', 'edits' ),
				$where,
				__METHOD__,
				array(
					'ORDER BY' => 'edits DESC',
					'LIMIT' => $this->topWikisLimit
				)
			);
			
			$wikis = array();
			if ( $this->app->wg->DevelEnvironment ) {
			//DevBox test
				$wikis = $this->getTestData();
			} else {
				while( $row = $dbs->fetchObject($res) ) {
					$wikiId = $row->wiki_id;
					$editCount = $row->edits;
					$wikiName = F::build('WikiFactory', array('wgSitename', $wikiId), 'getVarValueByName');
					$wikiUrl = F::build('WikiFactory', array('wgServer', $wikiId), 'getVarValueByName');
					
					$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'editCount' => $editCount );
				}
			}
		}
		
		$this->app->wg->Memc->set( $this->getMemcTopWikisId(), $wikis, 10800 ); // 3h
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $wikis;
	}
	
	/**
	 * @brief Gets memcache id for top wikis
	 */
	private function getMemcTopWikisId() {
		return 'UserProfilePageHelper'.'topWikis'.$this->user->getId().$this->topWikisLimit;
	}
	
	/**
	 * @brief Gets memcache id for hidden wikis
	 */
	private function getMemcHiddenWikisId() {
		return 'UserProfilePageHelper'.'hiddenWikis'.$this->user->getId();
	}
	
	/**
	 * @brief Sets hidden wikis in memc
	 */
	private function setMemcHiddenWikis() {
		$this->app->wg->Memc->set( $this->getMemcHiddenWikisId(), $this->hiddenWikis, 3*60*60);
	}
	
	/**
	 * @brief Clears hidden wikis: the field of this class, DB and memcached data
	 */
	private function clearHiddenTopWikis() {
		$this->hiddenWikis = array();
		$this->updateHiddenInDb( $this->app->wf->GetDB(DB_MASTER, array(), $this->app->wg->ExternalSharedDB), $this->hiddenWikis );
		
		$this->setMemcHiddenWikis();
		$this->app->wg->Memc->delete($this->getMemcTopWikisId());
	}
	
	/**
	 * @brief Gets test data for devboxes
	 * 
	 * @return array
	 */
	private function getTestData() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$wikis = array(
			831 => 60,
			4036 => 35,
			177 => 12,
			1890 => 5
		); //test data
		
		foreach ( $wikis as $wikiId => $editCount ) {
			if( !$this->isTopWikiHidden($wikiId) || ($wikiId == $this->app->wg->CityId) ) {
				$wikiName = F::build('WikiFactory', array('wgSitename', $wikiId), 'getVarValueByName');
				$wikiUrl = F::build('GlobalTitle', array(wfMsgForContent('Mainpage'), NS_MAIN, $wikiId), 'newFromText')->getFullUrl();
				
				$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'editCount' => $editCount );
			} else {
				unset($wikis[$wikiId]);
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $wikis;
	}
	
	/**
	 * @brief gets hidden top wikis; code from UPP2
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getHiddenTopWikis() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		if( empty($this->hiddenWikis) && !is_array($this->hiddenWikis) ) {
			$hiddenWikis = $this->app->wg->Memc->get( $this->getMemcHiddenWikisId() );
			
			if( empty($hiddenWikis) && !is_array($this->hiddenWikis) ) {
				$dbs = $this->app->wf->GetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB);
				$this->hiddenWikis = $this->getHiddenFromDb( $dbs );
				$this->setMemcHiddenWikis();
			} else {
				$this->hiddenWikis = $hiddenWikis;
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $this->hiddenWikis;
	}
	
	/**
	 * @brief adds hidden top wiki; code from UPP2
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function hideWiki($wikiId) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		if( !$this->isTopWikiHidden($wikiId) ) {
			$this->hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( $this->app->wf->GetDB(DB_MASTER, array(), $this->app->wg->ExternalSharedDB), $this->hiddenWikis );
			
			$this->app->wg->Memc->set( $this->getMemcHiddenWikisId(), $this->hiddenWikis, 3*60*60 );
			$this->app->wg->Memc->delete( $this->getMemcTopWikisId() );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * @brief auxiliary method for getting hidden pages/wikis from db
	 * @author ADi
	 */
	private function getHiddenFromDb( $dbHandler ) {
		$this->app->wf->ProfileIn( __METHOD__ );
		$result = false;
		
		if ( !$this->user->isAnon() ) {
			$row = $dbHandler->selectRow(
				array( 'page_wikia_props' ),
				array( 'props' ),
				array( 'page_id' => $this->user->getId() , 'propname' => self::PAGE_WIKIA_PROPS_PROPNAME ),
				__METHOD__,
				array()
			);
			
			if( !empty($row) ) {
				$result = unserialize( $row->props );
			}
			
			$result = empty($result) ? array() : $result;
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $result;
	}
	
	/**
	 * auxiliary method for updating hidden pages in db
	 * @author ADi
	 */
	private function updateHiddenInDb($dbHandler, $data) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$dbHandler->replace(
			'page_wikia_props',
			null,
			array('page_id' => $this->user->getId(), 'propname' => 10, 'props' => serialize($data)),
			__METHOD__
		);
		$dbHandler->commit();
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Checks whenever wiki is in hidden wikis; code from UPP2
	 * 
	 * @param integer $wikiId id of wiki which we want to be chacked
	 * 
	 * @return boolean
	 */
	public function isTopWikiHidden( $wikiId ) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$out = ( in_array($wikiId, $this->getHiddenTopWikis() ) ? true : false );
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $out;
	}
	
	/**
	 * Checks if user is the founder
	 * 
	 * @return boolean
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function isFounder() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$wiki = F::build('WikiFactory', array($this->app->wg->CityId), 'getWikiById');
		
		if( intval($wiki->city_founding_user) === $this->user->GetId() ) {
			$this->app->wf->ProfileOut( __METHOD__ );
			return true;
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return false;
	}
	
}

?>