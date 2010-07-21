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
* @filepath /extensions/awc/forums/includes/gen_class.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

// error_reporting(0);


/**
* Forums Config cls
* 
* This class is called all the time to get forum settings for different reasons
* @package awcsForum
*/
class awcs_forum_config{
    
/**#@+
 * @since Version 2.5.8
 */    
    var $chrset;
    var $wikieits;
    var $lang;
    var $ver;
    var $name;  
    var $css_defaut;
    var $installed = false ;
    var $cf_threadsubscrip = 0;
    var $cf_forumsubscrip = 0;
    
    var $cf_wiki_titles = 0;
    var $cf_wiki_pages = 0;
    
    var $cfl_Thread_MaxTitleLength_LastPostCol = 100;
    var $cfl_Post_DisplayLimit = 25;
    var $cfl_PostPageBlockLimitThreadTitle = 5;
    var $cfl_ThreadTitleLength = 50;
    
    var $updating = true;   
 /**#@-*/    
    
        /**
        * __construct
        * 
        * Set 'installed' var to false apon loading of class <br />
        * Set to true later on in the self::get_config()
        * @since Version 2.5.8
        */
        function __construct(){
            $this->installed = false;
        }
        
        
        /**
        *  Try and load the awc_f_config table
        * 
        * If so, change the 'installed' var to TRUE <br/>
        * Do a forum version compairason also to see if forum files and forum dbase versions are the same, if not display Update Link.
        * 
        * @uses awcs_forum_skin_templetes
        * @since Version 2.5.8
        * 
        */
        function get_config(){
        global $wikieits, $awc_currnt_lang_setting, $awcUser_lang, $tplt, $awc_ver;
            
                $dbr = wfGetDB( DB_SLAVE );
                
                $dbr->ignoreErrors(true);
                
                $res = $dbr->select( 'awc_f_config', 
                                array( '*' ), '' , __METHOD__);
                                
                $dbr->ignoreErrors(false);
                
                # awc_pdie($this);
                
                if(isset($res) AND !empty($res)){
	                
	                	foreach($res as $r){
		                 	$this->{$r->q} =  $r->a ;    
		                }
		                
                        $this->installed = true ; 
                           
                         $this->ver = $this->cf_forumversion ;
                         define('awcs_forum_ver_current', $this->cf_forumversion);

                         $awc_ver = str_replace(".", '', $this->ver); // $awc_ver Used in checks els where
                         
                         $this->name = $this->cf__forumname ;
                         $this->css_default = isset($this->cf_css_default) ? $this->cf_css_default : null ;
                         
                         $wikieits = $this->wikieits;
                         
                         $chrset = isset($this->cf_chrset) ? $this->cf_chrset : 'iso-8859-1';
                         $chrset = ($chrset == '') ? 'iso-8859-1' : $chrset ;
                         if(!defined('awc_forum_charset')) define('awc_forum_charset', $chrset);
                         $this->cf_chrset = $chrset;
                         $this->chrset = $chrset;
                         # 'UTF-8'
                         # 'ISO-8859-1'
                         
                        # $awc_lang = $this->cf_forumlang ;
                         
                        $l = explode(',', $this->cf_forumlang );
                        $l = array_map('trim',$l);

                            if (in_array($awcUser_lang, $l)) {
                                $awc_currnt_lang_setting = $awcUser_lang ;
                            } else {
                                # default lang
                               $awc_currnt_lang_setting = awcs_forum_lang_default ;
                            }
                            
                        if(isset($this->cf_css_active_ids)){
                            $this->cf_css_active_ids = explode(',', $this->cf_css_active_ids);
                        }
                        
                        #$cf_css_default = unserialize($this->cf_css_default);
                       # $this->cf_css_default = $cf_css_default['Default'];
                        
                         
                         unset($r, $res, $chrset, $sql, $cf_css_default);
                         
                         if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '<')) return ;
                         
                         $this->updating = false;
                         
                         // call the forums skin temletes
                         $tplt = new awcs_forum_skin_templetes();
                         
                         $theme = unserialize($this->cf_default_forum_theme);
                         
