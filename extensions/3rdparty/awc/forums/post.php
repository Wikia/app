<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
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
* @filepath /extensions/awc/forums/post.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

function awcs_forum_post(){
global $action;
   
    $post = new awcsforum_post_cls();
    $post->enter_post();
    

}

class awcsforum_post_cls{
    
   // var $boxheight;
    //var $postlimit;
    //var $wiki_pages ;
   // var $caption;  
   // var $raw_post;
   // var $wiki_titles; 
   // var $movethread;  // remove this...
   // var $MoveThreadTitle ; // remove this..
   
   
    var $ann, $sticky, $lock;
    var $id, $tID, $fID, $pID ;
    var $title;
    var $p_title ;
    var $post ;
    var $ThreadTitle ;
    var $isThread = false ;
    
    var $m_thread_subsrib = array();
    var $m_forum_subsrib = array();
    var $cur_memID, $cur_memName, $cur_m_posts, $cur_m_topics;
    var $mId, $mName;
    
  //  var $cf_threadsubscrip, $cf_forumsubscrip;
  //  var $skin_thread;
    var $forum_Antispam;
  //  var $displaysmiles;
    
    var $ispoll = false;
    var $polls_enabled;
   // var $poll_info;
    
    var $action;
    
    var $subscrib_what, $subscribe;
    
    var $cf_add_post_text_to_wiki, $t_wiki_pageid;
    
    function __construct(){
    global $wgRequest;

        $this->action = $wgRequest->action;
        
        $this->tID = $wgRequest->getVal( 'tID' );
        $this->fID = $wgRequest->getVal( 'fID' ); 
        $this->pID = $wgRequest->getVal( 'pID' );
        $this->t_wiki_pageid = $wgRequest->getVal( 't_wiki_pageid' );
        
        
        $this->subscribe = $wgRequest->getVal( 'subsribe' ) ;
        
        $this->title = trim($wgRequest->getVal( 't_title' ));
        $this->p_title = trim($wgRequest->getVal( 't_title' ));
        $this->ThreadTitle = trim($wgRequest->getVal( 'threadtitle' ));
       
        // $this->MoveThreadTitle = trim($wgRequest->getVal( 'threadname' ));
        $this->post = trim($wgRequest->getVal( 'wpTextbox1' ));
        $this->f_name = urldecode($wgRequest->getVal( 'f_name' ));
        
        $this->num_topics = $wgRequest->getVal( 'num_topics' );
        
        $this->forum_Antispam .= ($wgRequest->getVal('name')) ? 'spam' : $wgRequest->getVal('name') ;
        
        $todo = explode('/', $this->action);
        if(isset($todo[3]))$this->subscrib_what = $todo[3] ;
        
        global $awcs_forum_config;
        $ws = $awcs_forum_config->cf_add_post_text_to_wiki;
        $this->cf_add_post_text_to_wiki = ($ws == '1') ? true : false;
        
        $this->polls_enabled = $awcs_forum_config->cfl_Polls_enabled;
        
    }
    
