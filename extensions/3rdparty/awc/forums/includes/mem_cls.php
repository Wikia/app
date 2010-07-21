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
* @filepath /extensions/awc/forums/includes/mem_cls.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function GetMemInfo($n, $info = '', $uGroup = true){
global $wgOut, $wikieits, $awc_ver;
      
        $tmp = array();
        $tmp["name"] = null;
        $tmp["m_id"] = $n;
            
        $info[] = 'm_idname';
        $info[] = 'm_id';
       // awc_pdie($n);
       
        
        $user_fields = implode(',',$info);
        
        
    
            $dbr =& wfGetDB( DB_SLAVE );
            $dbr->ignoreErrors( true );
            
            
            if(!$r = $dbr->selectRow( 'awc_f_mems', 
                                array( $user_fields ), 
                                "m_id=$n",
                                __METHOD__, 
                                array('OFFSET' => 0 , 'LIMIT' =>  1))
              ){
              	
              	if(!$dbr->tableExists('awc_f_mems')){
	              	$dbr->ignoreErrors( false );
	            	$tmp['name'] = 'error_no_dbase_table';
	            	return $tmp;
              	}
				$dbr->ignoreErrors( false );
            	$tmp['name'] = '';
            	return $tmp;
			};

			if(empty($r) OR !isset($r)){
            	$tmp['name'] = '';
            	return $tmp;
            }
			
			
           # awc_pdie($r);
            if(empty($r) OR !isset($r)){
            	$tmp['name'] = '';
            	return $tmp;
            } 
            
            foreach($r as $k => $info){
                 # print($k . "<br />"); 
                switch($k){
                        
                        case 'm_idname':
                        case 'm_nickname':
                        	#awc_pdie($info);
                            $tmp['name'] = $info;
                           # if($tmp['name'] == '') $tmp['name'] = $r->m_idname;
                            
                        break;
                        
                        case 'm_adv':
                               $tmp['m_adv'] =  $r->m_adv ;
                                if(isset($r->m_adv_size)){
                                    $s = explode('x', $r->m_adv_size);
                                    $tmp['m_advw'] = isset($s[0]) ? $s[0] : '75' ;
                                    $tmp['m_advh'] = isset($s[1]) ? $s[1] : '75' ;
                                }
                        
                        break;
                        
                        case 'm_forum_subsrib':
                        case 'm_thread_subsrib':
                        case 'm_pmoptions':
                        case 'm_forumoptions':
                        case 'm_menu_options':
                              $tmp[$k] =  isset($info) ? unserialize($info) : '' ;
                             #$tmp[$k] = unserialize($info) ;
                        break;
                        
                    
                        default:
                            $tmp[$k] = $info;
                        break;
                    
                }
                
            	
            } 
            
            if($tmp['name'] == '') $tmp['name'] = $r->m_idname;
            
                  if($uGroup){  
                        $g='';
                        $wiki_user_tbl = $dbr->tableName('user');
                        $wiki_user_groups_tbl = $dbr->tableName('user_groups');
                        #$user_editcount = ', u.user_editcount';
                        
                        $user_editcount = ($wikieits == '1') ? ', u.user_editcount' :  null;
                           
                        $sql = "SELECT g.ug_group $user_editcount 
                                FROM $wiki_user_tbl u 
                                LEFT JOIN $wiki_user_groups_tbl g 
                                ON u.user_id=g.ug_user
                                WHERE u.user_id=$n ";
                                  
                        $res = $dbr->query($sql);
                        while ($r = $dbr->fetchObject( $res )) {
                            if(isset($r->user_editcount)) $tmp['edit_count'] = $r->user_editcount ;    
                           // $g .=  wfMsg($r->ug_group) . ", ";
                            $g .=  $r->ug_group . ", ";
                        }
                        $dbr->freeResult( $res );
                        
                        $g = substr($g,0, strlen($g) - 2);
                        $tmp['group'] = $g;
                        if ($g == "" ) $tmp['group'] = get_awcsforum_word('word_mem');
                        
                }
                        
            return $tmp;

}


function CanSearch(){
return true;
# awc_CanSearch
# awc_CanNotSearch
}

// m_menu_options

function CanDelete($u = ''){
global $awcUser;
    // this is loop through on all posts in a thread, find a better way
    if (!$awcUser->canDelete) return false ; 
	if(UserPerm >= 2 OR $awcUser->mName == $u) return true;
}
	
function CanEdit($u){
global $awcUser;

    // this is loop through on all posts in a thread, find a better way
    if ($awcUser->canEdit != '1') return false ;  
	if(UserPerm >= 2 OR $awcUser->mName == $u) return true;
}  
 	
function CanSig(){
global $awcUser;

   if ($awcUser->isAllowed("awc_CanNotHaveSig")) return false ; 
   
   if((in_array('bureaucrat', $wgUser->getGroups())) OR $awcUser->isAllowed("awc_ForumAdmin") OR $awcUser->isAllowed("awc_ForumMod") OR $awcUser->isAllowed("awc_CanHaveSig") AND !$awcUser->isAllowed("awc_CanNotHaveSig") ) return true;

   
}





class awcs_forum_mem{
	
	
}