                         $this->thmn_id = $theme['tplt'] ;
                         $tplt->thmn_id = $theme['tplt'] ;
                         $this->cf_css_default  = $theme['css'] ;
                         $this->cf_css_count  = $theme['css_count'] ;
                         $this->css_who  = $theme['who'] ;
                         $this->css_where  = $theme['where'] ;
                     
                } else {
	            	return false;
	            }

	            unset($dbr, $theme);
        
        }
        
        /** Display Install link
         * 
         * @since Version 2.5.8
         */
        function get_install(){
        global $awcUser, $wgRequest;
        
                            if ( !in_array('sysop', $awcUser->mGroups) ) {
                                return '<br />Need to be a Sysop to install AWC\'s Forum Extension<br>Login to your MediaWiki then try again.<hr>' ;
                            } else {
                                
                                if($wgRequest->action == "install_forum"){
                                    require(awc_dir . "updates/install/install_forum.php");
                                } else {
                                    return '<br /><a href="?title=Special:AWCforum&action=install_forum">Install Forum</a><hr>' ;
                                }
                            }
                            
        }
        
        
        /** Get CSS info 
        * 
        * @since Version 2.5.8
        */
        function get_css(){
        global $wgOut, $css_ver_info, $awcUser, $css_default_id, $awcsf_css_output; // $awcsf_css_output
        
                $css_ver_info = null;
                
            /*
                if($this->cf_css_mem_select == 1){
                    
                    if(isset($awcUser->m_forumoptions['css_id']) AND
                        !empty($awcUser->m_forumoptions['css_id']) AND
                        $awcUser->m_forumoptions['css_id'] != 0 AND
                        in_array($awcUser->m_forumoptions['css_id'], $this->cf_css_active_ids))
                        {
                            
                            $this->cf_css_default = $awcUser->m_forumoptions['css_id'];
                    }
                    
                }
                
               */
                
        
                $dbr = wfGetDB( DB_SLAVE );
                $dbr->ignoreErrors(true);
                
                $css_file = false ;
                // cf_css_mem_select cf_css_active_ids cf_css_fileorembed
                if($this->cf_css_fileorembed == 1){
                    $css_path = awc_dir . "skins/css/id{$this->cf_css_default}.css";
                    if ( file_exists( $css_path)){ 
                        
                        $awcsf_css_output =  '<link rel="stylesheet" type="text/css" href="'  . awc_path . 'skins/css/id'.$this->cf_css_default.'.css"/>'; 
                        
                        $wgOut->addScript($awcsf_css_output); 
                                                
                        $css_ver_info = "<a target='blank' href='{$this->css_where}'>{$this->css_who}</a>";
                        unset($dbr, $css_path);
                        return; 
                    }
                
                }
                
                // need some work in here, make more efficant...
                
                $sql = $dbr->selectSQLText( array( 'awc_f_theme_names','awc_f_theme_css' ), 
                   array( 'css_att, css_code, thmn_who, thmn_where, thmn_item_count' ), 
                   "css_thmn_id={$this->cf_css_default}", 
                   __METHOD__, 
                   array('OFFSET' => '0', 'LIMIT' => $this->cf_css_count),
                   array( 'awc_f_theme_names' => array('LEFT JOIN','thmn_id=' . $this->cf_css_default))
                    );
                
               if($res = $dbr->query($sql)){
               
                        $css_tmp = null;
                        while ($r = $dbr->fetchObject( $res )) {
                           
                            $thmn_who = $r->thmn_who;
                            $thmn_where = $r->thmn_where;
                            
                            $css_tmp .= "\n{$r->css_att} {\n{$r->css_code}\n}\n"  ;
                           # $temp = unserialize($r->css_name_info);
                         }
                         $dbr->freeResult( $res );
               
               
                         if($css_tmp == null){
                            
                            $awcsf_css_output = '<link rel="stylesheet" type="text/css" href="'  .  awc_path . 'awc.css"/>';
                            $wgOut->addScript($awcsf_css_output);
                            
                            $dbr->ignoreErrors(false);  
                            unset($dbr, $res, $r);                          
                            return;
                         } else {
                             
                            $css_ver_info = "<a target='blank' href='{$thmn_where}'>{$thmn_who}</a>";
                             
                            $css_out = '<style type="text/css">';
                            $css_out .= $css_tmp;
                            $css_out .= "\n</style>"; 
                            
                           // $awcsf_css_output = $css_out ;
                            
                            $wgOut->addScript($css_out);
                            
                            $dbr->ignoreErrors(false);
                            unset($dbr, $dbw, $res, $r, $css_out);
                            return;
                            
                         }
                         
               } else {
                  $awcsf_css_output = '<link rel="stylesheet" type="text/css" href="'  .  awc_path . 'awc.css"/>';
                  $wgOut->addScript($awcsf_css_output);
               }
               
               $dbr->ignoreErrors(false);
               unset($dbr, $dbw, $res);
               return;
        }
        
    
}


/** User Class, Called all the time
* 
* @since Version 2.5.8
*/
class awcs_forum_user{
/**#@+
 * @since Version 2.5.8
 */ 
    var $mId;
    var $mName, $mRealName, $nickname;
    var $mEmail;
    var $cols, $mOptions_cols;
    var $rows;
    var $language;
    var $timecorrection;
    var $mTouched;
    var $mGroups;
    var $mEditCount;
    var $isLoggedIn = 0;
    var $fancysig = 0;
    
