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
* @filepath /extensions/awc/forums/forum.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcs_forum_listing(){
global $wgOut, $wgRequest, $action_url, $tplt, $awcUser;
    
    $forum_cls = New awcforum_forum();
    
    if(!$awcUser->canRead) return $wgOut->loginToUse();
    
       # $spl = explode("/", $action);
       # $todo = $spl[0];
        
       # if(isset($spl[1])){
          #  $id = str_replace('_', '', str_replace('id', '', $spl[1])) ;
       # } else {
        #   $id = $wgRequest->getVal( 'id' ) ; 
       # } 
        
       # if($skip) return ;
        $todo = $action_url['what_file'];
        $id = $action_url['id'];
        
        define('what_page', $todo );
        
        switch( $todo ) {
        
            case 'sc':
                     if(!is_numeric($id)) return awcs_forum_error('word_noforum') ;
                     $str = $forum_cls->display_forums($id);
                break;
                
            case 'subf':
                    if(!is_numeric($id)) return awcs_forum_error('word_noforum') ; 
                     $str = $forum_cls->subsribe($id);
                break;
                
            case 'sf':
                    if(!is_numeric($id)) return awcs_forum_error('word_noforum') ; 
                    $str = $forum_cls->ShowThreads($id);
                break;
                
            case 'fpw': 
                    $str = $forum_cls->checkForumPassword();
                break;
                
            default:
                   $str = $forum_cls->display_forums();
                   global $ForumStat;
                    
                   if(isset($ForumStat)){
                       
                               $word = array('forum_stats' => get_awcsforum_word('word_forum_stats'),
                                    'forum_stats_users' => get_awcsforum_word('word_forum_stats_users'),
                                    'forum_stats_threads' => get_awcsforum_word('word_forum_stats_threads'),
                                    'forum_stats_topics' => get_awcsforum_word('word_forum_stats_topics'),
                                    'forum_stats_maxusers' => get_awcsforum_word('word_forum_stats_maxusers'),
                                     );
                                     
                               $info['mems'] = number_format($ForumStat->stat_mems); // 2.5.8
                               $info['threads'] = number_format($ForumStat->stat_threads); // 2.5.8
                               $info['topics'] = number_format($ForumStat->stat_posts); // 2.5.8
                               $info['maxusers'] = number_format($ForumStat->stat_maxusers); // 2.5.8
                               
                               $stat_tplt = $tplt->phase($word, $info, 'footer_forum_stats', true);
                               unset($word, $stat, $info);
                                    
                               $str .= $stat_tplt;
                    }
                   
                   
                   
                break;
        }
        
        return $wgOut->addHTML($str);
        
    #$forum->enter_forum($action);

}

class awcforum_forum{
    
    var $MaxTitleCol;
    var $cf__forumname, $cf__forumsubtitle, $cf_forumsubscrip;
    
    var $html_ext;
    var $show_guest_ip;
     
    var $rDB;
     
    function __construct() {
    global $awcs_forum_config, $str_len ;
    
    
        $this->rDB = wfGetDB(DB_SLAVE);
        
         $this->html_ext = $awcs_forum_config->cf_html_extension;
         $this->show_guest_ip = $awcs_forum_config->cf_show_guest_ip ;
        
         $this->MaxTitleCol = $awcs_forum_config->cfl_Thread_MaxTitleLength_LastPostCol;
        
         $this->cf__forumname = $awcs_forum_config->forum_name ;
         $this->cf__forumsubtitle = $awcs_forum_config->forum_subtitle ;
         
         $this->cf_forumsubscrip = isset($awcs_forum_config->cf_forumsubscrip) ? $awcs_forum_config->cf_forumsubscrip : 0;
        
        if (function_exists('mb_strlen')) {
           $str_len = 'awc_mbstrlen'  ; 
        } else {
           $str_len = 'awc_strlen' ;
        }
        

    }
    
    
    
