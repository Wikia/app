<?php     
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
* @filepath /extensions/awc/forums/awc_forum.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

/** Current Forum Version */
define('awcs_forum_ver', '2.5.10');

/** Forum DIR */
define('awc_dir', dirname(__FILE__) . '/');

$awcExtensionPath = explode('/extensions/', awc_dir);

define('awcForumPath', '/extensions/' . $awcExtensionPath[1]);

/**
*   config.php holds settings for the forums poll, menu, forum and other tags and info
*/
include(awc_dir . 'config/config.php');

/**
* need to load the perm.php (permission file) all the time
* so the Group Permission show up in the Wiki Sysops 'User rights management'
* so Sysops can control members Groups for the forums.
*/
require(awc_dir . "config/perm.php");




if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
        $wgHooks['ParserFirstCallInit'][] = 'AWCforum';
} else {
        $wgExtensionFunctions[] = 'AWCforum';
}

$wgAutoloadClasses['AWCforum'] = awc_dir . 'SpecialPage.php';
$wgSpecialPages['AWCforum'] = 'AWCforum';

$wgExtensionMessagesFiles['AWCforum_menu'] = awc_dir.'languages/menu.i18n.php';
$wgExtensionMessagesFiles['AWCforum_whoes_here'] = awc_dir.'languages/whos_here.i18n.php'; 
$wgExtensionMessagesFiles['AWCforum_genral_forum'] = awc_dir.'languages/general.i18n.php';
$wgExtensionMessagesFiles['AWCforum_forum_tag'] = awc_dir.'languages/forum_tag.i18n.php';
$wgExtensionMessagesFiles['AWCforum_poll_tag'] = awc_dir.'languages/poll_tag.i18n.php';



require_once(awc_dir . "ajax.php");
            
//awcs_forum_wfLoadExtensionMessages( 'AWCforum_forum_tag' );
    
    /**
    *  Search dbase for members name name while PMing
    * 
    * @uses AjaxResponse
    * @since Version 2.5.8
    */
function awcs_pmMemberNameSearch1($name){
    
    
    $limit = 8; //number of results to spit back

    $response = new AjaxResponse();
    $dbr = wfGetDB( DB_SLAVE );
    
    $sql = "SELECT m_idname FROM ". $dbr->tableName('awc_f_mems')." WHERE  UPPER(m_idname)  LIKE '%".$dbr->strencode( strtoupper ($name)). "%' ORDER BY m_idname LIMIT 10";
           
    $res = $dbr->query($sql); 
     $r = "";   
    while ($row = $dbr->fetchObject( $res ) ){
        
       // $r .= '<li>' . $row->m_idname . "</li>\n";
        $r .=   "<a href='javascript:void(0);' onclick=\"javascript:SetPMname('".$row->m_idname."')\">" . $row->m_idname . "</a><br>";
 
    }
    $html ='<ul>' .$r .'</ul> <hr/>';
 
    return $r .'<hr/>';


}

define("NS_AWC_FORUM", 121707);
$wgExtraNamespaces[NS_AWC_FORUM] = "Forum";
$wgNamespacesToBeSearchedDefault[NS_AWC_FORUM] = true;
$wgContentNamespaces[] = NS_AWC_FORUM;
$wgDefaultUserOptions['searchNs'. NS_AWC_FORUM] = 1;



if(awcs_forum_nav_bar OR show_whos_here_in_WIKI OR awcs_forum_use_poll OR show_whos_use_wiki_tag){   
global $wgCachePages, $wgParserCacheType;
    $wgCachePages = false;
    $wgParserCacheType = false;
}



$wgHooks['ArticleViewHeader'][] = 'AWC_FORUMS_ArticleViewHeader';

function AWCforum() {
	global $wgHooks;
	
        $wgHooks['EditPage::showEditForm:fields'][] = 'AWC_FORUM_showEditForm';
        $wgHooks['ArticleSaveComplete'][] = 'AWC_FORUM_ArticleSaveComplete';
        $wgHooks['UserLogout'][] = 'AWC_FORUM_UserLogout';
        $wgHooks['BeforePageDisplay'][] = 'AWC_FORUMS_BeforePageDisplay_Menu_WhoesHere';

        
        if(!defined('awcsf_wiki_url')){
            global $wgServer, $wgArticlePath;
            define('awcsf_wiki_url', $wgServer . str_replace('$1', '', $wgArticlePath) );
            define('awc_url', awcsf_wiki_url . "Special:AWCforum/" );
        }
        
         if(awcs_forum_nav_bar){   
            global $wgEnableSidebarCache;
            // Menu will not update corrertly if this is anabled...
            $wgEnableSidebarCache = false;
         }
         
         
         global $wgParser;
         $wgParser->setHook( "forum_info", "awc_forum_display_info" );
         $wgParser->setHook( "forum_poll", "awc_forum_poll_display" );
    
    return true;
}

    /**
    *  Remove user from forums-session table
    * 
    * @since Version 2.5.x
    */
