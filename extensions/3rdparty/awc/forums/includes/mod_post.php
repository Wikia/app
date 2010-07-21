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
* @filepath /extensions/awc/forums/includes/mod_post.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcs_forum_mod_options(){
global $wgRequest, $action, $wgOut;
	
    $mod = new awcs_forum_mod_post();
    
    $mod->todo = $wgRequest->getVal('todo');
    $mod->do_what = $wgRequest->getVal('do_what');
    
    if(isset($_POST['tID'])){
        $mod->tID = $_POST['tID'];
    } else {
        $mod->tID = array(0 => $wgRequest->getVal('tID'));
    }
    
    if(!is_array($mod->tID)) $mod->tID = array(0 => $mod->tID); 
    
    $url_spl = explode('/', $wgRequest->action);
    
    
    if(!isset($mod->tID) OR empty($mod->tID) OR $mod->tID == '' OR $mod->tID[0] == ''){
        if(isset($url_spl[3])) $mod->tID = array(0 => $url_spl[3]);
    }
    if(!isset($mod->tID) OR empty($mod->tID) OR $mod->tID == '') return ;
    
    
    if(!isset($mod->todo) OR empty($mod->todo) OR $mod->todo == ''){
        $mod->todo = $url_spl[1];
    }
    if(!isset($mod->todo) OR empty($mod->todo) OR $mod->todo == '') return ;
    
    
    if(!isset($mod->do_what) OR empty($mod->do_what) OR $mod->do_what == ''){
        $mod->do_what = $url_spl[2] ;
    }
    
    if(!isset($mod->do_what) OR empty($mod->do_what) AND ($mod->todo !='single_thread_mod')) return ;
    
    
    switch($mod->do_what){
    
        case 'delete':
            if (!CanDelete()){
                    $wgOut->loginToUse();
                    return ;
             }
        break; 
        
        default:
            if(!UserPerm >=2) die("Nope - Mod...");
        break; 
        
    }
    
    
    switch($mod->todo){
    
        case 'mod_thread':
            $mod->mod_thread();
        break; 
        
        case 'single_thread_mod':
            $mod->single_thread_mod();
        break; 
        
        case 'mod_post':
            $mod->mod_post();
        break; 
        
        
    
    }
    

}

class awcs_forum_mod_post{

var $todo, $do_what;
var $tID = array();

    function __construct() {
        
                awcsforum_funcs::get_table_names(array('awc_f_anns',
                                        'awc_f_polls',
                                        'awc_f_posts',
                                        'awc_f_forums',
                                        'awc_f_cats',
                                        'awc_f_threads',
                                        'awc_f_watchthreads',
                                        'awc_f_watchforums',)); // Get all the forums d-base table names, check for table pre-fix
                                          
        
        
    }
    
    
    function single_thread_mod(){
        global $wgRequest ;
        
        
        $tID = $wgRequest->getVal('tID');
        $this->tID = array(0 => $tID);
        
        $fID = $wgRequest->getVal('fID');
        $pID = $wgRequest->getVal('pID');
        
        $ann = $wgRequest->getVal('ann');
        $ann = ($ann == 'on') ? 1: 0;
        self::ann_thread($ann, true);
        
        $sticky = $wgRequest->getVal('sticky');
        $sticky = ($sticky == 'on') ? 1: 0;
        self::pin_thread($sticky, true);
        
        $lock = $wgRequest->getVal('lock');
        $lock = ($lock == 'on') ? 1: 0;
        self::pin_lock($lock, true);
        
        $move = $wgRequest->getVal('move');
        if($move == 'on') return self::movethread_form();
        
        
        $info['msg'] = 'thread_has_been_modded';
        $info['url'] = awc_url . "st/id" . $tID ;
        
        return awcf_redirect($info);
    }
    
    
    
    
    function mod_thread(){
    
        switch($this->do_what){
        
            case 'delete':
                self::delete_thread();
            break; 
            
            case 'pin':
                self::pin_thread(1);
            break; 
            case 'unpin':
                self::pin_thread(0);
            break; 
            
            case 'lock':
                self::pin_lock(1);
            break; 
            case 'unlock':
                self::pin_lock(0);
            break;
            
            
            case 'ann':
                self::ann_thread(1);
            break; 
            case 'unann':
                self::ann_thread(0);
            break;
            
            
            case 'move':
                self::movethread_form();
            break; 
            case 'do_movethread':
                self::do_movethread();
            break; 
            
            
            case 'splitmerge_get':
                self::splitmerge_get($this->tID);
            break; 
            
            case 'do_split':
                self::do_split();
            break; 
            
            case 'do_merge':
                self::do_merge();
            break; 
        
        }
    
    }
    
    
    function mod_post(){
    
        switch($this->do_what){
        
            case 'delete':
                self::delete_post();
            break; 
        
        }
    
    } 
    
    
    
