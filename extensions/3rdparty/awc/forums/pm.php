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
* @filepath /extensions/awc/forums/pm.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

 
class awcforum_pm{
    
    function enter_pm($action){
    global $awc, $wgRequest, $wgOut, $skin; 
    
        
    }
    
    
    
    function sendpm($to_name, $title, $msg, $save_sent = false, $sendto_names = null){
    global $wgUser, $wgOut, $wgPasswordSender, $IP, $awc_tables, $awcs_forum_config;
    
    
       // awcsforum_funcs::get_page_lang(array('lang_txt_mem'));
       /* 
        
        if ( !file_exists($IP . '/includes/AutoLoader.php')){
            require($IP . "/includes/UserMailer.php");
        }
        */
    
    
    
        $sender_name = $wgUser->mName ;
        $sender_id = $wgUser->mId;
        
        $send_msg_text = false;
        if(isset($awcs_forum_config->cf_send_pm_body_in_email) AND $awcs_forum_config->cf_send_pm_body_in_email == '1'){
            $send_msg_text = true;
        }
        
        $user_get = array();
        $user_get[] = 'm_id';
        
        
        
        
        $dbw = wfGetDB( DB_MASTER );
        $date_seperated = $dbw->timestamp();
        
        $pm_count = null;
        $to_address = array();
        
        
        /* set up email stuff here so its not included in the loop */
        $send_title = get_awcsforum_word('mem_pm_email_newpmawaiting') . ' ' . $title ;   	
        $send_body = get_awcsforum_word('mem_pm_email_newpmawaitingbody') ;
        $send_body .= " \n"  . $sender_name;
        $send_body .= " \n\n <a href='"  . awcsforum_funcs::awcforum_url('member_options/pminbox') . "'>" . awcsforum_funcs::awcforum_url('member_options/pminbox') . "</a> \n\r\n\r";
        require_once(awc_dir . 'send_mail.php');
		
        $html = true ;
        if($awcs_forum_config->cf_send_email_html == '0') $html = false ;
                
        
        foreach($to_name as $id => $send_to_info){
        
            $pm_count ++;
        
            if($pm_count == 1){
            		#$bs = $dbw->nextSequenceValue( 'awc_f_pms_pm_id_seq' );
                    $dbw->insert( 'awc_f_pms', 
                                    array('pm_title' => $title,
                                            'pm_text' => $msg,
                                            ) );
                    $pm_id = awcsforum_funcs::lastID($dbw, 'awc_f_pms', 'pm_id');
                          
            }
            
            
                $dbw->insert( 'awc_f_pms_info', 
                                array('pmi_pmid' => $pm_id,
                                        'pmi_sender' => $sender_name,
                                        'pmi_sender_id' => $sender_id,
                                        'pmi_receipt_id' => $send_to_info['id'],
                                        'pmi_receipt' => $sendto_names,
                                        'pmi_send_date' => $date_seperated,
                                        ) );
                                        
                
                # $mem = GetMemInfo($id, $user_get);
                # if(isset($mem['name'])){
               # awc_pdie($wgUser->mId);
                if($send_to_info['forum_username'] != 'no_name' OR $send_to_info['id'] == $wgUser->mId){
                    
                     
                    $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} 
                                    SET m_pmtotal = m_pmtotal + 1,
                                    m_pmunread = m_pmunread + 1, 
                                    m_pminbox = m_pminbox + 1,
                                    m_pmpop = '1'
                                    WHERE m_id =" . $send_to_info['id'] );
                
                } else {
                    $dbw->insert( 'awc_f_mems', 
                                array('m_id' => $send_to_info['id'],
                                        'm_idname' => $send_to_info['name'] ,
                                        'm_pmtotal' => '1',
                                        'm_pmunread' => '1',
                                        'm_pminbox' => '1',
                                        'm_pmpop' => '1',
                                        ) );
                }       
            
                
             
            /* @changeVer 2.5.8 */
            if(isset($send_to_info['email']) && !empty($send_to_info['email']) && $send_to_info['email'] != 'no_email'){
                $to_address[] = new MailAddress( $send_to_info['email'] );
                
                if($send_to_info['pass_pm_text'] == '1' AND $send_msg_text){
                    $send_body .= "\n\r\n\r" . awcsforum_mailer::check_msg_len($msg, 0);
                }
                
                awcsforum_mailer::send_mail($to_address, $send_title, $send_body,$html);
            
            
            
            }
                  
        }
        
        
        if($save_sent){
                             
                $dbw->insert( 'awc_f_pms_info', 
                                array('pmi_pmid' => $pm_id,
                                        'pmi_sender' => $sender_name,
                                        'pmi_sender_id' => $sender_id,
                                        'pmi_receipt_id' => $sender_id,
                                        'pmi_receipt' => $sendto_names,
                                        'pmi_send_date' => $date_seperated,
                                        'pmi_folder_id' => '1',
                                        'pmi_read_date' => $date_seperated,
                                        'pmi_read'        => '1',
                                        ) );
                                        
                $mem = GetMemInfo($id, $user_get);
                if(isset($mem['name'])){                       
                      
                    $dbw->query( "UPDATE {$awc_tables['awc_f_mems']} 
                                    SET m_pmtotal = m_pmtotal + 1,
                                    m_pmsent = m_pmsent + 1
                                    WHERE m_id =" . $sender_id );
                } else {
                    $dbw->insert( 'awc_f_mems', 
                                array('m_id' => $sender_id,
                                        'm_idname' => $wgUser->mName ,
                                        'm_pmtotal' => '1',
                                        'm_pmsent' => '1',
                                        ) );
                }
        
        }
        
        
        
        
 
      $wgOut->redirect( awc_url . 'member_options/pminbox' );
            
    }
    
    
    
    
    
    
    
}




