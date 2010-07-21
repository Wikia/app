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
* @filepath /extensions/awc/forums/search.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

function awcs_forum_search(){

    $search = new awcforum_search();
    $search->enter_search();

}

/* @TODO Work on searching forums sections which are passworded */
class awcforum_search{
    
    var $titlelimit, $ChrLimit, $MemSearch, $search_error;
    var $todo;
    
    var $searchword;
    var $tID = 0 ;
    var $fID = 0 ;
    var $cID = 0 ;
    var $what = null ;
    var $limit ;
    
    function SQL_calls($what){
        
        $perm = new awcs_forum_perm_checks();
        
        
        switch($what){
            
            case '':
            
            break;
        
        
        
        }
        
    
    }
    
    
    function enter_search(){
     global $awcs_forum_config, $wgRequest, $wgOut, $todo, $WhoWhere, $awc_tables, $action_url, $tplt;
     
        $perm = new awcs_forum_perm_checks();
        
       //$WhoWhere = 'search';
       $WhoWhere['type'] =  'forum' ;
       $WhoWhere['where'] =  'search||awc-split||search' ;
       
       Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('search_search'));
       
        $this->titlelimit = ($awcs_forum_config->cfl_ThreadTitleLength - 15);
        $this->ChrLimit = $awcs_forum_config->cf_Search_ChrLimit;
        
        $this->searchword = $wgRequest->getVal('kw');
        
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_threads = $dbr->tableName( 'awc_f_threads' );
        $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
        $awc_f_cats = $dbr->tableName( 'awc_f_cats' );
        $awc_f_posts = $dbr->tableName( 'awc_f_posts' );
            
              #need to do somthing with User topics and posts for URL blocks  
        $action = $wgRequest->action;
        
        $this->todo = $action_url['all'];
        $spl = explode("/", $action_url['all']);
        
        foreach($spl as $k => $value){                        
            if (substr($value , 0, 3) == "kw:") $this->searchword = str_replace('kw:', '', $value);
            if (substr($value , 0, 3) == "tID") $this->tID = str_replace('tID', '', $value);
            if (substr($value , 0, 3) == "fID") $this->fID = str_replace('fID', '', $value);
            if (substr($value , 0, 3) == "cID") $this->cID = str_replace('cID', '', $value);
            if (substr($value , 0, 4) == "what")$this->what = str_replace('what', '', $value);
            if (substr($value , 0, 6) == "limit:")$this->limit = str_replace('limit:', '', $value);
                        
        }
        
        $this->searchword = str_replace(array('[',']','{','}',), '', $this->searchword);
        $this->searchword = strip_tags($this->searchword);

        $todo = isset($spl[1]) ? $spl[1] : '';
        $user = isset($spl[2]) ? $spl[2] : 'NoNameForSearch';
        $user_id = isset($spl[3]) ? $spl[3] : '0';
        
        #die(">". $todo);
        
        define('what_page', $todo );
            
        if($todo == 's_form') return $this->s_form();
        