    function delete_post($no_redirect = false){
    global $wgOut, $ForumStat, $awc_tables, $awcs_forum_config;
                 
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
            if(isset($awcs_forum_config->cf_add_post_text_to_wiki) AND $awcs_forum_config->cf_add_post_text_to_wiki == '1'){
                require_once(awc_dir . 'includes/to_wiki_dbase.php');
                $ws = new awcs_forum_wikisearch_cls();
            }
        
        $tID = null;
        foreach($this->tID as $id){
        
                $sql = "SELECT t.t_ann, t.t_topics, t.t_name, t.t_starter,
                                t.t_wiki_pageid,
                                p.p_post, p.p_editdate, p.p_wiki_ver_id, p.p_wiki_hidden, p.p_title,
                                p.p_threadid, p.p_forumid, p.p_date, p.p_user, p.p_userid, f.f_replies
                        FROM  {$awc_tables['awc_f_posts']} p
                            JOIN {$awc_tables['awc_f_threads']} t
                                ON p.p_threadid=t.t_id
                            JOIN {$awc_tables['awc_f_forums']} f
                                ON p.p_forumid=f.f_id
                        WHERE p.p_id={$id}";
                        
                        
              
                $res = $dbr->query($sql);
                $r = $dbr->fetchRow( $res );
                $dbr->freeResult( $res );
                
                $tID = $r['p_threadid'];
                
                $p_editdate = $r['p_editdate'];
                $p_post = $r['p_post'];
                $p_title = $r['p_title'];
                
                $t_wiki_pageid = $r['t_wiki_pageid'];
                $p_wiki_hidden = $r['p_wiki_hidden'];
                $p_wiki_ver_id = $r['p_wiki_ver_id'];
                
                $fID = $r['p_forumid'];
                $p_date = $r['p_date'];
                $t_name = $r['t_name'];
                //$t_topics = $r['t_topics'];
                $t_topics = intval($r['t_topics'] -1); 
                $f_replies = intval($r['f_replies'] -1);
                $t_ann = $r['t_ann'];
                $p_user = $r['p_user'];
                $p_userid = $r['p_userid'];

                
                if ( !CanDelete($p_user) ){
                    $wgOut->loginToUse();
                    return ;
                }
                
                if($t_ann == "1" and UserPerm != 10){
                        $wgOut->loginToUse();
                        return ;
                 }
                 
                # DIE("> $tID");
                 if($tID == null OR $tID == ''){
                    return awcs_forum_error('problem_deleting_post');
                 }
                 
                
                    if(isset($awcs_forum_config->cf_add_post_text_to_wiki) AND $awcs_forum_config->cf_add_post_text_to_wiki == '1'){
                            
                            $ws->tID = $tID;
                            $ws->pID = $id;
                            
                            $ws->pageID = $t_wiki_pageid;
                            $ws->old_p_wiki_ver_id = $p_wiki_ver_id;
                            $ws->old_p_wiki_hidden = $p_wiki_hidden;
                            $ws->old_post_text = $p_post . ' ' . $p_title;
                            
                            $ws->delete_post();
                    }
                    

                $dbw->delete( 'awc_f_posts', array( 'p_id' => $id ), '');
                
                $sql = $dbr->selectSQLText( array( 'awc_f_posts' ), 
									        array( 'p_id, p_user, p_userid, p_date, p_forumid, p_threadid' ), 
									        "p_threadid=$tID", __METHOD__, 
									        array('OFFSET' => '0', 'LIMIT' => '1', 'ORDER BY' => 'p_date ASC'));
                
                $res = $dbr->query($sql);
                
                $post_count = 0;
                while($r = $dbr->fetchRow( $res )){
                    ++$post_count;
                    
                        $new_id = $r['p_id'];
                        $new_p_user = $r['p_user'];
                        $new_p_userid = $r['p_userid'];
                        $new_name = $r['p_user'];
                        $new_lastdate = $r['p_date'];
                        $thread_id = $r['p_threadid'];
                        
                }
                $dbr->freeResult( $res );
                
                
                 // update_thread_last_post
                 
                 
               // die(">" . $post_count);
                

                                    
                $dbw->update( 'awc_f_forums',
                                    array(  'f_replies'     => $f_replies,), 
                                    array('f_id' => $fID),
                                    '' ); 
                                    
               /*  
                $sql = "SELECT f.f_id 
                        FROM {$awc_tables['awc_f_forums']} f 
                        WHERE f.f_id=$fID AND f.f_threadid=$thread_id" ;
                $res = $dbw->query($sql);
                $r = $dbw->fetchRow( $res );
                
                if(isset($r['f_id']) AND !empty($r['f_id'])){
                        
                    $dbw->update( 'awc_f_forums',
                                    array(  'f_replies'     => $f_replies,
                                            'f_lasttitle'     => $t_name,
                                            'f_lastdate'     => $new_lastdate,
                                            'f_threadid'     => $thread_id,
                                            'f_lastuserid'     => $p_userid,
                                            'f_lastuser'  => $p_user,), 
                                    array('f_id' => $fID),
                                    '' ); 
                                    
                } else {
                    
                    $dbw->update( 'awc_f_forums',
                                    array(  'f_replies'     => $f_replies,), 
                                    array('f_id' => $fID),
                                    '' ); 
                
                }
                */
                
               
               if($p_userid != 0){
                   
                        $user_get = array();
                        $user_get[] = 'm_posts';
                        $user_get[] = 'm_idname';
                        
                        $posting_user_info = GetMemInfo($p_userid, $user_get);
                        unset($user_get);
                        
                        if(strlen($posting_user_info['name']) > 0){
                            
                            $dbw->update( 'awc_f_mems',
                                            array('m_posts' => intval($posting_user_info['m_posts'] - 1)), 
                                            array('m_id' => $p_userid),
                                            '' );
                        }
                        
               }
                
                
                
                if(isset($ForumStat)) $ForumStat->stat_posts(false);
 
                 if($post_count == 0){
                     
                         $this->tID[0] = $tID;
                        return self::delete_thread();
                    
                 }
                 
                 
                $dbw->update( 'awc_f_threads',
                                    array(  't_topics'     => $t_topics,
                                            't_lastdate'     => $new_lastdate,
                                            't_lastuser'     => $new_p_user,
                                            't_lastuserid'     => $new_p_userid,), 
                                    array('t_id' => $tID),
                                    '' );
                 
                
                $cutoff_limit = $awcs_forum_config->cfl_Post_DisplayLimit;
                if($t_topics >= $cutoff_limit) {
                     $limit = '/limit:'. ($t_topics - 1) . ',' . $cutoff_limit;
                 } else {
                    $limit = null;
                 }
                 
                 
                 
              
                
        }
        
        if($no_redirect) return ;
          
        $info['msg'] = 'post_has_been_deleted';
        $info['url'] = awc_url . "st/id" .$tID . $limit ;
        return awcf_redirect($info);
        
    }