    function enter_post(){
    global $wgRequest, $awcUser, $awcs_forum_config, $IP, $WhoWhere;
   
        include_once(awc_dir . 'includes/thread_funk.php');
      #  include_once(awc_dir . 'includes/post_funk.php');
        
       //  awcsforum_funcs::get_page_lang(array('lang_txt_thread'));
        
         $this->cur_memID = $awcUser->mId;
         $this->cur_memName = $awcUser->mName;
         $this->cur_m_posts = $awcUser->m_posts;
         $this->cur_m_topics = $awcUser->m_topics;
         
        // die($this->cur_memName);
         
         $this->mId = $awcUser->mId;
         $this->mName = $awcUser->mName;
         
         $this->m_thread_subsrib = $awcUser->m_thread_subsrib ;
         $this->m_forum_subsrib = $awcUser->m_forum_subsrib;
         
         //$this->boxheight = $awcUser->rows;
        // $this->postlimit = $awcs_forum_config->cfl_Post_DisplayLimit;
         
        // $this->wiki_pages = $awcs_forum_config->cf_wiki_pages;
         
         // $this->wiki_titles = $awcs_forum_config->cf_wiki_titles;
         
       //  $this->displaysmiles = $awcs_forum_config->cf_displaysmiles; // 
         
         #$this->awcdir = $awc['path'];
        # $this->emo_dir =  $awc['emo_dir'] ;
                   
         
         // $this->cf_threadsubscrip =  $awcs_forum_config->cf_threadsubscrip;
         // $this->cf_forumsubscrip =  $awcs_forum_config->cf_forumsubscrip;
         
	    
      
		if($wgRequest->getVal( 'ann' ) == "on"){
			$this->ann = "1";	
		}else{
			$this->ann = "0";	
		}
		           
		if($wgRequest->getVal( 'sticky' ) == "on"){
			$this->sticky = "1";
		}else{
			$this->sticky = "0";	
		}
		
		if($wgRequest->getVal( 'lock' ) == "on"){
			$this->lock = "1";	
		}else{
			$this->lock = "0";	
		}
        
        /*
		if($wgRequest->getVal( 'movethread' ) == "on"){
			$this->movethread = true ;	
		}else{
			$this->movethread = false ;	
		}
        */
        # need a Clean function
        $this->title = $this->CleanThreadTitle($this->title);
        $this->p_title = $this->CleanThreadTitle($this->p_title);
        $this->ThreadTitle = $this->CleanThreadTitle($this->ThreadTitle);
        //$this->MoveThreadTitle = $this->CleanThreadTitle($this->MoveThreadTitle);
          
        
        $preview = ($wgRequest->getVal( 'preview' ));
        
        
        global $wgUser;
        $wParser = new Parser();
        $d = awcsforum_funcs::convert_date(wfTimestampNow(), "1") . ' <b>' . get_awcsforum_word('word_localtime') . '</b>' ;
        $username = empty($wgUser->mOptions['nickname']) ? $wgUser->mName : $wgUser->mOptions['nickname'];
        $sigText = ($wgUser->mOptions['fancysig'] == 0) ? $wParser->getUserSig( $wgUser ) : $username;
        $this->post = strtr( $this->post, array(
                    '~~~~~' => $d,
                    '~~~~' => "$sigText $d",
                    '~~~' => $sigText
                ) );                
        
       // $this->post = $wgRequest->getVal( 'wpTextbox1' );   
        
       // $this->tID = $wgRequest->getVal( 'tID' );
       // $this->fID = $wgRequest->getVal( 'fID' ); 
       // $this->pID = $wgRequest->getVal( 'pID' );
        
        $this->isThread = $wgRequest->getVal( 'isThread' );
        
        $action = $wgRequest->action; 
        $spl = explode("/", $action);
		$todo = $spl[0];  # shuld ALWAYS be 'post' so skip it.
        $todo = $spl[1];
         
		$this->id = isset($spl[2]) ? str_replace(array('_', 'id'), '', $spl[2]) : $wgRequest->getVal( 'id' ) ;
        
       
       define('what_page', $todo );  
       //$WhoWhere = what_page ;  
       $WhoWhere['type'] =  'forum' ;
       $WhoWhere['where'] =  what_page . '||awc-split||' . what_page ;
       
		switch( $todo ) {
                         
            case 'add_poll':
                    $this->tID = $this->id ;
                    $this->fID = $spl[3] ;
                    $this->poll_form();
                break;
                
            case 'submit_poll':
                    $this->poll_add();
                break;
                
                
            case 'todo_poll_vote':
                   $this->poll_vote($wgRequest->getVal( 'id' ));
                break;
                
            case 'GetEdit':
                     if(!is_numeric( $this->id)) return awcs_forum_error('word_nothread') ;
				   $this->GetEdit($this->id);
				break;
                
            case 'edithistory':
                   $this->edithistory($this->id);
                break;
                
			case 'GetEditThread':
                     if(!is_numeric( $this->id)) return awcs_forum_error('word_nothread') ;
				   $this->GetEdit($this->id, true);
				break;
                
			case 'todo_edit_post':
				 $this->edit_post($preview, $action);
				break;
                
			case 'todo_new_t':
				 $this->GetNewThreadForm($action);
				break;	
                 
			case 'todo_add_post':
				 $this->add_post($preview);
				break;	
                
			case 'todo_add_thread':
				 $this->add_t($preview, $action);
				break;
                
			case 'quote':
                     if(!is_numeric( $this->id)) return awcs_forum_error('word_nothread') ;
				 $this->GetQuote($this->id);
				break;
/*				
			case 'delete_post':
                     if(!is_numeric( $this->id)) return awcs_forum_error('word_nothread') ;
                     $this->delete_post($this->id);
				break;
				
			case 'delete_thread':
                     if(!is_numeric( $this->id)) return awcs_forum_error('word_nothread') ;
                     $this->delete_thread($this->id); 
				break;
                */
                
                
            case 'sub':
           
                 require_once(awc_dir . 'includes/subscribe.php');
                 $t_subscribe = new awcs_forum_subscribe();
                    $t_subscribe->tID = str_replace('id', '', $spl[2]);
                    $t_subscribe->cur_memID = $this->cur_memID;    
                    $t_subscribe->subscribe = $spl[3]; 
                    $t_subscribe->m_thread_subsrib = $this->m_thread_subsrib; 
                    $t_subscribe->m_forum_subsrib = $this->m_forum_subsrib;
                    
                    $t_subscribe->check_thread_subscribe();
                    
                    $info['msg'] = 'thread_subscribe';
                    $info['url'] = awc_url . 'st/'. $spl[2];
                    return awcf_redirect($info);
            break;
            
            case 'fsub':
                 require_once(awc_dir . 'includes/subscribe.php');
                 $t_subscribe = new awcs_forum_subscribe();
                    $t_subscribe->fID = str_replace('id', '', $spl[2]);
                    $t_subscribe->cur_memID = $this->cur_memID;    
                    $t_subscribe->m_thread_subsrib = $this->m_thread_subsrib; 
                    $t_subscribe->m_forum_subsrib = $this->m_forum_subsrib;
                    
                    $t_subscribe->check_forum_subscribe();
                    
                    $info['msg'] = 'forum_subscribe';
                    $info['url'] = awc_url . 'sf/id'. $t_subscribe->fID;
                    return awcf_redirect($info);
            
            break;
            
            
            case 'close_poll':
                 $this->close_poll();
                break;    
                
            case 'delete_poll':
                 $this->delete_poll();
                break;  
                
            case 'reopen_poll':
                 $this->reopen_poll();
                break;   
            
            			
			default:
            
				break;
		}
        

                
    }
    
    function reopen_poll(){ // 2.5.8
    
    

        if(UserPerm >= 2){
            
           $wDB = wfGetDB( DB_MASTER );
           
            $wDB->update( 'awc_f_polls',
                            array('poll_open' => 1,), 
                            array('poll_id' => $this->id),
                            '' ); 
                            
            $tID = $this->action ;
            $tID = explode("/", $tID);
            
            $info['msg'] = 'word_pollReopen';
            $info['url'] = awc_url . "st/id" . $tID[3] ;
            return awcf_redirect($info);
            
        } else {
            return $wgOut->loginToUse();
        }
                                        
        
                                    
    
    }
    
    function close_poll(){ // 2.5.8
                          
    if(UserPerm >= 2){
        
        $wDB = wfGetDB( DB_MASTER );
        
            $wDB->update( 'awc_f_polls',
                            array('poll_open' => 0,), 
                            array('poll_id' => $this->id),
                            '' ); 
                            
                            
             $tID = $this->action ;
            $tID = explode("/", $tID);
            
            $info['msg'] = 'word_pollClose';
            $info['url'] = awc_url . "st/id" . $tID[3] ;
            return awcf_redirect($info);
            
        } else {
            return $wgOut->loginToUse();
        }
                                    
    
    }
    
    function delete_poll(){ // 2.5.8
    
    
        if(UserPerm >= 2){
            
            $action = $this->action ;
            $tID = explode("/", $action); 
            $tID  = $tID[3] ;
            
            $rDB = wfGetDB( DB_SLAVE );
            $wDB = wfGetDB( DB_MASTER );
            
            $awc_f_polls = $wDB->tableName('awc_f_polls');
            
            $sql = "SELECT COUNT(poll_threadid) AS TotalPolls FROM {$awc_f_polls} WHERE poll_threadid=$tID";
            $res = $wDB->query($sql);
            $r = $wDB->fetchObject($res);
             
             if ($r->TotalPolls == 1) {
                 
                $wDB->update( 'awc_f_threads',
                                array('t_poll' => 0,), 
                                array('t_id' => $this->id),
                                '' );
                                
             }
             
        
            $wDB->query( "DELETE FROM {$awc_f_polls} WHERE poll_id = ".$this->id );
        
            $info['msg'] = 'word_pollDelete';
            $info['url'] = awc_url . "st/id" . $tID ;
            return awcf_redirect($info);
            
        } else {
            return $wgOut->loginToUse();
        }                         
    
    }
    
    
    
