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
* @filepath /extensions/awc/forums/forum_tags.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

error_reporting(E_ALL & ~E_NOTICE);

class awcs_forum_info_tag{

    var $wiki_url, $awc_url;
    
    var $width= '100%';
    var $date = "yes";
    var $replies = "yes";
    var $postcount = "yes";
    var $users ="yes";
        
    var $showall = false;
    var $inline = false;
        
     var $addBeforeThreadTitle = null ;
     var $imgBeforeThreadTitle = null ;
     var $txtBeforeThreadTitle = null ;
        
     var $id = false;
     var $header_id = false;
     var $both = false;
     var $header_both = false;
        
/*     var $wThreadtitle = get_awcsforum_word('thread_title');
     var $wReplies = get_awcsforum_word('word_replies');
     var $wViews = get_awcsforum_word('views');
     var $wLastAction = get_awcsforum_word('last_action');*/
     
     
/*        
     var $header_classThreadtitle = 'usermessage';
     var $header_classReplies = 'usermessage';
     var $header_classViews = 'usermessage';
     var $header_classLastAction = 'usermessage';
        
     var $header_idThreadtitle = '';
     var $header_idReplies = '';
     var $header_idViews = '';
     var $header_idLastAction = '';
        
     var $header_styleThreadtitle = '';
     var $header_styleReplies = '';
     var $header_styleViews = '';
     var $header_styleLastAction = '';
        
     var $classThreadtitle = 'toccolours';
     var $classReplies = 'toccolours';
     var $classViews = 'toccolours';
     var $classLastAction = 'toccolours';
        
     var $idThreadtitle = 'toccolours';
     var $idReplies = 'toccolours';
     var $idViews = 'toccolours';
     var $idLastAction = 'toccolours';
        
     var $styleThreadtitle = '';
     var $styleReplies = '';
     var $styleViews = '';
     var $styleLastAction = '';
*/

     
    function __construct() {
    global $awcUser, $wgUser, $awcs_forum_config;
    global $wgShowSQLErrors, $wgTitle, $tplt, $perm_sql;
    
    static $already_here;
    
        self::get_url();
        if($already_here == 'yes') return ;
        $already_here = 'yes';
        
        global $wgCachePages;
        $wgCachePages = false;
            
        require_once(awc_dir . "includes/funcs.php");
        require_once(awc_dir . "includes/gen_class.php");
        require_once(awc_dir . "includes/perm_checks.php");
        
        
        if(!isset($awcUser)){
            $awcUser = new awcs_forum_user(); // gen_class.php   - call this first, forum_config/lang needs info from here
        }
        
        
       // if(!isset($awcs_forum_config)) {
            $awcs_forum_config = new awcs_forum_config();  // gen_class.php
            $awcs_forum_config->get_config();
      //  }
      
      
        // Check to see if forum is installed but checking of the Dbase config table is there...
        if(!$awcs_forum_config->installed OR $awcs_forum_config->updating){
            return '';
        }
        
        
    //  Note:
    // This needs to be after the awcs_forum_config()
    // for some reason the unserialize() gets messed you with the default CSS and cant read it correctly
        if(awcs_forum_convert_latin){
            $dbw = wfGetDB( DB_MASTER );
            $dbw->query("SET NAMES latin1");
        }
         
        
        $perm = new awcs_forum_perm_checks();   
        $perm_sql = $perm->cat_forum_sql();
        
       // $awcs_forum_config->get_css();
            
        //self::get_url();
        
        if(!isset($tplt))$tplt = new awcs_forum_skin_templetes(); // ??? error poped up, not sure why...
        
        $tplt->add_tplts(array("'postblocks_threadlisting'",));
        $tplt->add_tplts(array("'poll_display_options'",
                                "'poll_display_results'",
                                "'poll_opt_options'", 
                                "'poll_display_result_bars'", 
                                "'poll_display'",), true);
        
    }
    
    
    function forum_tag($input, $argv){
    global $awc, $showwhat, $awc_lang, $awcs_forum_config, $str_len ;
    global $wgOut, $wgUser, $wgServer, $wgScriptPath, $tplt, $awcsf_wiki_css_set, $words;
    
        if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '<')){ 
               return ;
        }
        
    static $here_count;
    ++$here_count;
       $dbr = wfGetDB( DB_SLAVE );     
            $showall = false;
            
            if($here_count == '1'){
                
                   //  $tplt->add_tplts(array("'postblocks_threadlisting'",), true);
                
                    $awc['link'] = $this->awc_url;
                    
                    if (function_exists('mb_strlen')) {
                           $str_len = 'awc_mbstrlen'  ; 
                    } else {
                           $str_len = 'awcsforum_funcs::awc_strlen' ;
                    }
                    
                   // awcsforum_funcs::get_page_lang(array('lang_txt_tag'));
                    awcs_forum_wfLoadExtensionMessages( 'AWCforum_forum_tag' );
                    $awc_lang['word_last'] = wfMsg('awcsf_word_last');
                    //die(wfMsg('awcsf_thread_title'));
                   // $words->wThreadtitle = wfMsg('awcsf_thread_title');
                  //  $words->wReplies = wfMsg('awcsf_word_replies');
                  //  $words->wViews = wfMsg('awcsf_views');
                  //  $words->wLastAction = wfMsg('awcsf_last_action');
                    
                    //die($this->wThreadtitle);
                    
                    if($awcsf_wiki_css_set != 'yes'){             
                            
                            $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' ); 
                            
                            $res = $dbr->select( 'awc_f_theme_css', 
                                        array( 'css_code, css_att' ), 
                                        "css_thmn_id = {$awcs_forum_config->cf_css_default} AND css_att IN ('.whos_here_row', '.whos_here', '.whos_here_header', '.pagejumps_PostOnForumPage') OR css_section = 'css_poll'",
                                        array(__METHOD__),
                                        array('OFFSET' => 0 , 'LIMIT' => 25)
                                       );
                            
                            $css = '<style type="text/css">';
                            
                            foreach($res as $r){
                                 $css .= "$r->css_att {\n $r->css_code \n} \n";     
                            }
                            
                            $css .= "\n .nothing {font-size: 0%;
                                        margin: .0em;
                                        border: 0;
                                        margin: 0;
                                        padding: 0;
                                        width: 0;}\n";
                            
                            $css .= "</style>\n";
                           #die($css);
                            $wgOut->addScript($css);
                            
                            $awcsf_wiki_css_set = 'yes';
                    }
                    
                    
            }           
            
            $howmanythreads = $awcs_forum_config->cf_forumTag_numthreads ;
            if(isset($argv['num']) AND is_numeric($argv['num'])){
                if($argv['num'] < $howmanythreads){
                    $howmanythreads = $argv['num'];
                } 
            }
            
            $whatforms =  $awcs_forum_config->cf_forumTag_whatforums ;
             
               
            $tag_info = self::default_tag_settings();
            
            $tag_info['howmanythreads'] = $howmanythreads ;
            $tag_info['whatforms'] = $whatforms;

            $s = explode(chr(10), $input);
            
            foreach($s as $k => $v){
                
                $v = trim($v);
                $s_splt = explode('=', $v ) ;
                
                switch($s_splt[0]){
                    
                    case 'showall':
                        $showall = true;
                        $tag_info['showall'] = true;
                    break;
                    
                    case 'idnot_class':
                        $tag_info['id'] = true;
                    break;
                    
                    case 'header_idnot_class':
                        $tag_info['header_id'] = true;
                    break;
                    
                    case 'classandid':
                        $tag_info['both'] = true;
                    break;
                    
                    case 'header_classandid':
                        $tag_info['header_both'] = true;
                    break;
                              
                    case 'inline':
                        $tag_info['inline'] = true; 
                    break;
                    
                    case 'imgBeforeThreadTitle':
                        $tag_info['imgBeforeThreadTitle'] = '<img src="' . $s_splt[1] . '" border="0">';
                    break;
                    
                    default;
                        if(isset($s_splt[0]) AND isset($s_splt[1])) $tag_info[trim($s_splt[0])] = trim($s_splt[1]);
                    break;
                
                }
               
                
            }
            
            
    		$awc_f_forums = $dbr->tableName( 'awc_f_forums' );
    		
              $html = null;
             if(isset($argv['id']) AND is_numeric($argv['id'])){
                // awc_pdie($tag_info);
                    $tag_info['forum'] = null;
                    //$whatforums = explode(',', $argv);
                    $tag_info['forum'] .= ' AND '. $awc_f_forums .'.f_id IN (' . implode(',', $argv) .  ')'; 
                    //if($tag_info['whatforms'] == '' | $tag_info['whatforms'] == '0') $tag_info['forum'] = null;
                    $html = self::GetForumDisplayInfo($tag_info);
             } elseif($showall){
                $tag_info['forum'] = null;
                $whatforums = explode(',', $tag_info['whatforms']);
                $tag_info['forum'] .= ' AND '. $awc_f_forums .'.f_id IN (' . $tag_info['whatforms'] .  ')'; 
                if($tag_info['whatforms'] == '' | $tag_info['whatforms'] == '0') $tag_info['forum'] = null;
                $html = self::GetForumDisplayInfo($tag_info);
             }else {
                 $whatforums = explode(',', $tag_info['whatforms']);
                 foreach($whatforums as $num){
                        $tag_info['forum'] = ' AND '. $awc_f_forums .'.f_id=' . $num .  ' ';
                        $html .= self::GetForumDisplayInfo($tag_info);
                 }
             }
             # die($html);
             $html = substr($html,0, strlen($html) - 2);
            # if(strlen($html) > 0 ) $input = null; 
            # $html = $wgOut->parse($html);
            
            return  $html ;
    
    
    }
    
    function GetForumDisplayInfo($info){
    global $awc, $wgOut, $awcs_forum_config, $str_len, $forum, $perm_sql;
     
     $thread_tools = new awcs_forum_thread_list_tools();
        
            if($info['both']){
                $info['classThreadtitle'] = 'class="'.$info['classThreadtitle'].'" id="'.$info['idThreadtitle'].'"';
                $info['classReplies'] = 'class="'.$info['classReplies'].'" id="'.$info['idReplies'].'"';
                $info['classViews'] = 'class="'.$info['classViews'].'" id="'.$info['diViews'].'"';
                $info['classLastAction'] = 'class="'.$info['classLastAction'].'" id="'.$info['idLastAction'].'"';
           } elseif(!$info['id']) {
                $info['classThreadtitle'] = 'class="'.$info['classThreadtitle'].'"';
                $info['classReplies'] = 'class="'.$info['classReplies'].'"';
                $info['classViews'] = 'class="'.$info['classViews'].'"';
                $info['classLastAction'] = 'class="'.$info['classLastAction'].'"';
            }else{
                $info['classThreadtitle'] = 'id="'.$info['idThreadtitle'].'"';
                $info['classReplies'] = 'id="'.$info['idReplies'].'"';
                $info['classViews'] = 'id="'.$info['idViews'].'"';
                $info['classLastAction'] = 'id="'.$info['idLastAction'].'"';
            }
       
       # die(">". $UserPerm);
        $dbr = wfGetDB( DB_SLAVE );
        
        $permsql = substr($perm_sql, 0, -4); 
        
       // if(strlen($info['forum']) > 0) $permsql = substr($permsql, 0, -4);
        $info['forum'] = substr($info['forum'], 4, strlen($info['forum']));
        
        if(strlen($info['forum']) > 0 AND strlen($permsql) > 0) $permsql .= ' AND ';
        
            $awc_f_threads = $dbr->tableName( 'awc_f_threads' );
            $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
            $awc_f_cats = $dbr->tableName( 'awc_f_cats' );
            $awc_f_posts = $dbr->tableName( 'awc_f_posts' );  
            
            $sql = "SELECT $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_desc, $awc_f_forums.f_id, $awc_f_forums.f_parentid, $awc_f_cats.cat_name, $awc_f_cats.cat_id, $awc_f_cats.c_wiki_perm
                        FROM $awc_f_threads
                        INNER JOIN $awc_f_forums
                            ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                        INNER JOIN $awc_f_cats
                            ON $awc_f_cats.cat_id=$awc_f_forums.f_parentid
                        WHERE $permsql 
                         ".$info['forum']." AND $awc_f_forums.f_passworded = 0
                        ORDER BY $awc_f_threads.t_lastdate DESC
                        LIMIT " . $info['howmanythreads'];
            
          #  die(">".$permsql);

            /*  
               * GROUP BY $awc_f_threads.t_id
               *  
              
            $sql = "SELECT $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_desc, $awc_f_forums.f_id, $awc_f_forums.parent_id, $awc_f_cats.cat_name, $awc_f_cats.cat_id, $awc_f_cats.c_wiki_perm
                        FROM $awc_f_threads
                        INNER JOIN $awc_f_forums
                            ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                        INNER JOIN $awc_f_cats
                            ON $awc_f_cats.cat_id=$awc_f_forums.parent_id
                        WHERE $permsql 
                         ".$info['forum']." AND $awc_f_forums.f_passworded = 0
                        GROUP BY $awc_f_threads.t_id
                        ORDER BY $awc_f_threads.t_lastdate DESC
                        LIMIT " . $info['howmanythreads'];
                        
                        
                        
                        
       
       
       
          $sql = $dbr->selectSQLText( array( 'awc_f_threads', 'awc_f_posts', 'awc_f_forums', 'awc_f_cats' ), 
                   array( "$awc_f_posts.*, $awc_f_threads.*, f_name, f_desc, f_id, parent_id, cat_name, cat_id" ),
                    "$permsql ".$info['forum']." AND f_passworded = 0", 
                   __METHOD__, 
                   array('OFFSET' => 0, 
                   		 'LIMIT' => $info['howmanythreads'], 
                   		 'GROUP BY' => 't_id',
                   		 'ORDER BY' => 't_lastdate DESC, p_id DESC',),
                   array( 'awc_f_posts' => array('JOIN','t_id=thread_id'),
       						'awc_f_forums' => array('JOIN','t_forumid=f_id'),
       						'awc_f_cats' => array('JOIN','parent_id=cat_id'))
                    );

            */        
         if(strlen($info['forum']) == 0 AND strlen($permsql) == 0) $sql = str_replace('WHERE', '', $sql);
         
                     //  awc_pdie($sql);
              
        $html = null;
        $singleline = null;
        if($res = $dbr->query($sql)){    
            while ($r = $dbr->fetchObject( $res )) {
                    $f_name = $r->f_name ;
                    $f_id = $r->f_id;
                    
                    $tTitle = awcsforum_funcs::awc_html_entity_decode($r->t_name);
                    $str_len($tTitle) > $awcs_forum_config->cf_forumTag_titlecutoff ? $t_name = awcsforum_funcs::awc_shorten($tTitle, $awcs_forum_config->cf_forumTag_titlecutoff ) . "..." : $t_name = $tTitle  ; 
            
                    $tmp = $info['imgBeforeThreadTitle'] . ' ' . $info['txtBeforeThreadTitle'] . ' <a href="' . $awc['link'] . 'st/id' . $r->t_id . '">' . $t_name . '</a>';
                   
                   $limit = null;
                   #$total['TotalPosts'] = null;
                   $send['t_topics'] = $r->t_topics;
                   $send['t_id'] = $r->t_id;
                   $send['t_name'] = $r->t_name;
                   $send['link'] = $this->awc_url;
                   
                   $t = null;

                            if ($r->t_ann == "1") {
                                $t = get_awcsforum_word('thread_makeAnnouncement') . " " ;
                            } 
                                                
                            if ($r->t_status == "1"){
                                $t = get_awcsforum_word('1indicator_locked') . " " ; 
                            }
                                 
                            if ($r->t_pin == "1"){
                                $t = get_awcsforum_word('1indicator_sticky') . " " ;
                            }
                                            
                            if ($r->t_pin == "1" AND $r->t_status == "1"){
                                $t = get_awcsforum_word('1indicator_lockSticky') . " " ;
                            }
                            
                            if ($r->t_poll == "1"){
                                $t = get_awcsforum_word('1indicator_poll') . " " ;
                            }
                  # $TotalPosts = $tmp['TotalPosts'];
                  # $limit = GetLimit($TotalPosts);
                    $thread_tools->link = $this->awc_url;
                    $thread_tools->tID = $r->t_id;
                    $thread_tools->total_posts = $r->t_topics;
                    $limit = $thread_tools->GetThreadPostLimit();
                    
                   //$limit = GetThreadPostLimit($send);

                   $tmp = $t . $tmp . ' ' . $limit;
                   
                   # die($awc['link']);
                    $html .= '<tr>';
                    $html .= '<td width="100%" '.$info['classThreadtitle'].' style="'.$info['styleThreadtitle'].'" nowrap>'.$tmp.'</td>';
                    
                    $singleline .= '<tr><td width="100%" '.$info['classThreadtitle'].' style="'.$info['styleThreadtitle'].'" >';
                    $singleline .=  $tmp ;
                    
                   # $singleline .= ;
                    if($info['replies'] == "yes") {
                        $html .= '<td '.$info['classReplies'].' style="'.$info['styleReplies'].'" nowrap>'. $r->t_topics .'</td>';
                        $singleline .= ' <SPAN STYLE="'.$info['styleReplies'].'"> (' . $r->t_topics . ' ' . $info['wReplies'] . ') </SPAN>' ;
                    }
                    if($info['postcount'] == "yes") {
                        $html .= '<td '.$info['classViews'].' style="'.$info['styleViews'].'" nowrap>'. $r->t_hits .'</td>';
                        $singleline .= ' <SPAN STYLE="'.$info['styleViews'].'"> (' . $r->t_hits . ' ' . $info['wViews'] . ') </SPAN>  ' ;
                    }
                    
                    if($info['date'] == "yes" || $info['users'] == "yes"){
                        $u = ($r->t_lastuser == '') ? $r->p_user : $r->t_lastuser;
                        $uID = ($r->t_lastuser == '') ? $r->p_userid : $r->t_lastuserid;
                        
                        #$u = $wgOut->parse("[[User:$u|$u]]");
                        $u = "<a href='". $awc['link'] ."mem_profile/{$u}/{$uID}'>$u</a>";
                       
                        $rplac = array('<p>', '</p>', chr(10));
                        $u = str_replace($rplac, '', $u);
                        $u = ($info['users'] == "yes") ?  ' - ' . $u : null ;
                        
                        $d = ($info['date'] == "yes") ?  '<a href="' . $awc['link'] . 'last_post/id' . $r->t_id . '"> '. awcsforum_funcs::convert_date($r->t_lastdate, "s").' </a>' . ' ' :  null ;
                        
                        $html .= '<td '.$info['classLastAction'].' style="'.$info['styleLastAction'].'" nowrap>'. $d . $u .'</td>';
                        $singleline .= ' <SPAN STYLE="'.$info['styleLastAction'].'"> (' . $d . $u . ') </SPAN><td></tr>' ;
                    }
                    $html .= '</tr>';
                
            }
            $dbr->freeResult( $res );
        }
        
        if($f_name == '') return ;
        
        
            if($info['header_both']){
                $info['classThreadtitle'] = 'class="'.$info['header_classThreadtitle'].'" id="'.$info['header_idThreadtitle'].'"';
                $info['classReplies'] = 'class="'.$info['header_classReplies'].'" id="'.$info['header_idReplies'].'"';
                $info['classViews'] = 'class="'.$info['header_classViews'].'" id="'.$info['header_diViews'].'"';
                $info['classLastAction'] = 'class="'.$info['header_classLastAction'].'" id="'.$info['header_idLastAction'].'"';
           } elseif(!$info['header_id']) {
                $info['classThreadtitle'] = 'class="'.$info['header_classThreadtitle'].'"';
                $info['classReplies'] = 'class="'.$info['header_classReplies'].'"';
                $info['classViews'] = 'class="'.$info['header_classViews'].'"';
                $info['classLastAction'] = 'class="'.$info['header_classLastAction'].'"';
            }else{
                $info['classThreadtitle'] = 'id="'.$info['header_idThreadtitle'].'"';
                $info['classReplies'] = 'id="'.$info['header_idReplies'].'"';
                $info['classViews'] = 'id="'.$info['header_idViews'].'"';
                $info['classLastAction'] = 'id="'.$info['header_idLastAction'].'"';
            }
         
         $out = null;   
        if($info['showall'] == false) $out = '<table width="'.$info['width'].'" cellpadding="0" cellspacing="0"><tr><td nowrap><a href="' . $awc['link'] . 'sf/id' . $f_id . '">' . $f_name . '</a><hr></td></tr></table>' ;
        $out .= '<table width="'.$info['width'].'" cellpadding="2" cellspacing="0">' ;
        $out .= '<tr>';
        
        $singleline_out = '<table width="'.$info['width'].'" cellpadding="2" cellspacing="0"><tr>' ;
        
        $out .= '<td width="75%" align="left" class="'.$info['header_classThreadtitle'].'" style="'.$info['header_styleThreadtitle'].'" nowrap>'.$info['wThreadtitle'].'</td>';
        if($info['replies'] == "yes") {
            $out .= '<td width="1%" align="left" class="'.$info['header_classReplies'].'" style="'.$info['header_styleReplies'].'" nowrap>'.$info['wReplies'].'</td>';
            
        }
        if($info['postcount'] == "yes") $out .= '<td width="1%" align="left" class="'.$info['header_classViews'].'" style="'.$info['header_styleViews'].'" nowrap>'.$info['wViews'].'</td>';
        #if($info['users'] == true) $out .= '<td width="1%" align="left" nowrap>'.get_awcsforum_word('forum_started_by').'</td>';
        if($info['date'] == "yes" || $info['users'] == "yes") $out .= '<td width="20%" align="left" class="'.$info['header_classLastAction'].'" style="'.$info['header_styleLastAction'].'" nowrap>'.$info['wLastAction'].'</td>';
       
        $out .= '</tr>';
        
        $out .= $html ;
        $out .= '</table><br />';
        
         $singleline_out = '<table width="'.$info['width'].'" cellpadding="2" cellspacing="0">' ;
         $singleline_out .= $singleline;
         $singleline_out .= '</table><br />';
         
         $out = str_replace(chr(10), '', $out);
         $singleline_out = str_replace(chr(10), '', $singleline_out);
         
        if ($info['inline']) return $singleline_out ;
        
        
        
        return $out ;

    }
    
    function default_tag_settings(){

        $tag_info['width'] = '100%';
        $tag_info['date'] = "yes";
        $tag_info['replies'] = "yes";
        $tag_info['postcount'] = "yes";
        $tag_info['users'] ="yes";
        
        $showall = false;
        $tag_info['showall'] = false;
        $tag_info['inline'] = false;
        
        $tag_info['addBeforeThreadTitle'] = null ;
        $tag_info['imgBeforeThreadTitle'] = null ;
        $tag_info['txtBeforeThreadTitle'] = null ;
        
        $tag_info['id'] = false;
        $tag_info['header_id'] = false;
        $tag_info['both'] = false;
        $tag_info['header_both'] = false;
        
        $tag_info['wThreadtitle'] = wfMsg('awcsf_thread_title');
        $tag_info['wReplies'] = wfMsg('awcsf_word_replies');
        $tag_info['wViews'] = wfMsg('awcsf_views');
        $tag_info['wLastAction'] = wfMsg('awcsf_last_action');
        
        $tag_info['header_classThreadtitle'] = 'usermessage';
        $tag_info['header_classReplies'] = 'usermessage';
        $tag_info['header_classViews'] = 'usermessage';
        $tag_info['header_classLastAction'] = 'usermessage';
        
        $tag_info['header_idThreadtitle'] = '';
        $tag_info['header_idReplies'] = '';
        $tag_info['header_idViews'] = '';
        $tag_info['header_idLastAction'] = '';
        
        $tag_info['header_styleThreadtitle'] = '';
        $tag_info['header_styleReplies'] = '';
        $tag_info['header_styleViews'] = '';
        $tag_info['header_styleLastAction'] = '';
        
        $tag_info['classThreadtitle'] = 'toccolours';
        $tag_info['classReplies'] = 'toccolours';
        $tag_info['classViews'] = 'toccolours';
        $tag_info['classLastAction'] = 'toccolours';
        
        $tag_info['idThreadtitle'] = 'toccolours';
        $tag_info['idReplies'] = 'toccolours';
        $tag_info['idViews'] = 'toccolours';
        $tag_info['idLastAction'] = 'toccolours';
        
        $tag_info['styleThreadtitle'] = '';
        $tag_info['styleReplies'] = '';
        $tag_info['styleViews'] = '';
        $tag_info['styleLastAction'] = '';
        
        return $tag_info;
        
    }

    function get_url(){
    global $wgTitle, $wgServer, $wgScriptPath, $awc_url, $wgArticlePath ;
       
        /*
        $wikiurl =   $wgServer . $wgScriptPath . '/';
        
        $url = $wgTitle->getInternalURL();
        $spath = null;
        if(strstr($url,"?")){
            $spath = "index.php?title=";
        }
        if(strstr($url,"/index.php/")){
            $spath = "index.php/";
        }
        
        $this->wiki_url = $wikiurl . $spath ;
        
        $this->wiki_url = awcsf_wiki_url;
        
        */
        
        $this->awc_url = awcsf_wiki_url . "Special:AWCforum/" ;
        $awc_url = $this->awc_url;
        define('awc_url', $this->awc_url); 
    
    }
    
    
    
    function poll($input, $argv){
    
        if(version_compare(awcs_forum_ver_current, awcs_forum_ver, '<')){
               return ;
        }
        
        if(!isset($argv['id']) OR empty($argv['id'])) return true;
        
    static $here_count;
    ++$here_count;
    
        global $awcs_forum_config, $wgOut, $awcUser, $awcsf_wiki_css_set;
    
            if($here_count == '1'){
                    
                global $wgHooks;
                
                    $wgHooks['BeforePageDisplay'][] = 'AWC_FORUMS_POLL_DECODE_BeforePageDisplay';
                    
                    require_once(awc_dir . 'includes/post_phase.php');
                   // awcsforum_funcs::get_page_lang(array('lang_txt_thread')); // get lang difinitions... 
                    awcs_forum_wfLoadExtensionMessages( 'AWCforum_poll_tag' );
                    global $awc_lang;
                    $awc_lang['word_poll_question'] = wfMsg('awcsf_word_poll_question');
                    $awc_lang['word_total_votes'] = wfMsg('awcsf_word_total_votes');
                    $awc_lang['word_votes'] = wfMsg('awcsf_word_votes');
                    $awc_lang['word_total_percent'] = wfMsg('awcsf_word_total_percent');
                    $awc_lang['word_poll_option'] = wfMsg('awcsf_word_poll_option');
                    $awc_lang['word_vote'] = wfMsg('awcsf_word_submit');
                    
                    
                    if($awcsf_wiki_css_set != 'yes'){
                        
                            $dbr = wfGetDB( DB_SLAVE );
                            $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' ); 
                            
                             $sql = "SELECT css_code, css_att
                                FROM $awc_f_theme_css
                                WHERE css_thmn_id = $awcs_forum_config->cf_css_default AND
                                css_att IN ('.whos_here_row', '.whos_here', '.whos_here_header', '.pagejumps_PostOnForumPage') OR
                                css_section = 'css_poll' LIMIT 0,25";
                              
                             // die($sql);          
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
                            
                            $wgOut->addScript($css);
                            
                            $awcsf_wiki_css_set = 'yes';
                    }
                    
                    
            }
        
        $tID =  $argv['id'];
        #$p = new awcs_forum_post_phase();
        $poll = awcs_forum_post_phase::display_poll($tID, null, $awcUser->mId); 
        
        $poll = "@POLL@".base64_encode($poll)."@POLL@";
        
      return $poll;
      
    }
    
    
    
    

}