    public function checkForumPassword(){
    global $wgRequest, $wgOut, $awcUser;
    
    	#awc_pdie($wgRequest);
    	# fid
    	# pw
    	
    	$fid = $wgRequest->getVal( 'fid' );
    	$pw = $wgRequest->getVal( 'pw' );
    	$pw = awcsf_encode_password($pw);
    	
    	$dbr = wfGetDB( DB_SLAVE );
        $r = $dbr->selectRow( 'awc_f_forums', 
                array( 'f_password' ), 
                array( 'f_id' => $fid ) );
                
        if($pw == $r->f_password){
        	$_SESSION['forumPW'] = $_SESSION['forumPW'] . ',' . $fid;
        	$awcUser->pw[$fid] = $fid;
        }
        
	   
        $info['msg'] = 'word_CheckingPassword';
        $info['url'] = awc_url . 'sf/id' . $fid;
        return awcf_redirect($info);
       
        #$str = $this->ShowThreads($fid);
       # return $wgOut->addHTML($str);
        
    }
    
 
	 function display_forums($cID = NULL) {
	 global $WhoWhere, $awc_tables, $tplt;
     
        $perm = new awcs_forum_perm_checks();
           
        if($cID == null){
            $test['all'] = 'all';
            Set_AWC_Forum_SubTitle($this->cf__forumname, $this->cf__forumsubtitle, $test);
            $WhoWhere['type'] =  'forum' ;
            $WhoWhere['where'] =  'index' ;
            $WhoWhere['perm'] =  '*' ;
        }
         
        
		/*
        $sql = "SELECT c.cat_id,c.cat_order,c.cat_name, $cat_desc f.*
		        FROM {$awc_tables['awc_f_cats']} c, {$awc_tables['awc_f_forums']} f
				WHERE c.cat_perm IN ( ". UserPerm ." )
                AND f.f_perm <= ". UserPerm ." 
                AND c.cat_id=f.parent_id $SQL
                ORDER BY c.cat_order ASC, c.cat_name, f.f_order, f.f_name ASC ";
                */
        
		$c = $awc_tables['awc_f_cats'];
        $f = $awc_tables['awc_f_forums'];
        
        $cat_desc = '';
		if($cID != NULL) {
			$cat_desc = "$c.cat_desc, ";
			$cID = " AND $c.cat_id=$cID ";
		}
		
        $perm_where = $perm->cat_forum_sql();
        $sql = "SELECT $c.cat_id,$c.cat_order,$c.cat_name, $c.c_wiki_perm, $cat_desc $f.*
                FROM {$awc_tables['awc_f_cats']} , {$awc_tables['awc_f_forums']}
                WHERE $perm_where $c.cat_id=$f.f_parentid $cID
                ORDER BY $c.cat_order ASC, $c.cat_name, $f.f_order, $f.f_name ASC ";
               
		$res = $this->rDB->query($sql);
		
        $cats = array();
        $children = array();
        $last_c_id=null;
		while ($r = $this->rDB->fetchObject( $res )) {
            
                    $cat_id = $r->cat_id;
                    $cat_name = $r->cat_name;
                    $cat_perm = $r->c_wiki_perm;
                    
                    if($cID != NULL) $cat_desc = $r->cat_desc;
                    
                    if ($last_c_id != $r->cat_id) {
						             
								$cats[ $r->cat_id ] = array( 'id' => $r->cat_id,
													'position'    => $r->cat_order,
													'name'        => $r->cat_name,
													);
																   
								$last_c_id = $r->cat_id;
						}
                
				
                    $children[ $r->f_id ] = array( 'f_id' => $r->f_id,
											'f_parentid'    => $r->f_parentid,
											'f_name'        => $r->f_name,
											'f_desc'       => $r->f_desc,
											'f_threads'    => $r->f_threads,
											'f_replies'    => $r->f_replies,
											'f_lastdate'        => $r->f_lastdate,
											'f_lastuser'        => $r->f_lastuser,
                                            'f_lastuserid'        => $r->f_lastuserid,
											'f_lasttitle'        => $r->f_lasttitle,
											'f_threadid'        => $r->f_threadid,
													   );
				
		}
        $this->rDB->freeResult( $res );
        
        
         
        if($cID != NULL){
            
                $e = array();
                $e['cID'] =  $cat_id  ;
                Set_AWC_Forum_SubTitle(get_awcsforum_word('word_ForumsFor') . ' ' . $cat_name, $cat_desc, $e);
                unset($e);
                        
                Set_AWC_Forum_BreadCrumbs($cat_name, true);
                
                $w = explode('=', $cID);
                
                $WhoWhere['type'] =  'forum' ;
                $WhoWhere['where'] =  'cid' . $cID . '||awc-split||' . $cat_name ;
                $WhoWhere['perm'] =  $cat_perm ;
                    
        }
		
	    $str = self::process_all_cats($cats, $children, $cID);
	    
        unset($children);
        unset($cats);
        
	return $str;	
	}
	