    function movethread_form(){
    global $wgOut, $tplt, $awc_tables ;  
     
    		if ( UserPerm < 2 ) return $wgOut->loginToUse();
    		
            $tplt->add_tplts(array("'move_threads'",), true );
            
            $info['thread_ids'] = null;
            foreach($this->tID as $tID){
                $info['thread_ids'] .= '<INPUT type="hidden" name="tID[]" value="'.$tID.'">';
            }
            
            #die(">". UserPerm);
                    
            $dbr = wfGetDB( DB_SLAVE );
            $sql = "SELECT * FROM {$awc_tables['awc_f_forums']} WHERE f_perm <= '".  UserPerm . "'" ;
            #$sql = "SELECT * FROM {$awc_tables['awc_f_forums']} WHERE f_perm <= ". intval( UserPerm ) ."";
            $res = $dbr->query($sql);
            
            $info['forums_select'] = '<SELECT NAME="fIDs">';
                while ($r = $dbr->fetchObject( $res )) {
                    $info['forums_select'] .= '<option value="'. $r->f_id  .'">'. $r->f_name  .'</option>';
                }
            $dbr->freeResult( $res );
        
            $info['forums_select'] .= '</SELECT>';
            
            $word['MoveThreadTitle'] = str_replace("|$|",  get_awcsforum_word('threads') , get_awcsforum_word('move_to')) ;
            $word['submit'] = get_awcsforum_word('submit'); 
            
            Set_AWC_Forum_SubTitle($word['MoveThreadTitle'] , get_awcsforum_word('move_to'), '');
                                      
            $out = $tplt->phase($word, $info, 'move_threads', true) ;
            
            $wgOut->addHTML($out);
            
    }

