<?php
/**
 *
 */

/*
 *
 * Some changes for UserActivityClass.php from extensions/wikia/UserActivity
 *
 */

class WikiaUserProfileActivity
{

	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	var $user_id_rel;
	var $rel_type;
	var $show_edits = 1;
	var $show_votes = 1;
	var $show_relationships = 1;
	var $show_friends = 1;
	var $show_foes = 0; // FOE OFF default 
	var $show_gifts_sent = 1;
	var $show_gifts_rec = 1;
	var $g_wiki_list;

	var $db_name;
	var $shared_city = false;

	function __construct($username, $filter, $item_max)
	{
		global $wgMessageCache;
		global $wgSharedUserProfile, $wgSharedDB, $wgDBname;
		global $wgCityId;

		$title = Title::newFromDBkey($username);

		require_once ( dirname( __FILE__ ) . '/WikiaUserProfile.i18n.php' );
		foreach( efUserProfile() as $lang => $messages )
		{
			$wgMessageCache->addMessages( $messages, $lang );
		}

		$this->user_name = $title->getText();
		$this->user_id = intval(User::idFromName($this->user_name));
		$this->rel_type = 0;
		$this->show_current_user = false;
		$this->show_all = 0;
		$this->setFilter($filter);
		$this->item_max = $item_max;
		$this->items = array();
		$this->g_wiki_list = array();
		
		$this->db_name = ($wgSharedUserProfile)?$wgSharedDB:$wgDBname;
		
		if (!isset($wgSharedDB))
		{
			#---
			$this->shared_city = $wgCityId;
			#---
			if (empty($wgCityId))
			{
				$this->shared_city = WikiFactory::DBtoID($wgDBname);
			}
		}
	}

	private function setFilter($filter)
	{
		if (strtoupper($filter)=="USER")
			$this->show_current_user = true;
		#---
		if (strtoupper($filter)=="FRIENDS")
			$this->rel_type=1;
		#---
		if (strtoupper($filter)=="FOES")
			$this->rel_type=2;
		#---
		if (strtoupper($filter)=="ALL")
			$this->show_all=true;
	}

	public function setActivityToggle($name,$value)
	{
		$this->$name = $value;
	}

