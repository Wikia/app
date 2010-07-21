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
* @filepath /extensions/awc/forums/includes/subscribe.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/


class awcs_forum_subscribe {
    
    var $tID, $fID, $cur_memID, $subscribe, $title;
    var $m_forum_subsrib, $m_thread_subsrib;
    var $wDB;
    var $forum_or_thread = 'thread';
    var $email_lookup = true;
    
    
    function __construct(){
    global $awcs_forum_config;
    
        $this->wDB = wfGetDB( DB_MASTER );
        
        $this->post_text_limit = $awcs_forum_config->cf_send_post_body_in_email_limit  ;
        $this->cf_send_post_body_in_email = $awcs_forum_config->cf_send_post_body_in_email ;
        
        $this->thread_text_limit = $awcs_forum_config->cf_send_thread_body_in_email_limit  ;
        $this->cf_send_thread_body_in_email = $awcs_forum_config->cf_send_thread_body_in_email  ;
        
        $this->send_email_html = $awcs_forum_config->cf_send_email_html  ;
        
    }
    
    
    function check_user_forum_subscribe(){
          self::check_for_subscribed_members();     
    }
    
    
    function check_user_thread_subscribe(){   
        self::check_thread_subscribe();
        self::check_for_subscribed_members();
    }
    
    function check_thread_subscribe(){   
        
        if($this->subscribe == 'no') {
            
                if(isset($this->m_thread_subsrib[$this->tID]) ){
                    self::unsubscribe_to_thread();
                    self::update_mem_thread();   
                } 
                
        } else {
            
                if(isset($this->m_thread_subsrib[$this->tID]) ){
                    if($this->subscribe != $this->m_thread_subsrib[$this->tID]){ 
                        self::change_subscribe_thread(); 
                        self::update_mem_thread();  
                    }  
                } else {
                    self::subscribe_to_thread();
                    self::update_mem_thread(); 
                }
                
        }
        
    }   
         
         
    function subscribe_to_thread(){
        
        $this->wDB->insert( 'awc_f_watchthreads', array(
                            'wtcht_thread_id'        => $this->tID,
                            'wtcht_mem_id'           => $this->cur_memID,
                            'wtcht_todo'           => $this->subscribe,), __METHOD__ ); 
                            
        $this->m_thread_subsrib[$this->tID] = $this->subscribe;   
              
    }
    
    
    function unsubscribe_to_thread(){
        $this->wDB->delete( 'awc_f_watchthreads', array( 'wtcht_thread_id' => $this->tID, 'wtcht_mem_id' => $this->cur_memID ), __METHOD__); 
        unset($this->m_thread_subsrib[$this->tID]);
    } 
    
    function change_subscribe_thread(){
        $this->wDB->update( 'awc_f_watchthreads',
                        array('wtcht_todo' => $this->subscribe,), 
                        "wtcht_thread_id=$this->tID AND wtcht_mem_id=$this->cur_memID", __METHOD__ );
                         
        $this->m_thread_subsrib[$this->tID] = $this->subscribe;   
    }
    
    
    
    
    
    function check_forum_subscribe(){   
     
        if(isset($this->m_forum_subsrib[$this->fID]) ){
                self::unsubscribe_to_forum(); 
                self::update_mem_thread();  
        } else {
            self::subscribe_to_forum();
            self::update_mem_thread(); 
        }
        
    }
         
         
    function subscribe_to_forum(){
        
        $this->wDB->insert( 'awc_f_watchforums', array(
                            'wtchf_forum_id'        => $this->fID,
                            'wtchf_mem_id'           => $this->cur_memID,) ); 
                            
        $this->m_forum_subsrib[$this->fID] = $this->subscribe;   
              
    }
    
    function unsubscribe_to_forum(){
        
        $this->wDB->delete( 'awc_f_watchforums', array( 'wtchf_forum_id' => $this->fID, 'wtchf_mem_id' => $this->cur_memID ), ''); 
        unset($this->m_forum_subsrib[$this->fID]);
        
    } 
    
    
    