    function do_movethread(){
    global $awc_tables, $wgRequest;
    
    
        $new_fID = $wgRequest->getVal('fIDs');
        
        $dbw = wfGetDB( DB_MASTER ); 
        $dbr = wfGetDB( DB_SLAVE );
        
        foreach($this->tID as $tID){
            
                $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_forumid, t_topics' ), "t_id=$tID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                             
                $current_fID = $r->t_forumid; 
                $t_topics = $r->t_topics;   
                
                $sql = "UPDATE {$awc_tables['awc_f_forums']} 
                        SET f_threads = f_threads - 1,
                        f_replies = f_replies - '$t_topics'";
                $sql .= " WHERE f_id =" . $current_fID ;
                $dbw->query($sql);
                
                
                $sql = "UPDATE {$awc_tables['awc_f_forums']} 
                        SET f_threads = f_threads + 1,
                         f_replies = f_replies + '$t_topics'";
                $sql .= " WHERE f_id =" . $new_fID;
                $dbw->query($sql);
        
            
               $dbw->update( 'awc_f_posts',
                    array(  'p_forumid'     => $new_fID,), 
                    array('p_threadid' => $tID),
                    '' );
                
               $dbw->update( 'awc_f_threads',
                    array(  't_forumid'     => $new_fID,),
                    array('t_id' => $tID),
                    '' );
        
        }
        
        $this->update_forum_last_thread($new_fID);
        $this->update_forum_last_thread($current_fID);
        
        $info['msg'] = 'thread_has_been_moved';
        $info['url'] = awc_url . "sf/id" . $new_fID ;
        return awcf_redirect($info);
    
    
    }
    
    function ann_thread($todo, $no_redirect = false){
    global $wgOut, $awc_tables, $ForumStat;
    
           if ( UserPerm < 10 ) return $wgOut->loginToUse();
                       
           $dbw = wfGetDB( DB_MASTER );
           $dbr = wfGetDB( DB_SLAVE ); 
            
          foreach($this->tID as $tID){
                
                $dbw->delete( 'awc_f_anns', array( 'ann_id' => $tID ), '');
                
                if($todo == '1') $dbw->insert( 'awc_f_anns', array( 'ann_id' => $tID,) );
                 
                $dbw->update( 'awc_f_threads',
                                array(  't_ann'     => $todo,), 
                                array('t_id' => $tID),
                                '' ); 
         }            
        
        $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_forumid' ), "t_id=$tID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                                
        $fID = $r->t_forumid;
        
        if($no_redirect) return ;
         
        if($todo == 1){                              
            $info['msg'] = 'thread_has_been_ann';
        } else {
            $info['msg'] = 'thread_has_been_unann';
        }
        
       
        $info['url'] = awc_url . "sf/id" . $fID ;
        return awcf_redirect($info);                
                            
    }
      
