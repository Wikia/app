<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/forums/thread.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

function awcs_forum_threads($action){

    $threads = new awcforum_threads();
    $threads->enter_threads($action);

}

class awcforum_threads{

    var $emotions;
    var $cookie_expir;
    var $quick_height;
    var $wiki_titles, $wiki_pages ;
    var $cf_SigGuestView, $cf_AdvatarGuestView;
    var $current_mem_info;
    var $WikiToolBar;
    var $displaysmiles, $mem_displaysmiles;
    var $cf_threadsubscrip;
    var $wiki_title_search_len;
    var $cf_AvatraSize;
    
    var $skin_thread;
    
    var $cf_add_post_text_to_wiki;
    
    var $multi_polls;
    
    
    var $userID = 0;
    var $userSubscribe = array();
    
    var $forum_perm_can_post = true;
        
        function __construct(){
        global $awcs_forum_config, $awcUser;
           
            $this->installed = false;
            include_once(awc_dir . 'includes/post_phase.php');
            
            $ws = $awcs_forum_config->cf_add_post_text_to_wiki;
            $this->cf_add_post_text_to_wiki = ($ws == '1') ? true : false;
            
            $this->userSubscribe = (isset($awcUser->m_thread_subsrib) AND !empty($awcUser->m_thread_subsrib)) ? $awcUser->m_thread_subsrib : null;
            $this->userID = $awcUser->mId;
            
            $this->multi_polls = $awcs_forum_config->cf_allow_multi_pols;
            
        }
        
        
        
	function enter_threads($action){
	global $wgRequest, $awcs_forum_config, $WhoWhere;
		
        $this->cf_AvatraSize = $awcs_forum_config->cf_AvatraSize;
        
        include_once(awc_dir . 'includes/thread_funk.php');
        
        $this->cookie_expir = $awcs_forum_config->cfl_Post_cookie_postcountexpire ;
        $this->quick_height = $awcs_forum_config->cfl_Post_quickpost_box_height;
        $this->cf_SigGuestView = $awcs_forum_config->cf_SigGuestView;
        $this->cf_AdvatarGuestView = $awcs_forum_config->cf_AdvatarGuestView ;
        $this->displaysmiles = $awcs_forum_config->cf_displaysmiles;
        $this->wiki_title_search_len = $awcs_forum_config->cf_wiki_title_search_len;
        $this->cf_threadsubscrip = $awcs_forum_config->cf_threadsubscrip ;
        $this->wiki_titles = $awcs_forum_config->cf_wiki_titles ;
        $this->wiki_pages = $awcs_forum_config->cf_wiki_pages;
        
        $this->display_mem_titles = $awcs_forum_config->cf_display_mem_titles;
        
        
        $this->emotions = GetEmotions();
        
		$spl = explode("/", $action);
		$todo = $spl[0];
        
        if(isset($spl[1])){
            $id =  str_replace(array('id', '_'), '', $spl[1]) ;
        } else {
           $id = $wgRequest->getVal( 'id' ) ; 
        } 
		
        if(!is_numeric($id)) return awcs_forum_error('word_nothread') ;
        
        $this->id =  $id ; 
        
        if (!$this->id) $this->id = $wgRequest->getVal( 'id' );
        
		define('what_page', $todo );
        $WhoWhere['type'] = 'forum';
        
		switch( $todo ) {
		
			case 'st':
			    $str = $this->GetPosts($this->id);
				break;
				
			case 'sp':
                $str = $this->GetPost($this->id);
                break;
				
			case 'ann_thread':
			    $this->do_ann_thread($this->id , str_replace('fid', '', $spl[3]), '1');
				break;
                
			case 'edit_post':
				 #  $str = $this->edit_post();
				break;
                
            case 'last_post':
                 self::get_latest_post($this->id);
                break;
				
		}
		
		#$str = $wgOut->parse($str);
		#$wgOut->addHTML($str);
		
	} 
	
	function CleanURL($u){
		
		return $u;
	}		
	
