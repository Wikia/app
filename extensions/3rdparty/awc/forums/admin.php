<?PHP
/**
* Forums Admin file...
* 
* 
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
* @filepath /extensions/awc/forums/admin.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
*  Set url where AutoForumUpdate looks
* @since Version 2.5.8
*/ 
define('awc_forum_update_url', 'http://anotherwebcom.com/app_update_info/awc_mw_forum_extension/');


/**
*  Admin:: Main class
* @since Version 2.5.8
*/ 
class awcforum_forumAdmin{

/**#@+
    * @var string
    * @since Version 2.5.8
    */ 
    var $membername;
    var $m_id;
    var $awc_url;
/**#@-*/
   
   function __construct(){
       
        if(UserPerm != 10) die("Nope - Forum Admin Section, You need to be a Sysops");
   }

    
    /**
    *  Enter Admin, choose what to do in SWITCH
    * 
    * URL command lines<br />
    * Special:AWCforum/admin/threads_to_wiki<br />
    * Special:AWCforum/admin/wfInitStats (runs wiki /maintenance/initStats.inc)<br />
    * Special:AWCforum/admin/re_forum_stats<br />
    * Special:AWCforum/admin/user_recount_all<br />
    * @parameter string $action
    * @uses awc_admin_skin
    * @since Version 2.5.8
    */ 
    function enterAdmin($action){
		global $wgRequest, $ADskin, $awc, $wgOut, $awc_admin_lang, $wgUser, $WhoWhere, $action_url, $awc_ver ;
    
        $WhoWhere['type'] = 'forum';
        $WhoWhere['where'] = 'admin||awc-split||admin' ;
        
        require_once( awc_dir . 'dBase.php' );
        require(awc_dir . 'includes/admin/admin_funk.php');
        require(awc_dir . 'skins/admin_skin.php');
        
		$ADskin = new awc_admin_skin();
        
        if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '=')) {
            Set_AWC_Forum_SubTitle(get_awcsforum_word('admin_setPagetitle'), get_awcsforum_word('admin_setSubtitle'));
            Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'admin'. '">' . get_awcsforum_word('admin_word') .'</a>'); 
            
            
        }

		$spl = explode("/", $action);
        
        $todo = (isset($spl[1])) ? str_replace("todo_", "", $spl[1]) : $wgRequest->getVal( 'todo' );
        
        $id =  isset($spl[2]) ? str_replace("id", "", $spl[2]) : $wgRequest->getVal( 'id' );
        
		$move_id = $wgRequest->getVal( 'move_id' );
        
        define('what_page', $todo );
        
		switch( $todo ) {
            

            // url commands        
          case 'threads_to_wiki':
                if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");
                if(!isset($spl[2]) OR !is_numeric($spl[2])) return  $wgOut->addHTML("<br><br><center>Need a count-number<br><br>");
                self::threads_to_wiki($spl[2]);
                break; 
                 
          case 'wfInitStats':
                if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");
                global $IP;
                require($IP . '/maintenance/initStats.inc');
                    wfInitStats();
                break; 
                 
          case 'dev':
                if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");
                require(awc_dir . 'includes/admin/admin_dev.php');
                return awcs_forum_dev_func();
                break; 
                
          case 're_forum_stats':
                if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");
                return self::re_forum_stats();
                break;
                
          case 'user_recount_all':
                if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");
                self::user_recount_all();
                break;
          // END url commands..
          
     
          case 'tplt':
                require(awc_dir . 'includes/admin/admin_tplt.php');
                awcs_forum_admin_tplt($action);
                break; 
                
          case 'theme':
                require(awc_dir . 'includes/admin/admin_theme.php');
                awcsforum_admin_theme_func();
                break; 
                
          case 'awc_lang':
                require(awc_dir . 'includes/admin/admin_lang_funk.php');
                $awc_lang_class = new awc_admin_lang_cls($action);
                unset($awc_lang_class);
                #$awc_lang_class->awc_admin_lang_cls();
                break; 
                
          case 'css':
                require(awc_dir . 'includes/admin/admin_css_funk.php');
                awcs_forum_admin_css($action);
                break;
                
          case 'cat':
                require(awc_dir . 'includes/admin/admin_cat.php');
                awcsf_admin_categories_func();
                break; 
                
                
          case 'forum':
                require(awc_dir . 'includes/admin/admin_forum.php');
                awcsf_admin_forum_func();
                break;
                
          case 'mem_title':
                require(awc_dir . 'includes/admin/admin_memtitle.php');
                awcsf_admin_membertitle_func();
                break;
                
                

                  
		  case 'maintenance':
				self::get_maintenance();
				break;
                
          case 'do_prune':
                if(in_array('bureaucrat', $wgUser->getGroups())) $this->do_prune();
                break;
                
          case 'do_Trecount':
                self::do_Trecount();
                break;
                
          case 'do_Precount':
                self::do_Precount();
                break;
                
                
                
		  case 'config_forum':
				self::do_config_forum();
				break;
                
		  case 'admin_get_config':
				self::do_get_config($id);
				break;
                
                	
          case 'mem_lookup':
                awcsforum_funcs::get_page_lang(array('lang_txt_mem'));
                self::mem_lookup();
                break;
                
          case 'save_sig':   
          case 'CheckAvatraSize':     
          case 'miscusersettings':
                self::save_userinfo($todo);
                break;
                
          case 'user_recount':
                self::user_recount();
                break;
                
                           
          case 'delete_file':
                self::delete_file($wgRequest->getVal('todo'));
                break;
                 
           
                
          case 'get_updates':
                self::get_updates();
                break;
                      
          case 'forum_update':
                self::forum_update();
                break;
                
          case 'forum_autoupdate':
                self::forum_autoupdate();
                break;
                
           case 'get_autoupdate':
                self::get_autoupdate();
                break;
                
           case 'autoupdate_unpack_and_update':
                self::autoupdate_unpack_and_update();
                break;
                
                
                
          case 'get_emotions':
                self::emotions_get();
                break;
                
          case 'edit_emotions':
                self::emotions_edit();
                break;
                
                
          case 'add_emotions':
                self::emotions_add();
                break;
                    
			default:
				self::main();
				break;
		}
	
	}
    
    /**
    *  Main Admin Page...
    * @uses Set_AWC_Forum_BreadCrumbs
    * @uses MainAdmin
    * @since Version 2.5.8
    */ 
    function main(){
    global $wgOut, $ADskin;
    
        Set_AWC_Forum_BreadCrumbs('' , true); 
        $html = $ADskin->MainAdmin() ;
        $wgOut->addHTML( $html );
        
    }
    
    
    /**
    *  Read file from awc server for update forum version
    * 
    * Step one (of 3) in Auto Update process.
    * @uses Set_AWC_Forum_BreadCrumbs
    * @since Version 2.5.8
    */
    function forum_autoupdate(){
    
           Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_autoupdate') .' - ' . get_awcsforum_word('admin_expearimental') , true);
        
            $ver_check_file =  awc_forum_update_url;
           // die($ver_check_file);
            $ver_file = @fopen($ver_check_file . 'forum_currentver.txt', "rb");
            
            $ver = '';
            $update = true;
             
            if (!$ver_file) {
                if(function_exists('fopen')){
                     $up = 'no file found or file is empty';
                  } else {
                      $up = 'no PHP "fopen()" function'; 
                }
                
                $update = false;
            
            }  else {
                
                if($update){
                
                    while (!@feof($ver_file)) {
                      $ver .= @fread($ver_file, 8192);
                    }
                    @fclose($ver_file);
                             
                    if($ver != ''){
                        
                        $savefilename = awc_dir . 'updates/update_ver.holder';
                        
                        if (!$save_ver_file = @fopen($savefilename , 'w')) {
                             $up = "Cannot open file ($savefilename)";
                             $update = false;
                        }

                        // Write $somecontent to our opened file.
                        if (@fwrite($save_ver_file, $ver) === FALSE) {
                            $up = "Cannot write to file ($savefilename)";
                            $update = false;
                        }
                        
                        @fclose($save_ver_file);
                    
                    
                    } else {
                         $update = false;
                         $up = 'file is empty';
                    }
                    
                }
            }
        
         if(!$update){
              return  awcs_forum_error($up);
         }
        
        global $wgOut, $awcs_forum_config;
        
        $wgOut->addHTML( '<br /><br />' .  get_awcsforum_word('admin_yourforumver') . ' <b>'. $awcs_forum_config->cf_forumversion . '</b>');
        
        
        if(version_compare($ver, $awcs_forum_config->cf_forumversion, '>')){
            $html = '<form action="'. awc_url .'admin/get_autoupdate" method="post">';
            $html .= '<input name="get_ver" type="hidden" value="'.$ver.'">' ;
            $html .= ' <input type="submit" value="'.get_awcsforum_word('admin_update_to'). ' ' .  $ver .'"></form>';
        } else {
            $html = '<br />' . get_awcsforum_word('admin_yourcurrentlyuptodate');
        }
        
        $wgOut->addHTML($html . '<br /> <hr />');
        
        
        //$wgOut->addHTML( $html );
       // die($ver);

    
    
    }
    
    /**
    *  Download tar Update, save in /updates/AutoUpdate_tars/ dir
    * 
    * Step two (of 3) in Auto Update process.
    * @uses Set_AWC_Forum_BreadCrumbs
    * @since Version 2.5.8
    */
    function get_autoupdate(){
    global $wgRequest;
    
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_autoupdate') .' - ' . get_awcsforum_word('admin_expearimental') , true);
        
        $get_ver = $wgRequest->getVal('get_ver');
        
        $get_link = awc_forum_update_url ;
        $get_link .= 'awcforum_get_auto_update_tar.php';
        
        $handle = fopen("$get_link?ver=$get_ver", "rb");
        $ftp_link = '';
        while (!feof($handle)) {
          $ftp_link .= fread($handle, 8192);
        }
        fclose($handle);
        
        $ftp_link = awc_forum_update_url . 'current_forum_update.tar';
        
        
        $ver_file = @fopen($ftp_link, "rb");
        while (!@feof($ver_file)) {
          $tar .= @fread($ver_file, 8192);
        }
        @fclose($ver_file);
                 
        $update = true; 
        $save_tar = awc_dir . 'updates/AutoUpdate_tars/'.$get_ver.'.tar';
        
        if (!$save_tar_hd = @fopen($save_tar , 'w')) {
             $up = "Cannot open file ($savefilename)";
             $update = false;
        }

        // Write $somecontent to our opened file.
        if (@fwrite($save_tar_hd, $tar) === FALSE) {
            $update = false;
        }
        
        @fclose($save_tar_hd);
        
        if($update){
        global $wgOut;
            
            $wgOut->addHTML(get_awcsforum_word('admin_updatetarinyourserver') . "<br />$save_tar<hr />");
            
            
            $html = '<form action="'. awc_url .'admin/autoupdate_unpack_and_update" method="post">';
            $html .= '<input name="get_ver" type="hidden" value="'.$get_ver.'">' ;
            $html .= ' <input type="submit" value="'.get_awcsforum_word('admin_continue'). ' ' .  $ver .'"></form>';
            
            $wgOut->addHTML($html . '<br /><br />'); 
        
        }
          
          # admin/get_updates/$get_ver              

      //  die($ftp_link);
        
        
    }
    
    /**
    *  Uncompress update TAR
    * 
    * Extract forum files to extensions folder 
    * Step three (of 3) in Auto Update process.
    * @todo Finish auto-update, need work on exstrating, need run auto run update script
    * @uses Set_AWC_Forum_BreadCrumbs
    * @since Version 2.5.8
    */
    function autoupdate_unpack_and_update(){
    global $wgRequest, $IP;
    
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_autoupdate') .' - ' . get_awcsforum_word('admin_expearimental') , true);
        
        $get_ver = $wgRequest->getVal('get_ver');
        
        $save_tar = awc_dir . 'updates/AutoUpdate_tars/'.$get_ver.'.tar';
        
        require(awc_dir . 'includes/tar_cls.php'); 
        $tar = new awcsforum_tar_compress_cls();
        
        //$tar->filename = $save_tar;
        
        $arch = new tar;
        $arch->extractTar($save_tar, awc_dir . 'updates/AutoUpdate_tars/');

      // die($IP);
      //  $tar->extract_files($IP . '/');
        
        
        // working, just need to fix the TAR error problem above...
       // die(header("Location: " . awc_url . 'admin/get_updates/' . $get_ver));
    
    }
    
    
    /**
    *  Recount all users Post and Thread counts
    * 
    * When stats get messed up, they can be correct here with a URL commend line<br />
    * 
    * @uses user_recount
    * @since Version 2.5.8
    */
    function user_recount_all(){
    global $wgRequest, $wgOut;
    
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_mems = $dbr->tableName( 'awc_f_mems' );
        $sql = "SELECT m_id FROM {$awc_f_mems} ";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            $wgRequest->data['m_id'] =  $r->m_id;
            self::user_recount(false);  
        }
        
        $wgOut->redirect( awc_url . "admin/" );
        
        
      //  $m_id = $wgRequest->getVal( 'm_id' );
        
      //  awc_pdie($wgRequest->getVal( 'm_id' ));
    
    
    }
                
    
    
    /**
    *  Recount forum stats; threads, posts, members
    * 
    * @uses user_recount
    * @since Version 2.5.8
    */
    function re_forum_stats(){
    GLOBAL $awc_tables; 
       
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $stat_info = array('threads' => '0', 'topics' => '0', 'mems' => '0');
        
        $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
        $sql = "SELECT f_threads, f_replies FROM {$awc_f_forums} ";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            $stat_info['threads'] = ($stat_info['threads'] + $r->f_threads);
            $stat_info['topics'] = ($stat_info['topics'] + $r->f_replies);            
        }
        unset($r);
        $dbr->freeResult( $res );
        
        $awc_f_mems = $dbr->tableName( 'awc_f_mems' ); 
        $sql = "SELECT m_id FROM {$awc_f_mems} ";
        $res = $dbr->query($sql);
        $stat_info['mems'] = $dbr->numRows( $res );
        $dbr->freeResult( $res );
        
       // $dbw->delete( 'awc_f_stats', true, '');
        
        $r = $dbr->selectRow( 'awc_f_stats', array('stats_id',),'');
        
        $dbw->update( 'awc_f_stats', array('stat_posts' => $stat_info['topics'],
                                            'stat_threads' => $stat_info['threads'],
                                            'stat_mems' => $stat_info['mems'],
                                            ), array('stats_id' => $r->stats_id), '');
        
        
        unset($stat_info);
        
    }
    
    
    
    /**
    *  Pull all info from 'awc_f_cats' table
    * 
    * @return array
    * @since Version 2.5.8
    */
    function cats_get_all_array(){
        
        $dbr = wfGetDB( DB_SLAVE );
        $out = array();
        
        $awc_f_cats = $dbr->tableName( 'awc_f_cats' );
        $sql = "SELECT * FROM $awc_f_cats ORDER BY cat_order";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            
            $out[$r->cat_id] = array('cat_id' => $r->cat_id,
                                            'cat_name' => $r->cat_name,
                                            'cat_desc' => $r->cat_desc, 
                                            'cat_order' => $r->cat_order,  
                                            'c_wiki_perm' => $r->c_wiki_perm,);
        }
        $dbr->freeResult( $res );
        unset($r);
        
        return $out;
        
    }
    
    /**
    *  Pull all info from 'awc_f_forums' table
    * 
    * @return array
    * @since Version 2.5.8
    */
    function forums_get_all_array(){
        
        $dbr = wfGetDB( DB_SLAVE );
        $out = array();
        
        $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
        $sql = "SELECT * FROM $awc_f_forums ORDER BY f_order";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            
            $out[$r->f_id] = array('f_id' => $r->f_id,
                                            'f_parentid' => $r->f_parentid,
                                            'f_name' => $r->f_name, 
                                            'f_desc' => $r->f_desc,  
                                            'f_threads' => $r->f_threads,
                                            'f_replies' => $r->f_replies,
                                            'f_lastdate' => $r->f_lastdate,
                                            'f_lastuser' => $r->f_lastuser, 
                                            'f_lastuserid' => $r->f_lastuserid,  
                                            'f_lasttitle' => $r->f_lasttitle,
                                            'f_threadid' => $r->f_threadid,
                                            'f_order' => $r->f_order,
                                            'f_perm' => $r->f_perm, 
                                            'f_top_tmplt' => $r->f_top_tmplt,  
                                            'f_posting_mesage_tmpt' => $r->f_posting_mesage_tmpt,
                                            'f_wiki_read_perm' => $r->f_wiki_read_perm,
                                            'f_wiki_write_perm' => $r->f_wiki_write_perm,
                                            'f_passworded' => $r->f_passworded, 
                                            'f_password' => $r->f_password,);
        }
        $dbr->freeResult( $res );
        unset($r);
        return $out;
        
    }
    
    
    /**
    *  Get all wiki Group Permissions
    * 
    * @return array
    * @since Version 2.5.8
    */
    function wikigroup_list(){
    global $wgGroupPermissions;
        
        $g = array();
        foreach($wgGroupPermissions as $key => $info){
            $g[] = $key;
        }
        
        return $g;
        
        
    }
    
    /**
    *  Loop WikiGroup check boxs for Cat or Forum pemissions (write or read)
    * 
    * @parameter string $checkbox_name (write or read permission)
    * @return array
    * @since Version 2.5.8
    */
    function wikigroup_check_for_save($checkbox_name){
    global $wgRequest;
            
        $c_wiki_perm = array();
        $wiki_perm = array();
        
        
        if(isset($_POST[$checkbox_name])){
            $c_wiki_perm = $_POST[$checkbox_name];
        } else {
             $c_wiki_perm['*'] = 'blank';
        }
        
        
        foreach($c_wiki_perm as $name => $on){
            $wiki_perm[] = $name;
        }
        unset($c_wiki_perm);
        
        return implode(',', $wiki_perm);
    }
    
    
    
    /**
    *  Create Wiki Group Permissions check boxs
    * 
    * @parameter string $checkbox_name
    * @parameter boolean $select
    * @uses wikigroup_list
    * @return array
    * @since Version 2.5.8
    */
    function wikigroup_get_checkboxs($checkbox_name, $select = null){

        $out = null;
        if($select != null) {
            $out =  "( <b><i>".str_replace(',', ' , ', $select)."</i></b> )";
            $select = explode(',', $select);
        }
        $out .= '<p style="height: 100px; width:300px; overflow: auto; border: 1px solid #000; background: #eee; color: #000; margin-bottom: 1.5em;">';
        $wiki_groups = self::wikigroup_list();
        
        
        foreach($wiki_groups as $group){
            
            if(is_array($select) AND in_array($group, $select)){
                 $out .= '<label><input type="checkbox" name="'.$checkbox_name.'['.$group.']" checked="checked"/> '.$group.'</label><br />';
            } else {
                $out .= '<label><input type="checkbox" name="'.$checkbox_name.'['.$group.']" /> '.$group.'</label><br />';
            }
            
        }
        
        $out .= '</p>';
        return $out;
    }
    
    
    /**
    *  Loop posts and add to wiki search table(s)
    * 
    * Loop from 'awc_f_posts' table<br />
    * Save posts text to wo Wiki tables<br />
    * Flag post 't_wiki_pageid' columne
    * @parameter string $limit (how many entries to work with)
    * @uses awcs_forum_wikisearch_cls
    * @since Version 2.5.8
    */
    function threads_to_wiki($limit){
    global $wgOut;    
        
        require_once(awc_dir . 'includes/to_wiki_dbase.php');
        
        $dbr = wfGetDB( DB_SLAVE );       
        $awc_f_threads = $dbr->tableName( 'awc_f_threads' ); 
        $awc_f_posts = $dbr->tableName( 'awc_f_posts' );          
        $sql = "SELECT t.t_id, t.t_name, p.p_post 
                    FROM $awc_f_threads t
                    JOIN $awc_f_posts p
                        ON p.p_threadid=t.t_id
                    WHERE t.t_wiki_pageid=0 AND t.t_date = p.p_date
                    ORDER BY t.t_date DESC
                    LIMIT 0, $limit";
                    
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            $tmp[] = array('p_post' => $r->p_post, 't_id' => $r->t_id , 't_name' => $r->t_name );
        }
        $dbr->freeResult( $res );
        

      
        foreach($tmp as $r){
           // die($r['p_post']);
                    $ws = new awcs_forum_wikisearch_cls();
                    
                    $ws->post = $r['p_post'];
                    $ws->tID = $r['t_id'];
                    
                    $ws->title = $r['t_name'];
                    $ws->p_wiki_hidden = $dbr->timestamp();
                    $ws->add_thread();
                    
                    $wgOut->addHTML("pageID($ws->pageID)  insert_textID($ws->insert_textID) insert_revID($ws->insert_revID) = {$r['t_name']} <br />");
                    unset($ws);
        
        
        }
                    
          /*
        
        $dbr = wfGetDB( DB_SLAVE );       
        $awc_f_threads = $dbr->tableName( 'awc_f_threads' ); 
        $awc_f_posts = $dbr->tableName( 'awc_f_posts' );          
        $sql = "SELECT t.t_wiki_pageid
                    FROM $awc_f_threads t
                    JOIN $awc_f_posts p
                        ON p.thread_id=t.t_id
                    WHERE t.t_date = p.p_date and t.t_wiki_pageid != 0
                    ORDER BY t.t_date DESC
                    LIMIT 0, $limit";
                    
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            //$tmp[] = array('p_post' => $r->p_post, 't_id' => $r->t_id , 't_name' => $r->t_name );
            $tmp[] = $r->t_wiki_pageid;
        }
        $dbr->freeResult( $res );
        
        $pIDs = implode(',', $tmp);
        
        $dbw = wfGetDB( DB_MASTER );
        $wiki_page = $dbw->tableName( 'page' );          
        $sql = "UPDATE $wiki_page SET page_namespace = ".NS_AWC_FORUM." WHERE page_id IN ($pIDs) ";
        $res = $dbw->query($sql);   
        
         */    
                    
    }
    
    /**
    *  Add new emotion
    * 
    * @since Version 2.5.8
    */
    function emotions_add(){
    global $wgRequest, $wgOut, $awc ;
    
        $dbw = wfGetDB( DB_MASTER );
              
        	#$bs = $dbw->nextSequenceValue( 'awc_f_emotions_e_id_seq' );
            $dbw->insert( 'awc_f_emotions', array(
                'e_code'        => $wgRequest->getVal('code'),
                'e_pic'        => $wgRequest->getVal('pic'),
                ) );
            
            $e_id = awcsforum_funcs::lastID($dbw, 'awc_f_emotions', 'e_id');
                
                
             if($_FILES["upload"]["error"] == '0'){
                 
                 $path = $_FILES["upload"]["tmp_name"] ;
                 $name = $_FILES["upload"]["name"] ;
                    
                    if(@move_uploaded_file($path, awc_dir . 'images/emotions/default/' . $name )){  
                        
                        $dbw->update( 'awc_f_emotions',
                                        array( 
                                                'e_pic'    => $name,
                                                ), 
                                        array( 
                                                'e_ID' => $e_id
                                        ), ''
                                    
                                    );
                        
                    } 

                    
             }
                
                
         $wgOut->redirect( awc_url . "admin/get_emotions" );
    }
    
    /**
    *  Edit emotion
    * 
    * @since Version 2.5.8
    */
    function emotions_edit(){
    global $wgRequest, $wgOut, $awc;
    
        $dbr = wfGetDB( DB_SLAVE );
        $dbw = wfGetDB( DB_MASTER );
        
        $table = $dbr->tableName( 'awc_f_emotions' );  
        $sql = "SELECT * FROM $table" ;   
            $res = $dbr->query($sql); 
            while ($r = $dbr->fetchObject( $res )) {
                
                if($wgRequest->getVal( 'd' . $r->e_ID ) == 'on'){
                    $dbw->delete( 'awc_f_emotions', array( 'e_ID' => $r->e_ID ), '');
                    # $awc['emo_dir'] . $wgRequest->getVal( $r->e_ID .'pic' )
                    @unlink(awc_dir . 'images/emotions/default/' . $wgRequest->getVal( $r->e_ID .'pic' ));
                } else {
                    $dbw->update( 'awc_f_emotions',
                                    array( 
                                            'e_code'    => $wgRequest->getVal( $r->e_ID ),
                                            'e_pic'    => $wgRequest->getVal( $r->e_ID .'pic' ),
                                            ), 
                                    array( 
                                            'e_ID' => $r->e_ID
                                    ), ''
                                
                                );
                }
                
                
              #  $html .= get_awcsforum_word('admin_emotion_code').' <input name="'.$r->e_ID.'" type="text" value="'.$r->e_code.'"> ' . get_awcsforum_word('admin_emotion_pic') . ' <input name="'.$r->e_ID.'pic" type="text" value="'.$r->e_pic.'"> <br />' ; 
            }
        $dbr->freeResult( $res );
        
        $wgOut->redirect( awc_url . "admin/get_emotions" );
        
    }
    
    /**
    *  Get and Display emotions
    * 
    * @since Version 2.5.8
    */
    function emotions_get(){
    global $awc, $wgOut;
    
    # $awc['emo_dir']
    
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_emotions_edit') , true);
        
        $html = '<form action="'. awc_url .'admin/edit_emotions" method="post">';
        $html .= '<br />' . get_awcsforum_word('admin_emotion_code') . ' / ' . get_awcsforum_word('admin_emotion_pic') . '  <a target="blank" href="http://wiki.anotherwebcom.com/Adding%2C_Deleting_and_Editing_Emotions">' . get_awcsforum_word('word_moreinfo') . '</a><hr>';
        $dbr = wfGetDB( DB_SLAVE );
        $table = $dbr->tableName( 'awc_f_emotions' );  
        $sql = "SELECT * FROM $table" ;   
            $res = $dbr->query($sql); 
            while ($r = $dbr->fetchObject( $res )) {
                $html .= get_awcsforum_word('delete') . ' <INPUT TYPE=CHECKBOX NAME="d'.$r->e_ID.'">' .' <input name="'.$r->e_ID.'" type="text" value="'.$r->e_code.'"> <img src="' . emo_path . $r->e_pic . '" /> <input name="'.$r->e_ID.'pic" type="text" value="'.$r->e_pic.'"> <br />' ; 
            }
        $dbr->freeResult( $res );
        
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form> <br /><br />';
        
        
        $html .= get_awcsforum_word('admin_addnewemotion') . '<hr>';
        $html .= '<form enctype="multipart/form-data" action="'. awc_url .'admin/add_emotions" method="post">';
         $html .= get_awcsforum_word('admin_emotion_code').' <input name="code" type="text" value=""> <input name="pic" type="text" value="">  ' ; 
         $html .= '<br /><input name="upload" type="file" size="60" /> <br /> '; 
         $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form> <br /><br />';
        
       
        $wgOut->addHTML($html);    
    }
    
    
    /**
    *  Delete file
    * 
    * @parameter string $path 
    * @uses unlink
    * @since Version 2.5.8
    */
    function delete_file($path){
     global $wgOut;
        
        $path = $path;
        @unlink($path);
        return $wgOut->addHTML('<b>' . $path .'</b> <br />'. get_awcsforum_word('admin_lang_hasbeendeleted'));
    
    }
    
    
    /**
    *  Gets update_ver##.php
    * 
    * @uses get_awcsforum_word
    * @since Version 2.5.8
    */
    function get_updates(){
    global $wgRequest, $wgOut, $awc, $wgUser; 
    
         if(!in_array('sysop', $wgUser->getGroups())) return ;
        
        $todo = $wgRequest->getVal( 'todo' );
        
        $action = $wgRequest->action;
        $spl = explode("/", $action);
        
        if($spl[2] == 'UnInstall'){
			require(awc_dir . '/updates/install/UnInstall.php');
			$re = new updateUnInstall();
			$re->update_this($spl[3]);
			return;
		}
        
        $update_file = awc_dir . 'updates/' . $spl[2] . '.php';
        if (! file_exists($update_file)){
            return $wgOut->addHTML('<br/><br />' . get_awcsforum_word('admin_update_sorrynofile') . $spl[2] . '<br/><br />');
        }
        
        
        require(awc_dir . 'includes/admin/admin_lang_funk.php');
        require(awc_dir . 'includes/admin/admin_css_funk.php');
        require(awc_dir . 'includes/admin/admin_tplt.php');
        require(awc_dir . 'includes/admin/admin_memtitle.php');
                
        require($update_file);
        $ver = 'update' . str_replace('.','_', $spl[2]);
        $UpDate = new $ver();
        
       #$UpDate->update_this($spl[2], $todo);
       
        if($UpDate->update_this($spl[2], $todo)) @unlink($update_file);
        
         # $update_file
        
        return ;#$wgOut->addHTML();

    
    
    }
    
    
    /**
    *  Display update files avaible
    * 
    * @uses get_awcsforum_word
    * @since Version 2.5.8
    */
    function forum_update(){
    global $wgOut, $awc, $awc_lang, $wgUser, $awcs_forum_config, $awc_ver;
    
       if(!in_array('sysop', $wgUser->getGroups())) return ;
        
        
        //if(strval($awc_ver) >= strval("250")) Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_forum_update') , true);
        
        get_awcsforum_word('admin_forum_updateinfo') == '' ?  $up = 'Click on the link below for the Forum version you would like to update to.' : $up = get_awcsforum_word('admin_forum_updateinfo');
        get_awcsforum_word('admin_update_to') == '' ?  $up_to = 'Update to' : $up_to = get_awcsforum_word('admin_update_to');
        get_awcsforum_word('admin_listofupdate') == '' ?  $up_list = 'Here is a list of up-dates which you can install, your current Forum is: ' : $up_list = get_awcsforum_word('admin_listofupdate');
        
        $wgOut->addHTML('<hr>' . $up . '<hr><br />');
        $wgOut->addHTML( $up_list . ' <b>'. $awcs_forum_config->cf_forumversion . '</b><hr>');
            
            $updates = array();
            $d = dir($filename = awc_dir . 'updates/');
            $dont_show = array();
            $dont_show[] = '.';
            $dont_show[] = '..';
            $dont_show[] = 'tmplet.php';
            $dont_show[] = 'update_lang.txt';
            $dont_show[] = 'install_update_config.php';
            $dont_show[] = 'UnInstall.php';
            $dont_show[] = '12_2x_post_count_fix.php';
            $dont_show[] = 'css';
            $dont_show[] = 'fresh_install_lang.txt';
            $dont_show[] = 'install_forum.php';
            $dont_show[] = 'index.html';
            $dont_show[] = 'fresh_install_tables.php';
            $dont_show[] = 'sql';
            #$dont_show[] = 'import_phpbb2.0.6.php';
            $dont_show[] = 'langs';
            $dont_show[] = 'import_vb.php';
            $dont_show[] = 'old';
            $dont_show[] = 'tmp_holder';
            
            
            
            while (false !== ($entry = $d->read())) {
              if(strstr($entry,".php") AND is_numeric(substr($entry , 0, 1))) $updates[] = str_replace('.php', '', $entry) ;
               #if(!in_array($entry, $dont_show)) $updates[] = str_replace('.php', '', $entry) ;
            }
            $d->close();
            unset($dont_show);
            arsort($updates) ;
            foreach($updates as $u){
             // die(awc_url);
             
                $wgOut->addHTML($up_to . ' <a href="'.awc_url.'admin/get_updates/'.$u.'">' . $u . '</a><br />');
            }
            
            if(file_exists( $filename .'12_2x_post_count_fix.php')){
                    $info = 'There was a big change from 1.2 to 2.x and with this change all old 1.2 threads and posts will not have 
                    Users current info; Signatures, Avatar, Post and Thread counts being displayed in old threads.<br />
                    You can fix this by running this update.<br /> Note: you have to run this update LAST.<br />
                    You must run all other updates before running this update<br />
                    And this update might take alittle while to run depending on the size of your forum.<br />
                    <b>User this at your own risk.</b><br />';
                    $delete = '( <a href="'.awc_url.'admin/delete_file/&todo='.awc_dir.'updates/12_2x_post_count_fix.php">Delete</a>) ';
                    $wgOut->addHTML('<br /><hr>' . $info . $delete .  $up_to . ' <a href="'.awc_url.'admin/get_updates/12_2x_post_count_fix/">1.2 to 2.x User count fix.</a><hr><br />');
            }
            
            get_awcsforum_word('admin_uninstall') == '' ? $uninstal_link = 'Un-install' : $uninstal_link = get_awcsforum_word('admin_uninstall');
            
            if(in_array('bureaucrat', $wgUser->getGroups())) $wgOut->addHTML('<br /><hr> <a href="'.awc_url.'admin/get_updates/UnInstall/">'.$uninstal_link.'</a>');
            
            if(in_array('bureaucrat', $wgUser->getGroups())) $wgOut->addHTML('<br /><a href="?title=Special:AWCforum&action=install_forum">Install Forum</a><hr>');
            
            
            unset($updates);    
    }
    
    
    /**
    *  Recount number of threads displayed in forum list
    * 
    * @since Version 2.5.8
    */
    function do_Trecount(){
    global $wgRequest, $wgOut, $awc;
    
        
        $forum_id = $wgRequest->getVal( 'forum_id' );
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $table_1 = $dbr->tableName( 'awc_f_threads' );
        
        $sql = "SELECT COUNT(t_id) as tCount FROM $table_1 WHERE t_forumid = $forum_id";   
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $tCount = $r['tCount']  ;
        $dbr->freeResult( $res );
        
        $table_1 = $dbr->tableName( 'awc_f_posts' ); 
        $sql = "SELECT COUNT(p_id) as pCount FROM $table_1 WHERE  p_forumid = $forum_id"; // 2.5.9 edit  
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $pCount = $r['pCount'];
        $dbr->freeResult( $res );
        
        
         #$er = ($pCount - $tCount);  
       # DIE($pCount . ' ' . $tCount . ' '. $er);
        $pCount = ($pCount - $tCount);
        
       $table_1 = $dbw->tableName( 'awc_f_forums' );
            $sql = "UPDATE $table_1  " ;
            $sql .= "SET f_replies = $pCount"  ;
            $sql .= ", f_threads = $tCount"  ;
            $sql .= " WHERE f_id =" . $forum_id;
       $dbw->query($sql);
       
       $wgOut->redirect( awc_url . "admin/maintenance" ); 
        
    }
    
    /**
    *  Recount number of posts for thread titles
    * 
    * @since Version 2.5.8
    */
    function do_Precount(){
    global $wgRequest, $wgOut, $awc;
    
        
        $forum_id = $wgRequest->getVal( 'forum_id' );
        $limit = $wgRequest->getVal( 'limit' );
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $table_1 = $dbw->tableName( 'awc_f_threads' );
        $table_2 = $dbw->tableName( 'awc_f_posts' );
        
        $sql = "SELECT COUNT(p_id) as pCount FROM $table_2 WHERE  p_forumid = $forum_id";   
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $pCount = $r['pCount'];
        $dbr->freeResult( $res );
        
       $table_1 = $dbw->tableName( 'awc_f_forums' );
            $sql = "UPDATE $table_1  " ;
            $sql .= "SET f_replies = $pCount"  ;
            $sql .= " WHERE f_id =" . $forum_id;
       $dbw->query($sql);
       
       
       $wgOut->redirect( awc_url . "admin/maintenance" ); 
        
      #  die(">". $pCount );
        
        
    }
    
    /**
    *  Recount a users post and thread count
    * 
    * @since Version 2.5.8
    */
    function user_recount($redirect = true){
    global $wgRequest, $wgOut, $awc; 
    
        $userName = $wgRequest->getVal( 'mem_name' );
        $m_id = $wgRequest->getVal( 'm_id' );
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_threads = $dbw->tableName( 'awc_f_threads' );
        $awc_f_posts = $dbw->tableName( 'awc_f_posts' );
        
        $sql = "SELECT COUNT(p_id) as pCount FROM $awc_f_posts WHERE  p_userid = $m_id";   
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $pCount = $r['pCount'];
        $dbr->freeResult( $res );
        
        $sql = "SELECT COUNT(t_id) as tCount FROM $awc_f_threads WHERE t_starterid = '$m_id'";   
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $tCount = $r['tCount'];
        $dbr->freeResult( $res );
        
       # die($tCount);
        
       $awc_f_mems = $dbw->tableName( 'awc_f_mems' );
            $sql = "UPDATE $awc_f_mems  " ;
            $sql .= "SET m_topics = $tCount"  ;
            $sql .= ", m_posts = $pCount" ;
            $sql .= " WHERE m_id =" . $m_id;
       $dbw->query($sql);
       
       
       
       if($redirect) $wgOut->redirect( awc_url . "admin/mem_lookup/$userName/$m_id" );
       
    }
    
    /**
    *  Get a users settings; Sig, Avatar
    * 
    * @uses get_awcsforum_word
    * @uses Set_AWC_Forum_BreadCrumbs
    * @uses awcforum_members
    * @uses GetThisMemInfo
    * @uses DisplayUserInfo_for_admin
    * @since Version 2.5.8
    */
    function mem_lookup(){
    global $wgRequest, $awc, $wgOut, $awcs_forum_config, $action_url ;
        
        require(awc_dir . 'members.php');
        $members = new awcforum_members();
        
        $userName = $wgRequest->getVal( 'mem_name' );
        
        $userName = $action_url['2'];
        
        #awc_pdie($userName);
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_MemberLookup') . ' - ' . $userName, true);
        
        $dbr = wfGetDB( DB_SLAVE );
        $table_1 = $dbr->tableName( 'user' );
        $sql = "SELECT user_id FROM $table_1 WHERE user_name='$userName'";
        $res = $dbr->query($sql);
        $r = $dbr->fetchRow( $res );
        $m_id = $r['user_id'];
        
        if($r['user_id'] == ''){
            $str = str_replace( '<p>', '', $wgOut->parse('[[Special:Listusers]]')) ;
            $str = str_replace( '</p>', '', $str) ;
            $wgOut->addHTML('<hr><br /> ' . get_awcsforum_word('admin_NoUserByThatName') . " <b>" . $userName . '</b><br /><h1></h1>'. $str .'<br />');
             return;
        } else {
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
        $user_get[] = 'm_topics'; 
        $user_get[] = 'm_posts'; 
        $userinfo = GetMemInfo($r['user_id'], $user_get);
        unset($user_get);
        */
            
        }
        $dbr->freeResult( $res );
         
        $members->awc_url = awc_url;
        
        $members->membername = $userName;
        $members->m_id = $m_id;
        $members->GetThisMemInfo();
        
       # die(print_r($members->mem_info['m_sig']));
        
        $members->todo_url = 'admin/' ;
        $members->upload = $awcs_forum_config->cf_advatar_no_upload;
        $members->sig_length = $awcs_forum_config->cf_SigLength;
        
        $html = '<hr><br /><br />';
        $html .= '<form id="get_sig" name="get_sig" action="'.awc_url . 'admin/user_recount" method="post">';
        $html .= get_awcsforum_word('admin_user_recount') . '<hr>';
        $html .= get_awcsforum_word('word_posts') . ' ' . $members->mem_info['m_topics'] . ' ' . get_awcsforum_word('word_replies') . ' ' . $members->mem_info['m_posts']; 
        $html .= '<input name="mem_name" type="hidden" value="'.$userName.'">' ;
        $html .= '<input name="m_id" type="hidden" value="'.$m_id.'"> <br />' ;      
        $html .= '<input type="submit" value="'.get_awcsforum_word('submit').'">';
        $html .= '</form><hr><br /><br />'; 
        
        $html .= $members->DisplayUserInfo_for_admin();
        
        return $wgOut->addHTML($html);
            
    }
       
       
    /**
    *  Save members settings
    * 
    * @parameter string $todo (miscusersettings, CheckAvatraSize, save_sig)
    * @uses awcforum_members
    * @uses GetThisMemInfo
    * @uses saveForumOptions
    * @uses avatra_check_size
    * @uses save_sig
    * @since Version 2.5.8
    */
    function save_userinfo($todo){
     global $wgRequest, $awc, $awcs_forum_config;
       
        require(awc_dir . 'members.php');
        $members = new awcforum_members();
        
        $userName = $wgRequest->getVal( 'mem_name' );
        $members->membername = $userName;
        
        $mID = $wgRequest->getVal( 'm_id' );
        $members->m_id = $mID;
        $members->GetThisMemInfo();
        
        $members->awc_url = awc_url;
        $members->todo_url = "admin/mem_lookup/$userName/$mID" ;
        
        $members->sig_length = $awcs_forum_config->cf_SigLength;
        
        
        $members->upload = $awcs_forum_config->cf_advatar_no_upload;
        
        $members->uploadsize = $awcs_forum_config->cf_advatar_upload_size;
        $members->uploadext = $awcs_forum_config->cf_advatar_upload_exe;
        
        $members->imagepath = awc_path . 'images/avatars/' ;
        $members->imagefolder = awc_dir . 'images/avatars/' ;
        
        
        switch($todo){
            
            case 'miscusersettings':
                $members->saveForumOptions();
                break;
        
            case 'CheckAvatraSize':
                $members->avatra_check_size();
                break;
        
            case 'save_sig':
                $members->sig_save();
                break;
                
        }
        
    } 
    
    /**
    *  Deelte threads and posts from date
    * 
    * @since Version 2.5.8
    */
	function do_prune(){
    global $wgRequest, $wgOut;
    
        # 2008-03-21 20:52:56
        $forum_id = $wgRequest->getVal( 'forum_id' );
        $years = $wgRequest->getVal( 'years' );
        $months = $wgRequest->getVal( 'months' );
        $days = $wgRequest->getVal( 'days' );
        
        $dDate = $years .'-'.$months.'-'.$days.' 24:59:59';
        
       # die(">". $forum_id);
       $dbw = wfGetDB( DB_MASTER );
		$table_1 = $dbw->tableName( 'awc_f_threads' );
        $table_2 = $dbw->tableName( 'awc_f_posts' );
         
        
        $sql = "SELECT p_id FROM $table_2 p, $table_1 t
                WHERE (t.t_ann != '1' AND t.t_pin != '1') AND t.t_forumid=$forum_id AND t.t_id = p.p_threadid AND t.t_lastdate <= '$dDate'";   
        $res = $dbw->query($sql);
        $PostTotal = $dbw->numRows($res);
       # die(">" . $PostTotal); 
        
        $sql = "DELETE $table_2 p FROM $table_2 p, $table_1 t
                WHERE (t.t_ann != '1' AND t.t_pin != '1') AND t.t_forumid=$forum_id AND t.t_id = p.p_threadid AND t.t_lastdate <= '$dDate'";  
        $dbw->query($sql); 
        
         
         
        $sql = "SELECT t_id FROM $table_1 t
                WHERE (t.t_ann != '1' AND t.t_pin != '1') AND t.t_forumid=$forum_id  AND t.t_lastdate <= '$dDate'"; 
        $res = $dbw->query($sql);
        $ThreadTotal = $dbw->numRows($res);
        #die(">". $ThreadTotal) ;
        
        $sql = "DELETE $table_1 t FROM $table_1 t
                WHERE (t.t_ann != '1' AND t.t_pin != '1') AND t.t_forumid=$forum_id  AND t.t_lastdate <= '$dDate'"; 
        $dbw->query($sql);
        
        
          $PostTotal = ($PostTotal - $ThreadTotal);
         # die(">". $PostTotal);
         
         
         
        
       $table_1 = $dbw->tableName( 'awc_f_forums' );
            $sql = "UPDATE $table_1  " ;
            $sql .= "SET f_replies = f_replies - $PostTotal"  ;
            $sql .= ", f_threads = f_threads - $ThreadTotal" ;
            $sql .= " WHERE f_id =" . $forum_id;
       $dbw->query($sql);
        
          

       
        
        
        $wgOut->addHTML( '<br />' .  get_awcsforum_word('word_done'));  
        
        
    
    }
    
    /**
    *  Get maintenance options
    * 
    * @uses Set_AWC_Forum_BreadCrumbs
    * @since Version 2.5.8
    */
    function get_maintenance(){
    global $ADskin, $wgOut;
    
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_maintenance'), true);
                
                
                $p_drop='';
        
                    $dbr = wfGetDB( DB_SLAVE );
		            $table_1 = $dbr->tableName( 'awc_f_forums' );
		            $sql = "SELECT f_id, f_name FROM $table_1 ORDER BY f_name ";
		            $res = $dbr->query($sql);
		            while ($r = $dbr->fetchObject( $res )) {
			            $p_drop .= '<option value="'. $r->f_id .'">'. $r->f_name .'</option>';
		            }
                    $dbr->freeResult( $res );
		            $p_drop = '<select name="forum_id">' . $p_drop . '</select>';
                    $e['forums_drop'] = $p_drop;
                    
                     
                    $m = '<option value="01">Jan</option>'; 
                    $m .= '<option value="02">Feb</option>';
                    $m .= '<option value="03">Mar</option>';
                    $m .= '<option value="04">Apr</option>';
                    $m .= '<option value="05">May</option>';
                    $m .= '<option value="06">Jun</option>';
                    $m .= '<option value="07">Jul</option>';
                    $m .= '<option value="08">Aug</option>';
                    $m .= '<option value="09">Sep</option>';
                    $m .= '<option value="10">Oct</option>';
                    $m .= '<option value="11">Nov</option>';
                    $m .= '<option value="12">Dec</option>';            
                        
                    $e['month_drop'] = '<select name="months">' . $m . '</select>';
                    
                    #for($i = 1; $i < 29; ++$i){
                    $d='';
                    for($i = 1; $i < 29; ++$i){
                        $n = $i;
                        if($n < 10) $n = '0'. $n;
                        $d .= '<option value="'. $n .'">'. $n .'</option>';
                    }
                    $e['day_drop'] = '<select name="days">' . $d . '</select>';
                    
                    $y='';
                    for($i = 2008; $i < 2021; ++$i){
                        $y .= '<option value="'. $i .'">'. $i .'</option>';
                    }
                    $e['year_drop'] = '<select name="years">' . $y . '</select>';
            
                   $html =  $ADskin->Maintance($e);
        
        
        return $wgOut->addHTML($html);
    
    }

    /**
    *  Get forum options, pass into to AdminSkin, set page title
    * 
    * @uses Set_AWC_Forum_BreadCrumbs
    * @uses get_awcsforum_word
    * @uses admin_GetConfig
    * @since Version 2.5.8
    */
    function do_get_config($todo){
    global $wgOut, $ADskin; 
    
                Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_get_config'));
                
                switch($todo){
                    
                    case 'forum':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_display_forum_options'), true);
                        break;
                        
                    case 'general':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_display_geneal_options'), true); 
                        break;
                        
                    case 'mem':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_display_mem_options'), true);
                        break;
                        
                    case 'thread':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_display_thread_options'), true);
                        break;
                        
                    case 'forum_tag':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_display_forumtag_options'), true);
                        break;
                        
                    case 'get_emotions':
                        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_emotions_edit'), true); 
                        break;
                            
                    default:
                      #  $b[] = get_awcsforum_word('admin_config_forum') ;
                        break;
                }
                
        $wgOut->addHTML($ADskin->admin_GetConfig($todo));     
    
    }
	
    
    /**
    *  Save forum config
    * 
    * @since Version 2.5.8
    */
	function do_config_forum(){
	global $wgRequest, $wgOut, $awc, $table_1, $awcs_forum_config; 	
		
        if(UserPerm != 10){
            die("Nope - Admin");
        }
        
	    $dbr = wfGetDB( DB_SLAVE );
        $dbw = wfGetDB( DB_MASTER );
        
        
		
        #$yes_wikiedit = true;
        # use this to see is WIki's User Table has the user_editcount feild
        $table_1 = $dbr->tableName( 'user' );
        
        $dBaseCLS = new awcforum_cls_dBase();
        $yes_wikiedit = $dBaseCLS->colCheck($table_1, 'user_editcount');
            
        foreach ($awcs_forum_config as $q => $a){
            
            $a = $wgRequest->getVal($q) ;
            
            if($q != 'cf_forumversion' && $q != 'cf_forumlang'){
			    if($wgRequest->getVal($q) !=''){
			    	
                        if($q == 'cf_css_default'){
                            $css = explode('|', $a);
                            $a = serialize(array('Default' => $css[0]));
                        }
                        
                        
                        if($q == 'cf__forumsubtitle' || $q == 'cf__forumname'){
                        	$a = awcsforum_funcs::awc_htmlentities($a);
                        }
                        
			    	
                $dbw->update( 'awc_f_config',
					array('a' => $a,), array('q' => $q), '');
                }
            }
                    
        }
        
        // check what wiki ver this aplies to... might be older, if so elete.
        # no user_editcount feild, so reste Forum Config for the "Show Wiki Edits"
        if($yes_wikiedit == false){
            $dbw->update( 'awc_f_config',
                    array( 
                                'a'    => 'no',
                                ), 
                        array( 
                                'q' => 'wikieits'
                        ), ''
                    
                    );  
        }
        
        
        $wgOut->redirect( awc_url . "admin" );
	
	}
    
    
}