    public function getRelationshipUser($user_id, $rel_type)
    {
    	global $wgMemc;
		wfProfileIn( __METHOD__ );
    	#---
		$key = wfMemcKey( 'user', 'user_profile_relationship_'.$rel_type, intval($user_id) );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_relationship ({$rel_type}) info for {$user_id} from cache\n" );
			$user_id_rel = $data;
		}
		else
		{
			$dbr =& wfGetDB( DB_MASTER );
			$rel_sql = "select r_user_id_relation from {$this->db_name}.user_relationship where r_user_id={$user_id} and r_type={$rel_type}";
			$res = $dbr->query($rel_sql);
			$user_id_rel = array(0 => 0);
			while ($row = $dbr->fetchObject( $res ) )
			{
				$user_id_rel[] = $row->r_user_id_relation;
			}
			$wgMemc->set( $key, $user_id_rel, MEM_CACHE_TIME );
		}
		wfProfileOut( __METHOD__ );
		return $user_id_rel;
	}

	public function getLastEdits()
	{
		global $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		#---
		$last_edits = array();
		#---
		$rel_sql = "";
		$key = wfMemcKey( 'user', 'user_profile_last_edits_'.$this->rel_type.'_'.$this->show_current_user.'_'.$this->item_max, $this->user_id );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_last_edits (type: {$this->rel_type} and current user: {$this->show_current_user}) info for {user id: {$this->user_id} and item_max: {$this->item_max} from cache\n" );
			$last_edits = $data;
		}
		else
		{
			if ($this->rel_type)
			{
				if (empty($this->user_id_rel))
				{
					$this->user_id_rel = $this->getRelationshipUser($this->user_id, $this->rel_type);
				}
				$rel_sql = " and rc_user in ('".implode(',', $this->user_id_rel)."') ";
			}

			$user_sql = "";
			if ($this->show_current_user)
			{
				$user_sql = " and rc_user = {$this->user_id}";
			}

			#---
			$city_where = ($this->shared_city) ? " and rc_city_id = '".$this->shared_city."' " : "";
			#---
			$external = new ExternalStoreDB();
			$dbs = $external->getSlave( "archive1" );
			#---
			$sql = "SELECT rc_city_id, UNIX_TIMESTAMP( rc_timestamp) as item_date, rc_title, rc_user, rc_user_text, rc_comment, rc_id, rc_minor, rc_new, rc_namespace ";
			$sql .= "FROM `dbstats`.`city_recentchanges` where rc_id > 0 {$rel_sql} {$user_sql} {$city_where} ";
			$sql .= "ORDER BY rc_id DESC LIMIT 0," . $this->item_max;

			#echo $sql. "<br>";
			#---
			$res = $dbs->query( $sql );
			while ($row = $dbs->fetchObject( $res ) )
			{
				$last_edits[] = array(
										"id"		=> 0,
										"type"		=> "last_edits",
										"city" 		=> $row->rc_city_id,
										"timestamp"	=> $row->item_date,
										"pagetitle"	=> $row->rc_title,
										"namespace"	=> $row->rc_namespace,
										"username"	=> $row->rc_user_text,
										"userid"	=> $row->rc_user,
										"comment"	=> $this->fixItemComment($row->rc_comment),
										"vote"		=> 0,
										"minor"		=> $row->rc_minor,
										"new"		=> $row->rc_new
									);
			}
			$wgMemc->set( $key, $last_edits, MEM_CACHE_TIME );
		}

		#--
		wfProfileOut( __METHOD__ );
		return $last_edits;
	}

	public function getLastVotes()
	{
		global $wgUser, $wgMemc;
		#---
		wfProfileIn( __METHOD__ );
		$last_votes = array();
		#---
		$key = wfMemcKey( 'user', 'user_profile_last_votes_'.$this->rel_type.'_'.$this->show_current_user.'_'.$this->item_max, $this->user_id );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_last_votes (type: {$this->rel_type} and current user: {$this->show_current_user}) info for {user id: {$this->user_id} and item_max: {$this->item_max} from cache\n" );
			$last_edits = $data;
		}
		else
		{
			$rel_sql = "";
			if ($this->rel_type)
			{
				if (empty($this->user_id_rel))
				{
					$this->user_id_rel = $this->getRelationshipUser($this->user_id, $this->rel_type);
				}
				$rel_sql = " and user_id in ('".implode(',', $this->user_id_rel)."') ";
			}

			$user_sql = "";
			if ($this->show_current_user)
			{
				$user_sql = " and user_id = {$this->user_id}";
			}

			#---
			$city_where = ($this->shared_city) ? " and city_id = '".$this->shared_city."' " : "";
			#---
			$dbs =& wfGetDBStats();
			#---
			$sql = "SELECT city_id, page_id, page_namespace, page_title, user_id, user_name, vote, UNIX_TIMESTAMP(time) as item_date ";
			$sql .= "FROM `dbstats`.`city_page_vote` ";
			$sql .= "WHERE page_id > 0 {$rel_sql} {$user_sql} {$city_where} ORDER BY time DESC LIMIT 0," . $this->item_max;
			#---

			$res = $dbs->query($sql);
			while ($row = $dbs->fetchObject( $res ) )
			{
				$last_votes[] = array(
										"id" 		=> 0,
										"type"		=> "last_votes",
										"city"		=> $row->city_id,
										"timestamp"	=> $row->item_date ,
										"pagetitle"	=> $row->page_title,
										"namespace"	=> $row->page_namespace,
										"username"	=> $row->user_name,
										"userid"	=> $row->user_id,
										"comment"	=> '',
										"vote"		=> $row->vote,
										"minor"		=> 0,
										"new"		=> 0
									);
			}
			$wgMemc->set( $key, $last_votes, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );

		return $last_votes;
	}

	public function getLastGiftsSent()
	{
		global $wgUser, $wgCityId, $wgMemc;
		#---
		wfProfileIn( __METHOD__ );
		$last_gifts_sent = array();
		#---
		$key = wfMemcKey( 'user', 'user_profile_last_gifts_sent_'.$this->rel_type.'_'.$this->show_current_user.'_'.$this->item_max, $this->user_id );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_last_gifts_sent (type: {$this->rel_type} and current user: {$this->show_current_user}) info for {user id: {$this->user_id} and item_max: {$this->item_max} from cache\n");
			$last_gifts_sent = $data;
		}
		else
		{
			$rel_sql = "";
			if ($this->rel_type)
			{
				if (empty($this->user_id_rel))
				{
					$this->user_id_rel = $this->getRelationshipUser($this->user_id, $this->rel_type);
				}
				$rel_sql = " and ug_user_id_to in ('".implode(',', $this->user_id_rel)."') ";
			}

			$user_sql = "";
			if ($this->show_current_user)
			{
				$user_sql = " and ug_user_id_from = {$this->user_id}";
			}

			$dbr =& wfGetDB( DB_SLAVE );

			$sql  = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_user_id_to, ug_user_name_to, UNIX_TIMESTAMP(ug_date) as item_date,gift_name, gift_id ";
			$sql .= "FROM {$this->db_name}.user_gift INNER JOIN {$this->db_name}.gift ON gift_id = ug_gift_id ";
			$sql .= "where 1=1 {$rel_sql} {$user_sql} ";
			$sql .= "ORDER BY ug_id DESC LIMIT 0,{$this->item_max}";

			//echo $sql. "<br>";
			#---
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) )
			{
				$last_gifts_sent[] = array(
											"id"		=> $row->ug_id,
											"type"		=> "gift_sent",
											"city"		=> $wgCityId,
											"timestamp"	=> $row->item_date ,
											"pagetitle"	=> $row->gift_name,
											"namespace"	=> $row->gift_id,
											"username"	=> $row->ug_user_name_to,
											"userid"	=> $row->ug_user_id_to,
											"comment"	=> '',
											"vote"		=> 0,
											"minor"		=> 0,
											"new"		=> 0
										);
			}
			$wgMemc->set( $key, $last_gifts_sent, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );
		#---
		return $last_gifts_sent;
	}

	public function getLastGiftsRec()
	{
		global $wgUser, $wgCityId, $wgMemc;
		#---
		wfProfileIn( __METHOD__ );
		$last_gifts_receive = array();
		#---
		$key = wfMemcKey( 'user', 'user_profile_last_gifts_rec_'.$this->rel_type.'_'.$this->show_current_user.'_'.$this->item_max, $this->user_id );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_last_gifts_rec (type: {$this->rel_type} and current user: {$this->show_current_user}) info for {user id: {$this->user_id} and item_max: {$this->item_max} from cache\n");
			$last_gifts_receive = $data;
		}
		else
		{
			$rel_sql = "";
			if ($this->rel_type)
			{
				if (empty($this->user_id_rel))
				{
					$this->user_id_rel = $this->getRelationshipUser($this->user_id, $this->rel_type);
				}
				$rel_sql = " and ug_user_id_from in ('".implode(',', $this->user_id_rel)."') ";
			}

			$user_sql = "";
			if ($this->show_current_user)
			{
				$user_sql = " and ug_user_id_to = {$this->user_id}";
			}

			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$sql  = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_user_id_to, ug_user_name_to, UNIX_TIMESTAMP(ug_date) as item_date,gift_name, gift_id ";
			$sql .= "FROM {$this->db_name}.user_gift INNER JOIN {$this->db_name}.gift ON gift_id = ug_gift_id ";
			$sql .= "where 1=1 {$rel_sql} {$user_sql} ORDER BY ug_id DESC LIMIT 0,{$this->item_max}";
			#---
			//echo $sql. "<br>";

			$res = $dbr->query($sql);
			while ( $row = $dbr->fetchObject( $res ) )
			{
				$last_gifts_receive[] = array(
												"id"		=> $row->ug_id,
												"type"		=> "gift_rec",
												"city"		=> $wgCityId,
												"timestamp"	=> $row->item_date ,
												"pagetitle"	=> $row->gift_name,
												"namespace"	=> $row->gift_id,
												"username"	=> $row->ug_user_name_from,
												"userid"	=> $row->ug_user_id_from,
												"comment"	=> '',
												"vote"		=> 0,
												"minor"		=> 0,
												"new"		=> 0
											);
			}
			$wgMemc->set( $key, $last_gifts_receive, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );
		#---
		return $last_gifts_receive;
	}

	public function getLastRelationships()
	{
		global $wgUser, $wgCityId, $wgMemc;
		#---
		$last_relationships = array();
		#---
		wfProfileIn( __METHOD__ );
		$last_relationships = array();
		#---
		$key = wfMemcKey( 'user', 'user_profile_last_user_rel_'.$this->rel_type.'_'.$this->show_current_user.'_'.$this->item_max, $this->user_id );
		$data = $wgMemc->get( $key );
		if($data)
		{
			wfDebug( "Got user_profile_last_gifts_rel (type: {$this->rel_type} and current user: {$this->show_current_user}) info for {user id: {$this->user_id} and item_max: {$this->item_max} from cache\n");
			$last_relationships = $data;
		}
		else
		{
			$rel_sql = "";
			if ($this->rel_type)
			{
				if (empty($this->user_id_rel))
				{
					$this->user_id_rel = $this->getRelationshipUser($this->user_id, $this->rel_type);
				}
				$rel_sql = " and r_user_id in ('".implode(',', $this->user_id_rel)."') ";
			}

			$user_sql = "";
			if ($this->show_current_user)
			{
				$user_sql = " and r_user_id = {$this->user_id}";
			}

			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$sql  = "SELECT r_id, r_user_id, r_user_name, r_user_id_relation, r_user_name_relation, r_type, UNIX_TIMESTAMP(r_date) as item_date ";
			$sql .= "FROM {$this->db_name}.user_relationship ";
			$sql .= "WHERE 1=1 {$rel_sql} {$user_sql} ORDER BY r_id DESC LIMIT 0,{$this->item_max}";
			#---
			//echo $sql. "<br>";

			$res = $dbr->query($sql);
			#---
			while ($row = $dbr->fetchObject( $res ) )
			{
				$r_type = ($row->r_type == 1)?"friend":"foe";
				$last_relationships[$r_type][] = array(
														"id"		=> $row->r_id,
														"type"		=> $r_type,
														"city"		=> $wgCityId,
														"timestamp"	=> $row->item_date ,
														"pagetitle"	=> $row->r_user_name_relation,
														"namespace"	=> NS_USER,
														"username"	=> $row->r_user_name_relation,
														"userid"	=> $row->r_user_id_relation,
														"comment"	=> '',
														"vote"		=> 0,
														"minor"		=> 0,
														"new"		=> 0
													);
			}
			$wgMemc->set( $key, $last_relationships, MEM_CACHE_TIME );
		}

		wfProfileOut( __METHOD__ );
		#---
		return $last_relationships;
	}

	public function getActivityList()
	{
		wfProfileIn( __METHOD__ );

		$keys = array();
		if ($this->show_edits)
		{
			$this->items = array_merge($this->items, $this->getLastEdits());
			$keys[] = 'last_edits';
		}
		if ($this->show_votes)
		{
			$this->items = array_merge($this->items, $this->getLastVotes());
			$keys[] = 'last_votes';
		}
		if ($this->show_gifts_sent)
		{
			$this->items = array_merge($this->items, $this->getLastGiftsSent());
			$keys[] = 'gift_sent';
		}
		if ($this->show_gifts_rec)
		{
			$this->items = array_merge($this->items, $this->getLastGiftsRec());
			$keys[] = 'gift_rec';
		}
		if ($this->show_relationships)
		{
			if ($this->show_friends) $keys[] = 'friend';
			if ($this->show_foes) $keys[] = 'foe';
			$rel = $this->getLastRelationships();
			foreach ($rel as $key => $values)
			{
				if (($key == 'friend') && ($this->show_friends))
				{
					$this->items = array_merge($this->items, $values);
					//$keys[] = $key;
				}
				elseif (($key == 'foe') && ($this->show_foes))
				{
					$this->items = array_merge($this->items, $values);
					//$keys[] = $key;
				}
			}
		}

		if ($this->items)
		{
			usort($this->items, '_sort_activity');
		}

		wfProfileOut( __METHOD__ );

		return array(0 => $this->items, 1 => $keys);
	}

	public function getTypeIcon($type)
	{
		switch ($type)
		{
			case "all":
				return "icon_user.gif";
			case "last_edits":
				return "editicon.png";
			case "last_votes":
				return "comment.gif";
			/*case "comment":
				return "comment.gif";*/
			case "gift_sent":
				return "icon_package.gif";
			case "gift_rec":
				return "icon_package_get.gif";
			case "friend":
				return "addedFriendIcon.png";
			case "foe":
				return "addedFoeIcon.png";
			/*case "challenge_sent":
				return "challengeIcon.png";
			case "challenge_rec":
				return "challengeIcon.png";*/
		}
	}

	public function getTypeTitle($type, $item)
	{
		switch ($type)
		{
			case "last_edits":
			case "last_votes": 	$title = Title::makeTitle( $item["namespace"], $item["pagetitle"]); break;
			case "gift_sent": 	$item["to_uname"] = (!empty($item["to_uname"])) ? $item["to_uname"] : ""; 
								$title = Title::makeTitle( NS_USER, $item["to_uname"] ); break;
			case "gift_rec": 	$item["from_uname"] = (!empty($item["from_uname"])) ? $item["from_uname"] : ""; 
								$title = Title::makeTitle( NS_USER, $item["from_uname"] ); 
								break;
			case "friend":
			case "foe": {
							$item["to_uname"] = (empty($item["to_uname"])) ? "" : $item["to_uname"];
							$title = Title::makeTitle( NS_USER, $item["to_uname"] ); 
							break;
						}
		}

		return $title;
	}

	private function getUserPageAvatar ($user_id, $options)
	{
		global $IP, $wgAvatarPath;
		$aAvatar = array();

		$avatar = new WikiaAvatar( $user_id, $options);

		#--- maybe more parameters??
		$aAvatar['img'] = "<img src=\"{$avatar->getAvatarImage()}\" alt=\"".wfMsg('avatar')."\" border=\"0\"/>";

		return $aAvatar;
	}

	public function getTypeActivityTitle($type, $namespace, $title, $username, $userid, $city)
	{
		global $wgUser, $wgCityId, $wgServer, $wgSitename;
		#---
		wfProfileIn( __METHOD__ );

		$href = Title::makeTitle(NS_USER, $this->user_name);
		$user_link = "<a href=\"".$href->getFullURL()."\">".$this->user_name."</a>";

		$title = Title::makeTitle($namespace, $title);
		$user_title = Title::makeTitle( NS_USER  , $username  );
		$user_avatar = new WikiaAvatar($userid, "s");
		$user_title_href = '<a href="' . $user_title->getFullURL() . '" title="' . $username . '">'.$user_avatar->getAvatarImageTag("s") . $username.'</a>';
		#$user_title_2 = Title::makeTitle( NS_USER  , $item["comment"]  );

		#---
		$domain_name = "";
		$domain_url = $wgServer;
		if (($wgCityId != $city) && ($city != 0) && ($wgCityId != 0))
		{
			$domain_name = WikiFactory::getVarValueByName( "wgSitename", $city );
			$domain_server = WikiFactory::getVarValueByName( "wgServer", $city );
			$domain_url = (empty($domain_server)) ? $wgServer : $domain_server;
			$domain_url = ($domain_url == 'http://') ? $wgServer : $domain_url;
		}

		#---
		switch ($type)
		{
			case "last_edits":
			{
				$title2 = $title->getLocalURL();
				if (0 != $title->getNamespace())
				{
					$namespace = Namespace::getCanonicalName($title->getNamespace());
					$title2 = "/index.php?title=".$namespace.":".$title->getText();
				}
				$title_href = '<a href="' . $domain_url . $title2 . '" title="' . $title->getText() . '">'.$title->getText().'</a>';
				$activity_title = wfMsg('usereditedpageurl', $user_link, $title_href);
				if (!empty($domain_name))
				{
					$activity_title .= wfMsg('ondomainsite', $domain_name);
				}
				break;
			}
			case "last_votes":
			{
				$title2 = $title->getLocalURL();
				if (0 != $title->getNamespace())
				{
					$namespace = Namespace::getCanonicalName($title->getNamespace());
					$title2 = "/index.php?title=".$namespace.":".$title->getText();
				}
				$title_href = '<a href="' . $domain_url . $title2 . '" title="' . $title->getText() . '">'.$title->getText().'</a>';
				$activity_title = wfMsg('uservotedforarticle', $user_link, $title_href);
				if (!empty($domain_name))
				{
					$activity_title .= wfMsg('ondomainsite', $domain_name);
				}
				break;
			}
			case "gift_sent":
			{
				$special_gift_link = '<a href="index.php?title=Special:ViewGift&gift_id='.$namespace.'">gift</a>';
				$activity_title = wfMsg('usersentgiftstats', $user_link, $special_gift_link, $user_title_href);
				break;
			}
			case "gift_rec":
			{
				$special_gift_link = '<a href="index.php?title=Special:ViewGift&gift_id='.$namespace.'">gift</a>';
				$activity_title = wfMsg('userrecvgiftstats', $user_link, $special_gift_link, $user_title_href);
				break;
			}
			case "friend":
			{
				if (($wgUser->getId() != $this->user_id) && ($wgUser->getId() != 0))
				{
					$friend_url = '<a href="index.php?title=Special:AddRelationship&user='.$this->user_name.'&rel_type=1" title="'.wfMsg('friendme').'">'.wfMsg('friendlink').'</a>';
				}
				else
				{
					$friend_url = wfMsg('friendlink');
				}
				$activity_title = wfMsg('userrelationwithuser', $user_link, $friend_url, $user_title_href);
				break;
			}
			case "foe":
			{
				if (($wgUser->getId() != $this->user_id) && ($wgUser->getId() != 0))
				{
					$foe_url = '<a href="index.php?title=Special:AddRelationship&user='.$this->user_name.'&rel_type=2" title="'.wfMsg('foeme').'">'.wfMsg('foelink').'</a>';
				}
				else
				{
					$foe_url = wfMsg('foelink');
				}
				$activity_title = wfMsg('userrelationwithuser', $user_link, $foe_url, $user_title_href);
				break;
			}
		}

		wfProfileOut( __METHOD__ );

		return $activity_title;
	}

	public function getTypeActivityInfo($type, $item)
	{
		global $wgUser, $wgGiftImagePath;
		#---
		wfProfileIn( __METHOD__ );

		$activity_info = "";
		switch ($type)
		{
			case "last_edits":
			{
				$activity_info = "<div class=\"user-feed-item-editinfo\">".$item["comment"]."</div>";
				break;
			}
			case "last_votes":
			{
				$activity_info = "<div class=\"user-feed-item-comment\">".wfMsg('yourvote').": <strong>".$item["vote"]."</strong></div>";
				break;
			}
			case "gift_sent":
			{
				$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($item["namespace"],"m") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
				$activity_info = "<div class=\"user-feed-item-gift\">";
				$activity_info .= "<span class=\"user-feed-gift-image\"><a href=\"index.php?title=Special:ViewGift&gift_id=".$item["namespace"]."\">{$gift_image}</a></span>";
				$activity_info .= "<span class=\"user-feed-gift-info\"><a href=\"index.php?title=Special:ViewGift&gift_id=".$item["namespace"]."\">".$item["pagetitle"]."</a></span>";
				$activity_info .= "</div>";
				break;
			}
			case "gift_rec":
			{
				$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($item["namespace"],"m") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
				$activity_info = "<div class=\"user-feed-item-gift\">";
				$activity_info .= "<span class=\"user-feed-gift-image\"><a href=\"index.php?title=Special:ViewGift&gift_id=".$item["namespace"]."\">{$gift_image}</a></span>";
				$activity_info .= "<span class=\"user-feed-gift-info\"><a href=\"index.php?title=Special:ViewGift&gift_id=".$item["namespace"]."\">".$item["pagetitle"]."</a></span>";
				$activity_info .= "</div>";
				break;
			}
			case "friend":
			{
				break;
			}
			case "foe":
			{
				break;
			}
		}

		wfProfileOut( __METHOD__ );

		return $activity_info;
	}

	function fixItemComment($comment)
	{
		if(!$comment)
			return "";
		else
		{
			$comment = str_replace ("<", "&lt;",$comment);
			$comment = str_replace (">", "&gt;",$comment);
			$comment = str_replace ("&", "%26", $comment );
			$comment = str_replace ("%26quot;","\"",$comment );
		}
		$preview = substr($comment,0,75);
		if ($preview != $comment)
		{
			$preview .= "...";
		}
		#---
		return stripslashes($preview) ;
	}

	public function dateDiff($dt1, $dt2)
	{

		$date1 = $dt1; //(strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
		$date2 = $dt2; //(strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;

		$dtDiff = $date1 - $date2;

		$totalDays = intval($dtDiff/(24*60*60));
		$totalSecs = $dtDiff-($totalDays*24*60*60);
		$dif['w'] = intval($totalDays/7);
		$dif['d'] = $totalDays;
		$dif['h'] = $h = intval($totalSecs/(60*60));
		$dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
		$dif['s'] = $totalSecs-($h*60*60)-($m*60);

		return $dif;
	}

	public function getTimeOffset($time,$timeabrv,$timename,$timename_plural)
	{
		$timeStr = "";
		#---
		if ($time[$timeabrv]>0)
		{
			$timeStr = $time[$timeabrv] . " " . $timename;
			if($time[$timeabrv]>1)
			{
				#$timeStr .= "s";
				$timeStr = $time[$timeabrv] . " " . $timename_plural;
			}
		}
		if ($timeStr)
		{
			$timeStr .= " ";
		}

		#---
		return $timeStr;
	}

	public function getTimeAgo($time)
	{
		$timeArray =  $this-> dateDiff(time(),$time  );
		$timeStr = "";
		$timeStrD = $this->getTimeOffset($timeArray,"d",wfMsg('day_txt'),wfMsg('days_txt'));
		$timeStrH = $this->getTimeOffset($timeArray,"h",wfMsg('hour_txt'),wfMsg('hours_txt'));
		$timeStrM = $this->getTimeOffset($timeArray,"m",wfMsg('minute_txt'),wfMsg('minutes_txt'));
		$timeStrS = $this->getTimeOffset($timeArray,"s",wfMsg('second_txt'),wfMsg('seconds_txt'));
		$timeStr = $timeStrD;
		if ($timeStr<2)
		{
			$timeStr.=$timeStrH;
			$timeStr.=$timeStrM;
			if(!$timeStr)
			{
				$timeStr.=$timeStrS;
			}
		}

		#---
		return $timeStr;
	}
}

