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
* @filepath /extensions/awc/forums/includes/funcs.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/



// gotta do something with these...
require_once(awc_dir . 'includes/simle.php');
require_once(awc_dir . 'includes/mem_cls.php');
require_once(awc_dir . 'includes/thread_list_tools.php');
require_once(awc_dir . 'includes/perm_checks.php');


/**
*  Testing/Dev
* @parameter string $v
* @since Version 2.5.8
*/
function awc_pdie($v){
    print "<pre>\n";
    print_r($v);
    print "\n</pre>";
    die();
}
        

/**
*  Lang keys to-> text
* @parameter string $key
* @return string
* @since Version 2.5.8
*/       
function get_awcsforum_word($key) {
global $awc_lang ;

     if(isset($awc_lang)){
         /*
             if(array_key_exists($key, $awc_lang)){
                return str_replace(array(chr(10), chr(13)), '', $awc_lang[$key]);
            }
        */
         if(isset($awc_lang[$key])){
            return str_replace(array(chr(10), chr(13)), '', $awc_lang[$key]);
        }
        
     }
     
}



/**
*  String length with chrset
* @parameter string $str
* @return string
* @since Version 2.5.8
*/  
function awc_mbstrlen($str){
    $str = mb_strlen($str, awc_forum_charset);
    return $str;
}

/**
* @parameter string $str
* @return string
* @since Version 2.5.8
*/  
function awc_strlen($str){
    $str = strlen($str);
    return $str;
}
        
        
/**
* General Forum Function
* @since Version 2.5.0
*/   
class awcsforum_funcs{

        /**
        * Encode URL's add HTTP to front
        * @parameter string $s
        * @return string
        * @since Version 2.5.8
        */ 
        public static function awcforum_url($s){
              // wfUrlencode
            $s = str_replace(array(' ', '%2F'), array( '_', '/'), $s);
            $s = urlencode($s);
            $s = str_replace('%2F', '/', $s);
            $s = awc_url . $s;
            return $s;       
                
        }
        
        public static function limitSplit($limit){
        	$limit = str_replace('LIMIT ', '', $limit);
        	$limitSplit = explode(',', $limit);
        	$ret['offset'] = (isset($limitSplit[0])) ? $limitSplit[0] : 0;
        	$ret['limit'] = (isset($limitSplit[1])) ? $limitSplit[1] : 1;
        	return $ret;        
        }

        /* @TODO PostgreSQL lastID
         * Cant get Postgre to return the correct 'lastID' entry
         * so this function was created
         */
        public static function lastID($db, $table, $col){
        global $wgDBtype;
        
	 		 
	 		 
        	 switch( $wgDBtype ) {
        	 	
				case 'postgres':
					$r = $db->selectRow( $table, 
                                array( $col ), '' , __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1, 'ORDER BY' => "$col DESC"));
                     $id = $r->$col;
				break;
				
				default:
					$id = $db->insertId();
				break;
				
	 		}
	 		
