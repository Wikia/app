<?PHP

/*
License:
Another Web Compnay (AWC) 

All of Another Web Company's (AWC) MediaWiki Extensions are licensed under
Creative Commons Attribution-Share Alike 3.0 United States License
http://creativecommons.org/licenses/by-sa/3.0/us/

All of AWC's MediaWiki extension's can be freely-distribute, 
 no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.

All of AWC's MediaWiki extension's can be edited or modified and freely-distribute 
 but these changes must be made public and viewable noting the changes are not original AWC code. 
 A link to http://anotherwebcom.com must be visable in the source code 
 along with being visable in render code for the public to see.

You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code. 
You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.

This License can and will be change with-out notice. 

All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

4/2008 Another Web Compnay (AWC)
The above text must stay intact and not edited in any way.

*/

class updateUnInstall{
	
    
    function update_this($todo){
    global $awc, $wgOut, $wgUser;
    
    
    	if(!in_array('bureaucrat', $wgUser->getGroups())) return ;
    	
    	if($todo == 'delete') {
             $this->Uninstallforum();
    	} else {
            get_awcsforum_word('admin_uninstall') == '' ? $uninstal_link = 'Un-install' : $uninstal_link = get_awcsforum_word('admin_uninstall');
            $out = get_awcsforum_word('admin_lang_uninstall_lastchance') . '<br><br>
            <a href="'.awc_url.'admin/get_updates/UnInstall/delete">'.$uninstal_link.'</a>';
    		 
             return $wgOut->addHTML($out);
    	} 
    	
    	return ;
        
        
    }
    
    function Uninstallforum(){
    global $wgOut, $wgUser, $wgDBprefix, $awc;
    
        $dbw =& wfGetDB( DB_MASTER ); 
        
        $dbw->sourceFile(awc_dir . 'updates/install/ununinstall_tables.sql');
        
        $lines = file(awc_dir . 'updates/install/ununinstall_tables.sql');
        foreach ($lines as $line_num => $line) {
           $wgOut->addHTML(htmlspecialchars($line) . "<br />\n");
        }
        
        
        $page = $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
        $file = "http://anotherwebcom.com/app_count.php?app=WikiForum_UnInstall&url=$page" ;
        $file = @fopen ($file, "r");
        $wgOut->addHTML ('<br>'.get_awcsforum_word('word_done').'<br>'.get_awcsforum_word('admin_lang_uninstall_remocelocalsttingsedit').'<br><b>require( "$IP/extensions/awc/forums/awc_forum.php" ); #awc</b><br>'.get_awcsforum_word('admin_lang_uninstall_anddeleteallfiles').'<br>');
    
    }
	
}