	function GetUserGroup($n){
        
			$dbr = wfGetDB( DB_SLAVE );
			$tmp=null;
			$wiki_user_tbl = $dbr->tableName( 'user' );
			$wiki_user_groups_tbl = $dbr->tableName( 'user_groups' );
			$sql = "SELECT g.ug_group FROM $wiki_user_tbl u, $wiki_user_groups_tbl g WHERE u.user_name='$n' AND u.user_id=g.ug_user";
			$res = $dbr->query($sql);
			while ($r = $dbr->fetchObject( $res )) {	
				$tmp .=  ucwords($r->ug_group) . ", ";
				  
			}
			$dbr->freeResult( $res );
			unset($r, $sql);
            
			$tmp = substr($tmp,0, strlen($tmp) - 2);
			if ($tmp == "" ) $tmp = get_awcsforum_word('mem_word');
			
			return $tmp;
						
	
	}
    
    function GetPost($pID){
    	
		$dbr = wfGetDB( DB_SLAVE );
		$awc_f_posts = $dbr->tableName( 'awc_f_posts' );
        $awc_f_threads = $dbr->tableName( 'awc_f_threads' );
        $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
        $awc_f_cats = $dbr->tableName( 'awc_f_cats' );
        
		$perm = new awcs_forum_perm_checks();
		$perm_where = $perm->cat_forum_sql();
		
		
		$sql = $dbr->selectSQLText( array( 'awc_f_threads', 'awc_f_posts', 'awc_f_forums', 'awc_f_cats' ), 
                   array( "$awc_f_posts.*, $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_desc, $awc_f_forums.f_id, $awc_f_forums.f_parentid, $awc_f_cats.cat_name, $awc_f_cats.cat_id" ),
                    "$perm_where $awc_f_posts.p_id=$pID", 
                   __METHOD__, 
                   array('OFFSET' => 0, 'LIMIT' => 1,),
                   array( 'awc_f_posts' => array('JOIN',"$awc_f_threads.t_id=$awc_f_posts.p_threadid"),
       						'awc_f_forums' => array('JOIN',"$awc_f_threads.t_forumid=$awc_f_forums.f_id"),
       						'awc_f_cats' => array('JOIN',"$awc_f_forums.f_parentid=$awc_f_cats.cat_id"))
                    );
         
                       
        $this->GetPosts('', $sql, true);
        
        return;
    }

    
    function check_subscribe($tID){
    #global $awcUser;
    #awc_pdie($awcUser);
      
        if($this->cf_threadsubscrip != '1' OR $this->userID == '0') return 'no';    
        
         $w['subscribed_word'] = get_awcsforum_word('word_subscribe');
         $v['subscribed_email'] = '';
         $v['subscribed_list'] = '';
         $v['subscribed_no'] = ''; 
         $v['subscribed'] = '';
         
         if(!empty($this->userSubscribe)){
                
                 if(!array_key_exists($tID, $this->userSubscribe)){
                    $w['subscribed_word'] = get_awcsforum_word('word_subscribe');
                    $v['subscribed_no'] = 'selected';
                 } else {
                     // find a better way for this Update...
                    $dbw = wfGetDB( DB_MASTER );
                    $dbw->update( 'awc_f_watchthreads', 
                                array('wtcht_sent' => '0',), 
                                array('wtcht_thread_id' => $tID, 'wtcht_mem_id' => $this->userID) , __METHOD__ );
                                
                 
                    
                    $w['subscribed_word'] = get_awcsforum_word('word_unsubscrib');
                    if($this->userSubscribe[$tID] == 'email'){
                        $v['subscribed_email'] = 'selected';
                    } else {
                        $v['subscribed_list'] = 'selected';
                    }
                    
                    $v['subscribed'] = 'checked';
                    unset($dbw);
                 }
                 
         }
         
         $subscribe_info = array('words' => $w, 'values' => $v);
         unset($w, $v);
         
         global $tplt;
         
                     $word['subscribe'] = ''; 
                     
                   // awc_pdie($subscribe_info);
                     if( $subscribe_info['values']['subscribed_email']== 'selected'){
                        $info['url_email'] = awc_url ."post/sub/id{$tID}/no";
                        $info['url_list'] = awc_url ."post/sub/id{$tID}/list";
                        
                        $word['word_subscribe_email'] = get_awcsforum_word('word_unsubscrib') . ' ' . get_awcsforum_word('word_subscribe_email');
                        $word['word_subscribe_memcp'] = get_awcsforum_word('word_subscribe') . ' ' . get_awcsforum_word('word_subscribe_memcp');
                     
                     }elseif( $subscribe_info['values']['subscribed_list'] == 'selected'){
                        
                        $info['url_email'] = awc_url ."post/sub/id{$tID}/email";
                        $info['url_list'] = awc_url ."post/sub/id{$tID}/no";
                        
                        $word['word_subscribe_email'] = get_awcsforum_word('word_subscribe') . ' ' . get_awcsforum_word('word_subscribe_email');
                        $word['word_subscribe_memcp'] = get_awcsforum_word('word_unsubscrib') . ' ' . get_awcsforum_word('word_subscribe_memcp');
                     
                     } else{
                         
                        $info['url_email'] = awc_url ."post/sub/id{$tID}/email";
                        $info['url_list'] = awc_url ."post/sub/id{$tID}/list";
                        
                        $word['word_subscribe_email'] = get_awcsforum_word('word_subscribe') . ' ' . get_awcsforum_word('word_subscribe_email');
                        $word['word_subscribe_memcp'] = get_awcsforum_word('word_subscribe') . ' ' . get_awcsforum_word('word_subscribe_memcp');
                     }
                     
                     
                     $e['subscribed_email'] = $subscribe_info['values']['subscribed_email'];
                     $e['subscribed_list'] = $subscribe_info['values']['subscribed_list'];
                     $e['subscribed_no'] = $subscribe_info['values']['subscribed_no'];
                     $e['subscribed'] = $subscribe_info['values']['subscribed'];
                     
                     $tPass['subscrib_links'] = $tplt->phase($word, $info, 'subscrib_links', true);
                     
                 $re['e'] = $e;
                 $re['tPass'] = $tPass;
                 $re['subscribe_info'] = $subscribe_info;
                 
                 unset($word, $info, $tPass, $subscribe_info);
                 
                 return $re;
    }

    
  