function AWC_FORUM_UserLogout(&$user){

    $dbw = wfGetDB( DB_MASTER );
    $awc_f_sessions = $dbw->tableName('awc_f_sessions');    
    $sql = "SELECT ses_id FROM $awc_f_sessions LIMIT 1";
        $dbw->ignoreErrors(true);
            if($res = $dbw->query($sql)){
                $dbw->delete( 'awc_f_sessions', array( 'ses_name' => $user->mName), '');
            } 
        $dbw->ignoreErrors(false);
        
    if(isset($_SESSION['awc_startTime'])) unset($_SESSION['awc_startTime']);
        
  return true;
}

    /**
    *  Check article for forum-form-input-fields
    *  Used when an article is edited from forum thread
    * 
    * @since Version 2.5.x
    */
function AWC_FORUM_ArticleSaveComplete(){
global $wgRequest, $wgTitle, $awc__url;

    $pID = $wgRequest->getVal('awc_redirect') ;
    $mem_namespace = $wgRequest->getVal('awc_mem_redirect') ;
    $wpStarttime = $wgRequest->getVal('wpStarttime') ;
   
   
    if($pID != '' && $wpStarttime != ''){
        
        if($mem_namespace){
             die(header('Location: ' . $awc__url . "mem_profile/" . $mem_namespace . '/' . $pID )); 
        }
                                     
        $dbr = wfGetDB( DB_SLAVE ); 
        $awc_f_posts = $dbr->tableName( 'awc_f_posts' );
        $res = $dbr->query("SELECT p.p_threadid, p.p_forumid FROM $awc_f_posts p WHERE p.p_id=$pID");
        $r = $dbr->fetchRow( $res );
            $tID = $r['p_threadid'];
           # $fID = $r['forum_id'];
        $dbr->freeResult( $res );
        
        
        die(header('Location: ' . $awc__url . "st/id" . $tID ));
        
    }
    
return true;

}

    /**
    *  Create forum-form-input-fields
    *  Used when an article is edited from forum thread
    * 
    * @uses AjaxResponse
    * @since Version 2.5.x
    */
function AWC_FORUM_showEditForm(&$q, &$out){
global $wgRequest;

   $out->addHTML("<input type='hidden' value='".$wgRequest->getVal('awc_redirect')."' name=\"awc_redirect\" />");
   $out->addHTML("<input type='hidden' value='".$wgRequest->getVal('awc_mem_redirect')."' name=\"awc_mem_redirect\" />");
   
    return true;
}