        # die(">". $todo); 
        if($todo == '') {
             
            $perm_sql =  $perm->forum_sql();
             if(strlen($perm_sql) > 0) $perm_sql = 'WHERE ' . $perm_sql ;
             
             Set_AWC_Forum_SubTitle(get_awcsforum_word('search_search'), get_awcsforum_word('search_search') . ' ' . get_awcsforum_word('search_whatAll')  );
             
             Set_AWC_Forum_BreadCrumbs('', true); 
             
            $tplt->add_tplts(array("'main_search_form'",
                                    "'main_seach_form_forum_drop'",), true );
             
            $words = array();
            $words['search_refine'] = get_awcsforum_word('search_refine') ;
            $words['search_full'] = get_awcsforum_word('search_full') ;
            $words['search_title'] = get_awcsforum_word('search_title') ;
            $words['word_is'] = get_awcsforum_word('word_is') ;
            $words['word_like'] = get_awcsforum_word('word_like') ;
            $words['search_membersname'] = get_awcsforum_word('search_membersname') ;
            $words['search_whatAll'] = get_awcsforum_word('search_whatAll') ;
            $words['search_search'] = get_awcsforum_word('search_search') ;
            
            $to_tplt['search_forums'] = null;
            $dbr = wfGetDB( DB_SLAVE );
            
            if($perm_sql){
            	$perm_sql .= "AND $awc_f_forums.f_passworded = 0";
            } else {
            	#$perm_sql = 'f.f_passworded = 0';
            }
            
            $sql = "SELECT $awc_f_forums.f_id, $awc_f_forums.f_name FROM $awc_f_forums $perm_sql  ORDER BY f_order ";
            $res = $dbr->query($sql);
            while ($r = $dbr->fetchObject( $res )) {
                $info['f_id'] = $r->f_id;
                $info['f_name'] = $r->f_name;
                $to_tplt['search_forums'] .= $tplt->phase('', $info, 'main_seach_form_forum_drop');
            }
            $dbr->freeResult( $res );
            $tplt->kill('main_seach_form_forum_drop');
            unset($res, $sql, $awc_f_forums);
             
            return $wgOut->addHTML($tplt->phase($words, $to_tplt, 'main_search_form',true)); 
        }
        
        
        
        
        if($todo == 'todate'){
             $perm_sql =  $perm->forum_sql();
             if(strlen($perm_sql) > 0) $perm_sql .= ' AND ' ;
             
            $this->total = 0;
            $this->searchword = get_awcsforum_word('word_todatesposts');
            
            $today = awcsforum_funcs::date_seperated(date('Y') . date('m') . date('d') . '000000') ;
           # die($perm_sql);
           
                
                $sql = "SELECT $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_id, $awc_f_forums.f_name, $awc_f_cats.cat_name
                        FROM {$awc_tables['awc_f_threads']}
                            INNER JOIN {$awc_tables['awc_f_forums']}
                        		ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                            INNER JOIN {$awc_tables['awc_f_cats']}
                        		ON $awc_f_forums.f_parentid=$awc_f_cats.cat_id
                        	WHERE $perm_sql $awc_f_threads.t_lastdate > '$today' AND $awc_f_forums.f_passworded = 0
                            ORDER BY $awc_f_threads.t_lastdate DESC";
                
                

              #  die($sql);        
                return $this->q_results($sql, $dbr); 
        }
        
        
        if($todo == 's'){
            
                $kw = $wgRequest->getVal( 'kw' );
                $kw = $this->searchword ;
                
                if($this->searchword == ""){
                    /*
                    $action = $wgRequest->action;
                    $spl = explode("/", $action);
                    foreach($spl as $k => $value){                        
                        if (substr($value , 0, 3) == "kw:") $this->searchword = str_replace('kw:', '', $value);
                        if (substr($value , 0, 3) == "tID") $this->tID = str_replace('tID', '', $value);
                        if (substr($value , 0, 3) == "fID") $this->fID = str_replace('fID', '', $value);
                        if (substr($value , 0, 3) == "cID") $this->cID = str_replace('cID', '', $value);
                        if (substr($value , 0, 4) == "what")$this->what = str_replace('what', '', $value);
                        if (substr($value , 0, 6) == "limit:")$this->limit = str_replace('limit:', '', $value);
                        
                    }
                    */
                }
                
                 $s_check = $this->check_searchword();
                 if(!$s_check)  return $this->search_error ;
                 
                 if($this->what == null) $this->what = $wgRequest->getVal( 'search_what' );
                 
                
                if(strstr($kw,"+") || strstr($kw," AND ")){
                    if(strstr($kw,"+")){
                        $s = $this->CreatePostTitleSearch(explode("+", $kw), 'AND', true);
                    }elseif(strstr($kw," AND ")){
                        $s = $this->CreatePostTitleSearch(explode(" AND ", $kw), 'AND', true);
                    }             
                }elseif(strstr($kw," OR ")){
                    $s = $this->CreatePostTitleSearch(explode(" OR ", $kw), 'OR', true);
                }else{
                    $s = $this->CreatePostTitleSearch($kw);
                }
                
                if($this->tID == 0) $this->tID = $wgRequest->getVal('tID');
                if($this->fID == 0) $this->fID = $wgRequest->getVal('fID');
                if($this->cID == 0) $this->cID = $wgRequest->getVal('cID');
                 
                if($this->what == null) $this->what = $wgRequest->getVal( 'search_what' );
                
                //die(">" . $this->what);
                switch ($this->what){
                
                    case 'c':
                         $s .= " AND $awc_f_forums.f_parentid = " . $this->cID . " ";
                         $cat = true;
                    break;
                    
                    case 'f':
                        $s .= " AND $awc_f_forums.f_id = " . $this->fID . " ";
                        $forum = true;
                    break;
                    
                    case 't':
                        $s .= " AND $awc_f_threads.t_id = " . $this->tID . " ";
                        $thread = true;
                        
                         if($this->what == 't') return $this->q_thread($s, $dbr);
                       # return $this->q_thread();
                    break;
                    
                }
                
                $perm_sql =  $perm->cat_forum_sql();
                //if(strlen($s) > 0) $perm_sql = 'WHERE ' . $perm_sql ;
                                     
                $sql = "SELECT DISTINCT $awc_f_threads.t_id, $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_id, $awc_f_forums.f_name, $awc_f_cats.cat_name
                        FROM {$awc_tables['awc_f_threads']}
                        	INNER JOIN {$awc_tables['awc_f_posts']} awc_f_posts
                        		ON awc_f_posts.p_threadid=$awc_f_threads.t_id
                            INNER JOIN {$awc_tables['awc_f_forums']} 
                        		ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                            INNER JOIN {$awc_tables['awc_f_cats']} 
                        		ON $awc_f_forums.f_parentid=$awc_f_cats.cat_id
                        	WHERE $perm_sql $s AND $awc_f_forums.f_passworded = 0
                            ORDER BY $awc_f_threads.t_lastdate DESC";
		        
		        
		        return $this->q_results($sql, $dbr); 
        
        }
        
