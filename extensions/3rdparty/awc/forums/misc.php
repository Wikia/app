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
* @filepath /extensions/awc/forums/misc.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


class awcforum_misc{

    function enter_misc($action){
    global $awc, $WhoWhere; 
    
      //  awcsforum_funcs::get_page_lang(array('lang_txt_mem')); 
      
        $spl = explode("/", $action);
        $todo = $spl[0];
        
        define('what_page', $todo );
        
       $WhoWhere['type'] =   'forum' ;
       $WhoWhere['where'] = $todo . '||awc-split||' . $todo ;
        
        switch( $todo ) {
        
            case 'credits':
                     $this->credits();
                break;
                
            case 'mem_profile':
                    $this->mem_profile($action);
                break;
                
            default: 
                break;
        }
        
    }
    
    function whoshere(){
        global $wgOut, $WhoWhere;
        
         //$WhoWhere = 'whoshere' ;
         $WhoWhere['type'] =   'forum' ;
         $WhoWhere['where'] =  'whoshere||awc-split||whoshere' ;
        
          
        Set_AWC_Forum_SubTitle(get_awcsforum_word('word_forum_stats_whos_here'), '');
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_forum_stats_whos_here'), true);
        
            $dbr = wfGetDB( DB_SLAVE );
            $awc_f_sessions = $dbr->tableName('awc_f_sessions');
            $sql = "SELECT * FROM $awc_f_sessions ORDER BY ses_when DESC";
            $res = $dbr->query($sql);
            
            
            $out = null;
            $guest = get_awcsforum_word('word_guests');
            $bots = get_awcsforum_word('word_forum_stats_bots');
            
            
            while ($r = $dbr->fetchObject( $res )) {
                
                $where = explode('||awc-split||', $r->ses_where);
                $where_link = $where[0];
                $where_text = (isset($where[1])) ? $where[1] : $where[0] ;
                $type = $r->ses_type;
                $who = $r->ses_name;
                
                if($r->ses_guest == '1') $who = $guest;
                if($r->ses_bot == '1') $who = $bots;
                
                if($type == 'wiki'){
                    
                    $f = array('\'', ' ');
                    $r = array('%27', '_'); // note
                            
                    $where_link = str_replace($f, $r, $where_link);
                            
                    $out .= "<b>{$who}</b> - <a href='".awcsf_wiki_url."{$where_link}'>".awcsforum_funcs::awc_html_entity_decode($where_text)."</a> <br /><br />";
                            
                
                } else {
                    
                    
                    $show = false;
                    $perm = explode(',', $r->ses_perm);
                    
                    if($r->ses_perm == '') {
                         $show = true;
                    } else {
                        
                        foreach($perm as $permIs){
                            if(strstr(UserGroupPerm, $permIs)){
                                $show = true;
                                break;
                            }
                        }
                        
                        
                    }
                    
                    
                    if($show){
                        if(strpos($where_link, 'tid') !== false){
                            $link = explode('tid', $where_link);
                            $out .= "<b>{$who}</b> - <a href='".awc_url."st/id{$link[1]}'>{$where_text}</a> <br /><br />\r";
                        } elseif(strpos($where_link, 'fid') !== false){
                            $link = explode('fid', $where_link);
                            $out .= "<b>{$who}</b> - <a href='".awc_url."sf/id{$link[1]}'>{$where_text}</a> <br /><br />\r";
                        } elseif(strpos($where_link, 'cid') !== false){
                            $link = explode('cid', $where_link);      
                            $out .= "<b>{$who}</b> - <a href='".awc_url."cf/id{$link[1]}'>{$where_text}</a> <br /><br />\r";
                        } else {
                            $out .= "<b>{$who}</b> - <a href='".awc_url."{$where_link}'>{$where_text}</a> <br /><br />\r";
                        }
                    }
                    
                    
                    
                    
                
                
                }
                
                
            }
            
            $wgOut->addHTML($out);
    
    }
    