/**
* Trigged when Wiki displays a page
* Displays Forum Menu and Who's Here
* 
* @uses awcs_forum_user
* @uses awcs_forum_wfLoadExtensionMessages
* @uses awcs_forum_stats
* @uses get_stats
* @uses awcs_forums_whos_here_skin_wiki
* @uses doUpdate
* @todo find out why this is being called multi-times by other extensions... http://wiki.anotherwebcom.com/Special:AWCforum/sp/id4778
* 
*/
function AWC_FORUMS_BeforePageDisplay_Menu_WhoesHere(&$out) {        
global $awcsf_menu_whoeshere_beforepagedisplay ;

        // find out why this is being called multi-times by other extensions...
        // http://wiki.anotherwebcom.com/Special:AWCforum/sp/id4778
        if($awcsf_menu_whoeshere_beforepagedisplay == 'yes') return true ;
        $awcsf_menu_whoeshere_beforepagedisplay = 'yes';
        
        
        if(awcs_forum_nav_bar OR show_whos_here_in_WIKI){
            global $awcUser, $wgUser;
            
            require_once(awc_dir . "includes/gen_class.php");
            require_once(awc_dir . "includes/funcs.php");
            
            if(!isset($awcUser)) $awcUser = new awcs_forum_user();
        }
       
      if(awcs_forum_nav_bar){
          
          // <awc_forum_menu_tag>
          
         $current_sidebar = wfMsgForContent( 'sidebar' );  // get current wiki-nav
          
          
          awcs_forum_wfLoadExtensionMessages( 'AWCforum_menu' );
          $sidebar =  "\n* ".wfMsg('awcf_forum_menu')." \n"  ;
          
               if(!$wgUser->isLoggedIn()){
                   // Add Admin options here...
                   /** @todo make config or AdminCP options here */
                    $sidebar .=  "** Special:AWCforum|".wfMsg('awcf_forum')." \n\n"  ;
                    $sidebar .=  "** Special:AWCforum/search|".wfMsg('awcf_search')." \n\n"  ;
                    $sidebar .=  "** Special:AWCforum/search/todate|".wfMsg('awcf_todays_posts')." \n\n"  ;
               }else{
                   
                   /*
                    require_once(awc_dir . "includes/gen_class.php");
                    require_once(awc_dir . "includes/funcs.php");
                   
                    
                    global $awcUser;
                  // awc_pdie($awcUser);
                    if(!isset($awcUser)) $awcUser = new awcs_forum_user();
                    */
                    if(empty($awcUser) OR $awcUser->has_mem_info == false) {
						$awcUser->get_mem_forum_options(); // set 
					}
                   # die();
                       if(isset($awcUser->m_pmunread )){
                            $user_title = '('. $awcUser->m_pmunread . ')' ;  
                            
                                if(isset($awcUser->m_pmpop) AND isset($awcUser->m_pmoptions['m_pmpop']) ){
                                    if($awcUser->m_pmpop == '1' AND 
                                        $awcUser->m_pmoptions['m_pmpop'] == '1'){
                                       
                                       global $wgOut, $wgTitle;  
                                       if( $wgTitle->mDbkeyform!= 'AWCforum') $wgOut->addHTML('<script type= "text/javascript">  alert("'.wfMsg('awcf__newpm').'"); </script>');
                                    }
                                }
                            
                       } else {
                            $user_title = '0' ;
                       }
                       
                       
                       
                       $user_title .= ' ' . wfMsg('awcf_unreadpms'); 
                       
                       $mOps = (isset($awcUser->m_menu_options)) ? $awcUser->m_menu_options : null ;
                       if(!is_array($mOps) OR !isset($mOps) OR empty($mOps)){
                            $mOps['pms'] = true ;
                            $mOps['recent'] = true ; 
                            $mOps['mythreads'] = true ; 
                            $mOps['myposts'] = true ; 
                            $mOps['subemail'] = true ; 
                            $mOps['sublist'] = true ;
                            $mOps['search'] = true ; 
                            $mOps['today'] = true ; 
                            $mOps['forum'] = true ;
                       }
                       
                        if($mOps['forum']) $sidebar .=  "** Special:AWCforum|".wfMsg('awcf_forum')."\n"  ;
                        if($mOps['search']) $sidebar .=  "** Special:AWCforum/search|".wfMsg('awcf_search')."\n"  ;
                        if($mOps['today']) $sidebar .=  "** Special:AWCforum/search/todate|".wfMsg('awcf_todays_posts')."\n"  ;
                        if($mOps['pms']) $sidebar .=  "** Special:AWCforum/member_options/pminbox|".$user_title."\n"  ;
                        if($mOps['recent']) $sidebar .=  "** Special:AWCforum/search/recent|".wfMsg('awcf_recent')."\n"  ;
                        if($mOps['mythreads']) $sidebar .=  "** Special:AWCforum/search/memtopics/".$wgUser->mName."/".$awcUser->mId."|".wfMsg('awcf_my_threads')."\n"  ;
                        if($mOps['myposts']) $sidebar .=  "** Special:AWCforum/search/memposts/".$wgUser->mName."/".$awcUser->mId."|".wfMsg('awcf_my_posts')."\n"  ;
                        if($mOps['subemail']) $sidebar .=  "** Special:AWCforum/member_options/threadsubscribe_email|".wfMsg('awcf_sub_email')."\n"  ;
                        if($mOps['sublist']) $sidebar .=  "** Special:AWCforum/member_options/threadsubscribe_list|".wfMsg('awcf_sub_list')."\n"  ;
                        $sidebar .= "\n";

                       
                        
                        
               }
               
               
               if(strstr($current_sidebar, '<awc_forum_menu_tag>' )){
                    $sidebar = str_replace('<awc_forum_menu_tag>', $sidebar, $current_sidebar);
               }elseif(awcs_forum_nav_bar_top){
                    $sidebar = $sidebar . $current_sidebar;
               } else{     
                    $sidebar = $current_sidebar . $sidebar;
               }
               
               
               global $wgMessageCache;
               /** @todo work on site notice bug */
              //die(print_r($sidebar));  
              # $sitenotice = $wgMessageCache->mCache[awcs_forum_lang_default]['Sitenotice'];
              
              // http://wiki.anotherwebcom.com/Special:AWCforum/st/id1188
              $wgMessageCache->disable();
              $wgMessageCache->addMessages(array('sidebar' => $sidebar));
              //$wgMessageCache->enable();
    }
    
    
    if(show_whos_here_in_WIKI == false) return true;

    global $wgTitle;
    if($wgTitle->mDbkeyform == 'AWCforum'){
        return true;
    }
      
    awcs_forum_wfLoadExtensionMessages( 'AWCforum_whoes_here' );   
    
    global $WhoWhere, $ForumStat;

    //$WhoWhere = null;
     
    $WhoWhere['type'] =  'wiki' ;
    $WhoWhere['where'] = $wgTitle->mTextform ;
    
    if($wgTitle->mNamespace == '-1'){
            $WhoWhere['type'] =  'wiki' ;
            $WhoWhere['where']  = "Special:{$WhoWhere['where']}";
    }elseif($wgTitle->mNamespace != '0'){
            global $wgCanonicalNamespaceNames;
            $WhoWhere['type'] =  'wiki' ;
            $WhoWhere['where'] = $wgCanonicalNamespaceNames[$wgTitle->mNamespace] . ":{$WhoWhere['where']}";   
    }
    
    $awcUser->mName = $wgUser->mName ;
    $awcUser->mId = $wgUser->mId ;

    // require_once(awc_dir . "includes/gen_class.php");
    // require_once(awc_dir . "includes/funcs.php");
     
     
      // need this to update the MaxUsers at once
    if(!isset($ForumStat)){
        $ForumStat = new awcs_forum_stats();
        $ForumStat->get_stats();
    }
     $WhoWhere['type'] =  'wiki' ;
     $WhoWhere['where'] = $WhoWhere['where'] ;
     
   
    global $whos_here;
    if(!isset($whos_here)) $whos_here = new awcs_forum_whos_here();
    
    if(isset($whos_here->installed) AND $whos_here->installed == true){
        $whos_here->load_ses($WhoWhere);
        $out->mBodytext .= '<br /><br /><br />' . awcs_forums_whos_here_skin_wiki($whos_here->whos_here) ;
    }
    $ForumStat->doUpdate(); 
        
  return true;
}