    function edithistory(){
    global $wgOut;
    
        
        $rDB = wfGetDB( DB_SLAVE );

        $r = $rDB->selectRow( 'awc_f_posts', 
                                    array( 'p_id', 'p_user', 'p_userid', 'p_date', 'p_post', 'p_title', 'p_editdate', 'p_editwho' ), 
                                    array( 'p_id' => $this->id ) );
                                    
        if($r->p_userid == $this->mId || UserPerm >= 2){
                                 
            include_once(awc_dir . 'includes/post_phase.php');
            $post_cls = new awcs_forum_post_phase();
            
            $post_cls->preview = true ;
            $post_cls->p_userid = $r->p_userid ;
            $post_cls->p_user = $r->p_user ;
            $post_cls->p_post = $r->p_post ;
            $post_cls->p_title = $r->p_title;
            $post_cls->p_date = $r->p_date;
            $post_cls->p_editdate = $r->p_editdate;
            $post_cls->p_editwho = $r->p_editwho;
            $post_cls->p_id = $r->p_id;
            unset($r);
            
            $html = $post_cls->display_post();
            unset($post_cls->wiki_titles);
            $html .= '<br />';
            
            
            $word['date_of_post'] = get_awcsforum_word('date_of_post');
            $word['by'] = get_awcsforum_word('by');
            $word['title'] = get_awcsforum_word('word_title');
                
            $awc_f_post_edits = $rDB->tableName('awc_f_post_edits');
            $sql = "SELECT * FROM {$awc_f_post_edits} WHERE pe_pid=$this->id ORDER BY pe_id DESC";
            $res = $rDB->query($sql);
            while ($r = $rDB->fetchObject( $res )) {
                
                $info['date'] = awcsforum_funcs::convert_date($r->pe_when, "l") ;
                $info['who'] = $r->pe_who ;
                $info['pe_post'] = $post_cls->phase_post($r->pe_post, '0', false) ;
                $info['pe_title'] = $r->pe_title ;
                

                
                $html .= '<table border="1" width="100%">
                            <tr>
                                <td>
                                <b>'.$word['date_of_post'].'</b> '.$info['date'].' <b>'.$word['by'].'</b> '.$info['who'].'<hr />
                                <b>'.$word['title'].'</b> :'.$info['pe_title'].'<hr />
                                '.$info['pe_post'].'
                                </td>
                            </tr>
                            </table>
                <br />
                ';
                
            }
            unset($rDB, $r, $res, $post_cls, $info, $word );
            $wgOut->addHTML($html);
            
        } else {
            unset($rDB, $r, $res, $post_cls, $info, $word );
            return $wgOut->loginToUse();
        }
        
    
    }
    
    function poll_vote($id){
     global $wgRequest, $wgOut, $awc_tables, $awcUser;
         
        $rDB = wfGetDB( DB_SLAVE );
        $wDB = wfGetDB( DB_MASTER );
         
        $sql = "SELECT * FROM {$awc_tables['awc_f_polls']} WHERE poll_id=$id LIMIT 1";
        
        $res = $rDB->query($sql);
        $poll = $rDB->fetchRow( $res );
        
        $p['poll_q'] = $poll['poll_q'];
        $p['poll_choice'] = unserialize($poll['poll_choice']);
        $p['poll_results'] = unserialize($poll['poll_a']);
        $p['poll_whovoted'] = unserialize($poll['poll_whovoted']);
                                        
        $polloption = $wgRequest->getVal( 'polloption' ) ;
        
         
       // awc_pdie($polloption);
        if($polloption == "-1"){
            $p['poll_results'][$polloption] = $p['poll_results'][$polloption] ;
        } else {
         $p['poll_results'][$polloption] = ($p['poll_results'][$polloption] + 1);
        }
        
        
        if(!@array_key_exists($awcUser->mId, $p['poll_whovoted'])){
            
            $p['poll_whovoted'][$awcUser->mId] = $polloption ;
              
            $wDB->update( 'awc_f_polls',
                        array('poll_open' => 1, 'poll_a' => serialize($p['poll_results']), 'poll_whovoted' => serialize($p['poll_whovoted']),), 
                        array('poll_id' => $id),
                        '' );
                        
                        
            $wDB->update( 'awc_f_threads',
                            array('t_pollopen' => 1,), 
                            array('t_id' => $poll['poll_threadid']),
                            '' );
                        
                        
                        
        }
        # polloption
        

        $wgOut->redirect( awc_url . "st/id" . $this->tID );          
    
    } 
    
    
     
    function CleanThreadTitle($t){
        
        $t = strip_tags($t);
        $t = awcsforum_funcs::awc_htmlentities($t);
                  
        #$trans = get_html_translation_table(awcsforum_funcs::awc_htmlentities);
        #$t = strtr($t, $trans);
        
        $t = str_replace("[", "", $t);
        $t = str_replace("]", "", $t);
        $t = str_replace("{", "", $t);
        $t = str_replace("}", "", $t);
        $t = str_replace("'", "\'", $t);
         
        return $t;
    }
    
    function GetNewThreadForm($action){
    global $wgOut, $awcUser;
        //forum-wiki-perm - move check to the top
        if (!$awcUser->canPost) return $wgOut->loginToUse();
        
        require(awc_dir . 'includes/post_box.php');
        $posting_box = new awcs_forum_posting_box();
        
        $posting_box->url = awc_url.'post/todo_'.urlencode('add_thread');
        $posting_box->javaCheck = 'onsubmit="return check_NewThread()"';
        
        $posting_box->quick_box = false;
        $posting_box->Show_ann_sticky_lock = true;
        
        $posting_box->subscribed_no = 'selected'; // need user chech here...
        
        
        $spl = explode("/", $action);
        $fID =  str_replace("id", "", $spl[2]) ;
        if($fID == '') $fID =  str_replace("id", "", $spl[3]) ;
        
        $rDB = wfGetDB( DB_SLAVE );
        $r = $rDB->selectRow( 'awc_f_forums', 
                        array( 'f_name', 'f_posting_mesage_tmpt', 'f_wiki_write_perm' ), 
                        array( 'f_id' => $fID ) );
                                      
        
        
        $perm = new awcs_forum_perm_checks(); 
        if(!$awcUser->canPost OR !$perm->can_post($r->f_wiki_write_perm)) {
                return awcs_forum_error('no_forum_read_perm');
        }
        
        
        $f_name = $r->f_name ;
        $f_posting_mesage_tmpt = $r->f_posting_mesage_tmpt;
        unset($r);
        
        $posting_box->f_name = urlencode($f_name);
        $posting_box->fID = $fID;
        
        $e['search_fID'] =  $fID ;
        Set_AWC_Forum_SubTitle($f_name, get_awcsforum_word('posting_new_thread'), $e); 
        unset($e);
                        

        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sf/id' . $fID . '">' . strtr($f_name, "_", " ")  .'</a>', true);

        if(strlen($f_posting_mesage_tmpt) > 1) $posting_box->f_posting_mesage_tmpt = add_tmpl_to_skin($f_posting_mesage_tmpt, $wgOut);  ;
        
        $html = $posting_box->box();
        $wgOut->addHTML($html);
        
    }
    