    function pin_thread($todo, $no_redirect = false){
    global $awc_tables, $ForumStat;
    
            $dbw = wfGetDB( DB_MASTER ); 
            $dbr = wfGetDB( DB_SLAVE );
            
            foreach($this->tID as $tID){
                $dbw->update( 'awc_f_threads',
                                array('t_pin'     => $todo,), 
                                array('t_id' => $tID),
                                '' ); 
            }
                            
        
        $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_forumid' ), "t_id=$tID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                             
        $fID = $r->t_forumid;
               
        if($no_redirect) return ;
         
        if($todo == 1){                              
            $info['msg'] = 'thread_has_been_pinned';
        } else {
            $info['msg'] = 'thread_has_been_unpinned';
        }
        
       
        $info['url'] = awc_url . "sf/id" . $fID ;
        return awcf_redirect($info);                
                            
    }  
    
    function pin_lock($todo, $no_redirect = false){
    global $awc_tables, $ForumStat;
    
    
            $dbw = wfGetDB( DB_MASTER ); 
            $dbr = wfGetDB( DB_SLAVE );
            foreach($this->tID as $tID){
                $dbw->update( 'awc_f_threads',
                                array('t_status'     => $todo,), 
                                array('t_id' => $tID),
                                '' ); 
            }
                            
        
        $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_forumid' ), "t_id=$tID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                                
        $fID = $r->t_forumid;   

        
        if($no_redirect) return ;
        
         
        if($todo == 1){                              
            $info['msg'] = 'thread_has_been_locked';
        } else {
            $info['msg'] = 'thread_has_been_unlocked';
        }
        
        $info['url'] = awc_url . "sf/id" . $fID ;
        return awcf_redirect($info);                
                            
    }
    