function awcs_forums_whos_here_skin_wiki($info){
global $wgOut, $awcs_forum_config, $awcsf_wiki_css_set; 

            
            if($awcsf_wiki_css_set != 'yes'){
                
                    if(!isset($awcs_forum_config)){
                        $awcs_forum_config = new awcs_forum_config();  // gen_class.php
                        $awcs_forum_config->get_config();
                    }
                    
                    if(!isset($awcs_forum_config->cf_css_default) OR $awcs_forum_config->cf_css_default == '') return ;

           
                    $dbr = wfGetDB( DB_SLAVE );
                    $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' ); 
                    
                    /*
                    $res = $dbr->select( 'awc_f_theme_css', 
                                        array( 'css_code, css_att' ), 
                                        "css_thmn_id = {$awcs_forum_config->cf_css_default} AND css_att IN ('.whos_here_row', '.whos_here', '.whos_here_header', '.pagejumps_PostOnForumPage') OR css_section = 'css_poll'",
                                        array(__METHOD__),
                                        array('OFFSET' => 0 , 'LIMIT' => 25)
                                       );
                                       
                                      */
                    $sql = "SELECT css_code, css_att
                                FROM $awc_f_theme_css
                                WHERE css_thmn_id = $awcs_forum_config->cf_css_default AND
                                css_att IN ('.whos_here_row', '.whos_here', '.whos_here_header', '.pagejumps_PostOnForumPage') OR
                                css_section = 'css_poll' LIMIT 25";
                    # die();
                   //  awc_pdie($sql);           
                    $css = '<style type="text/css">';
                    $res = $dbr->query($sql);    
                    while ($r = $dbr->fetchObject( $res )) {
                        $css .= "$r->css_att {\n $r->css_code \n} \n";
                    }
                    $css .= "\n .nothing {font-size: 0%;
                                margin: .0em;
                                border: 0;
                                margin: 0;
                                padding: 0;
                                width: 0;}\n";
                    $css .= "</style>\n";
                 //   awc_pdie($css);
                    $wgOut->addScript($css);
                    
                    $awcsf_wiki_css_set = 'yes';
            }
   
        $names = $info['names'];
        $names = substr($names, 0, -2);
            
        $html = '<br /><table class="whos_here" width="100%" cellpadding="0" cellspacing="0">';
        $html .= '<tr>
                        <td width="100%" class="whos_here_header">
                        <a href="'.awc_url.'whoshere">'.wfMsg('word_forum_stats_whos_here').'</a>  
                        &nbsp; '. wfMsg('members') . ' ' . $info['mems'] . '
                        &nbsp; '. wfMsg('guests') . ' ' . $info['guests']. '
                        &nbsp; '.wfMsg('bots').'  ' .  $info['bots'] . '
                        </td>
         </tr>';
        
        $html .= '<tr>';
        $html .= '<td class="whos_here_row"> &nbsp;  '. $names .' </td>';
        $html .= '</tr>';
        
        $html .= '</table>';

      return $html ;
}

