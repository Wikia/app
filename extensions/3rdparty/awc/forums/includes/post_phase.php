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
* @filepath /extensions/awc/forums/includes/post_phase.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

class awcs_forum_post_phase{

    var $cat_id, $cat_name = null ;
    var $f_id, $f_name = null;
    var $t_id, $t_ann, $t_pin, $t_status, $t_name, $t_topics, $t_hits, $t_perm, $t_poll, $t_pollopen = null ;
    var $p_id, $p_title, $p_post, $p_user, $p_userid, $p_editwhy, $p_editwho, $p_editdate, $p_date = null;
    
    var $uID, $uName;
    var $pm_enable;
    var $guest = 0;
    var $user_info_cols = array();
    
    var $viewing_mem_info = array();
    
    var $emotions;
    var $word_subscribe = null ;
    
    var $convert_wTitle = false;
    var $wiki_titles = null ;
    
    var $posting_message = null;
    //var $only_one_post = true;
    
    var $cf_SigGuestView, $cf_AdvatarGuestView, $displaysmiles;
    var $bcmod = false;
    
    var $tplt_info = array();
    
    var $awc_wgParser, $awc_wgOut;
    var $showTcount, $showPcount, $showWEcount;
    
    var $single_post = false;
    
    var $preview = false;
    
    var $has_limit = false;
    
    var $forum_perm_can_post = false;
    
    var $show_guest_ip;
    
    var $displaying_search_results = false;
    
    var $polls_enabled;
    
    var $mem_post_title = array();
    
    function __construct() {
    global $wgParser, $wgOut, $wgScriptPath ;
    global $awcs_forum_config, $tplt, $awcUser ;
    
        $this->awc_wgParser = $wgParser;
        $this->awc_wgOut = $wgOut;
        $this->wgScriptPath = $wgScriptPath;
        
        $this->canPost = $awcUser->canPost; // need forum-wiki-perm
        $this->uID = $awcUser->mId;
        $this->uName = $awcUser->mName;
        
        $this->guest = $awcUser->guest;
        $this->viewing_mem_info['displaysigs'] = isset($awcUser->m_forumoptions['mem_showsigs']) ? $awcUser->m_forumoptions['mem_showsigs'] :  1 ;
        $this->viewing_mem_info['displaysigonce'] = isset($awcUser->m_forumoptions['mem_showsigsonlyonce']) ? $awcUser->m_forumoptions['mem_showsigsonlyonce'] : 0;
        $this->viewing_mem_info['viewaadv'] = isset($awcUser->m_forumoptions['mem_showAdv']) ? $awcUser->m_forumoptions['mem_showAdv'] : 1;
        $this->viewing_mem_info['displaysmiles'] = isset($awcUser->m_forumoptions['cf_displaysmiles']) ? $awcUser->m_forumoptions['cf_displaysmiles'] : 1;
        
        $this->pm_enable = '1';
        $this->convert_wTitle =  $awcs_forum_config->cf_wiki_titles;
        $this->displaysmiles = $awcs_forum_config->cf_displaysmiles;
        
        $this->showTcount = $awcs_forum_config->cf_showThreadCount ;
        $this->showPcount = $awcs_forum_config->cf_showPostCount ;
        $this->showWEcount = $awcs_forum_config->wikieits ;
        
        $this->show_guest_ip = $awcs_forum_config->cf_show_guest_ip ;
        
        $this->multi_polls = $awcs_forum_config->cf_allow_multi_pols;
        
        $this->cf_SigGuestView = $awcs_forum_config->cf_SigGuestView ;
        $this->cf_AdvatarGuestView = $awcs_forum_config->cf_AdvatarGuestView ;
        $this->cf_AvatraSize = $awcs_forum_config->cf_AvatraSize ;
        
        $this->polls_enabled = $awcs_forum_config->cfl_Polls_enabled ;
        
        
      //  $this->bcmod = function_exists('bcmod') ? true : false ;
        
        $this->emotions = GetEmotions();
         
        
        $user_get = array();
        $user_get[] = 'm_id';
        $user_get[] = 'm_idname';
        
        if($this->showTcount == 1) $user_get[] = 'm_posts';
        if($this->showPcount == 1)$user_get[] = 'm_topics';
       
        if($this->viewing_mem_info['displaysigs'] == 1) $user_get[] = 'm_sig';
        
        if($this->viewing_mem_info['viewaadv'] == 1) $user_get[] = 'm_adv_size';
        if($this->viewing_mem_info['viewaadv'] == 1)  $user_get[] = 'm_adv';
       
        //$user_get[] = 'm_sig';
        //$user_get[] = 'm_adv_size';
        //$user_get[] = 'm_adv';
        
        $this->user_info_cols = $user_get ;
        unset($user_get);
        
        
        self::can_do();
                                                       
    }
    