        $perm = new awcs_forum_perm_checks();
        $perm_sql =  $perm->cat_forum_sql();
        # die($todo);
        switch ($todo){
            
            case 'memtopics':
                $this->MemSearch = $user . ' ' . get_awcsforum_word('word_topics');
                
                $sql = "SELECT $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_id, $awc_f_forums.f_name, $awc_f_cats.cat_name
                        FROM {$awc_tables['awc_f_threads']}
                            INNER JOIN {$awc_tables['awc_f_forums']}
                        		ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                            INNER JOIN {$awc_tables['awc_f_cats']} 
                        		ON $awc_f_forums.f_parentid=$awc_f_cats.cat_id
                        	WHERE $perm_sql $awc_f_threads.t_starterid=$user_id AND $awc_f_forums.f_passworded = 0
                            ORDER BY $awc_f_threads.t_lastdate DESC";
                break;
        
            case 'memposts':
                $this->MemSearch = $user . ' ' . get_awcsforum_word('word_posts');
                
                	$sql = "SELECT DISTINCT $awc_f_threads.t_id, $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_id, $awc_f_forums.f_name, $awc_f_cats.cat_name
                        FROM {$awc_tables['awc_f_threads']}
                        	INNER JOIN {$awc_tables['awc_f_posts']} awc_f_posts
                        		ON awc_f_posts.p_threadid=$awc_f_threads.t_id
                            INNER JOIN {$awc_tables['awc_f_forums']}
                        		ON $awc_f_threads.t_forumid=$awc_f_forums.f_id
                            INNER JOIN {$awc_tables['awc_f_cats']}
                        		ON $awc_f_forums.f_parentid=$awc_f_cats.cat_id
                        	WHERE $perm_sql (awc_f_posts.p_threadid=$awc_f_threads.t_id) AND (awc_f_posts.p_userid=$user_id AND awc_f_posts.p_thread_start!=1) AND $awc_f_forums.f_passworded = 0
                            ORDER BY $awc_f_threads.t_lastdate DESC";
                
                break;
                
            case 'recent':
            $this->total = 0;
            $this->searchword = get_awcsforum_word('word_recent_posts');
            
              //  die(awcsforum_funcs::date_seperated($_SESSION['awc_startTime']));
              
                    $sql = "SELECT $awc_f_threads.*, $awc_f_forums.f_name, $awc_f_forums.f_desc, $awc_f_forums.f_id, $awc_f_forums.f_parentid, $awc_f_cats.cat_name, $awc_f_cats.cat_id
                            FROM {$awc_tables['awc_f_threads']},
                                {$awc_tables['awc_f_forums']},
                                {$awc_tables['awc_f_cats']}
                            WHERE $perm_sql
                                $awc_f_cats.cat_id=$awc_f_forums.f_parentid AND $awc_f_forums.f_passworded = 0 AND
                                $awc_f_forums.f_id=$awc_f_threads.t_forumid AND 
                                $awc_f_threads.t_lastdate >= '". awcsforum_funcs::date_seperated($_SESSION['awc_startTime']) ."' 
                            ORDER BY $awc_f_threads.t_lastdate DESC, $awc_f_threads.t_name DESC";
                          
                          //  die($sql);
                              
            break;
        
        }
        