	function GetPosts($tID, $sql2='', $single_post = false) {
	global $LimitJump_top, $LimitJump_bot, $total_thread_count, $thread_title_for_search ;
	global $wgOut, $wgRequest, $wgCookieExpiration, $wgCookiePath, $wgCookieDomain;
    
    global $WhoWhere, $awc_tables, $tplt;
    global $awcUser;
    
        if(!$awcUser->canRead) return $wgOut->loginToUse();
        
        $perm = new awcs_forum_perm_checks();
        
        $post_cls = new awcs_forum_post_phase();
        if($single_post) $post_cls->single_post = true;
        
        
         $word=null;
         $i=null;
         $html=null;
         $e = array();
         $tPass = array();
         
         if($sql2 == '') {
             
             $check_subscribe = self::check_subscribe($tID);
             
             if($check_subscribe != 'no'){
                 $e = $check_subscribe['e'];
                 $tPass = $check_subscribe['tPass'] ;
                 $subscribe_info = $check_subscribe['subscribe_info'] ;
             } else {
                $tPass['subscrib_links'] = null;
             }
                              
         } else {
                $tPass['subscrib_links'] = null;
                $tplt->kill('subscrib_links');
         }
         
         
         $dbr = wfGetDB( DB_SLAVE );
         
         
         $this->display_mem_titles = 1;
         
         if($this->display_mem_titles){
            
            $sql = "SELECT * FROM {$awc_tables['awc_f_member_titles']} ORDER BY memtitle_postcount ASC";
            $res = $dbr->query($sql);
            while ($r = $dbr->fetchObject( $res )) {
                $post_cls->mem_post_title[$r->memtitle_id] = array('count' => $r->memtitle_postcount, 'title' => $r->memtitle_title, 'img' => $r->memtitle_img, 'css' => $r->memtitle_css);
            }
         	unset($res, $r);
         } else {
            $post_cls->mem_post_title[0] = 'do_not_show';
         }
         
        // get number of threads so we can make the Page Blocks
        # do something different, maybe move to sessions ro somehting  
		$sql = $dbr->selectSQLText( array( 'awc_f_threads' ), 
                   array( 't_topics, t_postid' ), "t_id={$tID}", 
                   __METHOD__, 
                   array('OFFSET' => '0', 'LIMIT' => '1'));
		
		
        $limit = '';
        $tPass['page_jumps'] = null;
        if($sql2 == '') { #$sql = "SELECT p_id FROM {$awc_tables['awc_f_posts']} WHERE p_id = $tID ";
       
            $res = $dbr->query($sql);
		    $r = $dbr->fetchRow( $res );
		    $ex['TotalPosts']  = $r['t_topics'];
            $dbr->freeResult( $res );
            
            $total['TotalPosts'] = $ex['TotalPosts'];
            $total['last'] = $r['t_postid'];
            $limit = GetLimit($total, 'thread');
            $tPass['page_jumps'] = $LimitJump_top;
            #die($LimitJump_bot);
        } else {
           # $ex['sql2'] = $sql2;
        }
        
       # DIE($limit);
        $limit_is_there = false;
        # sw: highlightsearchword
		$action = $wgRequest->action;
		$spl = explode("/", $action);
        $search_word = null;
        
        # loop through "action" to find seach word
        foreach($spl as $k => $value){
           if (stristr($value, 'limit')) {
                $post_cls->has_limit = true ;
            }
           
            if (substr($value , 0, 3) == "sw:"){
                 $sw1 = explode("sw:", $value);
                 $search_word = $sw1[1];
                 break;
            }
        }
        
		$search_word = str_replace("_", " ", $search_word);
        $spl2 = explode(" ", $search_word);
        # loop through seach word's 
        foreach($spl2 as $k => $value){
            $sw[] = $value;
        }
        
        $perm_where = $perm->cat_forum_sql();        
        
            $limit = awcsforum_funcs::limitSplit($limit);  
            # awc_pdie($limit);
 			$sql = $dbr->selectSQLText( array( 'awc_f_threads', 'awc_f_posts', 'awc_f_forums', 'awc_f_cats' ), 
                   array( 'p_id, p_title, p_post, p_user, p_userid, p_editwhy, p_editwho, p_editdate, p_date,
                t_id, t_ann, t_pin, t_status, t_name, t_topics, t_hits, t_perm, t_poll, t_wiki_pageid, t_lastdate, t_pollopen,
                f_posting_mesage_tmpt, f_name, f_id, f_wiki_write_perm, f_wiki_read_perm, f_passworded, cat_name, cat_id' ),
                    "$perm_where t_id = $tID", 
                   __METHOD__, 
                   array('OFFSET' => $limit['offset'], 'LIMIT' => $limit['limit'], 'ORDER BY' => 'p_thread_start DESC, p_date ASC'),
                   array( 'awc_f_posts' => array('JOIN','t_id=p_threadid'),
       						'awc_f_forums' => array('JOIN','t_forumid=f_id'),
       						'awc_f_cats' => array('JOIN','f_parentid=cat_id'))
                    );
        
       # die($sql);
        
        
        if(strlen($sql2) > 0) {
            $sql = $sql2;
        }
        
        $res = $dbr->query($sql);             
        $i = 0; 	
        $out = array();
       # $e['html'] = null;
                 
		while ($r = $dbr->fetchObject( $res )) {
		 ++$i;
         
                 if($i == 1){
                    # awc_pdie($r);
                      // stuff this stuff here so its not looped...
                        $WhoWhere['where'] = 'cid' . $r->cat_id . '|fid' .  $r->f_id . '|tid' .  $r->t_id . '||awc-split||' . $r->t_name ;
                        $WhoWhere['perm'] = isset($r->f_wiki_read_perm) ? $r->f_wiki_read_perm : '' ;
                        
                        $thread_title = $r->t_name;
                        $t_status = $r->t_status ;
                        $f_posting_mesage_tmpt = isset($r->f_posting_mesage_tmpt) ? $r->f_posting_mesage_tmpt : '' ;
                        $f_wiki_write_perm = isset($r->f_wiki_write_perm) ? $r->f_wiki_write_perm : '' ;
                        
                        
                        if((!$awcUser->guest) AND (awcsforum_funcs::wikidate($r->t_lastdate) > $_SESSION['awc_startTime'])) $_SESSION['awc_rActive'][$r->t_id]  = awcsforum_funcs::wikidate($r->t_lastdate) ;
                        
                        $e['PostTitle'] = $r->t_name;
                        $e['num_topics'] = $r->t_topics;
                        $f_name = $r->f_name;
                        $fID = $r->f_id;
                        $t_wiki_pageid = $r->t_wiki_pageid;
                
                        
			            if(!isset($awcUser->pw)){
			            	$awcUser->pw[0]=0;
			            }
			           #die(">" . $r->f_id);
			            if($perm->is_password($r->f_passworded) AND !in_array($r->f_id, $awcUser->pw)){
                                global $wgOut;
				                $password_field = '<br /><hr />' . get_awcsforum_word('forum_passworded'). '<hr />';
				                $password_field .= '</form><form action="'.awc_url.'fpw" method="post"  enctype="multipart/form-data">
				                <input name="fid" type="hidden" value="'.$r->f_id.'">
				                <input name="pw" type="password" size="20">
				                <input type="submit" value="'.get_awcsforum_word('submit').'">
				                </form><br /><br />';
                                $wgOut->addHTML($password_field);
                                return ;
                        }
                        
                        $this->forum_perm_can_post = false;
                        if($awcUser->canPost AND $perm->can_post($f_wiki_write_perm)) {
                            $this->forum_perm_can_post = true;
                            $post_cls->forum_perm_can_post = true ;  
                        }
                        
                        // end stuffed...
                     
                     
                     if(!$single_post){
                                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sc/id' . $r->cat_id . '">' . $r->cat_name .'</a>');
                                $BreadCrumb = Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sf/id' . $r->f_id . '">' . $r->f_name .'</a>', true);
                                                     
                                $t = null;
                                if ($r->t_ann == "1") {
                                    $t = get_awcsforum_word('thread_makeAnnouncement') . " " ;
                                    $e['ann'] = true ;
                                } 
                                                    
                                if ($r->t_status == "1"){
                                    $t = get_awcsforum_word('1indicator_locked') . " " ;
                                    $e['lock'] = true ;  
                                }
                                     
                                if ($r->t_pin == "1"){
                                    $t = get_awcsforum_word('1indicator_sticky') . " " ;
                                    $e['sticky'] = true ; 
                                }
                                                
                                if ($r->t_pin == "1" AND $r->t_status == "1"){
                                    $t = get_awcsforum_word('1indicator_lockSticky') . " " ;
                                }
                                                       
                                
                                $e['tID'] =  $r->t_id ;
                                $e['fID'] =  $r->f_id ;
                                $e['cID'] =  $r->cat_id  ;
                                $e['pID'] =  $r->p_id  ;                      
                                Set_AWC_Forum_SubTitle($r->t_name, $t . get_awcsforum_word('word_viewed') . " " . $r->t_hits . " " . get_awcsforum_word('word_times') . ", " . get_awcsforum_word('word_Withatotalof') . " " . $r->t_topics . " " . get_awcsforum_word('word_posts'), $e); 
                                
                                $tPass['mod_buttons'] = null;
                                if(UserPerm >= 2){
                                                
                                       $e['ann'] = ($r->t_ann == '1') ? 'checked' : null;
                                       $e['sticky'] = ($r->t_pin == '1') ? 'checked' : null;
                                       $e['lock'] = ($r->t_status == '1') ? 'checked' : null;
                                       $e['threadname'] = awcsforum_funcs::awc_html_entity_decode($thread_title);
                                       
                                       $word['pinned_word'] = get_awcsforum_word('pinned_word');
                                       $word['lockThread_word'] = get_awcsforum_word('lockThread_word');
                                       $word['mod_movethread'] = get_awcsforum_word('mod_movethread');
                                       $word['thread_makeAnnouncement'] = get_awcsforum_word('thread_makeAnnouncement');
                                       $word['mod_post'] = get_awcsforum_word('mod_post');
                                       
                                       
                                       
                                       if($r->t_ann != "1" || UserPerm == 10) {
                                            #$to_skin['mod_buttons'] = ModFormStart($r->t_id, $r->p_id, $r->f_id, awc_url, $r->t_name, $total_topics) ;
                                        }
                                        
                                        #if (UserPerm == 10) $to_skin['mod_buttons'] .= IsAnnonc($r->t_ann);
                                        if (UserPerm == 10){
                                            $e['ann'] = $tplt->phase($word, $e, 'mod_thread_dropdown_ann', true);
                                        } else{
                                            $e['ann'] = '' ;
                                        }
                                        
                                        if ((UserPerm >= 2 AND $r->t_ann != "1") || UserPerm == 10) {
                                           $tPass['mod_buttons'] = $tplt->phase($word, $e, 'mod_thread_dropdown', true); 
                                        } 
                                         unset($word);                                
                                                    
                                    } 
                                    
                                    
                                    
                                    if($this->userID != '0'){
                                        $tPass['options_menu'] = null;
                                        $word['word_thread_options_button'] = get_awcsforum_word('word_thread_options_button');
                                        $tPass['thread_options'] = $tplt->phase($word, $tPass, 'options_dropdown', true);
                                    } else {
                                        $tplt->kill('options_dropdown');
                                        $tPass['thread_options'] = null;
                                    }
                                    
                                    # $tPass['page_jumps'] // is set above...
                                    $html = $tplt->phase($word, $tPass, 'thread_header', true);
                                    unset($info, $word, $tPass);
                                #awc_pdie($tplt_info);
                                
                         } else { // single
                         
                                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sc/id' . $r->cat_id . '">' . $r->cat_name .'</a>');
                                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sf/id' . $r->f_id . '">' . $r->f_name .'</a>');
                                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'st/id' . $r->t_id . '">' . awcsforum_funcs::awc_html_entity_decode($r->t_name) .'</a>', TRUE);
                                                    
                                $e = array();
                                $e['tID'] =  $r->p_threadid ;
                                $e['fID'] =  $r->f_id ;
                                $e['cID'] =  $r->cat_id ;
                                
                                $tPass['page_jumps'] = "<b><a href='". awc_url ."st/id".$r->t_id."'>".get_awcsforum_word('click_here_for_full_thread')."</a></b>" ;
                                $tPass['thread_options'] = null;
                                $html = $tplt->phase($word, $tPass, 'thread_header', true);
                                Set_AWC_Forum_SubTitle($r->t_name, get_awcsforum_word('single_post_sub_title') , $e);
                         
                         
                         }
                             if($r->t_poll AND !$single_post){
                                 
                                 $poll = $post_cls->display_poll($tID);                     
                                 $html = $poll . $html;
                                 
                             }
                                
                 }
                 
                 // unset($_SESSION['awc_nActive'][$r->p_id]);
                 #if($r->p_wikipage_id != '0') $p_wikipage_id[] = $r->p_wikipage_id ;
                 
                 $post_cls->load_post_phase_info($r);
                    
                  //  awc_pdie($post_cls);
                 $html .= $post_cls->display_post();
                    				
		} # end SQL loop...
        unset($post_cls);
        
        if($i == 0){
            return ;
        }
        $dbr->freeResult( $res );
        unset($dbr, $res, $r);
        
                /*
                    if($this->cf_add_post_text_to_wiki){
                        $dbw = wfGetDB( DB_MASTER );
                        $wp_ids = implode(',',$p_wikipage_id);
                        $wiki_page = $dbw->tableName( 'page' );
                        $dbw->query( "UPDATE {$wiki_page} SET page_counter = page_counter + 1 
                                        WHERE page_id IN ($wp_ids)" );
                    }
        */
           # unset($r, $this, $user_get, $ex, $sql);
        if(!$single_post AND (strlen($sql2) == 0)){  
          
                $total_thread_count = $i;
                $thread_title_for_search = $thread_title;
                
                $yes = false ;
		       # $awc_ViewForum = $_COOKIE['awc_forum_ThreadView'] ;
                $awc_ViewForum = isset($_COOKIE['awc_forum_ThreadView']) ? $_COOKIE['awc_forum_ThreadView'] : null;
                           
		        $spl = explode(",", $awc_ViewForum);
		        foreach ($spl as $fid) {
			        if ($tID == $fid ) $yes = true ;
		        }		
		        if (!$yes) {
                    $dbw = wfGetDB( DB_MASTER );
		            $dbw->query( "UPDATE {$awc_tables['awc_f_threads']} SET t_hits = t_hits + 1 WHERE t_id = $tID" );
			        $expir = $this->cookie_expir ;
                    if($expir >= 1) $expir = ($expir * 60 * 60 );
                    $exp = time() + $expir  ; # $exp = time() + $wgCookieExpiration;
			        setcookie( 'awc_forum_ThreadView', $awc_ViewForum . "," . $tID , $exp, $wgCookiePath, $wgCookieDomain );
                    #$_SESSION['awc_forum_ThreadView'] = $awc_ViewForum ;
                    
					unset($dbw);
		        
                }
                

               # die($LimitJump_top);
              # $html = $e['html'];
               
                $info['page_jumps'] = ($LimitJump_bot) ? $LimitJump_bot : null;
                $info['BreadCrumb'] = $BreadCrumb;
                $html .= $tplt->phase('', $info, 'bottom_page_jumps', true);
            }  
            
            
            $wgOut->addHTML($html);
            //forum-wiki-perm
		    //if ($awcUser->canPost AND $t_status == "0" || UserPerm >= 2 && $i AND !$single_post){
            if(((strlen($sql2) == 0) AND $awcUser->canPost AND $this->forum_perm_can_post AND $t_status == "0" AND !$single_post) || (UserPerm >= 2 && $i AND !$single_post)){
                
                
                require(awc_dir . '/includes/post_box.php');
                $posting_box = new awcs_forum_posting_box();
                
                $posting_box->quick_box = true;
                
                $posting_box->f_posting_mesage_tmpt = (strlen($f_posting_mesage_tmpt) > 1) ? add_tmpl_to_skin($f_posting_mesage_tmpt) : null;
                
                
                
                #$posting_box->Thread_Title = awcsforum_funcs::awc_html_entity_decode($thread_title);
                $posting_box->Thread_Title = awcsforum_funcs::awc_htmlentities($thread_title);
                $posting_box->tbRows = $this->quick_height; 
                $posting_box->Show_ann_sticky_lock = false; 
                
                $posting_box->f_name = urlencode($f_name);
                $posting_box->fID = $fID;
                $posting_box->tID = $tID;
                $posting_box->t_wiki_pageid = $t_wiki_pageid;
                
                $posting_box->javaCheck = 'onsubmit="return check_quickPost()"';
                $posting_box->url = awc_url.'post/todo_'.urlencode('add_post') ;
                
                //awc_pdie($subscribe_info);
                if(!$awcUser->guest){
                    $posting_box->subscribed_email = $subscribe_info['values']['subscribed_email'];
                    $posting_box->subscribed_list = $subscribe_info['values']['subscribed_list'];
                    $posting_box->subscribed_no = $subscribe_info['values']['subscribed_no'];
                }
                
                $html = $posting_box->box();
                unset($posting_box);
                $wgOut->addHTML($html);
            }
            
	return ;	
	}
    