    function can_do(){
    
          # need to work on this
          
         if($this->convert_wTitle == '1'){
             $this->wiki_titles = awc_forum_wikititles(); 
         }
         
    }
    
    
    function member_cache($mem){
    
    
    }
    
    
    function display_post($pm = false, $pm_links = null){
    global $tplt;
    
   # awc_pdie($this);
   
    static $mem_Info = array();
    static $word = array() ;
    
    static $avatarwidth;
    
    $height_stuff = array('advar' => 0, 'memtitle' => 0, 'wikicount' => 0, 'postcount' => 0, 'threadcount' => 0) ;
    
    
   # awc_pdie($this);
    
    static $time_func_called = 0;
    ++$time_func_called;
        
        
        if($time_func_called == 1){
            
            $word = self::get_words();
                    
            if(isset($this->cf_AvatraSize)){
                $spl = explode('x',$this->cf_AvatraSize);
                $avatarwidth = $spl[1] + '20';
            } else {
                $avatarwidth = '135';
            }  
            
        }
        
        
        if($pm == false){
            // wfRunHooks( 'awcsforum_rawpost', array( &$this ) );
            
                if ($time_func_called == 1){
                    $tplt_info['LimitJump'] = isset($extras['LimitJump_top']) ? $extras['LimitJump_top'] : null;
                    $tplt_info['options_menu'] = isset($extras['options_menu']) ? $extras['options_menu'] : null;
                }
            
            
        } else {
        
                $edit_buttons['edit_buttons'] = $this->pm_links;
                $tplt_info['edit_buttons'] = $edit_buttons['edit_buttons'] ;
                $tplt_info['post_edited_on'] = null;
                
        }
        
        $tplt_info['avatarwidth'] = $avatarwidth;
        
        
        
        
        
        # Cache... Create array of Members info then check, cut down on queires on Sig and Group
            $HaveMemInfo = false; 
            if(!empty($mem_Info)){
                 
                       foreach ($mem_Info as $id => $value) {
                           if($mem_Info[$id]['m_id'] == $this->p_userid)  $HaveMemInfo = true;
                        }
                        
                        if(!$HaveMemInfo) $mem_Info[$this->p_userid] = GetMemInfo($this->p_userid, $this->user_info_cols); 
                   
            } else {
                 
                $mem_Info[$this->p_userid] = GetMemInfo($this->p_userid, $this->user_info_cols);
            }
            
          #  awc_pdie($mem_Info);
            
           
           $hook_user_info = array();
           
           $hook_user_info['name'] = $this->p_user ;
           $hook_user_info['id'] = $this->p_userid ;
           
            foreach ($mem_Info as $id => $value) {
                // if($id != 2) awc_pdie(">". $id);
                //die("kk");
                
                
              
               // if($id == 0){
               if($this->p_userid == 0){
               
                  //  die();
                        $AvatraSize = explode('x', $this->cf_AvatraSize);
                        $mem_Info[0]['m_adv'] = "{$this->wgScriptPath}" . awcForumPath . "/images/avatars/avatar_guest.gif";
                        $mem_Info[0]['m_advw'] = $AvatraSize[0];
                        $mem_Info[0]['m_advh'] = $AvatraSize[1];
                        
                        $mem_Info[0]['edit_count'] = 0;
                        $mem_Info[0]['m_posts'] = 0;
                        $mem_Info[0]['m_topics'] = 0;
                        $mem_Info[0]['edit_count'] = 0;
                        
                        $mem_Info[0]['member_title'] = '';
                        
                        
                        $to_skin['member_title'] = ''; 
                        
                        $to_skin['edit_count'] = 0;
                        $to_skin['m_posts'] = 0;
                        $to_skin['m_topics'] = 0;
                        
                        $to_skin['m_advh'] = $mem_Info[0]['m_advh'];
                        $to_skin['m_advw'] = $mem_Info[0]['m_advw'];
                        $to_skin['m_adv'] = $mem_Info[0]['m_adv'];
                        
                        $tplt_info['group'] = '';
                        
                        $to_skin['m_sig'] = '';
                        
                        
                        $mem_Info[0]['group'] =  isset($mem_Info[$this->p_userid]['group']) ? $mem_Info[$this->p_userid]['group'] : '';
                        
                        $mem_Info[0]['m_sig'] = '';
                        
                       // if($this->p_post != 'guest') die($this->p_userid);
                                               
                } else {
                
                    if(!isset($mem_Info[$id]['cached'])){
                        
                        $mem_Info[$id]['cached'] = true;
                        
                        if($mem_Info[$id]['m_id'] == $this->p_userid) {
                            
                            
                            //$mem_Info[0]['member_title'] = ''; mem_post_title
                               //  die($this->p_userid);
                            
                            
                            if($this->viewing_mem_info['displaysigs'] == 1 OR
                                ($awcUser->guest == '0' AND $this->cf_SigGuestView)) {
                            
                                $m_sig = $mem_Info[$id]['m_sig'];
                                $m_sig = self::phase_post($m_sig,'',false);
                                $to_skin['m_sig'] =  $m_sig;
                                
                                if(isset($mem_Info[$id]['m_sig'])){
                                    $to_skin['m_sig'] = str_replace('<a href=', '<a target="blank" href=', $m_sig) ;
                                }    
                                
                                if($this->viewing_mem_info['displaysigonce'] == 1 AND !isset($mem_Info[$id]['show_sig'])) {
                                        $mem_Info[$id]['show_sig'] = true;  
                                } elseif($this->viewing_mem_info['displaysigonce'] == 1) {
                                        $to_skin['m_sig'] = null;
                                }
                                       
                            } else {
                               $to_skin['m_sig'] = null;
                            }
                            
                            $to_skin['m_adv'] = null;  
                            if($this->viewing_mem_info['viewaadv'] == 1 || ($awcUser->guest == '0' AND $this->cf_AdvatarGuestView)){
                                if(isset($mem_Info[$id]['m_adv']) AND !empty($mem_Info[$id]['m_adv'])){
                                    $to_skin['m_adv'] = $mem_Info[$id]['m_adv'];
                                    $to_skin['m_advw'] = $mem_Info[$id]['m_advw'];
                                    $to_skin['m_advh'] = $mem_Info[$id]['m_advh'];
                                } elseif($mem_Info[$id]['m_topics'] == '0' AND $mem_Info[$id]['m_posts'] == '0') {
                                    $AvatraSize = explode('x', $this->cf_AvatraSize);
                                    $to_skin['m_adv'] = "{$this->wgScriptPath}" . awcForumPath . "images/avatars/avatar_guest.gif";
                                    $to_skin['m_advw'] = $AvatraSize[0];
                                    $to_skin['m_advh'] = $AvatraSize[1];
                                } else{
                                    $AvatraSize = explode('x', $this->cf_AvatraSize);
                                    $to_skin['m_adv'] = "{$this->wgScriptPath}" . awcForumPath . "images/avatars/avatar_default.gif";
                                    $to_skin['m_advw'] = $AvatraSize[0];
                                    $to_skin['m_advh'] = $AvatraSize[1];
                                }
                            }
                            
                           
                            
                            $mem_Info[$id]['m_adv'] = $to_skin['m_adv']; // flip for caching
                            $mem_Info[$id]['m_advw'] = $to_skin['m_advw']; // flip for caching
                            $mem_Info[$id]['m_advh'] =  $to_skin['m_advh']; // flip for caching
                            $mem_Info[$id]['m_sig'] = $to_skin['m_sig']; // flip for caching
                                          
                                     
                            if(!isset($mem_Info[$id]['m_topics']) OR empty($mem_Info[$id]['m_topics'])){
                                $mem_Info[$id]['m_topics'] = '0'; 
                            } 
                            $to_skin['m_topics'] = $mem_Info[$id]['m_topics'];
                            
                            if(!isset($mem_Info[$id]['m_posts']) OR empty($mem_Info[$id]['m_posts'])){
                                $mem_Info[$id]['m_posts'] = '0'; 
                            }
                            $to_skin['m_posts'] = $mem_Info[$id]['m_posts'];
                            
                            if(!isset($mem_Info[$id]['edit_count']) OR empty($mem_Info[$id]['edit_count'])){
                                $mem_Info[$id]['edit_count'] = '0'; 
                            }
                            $to_skin['edit_count'] = $mem_Info[$id]['edit_count']; 
                            
                            $tplt_info['group'] = $mem_Info[$id]['group'];
                            
                            
                            // @added 2.5.8
                            if(!isset($this->mem_post_title[0])){
                                
                                foreach($this->mem_post_title as $memPostTitleID){
                                
                                        if($mem_Info[$id]['m_posts'] >= $memPostTitleID['count']) {
                                            $tplt_info['member_title'] = $memPostTitleID['title'];
                                            $tplt_info['member_title_css'] = $memPostTitleID['css'];
                                        }
                            
                                }
                                  
                            }else{
                                $tplt_info['member_title'] = '';
                                $tplt_info['member_title_css'] = '';
                            }
                            
                            $mem_Info[$id]['member_title'] = $tplt_info['member_title'];
                            $mem_Info[$id]['member_title_css'] = $tplt_info['member_title_css'];
                            
                            $to_skin['member_title'] = $tplt_info['member_title'];
                            $to_skin['member_title_css'] = $tplt_info['member_title_css'];
                            //- @added / 2.5.8
                            
                        }
                        
                        
                    } else {
                                 
                        
                        $to_skin['edit_count'] = isset($mem_Info[$this->p_userid]['edit_count']) ? $mem_Info[$this->p_userid]['edit_count'] : 0;
                        $to_skin['m_posts'] = $mem_Info[$this->p_userid]['m_posts'];
                        $to_skin['m_topics'] = $mem_Info[$this->p_userid]['m_topics'];
                        
                        $to_skin['m_advh'] = $mem_Info[$this->p_userid]['m_advh'];
                        $to_skin['m_advw'] = $mem_Info[$this->p_userid]['m_advw'];
                        $to_skin['m_adv'] = $mem_Info[$this->p_userid]['m_adv'];
                        
                        $tplt_info['group'] = $mem_Info[$this->p_userid]['group'];
                        
                        
                        $tplt_info['member_title'] = isset($mem_Info[$this->p_userid]['member_title']) ? $mem_Info[$this->p_userid]['member_title'] : '';
                        $tplt_info['member_title_css'] = isset($mem_Info[$this->p_userid]['member_title_css']) ? $mem_Info[$this->p_userid]['member_title_css'] : '';
                       # die();
                        $to_skin['member_title'] = $tplt_info['member_title'];
                        $to_skin['member_title_css'] = $tplt_info['member_title_css'];
                        
                        
                        if($this->viewing_mem_info['displaysigonce'] == 1) {
                            $to_skin['m_sig'] = '';
                        } else {
                            $to_skin['m_sig'] = $mem_Info[$this->p_userid]['m_sig'];
                        }
                        
                        
                            
                        
                        
                        
                    }
                    
                }
                
                

                   
                            
                    
            }
            
            
            $height_stuff['advar'] = $mem_Info[$this->p_userid]['m_advh'] + 15 ;
            $height_stuff['memtitle'] =  ($to_skin['member_title'] == '') ? 0 : 20 ;
            $height_stuff['wikicount'] =  20  ;
            $height_stuff['postcount'] =  20 ;
            $height_stuff['threadcount'] = 20 ;
        
        
            if(!isset($mem_Info[$this->p_userid]['m_topics']) OR empty($mem_Info[$this->p_userid]['m_topics'])){
                $height_stuff['threadcount'] = 0 ;
            } 
            
            
            if(!isset($mem_Info[$this->p_userid]['m_posts']) OR empty($mem_Info[$this->p_userid]['m_posts'])){
                $height_stuff['postcount'] =  0 ;
            }
            
            
            if(!isset($mem_Info[$this->p_userid]['edit_count']) OR empty($mem_Info[$this->p_userid]['edit_count'])){
               $height_stuff['wikicount'] =  0  ;
            }
            
            
                       
                        
            $tplt_info['sig_display'] = $tplt->phase($word, $to_skin, 'sig_display');      
            $tplt_info['post_avatar'] = $tplt->phase($word, $to_skin, 'post_avatar');
            
            $to_skin['url'] = awcsf_wiki_url ."Special:Contributions/{$this->p_user}" ;
            $tplt_info['wikiedits_count_link'] = ($this->showWEcount == '1') ? $tplt->phase($word, $to_skin, 'link_wikiedits') : null ;

                                               
            $to_skin['url'] = awc_url ."search/memtopics/".urlencode($this->p_user).'/'.$this->p_userid ;
          //  $to_skin['url'] = awc_url ."search/memtopics/".$this->p_userid ;
            $tplt_info['topics_count_link'] = ($this->showTcount == '1') ? $tplt->phase($word, $to_skin, 'link_threads') : null ;
                   
            $to_skin['url'] = awc_url ."search/memposts/".urlencode($this->p_user).'/'.$this->p_userid ;                                // $to_skin['url'] = awc_url ."search/memposts/".$this->p_userid ;
              
            $tplt_info['post_count_link'] = ($this->showPcount == '1') ? $tplt->phase($word, $to_skin, 'link_posts') : null;
                                    
            $tplt_info['mem_drop_num'] = $time_func_called ;
            
            $tplt_info['user_name'] = "<a href=\"".awc_url."mem_profile/{$this->p_user}/{$this->p_userid}\" onmouseover=\"mopen('mem{$tplt_info['mem_drop_num']}')\" onmouseout=\"mclosetime()\">{$this->p_user}</a>";
            
            $tplt_info['admin_lookup'] = (UserPerm == 10 AND !$this->preview) ? '<a target="blank" href="'. awc_url .'admin/mem_lookup/'.$this->p_user.'/'.$this->p_userid.'">*</a>' : '';
            
            $to_skin['url'] = awc_url . "mem_profile/{$this->p_user}/{$this->p_userid}";
            $tplt_info['profile_link'] = $tplt->phase($word, $to_skin, 'link_profile') ;
            
            $tplt_info['user_options'] = isset($to_skin['user_options'])? $to_skin['user_options'] . '<br />' : null;
            
            if($this->p_userid == 0 ){                
                //if($this->show_guest_ip == 0) 
                
                
                if(UserPerm == 10 AND !$this->preview){
                   $tplt_info['user_name'] = "<a href='".awcsf_wiki_url."Special:Contributions/{$this->p_user}'>{$this->p_user}</a>";
                } elseif($this->show_guest_ip == 0){
                    $tplt_info['user_name'] = get_awcsforum_word('word_guest');
                } 
                
                
                $tplt_info['post_count_link'] = null;
                $tplt_info['profile_link'] = null;
                $tplt_info['user_options'] = null;
                $tplt_info['topics_count_link'] = null;
                $tplt_info['group'] = null;
                
              
                $tplt_info['member_title'] = '';
                $tplt_info['member_title_css'] = '';
                
                
                if(UserPerm == 10 AND !$this->preview){
                
                } elseif($this->show_guest_ip == 0){
                    $tplt_info['wikiedits_count_link'] = null;
                } 
                
            }
            
            if(!isset($tplt_info['member_title'])){
            	$tplt_info['member_title'] = '';
            	$tplt_info['member_title_css'] = '';
            }
            
            
            
            
            $m_pm = ($this->pm_enable == '1' AND $this->guest == false) ? $word['word_send'] . ' <a href="'.awc_url.'member_options/pmnew/'.$this->p_user.'/'.$this->p_id.'">' . $word['word_pm'] .'</a>' : null;
            $to_skin['url'] = awc_url.'member_options/pmnew/'.$this->p_user .'/'.$this->p_id ;
            $tplt_info['m_pm'] = $tplt->phase($word, $to_skin, 'link_send_pm_to') ;
            
            $tplt_info['date'] = null;
            $info['date'] = awcsforum_funcs::convert_date($this->p_date, "l") . " " ;
            if(!$this->preview) $tplt_info['date'] = $tplt->phase($word, $info, 'post_date_link');
            if($this->single_post OR $pm OR $this->preview) $tplt_info['date'] = $info['date'];
            
            $info['post_title'] = awcsforum_funcs::awc_html_entity_decode($this->p_title);
            #$info['post_title'] = $this->p_title ;
            $tplt_info['post_title'] = (!empty($this->p_title) AND $this->p_title != $this->t_name ) ? $tplt->phase($word, $info, 'post_title_row') : '';
            
            
            
            if($time_func_called % 2) {
               $tplt_info['row_class'] = 'post0'  ;
            } else {
               $tplt_info['row_class'] = 'post1'   ; 
            }
           /* 
            if ($this->bcmod) {
                //$tplt_info['row_class'] = 'post' . bcmod($time_func_called, '2')  ;
            } else {
                //$tplt_info['row_class'] = 'post' ;
            }
            */
            
            if($pm == false){
                            
                        if(!empty($this->p_editwho)){
                            $info['p_editdate'] = awcsforum_funcs::convert_date($this->p_editdate, "l") ;
                            $info['p_editwho'] = $this->p_editwho ;
                            $tplt_info['post_edited_on'] = $tplt->phase($word, $info, 'post_edited_on');
                        } else {
                            $tplt_info['post_edited_on'] = null;
                        }
                        
                        
                        
                        
                        $edit_buttons['edit_buttons'] = null;
                        if ( UserPerm >= 2 AND !$this->preview || (CanDelete($this->p_user) )) {
                                                                
                            if ($this->t_ann != "1" || UserPerm == 10){
                                
                                $url = awc_url .'mod/mod_post/delete/' . $this->p_id ;
                                #$url = awc_url .'post/delete_post/id' . $this->p_id ;
                                $t = $word['thread_deletepost'] . ' ? ' ;
                                $t = str_replace(array(chr(10), chr(13), "'"), '', $t);
                                                        
                                $info['url'] = $url ;
                                $info['msg'] = $t ;
                                
                                $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:delete_post');
                            }
                            
                        }
                        
                        
                        #if ( (UserPerm >= 2 || (CanDelete($this->p_user)) AND
                           # $this->only_one_post == false) ) {
                               # die(">". $this->only_one_post);    
                        if ( UserPerm >= 2  AND !$this->preview AND !$this->single_post  || 
                            (CanDelete($this->p_user)) AND $time_func_called == 1 AND !$this->has_limit) {
                                                                
                                if ($this->t_ann != "1" || UserPerm == 10){
                                    
                                    $url = awc_url .'mod/mod_thread/delete/' . $this->t_id ;
                                    $t = $word['thread_deletethread'] . ' ? \n'.  $word['deleteThread'] ;
                                    $t = str_replace(array(chr(10), chr(13), "'"), '', $t);
                                                            
                                    $info['url'] = $url ;
                                    $info['msg'] = $t ;
                                    
                                    $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:delete_thread');
                                }
                            
                        }
                        
                        
                       // die(">". $this->t_pollopen);
                         if(!$this->preview AND $time_func_called == 1 AND !$this->single_post ){
                             
                            if($this->polls_enabled == '1' AND $this->p_userid <> '0' AND (!$this->t_poll OR $this->multi_polls == '1') AND (UserPerm >= 10 || $this->uID == $this->p_userid)){ 
                                
                                $word['poll'] = get_awcsforum_word('word_add_poll');
                                $info['url'] = awc_url ."post/add_poll/{$this->t_id}/{$this->f_id}";
                                $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:poll');
                                
                                
                            } 
                                    
                        }
                        
                        
                         if(UserPerm >= 2 AND !$this->preview AND $time_func_called != 1){
                            $info['url'] = awc_url .'mod/mod_thread/splitmerge_get/' . $this->p_id;
                            $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:spltmerge_button');        
                        }
                        
                        
                         
                         if(!$this->preview AND $time_func_called == 1 AND CanEdit($this->p_user) || UserPerm >= 2){
                            $info['url'] = awc_url .'post/GetEditThread/id' . $this->p_id;
                            $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:edit_button');        
                        }
                        
                        
                         if(!$this->preview AND $time_func_called != 1 AND CanEdit($this->p_user) || UserPerm >= 2){
                            $info['url'] = awc_url .'post/GetEdit/id' . $this->p_id;
                            $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:edit_button');        
                        }
                        // forum-wiki-perm
                        
                        if(($this->canPost AND !$this->preview AND $this->t_status == "0" AND $this->forum_perm_can_post) || UserPerm >= 2){
                            $info['url'] = awc_url . "post/quote/id". $this->p_id;
                            $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:quote_button');        
                        }
                        
                        
                       # $tplt_info['edit_buttons'] = $tplt->phase($word, $edit_buttons, 'edit_buttons_row');
                        
            }
            $tplt_info['edit_buttons'] = $tplt->phase($word, $edit_buttons, 'edit_buttons_row');
            
/*            
            if($this->preview){
                $tplt_info['edit_buttons'] = null;
            } else {
                 $tplt_info['edit_buttons'] = $tplt->phase($word, $edit_buttons, 'edit_buttons_row');
            }
            */
            
            # crap! need to find a way to fill the height of the post-text, work-around
            $add = 0; // 2.5.8
            foreach($height_stuff as $item => $number ){
                $add = ($add + $number);
            }
            
            $tplt_info['table_height'] = $add ; //($to_skin['m_adv'] == null) ? '65' : ($to_skin['m_advh'] + 65); // 2.5.8
            $tplt_info['post_height'] = ($tplt_info['table_height'] - 10);
            
            $tplt_info['colspan'] = strlen($edit_buttons['edit_buttons']) > 0 ? ' ' : ' width="100%" colspan="2" ';
            
            $post = $this->p_post;
            $tplt_info['post'] = self::phase_post($post, $this->p_id);
            
            $tplt_info['p_id'] = $this->p_id;
            $tplt_info['pID'] = $this->p_id;
            
            
            wfRunHooks( 'awcsforum_post_render_display', array(&$tplt_info, $hook_user_info) );   // 2.5.6
            
            $post_table = $tplt->phase($word, $tplt_info, 'post_table');
            // if($time_func_called == 5) $post_table = '<a name="last"></a>' . $post_table;
            return $post_table;
    }
    
    
    function load_post_phase_info($r){
        
        $this->cat_id = $r->cat_id ;
        $this->cat_name = $r->cat_name ;
        $this->f_id = $r->f_id ;
        $this->f_name = $r->f_name ;
        if(!$this->single_post) $this->posting_message = $r->f_posting_mesage_tmpt ;
                    
        $this->t_id = $r->t_id ;
        $this->t_ann = $r->t_ann ;
        $this->t_pin = $r->t_pin ;
        $this->t_status = $r->t_status ;
        $this->t_name = $r->t_name ;
        #$this->t_topics = $r->t_topics ;
        #$this->t_hits = $r->t_hits ;
        $this->t_perm = $r->t_perm ;
        $this->t_poll = $r->t_poll ;
        $this->t_pollopen = $r->t_pollopen ;
                    
        $this->p_id = $r->p_id ;
        $this->p_title = $r->p_title ;
        $this->p_post = $r->p_post ;
        $this->p_user = $r->p_user ;
        $this->p_userid = $r->p_userid ;
        $this->p_editwhy = $r->p_editwhy ;
        $this->p_editwho = $r->p_editwho ;
        $this->p_editdate = $r->p_editdate ;
        $this->p_date = $r->p_date ;
        $this->t_name = $r->t_name ;
        
    }
    
