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
* @filepath /extensions/awc/forums/includes/post_box.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

class awcs_forum_posting_box{
    
    var $thread_subscribe;
    var $displaysmiles, $FCKeditor, $extra_wikitools;
    var $quick_box_height, $quick_box_width;
    var $box_height, $box_width;
    var $max_title_lenth;
    
    var $quick_box = false;
    
    var $user_name;
    var $mem_FCKeditor, $mem_extra_wikitools, $riched_disable;
    
    var $polls_enabled;
    
    var $SyntaxHighlight_GeSHi = false;
    
    function __construct(){
    global $awcs_forum_config, $awcUser, $wgExtensionCredits;
        
        if(isset($wgExtensionCredits['parserhook']['SyntaxHighlight_GeSHi'])) $this->SyntaxHighlight_GeSHi = true;

        $this->FCKeditor = $awcs_forum_config->cf_FCKeditor ;
        $this->max_title_lenth = $awcs_forum_config->cfl_Thread_MaxTitleLength;
        $this->quick_box_height = $awcs_forum_config->cfl_Post_quickpost_box_height;
        $this->quick_box_width = '98%';
        $this->displaysmiles = $awcs_forum_config->cf_displaysmiles ;
        $this->thread_subscribe = $awcs_forum_config->cf_threadsubscrip ;
        $this->extra_wikitools = $awcs_forum_config->cf_extrawikitoolbox ;
        $this->polls_enabled = $awcs_forum_config->cfl_Polls_enabled ;
        
        $this->box_height = $awcUser->rows ;
        // $this->box_width = $awcUser->mOptions_cols ;
        $this->box_width = '98%' ;
        
        
        $this->mem_extra_wikitools = isset($awcUser->m_forumoptions['cf_extrawikitoolbox']) ? $awcUser->m_forumoptions['cf_extrawikitoolbox'] : '0' ;
        $this->mem_FCKeditor = isset($awcUser->m_forumoptions['cf_FCKeditor']) ? $awcUser->m_forumoptions['cf_FCKeditor'] : '0' ;
        $this->riched_disable = $awcUser->riched_disable ;
                                     
        $this->user_name = $awcUser->mName ;
        $this->mId = $awcUser->mId ;
                  
    }
    
    
    var $is_pm = false;
    var $Show_ann_sticky_lock = false ;
    var $url, $javaCheck = null;
    var $post, $title = null;
    
    var $f_posting_mesage_tmpt = null;
    //var $isThread = false;
    
    var $subscribed_email = null;
    var $subscribed_list, $subscribed_no, $subscribe = null;
    var $preview_button = true;
    