function _sort_activity($x, $y)
{
	if ( $x["timestamp"] == $y["timestamp"] )
	 return 0;
	else if ( $x["timestamp"] > $y["timestamp"] )
	 return -1;
	else
	 return 1;
}

function wfwkGetLastActivity ($type, $username)
{
	global $wgUser, $wgMemc, $wgImageCommonPath;
	wfProfileIn( __METHOD__ );

	if (empty($type) || empty($username))
	{
		return false;
	}

	#---
	$user_title = Title::makeTitle( NS_USER  , $username  );

	#---
	$toggle_array = array();

	#---
	$activity = new WikiaUserProfileActivity($username, "user", 10);
	switch ($type)
	{
		case 'all' : $toggle_array = array("show_edits"=>1,"show_votes"=>1,"show_relationships"=>1,"show_friends"=>1,"show_foes"=>0 /* FOE OFF */,"show_gifts_sent"=>1,"show_gifts_rec"=>1); break;
		case 'last_edits' : $toggle_array = array("show_edits"=>1,"show_votes"=>0,"show_relationships"=>0,"show_friends"=>0,"show_foes"=>0,"show_gifts_sent"=>0,"show_gifts_rec"=>0); break;
		case 'last_votes' : $toggle_array = array("show_edits"=>0,"show_votes"=>1,"show_relationships"=>0,"show_friends"=>0,"show_foes"=>0,"show_gifts_sent"=>0,"show_gifts_rec"=>0); break;
		case 'gift_sent' : $toggle_array = array("show_edits"=>0,"show_votes"=>0,"show_relationships"=>0,"show_friends"=>0,"show_foes"=>0,"show_gifts_sent"=>1,"show_gifts_rec"=>0); break;
		case 'gift_rec' : $toggle_array = array("show_edits"=>0,"show_votes"=>0,"show_relationships"=>0,"show_friends"=>0,"show_foes"=>0,"show_gifts_sent"=>0,"show_gifts_rec"=>1); break;
		case 'friend' :  $toggle_array = array("show_edits"=>0,"show_votes"=>0,"show_relationships"=>1,"show_friends"=>1,"show_foes"=>0,"show_gifts_sent"=>0,"show_gifts_rec"=>0); break;
		case 'foe' : $toggle_array = array("show_edits"=>0,"show_votes"=>0,"show_relationships"=>0,"show_friends"=>0,"show_foes"=>0 /* FOE OFF */,"show_gifts_sent"=>0,"show_gifts_rec"=>0); break;
		default : $toggle_array = array("show_edits"=>1,"show_votes"=>1,"show_relationships"=>1,"show_friends"=>1,"show_foes"=>0 /* FOE OFF */,"show_gifts_sent"=>1,"show_gifts_rec"=>1); break;
	}

	foreach ($toggle_array as $name => $value)
	{
		$activity->setActivityToggle($name, $value);
	}

	$type_key = $type;
	if (!in_array($type, array('all','last_edits', 'last_votes', 'gift_sent', 'gift_rec', 'friend', 'foe')))
	{
		$type_key = 'default';
	}

	$id = User::idFromName($username);
	$key = wfMemcKey( 'user', 'ajax_profile_activity_'.$type_key, intval($id) );
	$data = $wgMemc->get( $key );
	if($data)
	{
		wfDebug( "Got (ajax) user activity ({$type}) info for {$username} from cache\n" );
		$activity_data = $data;
	}
	else
	{
		$activity_data = $activity->getActivityList();
		$wgMemc->set( $key, $activity_data, MEM_CACHE_TIME );
	}

	$items = $activity_data[0]; $types = $activity_data[1];
	$output = "";

	$loop = 1;
	$count = count($items);
	if (!empty($items))
	{
		foreach ($items as $id => $item)
		{
			$div_class = ($count != $loop) ? "user-feed-item" : "user-feed-item-no-border";
			#--
			$title = $activity->getTypeTitle($item['type'], $item);

			$output .= "<div class=\"{$div_class}\">";
			$output .= "<div class=\"user-feed-item-icon\"><img src={$wgImageCommonPath}/" . $activity->getTypeIcon($item['type']) . " alt=\"" . $activity->getTypeIcon($item['type']) . "\" border='0'></div>";
			$output .= "<div class=\"user-feed-item-activity\">".$activity->getTypeActivityTitle($item['type'], $item['namespace'], $item['pagetitle'], $item['username'], $item['userid'], $item['city'])."</div>";
			$output .= "<div class=\"cleared\"></div>";
			$output .= "<div class=\"user-feed-item-time\">".wfMsg('actiontimeago', $activity->getTimeAgo($item['timestamp']))."</div>";
			$output .= "<div class=\"cleared\"></div>";
			$output .= $activity->getTypeActivityInfo($item['type'], $item);
			$output .= "</div>";

			$loop++;
		}
	}
	else
	{
		if ( $wgUser->getName() == $user_title->getText() )
		{
			switch ($type)
			{
				case 'all' : $output .= "<p>".wfMsg('questionfornothing')."<br /> ";
							 $output .= "<a href='index.php?title=Special:InviteContacts'>".wfMsg('invitesomefriend')."</a>, ";
							 $output .= "<a href='index.php?title=Create_Opinion'>".wfMsg('writearticle')."</a>, ".wfMsg('ortext')." ";
							 $output .= "<a href='index.php?title=Special:Randompage'>".wfMsg('editrandomarticle')."</a>.</p>";
							 break;
				case 'last_edits' : $output .= "<p>".wfMsg('questionfornothing')." ";
									$output .= "<a href='index.php?title=Special:Randompage'>".wfMsg('editrandomarticle')."</a>.</p>";
									break;
				case 'last_votes' : $output .= "<p>".wfMsg('questionfornothing')." <br />";
									$output .= wfMsg('viewrandomandvote')."</p>";
									break;
				case 'gift_sent' : 	$output .= "<p>".wfMsg('questionfornothing')." <br /> ";
							 		$output .= wfMsg('moreyougiftgive').", ";
							 		break;
				case 'gift_rec' : $output .= "<p>".wfMsg('younoactivity')." :-(</p>"; break;
				case 'friend' : $output .= "<p>".wfMsg('questionfornothing')."<br /> ";
								$output .= "<a href='index.php?title=Special:InviteContacts'>".wfMsg('invitesomefriend')."</a>, ";
								break;
				case 'foe' : $output .= "<p>".wfMsg('younoactivity')."</p>";
							 break;
			}
		}
		else
		{
			$output .= "<p>".wfMsg('usernoactivity', $user_title->getText())." :-(</p>";
		}
	}

	wfProfileOut( __METHOD__ );

	return $output;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "wfwkGetLastActivity";

?>