    function add_post($preview = ''){
    global $wgOut, $awcUser ;

    // forum-wiki-pemr move to the top
        $perm = new awcs_forum_perm_checks(); 
        if(!$awcUser->canPost OR !$perm->can_post_check($this->fID)) {
                return awcs_forum_error('no_forum_read_perm');
        }
        
        
        if($this->post == '') return awcs_forum_error(get_awcsforum_word('blank_post_warning'));
		
        if($this->forum_Antispam != "") die("spam");
        
        if(strlen($preview) > 0){  
            return self::preview_show('post');
        }
        
        return self::add_single_post();
	}
    
    
	
    function add_t($preview = ''){
    global $wgOut, $wgRequest, $awc_tables, $awcUser;
    
        $perm = new awcs_forum_perm_checks(); 
        if(!$awcUser->canPost OR !$perm->can_post_check($this->fID)) {
                return awcs_forum_error('no_forum_read_perm');
        }
        
        if($this->forum_Antispam != "") die("spam"); 
        
        if($this->title == '') return awcs_forum_error(get_awcsforum_word('blank_title_warning'));
        if($this->post == '') return awcs_forum_error(get_awcsforum_word('blank_post_warning'));
        
         
        if(strlen($preview) > 0){
            return self::preview_show('thread');
        }
        
        self::add_thread();
		
    }
    