    function get_words(){
    	
       $word['subscribe'] = $this->word_subscribe;
       $word['editedon'] = get_awcsforum_word('editedon');
       $word['by'] = get_awcsforum_word('by');
       $word['edit'] = get_awcsforum_word('edit');
       $word['thread_makeAnnouncement'] = get_awcsforum_word('thread_makeAnnouncement');
       $word['1indicator_locked'] = get_awcsforum_word('1indicator_locked');
       $word['1indicator_sticky'] = get_awcsforum_word('1indicator_sticky');
       $word['1indicator_lockSticky'] = get_awcsforum_word('1indicator_lockSticky');
       $word['word_viewed'] = get_awcsforum_word('word_viewed');
       $word['word_times'] = get_awcsforum_word('word_times');
       $word['thread_makeAnnouncement'] = get_awcsforum_word('word_Withatotalof');
       $word['word_Withatotalof'] = get_awcsforum_word('1indicator_locked');
       $word['1indicator_sticky'] = get_awcsforum_word('1indicator_sticky');
       $word['word_subscribe_memcp'] = get_awcsforum_word('word_subscribe_memcp');
       $word['word_subscribe_email'] = get_awcsforum_word('word_subscribe_email');
       $word['word_thread_options_button'] = get_awcsforum_word('word_thread_options_button');
       $word['deleteThread'] = get_awcsforum_word('deleteThread');
       $word['thread_deletethread'] = get_awcsforum_word('thread_deletethread');
       $word['thread_deletepost'] = get_awcsforum_word('thread_deletepost');
       $word['word_poll_guest_message'] = get_awcsforum_word('word_poll_guest_message');
       $word['quote'] = get_awcsforum_word('quote');
       $word['word_post'] = get_awcsforum_word('word_post');
       $word['word_profile'] = get_awcsforum_word('word_profile');
       $word['word_send'] = get_awcsforum_word('word_send');
       $word['delete'] = get_awcsforum_word('thread_deletepost');
       $word['word_pm'] = get_awcsforum_word('word_pm');
       $word['posts'] = get_awcsforum_word('word_posts');
       $word['threads'] = get_awcsforum_word('word_threads');
       $word['wiki_edits'] = get_awcsforum_word('word_postsWikiedits');
       $word['word_split_merge'] = get_awcsforum_word('word_split_merge');
       
      # $word['threads'] = get_awcsforum_word('word_threads');
      # $word['wiki_edits'] = get_awcsforum_word('word_postsWikiedits');
       
                    
       return $word;
    }
    
