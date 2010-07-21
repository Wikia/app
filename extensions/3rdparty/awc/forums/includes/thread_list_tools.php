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
* @filepath /extensions/awc/forums/includes/thread_list_tools.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


class awcs_forum_thread_list_tools{

private $skin ;
private $words = array();
private $list_limit;
private $block_limit;
private $isGuest;
private $html_ext;
private $alt_row = false;
private $show_guest_ip;

public $total_posts ;
public $link;
public $tID ;
public $thread_count = 0;
public $extra_column = false ;


    function __construct() {
     global $tplt, $awcs_forum_config, $awcUser, $str_len;
        
        $this->skin = $tplt;
        $this->list_limit = intval($awcs_forum_config->cfl_Post_DisplayLimit);
        $this->block_limit = intval($awcs_forum_config->cfl_PostPageBlockLimitThreadTitle);
        $this->html_ext = $awcs_forum_config->cf_html_extension;
        $this->threadtitlelength = $awcs_forum_config->cfl_ThreadTitleLength;
        $this->show_guest_ip = $awcs_forum_config->cf_show_guest_ip ;
        
        $this->words['last'] = get_awcsforum_word('word_last');
        $this->words['new_thread'] = get_awcsforum_word('1indicator_newThreadOrPost');
        $this->words['locked'] = get_awcsforum_word('1indicator_locked');
        $this->words['sticky'] = get_awcsforum_word('1indicator_sticky');
        $this->words['locked_sticky'] = get_awcsforum_word('1indicator_lockSticky');
        $this->words['poll'] = get_awcsforum_word('word_poll');
        $this->words['forums'] = get_awcsforum_word('word_forum');
        $this->words['guest'] = get_awcsforum_word('word_guest');
        
        $this->isGuest = $awcUser->guest;
        
       // if (function_exists('bcmod')) $this->alt_row = true;
        
        if (function_exists('mb_strlen')) {
           $str_len = 'awc_mbstrlen'  ; 
        } else {
           $str_len = 'awcsforum_funcs::awc_strlen' ;
        }
    }
    
    /**
     * 
     * @change 2.5.8 
    */
    function loop_thread_list($r){
    global $row_class;
    
        ++$this->thread_count;
       
            $info['poll'] = $r->t_poll ;
            $info['ann'] = $r->t_ann;
            $info['sticky'] = $r->t_pin;
            $info['locked'] = $r->t_status ;
            $info['t_id'] = $r->t_id ;
            $tID = $info['t_id'] ;
            $info['t_name'] = awcsforum_funcs::awc_html_entity_decode($r->t_name) ; 
            $info['t_name'] = str_replace('%', '&#37;', $info['t_name']);
            
           // die(">" . $this->show_guest_ip);
            if($this->show_guest_ip == '0' AND $r->t_lastuserid == '0' AND UserPerm < 2){
                $info['user'] = $this->words['guest'] ;
            } else {
                $info['user'] = $r->t_lastuser ;
            }
           // $info['user'] = $r->t_lastuser ;
            $info['userid'] = $r->t_lastuserid ;
            
            $info['link'] = awc_url;
            
            
            
            if($this->thread_count % 2) {
               $info['row_class'] = 'thread_rows0'  ;
            } else {
               $info['row_class'] = 'thread_rows1'   ; 
            }
             
           
           $to_tplt = self::Check_ShowForumRows($info);
            
            $to_tplt['mem_url'] = awcsforum_funcs::awcforum_url("mem_profile/{$r->t_starter}/{$r->t_starterid}");
            // 
            $to_tplt['thread_title'] = awcsforum_funcs::awc_html_entity_decode($info['t_name']);
            
            $to_tplt['mod'] = (UserPerm >=2 AND $r->t_ann != '1' ) ? '<INPUT type="checkbox" name="tID[]" value="'.$info['t_id'].'">' : null;
            
            $to_tplt['col_5_isSearch_forum_name'] = '';
            
            $to_tplt['t_starter'] = $r->t_starter;
            if($this->show_guest_ip == '0' AND $r->t_starterid == '0' AND UserPerm < 2){
            	$to_tplt['t_starter'] = $this->words['guest'] ;
            } 
            
            $to_tplt['t_topics'] = $r->t_topics;
            $to_tplt['t_hits'] = $r->t_hits;
            $to_tplt['last'] = '<a href="'.awc_url.'last_post/id'.$r->t_id.'">' . awcsforum_funcs::convert_date($r->t_lastdate, "s") . '</a>' ;
            $to_tplt['user'] = $info['user'];
            
            $to_tplt['NewPost'] = self::new_thread_check($r->t_id, $r->t_lastdate) ;
            
            $this->link = awc_url;
            $this->tID = $r->t_id;
            $this->total_posts = $r->t_topics;
            $to_tplt['jump'] = self::GetThreadPostLimit();
            
            if($this->extra_column){
                if(!isset($tplt)) global $tplt;
                $to_tplt['forum_name'] = $r->f_name ; 
                $word['forum_name'] = $this->words['forums'];
                $to_tplt['col_5_isSearch_forum_name'] = $tplt->phase($word, $to_tplt, 'col_5_isSearch_forum_name'); // move
            }
            
            return $to_tplt;
    }
    
