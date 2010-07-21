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
* @filepath /extensions/awc/forums/members.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

error_reporting(E_ALL & ~E_NOTICE);


global $member_info, $member_default_forum_options;


function awcs_forum_members($action){

    
    $mem = new awcforum_members();
    $mem->enter_members($action);
    
   # Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_mem'), true);

}

class awcforum_members{
    
    var $awc_url;
    var $todo_url;
    var $sig_length;
    var $membername, $m_id, $mem_info = array();
    var $upload, $uploadsize, $uploadext, $imagefolder, $imagepath;
    var $WikiToolBar;
    var $here;
    var $modPMlimit, $modPMsendlimit, $userPMlimit, $userPMsendlimit;
    var $wikieits;

	function enter_members($action){
	global $wgOut, $awcUser, $awcs_forum_config, $wgRequest, $IP, $WhoWhere ;
    
        
        include_once(awc_dir . 'includes/post_phase.php');
        include_once(awc_dir . 'includes/post_box.php');
        include_once(awc_dir . 'includes/thread_funk.php');
        
        global $wgJsMimeType; // 2.5.8
        $wgOut->addScript( "<script type=\"{$wgJsMimeType}\">hookEvent(\"load\", pm_ajax_onload);</script>\n" );
        
           
        Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $awcUser->mName ); 
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_memCP'));    
                                            
        if($awcUser->mId == '0') return $wgOut->loginToUse();
    
        $this->here = true;
        
        $this->membername = $awcUser->mName ;
        $this->m_id = $awcUser->mId;  
          
        $this->sig_length = $awcs_forum_config->cf_SigLength;
		
        
        $this->wikieits = $awcs_forum_config->wikieits ;
        
        $this->modPMlimit = $awcs_forum_config->cf_mod_maxpmhave ;
        $this->modPMsendlimit = $awcs_forum_config->cf_mod_maxpmsendusers ;
        $this->userPMlimit = $awcs_forum_config->cf_mem_maxpmhave ;
        $this->userPMsendlimit = $awcs_forum_config->cf_mem_maxpmsendusers ;
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_mems',  array('m_pmpop' => '0', ), array('m_id' => $this->m_id), '' );

        
        $this->GetThisMemInfo();
        
        $this->DefaultMemForumOptions();
        
        $this->upload = $awcs_forum_config->cf_advatar_no_upload;
        
        $this->uploadsize = $awcs_forum_config->cf_advatar_upload_size;
        $this->uploadext = $awcs_forum_config->cf_advatar_upload_exe;
        
        $this->send_pm_body_in_email = $awcs_forum_config->cf_send_pm_body_in_email ;
        $this->send_thread_body_in_email = $awcs_forum_config->cf_send_thread_body_in_email ;
        $this->send_post_body_in_email = $awcs_forum_config->cf_send_post_body_in_email ;
        
        $this->cf_css_mem_select = $awcs_forum_config->cf_css_mem_select ;
        
        $this->cf_FCKeditor = $awcs_forum_config->cf_FCKeditor ;
        $this->cf_extrawikitoolbox = $awcs_forum_config->cf_extrawikitoolbox ;
        
        
        $this->imagepath = awc_path . 'images/avatars/' ;
        $this->imagefolder = awc_dir . 'images/avatars/' ;   
        
        $spl = explode("/", $action);
        $todo = isset($spl[1]) ? $spl[1] : null;
        
        $this->id = isset($spl[2]) ? $spl[2] : null;
        
		#die($todo);  
        define('what_page', $todo );
        
        $WhoWhere['where'] =  'forum' ;
        $WhoWhere['where'] =   'memcp||awc-split||memcp' ;
        
        
        $this->todo_url = 'member_options/';
          