    public function hide_code($post, $todo = 'hide'){
                                               
  #  return $post;
  
      #$post = preg_replace("#<pre(.+?)<\/pre>#is", "@ENCODED@" . 'base64_encode("$1")' . "@ENCODED@", $post ); 
      
      # $post = preg_replace('/@ENCODED@([0-9a-zA-Z\\+\\/]+=*)@ENCODED@/e','base64_decode("$1")', $post ); 
        
            if (preg_match_all("#<pre(.+?)<\/pre>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                } 
            }
            
            
            if (preg_match_all("#<source(.+?)<\/source>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                }   
            } 
            
                        
            if (preg_match_all("#<nowiki(.+?)<\/nowiki>#is", $post, $found)){
                foreach($found[0] as $k => $v){
                   $post = str_replace($v, awcf_hide_code($v), $post);
                } 
            }
            
            
            return $post;
            
    }
    
    
    function phase_post($post, $id, $wiki_page = true){
    global $wgOut, $wgOut, $wgParser;
    
            if($post == '') return $post; // for sigs...
            
            $post = convert_pre($post);
            
            $post = remove_forum_tag_from_post($post);
            
            $post = awcf_hide_code2($post);
            
            if($this->convert_wTitle == '1') {
                $post = wiki_links($post, $this->wiki_titles) ;
            }
            
            if($this->displaysmiles == '1' AND $this->viewing_mem_info['displaysmiles'] == '1'){
                $post = awcf_emotions($post, $this->emotions) ;
            }
            
            $post = br_convert($post);
            
            
             if($wiki_page) if(GetWikiPageOK($post)) $post = GetWikiPage($post, $id) ;
            
            
            $post = awcf_unhide_code($post);
            
           
            $post = awc_wikipase($post, $wgOut) ;
            
           # awc_pdie($post); 
            $post = Convert($post);
            // $post = Convert($post);
        
           # $f = array('&lt;/a&gt;', '&lt;a href', '"&gt;', "<a href=",);
           # $r = array('</a>', '<a href', '">', "<a target='blank' href=", '',);
          #  $post = str_replace($f, $r, $post ) ;
               
                   
            #$post = str_replace("<a href=", "<a target='blank' href=", $post ) ;
           # $post = str_replace('rel="nofollow"', "", $post ) ;
            
            if(isset($sw[1])){
                foreach($sw as $test) {
                    $post = HighLightSearchWord($post,$test); 
                }
            } else {
                #$post = HighLightSearchWord($post,$extras['word']);
            }
            
            
            // needs to be in the loop to check against each post for other extensions triggered
            if(isset($wgParser->mOutput->mHeadItems)){   
                foreach($wgParser->mOutput->mHeadItems as $k_ID => $mHeadItems){
                    
                    $wgOut->addHeadItem($k_ID, $mHeadItems);
                }
            }
                    
            return $post;
    }
    
    function display_poll($tID, $preview = false, $uID = null){
    global $tplt, $wgRequest;   
        
            if($uID == null) $uID = isset($this->uID) ? $this->uID : '0';
            
            
            if(!isset($tplt->tplts['poll_display_results']) or Empty($tplt->tplts['poll_display_results'])){
                    $tplt->add_tplts(array("'poll_display_options'",
                                            "'poll_display_results'",
                                            "'poll_opt_options'", 
                                            "'poll_display_result_bars'", 
                                            "'poll_display'",), true);
               }
               
               
            
                                 
                            
                                 
            $word['word_poll_question'] = get_awcsforum_word('word_poll_question');
            
            $Pass['thread_link'] = null;
            
            
            if($preview){
            
                $word['word_votes'] = get_awcsforum_word('word_votes');
                $word['word_total_percent'] = get_awcsforum_word('word_total_percent');
                $word['word_poll_option'] = get_awcsforum_word('word_poll_option');
                $word['word_total_votes'] = get_awcsforum_word('word_total_votes');
                    
                $opt = null;
                
                    foreach($_POST as $k => $v){
                        
                          if(!empty($v)){
                              
                                    if(strstr($k,'poll_opt')){
                                    	
                                        ++$opt;
                                        if(trim(awcsforum_post_cls::CleanThreadTitle($v)) != ''){
                                            $p['poll_choice']['poll_opt' . $opt] = trim(awcsforum_post_cls::CleanThreadTitle($v));
                                        }
                                        
                                    }

                          } 
                    
                    }
                    
                    
                  $p['poll_results'] = array();
                  #$p['poll_results'] = '0'; 
                  $Pass = self::display_result_bars($p);
                  $Pass['poll_q'] = $wgRequest->getVal( 'pollq' );
                  
                  
                  $poll = $tplt->phase($word, $Pass, 'poll_display', true);                     
                  //$poll .= '<br /><br />';
                  
                  
                    require(awc_dir . 'includes/post_box.php');
                    $posting_box = new awcs_forum_posting_box();
                    $posting_box->tID = $this->tID;
                    $posting_box->fID = $this->fID;
                    $poll .= $posting_box->poll_form_display();
                    
                  return $poll;
            }
            
            
            
             
            $dbr = wfGetDB( DB_SLAVE );
            
            $awc_f_polls = $dbr->tableName( 'awc_f_polls' );
            $awc_f_forums = $dbr->tableName( 'awc_f_forums' );
          //  $awc_f_threads = $dbr->tableName( 'awc_f_threads' );
           // die($tID);
                $poll_sql = "SELECT * FROM {$awc_f_polls} WHERE poll_threadid=$tID ORDER BY poll_id ASC";
                
                
                // poll_open
               // elseif($this->t_poll AND $this->t_pollopen == 0 AND UserPerm >= 2) {
                                 // word_pollClosed
                                 
                        
                $poll = null;
                $poll_res = $dbr->query($poll_sql);
                # $poll_r = $dbr->fetchRow($poll_res);  
                
                
                    while ($poll_r = $dbr->fetchObject( $poll_res )) {          
                            
                           // $poll_r = $dbr->fetchRow($poll_res);
                            
                            $Pass['pollID'] = $poll_r->poll_id;
                            $Pass['tID'] = $poll_r->poll_threadid;
                            $Pass['poll_q'] = $poll_r->poll_q;
                            $Pass['poll_q'] = '<a href="'.awc_url.'st/id'.$tID.'">'. $Pass['poll_q'] .'</a> ';
                            
                            $p = array();
                            $p['poll_choice'] = @unserialize($poll_r->poll_choice);
                            $p['poll_results'] = @unserialize($poll_r->poll_a);
                            $p['poll_whovoted'] = @unserialize($poll_r->poll_whovoted);
                            $p['poll_q'] = '<a href="'.awc_url.'st/id'.$tID.'">'. $poll_r->poll_q .'</a> ';
                           // $Pass['thread_link'] = '<a href="'.awc_url.'/st/id'.$tID.'">'.get_awcsforum_word('word_votes').'</a> ';
                           $poll_buttons =  self::poll_buttons($poll_r->poll_open, $poll_r->poll_id, $tID); // 2.5.8
                                
                            #unset($poll_r, $p_res);
                            
                            if(!@array_key_exists($uID, $p['poll_whovoted']) AND $uID != 0 ){
                                # $p['options'] =  $calling_class->skin_thread->poll_displayoptions_select($p['poll_choice'],$pIDs );
                                if ($poll_r->poll_open == 1){
                                        $t = 0;
                                        $Pass['select_options'] = null;
                                        foreach($p['poll_choice'] as $f => $v){
                                            if($v != ''){
                                                ++$t;
                                                $Pass['url'] = awc_url.'post/todo_poll_vote' ;
                                                $Pass['value'] = $f;
                                                $Pass['id'] = "polloption$f";
                                                $word['option'] = $v;
                                                // word_pollnovote
                                                
                                                
                                                #$word['option'] = get_awcsforum_word('word_votes');
                                                $word['submit'] = get_awcsforum_word('word_vote');
                                                $Pass['select_options'] .=  $tplt->phase($word, $Pass, 'poll_opt_options') ;  
                                            }
                                        }
                                        
                                        $Pass['value'] = '-1';
                                        $Pass['id'] = "polloption_opt" . ($t + 1);
                                        $word['option'] = get_awcsforum_word('word_pollnovote') ;
                                        $Pass['select_options'] .=  $tplt->phase($word, $Pass, 'poll_opt_options') ; 
                                        
                                        $Pass['options'] = $tplt->phase($word, $Pass, 'poll_display_options');
                                       
                                        
                                } else {
                                        $Pass = self::display_result_bars($p);
                                        $Pass['poll_q'] = $p['poll_q'];
                                        $Pass['options'] .=  get_awcsforum_word('word_pollClosed') ; // 2.5.8
                                }
                                
                                 $Pass['options'] .=  $poll_buttons ; // 2.5.8
                                        
                                        
                            } elseif ($uID != 0) {    
                                
                                
                                    
                                        if(!empty($p['poll_results'] )){
                                            $Pass = self::display_result_bars($p);
                                            $Pass['poll_q'] = $p['poll_q'];
                                            
                                        } else {
                                            $Pass['options'] = null;
                                        }
                                        
                                        if ($poll_r->poll_open == 0){
                                            $Pass['options'] .=  get_awcsforum_word('word_pollClosed') ; // 2.5.8
                                        }
                                        
                                        
                                        $Pass['options'] .=  $poll_buttons ; // 2.5.8
                                          
                            } else {
                                    
                                if ($poll_r->poll_open == 0){
                                        
                                    $Pass = self::display_result_bars($p);
                                    $Pass['poll_q'] = $p['poll_q'];
                                    $Pass['options'] .=  get_awcsforum_word('word_pollClosed') ; // 2.5.8
                                    
                                } else {
                                       $option = null;
                                        foreach($p['poll_choice'] as $f => $v){
                                            if($v != ''){
                                                $option .= $v . '<br />';
                                            }
                                        }
                                     
                                    $Pass['options'] = $option  ; 
                                }
                                    #$Pass['options'] = get_awcsforum_word('word_poll_guest_message');
                            }
                         
                           if(!isset($tplt->tplts['poll_display']) or Empty($tplt->tplts['poll_display'])){
                             $tplt->add_tplts(array("'poll_display'"), true); // need to find out why some severs need this and some dont. 
                           }
                        
                        $poll .= $tplt->phase($word, $Pass, 'poll_display');
                        
                        if($this->multi_polls == '0') break;     
                }
                                       
            return $poll;
    
    
    }
    
    function poll_buttons($closed, $Poll_ID, $tID){
    global $tplt;
    
     $edit_buttons['edit_buttons'] = null ;
     
        if($closed == 0 AND UserPerm >= 2) {
            
                    $word['delete_poll'] = get_awcsforum_word('word_delete_poll');
                    $info['url'] = awc_url ."post/delete_poll/{$Poll_ID}/{$tID}";
                    $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:delete_poll');
                    
                    $word['reopen_poll'] = get_awcsforum_word('word_pollreopen');
                    $info['url'] = awc_url ."post/reopen_poll/{$Poll_ID}/{$tID}";
                    $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:reopen_poll');
                                
        } elseif (UserPerm >= 2){     
                    
                    $word['delete_poll'] = get_awcsforum_word('word_delete_poll');
                    $info['url'] = awc_url ."post/delete_poll/{$Poll_ID}/{$tID}";
                    $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:delete_poll');
                    
                    $word['close_poll'] = get_awcsforum_word('word_close_poll');
                    $info['url'] = awc_url ."post/close_poll/{$Poll_ID}/{$tID}";
                    $edit_buttons['edit_buttons'] .= $tplt->phase($word, $info, 'post:close_poll');
                    
                                
        }
        
        
        return $edit_buttons['edit_buttons'];
    
    }
    
    function display_result_bars($p){
    global $tplt;   
        
                 $total = null;
                 $c = null;
                 $Pass['results'] = null;
                 
                 $word['word_votes'] = get_awcsforum_word('word_votes');
                 $word['word_total_percent'] = get_awcsforum_word('word_total_percent');
                 $word['word_poll_option'] = get_awcsforum_word('word_poll_option');
                 $word['word_total_votes'] = get_awcsforum_word('word_total_votes');
                 
                 if(!empty($p['poll_results'])){
                    foreach($p['poll_results'] as $k => $re){
                        $total = $total + $re;
                    }
                 } else {
                    $total = "0";
                 }
                    
                    foreach($p['poll_choice'] as $f => $v){
                        
                      if(!isset($p['poll_results'][$f])) $p['poll_results'][$f] = '0';
                       
                        $Pass['percent'] = @round(($p['poll_results'][$f]/$total)*100, 2) ;
                        $Pass['poll_results'] = $p['poll_results'][$f];
                        $Pass['option'] = $v;
                        
                        if($v != ''){  
                            ++$c;
                            $Pass['c'] = $c;
                            $Pass['results'] .= $tplt->phase($word, $Pass, 'poll_display_result_bars'); 
                        }
                        
                    }
                 
                 $Pass['total'] = $total;  
                 $Pass['options'] = $tplt->phase($word, $Pass, 'poll_display_results');
                 
                 return $Pass;
        
    }










}