    var $m_idname ;
    var $m_displaysigonce = 0 ;
    var $m_displaysig = 1 ;
    var $m_viewaadv = 0 ;
    var $m_posts ;
    var $m_topics ;
    var $m_pmunread ;
    var $m_pmoptions = array('m_pmautoquote' => '1', 'm_pmautosave' => '0', 'm_pmnewemail' => '1', 'm_pmpop' => '1');
    var $m_pmpop ;
    var $m_thread_subsrib = array();
    var $m_forum_subsrib = array();
    var $m_lasthere ;
    var $m_lasttouch ;
    var $m_where ;
    var $m_forumoptions = array('cf_extrawikitoolbox' => '1', 'cf_FCKeditor' => '0', 'mem_showAdv' => '1', 'mem_showsigs' => '1', 'mem_showsigsonlyonce' => '1', 'cf_displaysmiles' => '1');
    var $guest = true ;
    var $css_id ;
    

    var $canPost = true ;
    var $canRead = true ;
    var $canEdit = true ;
    var $canDelete = false ;
    var $canSearch = true;
    var $canSig = true;
    
    var $isMod = false;
    var $isAd0min = false;
    
    var $has_mem_info = false;
/**#@-*/ 

        /** User Class, Called all the time
        * 
        * @staticvar 
        * @uses ModYes
        * @uses AdminYes
        * @uses get_awcsforum_word
        * @uses GetUserPermission
        * @since Version 2.5.8
        */
        function __construct(){
        global $wgUser, $awcUser_lang;
        
        static $here_already = null ;
        
                if($here_already == 'yes') return ;
                $here_already = 'yes';
        
                define('UserPerm', awcsforum_funcs::GetUserPermission($wgUser));
                
                
                $this->mId = $wgUser->mId;
                $this->mName = $wgUser->mName;
                if($this->mName == " ") $this->mName = wfGetIP();
                $this->mRealName = $wgUser->mRealName;
                $this->mEmail = $wgUser->mEmail;
                $this->mTouched = $wgUser->mTouched;   
                $this->cols = $wgUser->mOptions['cols'];
                $this->mOptions_cols = $wgUser->mOptions['cols'];
                $this->rows = $wgUser->mOptions['rows'];
                             
                $this->language = $wgUser->mOptions['language'];
                if(strlen($this->language) == 0) $this->language = awcs_forum_lang_default ;
                $awcUser_lang = $this->language ;
                
               // awc_pdie($this->language);
                 
                $this->nickname = isset($wgUser->mOptions['nickname']) ? $wgUser->mOptions['nickname'] : null;
                $this->timecorrection = isset($wgUser->mOptions['timecorrection']) ? $wgUser->mOptions['timecorrection'] : null;
                $this->mTouched = $wgUser->mTouched;
                $this->mGroups = $wgUser->mGroups;
                $this->mEditCount = isset($wgUser->mOptions['mEditCount']) ? $wgUser->mEditCount : null ;
                
                $this->fancysig = isset($wgUser->fancysig) ? $wgUser->fancysig : null ;
                
                $this->riched_disable = isset($wgUser->mOptions['riched_disable']) ? $wgUser->mOptions['riched_disable'] : 1 ;
                $this->edit_count = isset($wgUser->mEditCount) ? $wgUser->mEditCount : null ; ;
                
                
                
                $this->canRead = ($wgUser->isAllowed("awc_CanNotView")) ? false : true ;
                
                $this->canPost = ($wgUser->isAllowed("awc_CanNotPost")) ? false : true ;
                
                $this->canDelete = ($wgUser->isAllowed("awc_CanNotDelete")) ? false : ($wgUser->isAllowed("awc_CanDelete")) ? true : false;
                
                $this->canEdit = ($wgUser->isAllowed("awc_CanNotEdit")) ? false : ($wgUser->isAllowed("awc_CanEdit")) ? true : false;
                
                $this->canSearch = ($wgUser->isAllowed("awc_CanNotSearch")) ? false : ($wgUser->isAllowed("awc_CanSearch")) ? true : false;
                
                foreach($wgUser->mGroups as $groupis){
                    
                    switch($groupis){
                        case 'Forum:Mod':
                            self::ModYes();
                            $wgUser->mEffectiveGroups[] = '*'; // used for cat & forums perm...
                            $wgUser->mEffectiveGroups[] = 'user'; // used for cat & forums perm...
                        break;
                        
                        case 'Forum:Admin':
                            self::AdminYes();
							$wgUser->mEffectiveGroups[] = '*'; // used for cat & forums perm...
                            $wgUser->mEffectiveGroups[] = 'user'; // used for cat & forums perm...
                            $wgUser->mEffectiveGroups[] = 'Forum:Mod'; // used for cat & forums perm...
                        break;
                        
                        case 'bureaucrat':
                        case 'sysop':
                            $wgUser->mEffectiveGroups[] = 'Forum:Admin'; // used for cat & forums perm...
                            $wgUser->mEffectiveGroups[] = 'Forum:Mod'; // used for cat & forums perm...
							$wgUser->mEffectiveGroups[] = '*'; // used for cat & forums perm...
                            $wgUser->mEffectiveGroups[] = 'user'; // used for cat & forums perm...
                            self::AdminYes();
                        break;
                    
                    }
                
                }
                
                $wgUser->mEffectiveGroups = array_unique($wgUser->mEffectiveGroups); // poor.. poor... poor...
                
                define('UserGroupPerm', implode(',', $wgUser->mEffectiveGroups));
                
                
                if(empty($wgUser->mGroups)){
                   $this->group = get_awcsforum_word('word_mem');
                } else {
                    // find out how to get group names in different languages
                    $this->group = implode(',', $wgUser->mGroups);
                }
                
                $this->isLoggedIn = $wgUser->isLoggedIn();
                
                $this->pw = array();
                #if($this->isLoggedIn == 1){
                	if(isset($_SESSION['forumPW'])){
                		$ids = explode(',', $_SESSION['forumPW']);
                		foreach($ids as $id){
                			$this->pw[$id] = $id;
                		}
                		#die();
                	}
                #} else {
                	#$this->pw[0] = 0;
                #}
                #awc_pdie($_SESSION);
               // $this->canPost = 
                
                
                
                
                
                
                
        }
        