    function new_thread_check($tID, $t_lastdate){
        
        if($this->isGuest) return ' ';
        
        $t_lastdate = awcsforum_funcs::wikidate($t_lastdate);
                   
        if( $t_lastdate > $_SESSION['awc_startTime']){
            $_SESSION['awc_nActive'][$tID] = $t_lastdate ;
        } 
    
        $NewThread = null;
        
       if(isset($_SESSION['awc_nActive'][$tID])){
           
           if(isset($_SESSION['awc_rActive'][$tID]) AND isset($_SESSION['awc_rActive'][$tID])){ 
                 if($_SESSION['awc_rActive'][$tID] != $_SESSION['awc_nActive'][$tID]){
                    $NewThread = $this->words['new_thread'];
                 }
           } else {
               $NewThread = $this->words['new_thread'];
           }
       }
               
     return $NewThread;
    }

    
    
   function GetThreadPostLimit(){ 
       
            $this->total_posts = intval($this->total_posts) ; 
           // die(">". $this->total_posts);
            
           // if($this->total_posts != 0) die(">". $this->total_posts);
            
            $last_id = '/#last';
            $tmp = ' ';

            $total_page_count = intval($this->total_posts/$this->list_limit)   ;
            
          // die(">". $this->block_limit);
            
            if($this->total_posts <= $this->list_limit) return ;
            $url = $this->link . 'st/id' . $this->tID . '/' ;
           
            $sLimit = 0;
            $endOfLimit = false;
            for( $i = 0; $i < $this->block_limit; ++$i ) {
                  #$n++;
                  
                   $sLimit = intval(($sLimit + $this->list_limit));
                   
                   # check to see if the Page Block is equle ot total post so extra Page Blocks are not displayed
                   if($sLimit >= ($this->total_posts)){
                       $endOfLimit = true;
                        break;
                   }
                     $info['click'] = ($i+2) ;
                     $info['url'] = $url . 'limit:' . $sLimit .',' . $this->list_limit  . $last_id ;
                     $tmp .= $this->skin->phase('', $info, 'postblocks_threadlisting');
                                      
                }
           
           if(!$endOfLimit){
                 $info['click'] = $this->words['last'] ; 
                 $info['url'] = $url . 'limit:' . ($this->total_posts - $this->list_limit) .',' . ($this->list_limit+2)  . $last_id ;
                 $tmp .= $this->skin->phase('', $info, 'postblocks_threadlisting');
           }
           
           if($tmp != ''){
                 $info['click'] = '1' ;
                 $info['url'] = $url . 'limit:0,' . $this->list_limit . $last_id ;
                 $tmp = $this->skin->phase('', $info, 'postblocks_threadlisting') . $tmp ;
           }
            
        return $tmp ;        
  }
  
    function Check_ShowForumRows($info){
    global $str_len;
                                               
            if($str_len($info['t_name']) > $this->threadtitlelength) $info['t_name'] = awcsforum_funcs::awc_shorten($info['t_name'], $this->threadtitlelength ) . "..." ; 
            
            if ($info['user']) $info['user'] = "<a href='". awcsforum_funcs::awcforum_url('mem_profile/' .$info['user'].'/'.$info['userid'])."'>".$info['user'] ."</a>";
            
            if(isset($info['search_words'])) {
               $info['thread_url'] = awcsforum_funcs::awcforum_url('st/id' . $info['t_id'] . $info['search_words']); 
            } else {
                
               $info['thread_url'] = awcsforum_funcs::awcforum_url('st/id' . $info['t_id'] . '/' . str_replace(array('>', '<'), ' ', $info['t_name']) ). $this->html_ext ;  
            }
            
            $classID = "row_info";
            $info['indicator_lock_sticky_ann'] = null;
            if(isset($info['locked']) AND $info['locked'] == "1"){
                    $info['indicator_lock_sticky_ann'] = $this->words['locked'] . ' ';
                    //$info['row_class']  =  'locked_thread' ;
            }
                
            if(isset($info['sticky']) AND $info['sticky'] == "1"){
                     $info['indicator_lock_sticky_ann'] = $this->words['sticky'] . ' ';
                     $info['row_class']  =  'sticky' ;
            }
              
             
              if(isset($info['sticky']) AND isset($info['locked']))
                if ($info['sticky'] == "1" AND $info['locked'] == "1") {
                     $info['indicator_lock_sticky_ann'] =  $this->words['locked_sticky'] . ' ';
                     $info['row_class']  =  'sticky' ;
                }
                
            if(isset($info['poll']) AND $info['poll'] == "1"){
                     $info['indicator_lock_sticky_ann'] = $this->words['poll'] . ' ';
                     $info['row_class']  = 'poll_thread_listing';
            }
              
        return $info ;
    }






}