	 function process_all_cats($cats, $children, $cat_link = null) {			
	 global $tplt;
    	
            $outHTML=null;
            
            $word_guest = get_awcsforum_word('word_guest');
            
            $word_header = array('topics' => get_awcsforum_word('word_topics'), 
                            'replies' => get_awcsforum_word('word_replies'),
                            'forum_last_post' => get_awcsforum_word('forum_last_post'),
                            );
                                
            foreach ($cats as $cat_id => $cat_data) {
				 
                 $html = $tplt->phase('', '', 'cat_open_table');
                 
                 
                $info['AdminEdit'] = (UserPerm == 10) ? '<a href="'. awc_url .'admin/cat/get_cat_id_edit/' . $cat_data['id'] .'">*</a> |  ' : null  ;
                $info['title'] = '<a href="'. awc_url . 'sc/id' . $cat_data['id'] . '/' . rawurlencode(str_replace('/', ' ', $cat_data['name'])) . $this->html_ext .'">'.$cat_data['name'].'</a>' ;
                
                if($cat_link != null) $info['title'] = $cat_data['name'] ;
                
                $html .= $tplt->phase($word_header, $info, 'cat_header');
                
				
					foreach ($children as $forum_id => $c) {
						if ($c['f_parentid'] == $cat_id) {
                            
                        
                            if($this->show_guest_ip == '0' AND $c['f_lastuserid'] == '0' AND UserPerm < 2){
                                $c['f_lastuser'] = $word_guest ;
                            } 
                            
                            $c['last_title'] = awcsforum_funcs::awc_html_entity_decode($c['f_lasttitle']);
                            $last_title = $c['last_title'];
                             if(isset($c['last_title']{$this->MaxTitleCol})) $c['last_title'] = awcsforum_funcs::awc_shorten($c['last_title'], $this->MaxTitleCol ) . "..." ;  
                            
                            
							$c['last_date'] = ($c['f_lastdate'] != '0000-00-00 00:00:00') ? awcsforum_funcs::convert_date($c['f_lastdate'], "s") : '&nbsp;';
                            
                            $c['mem_link'] = awcsforum_funcs::awcforum_url('mem_profile/' .$c['f_lastuser'] . '/'. $c['f_lastuserid']) ;
                            
                            $c['AdminEditLink'] = (UserPerm == 10) ? '<a href="'. awc_url . 'admin/forum/get_forum_id_edit/' . $c['f_id'] .'">*</a> | ' : null ;
                            $c['forum_link'] = awc_url . 'sf/id' . $c['f_id'] . '/' . rawurlencode(str_replace('/', ' ', $c['f_name'])) . $this->html_ext ;
                            
                           # die($last_title);
                            
                            $c['last_thread_link'] = awc_url . 'last_post/id' . $c['f_threadid'] .'/'.  rawurlencode(str_replace('/', ' ', $last_title)) . $this->html_ext;
                            
                            
                            $html .= $tplt->phase('', $c, 'cat_list_forums_rows');
                             
						}
					}
                    
                    
                $html .= $tplt->phase('', '', 'cat_close_table');
                
 
                $outHTML .= $html;
          }
          $tplt->kill('cat_open_table');
          $tplt->kill('cat_close_table');
          $tplt->kill('cat_list_forums_rows');
          unset($word_header, $c, $info);
			
            
	return $outHTML ;        
	}
	