        /** Sets Moderator privileges
        * 
        * @since Version 2.5.8
        */        
        function ModYes(){
             $this->canPost = true ;
             $this->canSearch = true ;
             $this->canSig = true ;
             $this->canRead = true ;
             $this->canEdit = true ;
             $this->canDelete = true ;
             $this->isMod = true;
        }
        
        /** Sets Admins privileges
        * 
        * @since Version 2.5.8
        */ 
        function AdminYes(){
            $this->isAdmin = true;
            self::ModYes();
        }
        
        /** Gets Members forum options
        * 
        * @uses GetMemInfo
        * @uses get_mem_forum_options
        * @uses clear_session
        * @uses set_session
        * @since Version 2.5.8 
        */ 
        function get_mem_forum_options($where = ''){
          global $awc_ver;
          
          $this->has_mem_info = true;
          
                if($this->mId != '0'){
                     
                    $this->guest = false;
                     
                     $user = array();
                     $user_get = array();
                     
                     $user_get[] = 'm_idname';
                     $user_get[] = 'm_displaysigonce';
                     $user_get[] = 'm_displaysig';
                     $user_get[] = 'm_viewaadv';
                     $user_get[] = 'm_posts';
                     $user_get[] = 'm_topics';
                     
                                   
                                   
                    if(version_compare(awcs_forum_ver, '2.5.3', '>=')){ // need a check for this  
                        $user_get[] = 'm_pmunread';  // .2.5.2
                        $user_get[] = 'm_pmoptions';
                        $user_get[] = 'm_pmpop'; 
                        $user_get[] = 'm_thread_subsrib';
                        $user_get[] = 'm_forum_subsrib';
                        
                        $user_get[] = 'm_lasthere';
                        $user_get[] = 'm_lasttouch';
                        $user_get[] = 'm_where';
                        $user_get[] = 'm_forumoptions';
                        $user_get[] = 'm_menu_options';
                    }
                    
                    
                     $user = GetMemInfo($this->mId, $user_get, false);
                    
                     if($user == 'error'){
						 return;
					 }
					
                      if($user['name'] == ''){
                        #  die($this->mName);
                            /** @changeVer 2.5.8 - Added default PM options for new members*/
                            $dbw = wfGetDB( DB_MASTER );
                            $dbw->insert('awc_f_mems', array(
                                'm_idname'        => $this->mName,
                                'm_id'        => $this->mId,
                                'm_forumoptions'        => serialize($this->m_forumoptions),
                                'm_pmoptions'        => serialize($this->m_pmoptions),
                            ) );
                           
                           $m_id = awcsforum_funcs::lastID($dbw, 'awc_f_mems', 'm_id');
                           wfRunHooks( 'awcsforum_memAddedToDbase', array($m_id, $this) ); // added 2.5.8
                           
                            
                           $sql = $dbw->selectSQLText( array( 'awc_f_stats' ), 
									                   array( '*' ), '', __METHOD__, 
									                   array('OFFSET' => '0', 'LIMIT' => '1'));
                  
                           # $awc_f_stats = $dbw->tableName('awc_f_stats');
                           # $sql = "SELECT * FROM $awc_f_stats LIMIT 1";
                            $dbw->ignoreErrors(true);
                            if($res = $dbw->query($sql)){
                                
                                $r = $dbw->fetchRow( $res );
                                
                                $stats_id = $r['stats_id'];
                                $stat_mems = ($r['stat_mems'] + 1);
                                
                                $dbw->freeResult( $res );
                                unset($r);
                                
                                $dbw->update( 'awc_f_stats',
                                    array('stat_mems' => $stat_mems , ), 
                                    array('stats_id' => $stats_id), '' );
                            
                            }
                            $dbw->ignoreErrors(false);
                                        
                                            
                            unset($m_forumoptions, $dbw, $res);
                            
                            
                          self::get_mem_forum_options();
                      }
                      
                      
                     foreach($user as $u => $v){
                            $this->$u = $v ;
                     }  
                     unset($user, $user_get);  
                     
                       if((!isset($awcs_forum_config->cf_save_recent_in_dabase)) OR 
                            $awcs_forum_config->cf_save_recent_in_dabase == '0'){
                            // $this->m_lasthere - has already been set from dbase info, this will set for cookie info...
                            $this->m_lasthere = isset($_COOKIE["awc_startTime"]) ? $_COOKIE["awc_startTime"] : awcsforum_funcs::wikidate(wfTimestampNow()) ;  
                       }
                           
                           
					//  awc_pdie($this);
                    // $awcstart = isset($_SESSION['awc_startTime']) ?  $_SESSION['awc_startTime'] :  null;
					if(!isset($_SESSION['awc_startTime']) OR empty($_SESSION['awc_startTime'])){
						 awcsforum_funcs::clear_session();
						 awcsforum_funcs::set_session($this->m_lasthere);         
					}
                        
                        
                        
                }
            
          }
        
        

}