    function delete_thread(){
    global $wgOut, $awc_tables, $ForumStat, $awcs_forum_config;
    
        if ( !CanDelete() ){
                $wgOut->loginToUse();
                return ;
         }
          
         
         
         if(isset($awcs_forum_config->cf_add_post_text_to_wiki) AND $awcs_forum_config->cf_add_post_text_to_wiki == '1'){
                require_once(awc_dir . 'includes/to_wiki_dbase.php');
                $ws = new awcs_forum_wikisearch_cls();
         }
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $fID = null;
        $threads = 0;
        $posts = 0;
           foreach($this->tID as $id){   
               
           ++$threads;    
                                   
                   $sql = "SELECT t.t_ann, t.t_forumid, t.t_topics, t.t_starterid, t.t_wiki_pageid 
                            FROM  {$awc_tables['awc_f_threads']} t
                            WHERE t.t_id=$id LIMIT 1";
                    
                    $res = $dbr->query($sql);
                    $r = $dbr->fetchRow( $res );
                    $dbr->freeResult( $res );
                    
                    $fID = $r['t_forumid'];
                    $page_ID = $r['t_wiki_pageid'];
                    
                    $t_starterid = $r['t_starterid'];
                    $t_ann = $r['t_ann'];
                    
                    
                    
                     if($t_ann == "1" and UserPerm != 10){
                            $wgOut->loginToUse();
                            return ;
                     }
                 
                 
                    if($fID == null OR $fID == ''){
                        return awcs_forum_error('problem_deleting_thread');
                    }
                 
                 
                    $user_get = array();
                    $user_get[] = 'm_topics';
                    $user_get[] = 'm_idname';
                    $n = GetMemInfo($t_starterid, $user_get);
                    unset($user_get);
                    $m_name = $n['name'];
                    if($m_name){
                        $dbw->update( 'awc_f_mems',
                                        array('m_topics' => ($n['m_topics'] - 1),), 
                                        array('m_id' => $t_starterid),
                                        '' );
                    }
                    unset($user_get, $n);
                    
                $user_get = array();
                $user_get[] = 'm_posts';
                $user_get[] = 'm_idname';
                 
                  # get members how created a post in thread... this is abit half-assed, but it works - 
                $sql = "SELECT p_userid FROM {$awc_tables['awc_f_posts']} WHERE p_threadid=$id LIMIT 1" ;
                $res = $dbr->query($sql);
                 while ($r = $dbr->fetchObject( $res )) {
                     
                     if(isset($r->p_userid)){
                     
                             if(isset($ForumStat)) $ForumStat->stat_posts(false);
                              
                             ++$posts; // use this for the forums post count math...
                            
                            $p_userid = $r->p_userid;
                            
                            $n = GetMemInfo($p_userid, $user_get);
                            $name = $n['name'];
                             if($name){
                                $dbw->update( 'awc_f_mems',
                                                array('m_posts' => ($n['m_posts'] - 1)), 
                                                array('m_id' => $p_userid),
                                                '' );
                                }
                     
                     }

                
                }
                $posts = ($posts - 1);  // half/assed  - top loop create one too many 
                if(isset($ForumStat)) $ForumStat->stat_posts(1); // half/assed - top loop create one too many   
                
                $dbr->freeResult( $res );    
                unset($user_get, $n);
               
               
                if(isset($awcs_forum_config->cf_add_post_text_to_wiki) AND $awcs_forum_config->cf_add_post_text_to_wiki == '1'){
                        
                        $ws->pageID = $page_ID;
                        $ws->delete_thread();
                }
                
                
                if(isset($ForumStat))$ForumStat->stat_threads(false);
                              
        }
        
        
         $dbw->query( "DELETE FROM {$awc_tables['awc_f_posts']} WHERE p_threadid IN (".implode(',', $this->tID).")");
         $dbw->query( "DELETE FROM {$awc_tables['awc_f_threads']} WHERE t_id IN (".implode(',', $this->tID).")");
         $dbw->query( "DELETE FROM {$awc_tables['awc_f_anns']} WHERE ann_id IN (".implode(',', $this->tID).")");
         $dbw->query( "DELETE FROM {$awc_tables['awc_f_watchthreads']}  WHERE wtcht_thread_id IN (".implode(',', $this->tID).")");
         // polls ???
         
        $dbw->query( "UPDATE {$awc_tables['awc_f_forums']} 
                        SET f_threads = f_threads - {$threads},
                            f_replies = f_replies - {$posts}
                        WHERE f_id={$fID}");  
                                      
        unset($dbr, $r, $res);
                                    
        $this->update_forum_last_thread($fID);
        
        $info['msg'] = 'thread_has_been_deleted';
        $info['url'] = awc_url . "sf/id" . $fID ;
        return awcf_redirect($info);
        
    }
    

    function splitmerge_get($id){
     global $wgOut, $tplt, $awc_tables;   
        
        if ( UserPerm < 2 ) return $wgOut->loginToUse();
             
        $id = $id[0];
        
        awcsforum_funcs::get_page_lang(array('lang_txt_thread')); // get lang difinitions... 
        Set_AWC_Forum_SubTitle(get_awcsforum_word('word_split_merge'), ''  );
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_split_merge'), true);
        
        $dbr = wfGetDB( DB_SLAVE );
        
        $r = $dbr->selectRow( 'awc_f_posts', 
                                array( 'p_title' ), "p_id=$id" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
        $title = $r->p_title;
        unset($r);
        $sql = "SELECT f_id, f_name FROM {$awc_tables['awc_f_forums']} WHERE f_perm <= '". UserPerm ."' ORDER BY f_order ASC ";
        
        $info['forums_dropdown'] = '<select name="fID">';
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            $info['forums_dropdown'] .= '<option value="'.$r->f_id.'">'.$r->f_name.'</option>';  
            
        }
        $dbr->freeResult( $res );
        unset($dbr, $r, $res);
        
        $info['forums_dropdown'] .= '</select>';
        
        $info['pID'] = $id;
        
        $word['word_create_new_thread'] = get_awcsforum_word('word_create_new_thread');
        $word['word_thread_title_for_new_thread'] = get_awcsforum_word('word_thread_title_for_new_thread');
        $word['submit'] = get_awcsforum_word('submit');
        $word['word_merge_this_post_to_this_thread'] = get_awcsforum_word('word_merge_this_post_to_this_thread');
        
        
        $tplt->add_tplts(array("'split_and_merge'",), true );
        $out = $tplt->phase($word, $info, 'split_and_merge', true) ;
            
        $wgOut->addHTML($out);
        
    }
    
    
    function do_split(){
    global $awcUser, $awc_tables, $wgRequest, $awcs_forum_config;
        
            if ( UserPerm < 2 ) return $wgOut->loginToUse();
            
            require(awc_dir . 'post.php');
            $post_cls = new awcsforum_post_cls();
            
            $pID = $this->tID[0];
            
            $dbr = wfGetDB( DB_SLAVE );
            
            $r = $dbr->selectRow( 'awc_f_posts', 
                                array( '*' ), "p_id=$pID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                                
            $this->tID = array(0 => $pID);
            $post_cls->post = $r->p_post ;
            $post_cls->cur_memID = $r->p_userid;
            $post_cls->cur_memName = $r->p_user;
            
            unset($dbr, $r);
            
            $user_get = array();
            $user_get[] = 'm_id';
            $user_get[] = 'm_posts';
            $user_get[] = 'm_topics';
            $mem_Info = GetMemInfo($post_cls->cur_memID, $user_get);
            unset($user_get);
            
            $post_cls->cur_m_posts = $mem_Info['m_posts'];
            $post_cls->cur_m_topics = $mem_Info['m_topics'];
            $post_cls->mName = $post_cls->cur_memName;
            unset($mem_Info);
            
            
            $title = trim($wgRequest->getVal( 't_title' ));
            $post_cls->title = $post_cls->CleanThreadTitle($title) ;
            
            $post_cls->fID = $wgRequest->getVal('fID') ;
            $post_cls->is_poll = false ;
            $post_cls->subscrib_what = 'no' ;
            $post_cls->forum_Antispam = '';
            
            $post_cls->ann = '0';
            $post_cls->sticky = '0';
            $post_cls->lock = '0';
            
            $post_cls->cf_threadsubscrip = $awcs_forum_config->cf_threadsubscrip;
            $post_cls->cf_forumsubscrip = $awcs_forum_config->cf_forumsubscrip;
            
            $post_cls->add_thread();
            
            self::delete_post(true);
    
    }
    
    
    
    
    
    function do_merge(){
     global $wgRequest, $awc_tables;
    
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $this->tID = $wgRequest->getVal( 'tID' );
        $this->pID = $wgRequest->getVal( 'pID' );
        
        $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_forumid, t_topics' ), "t_id={$this->tID}" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                                
        $new_forum_id = $r->t_forumid ;
        $new_t_topics = $r->t_topics  ;
        $new_t_topics = ($new_t_topics + 1);
        
        if($new_forum_id == '') return awcs_forum_error( get_awcsforum_word('word_no_thread_id_for_move') . ' ' . $this->tID);
        
       # die(">" . $this->pID);
        $sql = $dbr->selectSQLText( array( 'awc_f_posts', 'awc_f_threads' ), 
                   array( 'p_threadid, p_forumid, t_topics' ), 
                   "p_id={$this->pID}", 
                   __METHOD__, 
                   array('OFFSET' => '0', 'LIMIT' => '1'),
                   array( 'awc_f_threads' => array('LEFT JOIN','p_threadid=t_id'))
                    );
         /*           
        $r = $dbr->selectRow( 'awc_f_posts, awc_f_threads', 
                                array( 'p_threadid, p_forumid, t_topics' ), 
                                "p_id = {$this->pID}  AND p_threadid=t_id" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
*/
        $res = $dbr->query($sql);
        $r = $dbr->fetchObject( $res );
                         
        $current_thread_id =  $r->p_threadid ;
        $current_forum_id = $r->p_forumid ;
        $current_t_topics = $r->t_topics ;
        $current_t_topics = ($current_t_topics - 1);
         
       # die("$current_thread_id");
        $dbw->update( 'awc_f_posts',
            array(  'p_threadid'     => $this->tID, 'p_forumid' => $new_forum_id), 
            array('p_ID' => $this->pID),
            '' );
            
        #self::update_thread_last_post($this->tID); 
        #self::update_thread_last_post($current_thread_id);
           
        $sql = "UPDATE {$awc_tables['awc_f_forums']} SET f_replies = f_replies - 1 ";
        $sql .= " WHERE f_id =" . $current_forum_id ;
        $dbw->query($sql);
        
        $sql = "UPDATE {$awc_tables['awc_f_forums']} SET f_replies = f_replies + 1 ";
        $sql .= " WHERE f_id =" . $new_forum_id ;
        $dbw->query($sql);  
        
        
        $dbw->update( 'awc_f_threads',
            array('t_topics' => $current_t_topics), 
            array('t_id' => $current_thread_id),
            '' );
           
           
        $dbw->update( 'awc_f_threads',
            array('t_topics' => $new_t_topics), 
            array('t_id' => $this->tID),
            '' );
            
		$dbw->commit();
		
        unset($dbw, $dbr, $r);
        // Update threads first
        $this->update_thread_last_post($this->tID);
        $this->update_thread_last_post($current_thread_id);
        
        // Update forums second...
        $this->update_forum_last_thread($new_forum_id);
        $this->update_forum_last_thread($current_forum_id);
        
        
       
        
        $info['msg'] = 'post_has_been_merged';
        $info['url'] = awc_url . "st/id" . $this->tID ;
        return awcf_redirect($info);
        
    }
    
    
    
    
    function update_thread_last_post($tID){
    global $awc_tables;
    
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        
        $r = $dbr->selectRow( 'awc_f_posts', 
                                array( 'p_id, p_user, p_date, p_userid' ), 
                                "p_threadid=$tID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1, 'ORDER BY' => 'p_id DESC'));
                                
        $uname = $r->p_user ;
        $title = $r->p_user ;
        $uid = $r->p_userid ;
        $date = $r->p_date ;
        $p_id = $r->p_id ;
        
            $dbw->update( 'awc_f_threads',
                            array(  't_lasttitle'       => $title,
                                    't_lastdate'        => $date,
                                    't_lastuser'        => $uname,
                                    't_lastuserid'      => $uid,
                                    't_postid'           => $p_id,), 
                            array('t_id' => $tID),
                            '' );
                           
         unset($dbw, $dbr, $r);
        
    }
    
    
    function update_forum_last_thread($fID){
    
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $r = $dbr->selectRow( 'awc_f_threads', 
                                array( 't_lastuser, t_lastdate, t_postid, t_lastuserid, t_id, t_name, t_starter, t_starterid' ),
                                 "t_forumid=$fID" , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1, 'ORDER BY' => 't_lastdate DESC'));
        
        $uname = (!empty($r->t_lastuser)) ? $r->t_lastuser : (!empty($r->t_starter)) ? $r->t_starter : ' ' ;
        $uid  = (!empty($r->t_lastuserid)) ? $r->t_lastuserid : (!empty($r->t_starterid)) ? $r->t_starterid : 0;
        $date  = (!empty($r->t_lastdate)) ? $r->t_lastdate : $dbr->timestamp();
        $f_lasttitle = (!empty($r->t_name)) ? $r->t_name : ' ' ;
        $t_id = (!empty($r->t_id)) ? $r->t_id : 0 ;
        
        $dbw->update( 'awc_f_forums',
                            array(  'f_lasttitle'       => $f_lasttitle,
                                    'f_lastdate'        => $date,
                                    'f_lastuser'        => $uname,
                                    'f_lastuserid'      => $uid,
                                    'f_threadid'        => $t_id,), 
                            array('f_id' => $fID),
                            '' );               
        unset($dbw, $dbr, $r);
        
    }
    
    
    
    
    
    
    
    
    
    

}