		switch( $todo ) {
					
			case 'save_sig':
				    $this->sig_save();
				break;
                
			case 'clearIndicators':
				    $this->clearIndicators();
				break;
                
            case 'CheckAvatraSize':
                    $wgOut->addHTML($this->avatra_check_size());
                break;
                
                
            case 'miscusersettings':
                 $this->saveForumOptions();
            break;
            
                
            case 'viewaadv':
                    $this->viewaadv();
                break;
                
            case 'editsig':
                    $this->sig_get_edit();
                break;
                
            case 'editava':
                    $this->avatar_get();
                break;
                
            case 'editgen':
                    $this->editgen();
                break;
                
                
                
            case 'pminbox':
            case 'pmsent':
            case 'pmsaved':
                    $this->pm_list($todo);
                break;
                
            
            case 'pmnew':
                    $this->pm_create();
                break;
                
            case 'sendpm':
                    $this->pm_send($action);
                break;
                
            case 'readpm':
                    $this->pm_read();
                break;
                
            case 'quotepm':
                    $this->mem_info['m_pmoptions']['m_pmautoquote'] = '1';
                    $this->pm_read();
                break;
                
                 
                
                
            case 'pms_change':
                    $this->pm_change();
                break;
                
            case 'getPMoptions':
                    $this->getPMoptions();
                break;
                
            case 'savePMoptions':
                    $this->savePMoptions();
                break;
                
                
                
            case 'threadsubscribe':
                    $this->threadsubscribe();
                break;
                
            case 'threadsubscribe_email':
                    $this->threadsubscribe('email');
                break;
                
            case 'threadsubscribe_list':
                    $this->threadsubscribe('list');
                break;
                
            case 'delete_tsub':
                    $this->delete_tsub();
                break;
                
                
            case 'menu_options':
                    $this->menu_options();
                break;
                
            case 'menu_options_save':
                    $this->menu_options_save();
                break;
                
            case 'pm_clear_unread':
                    $this->pm_clear_unread();
                break;
                
            case 'pm_re_count':
                    $this->pm_re_count();
                break;
                
                
			default:
                Set_AWC_Forum_BreadCrumbs('',true); 
                $user_wiki_page = GetWikiPage('<wiki>'.$this->membername.'</wiki>', '', '2', $this->m_id);
                $user_wiki_page = awcs_forum_post_phase::phase_post($user_wiki_page, '', false);
                self::display_memcp($user_wiki_page);
				break;
					
		}	
        


}

    function display_memcp($body){
    global $tplt, $wgOut;
    
        $tplt->add_tplts(array("'memcp_main_body'", ),true);
        
        $words = array();
        $words['word_help'] = get_awcsforum_word('word_help');
        $words['mem_pm_option'] = get_awcsforum_word('mem_pm_option');
        $words['mem_pm_totalpms'] = get_awcsforum_word('mem_pm_totalpms');
        $words['mem_pm_sendnew'] = get_awcsforum_word('mem_pm_sendnew');
        $words['mem_pm_inbox'] = get_awcsforum_word('mem_pm_inbox');
        $words['mem_pm_sent'] = get_awcsforum_word('mem_pm_sent');
        $words['mem_pm_saved'] = get_awcsforum_word('mem_pm_saved');
        $words['mem_general_options'] = get_awcsforum_word('mem_general_options');
        $words['mem_edit_sig_option'] = get_awcsforum_word('mem_edit_sig_option');
        $words['mem_edit_avatar_option'] = get_awcsforum_word('mem_edit_avatar_option');
        $words['mem_edit_gen_option'] = get_awcsforum_word('mem_edit_gen_option');
        $words['mem_edit_wiki_option'] = get_awcsforum_word('mem_edit_wiki_option');
        $words['mem_subscription'] = get_awcsforum_word('mem_subscription');
        $words['word_threads'] = get_awcsforum_word('word_threads');
        $words['word_subscribe_email'] = get_awcsforum_word('word_subscribe_email');
        $words['word_subscribe_memcp'] = get_awcsforum_word('word_subscribe_memcp');
        $words['mem_edit_menu_options'] = get_awcsforum_word('mem_edit_menu_options');
        
        
        
        $info['body_info'] = $body;
        
        $info['total_count'] = isset($this->mem_info['m_pmtotal']) ? $this->mem_info['m_pmtotal'] : 0;
        $info['inbox_count'] = isset($this->mem_info['m_pminbox']) ? $this->mem_info['m_pminbox'] : 0;
        $info['sent_count'] = isset($this->mem_info['m_pmsent']) ? $this->mem_info['m_pmsent'] : 0;
        $info['save_count'] = isset($this->mem_info['m_pmsave']) ? $this->mem_info['m_pmsave'] : 0;
        
           if(isset($this->mem_info['m_adv']) AND !empty($this->mem_info['m_adv'])){
                $info['adv'] = '<DIV align="center"><img align="center" src="'. $this->mem_info['m_adv'] .'" border="0" height="'. $this->mem_info['m_advh'] .'" width="'. $this->mem_info['m_advw'] .'" align="middle"/></div>';
           }else{
               
               global $awcs_forum_config;
                $splAWC = explode('x', $awcs_forum_config->cf_AvatraSize);
                $aH = $splAWC[0];
                $aW = $splAWC[1];
                $info['adv'] = '<DIV align="center"><img align="center" src="'.$this->imagepath.'avatar_default.gif" border="0" height="'. $aH .'" width="'. $aW .'" align="middle"/></div>';
           }

        
        $out = $tplt->phase($words,$info,'memcp_main_body',true);
        
        return $wgOut->addHTML($out);
        
    }
    
    function menu_options(){
    global $awcUser;
    
    Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_edit_menu_options'), true);
    
    
    $mOps = $awcUser->m_menu_options;
    
            $html = '<form action="'.awc_url.'member_options/menu_options_save" method="post"  enctype="multipart/form-data">';   
            $html .= '<input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= '<input name="m_id" type="hidden" value="'.$this->m_id.'">' ;
            
            $html .= '<table width="100%" class="mem_pm_table" cellpadding="0" cellspacing="0"><tr><td>';
            
            $html .= awcsf_CheckYesNo('op_search', $mOps['search']) . ' - ' . get_awcsforum_word('op_search'). '<br />';
            $html .= awcsf_CheckYesNo('op_today', $mOps['today']) . ' - ' . get_awcsforum_word('op_today')  . '<br />';
            $html .= awcsf_CheckYesNo('op_pms', $mOps['pms']) . ' - ' . get_awcsforum_word('op_pms')  . '<br />';
            $html .= awcsf_CheckYesNo('op_recent', $mOps['recent']) . ' - ' . get_awcsforum_word('op_recent') . '<br />';
            $html .= awcsf_CheckYesNo('op_mythreads', $mOps['mythreads']) . ' - ' . get_awcsforum_word('op_mythreads') . '<br />';
            $html .= awcsf_CheckYesNo('op_myposts', $mOps['myposts']) . ' - ' . get_awcsforum_word('op_myposts') . '<br />';
            $html .= awcsf_CheckYesNo('op_subemail', $mOps['subemail']) . ' - ' . get_awcsforum_word('op_subemail') . '<br />';
            $html .= awcsf_CheckYesNo('op_sublist', $mOps['sublist']) . ' - ' . get_awcsforum_word('op_sublist') . '<br />';
            $html .= awcsf_CheckYesNo('op_forum', $mOps['forum']) . ' - ' . get_awcsforum_word('op_forum') . '<br />';
            
            
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
            $html .= '</td></tr></table></form>'; 
            
           self::display_memcp($html);
    
    }
    
    function menu_options_save(){
    global $wgRequest;    
    
        $op_search = $wgRequest->getVal( 'op_search' ); 
        $op_today = $wgRequest->getVal( 'op_today' );
        $op_pms = $wgRequest->getVal( 'op_pms' );
        $op_recent = $wgRequest->getVal( 'op_recent' );
        $op_mythreads = $wgRequest->getVal( 'op_mythreads' );
        $op_myposts = $wgRequest->getVal( 'op_myposts' );
        $op_subemail = $wgRequest->getVal( 'op_subemail' );
        $op_sublist = $wgRequest->getVal( 'op_sublist' );
        $op_forum = $wgRequest->getVal( 'op_forum' );
        
            $m_menuoptions = array('search'=>$op_search,
                                    'today'=>$op_today,
                                    'pms'=>$op_pms,
                                    'recent'=>$op_recent,
                                    'mythreads'=>$op_mythreads,
                                    'myposts'=>$op_myposts,
                                    'subemail'=>$op_subemail,
                                    'sublist'=>$op_sublist,
                                    'forum'=>$op_forum, );
                                    
            
            
            $dbw = wfGetDB( DB_MASTER );
            $dbw->update( 'awc_f_mems',
                                array('m_menu_options'    => serialize($m_menuoptions), ), 
                                array('m_id' => $this->m_id),  '' );
                                
                                
                                
        $info['msg'] = 'mem_menuoptionsaved';
        $info['url'] = awc_url . 'member_options/menu_options';
        return awcf_redirect($info);              
    }

    function delete_tsub(){
    global $wgOut, $awc, $awcUser, $wgRequest;


        if(isset($_POST['tid'])){
            $ids = array();
            $ids = $_POST['tid'];
        }    
        
        if(!isset($ids)){
            
            if(isset($_GET['tid'])){
                    $ids = array();
                    $ids[] = $_GET['tid'];
                }
        }
        
        if(isset($ids)){
            $dbw = wfGetDB( DB_MASTER );
            foreach($ids as $k => $tid){
                #print($tid);
                $dbw->delete( 'awc_f_watchthreads', array( 'wtcht_thread_id' => $tid, 'wtcht_mem_id' => $awcUser->mId ), '');
            }
        }
        
        return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/threadsubscribe') );
    }
    
    function threadsubscribe($where=''){
     global $wgOut, $awc, $awc_tables, $tplt; 
     
     
        $thread_tools = new awcs_forum_thread_list_tools();
        $tplt->add_tplts(array("'memcp_recent_header'",
                            "'memcp_recent_row'",
                            "'memcp_recent_close'", 
                            "'postblocks_threadlisting'",),true);
        
        $words = array();
        $words['thread_title'] = get_awcsforum_word('thread_title');
        $words['word_replies'] = get_awcsforum_word('word_replies');
        $words['last_action'] = get_awcsforum_word('last_action');
        $words['thread_title_started_by'] = get_awcsforum_word('thread_title_started_by');
        $words['delete'] = get_awcsforum_word('delete');
        
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_subscriptionthread'));
            
            if (function_exists('bcmod')) {
                $row_class = 1  ;
            } else {
                $row_class = 0  ;
            }    
            
            $html = '<form action="'.awc_url.'member_options/delete_tsub" method="post"  enctype="multipart/form-data">';
            
            $html .= $tplt->phase($words,'','memcp_recent_header',true);
            
            $dbr = wfGetDB( DB_SLAVE );
            
            if($where == 'list'){
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_subscribe_memcp'), true); 
                $sql = "SELECT w.wtcht_todo, t.t_postid, t.t_id, t.t_topics, t.t_lastdate, t.t_name, t.t_starterid, t.t_starter, t.t_lastuser, t.t_lastuserid
                        FROM {$awc_tables['awc_f_watchthreads']} w, {$awc_tables['awc_f_threads']} t 
                        WHERE w.wtcht_todo='list' AND t.t_id=w.wtcht_thread_id AND w.wtcht_mem_id=". $this->m_id . " ORDER BY t.t_lastdate DESC";
                    
            }  elseif($where == 'email') {
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_subscribe_email'), true);
                $sql = "SELECT w.wtcht_todo, t.t_postid, t.t_id, t.t_topics, t.t_lastdate, t.t_name, t.t_starterid, t.t_starter, t.t_lastuser, t.t_lastuserid
                        FROM {$awc_tables['awc_f_watchthreads']} w, {$awc_tables['awc_f_threads']} t 
                        WHERE w.wtcht_todo='email' AND t.t_id=w.wtcht_thread_id AND w.wtcht_mem_id=". $this->m_id . " ORDER BY t.t_lastdate DESC";
            
            } else {
               Set_AWC_Forum_BreadCrumbs('', true);
                $sql = "SELECT w.wtcht_todo, t.t_postid, t.t_id, t.t_topics, t.t_lastdate, t.t_name, t.t_starterid, t.t_starter, t.t_lastuser, t.t_lastuserid
                        FROM {$awc_tables['awc_f_watchthreads']} w, {$awc_tables['awc_f_threads']} t 
                        WHERE t.t_id=w.wtcht_thread_id AND w.wtcht_mem_id=". $this->m_id . " ORDER BY t.t_lastdate DESC";
            }
                    
            $res = $dbr->query($sql);
            $c = 0;
            while ($r = $dbr->fetchObject( $res )) {
              
                $info['t_id'] = $r->t_id;
                $info['t_name'] = awcsforum_funcs::awc_html_entity_decode($r->t_name);
                $info['t_topics'] = $r->t_topics;
                $info['t_starter'] = $r->t_starter;
                $info['t_starterid'] = $r->t_starterid;
                $info['last'] = '<a href="'.awc_url.'last_post/'.$r->t_id.'">' . awcsforum_funcs::convert_date($r->t_lastdate, "s") . '</a>' ;
               /* 
                if($awcUser->guest == false){ 
                    $info['NewPost'] = awcs_forum_CheckIfThreadIsNew($r->t_id, $r->t_lastdate);
                } else {
                    $info['NewPost'] = null;
                }
                */
                
                $info['NewPost'] = $thread_tools->new_thread_check($r->t_id, $r->t_lastdate) ;
                
                $info['url'] = awc_url . 'st/' . $r->t_id ;
                
                if($where == 'email' OR $where == 'list') {
                     $info['wtcht_todo'] = null;
                } else {
                    $info['wtcht_todo'] = $r->wtcht_todo;
                }
                
                
                $thread_tools->link = awc_url;
                $thread_tools->tID = $r->t_id;
                $thread_tools->total_posts = $r->t_topics;
                $info['t_jump'] = $thread_tools->GetThreadPostLimit();
                
                $c++;  
                if ($row_class) {
                    $info['row_class'] = 'thread_rows' . bcmod($c, '2')  ;
                } else {
                    $info['row_class'] = 'thread_rows'  ;
                }
                
                $html .= $tplt->phase($words,$info,'memcp_recent_row');  
            }
            $dbr->freeResult( $res ); 
            
            $tplt->kill('memcp_recent_row');
            $html .= $tplt->phase($words,'','memcp_recent_close',true);
            $html .= '</form>';
            
            self::display_memcp($html);

    }

    function DefaultMemForumOptions(){
    global $member_default_forum_options, $wgLocalTZoffset;

            $member_default_forum_options = array();
            
            $member_default_forum_options['cf_extrawikitoolbox']['yesno'] = '1';
            $member_default_forum_options['cf_FCKeditor']['yesno'] = '0';
            $member_default_forum_options['css_id']['drop'] = '0';
            
            #die(">". $wgLocalTZoffset);
            
            $date = '
                            <option value ="l, M jS Y g:i:s A">'.date('l, M jS Y g:i:s A').'</option>
                            <option value ="D, M jS Y g:i:s A">'.date('D, M jS Y g:i:s A').'</option>
                            <option value ="g:i:s A - D, M jS Y">'.date('g:i:s A - D, M jS Y').'</option>
                            <option value ="D M jS g:i a">'.date('D M jS g:i a').'</option>
                            <option value ="m/j/y g:i a">'.date('m/j/y g:i a').'</option>
                      </select>';   
                            
            #$member_default_forum_options['cf_DateLong']['drop'] = '0';
            #$member_default_forum_options['cf_DateLong']['options'] = $date;
            
            #$member_default_forum_options['cf_DateShort']['drop'] = '0';
           # $member_default_forum_options['cf_DateShort']['options'] = $date;
            
            $member_default_forum_options['mem_showAdv']['yesno'] = '1';
            $member_default_forum_options['mem_showsigs']['yesno'] = '1';
            $member_default_forum_options['mem_showsigsonlyonce']['yesno'] = '0';
            
            $member_default_forum_options['cf_displaysmiles']['yesno'] = '1';
            
            $member_default_forum_options['m_sub_thread_auto']['yesno'] = '0';
             
                                                         
           /* 
           // meed to work on this in the subscribe.php file...
                $member_default_forum_options['mem_send_thread_body_in_email']['yesno'] = '0';
                $member_default_forum_options['mem_send_post_body_in_email']['yesno'] = '0';
            */
            
            
           # die(print_r($member_info));
    }


    // need this so AdminCP can pull members info...
    function GetThisMemInfo(){
    global $member_info;

            $user_get = array();
            $user_get[] = '*';   
            $this->mem_info = GetMemInfo($this->m_id, $user_get);
            unset($user_get);
            $member_info = $this->mem_info;
            
           # awc_pdie($this->mem_info);
    }
    
    function pm_re_count(){
    global $wgOut, $awc_tables;
    
   
    
            $dbr = wfGetDB( DB_SLAVE );
            $sql = "SELECT pmi_folder_id, pmi_read FROM {$awc_tables['awc_f_pms_info']} 
                    WHERE pmi_receipt_id = ". $this->m_id ;
                    
            $res = $dbr->query($sql);
            $save = 0;
            $inbox = 0;
            $sent = 0;
            $unread = 0;
            while ($r = $dbr->fetchObject( $res )){
                
                switch($r->pmi_folder_id){
                    
                    case '0':
                        ++$inbox;
                    break;
                    
                    case '1':
                        ++$sent;
                    break;
                    
                    case '2':
                        ++$save;
                    break;
                
                }
                
                if($r->pmi_read == '0') ++$unread;
                
            }
            
            $total = ($inbox + $sent + $save);
            
    
         $dbw = wfGetDB( DB_MASTER );
         $dbw->update( 'awc_f_mems',  array('m_pmtotal' => $total,
                                                'm_pminbox' => $inbox,
                                                'm_pmsent' => $sent,
                                                'm_pmsave' => $save,
                                                'm_pmunread' => $unread, ), array('m_id' => $this->m_id), '' );
        
        return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/pminbox') );
    }
       
    function pm_clear_unread(){
    global $wgOut;
    
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_mems',  array('m_pmunread' => '0', ), array('m_id' => $this->m_id), '' );
        $dbw->update( 'awc_f_pms_info',  array('pmi_read_date' => $dbw->timestamp(),
                                                'pmi_read' => '1',
                                                 ), array('pmi_receipt_id' => $this->m_id), '' );
        
       self::pm_re_count();
        
        return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/pminbox') );
    }
    
            
    function pm_change(){
    global $wgOut, $awc, $awcUser, $wgRequest, $awc_tables, $action_url;

        $pm_changetodo = $wgRequest->getVal( 'pm_changetodo' );
        $where = $wgRequest->getVal( 'where' );
        
        if($pm_changetodo == null){
             $pm_changetodo = $action_url[2];
        }    

        if(isset($_POST['pm_ids'])){
            $pm_ids = array();
            $pm_ids = $_POST['pm_ids'];
        } 
        
        if(!isset($pm_ids)){
            
            if(!empty( $action_url['id'])){
                $pm_ids = array();
                $pm_ids[] = $action_url['id'] ;
            }
            
        }
        
         if(!isset($pm_ids)) die("no pms");
        
            
        $dbr = wfGetDB( DB_SLAVE );
        $dbw = wfGetDB( DB_MASTER );
        
        $inbox_count = 0;
        $sent_count = 0;
        $save_count = 0;
        $pm_count = 0;
        
        
        foreach($pm_ids as $num => $id){
            
                $sql = "SELECT pmi_folder_id FROM {$awc_tables['awc_f_pms_info']} WHERE pmi_id = $id AND pmi_receipt_id= ".$this->m_id." LIMIT 1";
                $res = $dbr->query($sql);
                $r = $dbr->fetchRow( $res );
                
                $pm_count ++;
               
                if($pm_changetodo == 'pm_move' AND $r['pmi_folder_id'] == '2') unset($pm_ids[$num]);
                if($pm_changetodo == 'pm_moveinbox' AND $r['pmi_folder_id'] == '0') unset($pm_ids[$num]);
                          
                switch($r['pmi_folder_id']){
                    
                    case '0':
                        $inbox_count ++;
                    break;
                    
                    case '1':
                        $sent_count ++;
                    break;
                    
                    case '2':
                        $save_count ++;
                    break;
                
                }
                $dbr->freeResult( $res ); 
                
        }
        
        
        
        
        if($pm_changetodo == 'pm_delete' ){
        
            foreach($pm_ids as $num => $pmi_id){
                
                    $sql = "SELECT pmi_pmid FROM {$awc_tables['awc_f_pms_info']} WHERE pmi_id = $id AND pmi_receipt_id= ".$this->m_id." LIMIT 1";
                    $res = $dbr->query($sql);
                    $r = $dbr->fetchRow( $res );
                    $pms_id[$pmi_id] = $r['pmi_pmid'];
                    $dbr->freeResult( $res );
                    
                    $sql = "SELECT count(pmi_id) as num_pms FROM {$awc_tables['awc_f_pms_info']} WHERE pmi_pmid = $pms_id[$pmi_id]" ;
                    $res = $dbr->query($sql);
                    $r = $dbr->fetchRow( $res );
                    $num_pms[$pmi_id] = $r['num_pms'];
                    $dbr->freeResult( $res );
                    
                    
                    if($num_pms[$pmi_id] == 1){
                        $dbw->delete( 'awc_f_pms', array( 'pm_id' => $pms_id[$pmi_id] ), '');
                        $dbw->delete( 'awc_f_pms_info', array( 'pmi_id' => $pmi_id ), '');
                    } else {
                        $dbw->delete( 'awc_f_pms_info', array( 'pmi_id' => $pmi_id ), '');
                    }
                    
                    
                    

                    
            }
              
            $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} 
                            SET m_pmsave = m_pmsave - $save_count,
                                m_pmsent = m_pmsent - $sent_count,
                                m_pmtotal = m_pmtotal - $pm_count,
                                m_pminbox = m_pminbox - $inbox_count
                            WHERE m_id =" . $this->m_id );
                            
                            
             return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/pminbox') );
                            
        }
        
        
          if(isset($this->mem_info['m_pmtotal'])){
               if(UserPerm == 2 AND $this->mem_info['m_pmtotal'] > $this->modPMlimit){
                    return awcs_forum_error(get_awcsforum_word('mem_pm_toomany') . ' ' . $this->modPMlimit );
               } elseif(UserPerm == 1 AND $this->mem_info['m_pmtotal'] > $this->userPMlimit){ 
                   return awcs_forum_error(get_awcsforum_word('mem_pm_toomany') . ' ' . $this->userPMlimit );
               }
          }
        
        
        
        
        if(count($pm_ids) != 0){
            
            if($pm_changetodo == 'pm_move' ){
                   
                    $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} 
                                    SET m_pminbox = m_pminbox - $inbox_count,
                                        m_pmsent = m_pmsent - $sent_count,
                                        m_pmsave = m_pmsave + $pm_count
                                    WHERE m_id =" . $this->m_id );
                                    
                                    
                    foreach($pm_ids as $id){
                          
                        $dbw->query( "UPDATE {$awc_tables['awc_f_pms_info']} 
                            SET pmi_folder_id = 2
                            WHERE pmi_id = $id AND pmi_receipt_id = " . $this->m_id );    
                    }
                
                      
            
            }
          #  return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/pmsaved') );
        }
        
        if(count($pm_ids) != 0){
            if($pm_changetodo == 'pm_moveinbox' ){
               
                $dbw->query( "UPDATE {$awc_tables['awc_f_mems']}  
                                SET m_pmsave = m_pmsave - $save_count,
                                    m_pmsent = m_pmsent - $sent_count,
                                    m_pminbox = m_pminbox + $pm_count
                                WHERE m_id =" . $this->m_id );
                                
                                
                foreach($pm_ids as $id){       
                    $dbw->query( "UPDATE {$awc_tables['awc_f_pms_info']}  
                        SET pmi_folder_id = 0
                        WHERE pmi_id = $id AND pmi_receipt_id = " . $this->m_id );    
                }                
            
            }
           # return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/pminbox') );
        }
        return $wgOut->redirect( awcsforum_funcs::awcforum_url('member_options/'.$where) );
        //$wgOut->redirect( awcsforum_funcs::awcforum_url('member_options') );
        

    }


    function pm_list($todo){
     global $wgOut, $awc, $awcUser, $awc_tables;
      
        switch($todo){
            
                case 'pminbox':
                        $where = 'AND pi.pmi_folder_id=0';
                        $title = get_awcsforum_word('mem_pm_inbox') ;
                    break;
                    
                case 'pmsent':
                        $where = 'AND pi.pmi_folder_id=1';
                        $title = get_awcsforum_word('mem_pm_sent') ;
                    break;
                    
                case 'pmsaved':
                        $where = 'AND pi.pmi_folder_id=2';
                        $title = get_awcsforum_word('mem_pm_saved') ;
                    break;
                    
                default:
                        $where = 'AND pi.pmi_folder_id=0';
                        $title = get_awcsforum_word('mem_pm_inbox') ;
                    break;
            
        
        
        
        }

            #if($this->todo_url == 'member_options') Set_AWC_Forum_SubTitle(get_awcsforum_word('word_pm'), $this->membername );         
            
            #if($this->todo_url == 'member_options'){
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_pm'));
            Set_AWC_Forum_BreadCrumbs($title, true);

            
            
            $html = '<form name="pm_list" action="'.awc_url.'member_options/pms_change" method="post"  enctype="multipart/form-data">';   
            $html .= '<table width="100%" class="mem_pm_table" cellpadding="0" cellspacing="0">';
            
            $html .= "<tr><td class='pm_header_new' align='left' nowrap><INPUT type=\"checkbox\" name=\"checkbox_toggle\" onChange=\"checkall_toggle('pm_list','pm_ids[]', this.checked);\"> </td>
                                <td class='pm_header_title' align='left'>".get_awcsforum_word('mem_pm_title')."</td>
                                <td class='pm_header_sender' align='center' nowrap>".get_awcsforum_word('mem_pm_sender')."</td>
                                <td class='pm_header_date' align='center' nowrap>".get_awcsforum_word('mem_pm_sentdate')."</td>
                            </tr>";
                            
            
            $dbr = wfGetDB( DB_SLAVE );
            $sql = "SELECT p.pm_id, p.pm_title, pi.pmi_sender, pi.pmi_sender_id, pi.pmi_read, pi.pmi_send_date, pi.pmi_id, pi.pmi_receipt 
                FROM {$awc_tables['awc_f_pms']} p, {$awc_tables['awc_f_pms_info']} pi 
                    WHERE  p.pm_id=pi.pmi_pmid AND pi.pmi_receipt_id = ". $awcUser->mId . " $where ORDER BY pi.pmi_send_date DESC";
            
            $res = $dbr->query($sql);
            $c = null;
            while ($r = $dbr->fetchObject( $res )) {
                $c ++;
                
                $name =  '<a href="'. awcsforum_funcs::awcforum_url('mem_profile/' .$r->pmi_sender . '/'. $r->pmi_sender_id).'">'. $r->pmi_sender .'</a>';
                
                if($todo == 'pmsent' || $todo == 'pmsaved' AND $r->pmi_sender_id == $this->m_id  ) {
                     $sent_to = '<br />' . $r->pmi_receipt;
                } else {
                    $sent_to = null;
                }
                
                
                $r->pmi_read == 0 ? $ind = get_awcsforum_word('mem_pm_new_indicator') : $ind = '<INPUT TYPE=CHECKBOX value="'.$r->pmi_id.'" name="pm_ids[]" >';
                $html .= "<tr><td class='pm_row' align='left' nowrap>$ind</td>
                                <td class='pm_row' align='left'><a href='".awc_url."member_options/readpm/id".$r->pm_id."'>".$r->pm_title."</a>$sent_to</td>
                                <td class='pm_row' align='center' nowrap>$name</a></td>
                                <td class='pm_row' align='center' nowrap>".awcsforum_funcs::convert_date($r->pmi_send_date, "l")."</td>
                            </tr>";
            }
            $dbr->freeResult( $res ); 
            
            
            $html .= '<tr><td colspan="4"> <br />';
            $html .= get_awcsforum_word('mem_pm_dowhatwith') . ' ';
            $html .= ' <select name="pm_changetodo">
                      <option value="pm_move" SELECTED>'.get_awcsforum_word('mem_pm_movetosave').'</option>
                      <option value="pm_moveinbox">'.get_awcsforum_word('mem_pm_movetoinbox').'</option>
                      <option value="pm_delete">'.get_awcsforum_word('delete').'</option>
                    </select> ';
            $html .= '<input name="where" type="hidden" value="'.$todo.'">' ;
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
                    
            $html .= '</td></tr>';
            
            $html .= '</table>';

            $html .= '</form>';
            
            self::display_memcp($html);
            
    }

    function pm_read(){
    global $wgOut, $awcUser, $awc_tables, $tplt, $awcs_forum_config;
    
            $pmID = str_replace('id', '', $this->id);
            
            $post_cls = new awcs_forum_post_phase();
            $post_box = new awcs_forum_posting_box();
            

            if($this->todo_url == 'member_options/'){
                Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('pm_readingpm'), true); 
            }
            
            
            $dbr = wfGetDB( DB_SLAVE );
            
            $sql = "SELECT * FROM {$awc_tables['awc_f_pms']} p, {$awc_tables['awc_f_pms_info']} pi 
                        WHERE  p.pm_id=pi.pmi_pmid AND pi.pmi_pmid = ". $pmID . " AND pi.pmi_receipt_id = ". $this->m_id  ." LIMIT 1" ;
            
            $res = $dbr->query($sql);
            $r = $dbr->fetchRow( $res ) ;
            
            $post_cls->p_userid = $r['pmi_sender_id'] ;
            $post_cls->p_user = $r['pmi_sender'] ;
            $post_cls->p_title = $r['pm_title'] ;
            $post_cls->p_post = $r['pm_text'];
            
            $post_cls->p_date = $r['pmi_send_date'];
            $post_cls->p_id = $r['pm_id'];
            
            $post_cls->only_one_post = true;
            
            if($r['pmi_read'] == '0'){
                
                    $dbw = wfGetDB( DB_SLAVE );
                   
                    $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} 
                                    SET m_pmunread = m_pmunread - 1
                                    WHERE m_id =" . $this->m_id );
                                    
                $dbw->update( 'awc_f_pms_info',
                                array('pmi_read_date'          => $dbw->timestamp(),
                                      'pmi_read'        => '1',
                                      ), 
                                array('pmi_pmid' => $pmID),
                                '' );
            
            }
            
            $dbr->freeResult( $res );
            
            $word = array();
            $word['delete'] = get_awcsforum_word('delete');
            $word['save'] = get_awcsforum_word('mem_pm_save');
            $word['quote'] = get_awcsforum_word('quote');
            
            $url = awc_url.'member_options/pms_change/pm_delete/id_'.$r['pmi_id'] ;
            $t = $word['delete'] . ' ? \n'.  $r['pm_title'] ;
            $t = str_replace(array(chr(10), chr(13), "'"), '', $t);
                                    
            $info['url'] = $url ;
            $info['msg'] = $t ;                  
            $edit_buttons = $tplt->phase($word, $info, 'post:delete_post');
            
            $info['url'] = awc_url . "member_options/pms_change/pm_move/id_". $r['pmi_id'];
            $edit_buttons .= $tplt->phase($word, $info, 'pm:save_pm');
            
            $info['url'] = awc_url . "member_options/quotepm/id". $pmID;
            $edit_buttons .= $tplt->phase($word, $info, 'post:quote_button');
            
            $post_cls->pm_links = $edit_buttons;
            
            $out['body_info'] .= $post_cls->display_post(true);
            
           # $st['send_to'] = $st['p_user'];
            #$st['pmTitle'] = get_awcsforum_word('word_re') . ' '  . $st['p_title'];
            
            $post_replay = null;
            if(isset($this->mem_info['m_pmoptions']['m_pmautoquote'])){ 
                if($this->mem_info['m_pmoptions']['m_pmautoquote'] == '1'){
                    $post_replay = "[quote=".$r['pmi_sender']."]\n" . $r['pm_text'] . "\n[/quote] \n\n";
                }
            }
            
           
           $m_pmautosave = get_awcsforum_word('mem_pm_savesenttosavesfolder') . '<INPUT TYPE=CHECKBOX NAME="savetosent"><br />' ;
           if(isset($this->mem_info['m_pmoptions']['m_pmautosave'])){  
             if($this->mem_info['m_pmoptions']['m_pmautosave'] == '1'){
                $m_pmautosave = get_awcsforum_word('mem_pm_savesenttosavesfolder') . '<INPUT TYPE=CHECKBOX NAME="savetosent" checked><br />' ;
            }
           }
           $post_box->user_options = $m_pmautosave;
           
           
           $post_box->is_pm = true;
           $post_box->post = $post_replay;
           $post_box->title = get_awcsforum_word('word_re') . ' '  . $r['pm_title'];
           $post_box->title = awcsforum_funcs::awc_htmlentities($post_box->title);
           $post_box->thread_subscribe = false;
           $post_box->quick_box = false;
           $post_box->box_width = "75%";
           
           $post_box->javaCheck = 'onsubmit="return check_NewThread()"';;
           $post_box->url = awc_url . 'member_options/sendpm';
           $post_box->mem_pm_sendto = get_awcsforum_word('mem_pm_sendto') ;
           $post_box->mem_pm_sendto .= ' <input name="send_to" id="send_to" type="text" value="'. $r['pmi_sender'] .'" size="75%"><hr />';
           $post_box->mem_pm_sendto .= "<div id='ajax_pmnames' name='ajax_pmnames'></div>"; // 2.5.8
           $post_box->mem_pm_sendto .= get_awcsforum_word('words_send_to_multi_users') . ' ';
           
           if(UserPerm < 2){
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mem_maxpmsendusers . '<hr />';
           } else {
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mod_maxpmsendusers . '<hr />';
           }
           
            $out['body_info'] .= $post_box->box();
            
            self::display_memcp($out['body_info']);

    }

    function pm_send(){
    global $wgRequest, $wgOut, $awc_tables, $action_url;

        $preview = $wgRequest->getVal( 'preview' );
        $post = $wgRequest->getVal( 'wpTextbox1' );
        
        $title = $wgRequest->getVal( 't_title' );
        $send_to = $wgRequest->getVal( 'send_to' );
        
        #$savetosent = $wgRequest->getVal( 'savetosent' );
        $savetosent = $wgRequest->getVal( 'savetosent' ); 
        $savetosent = ($savetosent== 'on') ? 'checked' : '';
        
        
        $sendto_ids = array();
        $sendto_names = null;
        
        $sendto = explode(';',$send_to);
        $sendto = array_map('trim',$sendto); 
           
        if ((UserPerm == 2 AND count($sendto) > $this->modPMsendlimit) || (UserPerm == 1 AND count($sendto) > $this->userPMsendlimit)){
           $preview = true;
           $l = null;
           UserPerm == 2 ? $l = $this->modPMsendlimit : $l = $this->userPMsendlimit ;
          $info['error'] = get_awcsforum_word('mem_pm_sendtomanypeople') . ' ' . $l ;
        }
       
        
        $dbr = wfGetDB( DB_SLAVE );    
        
        if(strlen($preview) == 0){
             
            $info['error'] = null;
             
              
            
            
            $user_table = $dbr->tableName( 'user' );
              
              
              
            if(!isset($awcUser->mem_send_pm_body_in_email) OR $awcUser->mem_send_thread_body_in_email == '0'){
                $this->cf_send_post_body_in_email = 0;
            } 
              
              
                  
            foreach($sendto as $n => $user){
        	    
                $sql = "SELECT w.user_id, w.user_email, f.m_pmoptions, f.m_idname 
                        FROM $user_table w
                        LEFT JOIN {$awc_tables['awc_f_mems']} f
                        ON w.user_name=f.m_idname
                        WHERE w.user_name='".$user."'
                        LIMIT 1";
                            
                $res = $dbr->query($sql);
                $r = $dbr->fetchRow($res);
                if(!isset($r['user_id'])){
                    
                    
                        $sql = "SELECT w.user_id, w.user_email, f.m_pmoptions, f.m_idname 
                                FROM $user_table w
                                LEFT JOIN {$awc_tables['awc_f_mems']} f
                                ON w.user_name=f.m_idname
                                WHERE w.user_name='".str_replace('_', ' ', $user)."'
                                LIMIT 1";
                                    
                        $res = $dbr->query($sql);
                        $r = $dbr->fetchRow($res);
                
                } 
                
                if(!isset($r['user_id'])){   
                        $info['error'] .= get_awcsforum_word('mem_pm_sendnouserbythatname') . ' ' . $user . '<br />' ;
                        $preview = true;
                } else {
                    
                    $sendto_names .= ', ' . $user ;
                    
                    $pmoptions = isset($r['m_pmoptions']) ? unserialize($r['m_pmoptions']) : 'no_email' ;
                    
                    $sendto_ids[$r['user_id']]['forum_username'] = isset($r['m_idname']) ? $r['m_idname'] : 'no_name' ;
                    $sendto_ids[$r['user_id']]['pass_pm_text'] = '0';
                    
                    if($pmoptions != 'no_email'){
                        
                        if($pmoptions['m_pmnewemail'] == '1' AND isset($r['user_email']) AND !empty($r['user_email'])){
                            $sendto_ids[$r['user_id']]['email'] = $r['user_email'] ;
                            $sendto_ids[$r['user_id']]['pass_pm_text'] = $pmoptions['m_pm_text_in_email'] ;
                        } else {
                          $sendto_ids[$r['user_id']]['email'] = 'no_email'; 
                        }
                        
                    } else {
                        $sendto_ids[$r['user_id']]['email'] = 'no_email'; 
                    }
                     
                    $sendto_ids[$r['user_id']]['name'] = $user;
                    $sendto_ids[$r['user_id']]['id'] = $r['user_id'];
                     
                }
                $dbr->freeResult( $res );
                
            }       
            
            
        }
        
        
        if(strlen($preview) > 1 OR strlen($info['error']) > 1){
            
            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_pm_sendpm'), true); 
            
            
             if(strlen($info['error']) > 1){
                    $out['body_info'] .= "<br /><b><center>".$info['error']."</center></b><br /><hr />";
             }
            
            
            $post_cls = new awcs_forum_post_phase();
            $post_box = new awcs_forum_posting_box();
            
            $post_cls->p_userid = $this->m_id ;
            $post_cls->p_user = $this->membername ;
            $post_cls->p_title = $title ;
            $post_cls->p_post = $post;
            $post_cls->p_date = $dbr->timestamp();
            $post_cls->p_id = $r['pm_id'];
            $post_cls->only_one_post = true;
            $post_cls->pm_links = null;
            
            $out['body_info'] .= $post_cls->display_post(true);
            
            
            
           $m_pmautosave = get_awcsforum_word('mem_pm_savesenttosavesfolder') . '<INPUT TYPE=CHECKBOX NAME="savetosent" '.$savetosent.'><br />' ;
           $post_box->user_options = $m_pmautosave;
           
           
           $post_box->is_pm = true;
           $post_box->post = $post;
           $post_box->title = $title;
           $post_box->thread_subscribe = false;
           $post_box->quick_box = false;
           $post_box->box_width = "75%";
           
           $post_box->javaCheck = 'onsubmit="return check_NewThread()"';;
           $post_box->url = awc_url . 'member_options/sendpm';
           $post_box->mem_pm_sendto = get_awcsforum_word('mem_pm_sendto') ;
           $post_box->mem_pm_sendto .= ' <input name="send_to" id="send_to" type="text" value="'. $send_to .'" size="75%"><hr />';
           $post_box->mem_pm_sendto .= "<div id='ajax_pmnames' name='ajax_pmnames'></div>"; // 2.5.8
           $post_box->mem_pm_sendto .= get_awcsforum_word('words_send_to_multi_users') . ' ';
           
           if(UserPerm < 2){
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mem_maxpmsendusers . '<hr />';
           } else {
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mod_maxpmsendusers . '<hr />';
           }
           
            $out['body_info'] .= $post_box->box();
            
           return  self::display_memcp($out['body_info'] );
        }
         
        $sendto_names = substr($sendto_names , 1);
        require(awc_dir . 'pm.php');
        
        #die(print_r($sendto_ids));
        
        awcforum_pm::sendpm($sendto_ids, $title, $post, $savetosent, $sendto_names);
             
    }

    function pm_create($info =''){
    global $wgOut, $wgRequest, $action_url, $awcs_forum_config;

            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
             
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_pm_sendpm'), true); 
            
           $info['send_to'] = ($wgRequest->getVal('send_to') != '') ? $wgRequest->getVal( 'send_to' ): null;
            
             # awc_pdie($action_url);      
        if($info['send_to'] == null){
            if(isset($action_url[2]) AND !empty($action_url[2])){
                $info['send_to'] = $action_url[2] ;
            }
        }
            
            $post_box = new awcs_forum_posting_box();
            
           $m_pmautosave = get_awcsforum_word('mem_pm_savesenttosavesfolder') . '<INPUT TYPE=CHECKBOX NAME="savetosent"><br />' ;
           if(isset($this->mem_info['m_pmoptions']['m_pmautosave'])){  
             if($this->mem_info['m_pmoptions']['m_pmautosave'] == '1'){
                $m_pmautosave = get_awcsforum_word('mem_pm_savesenttosavesfolder') . '<INPUT TYPE=CHECKBOX NAME="savetosent" checked><br />' ;
            }
           }
           $post_box->user_options = $m_pmautosave;
           
           
           $post_box->is_pm = true;
           $post_box->post = $post_replay;
           $post_box->title = $info['pm_title'];
           $post_box->thread_subscribe = false;
           $post_box->quick_box = false;
           $post_box->box_width = "75%";      
           
           
           // <input name="send_to" type="text" value="" size="75%"
           
           $post_box->javaCheck = 'onsubmit="return check_NewThread()"';;
           $post_box->url = awc_url . 'member_options/sendpm';
           $post_box->mem_pm_sendto = get_awcsforum_word('mem_pm_sendto') ;
           $post_box->mem_pm_sendto .= '<input name="send_to_id" type="hidden" value="'. $action_url[3] .'" >';
           
           $post_box->mem_pm_sendto .= ' <input name="send_to" id="send_to" type="text" value="'. $info['send_to'] .'" size="75%"><hr />';
           $post_box->mem_pm_sendto .= "<div id='ajax_pmnames' name='ajax_pmnames'></div>"; // 2.5.8
           $post_box->mem_pm_sendto .= get_awcsforum_word('words_send_to_multi_users') . ' ';
           
           if(UserPerm < 2){
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mem_maxpmsendusers . '<hr />';
           } else {
                $post_box->mem_pm_sendto .= $awcs_forum_config->cf_mod_maxpmsendusers . '<hr />';
           }

            $out['body_info'] .= $post_box->box();
            self::display_memcp($out['body_info'] );

    }

    function editgen(){
    global $wgOut, $awc, $member_default_forum_options;

            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_edit_gen_option'), true); 
            
            $Config_Settings['cf_displaysmiles'] = array('thread', 'yesno', '1'); # 2.3.5
            
            $mem_forumoptions = isset($this->mem_info['m_forumoptions']) ? $this->mem_info['m_forumoptions'] : null ;
            
            $m_viewaadv = isset($this->mem_info['m_viewaadv']) ? $this->mem_info['m_viewaadv'] == '1'? 'checked' : '' : '' ;
            $m_displaysig = isset($this->mem_info['m_displaysig']) ? $this->mem_info['m_displaysig'] == '1'? 'checked' : '' : '' ;
            $m_displysigonce = isset($this->mem_info['m_displaysigonce']) ? $this->mem_info['m_displaysigonce'] == '1'? 'checked' : '' : '' ;
            
            $html = '<form action="'.awc_url. $this->todo_url . 'miscusersettings" method="post">';
            $html .= '<input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= '<input name="m_id" type="hidden" value="'.$this->m_id.'">' ;      
            #$html .= '<INPUT TYPE=CHECKBOX NAME="m_viewaadv" '. $m_viewaadv.'> ' .get_awcsforum_word('mem_showAdv') . "<br />" ;
            #$html .= '<INPUT TYPE=CHECKBOX NAME="m_displaysig" '.$m_displaysig.'> ' .get_awcsforum_word('mem_showsigs') . "<br />" ;
            #$html .= '<INPUT TYPE=CHECKBOX NAME="m_displaysigonce" '.$m_displysigonce.'> ' .get_awcsforum_word('mem_showsigsonlyonce') . "<br />" ;
            
           # if($mem_forumoptions != null){
           // awcsforum_funcs::get_page_lang(array('lang_txt_admin'));
           
                foreach($member_default_forum_options as $name => $vName){

                    foreach($member_default_forum_options[$name] as $type => $v){
                     
                            if($type != 'options'){
                                 $val = isset($mem_forumoptions[$name]) ?  $mem_forumoptions[$name] : $v ;
                                 
                                    $displayname = get_awcsforum_word($name);
                                   # $name = str_replace('a href=', 'a target="blank" href=', $out);
                                   
                                   $out[$name]['text'] = '' . $displayname . '<hr>';
                            
                                if($type == 'yesno'){
                                    
                                    $out[$name]['option'] = awcsf_CheckYesNo($name, $val) . ' ';           
                               
                               } else if($type == 'drop'){
                                    
                                        if($name == 'css_id'){
                                            $out[$name]['option'] = self::show_active_dropdown();
                                        }
                                        
                                } else {
                                    $out[$name]['option'] = '<input name="'.$name.'" type="text" value="'.$val.'" size="50">  ' ;
                                }
                                
                                $out[$name]['option'] .= '<br /><br />';
                             
                            }   
                    }
                    
                }
                
                
                if($this->send_thread_body_in_email == '0') unset($out['mem_send_thread_body_in_email']);
                if($this->send_post_body_in_email == '0') unset($out['mem_send_post_body_in_email']);
                if($this->send_pm_body_in_email == '0') unset($out['mem_send_pm_body_in_email']);
                if($this->cf_css_mem_select == '0') unset($out['css_id']);
                if($this->cf_FCKeditor == '0') unset($out['cf_FCKeditor']);
                if($this->cf_extrawikitoolbox == '0') unset($out['cf_extrawikitoolbox']);
                
                foreach($out as $id => $info ){
                    $html .= $out[$id]['text'];
                    $html .= $out[$id]['option'];
                }
            
            
            $html .= '<br /><hr><input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><hr>'; 
            
            self::display_memcp($html);
            
    }

    function show_active_dropdown(){
        global $awcs_forum_config, $member_info;
            
            $dbr = wfGetDB( DB_SLAVE );
            
            $awc_f_theme = $dbr->tableName( 'awc_f_theme' ); 
            
            $cf_css_active_ids = implode(',',$awcs_forum_config->cf_css_active_ids);
            $sql = "SELECT thm_title, thm_id 
                        FROM $awc_f_theme
                        WHERE thm_id IN ({$cf_css_active_ids})" ;
                        
            $res = $dbr->query($sql); 
            
            $out = '<select name="css_id">';   
            
            
                while ($r = $dbr->fetchObject( $res )) {
                    if($r->thmn_id == $member_info['m_forumoptions']['css_id']){
                        $out .=  "<option value='{$r->thm_id}' SELECTED>{$r->thm_title}</option>"; 
                    } else {
                        $out .=  "<option value='{$r->thm_id}'>{$r->thm_title}</option>"; 
                    }
                }
                
             $out .=  '</select> '; 
             
             return $out;  
        
        }

    function getPMoptions(){
    global $wgOut, $awc, $awcs_forum_config;

            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_pm_option'), true); 
            
            
            $m_pmautoquote = isset($this->mem_info['m_pmoptions']['m_pmautoquote']) ? $this->mem_info['m_pmoptions']['m_pmautoquote'] == '1'? 'checked' : '' : '' ;
            $m_pmautosave = isset($this->mem_info['m_pmoptions']['m_pmautosave']) ? $this->mem_info['m_pmoptions']['m_pmautosave'] == '1'? 'checked' : '' : '' ;
            $m_pmnewemail = isset($this->mem_info['m_pmoptions']['m_pmnewemail']) ? $this->mem_info['m_pmoptions']['m_pmnewemail'] == '1'? 'checked' : '' : '' ;
            $m_pmpop = isset($this->mem_info['m_pmoptions']['m_pmpop']) ? $this->mem_info['m_pmoptions']['m_pmpop'] == '1'? 'checked' : '' : '' ;
            
            $m_pm_text_in_email = isset($this->mem_info['m_pmoptions']['m_pm_text_in_email']) ? $this->mem_info['m_pmoptions']['m_pm_text_in_email'] == '1'? 'checked' : '' : '' ;
            
            $html = '<form action="'. awcsforum_funcs::awcforum_url('member_options/savePMoptions').'" method="post">';
            
            $html .= '<INPUT TYPE=CHECKBOX NAME="m_pmautoquote" '. $m_pmautoquote.'> ' .get_awcsforum_word('mem_pm_autoquote') . "<br />" ;
            $html .= '<INPUT TYPE=CHECKBOX NAME="m_pmautosave" '. $m_pmautosave.'> ' .get_awcsforum_word('mem_pm_autosave') . "<br />" ;
            $html .= '<INPUT TYPE=CHECKBOX NAME="m_pmnewemail" '. $m_pmnewemail.'> ' .get_awcsforum_word('mem_pm_newemail') . "<br />" ;
            
            
            if(isset($awcs_forum_config->cf_send_pm_body_in_email) && $awcs_forum_config->cf_send_pm_body_in_email == '1'){
            	$html .= '<INPUT TYPE=CHECKBOX NAME="m_pm_text_in_email" '. $m_pm_text_in_email.'> ' .get_awcsforum_word('mem_send_pm_body_in_email') . "<br />" ;
            }
            
            
            $html .= '<INPUT TYPE=CHECKBOX NAME="m_pmpop" '. $m_pmpop.'> ' .get_awcsforum_word('mem_pm_newpop') . "<br />" ;
            $html .= '<br /><hr><input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><hr>'; 
            
            self::display_memcp($html);
    }

    function savePMoptions(){
    global $wgRequest, $wgOut, $awc_tables, $awcUser;
                              
            $wgRequest->getVal('m_pmautoquote') == 'on' ? $m_pmautoquote = '1' : $m_pmautoquote = '0';
            $wgRequest->getVal('m_pmautosave') == 'on' ? $m_pmautosave = '1' : $m_pmautosave = '0';
            $wgRequest->getVal('m_pmnewemail') == 'on' ? $m_pmnewemail = '1' : $m_pmnewemail = '0';
            $wgRequest->getVal('m_pmpop') == 'on' ? $m_pmpop = '1' : $m_pmpop = '0';
            
            $m_pm_text_in_email = ($wgRequest->getVal('m_pm_text_in_email') == 'on') ? '1' : '0';
            
            $m_pmoptions = array('m_pmautoquote'=>$m_pmautoquote,
                                    'm_pmautosave'=>$m_pmautosave,
                                    'm_pmnewemail'=>$m_pmnewemail,
                                    'm_pmpop'=>$m_pmpop,
                                    'm_pm_text_in_email'=>$m_pm_text_in_email, );
            
            
            $dbw = wfGetDB( DB_MASTER );
            $dbr = wfGetDB( DB_SLAVE );
            
            $r = $dbr->selectRow( 'awc_f_mems', 
                                        array( 'm_idname' ), 
                                        array( 'm_id' => $this->m_id ) );
            
            if ((isset($r->m_idname) AND $r->m_idname != '') OR $this->m_id == $awcUser->mId) {
                
                $dbw->update( 'awc_f_mems',
                                array('m_pmoptions'    => serialize($m_pmoptions), ), 
                                array('m_id' => $this->m_id),
                                '' );
            } else {
                
                $dbw->insert( 'awc_f_mems', array(
                                'm_id'              => $this->m_id,
                                'm_idname'          => $this->membername,
                                'm_pmoptions'  => serialize($m_pmoptions),
                ) );
            }
            
            $wgOut->redirect( awc_url . $this->todo_url );
    }

    function avatar_get(){
    global $wgOut, $awcs_forum_config;

            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_general_options')); 
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_edit_avatar_option'), true); 
            
           if(isset($this->mem_info['m_adv'])){
                $m_adv = '<DIV align="center"><img align="left" src="'. $this->mem_info['m_adv'] .'" border="0" height="'. $this->mem_info['m_advh'] .'" width="'. $this->mem_info['m_advw'] .'" align="middle"/></div>';
                $m_advURL = $this->mem_info['m_adv'];
                $m_advtag = $this->mem_info['m_advtag'];
                if($m_advtag == '') $m_advtag = $m_advURL;
           }else{
                $m_adv = '' ;
                 $m_advURL = '';
                 $m_advtag = '';
           }
            
            
            $html = get_awcsforum_word('mem_advatarsize') . ' '.$awcs_forum_config->cf_AvatraSize . '<hr>';
            if($awcs_forum_config->cf_advatar_no_url == '0') $html .= get_awcsforum_word('mem_advatar_no_url') . '<br />';
            if($awcs_forum_config->cf_advatar_no_wiki == '0') $html .= get_awcsforum_word('mem_advatar_no_wiki') . '<br />';
            
            $html .= $m_adv . ' <br /> ';
            
            $html .= ' <form enctype="multipart/form-data" id="get_advatar" name="get_advatar" action="'.awc_url. $this->todo_url . 'CheckAvatraSize" method="post">';
            $html .= ' <input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= ' <input name="m_id" type="hidden" value="'.$this->m_id.'">' ; 
            
            $html .= ' <input name="path" type="text" value="'.$m_advtag .'" size="75"><br />';
            if($this->upload == '1') $html .= ' <input name="uploaded" type="file" size="62" /><br />';      
            $html .= ' <INPUT TYPE=CHECKBOX NAME="clear_ad"> ' .get_awcsforum_word('mem_delete_advatar') . '<br />' ;
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><br />';
            
            self::display_memcp($html);
            
    }

    function sig_get_edit(){
    global $wgOut;


            Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_general_options')); 
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_edit_sig_option'), true); 
                
            $sig_is = isset($this->mem_info['m_sig']) ? $this->mem_info['m_sig'] : '';
            
            $html = '<form action="'.awc_url. $this->todo_url . 'save_sig" method="post">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0">';
            $html .= '<tr><td class="mem_name">';
            
            $raw_sig = $sig_is;
            $sig_is = remove_forum_tag_from_post($sig_is);
            $sig_is = br_convert($sig_is);
            $sig_is = awc_wikipase($sig_is, $wgOut) ;
            $sig_is = Convert($sig_is);         
            $html .= $sig_is;
            
            $html .= '</tr></td></table>';
            $html .= '<table class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
            $html .= '<td width="100%" align="left">';
            $html .= $this->WikiToolBar ;
            $html .= '<input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= '<input name="m_id" type="hidden" value="'.$this->m_id.'">' ;
            $html .= '<textarea name="wpTextbox1" id="wpTextbox1" cols="70%" rows="10" wrap="virtual" class="post_box" onKeyDown="limitText(this.form.wpTextbox1,this.form.countdown,'.  $this->sig_length .');" 
    onKeyUp="limitText(this.form.wpTextbox1,this.form.countdown,'.  $this->sig_length .');"">'.$raw_sig.'</textarea>';
            $html .= '<br />';        
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">  ' . get_awcsforum_word('cf_SigLength') . ' '.  $this->sig_length .' / <input readonly type="text" name="countdown" size="3" value="100"></form>';
            $html .= '</td>';
            $html .= '</tr></table></form>';
            
            self::display_memcp($html);
            
            
    }

    function saveForumOptions(){
     global $wgRequest, $wgOut, $member_default_forum_options, $awc_tables;
     
            $viewaadv = $wgRequest->getVal( 'm_viewaadv' );  
            $viewaadv == 'on' ? $viewaadv = '1': $viewaadv = '0';
            
            $wgRequest->getVal('m_displaysig') == 'on' ? $display = '1' : $display = '0';
            $wgRequest->getVal('m_displaysigonce') == 'on' ? $onlyone = '1' : $onlyone = '0';
            
            $dbw = wfGetDB( DB_MASTER );
            $dbr = wfGetDB( DB_SLAVE );
            
            $sql = "SELECT m_idname FROM {$awc_tables['awc_f_mems']} WHERE m_id='".$this->m_id."'";
            $res = $dbr->query($sql);
            $r = $dbr->fetchObject( $res );
            $n = $r->m_idname ;
            $dbr->freeResult( $res );
            
            # m_forumoptions
            $m_forumoptions = array();
            foreach($member_default_forum_options as $name => $v ){
                $m_forumoptions[$name] = $wgRequest->getVal($name); 
            }
            
            
                $dbw->update( 'awc_f_mems',
                                array('m_forumoptions'          => serialize($m_forumoptions),), 
                                array('m_id' => $this->m_id),
                                '' );
                                
            unset($m_forumoptions);
                                
            if($this->here == true) $this->todo_url = 'member_options/editgen';
            $wgOut->redirect( awc_url . $this->todo_url );
           
            return ;
            
            
            if ($n) {
                
                $dbw->update( 'awc_f_mems',
                                array('m_viewaadv'          => $viewaadv,
                                      'm_displaysig'        => $display,
                                      'm_displaysigonce'    => $onlyone,
                                      ), 
                                array('m_id' => $this->m_id),
                                '' );
            } else {
                
                $dbw->insert( 'awc_f_mems', array(
                                'm_id'              => $this->m_id,
                                'm_idname'          => $this->membername,
                                'm_viewaadv'        => $viewaadv,
                                'm_displaysig'      => $display,
                                'm_displaysigonce'  => $onlyone,
                ) );
            }
            
            if($this->here == true) $this->todo_url = 'member_options/editgen';
            $wgOut->redirect( awc_url . $this->todo_url );

    }

    function clearIndicators(){
     global $wgOut, $tplt;
      
         awcsforum_funcs::clear_session();
         awcsforum_funcs::clear_awcsforum_cookie();
         awcsforum_funcs::set_session(wfTimestampNow());
         
         
         awcsforum_funcs::get_page_lang(array('lang_txt_redirects')); // get lang difinitions... 
         $tplt->add_tplts(array("'redirect'", ), true);
         
         $info['msg'] = 'clearIndicators';
         $info['url'] = $_SERVER['HTTP_REFERER'] ;
         return awcf_redirect($info);
                    
        // member_options/clearIndicators
         
        // $wgOut->redirect( $_SERVER['HTTP_REFERER']);  
     
     }
     
    function DisplayUserInfo1(){
     global $wgOut, $awcUser, $awc_tables;

            
            $this->pm_list('pminbox');
            
            return ;
            
            
            if($this->todo_url == 'member_options') Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            

            

            
            $html = '<table width="100%" class="mem_pm_table" cellpadding="0" cellspacing="0">';
            
            $html .= "<tr><td class='pm_header' width='5%' align='left' nowrap>".get_awcsforum_word('mem_pm_new')."</td>
                                <td class='pm_header' width='85%' align='left' nowrap>".get_awcsforum_word('mem_pm_title')."</td>
                                <td class='pm_header' width='5%' align='left' nowrap>".get_awcsforum_word('mem_pm_sender')."</td>
                                <td class='pm_header' width='5%' align='left' nowrap>".get_awcsforum_word('mem_pm_sentdate')."</td>
                            </tr>";
                            
            
            $dbr = wfGetDB( DB_SLAVE );
            
            $sql = "SELECT p.pm_id, p.pm_title, pi.pmi_sender, pi.pmi_read, pi.pmi_send_date 
                FROM {$awc_tables['awc_f_pms']} p, {$awc_tables['awc_f_pms_info']} pi 
                    WHERE  p.pm_id=pi.pmi_pmid AND pi.pmi_receipt_id = ". $awcUser->mId . " AND pi.pmi_folder_id=0 ORDER BY pi.pmi_send_date DESC";
            
            $res = $dbr->query($sql);
            $c = null;
            while ($r = $dbr->fetchObject( $res )) {
                $c ++;
                $r->pmi_read == 0 ? $ind = '->' : $ind = '';
                $html .= "<tr><td class='pm_row' width='5%' align='left' nowrap>$ind</td>
                                <td class='pm_row' width='85%' align='left' nowrap><a href='".awc_url."member_options/readpm/id".$r->pm_id."'>".$r->pm_title."</a></td>
                                <td class='pm_row' width='5%' align='left' nowrap>".$r->pmi_sender."</td>
                                <td class='pm_row' width='5%' align='left' nowrap>".awcsforum_funcs::convert_date($r->pmi_send_date, "l")."</td>
                            </tr>";
            }
            $dbr->freeResult( $res ); 
            
            
            $html .= '</table>';
             # m_pmcount
              
            $info = array();
              
            self::display_memcp($html);
            
      }
     
    function DisplayUserInfo_for_admin(){
     global $wgOut, $awcs_forum_config;

            if($this->todo_url == 'member_options') Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_memCP'), $this->membername );         
            
            if($this->todo_url == 'member_options'){
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_memCP')); 
                Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url . $this->todo_url . '">' . get_awcsforum_word('word_mem')  .'</a>');
                Set_AWC_Forum_BreadCrumbs($this->membername, true ); 
            }
            
            $html = '';
             /*
            $user_get = array();
            $user_get[] = 'm_id';
            $user_get[] = 'm_idname';
            $user_get[] = 'm_sig';
            $user_get[] = 'm_viewaadv';
            $user_get[] = 'm_displaysig';
            $user_get[] = 'm_displaysigonce';
            $user_get[] = 'm_adv';
            $user_get[] = 'm_advtag';
            $user_get[] = 'm_displaysigonce';
            $info = GetMemInfo($this->m_id, $user_get);
            unset($user_get);
              */
            $sig_is = isset($this->mem_info['m_sig']) ? $this->mem_info['m_sig'] : '';
            #$m_viewaadv = isset($this->mem_info['m_viewaadv']) ? $this->mem_info['m_viewaadv'] == '1'?'checked' : '' : '' ;
            #$m_displaysig = isset($this->mem_info['m_displaysig']) ? $this->mem_info['m_displaysig'] == '1'? 'checked' : '' : '' ;
            #$m_displysigonce = isset($this->mem_info['m_displaysigonce']) ? $this->mem_info['m_displaysigonce'] == '1'? 'checked' : '' : '' ;
            
           if(isset($this->mem_info['m_adv'])){
                $m_adv = '<DIV align="center"><img align="left" src="'. $this->mem_info['m_adv'] .'" border="0" height="'. $this->mem_info['m_advh'] .'" width="'. $this->mem_info['m_advw'] .'" align="middle"/></div>';
                $m_advURL = $this->mem_info['m_adv'];
                $m_advtag = $this->mem_info['m_advtag'];
                if($m_advtag == '') $m_advtag = $m_advURL;
           }else{
                $m_adv = '' ;
                 $m_advURL = '';
                 $m_advtag = '';
           }

            
            # start table...
            #$html = '<a href="http://wiki.anotherwebcom.com/Category:MediaWiki:Forum" target="new"><img src="http://anotherwebcom.com/awc_forum_update.gif"></a>';
            $html = '<p align="right"><a href="http://wiki.anotherwebcom.com/Category:MediaWiki:Forum" target="new"><img src="http://anotherwebcom.com/awc_forum_update.gif"></a></p>';
            $html .= '<br /><table width="100%" class="forum_posts" cellpadding="0" cellspacing="0">';
            $html .= '<tr><td valign="top"> ';
            
            # MISC User Settings ...
            #$html .= '<form action="'.awc_url. $this->todo_url . 'miscusersettings" method="post">';
            #$html .= '<input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            #$html .= '<input name="m_id" type="hidden" value="'.$this->m_id.'">' ;      
            #$html .= '<INPUT TYPE=CHECKBOX NAME="m_viewaadv" '. $m_viewaadv.'> ' .get_awcsforum_word('mem_showAdv') . "<br />" ;
           # $html .= '<INPUT TYPE=CHECKBOX NAME="m_displaysig" '.$m_displaysig.'> ' .get_awcsforum_word('mem_showsigs') . "<br />" ;
           # $html .= '<INPUT TYPE=CHECKBOX NAME="m_displaysigonce" '.$m_displysigonce.'> ' .get_awcsforum_word('mem_showsigsonlyonce') . "<br />" ;
            #$html .= '<input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><hr>';        
            
            # Avatar stuff ... 
            $html .= get_awcsforum_word('mem_advatarsize') . ' '.$awcs_forum_config->cf_AvatraSize . '<hr>';
            if($awcs_forum_config->cf_advatar_no_url == '0') $html .= get_awcsforum_word('mem_advatar_no_url') . '<br />';
            if($awcs_forum_config->cf_advatar_no_wiki == '0') $html .= get_awcsforum_word('mem_advatar_no_wiki') . '<br />';
            
            $html .= $m_adv . ' <br /> ';
            
            $html .= ' <form enctype="multipart/form-data" id="get_advatar" name="get_advatar" action="'.awc_url. $this->todo_url . 'CheckAvatraSize" method="post">';
            $html .= ' <input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= ' <input name="m_id" type="hidden" value="'.$this->m_id.'">' ; 
            
            $html .= ' <input name="path" type="text" value="'.$m_advtag .'" size="100"><br />';
            if($this->upload == '1') $html .= ' <input name="uploaded" type="file" size="87" /><br />';      
            $html .= ' <INPUT TYPE=CHECKBOX NAME="clear_ad"> ' .get_awcsforum_word('mem_delete_advatar') . '<br />' ;
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><br />';
            
            $html .= '</td></tr>'; 
            $html .= '<tr><td>'; 
            
            $html .= '<form action="'.awc_url. $this->todo_url . 'save_sig" method="post">';
            $html .= '<br /><br /><table width="100%" class="forum_posts" cellpadding="0" cellspacing="0">';
            $html .= '<tr><td>'. get_awcsforum_word('mem_word_sig') . '</td></tr>';
            $html .= '<tr><td class="mem_name">';
            $html .= convert($wgOut->parse($sig_is));
            $html .= '</tr></td></table>';
            $html .= '<table class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
            $html .= '<td width="100%" align="left">';
            $html .= $this->WikiToolBar ;
            $html .= '<input name="mem_name" type="hidden" value="'.$this->membername.'">' ;
            $html .= '<input name="m_id" type="hidden" value="'.$this->m_id.'">' ;
            $html .= '<textarea name="wpTextbox1" id="wpTextbox1" cols="98%" rows="10" wrap="virtual" class="post_box" onKeyDown="limitText(this.form.wpTextbox1,this.form.countdown,'.  $this->sig_length .');" 
    onKeyUp="limitText(this.form.wpTextbox1,this.form.countdown,'.  $this->sig_length .');"">'.$sig_is.'</textarea>';
            $html .= '<br />';        
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">  ' . get_awcsforum_word('cf_SigLength') . ' '.  $this->sig_length .' / <input readonly type="text" name="countdown" size="3" value="100"></form>';
            $html .= '</td>';
            $html .= '</tr></table></form>';

            
            $html .= '</td></tr>';
            
            $html .= '</table><br /><br />';
           
             return $html;
     }
     
    function avatra_check_size(){
     global $wgOut, $wgRequest, $awcs_forum_config, $wgScriptPath, $IP;
     
            $path = trim($wgRequest->getVal( 'path' ));
                 
             /*    
            $user_get = array();
            $user_get[] = 'm_id';
            $user_get[] = 'm_idname';
            $user_get[] = 'm_adv';
            $user_get[] = 'm_advtag';
            #die(print_r($user_get));
            $info = GetMemInfo($this->m_id, $user_get);
            unset($user_get);
             */
                 if(substr($wgScriptPath , strlen($wgScriptPath) -1, 1) == '/' || substr($wgScriptPath , strlen($wgScriptPath) -1, 1) == '\\'){
                    $sPath =  substr($wgScriptPath , 0, strlen($wgScriptPath) -1) . $this->imagepath;
                 } else {
                    $sPath =  $this->imagepath;
                 }
                 
                 $delete_image = $this->imagefolder . str_replace($sPath, '', $this->mem_info['m_adv']);
                        
                if( $wgRequest->getVal('clear_ad') == 'on'){
                     
                     $dbw = wfGetDB( DB_MASTER );
                     $dbw->update( 'awc_f_mems',
                            array('m_adv' => '', 'm_adv_size' =>'0x0', 'm_advtag' => '',), 
                            array('m_id' => $this->m_id),
                            '' );
                            
                     @unlink($delete_image); 
                           
                    return $wgOut->redirect( awc_url . $this->todo_url  ); 
                }
                
                
                
                $splAWC = explode('x', $awcs_forum_config->cf_AvatraSize);
                $aD = $awcs_forum_config->cf_AvatraSize;
                $aH = $splAWC[0];
                $aW = $splAWC[1];
                 
                
                $ext = explode(',', $this->uploadext);
                $ext = array_map('trim',$ext); 
                 
                 if($_FILES["uploaded"]["error"] == '0'){
                     
                     $size = $_FILES["uploaded"]["size"] ;
                     $path = $_FILES["uploaded"]["tmp_name"] ;
                     $name = $_FILES["uploaded"]["name"] ;
                     
                     $img = getimagesize($path);
                     
                     $type = $img['mime'];
                     $type = str_replace('image/', '', $type);
                     
                     if($size > $this->uploadsize ) return  $size . ' ' . get_awcsforum_word('mem_advatar_upload_size') . ' ' . $this->uploadsize ; 
                     
                     
                     if(!in_array($type, $ext)) return get_awcsforum_word('mem_advatar_upload_ext') . ' ' . $this->uploadext . '<br />' . get_awcsforum_word('mem_advatar_upload_extyourectis') . '<b>'. $type . '</b> ';
                     
                        $h =  $img['1'];
                        $w =  $img['0'];
                        
                        if($h > $aH || $w > $aW) return get_awcsforum_word('mem_advatarsize') . " $aD. <br />Your pic is " . $h . 'x' . $w;
                        
                        if(@move_uploaded_file($path, $this->imagefolder . $this->m_id . '_' . $name)){
                            
                            @unlink($delete_image);
                                                    
                            $this->avtar_save($sPath . $this->m_id . '_' . $name, $h, $w, $name);
                            return $wgOut->redirect( awc_url . $this->todo_url  );
                            
                        } else {
                            return get_awcsforum_word('mem_advatar_upload_no_move');
                        }
                                
            } else if(strstr($path,"http://")){
                
                
                if($path == '') return get_awcsforum_word('mem_noAvatar');
                
                if($awcs_forum_config->cf_advatar_no_url == '0') return get_awcsforum_word('mem_advatar_no_url');
                
                
                $path = str_replace(' ', '%20', $path);
                #$path = urlencode($path);
                $img = getimagesize($path);            
                
                if(isset($img['mime'])){
                    
                    $h =  $img['1'];
                    $w =  $img['0'];
                    $type = $img['mime'];
                    
                    if($w > $aW or $h > $aH) return get_awcsforum_word('mem_advatarsize') . " $aD. <br />Your pic is " . $h . 'x' . $w;
                    
                    $type = str_replace('image/', '', $img['mime']);
                    if(!in_array($type, $ext)) return  $type . ' ' . get_awcsforum_word('mem_advatar_upload_ext') . ' ' . $this->uploadext ;                
                    
                    
                    @unlink($delete_image); 
                     
                    $this->avtar_save($path, $h, $w,  $path);
                    $wgOut->redirect( awc_url . $this->todo_url  ); 
                    
                } else {
                    return get_awcsforum_word('word_noadvatarurl');
                }
             
            }  else if(substr($path,0,2) == '[['){
                
                if($path == '') return get_awcsforum_word('mem_noAvatar'); 
                
                if($awcs_forum_config->cf_advatar_no_wiki == '0' AND substr($path,0,2) == '[[') return get_awcsforum_word('mem_advatar_no_wiki');
                #$img = $path;  
                $tag = $path ;       
                $pic = $wgOut->parse($path);
                
                $spl_w = explode('width="', $pic);
                $spl_w = explode('"', $spl_w[1]);
                $w = $spl_w[0];
                
                $spl_h = explode('height="', $pic);
                $spl_h = explode('"', $spl_h[1]);
                $h = $spl_h[0];
                
                if(!is_numeric($w) || !is_numeric($h)) return get_awcsforum_word('mem_cantreadwikiimagetag'); 
                
                $spl_p = explode('src="', $pic);
                $spl_p = explode('"', $spl_p[1]);
                $path = $spl_p[0];
                
                if($w > $aW or $h > $aH) return get_awcsforum_word('mem_advatarsize') . " $aD. <br />Your pic is " . $w . 'x' . $h;
               
               @unlink($delete_image); 
                
                $this->avtar_save($path, $h, $w, $tag);
                
                $wgOut->redirect( awc_url . $this->todo_url  );
                
            } else {
            
                return get_awcsforum_word('mem_miscAvatarprobelm');
            
            }
            
     
     }
     
    function avtar_save($p, $w, $h , $t){
    	
            $dbw = wfGetDB( DB_MASTER );
            if(!isset($this->mem_info['name'])){
                    
                  $dbw->insert( 'awc_f_mems', array(
                                'm_adv'       => $p,
                                'm_advtag'       => $t,
                                'm_idname'       => $this->membername,
                                'm_id'       => $this->m_id, 
                                'm_adv_size'        => $h . 'x' . $w,

                            ) );
                           
            } else {
                            $dbw->update( 'awc_f_mems',
                                            array('m_advtag' => $t, 'm_adv' => $p, 'm_adv_size' => $h . 'x' . $w), 
                                            array('m_id' => $this->m_id),
                                            '' );
            }
                        
                        
     }

    function sig_save(){
     global $wgRequest, $wgOut, $awc_tables, $awcUser;
			    
		    
            $post = $wgRequest->getVal( 'wpTextbox1' );
            $post = str_replace("'", "\'", $post);
            
            $dbw = wfGetDB( DB_MASTER );
            $dbr = wfGetDB( DB_SLAVE );
            
            $r = $dbr->selectRow( 'awc_f_mems', 
                                        array( 'm_idname' ), 
                                        array( 'm_id' => $this->m_id ) );
            
            if ((isset($r->m_idname) AND $r->m_idname != '') OR $this->m_id == $awcUser->mId) {
		        $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} SET m_sig = '". $post . "' WHERE m_id=" . $this->m_id  );
            } else {
		        $dbw->insert('awc_f_mems',  array('m_id' => $this->m_id, 'm_idname' => $this->membername, 'm_sig'=> $post, ) );
            }
                                                                     
            if($this->here == true) $this->todo_url = 'member_options/editsig';
            $wgOut->redirect( awc_url . $this->todo_url );  
			    
			    
     }


}