    function mem_profile($action){
    global $wgOut, $rev_timestamp, $awc, $wgOut, $wgParser, $WhoWhere, $tplt, $awcs_forum_config, $wgScriptPath, $awcUser; 
    
      // require(awc_dir . 'skins/members_skin.php');
     //  $skin_mem = New mem_skin();
       
        require_once(awc_dir . 'includes/post_phase.php');
        require_once(awc_dir . 'includes/thread_funk.php');
        $post_cls = new awcs_forum_post_phase();
       
       
       $WhoWhere = $action ;
       
       $WhoWhere['type'] =  'forum' ;
       $WhoWhere['where'] =  $action . '||awc-split||' . $action ;
       
      # die($action);
             
        $spl = explode("/", $action);
        
        if(isset($spl[1])){
            $mem_name = $spl[1];
            $mem_id = $spl[2];
        } else {
            return awcs_forum_error('') ; 
        }
        
        
        $user_get = array('*');
        $mem_page = array();
        $mem_page = GetMemInfo($mem_id, $user_get);
        
        
        if($mem_id == 0 AND UserPerm != 10){
        	$mem_name = get_awcsforum_word('word_guest');
        }
        
        #$out = $wgOut->parse($info);
        $mem_page['body'] = awc_clean_wikipase($wgOut->parse('[[User:'. $mem_name . '|'.get_awcsforum_word('edit').']]')) . ' ';
       # $mem_page['body'] = str_replace('User:'. $mem_name, 'User:'. $mem_name .'&amp;action=edit', $mem_page['body']);
       
        $mem_page['body'] .= awc_clean_wikipase($wgOut->parse('[[User_talk:'. $mem_name . '|'.get_awcsforum_word('word_discussion').']]')) . '<hr>';
         
        $mem_page['body'] = str_replace('action=edit', 'awc_redirect='.$mem_id.'&amp;action=edit', $mem_page['body']);
        $mem_page['body'] = str_replace('action=edit', 'awc_mem_redirect='.$mem_name.'&amp;action=edit', $mem_page['body']); 
        
      #  die($mem_page['body']);
       # $post = awc_wikipase($post, $wgOut) ;
        $GetWikiPage_body = GetWikiPage('<wiki>'.$mem_name.'</wiki>', '', '2', $mem_id);
        
         
        $post_cls->displaysmiles = '0';
        $post_cls->convert_wTitle = '0';
        $GetWikiPage_body =  $post_cls->phase_post($GetWikiPage_body, '', false);
        
       // die(awcsforum_funcs::convert_date($rev_timestamp, 'l'));
        /*
        $GetWikiPage_body = convert_pre($GetWikiPage_body);
        $GetWikiPage_body = remove_forum_tag_from_post($GetWikiPage_body);
        $GetWikiPage_body = br_convert($GetWikiPage_body);
        $GetWikiPage_body = awc_wikipase($GetWikiPage_body, $wgOut) ;
          */          
        $mem_page['body'] .= $GetWikiPage_body ;
        
        $post = str_replace('&lt;/a&gt;', '</a>', $mem_page['body']);
        $post = str_replace('&lt;a href', '<a href', $post);
        $post = str_replace('"&gt;', '">', $post); 
        
        $mem_page['body'] = $post;
        
        // needs to be in the loop to check against each post for other extensions triggered
        foreach($wgParser->mOutput->mHeadItems as $k_ID => $mHeadItems){
            $wgOut->addHeadItem($k_ID, $mHeadItems);
        }
        
        
        $Pass['body_info'] = isset($mem_page['body']) ? $mem_page['body'] : ' ';
        
        $Pass['sig'] = isset($mem_page['m_sig'])? $post_cls->phase_post($mem_page['m_sig'], '', false) : ' ';
        
        $Pass['group ']= isset($mem_page['group'])? $mem_page['group'] : null;
        
        $Pass['m_topics'] = $awcs_forum_config->cf_showThreadCount == '1' ? isset($mem_page['m_topics']) ? get_awcsforum_word('word_threads') . '  <a href="'.awc_url.'search/memtopics/'.urlencode($mem_page['name']).'/'.$mem_id.'">' . $mem_page['m_topics'] .'</a>' : null : null;
        
        $Pass['m_posts'] = $awcs_forum_config->cf_showPostCount == '1' ? isset($mem_page['m_posts']) ? get_awcsforum_word('word_posts') . ' <a href="'.awc_url.'search/memposts/'.urlencode($mem_page['name']).'/'.$mem_id.'">' . $mem_page['m_posts'] .'</a>' : null : null;
        
        $Pass['m_pm'] = $awcUser->guest == '0' ? get_awcsforum_word('word_send') . ' <a href="'.awc_url.'member_options/pmnew/'.$mem_page['name'].'">' . get_awcsforum_word('word_pm') .'</a>' : null;
        
        $Pass['wikiedits'] = isset($mem_page['edit_count']) ? get_awcsforum_word('word_postsWikiedits') . ' <a href="'.awcsf_wiki_url.'Special:Contributions/'.$mem_page['name'].'">' . $mem_page['edit_count'] .'</a>'  : get_awcsforum_word('word_postsWikiedits') . ' <a href="'.awcsf_wiki_url.'Special:Contributions/'.$mem_page['name'].'">0</a>' ;
        
        
        
        $m_adv = isset($mem_page['m_adv']) ? 1  : 0 ;
        
        if($m_adv == 0 || empty($mem_page['m_adv'])){
            $m_adv = 1;
            $AvatraSize = explode('x', $awcs_forum_config->cf_AvatraSize);
            if($mem_page['m_topics'] == '0' AND $mem_page['m_posts'] == '0') {
                    $mem_page['m_adv'] = "$wgScriptPath" . awcForumPath . "images/avatars/avatar_guest.gif";
                    $mem_page['m_advw'] = $AvatraSize[0];
                    $mem_page['m_advh'] = $AvatraSize[1];
                    $this->pm_enable = 0;
                } else{
                    $mem_page['m_adv'] = "$wgScriptPath" . awcForumPath . "images/avatars/avatar_default.gif";
                    $mem_page['m_advw'] = $AvatraSize[0];
                    $mem_page['m_advh'] = $AvatraSize[1];
            }

        }
        
        $Pass['m_adv'] = ($m_adv == 1 AND $mem_page['m_adv'] != '') ? '<DIV align="center"><img class="adv" src="'. $mem_page['m_adv'] .'" border="0" height="'. $mem_page['m_advh'] .'" width="'. $mem_page['m_advw'] .'" align="middle"/></div>'  : null ;
        
        $Pass['avatarwidth'] = $mem_page['m_advw'];
        
        
        
        $out = $tplt->phase('', $Pass, 'mem_profile_table', true);
        
        
        Set_AWC_Forum_SubTitle(get_awcsforum_word('mem_profile') . $mem_name , get_awcsforum_word('mem_lastmod') . " ". awcsforum_funcs::convert_date($rev_timestamp, 'l'));
        
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('mem_profile') . ' ' . $mem_name , true);

        
        $wgOut->addHTML($out);
        