/** Who's here Class
* 
* @staticvar $whosHere_static = array() 
* @since Version 2.5.8
*/
class awcs_forum_whos_here{
# http://www.mediawiki.org/wiki/Manual:Hooks/UserLogoutComplete

/**#@+
 * @since Version 2.5.8
 */    
    var $who;
    var $whoID;
    var $where, $type;
    var $when;
    var $perm;
    var $guest;
    var $bot = 0;
    var $whos_here = array('mems' => 0, 'guests' => 0, 'bots' => 0, 'bot_names' => null, 'names' => null);
    var $installed = false;
        
    var $awc_whos_here = array();
    
    //private $awc_whos_here = array();
    private $ses_table;
    private $cut_off = 0;
    private $browser;
    private $user_ip;
    
/**#@-*/ 
    
    static $whosHere_static = array();
        
        /** __construct
        * 
        * @since Version 2.5.8
        */
        function __construct(){
        global  $WhoWhere, $wgUser, $AlreadyHere;  // use $wgUser and not $awcUser, whoes_here is called from wiki so $awcUser is missing sometimes
        	
        	static $AlreadyHere = null;
        
            if($AlreadyHere == 'yes') {
                // double check...
                $this->awc_whos_here = $whosHere_static;
             return;
            }
            
            $AlreadyHere = 'yes';
                                                                                               
            $this->when = time() ;
            $this->cut_off = ($this->when - 1800);
            
             $this->who = $wgUser->mName;
             $this->whoID = $wgUser->mId;
             
             $this->where = $WhoWhere['where']  ;
             $this->type = $WhoWhere['type']  ;
             $this->perm = (isset($WhoWhere['perm'])) ? $WhoWhere['perm'] : '*' ;
             
             
            $wDB = wfGetDB( DB_MASTER );
            $this->ses_table = $wDB->tableName('awc_f_sessions');
            
            //$wDB->begin();               
        
            
            $wDB->ignoreErrors(true);
            $sql = "DELETE FROM {$this->ses_table} WHERE ses_when <= {$this->cut_off}";
            if($wDB->query($sql)){
                $this->installed = true;
                $wDB->ignoreErrors(false);
            } else {
                $wDB->ignoreErrors(false);
                //$wDB->commit();
                return ;
            }
            
            
            // $this->when = $awcUser->mId;
            
             $this->browser = $_SERVER['HTTP_USER_AGENT'];
            
             $this->guest = ($this->whoID == '0') ? '1' : '0';
             
             
            if($this->browser == '' ||  strstr($this->browser,'bot') || strstr($this->browser,'http://')) {
                $this->bot = 1;      
            }
            
            global $wgVersion;
            if(version_compare($wgVersion, '1.10.0', '<')){
                global $IP;
                require_once($IP . '/includes/ProxyTools.php');
                $this->user_ip = wfGetIP();
            } else {
                $this->user_ip = IP::sanitizeIP( wfGetIP() );
            }
            
            unset($wDB, $sql);
            
        }
        
       /** Load sessions
        * @uses check_ses
        * @uses display_ses
        * @since Version 2.5.8
        */
        function load_ses(){
        global $ForumStat, $action_url, $AlreadyHere;
        
            if($AlreadyHere == 'yes') return;
            
           // return ;
            if(self::get_ses() === false) return false;
            
            $whosHere_static = $this->awc_whos_here ;
            
            self::check_ses();
            
            self::display_ses();
            
          //  awc_pdie($this->awc_whos_here);
            
        }
        
        
        /** Pull sessions from ses_table table
        * @uses add_ses
        * @return boolean
        * @since Version 2.5.8
        */
        function get_ses(){
        
            $rDB = wfGetDB( DB_SLAVE );
            $rDB->ignoreErrors(true);
            //if(version_compare(awcs_forum_ver, awcs_forum_ver_current, '<')){
                $awc_whos_here = array();
                $sql = "SELECT ses_name, ses_where, ses_guest, ses_bot, ses_perm, ses_type, ses_when FROM {$this->ses_table} WHERE ses_when >= {$this->cut_off} ORDER BY ses_when DESC";
                
                if($res = $rDB->query($sql)){
                $rDB->ignoreErrors(false);
                   
                        while ($r = $rDB->fetchObject( $res )) {
                            $this->awc_whos_here[$r->ses_name] = array('who' => $r->ses_name, 
                                                                   // 'where' => str_replace('(viewing_wiki_site)', '', $r->ses_where), 
                                                                    'where' => $r->ses_where, 
                                                                    'guest' =>  $r->ses_guest, 
                                                                    'when' =>  $r->ses_when, 
                                                                    'perm' =>  $r->ses_perm, 
                                                                    'bot' =>  $r->ses_bot,) ;
                        }
                       $rDB->freeResult( $res );
                       
                       unset($rDB, $res, $r); 
                       if(empty($this->awc_whos_here)) self::add_ses();
                       return true;
                        
                } else { 
                       $rDB->ignoreErrors(false);
                       unset($rDB);
                        return false;
                }
        
        }
        
