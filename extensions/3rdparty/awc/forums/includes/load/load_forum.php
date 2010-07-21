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
* @filepath /extensions/awc/forums/load/load_forum.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

function load_awcs_forum(){
# $START = processing_time(); // Used for testing speed... $RESULT at bottom...
global $wgRequest, $wgOut, $wgScriptPath;
global $awc, $awcUser, $awc_tables, $awc_ver, $ForumStat, $awcs_forum_config, $WhoWhere, $action_url, $tplt;
global $awc_url, $wiki_url, $style_path, $button_path, $awc__url;
    
    require_once(awc_dir . "includes/funcs.php");
    require_once(awc_dir . "includes/gen_funk.php");
    require_once(awc_dir . "includes/gen_class.php"); // awcs_forum_config, awcs_forum_user, awcs_forum_stats, 
         
    
     $WhoWhere = null;
                                                
    define('awc_path', $wgScriptPath .  awcForumPath );
    define('emo_path', awc_path . 'images/emotions/default/' );
    
    define('button_path', awc_path . 'images/buttons/default/' );
    
    $style_path = awc_path . 'skins/';  // used in awcs_forum_skin_templetes::phase() for "find and replace"
    $button_path = button_path ;  // used in awcs_forum_skin_templetes::phase() for "find and replace"
    $wiki_url = awcsf_wiki_url;  // used in awcs_forum_skin_templetes::phase() for "find and replace" 
    $awc_url = awc_url ;  // used in awcs_forum_skin_templetes::phase() function for "find and replace" 
    
    $awc__url = $awc_url;
    
    if(!isset($awcUser)){
        $awcUser = new awcs_forum_user();
    }
    
    
    $wgRequest->action = null;
    $clean_todo = null;
    
    $clean_todo_arr = $wgRequest->getVal( 'title' );
    $clean_todo_arr = rawurldecode($clean_todo_arr);
    $clean_todo_arr = explode('/', $clean_todo_arr);
    
    
    if(isset($clean_todo_arr[1]) AND (!isset($_GET['action']) OR !isset($_POST['action']))){
        
        $count_to = (count($clean_todo_arr)-1);
        for ($i = 1; $i <= $count_to; ++$i) {
            $clean_todo .= $clean_todo_arr[$i] . "/";
        }
        
       $wgRequest->action = $clean_todo ;        
    }
    
    $action = $wgRequest->getVal( 'action' );
    if($action == null){
        $action = $clean_todo ;
    } else {
        $action = str_replace('%2F','/',$action) ;
        $wgRequest->action = $action;
    }
    
    $action_spl = explode("/", $action);
    
    #$todo = $action_spl[0];
    $action_url = array();
    $action_url['all'] = $action ;
    $action_url['what_file'] = $action_spl[0] ;
    
    if(isset($action_spl[1])){
        
        if(strstr($action_spl[1],"id")){
            $action_url['id'] = str_replace(array('_','id','id_'), '', $action_spl[1]) ;
        } else {
           $action_url['section'] = ($action_spl[1]) ;
           $action_url['id'] = $wgRequest->getVal('id'); 
        }
        
    } else{
        $action_url['id'] = $wgRequest->getVal('id'); 

    }
        
    if(isset($action_spl[2]))$action_url['todo'] = $action_spl[2] ;
    
    foreach($action_spl as $act){
        
        if(strstr($act,"id_")){
            $action_url['id'] = str_replace(array('_','id','id_'), '', $act) ;
        } else {
            $action_url[] = $act;
        }
    }
    
    if($wgRequest->action == "install_forum" AND in_array('sysop', $awcUser->mGroups)){
        require(awc_dir . "updates/install/install_forum.php");
        return ;
    }
    
    
    if(!isset($awcs_forum_config)){
        $awcs_forum_config = new awcs_forum_config();  // gen_class.php
    }
    
    
    
    if($awcs_forum_config->get_config() === false){
        $out =  $awcs_forum_config->get_install() ;
        $wgOut->addHTML($out);
        return ;
    }
   # die("k,h");
    
    //  Note:
    // This needs to be after the awcs_forum_config()
    // for some reason the unserialize() gets messed with the default CSS and cant read it correctly
    if(awcs_forum_convert_latin){
        $dbw = wfGetDB( DB_MASTER );
        $dbw->query("SET NAMES latin1");
        unset($dbw);
    }
                                 
    /*                             
    // Check to see if forum is installed by checking of the Dbase config table is there...
    if(!$awcs_forum_config->installed){
        $out =  $awcs_forum_config->get_install() ;
        $wgOut->addHTML($out);
        return ;
    }
    
   */
    
    // ckeck forum version...
     if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '<')){
            global $wgRequest;
            if(!strstr($wgRequest->action, "admin/forum_update") AND !strstr($wgRequest->action, "admin/get_updates")){
                
                if(!in_array('sysop', $awcUser->mGroups)){
                        awcs_forum_wfLoadExtensionMessages( 'AWCforum_genral_forum' );
                        $wgOut->addHTML("<center>".wfMsg('awcsf_updating')."<br /> <b>".wfMsg('awcsf_sysops_login')."</b></center>");
                    return ;
                }
                die(header('Location: ' . awc_url . 'admin/forum_update' ));
            }
     }
    
    if(isset($awcs_forum_config->cf_header_import) and !empty($awcs_forum_config->cf_header_import)){
        $header = awc_wikipase($awcs_forum_config->cf_header_import, $wgOut);
        $wgOut->addHTML($header);
    }
    
    // load this after config_config
    require(awc_dir . "includes/load/load_skin_tplts.php");
    
    if(!isset($tplt)){
          require(awc_dir . 'admin.php');
          awcsforum_funcs::get_table_names(array('awc_f_cats',), true); // Get all the forums d-base table names, check for table pre-fix
                
          awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_admin')); // get lang difinitions...  
                                        
          $admin = new awcforum_forumAdmin();
          $admin->enterAdmin($action);
          return ;
    }
    
    // load lang difinistions and get sql table names
    switch( $action_url['what_file'] ) {
            case 'search':
                require(awc_dir . 'search.php');
                awcsforum_funcs::get_table_names(array('awc_f_threads',
                                        'awc_f_posts',
                						'awc_f_forums',
                						'awc_f_cats',)); // Get all the forums d-base table names, check for table pre-fix
                                        
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search')); // get lang difinitions...  
                break;
            
            case 'post':
                require(awc_dir . 'post.php');
                awcsforum_funcs::get_table_names(array('awc_f_polls',
                                        'awc_f_posts',
                						'awc_f_forums',
                						'awc_f_threads',
                						'awc_f_watchthreads',
                						'awc_f_watchforums',)); // Get all the forums d-base table names, check for table pre-fix
                                                            
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_thread', 
                                        'lang_txt_redirects')); // get lang difinitions... 
                break;
            
            case 'st': 
            case 'sp':
            case 'last_post':
            case 'delete_post':
            case 'delete_thread':
                require(awc_dir . 'thread.php');
                awcsforum_funcs::get_table_names(array('awc_f_posts',
                						'awc_f_threads',
                                        'awc_f_polls',
                						'awc_f_forums',
                                        'awc_f_member_titles',
                						'awc_f_cats',)); // Get all the forums d-base table names, check for table pre-fix
                                        
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_thread')); // get lang difinitions... 
                break;

        
            case 'member_options':
                require(awc_dir . 'members.php');
                awcsforum_funcs::get_table_names(array('awc_f_watchthreads',
                						'awc_f_watchforums',
                						'awc_f_threads',
                						'awc_f_pms_info',
                						'awc_f_pms',
                						'awc_f_mems',
                						'awc_f_threads',)); // Get all the forums d-base table names, check for table pre-fix
                                        
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_mem', 
                                        'lang_txt_redirects')); // get lang difinitions...   
                break;
                
            case 'admin':
                require(awc_dir . 'admin.php');
                awcsforum_funcs::get_table_names(array('awc_f_cats',), true); // Get all the forums d-base table names, check for table pre-fix
                
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_admin', 
                                        'lang_txt_redirects')); // get lang difinitions...  
                break; 
                
            case 'pm':
                require(awc_dir . 'pm.php');
                awcsforum_funcs::get_table_names(array('awc_f_mems',)); // Get all the forums d-base table names, check for table pre-fix
                
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_mem')); // get lang difinitions...   
                break; 
                
                
            case 'mem_profile':
            case 'credits':
            case 'whoshere':
                require(awc_dir . 'misc.php');
                awcsforum_funcs::get_table_names(array('awc_f_langs',
                                        'awc_f_sessions',)); // Get all the forums d-base table names, check for table pre-fix							
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_mem')); // get lang difinitions...   
                break; 
                
                
                
             case 'mod':   
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search',
                                        'lang_txt_thread', 
                                        'lang_txt_redirects')); // get lang difinitions...     
                                        
                                                     
                break;                              
            
            case 'sc':
            case 'sf':
            case 'subf':
            default:
                require(awc_dir . 'forum.php');
                awcsforum_funcs::get_table_names(array('awc_f_cats',
                                        'awc_f_forums',
                						'awc_f_anns',
                						'awc_f_threads',)); // Get all the forums d-base table names, check for table pre-fix
                											
                awcsforum_funcs::get_page_lang(array('lang_txt_forum',
                                        'lang_txt_search')); // get lang difinitions...  
                
                break;
    }

    
    $awcs_forum_config->ver = isset($awcs_forum_config->cf_forumversion) ?  $awcs_forum_config->cf_forumversion : '2.x.x';
    $awcs_forum_config->ver = str_replace('.', '' , $awcs_forum_config->ver); 
    
    // need a check, some servers will drop the last zero from the version, version needs to be three digets
    #strlen($awc_ver) == 2 ? $awc_ver = $awc_ver . '0' : $awc_ver = $awc_ver ; 
    $awcs_forum_config->ver = !isset($awcs_forum_config->ver{2}) ? $awcs_forum_config->ver . '0' : $awcs_forum_config->ver ;
    $awc_ver = $awcs_forum_config->ver ;
    
    
    
    
     $info['url'] = awc_url ;
     
     
    // Need a check here for Admin Setting....
    if(isset($awcs_forum_config->cf_use_forum_stats) AND $awcs_forum_config->cf_use_forum_stats == '1' ){
        $ForumStat = new awcs_forum_stats();
        $ForumStat->get_stats();
    }
    
    
    // need to do something here....
    // PM check, display pop-up or not, set MemCP text for top menu
    if($awcUser->mId != '0'){
        
        $awcUser->get_mem_forum_options(); // set 
        
        
             if(isset($awcUser->m_pmunread)){
                $info['user_title'] = ($awcUser->m_pmunread == 0 || $awcUser->m_pmunread == '') ?  get_awcsforum_word('word_MemOpts') . '' : get_awcsforum_word('word_MemOpts') . ' <b>' . $awcUser->m_pmunread . '</b> ' . get_awcsforum_word('word_unreadpms');
                $pms = $awcUser->m_pmunread . ' ' . get_awcsforum_word('word_unreadpms');
             } else {
                $info['user_title'] = get_awcsforum_word('word_MemOpts');
                $pms = '';
                
             }
         
             $info['user_name'] = urlencode($awcUser->mName) . '/' . $awcUser->mId;
             
             $word['word_recent_posts'] = get_awcsforum_word('word_recent_posts');
             $word['word_gotomempc'] = get_awcsforum_word('word_gotomempc');
             $word['word_gotopms'] = get_awcsforum_word('word_gotopms');
             $word['word_gotosig'] = get_awcsforum_word('word_gotosig');
             $word['word_gotoavatar'] = get_awcsforum_word('word_gotoavatar');
             $word['word_subscribe_email'] = get_awcsforum_word('word_subscribe_email');
             $word['word_subscribe_memcp'] = get_awcsforum_word('word_subscribe_memcp');
             $word['word_threads'] = get_awcsforum_word('word_threads');
             $word['word_posts'] = get_awcsforum_word('word_posts');
             $word['word_MemClearIndicators'] = get_awcsforum_word('word_MemClearIndicators');
             
             $info['mem_links'] = $tplt->phase($word, $info, 'top_menu_user_links');
         
    } else {
        $pms = '';
        $mem_title  = null;
        $info['mem_links'] = null;
    }
    $tplt->kill('top_menu_user_links');
    
    
    

    
    $awcs_forum_config->get_css();   
        
    //$wgOut->addScript('<script type="text/javascript" src="'. awc_path . 'awc.js"></script>'); 
    $wgOut->mScripts.= '<script type="text/javascript" src="'. awc_path . 'awc.js"></script>'; 
    
    
    if((UserPerm == 10)){
        $word['word_AdminCP'] = get_awcsforum_word('word_AdminCP');
        $word['word_AdminCP'] = (strlen($word['word_AdminCP']) < 2) ? "Admin Control Panel" : $word['word_AdminCP'] ;
        $info['admin_link'] = $tplt->phase($word, '', 'top_menu_admin_link');
    } else {
        $info['admin_link'] = null;
    }
    $tplt->kill('top_menu_admin_link');
    
     
     if(CanSearch()) {
        $word['search'] = get_awcsforum_word('search_search');
        $info['search_link'] = $tplt->phase($word, '', 'top_menu_search_link');
     } else {
         $info['search_link'] = null;
     }
     $tplt->kill('top_menu_search_link');
     
     
     $word['word_todays_posts'] = get_awcsforum_word('word_todays_posts');
     $info['todays_posts'] = $tplt->phase($word, '', 'top_menu_todays_posts_link', true);
     
     
     $word['word_credits'] = get_awcsforum_word('word_credits');
     
     
     $top_menu_links = $tplt->phase($word, $info, 'top_menu_top', true);
     
     $wgOut->addHTML($top_menu_links);
     
        
        if($awcUser->mId != '0'){    
           if(isset($awcUser->m_pmpop) AND isset($awcUser->m_pmoptions['m_pmpop']) ){
                if($awcUser->m_pmpop == '1' AND $awcUser->m_pmoptions['m_pmpop'] == '1' AND $action_url['what_file'] != 'member_options'){
                    $wgOut->addHTML('<script type= "text/javascript">  alert("'.get_awcsforum_word('word_newpm').'"); </script>');
                }
           }
        }

        
       # $wgOut->addHTML('<hr>');
       global $wgSitename;
         $awcs_forum_config->forum_name = (!empty($awcs_forum_config->cf__forumname)) ?  str_replace('|$|', ' ' . $wgSitename . ' ', $awcs_forum_config->cf__forumname) :  $wgSitename . ' ' . get_awcsforum_word('word_forum');
         
         $awcs_forum_config->forum_subtitle = isset($awcs_forum_config->cf__forumsubtitle) ? $awcs_forum_config->cf__forumsubtitle : '';
         
       
        if ( !$awcUser->canRead AND $action_url['what_file'] != 'credits' ){
            global $wgSitename;
                $Tforum_name = str_replace('|$|', ' ' . $wgSitename . ' ', $awcs_forum_config->cf__forumname);
         
                Set_AWC_Forum_SubTitle($awcs_forum_config->forum_name, $awcs_forum_config->forum_name);
                
                $wgOut->loginToUse();
                
                get_awcsforum_word('word_standalongforumextension') == '' ? $awc_info = 'Stand Alone Forum Extension' : $awc_info = get_awcsforum_word('word_standalongforumextension');
                $wgOut->addHTML("\r". '<br /><hr><center> <a href="http://wiki.anotherwebcom.com" target="_blank" title="PHP, Visual Basic  scripts and programs">AWC\'s</a>: <b>'.$awcs_forum_config->cf_forumversion.'</b> MediaWiki - '.$awc_info.'</center>'."\r");
       
                return ;
         }
         
         # 
        switch( $action_url['what_file'] ) {
            
            case 'mod':
                require(awc_dir . 'includes/mod_post.php');
                awcs_forum_mod_options();
                break;
                
            case 'whoshere':
                //$WhoWhere = 'whoshere' ;
                $WhoWhere['type'] =  'forum' ;
                $WhoWhere['where'] =  'whoshere||awc-split||whoshere' ;
                
                $whoshere = new awcforum_misc();
                $whoshere->whoshere();
                break;
            
            case 'search':
                awcs_forum_search();
                #$search = new awcforum_search();
                #$search->enter_search($action);
                break;
            
                  
            case 'post':
                awcs_forum_post();
                #$post=new awcsforum_post_cls();
                #$post->enter_post($action);
                break;
                
            
            case 'st': 
            case 'sp':
            case 'last_post':
            case 'delete_post':
            case 'delete_thread':
                awcs_forum_threads($action);
                break;

        
            case 'member_options':
                awcs_forum_members($action);
                break;
                
                
            case 'admin':
                $admin = new awcforum_forumAdmin();
                $admin->enterAdmin($action);
                break;
                 
                
            case 'pm':
                $pm = new awcforum_pm();
                $pm->enter_pm($action);
                break; 
                
                
            case 'mem_profile':
            case 'credits':
                $pm = new awcforum_misc();
                $pm->enter_misc($action);
                break; 
                       
                         
            case 'feed':
            //awc_pdie($action_url);
                $title = str_replace('feed/', '', $action_url['all']);
                $rss = new FeedItem(
                            $title,
                            'Description',
                            awc_url . $title
                        );
                 awc_pdie($rss);       
                break;
                
            case 'sc':
            case 'sf':
            case 'subf':
            case 'fpw':
            default:
                awcs_forum_listing();
                break;
        }
        
        $awc_info = get_awcsforum_word('word_standalongforumextension') == '' ?  'Stand Alone Forum Extension' : get_awcsforum_word('word_standalongforumextension');

        

        // admin check needed
        if(isset($awcs_forum_config->cf_show_whoes_here) AND $awcs_forum_config->cf_show_whoes_here == '1'){
             
                $whos_here = new awcs_forum_whos_here();
                $whos_here->load_ses($action) ;
                             
                $word = array('word_forum_stats_whos_here' => get_awcsforum_word('word_forum_stats_whos_here'),
                                'members' => get_awcsforum_word('word_members'),
                                'guests' => get_awcsforum_word('word_guests'),
                                'word_forum_stats_bots' => get_awcsforum_word('word_forum_stats_bots'),
                                 );
                                 
                
                $info['names'] = substr($whos_here->whos_here['names'], 0, -2);
                $info['num_mems'] = $whos_here->whos_here['mems'];
                $info['num_guests'] = $whos_here->whos_here['guests'];
                $info['num_bots'] = $whos_here->whos_here['bots'];
                
                $footer_whoshere = $tplt->phase($word, $info, 'footer_whoshere', true);
                
                $wgOut->addHTML($footer_whoshere);
                unset($word, $info);
                
        }
        
        
        #require(awc_dir . 'dBase.php');
        #$dBase = new awcforum_cls_dBase();
        
        # die("done");

     /*  
        * top poster, replier, most posts in thread, most viewed thrread.
      */ 
        global $css_ver_info;
        if($css_ver_info != null)$css_ver_info = get_awcsforum_word('word_css_style_by') . " $css_ver_info";
        // Read the top please... http://google.com/search?q=Special:AWCforum will bring up your site sooner or later...
        $wgOut->addHTML('<br /><hr>
            <center>
                <a href="http://wiki.anotherwebcom.com" target="_blank" title="PHP, Visual Basic  scripts and programs">AWC\'s</a>:
                 <b>'.$awcs_forum_config->cf_forumversion.'</b> MediaWiki - '.$awc_info.'<br />'.$css_ver_info.'</center>');
       
       
       $wgOut->setRobotpolicy($awcs_forum_config->cf_setRobotpolicy);
       
       if(isset($ForumStat)) $ForumStat->doUpdate();   
       
       if($awcUser->mId != '0'){ 
            
           $now =  awcsforum_funcs::wikidate(wfTimestampNow()) ;
           
           if((isset($awcs_forum_config->cf_save_recent_in_dabase)) AND 
                            $awcs_forum_config->cf_save_recent_in_dabase == '1'){
               
             $dbw = wfGetDB( DB_MASTER );
             $dbw->update('awc_f_mems',
                        array('m_lasttouch'  => wfTimestampNow(),
                              'm_lasthere'  => $now,), 
                        array('m_id' => $awcUser->mId),
                        '');
           } else {
               
                global $wgCookieExpiration , $wgCookiePath, $wgCookieDomain;   
                 $exp = time() + $wgCookieExpiration; 
                 setcookie('awc_startTime', $now, $exp, $wgCookiePath, $wgCookieDomain );
           }
       }
       
 # $wgOut->setSubtitle( 'Time Test: ' .  processing_time($START) . ' Memory Peek= ' . memory_get_peak_usage(true) . ' memory_get_usage= ' . memory_get_usage()  ) ;  # testing
} 