    function ShowThreads($id) {
    global $LimitJump_top, $LimitJump_bot, $awcUser ;
    global $wgOut, $wgUser, $WhoWhere, $awc_tables, $numthreadcols, $tplt;  
    
        $perm = new awcs_forum_perm_checks();
        
        $thread_tools = new awcs_forum_thread_list_tools();
        
        $word_headers = array('replies' => get_awcsforum_word('word_replies'),
                        'views' => get_awcsforum_word('views'),
                        'last_action' => get_awcsforum_word('last_action'),
                        'started_by' => get_awcsforum_word('thread_title_started_by'),
                        );
                        
        
        $word = array('replies' => get_awcsforum_word('word_replies'),
                        'views' => get_awcsforum_word('views'),
                        'last_action' => get_awcsforum_word('last_action'),
                        'started_by' => get_awcsforum_word('forum_started_by'),
                        );

        $f_id = (int)$id;
        $sql = $this->rDB->selectSQLText( array( 'awc_f_forums','awc_f_cats' ), 
                   array( 'f_name, f_desc, f_top_tmplt, f_parentid, f_id, f_threads,
                 f_wiki_read_perm, f_wiki_write_perm, f_passworded, cat_name' ), 
                   "f_id={$f_id}", 
                   __METHOD__, 
                   array('OFFSET' => '0', 'LIMIT' => '1'),
                   array( 'awc_f_cats' => array('LEFT JOIN','cat_id=f_parentid')) );
                   
        $res = $this->rDB->query($sql);
        $r = $this->rDB->fetchRow( $res );
        $this->rDB->freeResult( $res );
        
        $forum_info= array();
        $forum_info['f_name'] = $r['f_name'] ;
        $forum_info['f_desc'] = $r['f_desc'] ;
        $forum_info['f_top_tmplt'] = $r['f_top_tmplt'] ;
        $forum_info['cid'] = $r['f_parentid'] ;
        $forum_info['cat_name'] = $r['cat_name'] ;
        $forum_info['fid'] = $r['f_id'] ;
        $forum_info['f_threads'] = $r['f_threads'] ;
        $forum_info['f_wiki_write_perm'] = $r['f_wiki_write_perm'] ;
        $forum_info['f_wiki_read_perm'] = $r['f_wiki_read_perm'] ;
        $forum_info['f_passworded'] = $r['f_passworded'] ;
        
        
        $WhoWhere['type'] =  'forum' ;
        $WhoWhere['where'] =  'cid' . $r['f_parentid'] . '|fid' .  $r['f_id'] . '||awc-split||' . $forum_info['f_name'] ;
        $WhoWhere['perm'] = $forum_info['f_wiki_read_perm'] ;
        
        unset($r, $res);
        
       // check for Forums Subscriptions
       if( $awcUser->isLoggedIn AND $this->cf_forumsubscrip == '1'){
        
            $m_forum_subsrib = array(); 
            $m_forum_subsrib = $awcUser->m_forum_subsrib ;
                    
            if(!empty($m_forum_subsrib)){
               
                     if(!array_key_exists($id, $m_forum_subsrib)){
                        $word_subscribe = get_awcsforum_word('word_subscribe');
                        $options_menu = null;
                     } else {
                         
                         $word_subscribe = get_awcsforum_word('word_unsubscrib');
                         $options_menu = get_awcsforum_word('word_youraresubscribed');
                         
                        if($awcUser->m_forum_subsrib[$id] == ''){
                            
                            $dbw = wfGetDB( DB_MASTER ); 
                            $awcUser->m_forum_subsrib[$id] = 'seen';
                            
                            awcsforum_funcs::get_table_names(array('awc_f_mems',
                                                    'awc_f_watchforums',));
                                            
                            $sql = "UPDATE {$awc_tables['awc_f_watchforums']} f 
                                        JOIN {$awc_tables['awc_f_mems']} m
                                        ON f.wtchf_mem_id=m.m_id 
                                        SET f.wtchf_sent=0, m.m_forum_subsrib='". serialize($awcUser->m_forum_subsrib) ."' 
                                    WHERE f.wtchf_forum_id = $id AND f.wtchf_mem_id = $awcUser->mId";
                                
                            $dbw->query($sql);
                        }
                        
                     }
                     
            } else {
                    $word_subscribe = get_awcsforum_word('word_subscribe');
                    $options_menu = null;
            }
            
       }
       
        $ann_threads = '<form name="mod_form" enctype="multipart/form-data" action="'.awc_url.'mod/" method="post">
                        <input name="todo" type="hidden" value="mod_thread">';
        
        
        # query for Announcement threads...
        $totalAnnocments = 0;
		$sql = "SELECT t.t_id,t.t_ann,t.t_pin,t.t_status,t.t_poll,t.t_name,t.t_starter,t.t_starterid,t.t_topics,t.t_hits,t.t_lastdate, t.t_lastuser, t.t_lastuserid, t.t_forumid 
				FROM {$awc_tables['awc_f_anns']} a
                INNER JOIN {$awc_tables['awc_f_threads']} t ON a.ann_id=t.t_id 
				ORDER BY t.t_lastdate DESC, t.t_name DESC ";         
                
        $res = $this->rDB->query($sql);
        $a=null;
        $sa=null;
        $to_skin = array();
        
		while ($r = $this->rDB->fetchObject( $res )) {
			$a++;
            
            if ($a == 1) {
                // create announcements header
                $to_skin['col_5_isSearch_forum_name'] = '';
                $to_skin['tr_id'] = 'id="annc"';
                $to_skin['first_col_name'] = get_awcsforum_word('announcement');
                $ann_threads .= $tplt->phase($word_headers, $to_skin, 'thread_list_header');
                unset($to_skin);
            }
            
            /*
             check if threads being looped are part of the current forum
             if so, count them for the "math" in the thread-display-limit
            */
            if($r->forum_id == $id) $totalAnnocments++;
			
            $to_skin = $thread_tools->loop_thread_list($r);
            $ann_threads .= $tplt->phase($word, $to_skin, 'thread_list_rows');
            
           // unset($to_skin);
		}
        
        $this->rDB->freeResult( $res );
        unset($r, $res);
        
		if ($a >= 1)$ann_threads .= "</table><br />";
        
        $can_read = $perm->can_read($forum_info['f_wiki_read_perm']);
            
            if(!$can_read){
                global $wgOut;
                $wgOut->addHTML($ann_threads);
                return awcs_forum_error('no_forum_read_perm');
            }
            
            if(!isset($awcUser->pw)){
            	$awcUser->pw[0]=0;
            }
            if($perm->is_password($forum_info['f_passworded']) AND !in_array($id, $awcUser->pw)){
                // show Announcement's then password field
                
                Set_AWC_Forum_SubTitle($forum_info['f_name'], $forum_info['f_desc'], '');
        
                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sc/id' . $forum_info['cid'] . '">' . $forum_info['cat_name'] .'</a>');
                Set_AWC_Forum_BreadCrumbs(strtr($forum_info['f_name'], "_", " "), true);
                
                global $wgOut;
                $password_field = '<br /><hr />' . get_awcsforum_word('forum_passworded'). '<hr />';
                $password_field .= '</form><form action="'.awc_url.'fpw" method="post"  enctype="multipart/form-data">
                <input name="fid" type="hidden" value="'.$id.'">
                <input name="pw" type="password" size="20">
                <input type="submit" value="'.get_awcsforum_word('submit').'">
                </form><br /><br />';
                
                $wgOut->addHTML($ann_threads . $password_field);
                
                return ;
            }
            
            
            $post_button = '';
            if($awcUser->canPost AND $perm->can_post($forum_info['f_wiki_write_perm'])) {
               $word1['start_new_thread']  = str_replace(' ', '&nbsp;', get_awcsforum_word('start_new_thread'));
               $info['url'] = awc_url .'post/todo_new_t/id'.$id ;
               $post_button = $tplt->phase($word1, $info, 'forum:start_new_thread');
            }
            $tplt->kill('forum:start_new_thread');
            
            
        // add templet after anncoments... todo
        if(strlen($forum_info['f_top_tmplt']) > 1){
            $ann_threads .= add_tmpl_to_skin($forum_info['f_top_tmplt']) ;
        }
        
		$TotalPosts = intval($forum_info['f_threads'] - $totalAnnocments);
        $total['TotalPosts'] = $TotalPosts;
        $limit = GetLimit($total, 'cat'); 
        
        if( $awcUser->isLoggedIn AND $this->cf_forumsubscrip == '1'){
            $info['url'] = awc_url .'post/fsub/id' . $id ;
            $word1['subscrib'] = $word_subscribe ;
            $sb = $tplt->phase($word1, $info, 'forum:subscrib_to_forum');
        } else {
            $sb = null;
        }
        unset($word1);
        $tplt->kill('forum:subscrib_to_forum');
        
        
         // add tplt, start new thread button, subscrib, page jumps
         $info['jump'] = $LimitJump_top ;
         $info['new_thread_button'] = $post_button ;
         $info['subscrib_button'] = $sb;
         $html = $tplt->phase('', $info, 'thread_list_header_menu', true);
         unset($info);
         
         
         $info['col_5_isSearch_forum_name'] = '';
         $info['tr_id'] = null;
         
         $info['first_col_name'] = (UserPerm >=2 ) ? '<INPUT type="checkbox" name="checkbox_toggle" onChange="return checkall_toggle(\'mod_form\',\'tID[]\', this.checked)">  ' : null;
         
         $info['first_col_name'] .= get_awcsforum_word('thread_title');
         
         $html .= $tplt->phase($word_headers, $info, 'thread_list_header', true);
         unset($info, $word_headers);
         
         
        $limit = str_replace('LIMIT ', '', $limit);
        $limitSPLIT = explode(',', $limit);
        $offset = (isset($limitSPLIT[0])) ? $limitSPLIT[0] : 0 ;
        $limit = (isset($limitSPLIT[1])) ? $limitSPLIT[1] : 15 ;
        
        $t_forumid = (int)$id;
        $sql = $this->rDB->selectSQLText( array( 'awc_f_threads' ), 
                   array( 't_id,t_ann,t_pin,t_status,t_poll,t_name,t_starter,t_starterid,t_topics,t_hits,t_lastdate,t_lastuser,t_lastuserid' ), 
                   "t_forumid=$t_forumid AND t_ann=0", 
                   __METHOD__, 
                   array('OFFSET' => $offset, 'LIMIT' => $limit, 'ORDER BY' => 't_pin DESC, t_lastdate DESC,t_name')
                  );
        
		$res = $this->rDB->query($sql);
        $isThreads = false ;
        $thread_tools->thread_count = 0;
		while ($r = $this->rDB->fetchObject( $res )) {
            $isThreads = true;
            
            $to_tplt = $thread_tools->loop_thread_list($r);
            $html .= $tplt->phase($word, $to_tplt, 'thread_list_rows');
            
		}
        $this->rDB->freeResult( $res );
        unset($r, $res);
        $tplt->kill('thread_list_rows');
        
        
       
        
        if(!$isThreads){
            
            //  keep this here...
            $tplt->add_tplts(array("'empty_forum'",) ,true);
                                
            $info['new_thread_button'] = $post_button ;
            $info['subscrib_button'] = $sb;
            $word['empty_forum'] = get_awcsforum_word('word_emptyforum');
            
            $html = $tplt->phase($word, $info, 'empty_forum', true);
        }
         
		$html .= "</table>";
        
        
        $e = array();
        $e['fID'] =  $id ;
        $e['cID'] =  $forum_info['cid']  ;
        Set_AWC_Forum_SubTitle($forum_info['f_name'], $forum_info['f_desc'], $e);
	   unset($e);
        
        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sc/id' . $forum_info['cid'] . '">' . $forum_info['cat_name'] .'</a>');
        $BreadCrumb = Set_AWC_Forum_BreadCrumbs(strtr($forum_info['f_name'], "_", " "), true);
      
   #   
   #   
      
        $info['page_jumps'] = ($LimitJump_bot) ? $LimitJump_bot : null; 
        
        if((UserPerm >=2)){
                          
            $words['ann'] = get_awcsforum_word('thread_makeAnnouncement'); 
            $words['unann'] = get_awcsforum_word('thread_UnMakeAnnouncement');                           
            $mod['ann'] = (UserPerm >=10) ? $tplt->phase($words, '', 'thread_listing_mod_drop_ann') : null;
            $tplt->kill('thread_listing_mod_drop_ann');
            
            $words['pinn'] = get_awcsforum_word('pinned_word');
            $words['unpinn'] = get_awcsforum_word('pinnedUn_word');
            
            $words['lock'] = get_awcsforum_word('lockThread_word');
            $words['unlock'] = get_awcsforum_word('lockThreadUn_word');
            
            $words['move'] = get_awcsforum_word('mod_movethread');
            $words['delete'] = get_awcsforum_word('delete');
            
            $words['mod_options'] = get_awcsforum_word('mod_post');
            
            $info['page_jumps'] = ' ' . $tplt->phase($words, $mod, 'thread_listing_mod_drop', true) . $info['page_jumps'];
            unset($words, $mod);
        } 
        
        $info['BreadCrumb'] = $BreadCrumb ;
        $html .= $tplt->phase($word, $info, 'bottom_page_jumps', true);
		
	return $ann_threads . $html . '</form>' ;	
	}
    

}