        /** Add new session info
        * @since Version 2.5.8
        */
        function add_ses(){
            
            $wDB = wfGetDB( DB_MASTER ); 
            
           // $wDB->query("DELETE FROM $this->ses_table WHERE ses_name = '$this->user_ip'");
                                        
            $wDB->insert( 'awc_f_sessions',  
                    array('ses_name' => $this->who,
                            'ses_when'  => $this->when,
                            'ses_id'  => $this->whoID,
                            'ses_guest'  => $this->guest,
                            'ses_browser'  => $this->browser,
                            'ses_bot'  => $this->bot,
                            'ses_where'  => $this->where,
                            'ses_type'  => $this->type,
                            'ses_perm'  => $this->perm, ) );
            
            
            unset($wDB); 
                            
           // $c = count($this->awc_whos_here) ;
            $this->awc_whos_here[$this->who]['who'] = $this->who;
            $this->awc_whos_here[$this->who]['when'] = $this->when;
            $this->awc_whos_here[$this->who]['where'] = $this->where;
            $this->awc_whos_here[$this->who]['type'] = $this->type;
            $this->awc_whos_here[$this->who]['guest'] = $this->guest;
            $this->awc_whos_here[$this->who]['bot'] = $this->bot;
            $this->awc_whos_here[$this->who]['perm'] = $this->perm;
            
        }
        
        /** Check session, update to add new
        * @uses update_ses
        * @uses add_ses
        * @since Version 2.5.8
        */
        function check_ses(){
        
            
            $checked = false;
            
                foreach($this->awc_whos_here as $id => $ses){
                    
                    
                        if($id == $this->who){
                                self::update_ses();
                                $this->awc_whos_here[$id]['when'] = $this->when;
                                $this->awc_whos_here[$id]['where'] = $this->where;
                                $this->awc_whos_here[$id]['type'] = $this->type;
                                $this->awc_whos_here[$id]['perm'] = $this->perm;
                                $checked = true;
                                break ;
                    }
                    
                }
                
                if(!$checked)self::add_ses();
                
        }
        
        /** Update session
        * @since Version 2.5.8
        */
        function update_ses(){
          
        	$wDB = wfGetDB( DB_MASTER );
            if(isset($this->awc_whos_here[$this->user_ip]) AND !User::isIP($this->who)){
                $wDB->query("DELETE FROM $this->ses_table WHERE ses_name = '$this->user_ip'");
            }
                                    
            $wDB->update( 'awc_f_sessions',
                            array('ses_when' => $this->when, 'ses_where' => $this->where,'ses_type' => $this->type,'ses_perm' => $this->perm,), 
                            array('ses_name' => $this->who), '' );
            unset($wDB);          

        }
        
