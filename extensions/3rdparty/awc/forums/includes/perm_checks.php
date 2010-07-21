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
* @filepath /extensions/awc/forums/includes/checks.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


class awcs_forum_perm_checks{

private $bureaucrat = false;
private $UserGroupPerm = null;
private $dbTables = array();

    function __construct() {
        
        if(strstr(UserGroupPerm,'bureaucrat')) {
                $this->bureaucrat = true;
        }
        
        awcsforum_funcs::get_table_names(array('awc_f_cats', 'awc_f_forums'));
        
        $this->UserGroupPerm = explode(',', UserGroupPerm);
        
    }
    
     
    function cat_forum_sql(){

            if($this->bureaucrat) return ;
            
            $perm_where = self::cat_sql();
            $perm_where .= ' AND ';
            $perm_where .= self::forum_sql();
            $perm_where .= ' AND ';
            
            return $perm_where;
            
    }
    
    
    function cat_sql(){
        if($this->bureaucrat) return ;
        global $awc_tables;
        return " ({$awc_tables['awc_f_cats']}.c_wiki_perm LIKE '%".implode("%' OR {$awc_tables['awc_f_cats']}.c_wiki_perm LIKE '%",$this->UserGroupPerm)."%') ";
    }
    
    
    function forum_sql(){
        if($this->bureaucrat) return ;
        global $awc_tables;
        return " ({$awc_tables['awc_f_forums']}.f_wiki_read_perm LIKE '%".implode("%' OR {$awc_tables['awc_f_forums']}.f_wiki_read_perm LIKE '%",$this->UserGroupPerm)."%') ";
    }
    
    function can_read($f_wiki_read_perm){
        
        if($this->bureaucrat) return true ;
             
            $forum_perms = explode(',', $f_wiki_read_perm);
            foreach($forum_perms as $group){
                    if(in_array($group, $this->UserGroupPerm)){
                       return true;
                    }
            }
            
            return false;
            
    }
    
    function can_post($f_wiki_write_perm){
        
        if($this->bureaucrat) return true ;
        
            $forum_perms = explode(',', $f_wiki_write_perm);
            foreach($forum_perms as $group){
                    if(in_array($group, $this->UserGroupPerm)){
                       return true;
                    }
            }
            
            return false;
    }
    
    
    
    function is_password($f_passworded){
        
       // if($this->bureaucrat) return true ; // false
        
        // need some kind of chack here, when forum is passworded and user has already entered the password, sessions ???
        if($f_passworded == 1) return true;
        return false ;
        
    }
    
    
    
    function can_post_check($fID){
            
        $rDB = wfGetDB( DB_SLAVE );
        $r = $rDB->selectRow( 'awc_f_forums',  array( 'f_wiki_write_perm' ), array( 'f_id' => $fID ) );
        
        return self::can_post($r->f_wiki_write_perm);
        
    
    }
    
    



}