       # $dbr = wfGetDB( DB_SLAVE );
        
         

        
                
    }
    
    
    function credits(){
    global $wgOut, $awc_tables ;
    
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_credits') , true);

            
            Set_AWC_Forum_SubTitle(get_awcsforum_word('word_credits'), get_awcsforum_word('word_specialthanks'));
            
            
                $dbr = wfGetDB( DB_SLAVE );
                $sql = "SELECT lang_name, lang_owner_info FROM {$awc_tables['awc_f_langs']}";
                $res = $dbr->query($sql);
                while ($r = $dbr->fetchObject( $res )) {
                   $lang_info[$r->lang_name]['lang_owner_info'] = unserialize($r->lang_owner_info) ;
                }
                
                
                get_awcsforum_word('word_awcthanks') == '' ? $ty = "AWC would like to thank..." : $ty = get_awcsforum_word('word_awcthanks'); 
                $wgOut->addHTML('<br /><b>' . $ty . '</b><hr>');
                
                
                get_awcsforum_word('word_thanksforthesmilies') == '' ? $htpc = "Has been a GREAT help !" : $htpc = get_awcsforum_word('word_beenagreatehelp'); 
                                
                $wgOut->addHTML('<br /><a target="blank" href="">HTPC</a> '. $htpc );
                
                get_awcsforum_word('word_thanksforthesmilies') == '' ? $smilies = "Thanks for the smilies" : $smilies = get_awcsforum_word('word_thanksforthesmilies'); 
                $wgOut->addHTML('<br /><hr><a target="blank" href="http://www.greghilton.com">Greg Hilton</a> '. $smilies ); 
                
                
                
                $wgOut->addHTML('<br /><br /><hr><b>' . get_awcsforum_word('word_langtranslate') . '</b><hr>');
                
                foreach($lang_info as $k => $v){
                    
                    $wgOut->addHTML($k . ' - ' . $lang_info[$k]['lang_owner_info']['lang_owner_when'] . '<br />' . $lang_info[$k]['lang_owner_info']['lang_owner'] . '<br /><a target="blank" href="http://'. str_replace('http://', '', $lang_info[$k]['lang_owner_info']['lang_owner_contact']) .'">' . $lang_info[$k]['lang_owner_info']['lang_owner_contact'] . '</a><br /><br />');
                    
               # die(print_r($lang_info));
                }
                
                

                
                
            
            
              $wgOut->addHTML('<br /><hr>');  
    }
    
    
    
    
    
    
    
}