        /** Display Who's Here
        * @since Version 2.5.8
        */
        function display_ses(){
        global $action_url, $wgTitle, $ForumStat;
        
                
                $current_page = array();
                $current_page[0] = str_replace('_', ' ', $wgTitle->mPrefixedText);
                
                
                
                $current_page[0] = $wgTitle->mTextform ;
                if($wgTitle->mNamespace == '-1'){
                        $current_page[0] = "Special:{$current_page[0]}";
                }elseif($wgTitle->mNamespace != '0'){
                        global $wgCanonicalNamespaceNames;
                        $current_page[0] = $wgCanonicalNamespaceNames[$wgTitle->mNamespace] . ":{$current_page[0]}";   
                }
    
                if($current_page[0] != 'Special:AWCforum') $action_url['all'] = $current_page[0];
                 
               # die($action_url['all']);
              //awc_pdie($this->awc_whos_here);
                if($action_url['all'] == '' || $action_url['all'] == '/' || $action_url['all'] == 'Main Page'){
                

                        foreach($this->awc_whos_here as $name => $info){
                            
                            if($info['guest'] == '0') {
                                
                                $this->whos_here['names'] .= $info['who'] . ', ';
                                ++$this->whos_here['mems'];
                            
                            } elseif($info['bot'] == '1' ) {
                                  
                                  ++$this->whos_here['bots'];
                            
                            } else {
                                
                                ++$this->whos_here['guests'];
                            }
                            
                        }
                       
                
            } else {
            
              $action_replace = str_replace('sf/id', 'fid', $action_url['all']);
              $action_replace = str_replace('sc/id', 'cid', $action_replace);
              $action_replace = str_replace('st/id', 'tid', $action_replace);
              
              $temp_split = explode('/',$action_replace);
              $action_replace =  $temp_split[0];
              //  die($action_replace);
              foreach($this->awc_whos_here as $id => $info){
              
                          if(!isset($info['type'])){
                              $info['type'] = 'forum';
                          }
                      
                          if($this->where == $info['where'] and strstr($action_replace,'tid') ){
                          
                                    if($info['guest'] == '0') {
                                        
                                        $this->whos_here['names'] .= $info['who'] . ', ';
                                        ++$this->whos_here['mems'];
                                        
                                    } elseif($info['bot'] == '1') {
                                    
                                      ++$this->whos_here['bots'];
                                    
                                    } else {
                                        
                                      ++$this->whos_here['guests'];
                                    }
                                    
                          
                          }
                          
                          if(strstr($action_replace,'fid') and  strstr($info['where'],$action_replace)){
                          
                                    if($info['guest'] == '0') {
                                        
                                        $this->whos_here['names'] .= $info['who'] . ', ';
                                        ++$this->whos_here['mems'];
                                        
                                    } elseif($info['bot'] == '1') {
                                    
                                        ++$this->whos_here['bots'];
                                    
                                    } else {
                                        
                                        ++$this->whos_here['guests'];
                                    }
                          
                          }
                          
                        //  awc_pdie($info['where']);
                          
                          if(strstr($action_replace,'cid') and  strstr($info['where'],$action_replace)){
                          
                                    if($info['guest'] == '0') {
                                        
                                        $this->whos_here['names'] .= $info['who'] . ', ';
                                        ++$this->whos_here['mems'];
                                        
                                    } elseif($info['bot'] == '1') {
                                    
                                        ++$this->whos_here['bots'];
                                    
                                    } else {
                                        
                                        ++$this->whos_here['guests'];
                                    }
                          
                          }
                          
                          
                          #die($info['where']);
                          if($info['type'] == 'wiki' AND $this->where == $info['where']){
                          
                                    if($info['guest'] == '0') {
                                        $this->whos_here['names'] .= $info['who'] . ', ';
                                        ++$this->whos_here['mems'];
                                    } elseif($info['bot'] == '1') {
                                        ++$this->whos_here['bots'];
                                    } else {
                                        ++$this->whos_here['guests'];
                                    }
                          
                          }
                      
                  }
                  
                
            }
                
               if($this->whos_here['mems'] + $this->whos_here['bots'] + $this->whos_here['guests'] == 0){
                   // $this->whos_here['names'] = ' qq';
               }
               
               $stat_maxusers = ((int)$this->whos_here['guests'] + (int)$this->whos_here['mems'] + (int)$this->whos_here['bots']);
               
               if(isset($ForumStat)){
                   if((int)$ForumStat->stat_maxusers < (int)$stat_maxusers){
                        $ForumStat->stat_maxusers(1);
                   }
               }
               
               
               unset($awc_whos_here, $whos_here, $awc_f_sessions);
               
                return ;
        }
        
}

/** Forum Stats Class
* @since Version 2.5.8
*/
class awcs_forum_stats{
/**#@+
 * @since Version 2.5.8
 */     
    var $stats_id;
    var $stat_mems;
    var $stat_threads;
    var $stat_posts;
    var $stat_maxusers; 
    
    var $update = false; 
/**#@-*/ 
    
        /** Get stats
        * @since Version 2.5.8
        */
        function get_stats(){
            
                $dbr = wfGetDB( DB_SLAVE );
                
                $dbr->ignoreErrors(true);
                
                $r = $dbr->selectRow( 'awc_f_stats', 
                                array( '*' ), '' , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1));
                                
                $dbr->ignoreErrors(false);
                                
                if(isset($r) and !empty($r)){
                	
                    $this->stats_id = $r->stats_id;
                    $this->stat_mems = $r->stat_mems;
                    $this->stat_threads = $r->stat_threads;
                    $this->stat_posts = $r->stat_posts;
                    $this->stat_maxusers = $r->stat_maxusers;
                    unset($r);
                }
 