    function load_post_phase_info($r){
    global $post_cls;
    
        
                    $post_cls->cat_id = $r->cat_id ;
                    $post_cls->cat_name = $r->cat_name ;
                    $post_cls->f_id = $r->f_id ;
                    $post_cls->f_name = $r->f_name ;
                    $post_cls->posting_message = $r->f_posting_mesage_tmpt ;
                    
                    $post_cls->t_id = $r->t_id ;
                    $post_cls->t_ann = $r->t_ann ;
                    $post_cls->t_pin = $r->t_pin ;
                    $post_cls->t_status = $r->t_status ;
                    $post_cls->t_name = $r->t_name ;
                    #$post_cls->t_topics = $r->t_topics ;
                    #$post_cls->t_hits = $r->t_hits ;
                    $post_cls->t_perm = $r->t_perm ;
                    $post_cls->t_poll = $r->t_poll ;
                    
                    $post_cls->p_id = $r->p_id ;
                    $post_cls->p_title = $r->p_title ;
                    $post_cls->p_post = $r->p_post ;
                    $post_cls->p_user = $r->p_user ;
                    $post_cls->p_userid = $r->p_userid ;
                    $post_cls->p_editwhy = $r->p_editwhy ;
                    $post_cls->p_editwho = $r->p_editwho ;
                    $post_cls->p_editdate = $r->p_editdate ;
                    $post_cls->p_date = $r->p_date ;
                    $post_cls->t_name = $r->t_name ;
        
    }
    
    
    function get_latest_post($tID, $no_redirect = false){
    global $awcs_forum_config;
    
        $limit = $awcs_forum_config->cfl_Thread_DisplayLimit  ;
        
        $dbr = wfGetDB( DB_SLAVE );
        // get number of threads so we can make the Page Blocks
        # do something different, maybe move to sessions ro somehting
        $r = $dbr->selectRow( 'awc_f_threads', 
                                    array( 't_topics', 't_postid'), 
                                    array( 't_id' => $tID ) );
        $TotalPosts  = $r->t_topics + 2 ;
        $Post_id  = $r->t_postid;
        
        
       if($TotalPosts > $limit){
           $start = ($TotalPosts - $limit);
            $url = awc_url . "st/id$tID/limit:$start,$limit/#post_$Post_id";
       } else {
            $url = awc_url . "st/id$tID/#post_$Post_id";
       }
       
       if($no_redirect) return $url; 
       
       return die(header('Location: ' . $url ));
        
    }
	

}