        return $this->q_results($sql, $dbr); 
        
    }
    
    function s_form(){
    global $wgOut, $LimitJump, $first_return, $wgRequest, $kw, $awc_tables;
    
    #die(">".  print_r( $_POST['fID[]'] ) );
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_threads = $dbr->tableName( 'awc_f_threads' );
        $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
        $awc_f_cats = $dbr->tableName( 'awc_f_cats' );
        $awc_f_posts = $dbr->tableName( 'awc_f_posts' );
        
        
        $kw = $wgRequest->getVal( 'kw' );
        $this->searchword = $kw; 
         
        $s_check = $this->check_searchword();
        if(!$s_check)  return $this->search_error ;
        
        $perm = new awcs_forum_perm_checks();
        $perm_sql =  $perm->cat_forum_sql();
        
        
        $wgRequest->getVal('Sis_like') == 'is' ? $Sis_like = '=' : $Sis_like = '' ;
        $wgRequest->getVal('full') == 'full' ? $full = '1' : $full = '0' ;
        
       # die(">". $Sis_like);
        
                if(strstr($kw,"+") || strstr($kw," AND ")){
                    if(strstr($kw,"+")){
                        $s = $this->CreatePostTitleSearch(explode("+", $kw), 'AND', true, $Sis_like, $full);
                    }elseif(strstr($kw," AND ")){
                        $s = $this->CreatePostTitleSearch(explode(" AND ", $kw), 'AND', true, $Sis_like, $full);
                    }             
                }elseif(strstr($kw," OR ")){
                    $s = $this->CreatePostTitleSearch(explode(" OR ", $kw), 'OR', true, $Sis_like, $full);
                }else{
                    $s = $this->CreatePostTitleSearch($kw,'','',$Sis_like, $full);
                }
                
                 
        $forums_to_search = '';
        foreach ( $_POST['fID'] as $fid ) {
             if($fid == 'all'){
                 $forums_to_search = null;
                 break;
                
             }
             $forums_to_search .= "$awc_f_forums.f_id=$fid OR ";
             
        }
        
        if($forums_to_search != null){
           $forums_to_search = ' AND (' . substr($forums_to_search , 0, strlen($forums_to_search) -4) . ')';
        }
        
	 $mem = ($wgRequest->getVal('is_like') == 'is') ? ' AND '.$awc_f_posts.'.p_user = \'' . $wgRequest->getVal('memname') . '\'' : ' AND '.$awc_f_posts.'.p_user LIKE \'%' . $wgRequest->getVal('memname') . '%\'' ; 
 
      $mem_search = '';
      $wgRequest->getVal('s_memposts') == 'on' AND $wgRequest->getVal('memname') != '' ? $mem_search =  $mem : $mem_search = '';
 
 
      $s .= $forums_to_search . $mem_search ;
      $s = substr($s , 4, strlen($s)) ;
 
   # die(">". $s);  
 
                 $sql = "SELECT DISTINCT {$awc_tables['awc_f_threads']}.t_id, {$awc_tables['awc_f_threads']}.*, $awc_f_posts.p_user, $awc_f_forums.f_name, $awc_f_forums.f_id, $awc_f_forums.f_name, $awc_f_cats.cat_name
                        FROM {$awc_tables['awc_f_threads']}
                        	INNER JOIN {$awc_tables['awc_f_posts']} awc_f_posts
                        		ON awc_f_posts.p_threadid={$awc_tables['awc_f_threads']}.t_id
                            INNER JOIN {$awc_tables['awc_f_forums']}
                        		ON {$awc_tables['awc_f_threads']}.t_forumid=$awc_f_forums.f_id
                            INNER JOIN {$awc_tables['awc_f_cats']}
                        		ON $awc_f_forums.f_parentid=$awc_f_cats.cat_id
                        	WHERE $perm_sql $s AND $awc_f_forums.f_passworded = 0
                            ORDER BY {$awc_tables['awc_f_threads']}.t_lastdate DESC";         
                           
                       //  die($sql);
                return $this->q_results($sql, $dbr);
        
    
    
    }
    
    function check_searchword(){
    global $kw, $awc, $wgOut;
                 
                 $no_search = array();
                 require(awc_dir . 'config/no_search.php');
                 foreach($no_search as $clear_word){
                    $this->searchword = str_replace($clear_word, "", $this->searchword);
                 }
                 
                 
                 if(strlen($this->searchword) < $this->ChrLimit){
                      $er = '';
                     foreach($no_search as $clear_word){
                        $er .= $clear_word . "<br />";
                     }
                     $er .= '';
                     
                    Set_AWC_Forum_SubTitle(get_awcsforum_word('search_word_to_short') . ' ' . $this->ChrLimit  );
                    
                        Set_AWC_Forum_BreadCrumbs($this->searchword, true); 
                        
                      $this->search_error = $wgOut->addHTML('<hr>' . get_awcsforum_word('search_word_to_short') . ' ' . $this->ChrLimit . '<hr>' . '<br />' . get_awcsforum_word('search_omitted_words') . '<hr>' . $er);
                     unset($no_search);
                    return false;
                 }
                 unset($no_search);
                 
                 $this->searchword =   str_replace('_', ' ', $this->searchword) ;
                 $kw = strip_tags($this->searchword);
                 $kw = awcsforum_funcs::awc_htmlentities($kw);
                 
                 
        return true;
    }
    