                unset($dbr, $r, $sql, $res);
        }
        
        
        /** Trigger and Set 'Update' = TRUE
        * @since Version 2.5.8
        */
        function update(){
            $this->update = true;
        }
        
        function stat_threads($math){
            if($math){
             ++$this->stat_threads;
            } else {
                $this->stat_threads = ($this->stat_threads -1);
            }
            self::update();
        }
        
        /** Add or Subtract total posts
        * @since Version 2.5.8
        */
        function stat_posts($math){
            if($math){
             ++$this->stat_posts;
            } else {
                $this->stat_posts = ($this->stat_posts -1);
            }
            self::update();
        }
        
        /** Add or Subtract total Users
        * @since Version 2.5.8
        */
        function stat_maxusers($math){
            if($math){
             ++$this->stat_maxusers;
            } else {
                $this->stat_maxusers = ($this->stat_maxusers -1);
            }
            self::update();
        }
        
        /** Add or Subtract current members
        * @since Version 2.5.8
        */
        function Set_stat_mems($math){
            if($math){
             ++$this->stat_mems;
            } else {
                $this->stat_mems = ($this->stat_mems -1);
            }
            self::update();
        }
        
        /** Exicute stats update
        * @since Version 2.5.8
        */
        function doUpdate(){
            
                if($this->update){
                    
                    $dbw = wfGetDB( DB_MASTER );
                    $dbw->update( 'awc_f_stats',
                            array('stat_maxusers' => $this->stat_maxusers , 
                                    'stat_mems' => $this->stat_mems, 
                                    'stat_posts' => $this->stat_posts, 
                                    'stat_threads' => $this->stat_threads,), 
                            array('stats_id' => $this->stats_id), '' );
                    unset($dbw);
                }
            
        }
        
        

}


class awcs_forum_skin_templetes{
/**#@+
 * @since Version 2.5.8
 */ 
    var $get_tplt = array();
    var $tplts = array();
    var $thmn_id ;
/**#@-*/ 

    // make a simple skin file for the update procces since there will no longer be any skin files
    
    function get_tplts_html(){
    global $css_default_id; 
      
        $dbr = wfGetDB( DB_SLAVE );
        
        $limit = count($this->get_tplt) + 1;
        $where = implode(',', $this->get_tplt);      
        
        
        if($where == ''){
        	unset($dbr, $res, $limit, $where, $this->get_tplt);
        	return;
        }
        
        $res = $dbr->select( 'awc_f_theme_tplt', 
                            array( 'tplt_function, tplt_code' ), 
                             "tplt_thmn_id=$this->thmn_id AND tplt_function IN ({$where})",
                             array(__METHOD__),
                             array('OFFSET' => 0 , 'LIMIT' => $limit) );
                             

        if(isset($res) AND !empty($res)){
        	
        	foreach($res as $r){
        		$template = $r->tplt_code;
        		$this->tplts[$r->tplt_function] = $template;
        	}
        	
        }
          
        unset($dbr, $res, $limit, $where, $this->get_tplt);
        $this->get_tplt = array();
        
    }
    
    
    function add_tplts($tplts, $get_tplt_from_db = false){
      
	      if(isset($this->get_tplt) and !empty($this->get_tplt)){
	      		$this->get_tplt = array_merge($tplts, $this->get_tplt);
	      } else{
	      		$this->get_tplt = $tplts;
	      }
	        
	      if($get_tplt_from_db) $this->get_tplts_html();
      
    }
    
    
    function phase($word, $info, $template, $kill = false){
    global $awc_url, $wiki_url, $style_path, $button_path;
         
        $temp = $this->tplts[$template];
                
        $awc_links = array($awc_url, $wiki_url, $style_path, $button_path);
        $links = array('{$awc_url}', '{$wiki_url}', '{$style_path}', '{$button_path}');
        
        $temp = str_replace($links, $awc_links, $temp);

            
        if(!empty($word)){
            foreach($word as $k => $w){
                $temp = str_replace('$word['.$k.']', $w, $temp);
            }
        }
        
        
        if(!empty($info)){
            foreach($info as $k => $w){
                $temp = str_replace('$info['.$k.']', $w, $temp);
            }
        }
        
        unset($word, $info);
        if($kill) unset($this->tplts[$template]);
        
        return $temp;
    }
    
    
    function kill($kill){
        unset($this->tplts[$kill]);
    }
    
    
    

}


class awcs_forum_breadcrumbs{
/**#@+
 * @since Version 2.5.8
 */ 
    //var $home_page;
    //var $spliter;
    var $links = array();
/**#@-*/ 

    
    function __construct(){
        //$this->spliter = get_awcsforum_word('1indicator_main_bread_crumb') ;
        //$this->home_page = '<a href="'. awc_url .'">'. get_awcsforum_word('word_forum') . '</a>';
        self::add('<a href="'. awc_url .'">'. get_awcsforum_word('word_forum') . '</a>');
    }
    
    function add($add){
        array_push($this->links, $add);
    }
    
    function send(){
    global $wgOut, $tplt;
    
        $before = null;
        $end = null;
        $out = null;
        $bc = null;
        
        $spliter = get_awcsforum_word('1indicator_main_bread_crumb') ;
        
        wfRunHooks( 'awcsforum_breadcrumb', array( &$before, &$this->links, &$after ) ); // changed 2.5.7
        
        $bc = implode(' ' . $spliter . ' ', $this->links);
        
        $info['bc_links'] =  $before . $bc . $after  ;
        $BreadCrumb = $info['bc_links'];
        
        $out = $tplt->phase('', $info, 'breadcrumbs', true);
        
        $wgOut->addHTML($out); 
        
        return $BreadCrumb;
    }

}