function awc_forum_poll_display($input, $argv ) {
     
static $forum_tag = null;

    if($forum_tag == null){
        require_once(awc_dir . 'includes/forum_tags.php');
    }
    
    $forum_tag = new awcs_forum_info_tag();
    $poll = $forum_tag->poll($input, $argv);
    #die($poll);
    return  $poll ;
     
}

function awc_forum_display_info($input, $argv ) {

static $forum_tag = null;

    if($forum_tag == null){
        require_once(awc_dir . 'includes/forum_tags.php');
    }
    
    $forum_tag = new awcs_forum_info_tag();
    return $forum_tag->forum_tag($input, $argv);
    

}

function AWC_FORUMS_POLL_DECODE_BeforePageDisplay(&$out) { 
    $out->mBodytext = preg_replace('/'."@POLL@".'([0-9a-zA-Z\\+\\/]+=*)'."@POLL@".'/e', 'base64_decode("$1")',  $out->mBodytext );   
  return true;
}

/**
 * 
 * Used for redirect of Search results, "Add post text to Wiki's dBase"...
 * @changeVer 2.5.8 Edited function call, removed ...
 */
function AWC_FORUMS_ArticleViewHeader(&$article){

    if($article->mTitle->mNamespace == NS_AWC_FORUM){
            global $wgServer, $wgArticlePath;
            $awcsf_wiki_url = $wgServer . str_replace('$1', '', $wgArticlePath);
           # die($awcsf_wiki_url . $article->mTitle->mUrlform);
            die(header('Location: ' . $awcsf_wiki_url . $article->mTitle->mUrlform ));
    }
    
    return true;
}





function awcs_forum_wfLoadExtensionMessages( $extensionName ) {
/* Idea taking form:
http://www.mediawiki.org/wiki/Extension_talk:Renameuser#Call_to_undefined_function_wfLoadExtensionMessages.28.29

	To make AWC's Forum Extension lang files compatable with old wiki vers...
*/

global $wgVersion;
  if(version_compare($wgVersion, '1.11.0', '>=')){
  		wfLoadExtensionMessages($extensionName);
  return true;	
  }


global $wgExtensionMessagesFiles;
global $wgMessageCache;

       require( $wgExtensionMessagesFiles[$extensionName]); # adapt the path if necessary
                foreach ( $messages as $lang => $langMessages ) {
                        $wgMessageCache->addMessages( $langMessages, $lang );
                }
        return true;

}


$wgExtensionCredits['specialpage'][] = array(
        'name' => 'AWC`s MediaWiki Forum',
        'version' => awcs_forum_ver ,
        'author' => 'Another Web Company',
        'url' => 'http://wiki.anotherwebcom.com/Category:AWC%27s_MediaWiki_Forum_Extension',
        'description' => 'Integrated Forum for your Wiki.'
);