	 		return $id;
	 		
        }



        public static function awcf_checkserverload(){

        return file_get_contents('/proc/loadavg');
        
        $loadresult = @exec('uptime');
        preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$loadresult,$avgs);

        //GET SERVER UPTIME
        $uptime = explode(' up ', $loadresult);
        $uptime = explode(',', $uptime[1]);
        $uptime = $uptime[0].', '.$uptime[1];

        $data .= "Server Load Averages $avgs[1], $avgs[2], $avgs[3]\n";
        $data .= "Server Uptime $uptime";

        return $data;
        }
        
        
        public static function addSQLtables($table, $str){
        	
        	
        }


        /**
        * Get wiki dBase table name with prefix
        * @parameter string $tables
        * @parameter boolean $all
        * @since Version 2.5.0
        * @return array
        * @changeVer 2.5.8 - made method public static
        */ 
        public static function get_table_names($tables, $all = false){ // 
        global $awc_tables;
        
            $dbr = wfGetDB( DB_SLAVE );
            
            foreach($tables as $table){
                $awc_tables[$table] = $dbr->tableName($table);
            }
            
            if(!$all) return ;
            
            $awc_tables['awc_f_config'] = $dbr->tableName('awc_f_config');
            $awc_tables['awc_f_stats']= $dbr->tableName('awc_f_stats');
            $awc_tables['awc_f_sessions'] = $dbr->tableName('awc_f_sessions');

            $awc_tables['awc_f_watchthreads'] = $dbr->tableName('awc_f_watchthreads');
            $awc_tables['awc_f_watchforums'] = $dbr->tableName('awc_f_watchforums');
            
            $awc_tables['awc_f_cats'] = $dbr->tableName('awc_f_cats');
            $awc_tables['awc_f_threads'] = $dbr->tableName('awc_f_threads');
            $awc_tables['awc_f_forums'] = $dbr->tableName('awc_f_forums');
            $awc_tables['awc_f_polls'] = $dbr->tableName('awc_f_polls');
            $awc_tables['awc_f_posts'] = $dbr->tableName('awc_f_posts');
            $awc_tables['awc_f_anns'] = $dbr->tableName('awc_f_anns');
            $awc_tables['awc_f_member_titles'] = $dbr->tableName('awc_f_member_titles');
            
            $awc_tables['awc_f_mems'] = $dbr->tableName('awc_f_mems');
            $awc_tables['awc_f_pms'] = $dbr->tableName('awc_f_pms');
            $awc_tables['awc_f_pms_info'] = $dbr->tableName('awc_f_pms_info'); 
            
            $awc_tables['awc_f_langs'] = $dbr->tableName('awc_f_langs');
            
            $awc_tables['awc_f_emotions'] = $dbr->tableName('awc_f_emotions');

        }


        /**
        * User Periossions
        * @parameter object $wg_User
        * @since Version 2.5.0
        * @return int
        * @changeVer 2.5.8 - made method public static
        */
        public static function GetUserPermission($wg_User){
            
            if(in_array('bureaucrat', $wg_User->getGroups()) OR in_array('sysop', $wg_User->getGroups())) return 10;
            if($wg_User->isAllowed("awc_ForumAdmin")) return 10;
            if($wg_User->isAllowed("awc_ForumMod")) return 2;
            if(isset($wg_User->mId) AND $wg_User->mId != '0') return 1; 
            
            return 0;
        }



        /**
        * Shorten string
        * @parameter string $str
        * @parameter string $len
        * @since Version 2.5.0
        * @return string
        * @uses mb_substr
        * @changeVer 2.5.8 - made method public static
        */
        public static function awc_shorten($str, $len = "test"){ 
            return mb_substr($str,0, $len, awc_forum_charset);
        }

        /**
        * Convert all HTML entities to their applicable characters
        * @parameter string $str
        * @since Version 2.5.0
        * @return string
        * @uses html_entity_decode
        * @changeVer 2.5.8 - made method public static
        */
        public static function awc_html_entity_decode($str){  
            return html_entity_decode($str, ENT_QUOTES, awc_forum_charset);
        }

        /**
        * Convert all applicable characters to HTML entities
        * @parameter string $str
        * @since Version 2.5.0
        * @return string
        * @uses htmlentities
        * @changeVer 2.5.8 - made method public static
        */
        public static function awc_htmlentities($str){
            return htmlentities($str, ENT_QUOTES, awc_forum_charset);
        }

        /**
        * Convert special characters to HTML entities
        * @parameter string $str
        * @since Version 2.5.0
        * @return string
        * @uses htmlspecialchars
        * @changeVer 2.5.8 - made method public static
        */
        public static function awc_htmlspecialchars($str){
            return htmlspecialchars($str, ENT_QUOTES, awc_forum_charset);
        }


        /**
        * Clears forum cookie
        * @since Version 2.5.0
        * @uses setcookie
        * @changeVer 2.5.8 - made method public static
        */
        public static function clear_awcsforum_cookie(){
        Global $wgCookieExpiration , $wgCookiePath, $wgCookieDomain;   
        
            $exp = time() + $wgCookieExpiration; 
            setcookie('awc_startTime', '', $exp, $wgCookiePath, $wgCookieDomain );  
        }


        /**
        * Set forum session vars
        * @since Version 2.5.0
        * @uses wikidate
        * @changeVer 2.5.8 - made method public static
        */
        public static function set_session($timeis){
        Global $awcUser;

            wfSuppressWarnings(); # session was kicking up error on some peoples servers and not other, dont know how to fix :)
            
                $timeis = awcsforum_funcs::wikidate($timeis);
                //$_SESSION['awc_startTime'] = awcsforum_funcs::wikidate($awcUser->m_lasthere);   // notes: what am i doeing with this ????
                $_SESSION['awc_startTime'] = $timeis;
                $_SESSION['awc_nActive']['nA'] = 'a';
                $_SESSION['awc_rActive']['rA'] = 'a';
                
            wfRestoreWarnings();
            
        }

        /**
        * Clears forum session vars
        * @since Version 2.5.0
        * @changeVer 2.5.8 - made method public static
        */
        public static function clear_session(){
         
            wfSuppressWarnings(); # session was kicking up error on some peoples servers and not other, dont know how to fix :)
                if(isset($_SESSION['awc_startTime'])) unset($_SESSION['awc_startTime']);
                if(isset($_SESSION['awc_nActive'])) unset($_SESSION['awc_nActive']);
                if(isset($_SESSION['awc_rActive'])) unset($_SESSION['awc_rActive']);
            wfRestoreWarnings();  
        }
	    
        /**
        * Adds forum lagnuage files to global array
        * @since Version 2.5.0
        * @changeVer 2.5.8 - made method public static
        */  
        public static function combin_lang(&$new_lang){
        global $awc_lang ; 
            if($new_lang == '') return;
             foreach ($new_lang as $k => $v) {
                 $awc_lang[$k] = $v ;
             }
             unset($new_lang);
        }
        
        /**
        * Pulls language definitions from dBase, sets global array
        * @since Version 2.5.0
        * @uses unserialize
        * @changeVer 2.5.8 - made method public static, restructed lang table
        */
        public static function get_page_lang($col){
        global $awc_currnt_lang_setting, $awc_lang;
                   
                if ( file_exists( awc_dir .'languages/LanguageEn.php')){  // just a check for back-word compatiablity 
                    require(awc_dir .'languages/LanguageEn.php'); 
                } else {
                    
                    $get_cols = null;
                    foreach($col as $cols){
                        $get_cols .= " $cols,";
                    }
                    $get_cols = substr($get_cols, 0, -1);
                      
                    $dbr = wfGetDB( DB_SLAVE );
                    
                    $r = $dbr->selectRow( 'awc_f_langs', 
                                        array( $get_cols ), 
                                        array( 'lang_code' => $awc_currnt_lang_setting ) );

                    
                    foreach($r as $langObj){
                    	$combinlang = unserialize($langObj); 
                    	awcsforum_funcs::combin_lang($combinlang); 
                    }
                    
                    unset($dbr, $r, $combinlang, $get_cols, $langObj, $col);

                }
                
        }
	        

        /**
        * Breaks up date string
        * @since Version 2.5.0
        * @parameter string $srt
        * @return string
        * @changeVer 2.5.8 - made method public static
        */
        public static function readabledate($srt){

            $year = substr($srt, 0, 4);
            $month = substr($srt, 4, 2);
            $day = substr($srt, 6, 2);
            
            $hour = substr($srt, 8, 2);
            $min = substr($srt, 10, 2);
            $sec = substr($srt, 12, 2);
            
            return $year . '_' . $month . '_' . $day . '__' . $hour . '_' . $min . '_' . $sec;      
        }


        /**
        * Format date numbers to words - check users timezone also
        * @since Version 2.5.0
        * @return string $srt (date numbers)
        * @parameter string $srt (date numbers)
        * @parameter string $t (how to format, long or short)
        * @parameter string $skip (??? dont know, find out why)
        * @todo Find out what the $skip parameter is for
        * @uses wikidate
        * @changeVer 2.5.8 - made method public static
        */
        public static function convert_date($srt, $t, $skip = false){
        global $awcs_forum_config, $awcUser;
        
                global $wgLang;
		        $srt = awcsforum_funcs::wikidate($srt);
                
                    if(isset($awcUser->timecorrection)){
                        $user_timeShift = $awcUser->timecorrection;
                        $srt = $wgLang->userAdjust( $srt, $user_timeShift);
                    } else {
                        $srt = $wgLang->userAdjust( $srt, 0);
                    }
                    
                    
                    if($t == "l"){
                        $date = $awcs_forum_config->cf_DateLong;
                    } else {
                        $date = $awcs_forum_config->cf_DateShort;
                    }
                    
                    $year = substr($srt, 0, 4);
                    $month = substr($srt, 4, 2);
                    $day = substr($srt, 6, 2);
                    
                    $hour = substr($srt, 8, 2);
                    $min = substr($srt, 10, 2);
                    $sec = substr($srt, 12, 2);
		        
		        # $srt2 = @date( $date, mktime($hour , $min, $sec, $month, $day, $year) ) ;
                
        return date( $date, mktime($hour , $min, $sec, $month, $day, $year) ) ;
        }

        /**
        * Remove colon : space and dash - from date string
        * @since Version 2.5.0
        * @parameter string $srt
        * @return string
        * @changeVer 2.5.8 - made method public static
        */
        public static function wikidate($srt){
            return str_replace(array(':', ' ', '-'), "", $srt);
        }

        /**
        * Format date string with dashs and colons
        * @since Version 2.5.0
        * @parameter string $srt
        * @return string
        * @changeVer 2.5.8 - made method public static
        */
        public static function date_seperated($srt){
            
            $year = substr($srt, 0, 4);
            $month = substr($srt, 4, 2);
            $day = substr($srt, 6, 2);
            
            $hour = substr($srt, 8, 2);
            $min = substr($srt, 10, 2);
            $sec = substr($srt, 12, 2);
                    
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec ;
        }   
            
}

    