function Set_AWC_Forum_BreadCrumbs($add, $send = false){
    
    static $b_crumbs;
    
        if(!isset($b_crumbs)){
          $b_crumbs = new awcs_forum_breadcrumbs();
        }
        
        if($add != '') $b_crumbs->add($add);
        
        if($send) return $b_crumbs->send();
        return ;
                  
}
    

function Set_AWC_Forum_SubTitle($title, $sub = '', $extra = ''){
global $wgOut, $tplt;

	#die($title);

    $title = strtr($title, "_", " ");
    $title = str_replace("&#039;", "'", $title);
    $title = awcsforum_funcs::awc_html_entity_decode($title);
    
    if($sub == '') $sub = ' &nbsp; ';
    $sub = awcsforum_funcs::awc_html_entity_decode($sub);
    //$sub = strtr($sub, "_", " "); // note - commented out on 3-23-09
    
     
     if (CanSearch() AND isset($extra) AND !empty($extra)){
        $info['url'] = awc_url ;
        
       # awc_pdie($extra);
        
        $info['hidden_tID'] = isset($extra['tID']) ? '<input name="tID" type="hidden" value="'.$extra['tID'].'">' : null ;
        $info['hidden_fID'] = isset($extra['fID']) ? '<input name="fID" type="hidden" value="'.$extra['fID'].'">' : null ;
        $info['hidden_cID'] = isset($extra['cID']) ? '<input name="cID" type="hidden" value="'.$extra['cID'].'">' : null ;
        
        $info['drop_cID'] = isset($extra['cID']) ? '<option value="c">'.get_awcsforum_word('search_whatCat').'</option>' : null ;
        $info['drop_fID'] = isset($extra['fID']) ? '<option value="f">'.get_awcsforum_word('search_whatForum').'</option>' : null ;
        $info['drop_tID'] = isset($extra['tID']) ? '<option value="t">'.get_awcsforum_word('search_whatThread').'</option>' : null ;
        
        #awc_pdie($info);
        
        $word['search_search'] = get_awcsforum_word('search_search');
        $word['search_whatAll'] = get_awcsforum_word('search_whatAll');
        
        $search = $tplt->phase($word, $info, 'top_search_box');
     }  else {
        $search = '' ;
     }
     $tplt->kill('top_search_box');
                 
    
    $wgOut->setPagetitle($title);
    $wgOut->setSubtitle( $search . $sub) ;
    
    
    wfRunHooks( 'awcsforum_before_addKeyword', array( &$title, &$sub ) );
        
    $wgOut->addKeyword($title . ' ' . $sub);
    
    unset($title, $search, $sub);      
}    