    function add_single_post($no_redirect = false){
    global $awc_tables, $ForumStat, $awcUser;
    
            $wDB = wfGetDB( DB_MASTER );
        
            $t_lastdate = $wDB->timestamp();
            
            wfRunHooks( 'awcsforum_add_newpost', array(&$this) );   // 2.5.5 
            
            #$bs = $dbw->nextSequenceValue( 'awc_f_posts_p_id_seq' );
            $p_wiki_hidden = $wDB->timestamp();
            $wDB->insert( 'awc_f_posts', array(
                'p_threadid'        => $this->tID,
                'p_post'           => $this->post,
                'p_title'       => $this->p_title,
                'p_user'           => $this->cur_memName,
                'p_userid'      => $this->cur_memID,
                'p_date'           => $t_lastdate,
                'p_editdate'    => $t_lastdate,
                'p_forumid'         => $this->fID,
                'p_wiki_hidden'         => $p_wiki_hidden,
            ) );
            $pid = awcsforum_funcs::lastID($wDB, 'awc_f_posts', 'p_id');
            $_SESSION['awc_rActive'][$this->tID]  = $t_lastdate ;
            //$_SESSION['awc_rActive'][$pid] = $pid;
            //unset($_SESSION['awc_nActive'][$pid]);
            
            
            // add to wiki dbase
              if($this->cf_add_post_text_to_wiki){
                	
              		require_once(awc_dir . 'includes/to_wiki_dbase.php');
                	$ws = new awcs_forum_wikisearch_cls();
                	
                	$ws->post = $this->post;
                    $ws->title = $this->p_title ;
                    $ws->rev_comment = (strlen($this->p_title) > 0) ? $this->p_title : '';
                    $ws->tID = $this->tID;
                    $ws->pID = $pid;
                    $ws->pageID = $this->t_wiki_pageid;
                    $ws->p_wiki_hidden = $p_wiki_hidden;
                    $ws->add_post();
                    
                }
                
                $time_now = $wDB->timestamp();
          /*
                
                $wDB->query( "UPDATE {$awc_tables['awc_f_threads']} as t
                            JOIN {$awc_tables['awc_f_forums']} as f
                                ON t.forum_id=f.f_id 
                                SET t.t_topics = t.t_topics + 1,
                                    t.t_postid ='". $pid ."',
                                    t.t_lastdate = $time_now,
                                    t.t_lastuser = '". $this->cur_memName ."',
                                    t.t_lastuserid = ". $this->cur_memID .",
                                        f.f_replies = f.f_replies + 1,
                                        f.f_lastdate = $time_now,
                                        f.f_lastuser = '". $this->cur_memName ."',
                                        f.f_lastuserid = ". $this->cur_memID .",
                                        f.f_lasttitle = '". $this->ThreadTitle ."',
                                        f.f_threadid = '". $this->tID ."'
                            WHERE t_id = $this->tID");
                
     */  
          
                $wDB->query( "UPDATE {$awc_tables['awc_f_threads']} 
                        SET t_topics = t_topics + 1,
                        t_postid =". $pid .",
                        t_lastdate = '".$wDB->timestamp()."',
                        t_lastuser = '". $this->cur_memName ."',
                        t_lastuserid = ". $this->cur_memID ."
                        WHERE t_id = " . $this->tID );
            
         #  include_once(awc_dir . 'includes/mod_post.php');
         #  awcs_forum_mod_post::update_forum_last_thread($this->fID);
            

            $wDB->query( "UPDATE {$awc_tables['awc_f_forums']} 
                            SET f_replies = f_replies + 1,
                            f_lastdate = '".$wDB->timestamp()."',
                            f_lastuser = '". $this->cur_memName ."',
                            f_lastuserid = ". $this->cur_memID .",
                            f_lasttitle = '". $this->ThreadTitle ."',
                            f_threadid = '". $this->tID ."'
                            WHERE f_id =" . $this->fID );
                         
                             
            $m_topics = $this->cur_m_topics;
            $m_posts = $this->cur_m_posts;
            $name = $this->cur_memName;
            
           // die("cur_memID=$this->cur_memID, m_posts = $m_posts, m_topics = $m_topics");
            if($this->cur_memID != '0' ){
                
                $wDB->update( 'awc_f_mems',
                                array('m_posts' => ($m_posts + 1)), 
                                array('m_idname' => $this->cur_memName),
                                '' );
                                
            }
            
            
            if(isset($ForumStat)) $ForumStat->stat_posts(1);
            
             require_once(awc_dir . 'includes/subscribe.php');
             $t_subscribe = new awcs_forum_subscribe();
                $t_subscribe->fID = $this->fID;
                $t_subscribe->tID = $this->tID;
                $t_subscribe->cur_memID = $this->cur_memID;    
                $t_subscribe->subscribe = $this->subscribe; 
                $t_subscribe->title = $this->ThreadTitle;
                
               # die($this->ThreadTitle);
                $t_subscribe->post = $this->post;
                $t_subscribe->m_thread_subsrib = $this->m_thread_subsrib; 
                $t_subscribe->m_forum_subsrib = $this->m_forum_subsrib;
             
             wfRunHooks( 'awcsforum_add_newpost_thread_subscribe', array(&$t_subscribe, &$this ) );   // 2.5.5 
             $t_subscribe->check_user_thread_subscribe();
             
            if($no_redirect) return ;
            
            require_once(awc_dir . 'thread.php');
            $info['msg'] = 'post_has_been_add';
            $awcforum_threads = new awcforum_threads();
            $info['url'] = $awcforum_threads->get_latest_post($this->tID, true);
            #$info['url'] = awc_url . "last_post/id{$this->tID}";
            #awc_pdie($info);
            return awcf_redirect($info);
    
    }
    
    function add_thread($no_redirect = false){
    global $awc_tables, $ForumStat, $awcUser;
    
    $wDB = wfGetDB( DB_MASTER );
    
    $this->t_lastdate = $wDB->timestamp();
    
        wfRunHooks( 'awcsforum_add_newthread', array( &$this ) );   // 2.5.5
    		
        	#$bs = $dbw->nextSequenceValue( 'awc_f_threads_t_id_seq' );
            $wDB->insert( 'awc_f_threads', array(
                't_forumid'        => $this->fID,
                't_name'           => $this->title,
                't_starter'     => $this->cur_memName,
                't_starterid'     => $this->cur_memID,
                't_date'           => $this->t_lastdate,
                't_lastdate'    => $this->t_lastdate,
                't_ann'           => $this->ann,
                't_pin'           => $this->sticky,
                't_status'         => $this->lock,
                't_lastuser'     => $this->cur_memName,
                't_lastuserid'     => $this->cur_memID,
            ) );
            $NewTid = awcsforum_funcs::lastID($wDB, 'awc_f_threads', 't_id');
            $_SESSION['awc_rActive'][$NewTid] = $NewTid;
            unset($_SESSION['awc_nActive'][$NewTid]);
            
            if($this->ann){
                    $wDB->insert( 'awc_f_anns', array(
                        'ann_id'        => $NewTid,
                    ) );
            }
             
           # $bs = $dbw->nextSequenceValue( 'awc_f_posts_p_id_seq' );
            $p_wiki_hidden = $wDB->timestamp();
            $wDB->insert( 'awc_f_posts', array(
                'p_threadid'        => $NewTid,
                'p_post'           => $this->post,
                'p_title'       => $this->title,
                'p_user'           => $this->cur_memName,
                'p_userid'      => $this->cur_memID,
                'p_date'           => $this->t_lastdate,
                'p_editdate'    => $this->t_lastdate,
                'p_forumid'         => $this->fID,
                'p_wiki_hidden'         => $p_wiki_hidden,
                'p_thread_start'=> 1,
            ) );
            $newid = awcsforum_funcs::lastID($wDB, 'awc_f_posts', 'p_id');
            $_SESSION['awc_rActive'][$NewTid]  = $this->t_lastdate ;
            //$_SESSION['awc_rActive'][$newid] = $newid;
            //unset($_SESSION['awc_nActive'][$newid]);
             
         
                $time_now = $wDB->timestamp();
                /* 
                $wDB->query(str_replace('  ', '', "UPDATE {$awc_tables['awc_f_threads']} t
                            JOIN {$awc_tables['awc_f_forums']} f
                                ON t.forum_id=f.f_id
                                    SET f.f_threads = f.f_threads + 1,
                                        f.f_lastdate = ".$this->t_lastdate.",
                                        f.f_lastuser = '". $this->cur_memName ."',
                                        f.f_lastuserid = ". $this->cur_memID .",
                                        f.f_lasttitle = '". $this->title ."',
                                        f.f_threadid = '". $NewTid ."',
                                            t.t_postid = '". $newid ."'
                            WHERE t_id = $NewTid"));
             */    
        
             
           
            $wDB->query( "UPDATE {$awc_tables['awc_f_forums']} 
                            SET f_threads = f_threads + 1,
                            f_lastdate = '".$time_now."',
                            f_lastuser = '". $this->cur_memName ."',
                            f_lastuserid = ". $this->cur_memID .",
                            f_lasttitle = '". $this->title ."',
                            f_threadid = '". $NewTid ."'
                            WHERE f_id =" . $this->fID );

            
            $wDB->update( 'awc_f_threads',
                                array('t_postid' => $newid,
                                      ), 
                                array('t_id' => $NewTid),
                                '' );
            
            
            $m_topics = $this->cur_m_topics;
            $m_posts = $this->cur_m_posts;
            $name = $this->cur_memName;
            
            if($this->cur_memID != '0' ){
                
                $wDB->update( 'awc_f_mems',
                                array('m_posts' => ($m_posts + 1),
                                      'm_topics' => ($m_topics + 1),), 
                                array('m_id' => $this->cur_memID),
                                '' );
                                   
            }
                          
            if($this->cf_add_post_text_to_wiki){
                require_once(awc_dir . 'includes/to_wiki_dbase.php');
                $ws = new awcs_forum_wikisearch_cls();
                    $ws->post = $this->post;
                    $ws->tID = $NewTid;
                    $ws->pID = $newid;
                    $ws->title = $this->title;
                    $ws->p_wiki_hidden = $p_wiki_hidden;
                    $ws->add_thread();
            }
            
            
            if(isset($ForumStat)) $ForumStat->stat_threads(1);
            //$ForumStat->stat_posts(1);
            
           // $this->tID = $NewTid ;
            $wDB->commit();
            
            
             require_once(awc_dir . 'includes/subscribe.php');
             $t_subscribe = new awcs_forum_subscribe();
                $t_subscribe->fID = $this->fID;
                $t_subscribe->tID = $NewTid;
                $t_subscribe->cur_memID = $this->cur_memID;    
                $t_subscribe->subscribe = $this->subscribe; 
                $t_subscribe->title = $this->title;
                $t_subscribe->post = $this->post;
                $t_subscribe->m_thread_subsrib = $this->m_thread_subsrib; 
                $t_subscribe->m_forum_subsrib = $this->m_forum_subsrib;
                $t_subscribe->forum_or_thread  = 'forum';
             wfRunHooks( 'awcsforum_add_newthread_forum_subscribe', array(&$t_subscribe, &$this ) ); // 2.5.5
             $t_subscribe->check_user_forum_subscribe();
             
             
            if($no_redirect) return ;
            
            $info['msg'] = 'thread_has_been_add';
            $info['url'] = awc_url . "st/id" . $NewTid;
            return awcf_redirect($info);
    }
    
    
    function preview_show($post_or_thread_or_misc){
    global $wgOut, $wgRequest,  $awc_tables;
    
        include_once(awc_dir . 'includes/post_phase.php');
        $post_cls = new awcs_forum_post_phase();
        
        require(awc_dir . 'includes/post_box.php');
        $posting_box = new awcs_forum_posting_box();
        
        $posting_box->Thread_Title = $this->ThreadTitle; 
        $posting_box->f_name = $this->f_name; 
                       
        $f_posting_mesage_tmpt = null;
        $f_name = null;
        if($post_or_thread_or_misc == 'thread'){      
                    
                    $rDB = wfGetDB( DB_SLAVE );
                    $r = $rDB->selectRow( 'awc_f_forums', 
                                    array( 'f_name', 'f_posting_mesage_tmpt' ), 
                                    array( 'f_id' => $this->fID ) );
                                                  
                    $f_name = $r->f_name ;
                    $f_posting_mesage_tmpt = $r->f_posting_mesage_tmpt;
                    unset($r);
                    
                    Set_AWC_Forum_SubTitle(get_awcsforum_word('posting_Preview_word') . ': ' . str_replace('_', ' ', $this->title) , '', '');
                
                    Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sf/id' . $this->fID . '">' . strtr($f_name, "_", " ")  .'</a>');
                    Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('posting_Preview_word'), true);
                    
                    
                    $posting_box->Show_ann_sticky_lock = true; 
                    $posting_box->url = awc_url.'post/todo_add_thread';
                    $posting_box->javaCheck = 'onsubmit="return check_NewThread()"';
              }
              
              
              if($post_or_thread_or_misc == 'post'){   
                  
                    Set_AWC_Forum_SubTitle(get_awcsforum_word('word_postingreply'), get_awcsforum_word('word_postingreplyfor') . " " . $this->ThreadTitle); 

                    Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'sf/id' . $this->fID . '">' . $this->f_name  .'</a>' );
                    Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'st/id' . $this->tID . '">' . $this->ThreadTitle  .'</a>' );
                    Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('posting_Preview_word'), true);
                   
                   $posting_box->Show_ann_sticky_lock = false; 
                   $posting_box->javaCheck = 'onsubmit="return check_quickPost()"';
                   $posting_box->url = awc_url.'post/todo_add_post' ;
                   
              }
              
              
              if($post_or_thread_or_misc == 'quote'){   
                   $posting_box->Show_ann_sticky_lock = false; 
                   $posting_box->javaCheck = 'onsubmit="return check_quickPost()"';
                   $posting_box->url = awc_url.'post/todo_add_post' ;
                   
                   $this->subscribe = isset($this->m_thread_subsrib[$this->tID]) ? $this->m_thread_subsrib[$this->tID] : ''; 
              }
              
              
              if($post_or_thread_or_misc == 'edit'){   
                   $posting_box->Show_ann_sticky_lock = false; 
                   $posting_box->javaCheck = $this->javaCheck;
                   $posting_box->url = awc_url.'post/todo_edit_post' ;
                   $posting_box->preview_button = true;
                   $posting_box->isThread = $this->isThread;
                   
              }

              
                $post_cls->preview = true ;
                