    var $t_wiki_pageid;
    
          
    function box(){
    global $tplt;
    global $oFCKeditorExtension, $pageEditor;
                      
                                         
               if($this->is_pm){
                   
                    $to_skin['posting_message'] = null;
                    $word['title'] = get_awcsforum_word('word_posttile');
                    $to_skin['user_options'] = $this->user_options;
                    $to_skin['pm_send_to_box'] = $this->mem_pm_sendto ;
                    
               } else {
               
                       #$info['subscribed_word'] = $extra['subscribed_word'];
                       $word['subscribed_word'] = get_awcsforum_word('word_subscribe') ;
                       
                       $word['subscribed_email'] = get_awcsforum_word('word_subscribe_email') ;
                       $info['subscribed_email'] = $this->subscribed_email;
                       
                       $word['subscribed_list'] = get_awcsforum_word('word_subscribe_memcp') ;
                       $info['subscribed_list'] = $this->subscribed_list;
                       
                       $word['subscribed_no'] = get_awcsforum_word('word_unsubscrib') ;
                       $info['subscribed_no'] = $this->subscribed_no;
                       
                       
                       if(isset($this->subscribe) AND $this->subscribe == 'dont_show' OR $this->mId == 0){
                            $to_skin['user_options'] = null;
                       } else {
                           $to_skin['user_options'] = $tplt->phase($word,$info,'subscrib_chk',true);
                            
                       }
                       
                       $word['title'] = get_awcsforum_word('word_posttile');
                       $to_skin['pm_send_to_box'] = null;
               
               }
                
               $to_skin['url'] = $this->url;
               $to_skin['javaCheck'] = $this->javaCheck ;
               
               $to_skin['posting_message'] = $this->f_posting_mesage_tmpt;
               
               $to_skin['post'] = $this->post ;
               
               $to_skin['rows'] = ($this->quick_box) ? $this->quick_box_height : $this->box_height ;
               $to_skin['max_chr'] = $this->max_title_lenth ; 
               $to_skin['cols'] = ($this->quick_box) ? $this->quick_box_width : $this->box_width ;         
               
               $to_skin['title'] = $this->title ;
                
               $to_skin['hidden_input'] = null;
               $to_skin['mod_options'] = null;
                 
               $to_skin['hidden_input'] .= (isset($this->num_topics)) ? '<input name="num_topics" type="hidden" value="'.$this->num_topics.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->pID)) ? '<input name="pID" type="hidden" value="'.$this->pID.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->Thread_Title)) ? '<input name="threadtitle" type="hidden" value="'.$this->Thread_Title.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->isThread)) ? '<input name="isThread" type="hidden" value="'.$this->isThread.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->fID)) ? '<input name="fID" type="hidden" value="'.$this->fID.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->tID)) ? '<input name="tID" type="hidden" value="'.$this->tID.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->f_name)) ? '<input name="f_name" type="hidden" value="'.$this->f_name.'">' : null ;
               $to_skin['hidden_input'] .= (isset($this->t_wiki_pageid)) ? '<input name="t_wiki_pageid" type="hidden" value="'.$this->t_wiki_pageid.'">' : null ;
               
               
                $to_skin['hidden_input'] .= $tplt->phase('','','spam_fields', true);
                
                
                if ($this->Show_ann_sticky_lock){
                        
                    if( UserPerm >= 2 ){
                            
                            $info['ann_chk'] = (isset($this->ann) AND $this->ann == '1') ? 'checked' : null;
                            $info['pin_chk'] = (isset($this->sticky) AND $this->sticky == '1') ? 'checked' : null;
                            $info['lock_chk'] = (isset($this->lock) AND $this->lock == '1') ? 'checked' : null;
                            
                            if( UserPerm == 10 ){
                                 $word['thread_makeAnnouncement'] = get_awcsforum_word('thread_makeAnnouncement') ;
                                 $info['ann'] = $tplt->phase($word,$info,'mod_chks_ann', true);
                            } else {
                                $info['ann'] = '';
                            }

                            $word['pinned_word'] = get_awcsforum_word('pinned_word') ;
                            $word['lockThread_word'] = get_awcsforum_word('lockThread_word') ;
                            
                            $to_skin['mod_options'] = $tplt->phase($word,$info,'mod_chks', true); 
         
                    }
                        
                } else {
                    
                        $ann = (isset($this->ann) AND $this->ann == '1') ? "on" : null ;
                        $sticky = (isset($this->sticky) AND $this->sticky == '1') ? "on" : null;
                        $lock = (isset($this->lock) AND $this->lock == '1') ? "on" : null;
                        
                        $to_skin['hidden_input'] .= '<INPUT TYPE=hidden NAME="ann" value="'.$ann.'">' ;
                        $to_skin['hidden_input'] .= '<INPUT TYPE=hidden NAME="sticky" value="'.$sticky.'">' ;
                        $to_skin['hidden_input'] .= '<INPUT TYPE=hidden NAME="lock" value="'.$lock.'">' ;      
                }
                
                
                
                
                
                $to_skin['ExtraWikiToolBar'] = null;
                if (method_exists($oFCKeditorExtension, 'onEditPageShowEditFormInitial')
                    AND ($this->FCKeditor AND $this->mem_FCKeditor AND $this->riched_disable == 0)){
                     
                    $form->textbox1 = str_replace("\r", '<br />', $to_skin['post']);
                    $rawPost = $form->textbox1;
                        
                    $oFCKeditorExtension->onEditPageShowEditFormInitial($form);
                    $to_skin['javaCheck'] = '';
                    
                } else if($this->extra_wikitools AND $this->mem_extra_wikitools AND !$this->quick_box ) {
                    global $wgOut; // only needed here...
                    $Edittools = GetWikiPage('<wiki>Edittools</wiki>', '', '8','');
                    $Edittools = awc_wikipase($Edittools, $wgOut);
                    $to_skin['ExtraWikiToolBar'] = $Edittools;
                }
                
                $to_skin['SimlieButtons'] = null;
                if($this->displaysmiles == '1'){
                     global $emotions; // only needed here...
                     if(!isset($emotions)) $emotions = GetEmotions();
                     $to_skin['SimlieButtons'] = EmotionsToToolbar($emotions, '');
                }
                
                $to_skin['WikiToolBar'] = GetWiki_ToolBar(); // 2.4.3
                

               $forum_tags = array();
               $forum_tags['center'] = array('open'=> '[center]', 'close'=>'[/center]', 'image'=>'center.gif');
               $forum_tags['underline'] = array('open'=> '[u]', 'close'=>'[/u]', 'image'=>'underline.gif');
               $forum_tags['strike'] = array('open'=> '[s]', 'close'=>'[/s]', 'image'=>'strike.gif');
               $forum_tags['quote'] = array('open'=> '[quote=username]', 'close'=>'[/quote]', 'image'=>'quote.gif');
               $forum_tags['color'] = array('open'=> '[color=red]', 'close'=>'[/color]', 'image'=>'color.gif');
               $forum_tags['code'] = array('open'=> '[code]', 'close'=>'[/code]', 'image'=>'code.gif');
               
               $forum_tags['search'] = array('open'=> '[search]', 'close'=>'[/search]', 'image'=>'search.jpg');
               $forum_tags['google'] = array('open'=> '[google]', 'close'=>'[/google]', 'image'=>'google.gif');
               $forum_tags['yahoo'] = array('open'=> '[yahoo]', 'close'=>'[/yahoo]', 'image'=>'yahoo.jpg');
               
               
               if($this->SyntaxHighlight_GeSHi){
                   require_once(awc_dir . 'config/SyntaxHighlight_GeSHi_tags.php');
               }
               
               
               $f_tags = array();
               $f_tags['tags'] = null;
               foreach($forum_tags as $what => $code){
                        $info['java_script'] = "javascript:insertTags('{$code['open']}', '{$code['close']}', '{$what}')";
                        $info['img'] = $code['image'] ;
                        $f_tags['tags'] .= $tplt->phase('',$info,'forum_tool_bar_tags');
               }
               $tplt->kill('forum_tool_bar_tags');
               
               $to_skin['ForumBar'] = $tplt->phase('',$f_tags,'forum_tool_bar',true);
               unset($f_tags, $forum_tags);
               
               
               $word['posting_Preview_word'] = get_awcsforum_word('posting_Preview_word') ;
               $word['submit'] = get_awcsforum_word('submit') ;             
               $submit_buttons = $tplt->phase($word,'','button:submit', true);
               if($this->preview_button) $submit_buttons .= $tplt->phase($word,'','button:preview', true); 
               $to_skin['submit_buttons'] = $submit_buttons; 
                   
                 
               $word['posting_as'] =  get_awcsforum_word('word_postingas') . ' <b>' . $this->user_name . '</b>';
                
                
               if(!isset($tplt->tplts['post_box']) or Empty($tplt->tplts['post_box'])){
                 $tplt->add_tplts(array("'post_box'"), true); // need to find out why some severs need this and some dont. 
               }
              
                
               return $tplt->phase($word,$to_skin,'post_box', true);

        }
    
        
        function poll_form_display(){
        global $wgRequest, $tplt;
        
        
            $tplt->add_tplts(array("'poll_form_options'",
                                        "'poll_form'",
                                        "'button:preview'",
                                        "'button:submit'", ),true);
                                         
                                        
            $word['word_poll'] =  get_awcsforum_word('word_poll');
            $word['word_poll_question'] = get_awcsforum_word('word_poll_question');
            
            $ispoll =  $wgRequest->getVal('ispoll');
            if($ispoll == 'on' ) {
                $to_skin['ispoll'] = 'checked';
            } else {
                $to_skin['ispoll'] = '';
            }
            
            $to_skin['pollq'] = $wgRequest->getVal( 'pollq' );
            $to_skin['tID'] = $this->tID;
            $to_skin['fID'] = $this->fID;
            $to_skin['max_chr'] = '255';
            
            $word['posting_Preview_word'] = get_awcsforum_word('posting_Preview_word') ;
            $word['submit'] = get_awcsforum_word('submit') ; 
            
            $to_skin['submit_buttons'] = $tplt->phase($word,'','button:submit', true);
            $to_skin['submit_buttons'] .= $tplt->phase($word,'','button:preview', true); 
            
            $to_skin['poll_options'] = self::poll_form_options();
            
            $html = $tplt->phase($word,$to_skin,'poll_form', true);                         
                                         
            return $html;
        }
        
        
        
        
        function poll_form_options(){
        global $wgRequest, $tplt;
           
            $word['word_poll_option'] = get_awcsforum_word('word_poll_option');
            
            $to_skin['max_chr'] = '255';
            
            $html = null;
            for ($i=1; $i<=10; $i++){
                $info['poll_options']['poll_opt' . $i] = $wgRequest->getVal('poll_opt' . $i);
                $to_skin['name'] = "poll_opt$i";
                $to_skin['value'] = $info['poll_options']['poll_opt' . $i];
                $html .= $tplt->phase($word,$to_skin,'poll_form_options');  
            }
            
            $tplt->kill('poll_form_options');
            
            return $html;
        
        
        }
    
    
    
    
}