    function update_mem_thread(){
        
        $this->wDB->update( 'awc_f_mems',
                        array('m_thread_subsrib' => serialize($this->m_thread_subsrib),
                                'm_forum_subsrib' => serialize($this->m_forum_subsrib),), 
                        array('m_id' => $this->cur_memID),
                        '' );
    }
    

    
    function check_for_subscribed_members(){
    global $awc_tables;
     
        $email_adds = array();
        
        // this can be set in a HOOK to false to create your own user-email list
        if($this->email_lookup){  
            
            $rDB = wfGetDB( DB_SLAVE );
            $wiki_user = $rDB->tableName( 'user' );
        
            if($this->forum_or_thread == 'thread'){
                $sql = "SELECT wu.user_email, t.wtcht_mem_id FROM {$awc_tables['awc_f_watchthreads']} t
                        JOIN $wiki_user wu
                            ON t.wtcht_mem_id=wu.user_id
                        WHERE t.wtcht_thread_id=$this->tID AND t.wtcht_sent=0 AND t.wtcht_todo= 'email'";
            } else {
                $sql = "SELECT wu.user_email, f.wtchf_mem_id FROM {$awc_tables['awc_f_watchforums']} f
                        JOIN $wiki_user wu
                            ON f.wtchf_mem_id=wu.user_id
                        WHERE f.wtchf_forum_id=$this->fID AND f.wtchf_sent=0";
            }
                     
             
           $res = $rDB->query($sql);
            while ($r = $rDB->fetchObject( $res )) {
            
                if($this->forum_or_thread == 'thread'){
                     if($this->cur_memID != $r->wtcht_mem_id){ // "safe" check
                        if($r->user_email != '') $email_adds[] = $r->user_email;
                     }
                } else {
                     if($this->cur_memID != $r->wtchf_mem_id){ // "safe" check
                        if($r->user_email != '') $email_adds[] = $r->user_email;
                     }
                }
                     
            }
       }
       
        

        wfRunHooks( 'awcsforum_subscribe_get_email_address', array(&$email_adds, &$this) ); // 2.5.5
        
        if(!empty($email_adds)){
            
            require_once(awc_dir . 'send_mail.php');
            
                if($this->forum_or_thread == "thread"){
                    
                    $send_title = get_awcsforum_word('word_email_newreplieswaitingtitle') . ' ' . $this->title ;
                    $send_body = get_awcsforum_word('word_email_newreplieswaiting') ;
                    
                    $send_body .= " \n"  . $this->title;
                    $send_body .= " \n\n <a href='"  . awc_url . "st/id" . $this->tID . "'>". awc_url . "st/id" . $this->tID ."</a><br /><br />";
                    
                    
                    if($this->cf_send_post_body_in_email == '1'){                      
                            $send_body .= " \n" .  awcsforum_mailer::check_msg_len($this->post, $this->post_text_limit);
                    }
                    
                } else {
                    
                    $send_title = get_awcsforum_word('word_email_newreplieswaitingtitle_forum') . ' ' . $this->title  ;
                    $send_body = get_awcsforum_word('word_email_newreplieswaiting_forum') ;
                    
                    $send_body .= " \n"  . $this->title;
                    $send_body .= " \n\n <a href='"  . awc_url . "sf/id" . $this->fID . "'>". awc_url . "sf/id" . $this->fID ."</a><br /><br />";
                    
                    if($this->cf_send_thread_body_in_email == '1'){                        
                            $send_body .= " \n" . awcsforum_mailer::check_msg_len($this->post, $this->thread_text_limit);
                    }
                    
                }
                
                $html = true;
                if($this->send_email_html == '0') $html = false;
                
                awcsforum_mailer::send_mail($email_adds, $send_title, $send_body, $html);
                
                
                if($this->forum_or_thread == 'thread'){
                    $this->wDB->update( 'awc_f_watchthreads', 
                                array('wtcht_sent' => '1',), 
                                array('wtcht_thread_id' => $this->tID, 'wtcht_sent' => '0'), '' );
                } else {
                    $this->wDB->update( 'awc_f_watchforums', 
                                array('wtchf_sent' => '1',), 
                                array('wtchf_forum_id' => $this->fID, 'wtchf_sent' => '0'), '' );
                }
                
                
        }
        
        if($this->subscribe != 'no' AND $this->forum_or_thread != "thread"){
            self::subscribe_to_thread();
            self::update_mem_thread();  
        }
        
    }
    
    
}