                $post_cls->p_userid = $this->cur_memID ;
                $post_cls->p_user = $this->cur_memName ;
                $post_cls->p_post = $this->post ;
                $post_cls->p_title = $this->title;
                $post_cls->p_date = awcsforum_funcs::date_seperated(wfTimestampNow());
                
                $post_cls->ann = $this->ann;
                $post_cls->sticky = $this->sticky;
                $post_cls->lock = $this->lock;
                
                $post_cls->member_title = '' ;
                $post_cls->member_title = '' ;
                
                $html = $post_cls->display_post();
                $wgOut->addHTML($html);
                
                
                switch($this->subscribe){
                    
                    case 'no':
                        $posting_box->subscribed_no = 'selected';
                    break;
                    
                    case 'email':
                        $posting_box->subscribed_email = 'selected';
                    break;
                    
                    case 'list':
                        $posting_box->subscribed_list = 'selected';
                    break;
                    
                }
                
                $posting_box->subscribe = $this->subscribe ; 
                
                if(strlen($f_posting_mesage_tmpt) > 2) $posting_box->f_posting_mesage_tmpt = awc_wikipase($f_posting_mesage_tmpt, $wgOut);  ;
                
                $posting_box->f_name = urlencode($f_name);
                #$posting_box->Thread_Title = awcsforum_funcs::awc_html_entity_decode($this->title);
                $posting_box->title = $this->title;
                $posting_box->post = $this->post; 
                
                if($this->f_name) $posting_box->f_name = urlencode($this->f_name);
                
                $posting_box->fID = $this->fID;
                $posting_box->tID = $this->tID; 
                $posting_box->pID = $this->pID;
                $posting_box->t_wiki_pageid = $this->t_wiki_pageid ;
               //$e['do_poll'] = $is_poll; 
                
                $posting_box->ann = $this->ann; 
                $posting_box->sticky = $this->sticky; 
                $posting_box->lock = $this->lock; 
                          
                $posting_box->quick_box = false;
                
                
                $html = $posting_box->box();
                $wgOut->addHTML($html);
            