function CreatePostTitleSearch($sWords, $what='', $morethenword=false, $isORlike='', $full='1'){
global $awc_tables;

        $p='';
        $t='';
        $s='';
        if($morethenword) {
                  #$mWords = explode("+", $kw);  
                    
                  foreach($sWords as $w){
                    # die('>' . print_r($w));
                    $p .= " $what awc_f_posts.p_post LIKE '%" . trim($w) . "%'";
                    $t .= " $what {$awc_tables['awc_f_threads']}.t_name LIKE '%" . trim($w) . "%'";
                  }
                 
                $p = trim($p);
                $p = substr($p,3,strlen($p));
                $p = "($p)";
                
                $t = trim($t);
                $t = substr($t,3,strlen($t));
                $t = "($t)";
                # die(' AND (' . $p . ' OR ' . $t . ')');
                
                $return = ' AND (' . $p . ' OR ' . $t . ')';
                if($full == '0' ) $return = ' AND (' . $t . ')';
                if($this->what == 't') $return = ' AND (' . $p . ')';
               
                
                if($isORlike == '=') {
                    $return = str_replace("LIKE '%", "='", $return);
                    $return = str_replace("%'", "'", $return);
                }
                
                return $return ;
        
        } else {
            $p .= " awc_f_posts.p_post LIKE '%" . trim($sWords) . "%'";
            $t .= " {$awc_tables['awc_f_threads']}.t_name LIKE '%" . trim($sWords) . "%'";
            
            $return = ' AND (' . $p . ' OR ' . $t . ')';
            if($full == '0' ) $return = ' AND (' . $t . ')';
            if($this->what == 't') $return = ' AND (' . $p . ')';
                
                if($isORlike == '=') {
                    $return = str_replace("LIKE '%", "='", $return);
                    $return = str_replace("%'", "'", $return);
                }
                
               
            return $return;
            
        }
        
        return ;
        

} 
    
    
    function q_results($sql, $dbr){
    global $wgOut, $LimitJump_top, $LimitJump_bot, $first_return, $todo, $tplt, $awcUser;
    
    
        $thread_tools =  New awcs_forum_thread_list_tools();
        $thread_tools->extra_column = true;
        
        
        $word_headers = array('replies' => get_awcsforum_word('word_replies'),
                        'views' => get_awcsforum_word('views'),
                        'last_action' => get_awcsforum_word('last_action'),
                        'started_by' => get_awcsforum_word('thread_title_started_by'), );
                        
        
        
         $word = array('started_by' => get_awcsforum_word('forum_started_by'), );
       
       
        $sql = str_replace('AND   AND', ' AND ', $sql);
        $sql = str_replace('WHERE   AND', 'WHERE ', $sql);
        
       # die($sql);
        $res = $dbr->query($sql);
            $r = $dbr->fetchRow( $res );
            $total = $dbr->numRows($res);
        $dbr->freeResult( $res );
        
            $this->total = $total;
            $send['TotalPosts'] = $total;
        $limit = GetLimit($send, 'search');
        
        
        $i = 0;
        $tmp='';
        
        $dbr = wfGetDB( DB_SLAVE ); 
        
        #awcsforum_funcs::limitSplit($limit);
        #die($limit);
        #$res = $dbr->query($sql . ' ' . $limit);
        require_once( awc_dir . 'dBase.php' );
        $dbase = new awcforum_cls_dBase();
        $limit = $dbase->limit($limit);
        
        $res = $dbr->query("{$sql} {$limit}");
        while ($r = $dbr->fetchObject( $res )) {
       // ++$i; 
        
        
            $to_skin = $thread_tools->loop_thread_list($r);
            
            $e['NewPost'] = $thread_tools->new_thread_check($r->t_id, $r->t_lastdate) ;
                  
          if ($todo == 'recent') {
              
              
               if (isset($e['NewPost']) AND strlen($e['NewPost']) > 0 ) {
                    ++$i;
                        
                        
                        $thread_tools->link = awc_url;
                        $thread_tools->tID = $r->t_id;
                        $thread_tools->total_posts = $r->t_topics;
                        
                        $to_skin['search_words'] = ''; 
                           
                        $tmp .= $tplt->phase($word, $to_skin, 'thread_list_rows'); 
                                         
                    }
                

                
              } else {
                    ++$i;
                    
                        $thread_tools->link = awc_url;
                        $thread_tools->tID = $r->t_id;
                        $thread_tools->total_posts = $r->t_topics;
                        
                        $to_skin['search_words'] = ''; 
                        
                        $tmp .= $tplt->phase($word, $to_skin, 'thread_list_rows');
              }
            
            unset($e);
        }
        $dbr->freeResult( $res );
        
        if($LimitJump_top){
            
                #kw
                $tID = isset($this->tID) ? '/tID' . $this->tID : null;
                $fID = isset($this->fID) ? '/fID' . $this->fID : null;
                $cID = isset($this->cID) ? '/cID' . $this->cID : null;
                $what = isset($this->what) ? '/what' . $this->what : null;
                $this->searchword = str_replace(' ', '_', $this->searchword) ;
               # die($LimitJump);
               # $this->fID = $wgRequest->getVal('fID');
               # $this->cID = $wgRequest->getVal('cID');
               # $LimitJump = $LimitJump . "/kw:$this->searchword$tID$fID$cID";
               # die(">". print_r($LimitJump) );
            if($first_return){
                 $LimitJump_bot = str_replace('limit:', "kw:$this->searchword$tID$fID$cID$what" .'/limit:' , $LimitJump_bot) ;
                 $LimitJump_top = str_replace('limit:', "kw:$this->searchword$tID$fID$cID$what" .'/limit:' , $LimitJump_top) ;
            
            }
             $LimitJump = '<tr><td width="100%" colspan="6" align="right" class="page_jumps_holderBot">'. $LimitJump_bot .'</td></tr>';
        } else {
            $LimitJump_top = null;
            $LimitJump = null;
        }
        

        
        $to_tplt['col_5_isSearch_forum_name'] = '<td class="thread_col_head" width="20%" align="center" nowrap="nowrap">'.get_awcsforum_word('word_forum').'</td>';
        $to_tplt['tr_id'] = '';
        $to_tplt['first_col_name'] = get_awcsforum_word('thread_title');
        $html = $tplt->phase($word_headers, $to_tplt, 'thread_list_header');
        
        
        $html .= $tmp . $LimitJump ;
        
        $html .= '</table>';
           
        
        if(!$this->searchword) $this->searchword = $this->MemSearch;
        $end ='';
        if($this->what == 'c') $end = ', ' . get_awcsforum_word('word_inCat') . ' ' . $cat_name . '' ;
        if($this->what == 'f') $end = ', ' . get_awcsforum_word('word_inForum') . ' ' . $cat_name . '/' . $forum_name . '' ;
        if($this->what == 't') $end = ', ' . get_awcsforum_word('word_inThread') . ' ' . $thread_name ;
        $title = str_replace("|$|", $i, get_awcsforum_word('search_SearchResultsFound'))  . ": $this->searchword" . $end ;
       /*
       broken...
       $read_threads = (isset($_SESSION['awc_rActive'])) ? count($_SESSION['awc_rActive']) : 0;
       if($this->todo == 'search/recent/') $this->total = ($this->total - $read_threads) ;
       */
       if($this->todo == 'search/recent/') $this->total = '';
        Set_AWC_Forum_SubTitle('(' . $this->total . ') ' . get_awcsforum_word('search_SearchResults'), $title  );
        
        Set_AWC_Forum_BreadCrumbs($this->searchword, true); 
        
       # $str = $wgOut->parse($html);
        $wgOut->addHTML($html);
        return;
    
    }
    
    function q_thread($s, $dbr){
    global $awc, $wikieits, $total_thread_count, $thread_title_for_search, $awc_tables, $tplt;
    
        $perm = new awcs_forum_perm_checks();
        $perm_sql =  $perm->forum_sql();
       // if(strlen($s) > 0 AND strlen($perm_sql) > 0) $perm_sql .= ' AND ' ;
       
                    
                    $sql = "SELECT awc_f_posts.p_id, awc_f_posts.p_title, awc_f_posts.p_post, awc_f_posts.p_user, awc_f_posts.p_userid, awc_f_posts.p_editwhy, awc_f_posts.p_editwho, awc_f_posts.p_editdate, awc_f_posts.p_date,
                {$awc_tables['awc_f_threads']}.t_id, {$awc_tables['awc_f_threads']}.t_ann, {$awc_tables['awc_f_threads']}.t_pin, {$awc_tables['awc_f_threads']}.t_status, {$awc_tables['awc_f_threads']}.t_name, {$awc_tables['awc_f_threads']}.t_topics, {$awc_tables['awc_f_threads']}.t_hits, {$awc_tables['awc_f_threads']}.t_perm, {$awc_tables['awc_f_threads']}.t_poll, {$awc_tables['awc_f_threads']}.t_wiki_pageid, {$awc_tables['awc_f_threads']}.t_lastdate, 
                {$awc_tables['awc_f_forums']}.f_posting_mesage_tmpt, {$awc_tables['awc_f_forums']}.f_name, {$awc_tables['awc_f_forums']}.f_id, {$awc_tables['awc_f_forums']}.f_wiki_write_perm, {$awc_tables['awc_f_forums']}.f_passworded, 
                {$awc_tables['awc_f_cats']}.cat_name, {$awc_tables['awc_f_cats']}.cat_id
                    FROM {$awc_tables['awc_f_threads']}
                    JOIN {$awc_tables['awc_f_posts']} awc_f_posts
                        ON {$awc_tables['awc_f_threads']}.t_id=awc_f_posts.p_threadid
                    JOIN {$awc_tables['awc_f_forums']}
                        ON {$awc_tables['awc_f_threads']}.t_forumid={$awc_tables['awc_f_forums']}.f_id
                    JOIN {$awc_tables['awc_f_cats']} 
                        ON {$awc_tables['awc_f_forums']}.f_parentid={$awc_tables['awc_f_cats']}.cat_id
                    WHERE $perm_sql $s AND {$awc_tables['awc_f_forums']}.f_passworded = 0
                    ORDER BY awc_f_posts.p_thread_start DESC, awc_f_posts.p_date";                    
                    
        $sql = str_replace('AND   AND', ' AND ', $sql);
        $sql = str_replace('WHERE   AND', 'WHERE ', $sql);
      
     // awc_pdie($s);
        
        global $wgOut;
        require_once(awc_dir . 'includes/post_phase.php');
        require_once(awc_dir . 'includes/thread_funk.php');
        $post_cls = new awcs_forum_post_phase();
     
        $res = $dbr->query($sql);
        $post_table = null;
         while ($r = $dbr->fetchObject( $res )) {
         ++$total_thread_count;
         
            $thread_title_for_search = '<b>' . $r->t_name . '</b>';
         
             $tplt_info['edit_buttons'] = null;
             $tplt_info['sig_display'] = null;
             $tplt_info['user_options'] = null;
             $tplt_info['post_avatar'] = null;
             $tplt_info['admin_lookup'] = null;
             $tplt_info['profile_link'] = null;
             $tplt_info['m_pm'] = null;
             $tplt_info['wikiedits_count_link'] = null;
             $tplt_info['topics_count_link'] = null;
             $tplt_info['post_count_link'] = null;
             $tplt_info['group'] = null;
             
             
             $tplt_info['post_edited_on'] = null;
             $tplt_info['wikiedits_count_link'] = null;
             $word = null;
              
             
             $tplt_info['user_name'] = $r->p_user;
             $tplt_info['post_title'] =  $r->p_title;
            // $tplt_info['post_edited_on'] =  $r->p_editdate;
             
             $tplt_info['date'] = $r->p_date;
              $tplt_info['post'] =  $post_cls->phase_post($r->p_post, '', false);
            // $tplt_info['post'] =  awc_wikipase($r->p_post, $wgOut);
            // $tplt_info['post'] =  $r->p_post ;
             
             $tplt_info['avatarwidth'] = 0 ;
             
             
             $post_table .= $tplt->phase($word, $tplt_info, 'post_table');
         }
         
         
         $wgOut->addHTML($post_table);
         
         
         
         $end = ', ' . get_awcsforum_word('word_inThread') . ' ' . $thread_title_for_search ;
         $title = str_replace("|$|", $total_thread_count, get_awcsforum_word('search_SearchResultsFound'))  . ": $this->searchword" . $end ;
        Set_AWC_Forum_SubTitle(get_awcsforum_word('search_SearchResults'), $title  );
         
         
        // die($post_table);
         
         return ;
      
       require(awc_dir . 'thread.php');
       require(awc_dir . 'includes/thread_funk.php');
       $threads = new awcforum_threads();
       $threads->awc_url = $awc['link'];
       $threads->cookie_expir = $awc['config']['cfl_Post_cookie_postcountexpire'];
       $threads->quick_height = $awc['config']['cfl_Post_quickpost_box_height'];
       
       // isset($awc['config']['wikieits']) ? $threads->wikieits = $awc['config']['wikieits'] : $threads->wikieits=null;
       // $wikieits = $threads->wikieits;
      
      # die($this->searchword);
      global $wgRequest;
      $wgRequest->data['action'] .= 'sw:' . $this->searchword;
     # die(print_r($wgRequest));
     
        $threads->GetPosts($this->tID, $sql);
        
        $end = ', ' . get_awcsforum_word('word_inThread') . ' ' . $thread_title_for_search ;
        $title = str_replace("|$|", $total_thread_count, get_awcsforum_word('search_SearchResultsFound'))  . ": $this->searchword" . $end ;
        Set_AWC_Forum_SubTitle(get_awcsforum_word('search_SearchResults'), $title  );
        
       return ;        
    }

	
    function TopSearchBox($info){
    
        $html .= '<form id="editform" name="editform" action="'.$awc['link'].'search" method="post"  enctype="multipart/form-data">';
        $html .= '<input name="tID" type="hidden" value="'.$info['tID'].'">' ; 
        $html .= '<input name="fID" type="hidden" value="'.$info['fID'].'">' ;    
		$html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form>';
        
        return $html;
        
    }


    # http://us3.php.net/manual/en/function.sort.php#76547
    function msort($array, $id="id", $sort_ascending=true) {
            
       # die(print_r($array));
        
            $temp_array = array();
            while(count($array)>0) {
                $lowest_id = 0;
                $index=0;
                foreach ($array as $item) {
                    if (isset($item[$id])) {
                      if ($array[$lowest_id][$id]) {
                            if ($item[$id]<$array[$lowest_id][$id]) {
                                $lowest_id = $index;
                            }
                      }
                     }
                    $index++;
                }
                $temp_array[] = $array[$lowest_id];
                $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
            }
                    if ($sort_ascending) {
                return $temp_array;
                    } else {
                        return array_reverse($temp_array);
                    }
    }
        
     function vsort($array, $id="id", $sort_ascending=true, $is_object_array = false) {
            $temp_array = array();
            while(count($array)>0) {
                $lowest_id = 0;
                $index=0;
                if($is_object_array){
                    foreach ($array as $item) {
                        if (isset($item->$id)) {
                                            if ($array[$lowest_id]->$id) {
                            if ($item->$id<$array[$lowest_id]->$id) {
                                $lowest_id = $index;
                            }
                            }
                                        }
                        $index++;
                    }
                }else{
                    foreach ($array as $item) {
                        if (isset($item[$id])) {
                            if ($array[$lowest_id][$id]) {
                            if ($item[$id]<$array[$lowest_id][$id]) {
                                $lowest_id = $index;
                            }
                            }
                                        }
                        $index++;
                    }                             
                }
                $temp_array[] = $array[$lowest_id];
                $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
            }
                    if ($sort_ascending) {
                return $temp_array;
                    } else {
                        return array_reverse($temp_array);
                    }
     }
           
    
    
    
    
    
    
}