            return ;
    
    }
    
    
    function poll_form(){
    global $wgOut;
        
        if($this->polls_enabled != '1') return '';
        
        require(awc_dir . 'includes/post_box.php');
        $posting_box = new awcs_forum_posting_box();
        $posting_box->tID = $this->tID;
        $posting_box->fID = $this->fID;
        $html = $posting_box->poll_form_display();
        $wgOut->addHTML($html);
    
    }
    
    function poll_add($no_redirect = false){
    global $wgRequest;
    
            if($this->polls_enabled != '1') return '';
    
   
            $preview = $wgRequest->getVal('preview');
            if(strlen($preview) > 0){
                global $wgOut;
                require_once(awc_dir . 'includes/post_phase.php');
                return $wgOut->addHTML(awcs_forum_post_phase::display_poll('',true));
            
            }
            
            $p['poll_info'] = array();
            $p['poll_info']['ispoll'] = 'checked';
            $p['poll_info']['pollq'] =  trim(self::CleanThreadTitle($wgRequest->getVal( 'pollq' )));
            
            
            if($p['poll_info']['pollq'] == '') return awcs_forum_error(get_awcsforum_word('blank_poll_warning'));
            
            $opt = null;
             
             
                    foreach($_POST as $k => $v){
                        
                          if(!empty($v)){
                              
                                    if(strstr($k,'poll_opt')){
                                    	
                                        ++$opt;
                                        if(trim(self::CleanThreadTitle($v)) != ''){
                                            $p['poll_info']['poll_options']['poll_opt' . $opt] = trim(self::CleanThreadTitle($v));
                                        }
                                        
                                    }

                          } 
                    
                    }
                    
             
             /*  
             // $wgRequest - does not work correctly with MW 1.9, Using the above $_POST does  
            foreach($wgRequest as $k => $v){
                
                  if(!empty($v) AND is_array($v)){
                      
                        foreach($v as $k2 => $v2){
                            
                            if(strstr($k2,'poll_opt')){
                                
                                ++$opt;
                                if(trim(self::CleanThreadTitle($v[$k2])) != '') $p['poll_info']['poll_options']['poll_opt' . $opt] = trim(self::CleanThreadTitle($v[$k2]));
                            }
                            
                        }
                  }
            
            }
            */
            
            if(count($p['poll_info']['poll_options']) < 2) return awcs_forum_error(get_awcsforum_word('blank_poll_option'));
            
            
             wfRunHooks( 'awcsforum_add_newpoll', array(&$this, &$p) );   // 2.5.5
            
            
            $wDB = wfGetDB( DB_MASTER );
            
            $wDB->insert( 'awc_f_polls', array(
                'poll_threadid'      => $this->tID,
                'poll_forumid'      => $this->fID,
                'poll_q'       => $p['poll_info']['pollq'],
                'poll_num_options'      => '1',
                'poll_choice'      => serialize($p['poll_info']['poll_options']),
                'poll_a'      => '1',
                'poll_open'      => '1',
                'poll_start_date'      => '1',
                'poll_close_date'      => '1',
                'poll_perm'      => '1'

            ) );
            
            
            $wDB->update( 'awc_f_threads',
                                    array(  't_poll'    => '1', 't_pollopen' => 1,), 
                                    array('t_id' => $this->tID),
                                    '' ); 
            
            
            if($no_redirect) return ;
            
            $info['msg'] = 'poll_has_been_add';
            $info['url'] = awc_url . "st/id" . $this->tID;
            return awcf_redirect($info);
    
    }
    
    

	function edit_post($preview = '', $action = ''){
	global $wgOut, $awcUser, $wgRequest, $wgParser, $wgTitle, $awc_tables;
       
       
        if(strlen($preview) > 0){
            return self::GetEdit($this->pID, $this->isThread , true);
        }
    
       
       // awc_f_post_edits  
         
     if($this->post == "") die(get_awcsforum_word('blank_post_warning'));
     
     if($this->forum_Antispam != "") die("spam");
     
     wfRunHooks( 'awcsforum_edit_thread', array(&$this) );   // 2.5.8
     
     $rDB = wfGetDB( DB_SLAVE );
         
        $sql = "SELECT p.p_wiki_hidden, p.p_wiki_ver_id, p.p_user, p.p_editwho, p.p_post, p.p_title, p.p_editdate,
                        t.t_id, t.t_wiki_pageid
                FROM {$awc_tables['awc_f_posts']} p 
                JOIN {$awc_tables['awc_f_threads']} t
                    ON p.p_threadid=t.t_id
                WHERE p.p_id=" . $this->pID;
                
                    
        $res = $rDB->query($sql);
        $r = $rDB->fetchRow( $res );
        
        if ( !CanEdit($r['p_user']) ){
                $wgOut->loginToUse();
                return ;
         }
         $rDB->freeResult( $res );
         
         $current_post = $r['p_post'];
         $current_title = $r['p_title'];
         $current_date = $r['p_editdate'];
         $current_p_wiki_hidden = $r['p_wiki_hidden'];
         $current_p_wiki_ver_id = $r['p_wiki_ver_id'];
         
         $current_p_user = $r['p_editwho'];
         if(strlen($current_p_user) <= 0) $current_p_user = $r['p_user'];
        
        $wDB = wfGetDB( DB_MASTER );
        
		$p_wiki_hidden = $wDB->timestamp();
		$wDB->update( 'awc_f_posts',
						array('p_post' => $this->post,
                                'p_title' => $this->p_title, 
                                'p_editdate' => $wDB->timestamp(),
                                'p_editwho' => $this->mName,
                                'p_editwhy' => "testing",
                                'p_wiki_hidden' => $p_wiki_hidden,), 
						array('p_id' => $this->pID),
						'' );
                        
                        
                        
            if($this->cf_add_post_text_to_wiki){
                require_once(awc_dir . 'includes/to_wiki_dbase.php');
                $ws = new awcs_forum_wikisearch_cls();
                    
                    $ws->post = $this->post;
                    $ws->title = $this->p_title;
                    $ws->tID = $r['t_id'];
                    $ws->pID = $this->pID;
                    $ws->p_wiki_hidden = $p_wiki_hidden;
                    
                    $ws->pageID = $r['t_wiki_pageid'];
                    $ws->old_p_wiki_hidden = $current_p_wiki_hidden;
                    $ws->old_p_wiki_ver_id = $current_p_wiki_ver_id;
                    $ws->old_post_text = $current_post . ' ' . $current_title ;
                    
                    $ws->edit_post();
            }
                        
    
        if($this->isThread  == "yes") {
            
            $wDB->update( 'awc_f_threads',
                        array(  't_name'    => $this->title), 
                        array('t_id' => $this->tID),
                        '' );
                        
                         
              /*          
	             if (UserPerm == 10){
                    $wDB->update( 'awc_f_threads',
						            array(  't_name'    => $this->title, 
                                            't_ann'     => $this->ann,
                                            't_pin'     => $this->sticky,
                                            't_status'  => $this->lock,), 
						            array('t_id' => $this->tID),
						            '' ); 
                                    
                } else if (UserPerm == 10){
                    $wDB->update( 'awc_f_threads',
						            array(  't_name'    => $this->title, 
                                            't_pin'     => $this->sticky,
                                            't_status'  => $this->lock,), 
						            array('t_id' => $this->tID),
						            '' ); 
                    } else {
                    $wDB->update( 'awc_f_threads',
						            array(  't_name'    => $this->title), 
						            array('t_id' => $this->tID),
						            '' );  

                    }
                    */
                                    
        } 
        
        
        $wDB->insert( 'awc_f_post_edits', array(
                        'pe_pid'        => $this->pID,
                        'pe_post'           => $current_post,
                        'pe_title'           => $current_title,
                        'pe_who'           => $current_p_user,
                        'pe_whoid'           => '0',
                        'pe_when'           => $current_date,) ); 
        

        
        
        
        
                     
       /* 
        
        $cutoff_limit = $this->postlimit;
        if($this->num_topics >= $cutoff_limit) {
             $limit = '/limit:'. (($this->num_topics +1) - $cutoff_limit) . ',' . $cutoff_limit;
         } else {
            $limit = null;
         }
        # die(">". $limit);
         */
        
        $wgOut->redirect( awc_url . "st/id" . $this->tID . $limit . "/#post_" .$this->pID  );    
        
        
        
		#$wgOut->redirect( awc_url . "st/id" . $this->tID . "#post_" .$this->pID  );	
		
		
	}
    
    function GetEdit($pID, $thread = false, $preview = false){
    global $wgOut, $wgRequest, $awc_tables;
         
        
        $rDB = wfGetDB( DB_SLAVE ); 
        
		$res = $rDB->query("SELECT p.*, t.t_id, t.t_topics, t.t_name, t.t_ann, t.t_pin, t.t_status, f.f_name 
                            FROM {$awc_tables['awc_f_posts']} p,
                                 {$awc_tables['awc_f_threads']} t,
                                 {$awc_tables['awc_f_forums']} f 
                            WHERE p.p_id=$pID AND p.p_threadid=t.t_id AND t.t_forumid=f.f_id");
        $r = $rDB->fetchRow( $res );
        
         if ( !CanEdit($r['p_user']) ){
                $wgOut->loginToUse();
                return ;
         }
         
          
         
        if($r['t_ann'] == "1" AND $r['p_thread_start'] == '1' AND UserPerm != 10){
                $wgOut->loginToUse();
                return ;
         }
         
         
        $title = $r['p_title'] ;
        if($preview) $title = $wgRequest->getVal( 't_title' ); 
      #  if (!$title) $title =  $r['t_name'] ;
        
        $ThreadTitle = $r['t_name']; 
        if($preview) $ThreadTitle = $wgRequest->getVal( 't_title' );
        
        $ThreadTitle = awcsforum_funcs::awc_html_entity_decode($ThreadTitle);
       // $this->title = awcsforum_funcs::awc_html_entity_decode($title); // problem with the double quote
        $this->title = html_entity_decode($title, ENT_NOQUOTES, awc_forum_charset); 
       // $this->title = $title;  
       # awc_pdie($r);
        $this->tID = $r['t_id'] ;
        $this->pID = $r['p_id'] ;
        $this->fID = $r['p_forumid'] ;
        $this->cur_memID = $r['p_userid'];
        $this->cur_memName = $r['p_user'];
        
        $this->post = $r['p_post']  ;  
        if($preview) $this->post = $wgRequest->getVal( 'wpTextbox1' );
        
        $this->subscribe = 'dont_show';
        $this->subscribe = 'dont_show';
        
        
       if($thread) {
        $this->javaCheck = 'onsubmit="return check_NewThread()"';
        $this->isThread = 'yes';
       } else {
        $this->javaCheck = 'onsubmit="return check_quickPost()"';
       }
        
    
        Set_AWC_Forum_SubTitle(get_awcsforum_word('editingpost'), get_awcsforum_word('editingpost') . " " . $title); 
                        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('editingpost'));
        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'st/id' . $r['p_threadid'] . '">' . $ThreadTitle  .'</a>', true);
        
        
        return self::preview_show('edit');
    
    }
    
    
    function GetQuote($pID){
    global $wgOut, $wgRequest, $awc_tables, $awcUser ;
    // forum-wiki-perm move to top
		 if (!$awcUser->canPost) return $wgOut->loginToUse();
         
        $rDB = wfGetDB( DB_SLAVE );
        
		$res = $rDB->query("SELECT p.*, t.t_wiki_pageid, t.t_id, t.t_name, t.t_ann, t.t_pin, t.t_status, t.t_topics, f.f_name, f.f_wiki_write_perm
                                FROM {$awc_tables['awc_f_posts']} p, {$awc_tables['awc_f_threads']} t, {$awc_tables['awc_f_forums']} f 
                                WHERE p.p_id=$pID AND f.f_id=p.p_forumid AND p.p_threadid=t.t_id LIMIT 1");
        $r = $rDB->fetchRow( $res );
        
        
        $perm = new awcs_forum_perm_checks(); 
        if(!$awcUser->canPost OR !$perm->can_post($r['f_wiki_write_perm'])) {
                return awcs_forum_error('no_forum_read_perm');
        }
        
        $title = $r['p_title'] ;
        if ($title == "") $title =  $r['t_name'] ;
        
        $title = awcsforum_funcs::awc_html_entity_decode($title);
        $ptitle = awcsforum_funcs::awc_html_entity_decode($r['p_title']);
        $ttitle = awcsforum_funcs::awc_html_entity_decode($r['t_name']);
        
        $this->ThreadTitle = $ttitle; 
        $this->f_name = $r['f_name']; 
        $this->t_wiki_pageid = $r['t_wiki_pageid']; 
        
        
        $this->tID = $r['t_id'] ;
        $this->fID = $r['p_forumid'] ;
        
        if ($r['t_ann']) $t_ann = "checked";
        if ($r['t_pin']) $t_pin = "checked";
        if ($r['t_status']) $t_status = "checked";
        
        
        $this->post = "[QUOTE=" . $r['p_user'] . " [[Special:AWCforum/sp/id" . $pID . "|" . awcsforum_funcs::convert_date($r['p_date'], "1") . "]]]" .  $r['p_post'] . "[/quote]" . chr(10)  ;  
        
        Set_AWC_Forum_SubTitle(get_awcsforum_word('word_quoting'), $ptitle); 
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_quoting'));
        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'st/id' . $r['p_threadid'] . '">' . $ttitle  .'</a>', true);
        
        
        return self::preview_show('quote');
    
    }
    
    
    
}
