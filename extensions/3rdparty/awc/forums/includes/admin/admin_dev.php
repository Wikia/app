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
* @filepath /extensions/awc/forums/admin/admin_dev.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

function awcs_forum_dev_func(){
global $action_url, $wgUser;

    
    if(!in_array('bureaucrat', $wgUser->getGroups())) die("need to be a bureaucrat");


    #awc_pdie($action_url);
    $dev = new awcs_forum_dev_cls();
    $dev->todo = $action_url['todo'];
    
    switch($dev->todo){
        
        case 'write_uninstall_tables':
            $dev->write_uninstall_tables();
        break;
        
        case 'write_install_tables':
            $dev->write_install_tables();
        break;
        
        case 'write_lang':
            $dev->write_lang();
        break;
        
        case 'write_tplt':
            $dev->write_tplt();
        break;
        
        case 'write_css':
            $dev->write_css();
        break;
        
        case 'write_tplt_to_wiki':
            $dev->write_tplt_to_wiki();
        break;
        
        case 'write_tplt_section_to_wiki':
            $dev->write_tplt_section_to_wiki();
        break;
        
        case 'write_admin_config_to_wiki':
            $dev->write_admin_config_to_wiki();
        break;
        
        case 'tmplt_show_version_plus':
            $dev->tmplt_show_version_plus();
        break;
        
        case 'create_install_files':
            $dev->create_install_files();
        break;
        
        default:
             $dev->export();
        break;
    
    }
    
   
    

}

class awcs_forum_dev_cls{
    
    var $todo;
    var $disclaimer = "/*
License:
Another Web Compnay (AWC) 

All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
Creative Commons Attribution-Share Alike 3.0 United States License<br />
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

*/";


    function tmplt_show_version_plus(){
    
    
    
    
    }
    
    function create_install_files(){

       // die("here");
            self::write_uninstall_tables();
            self::write_install_tables();
            self::write_lang();
            self::write_tplt();
            self::write_css();
            
    }


    function export(){
        global $wgOut, $awcs_forum_config ;
        
         $html = '<br /><form enctype="multipart/form-data" action="'. awc_url .'admin/tplt/export_xml" method="POST">';
         $html .= '<input name="ver" type="text" value="">'; 
         $html .= '<input type="submit" value="Export TPLT forum ver"></form>';
         
         $html .= '<br /><form enctype="multipart/form-data" action="'. awc_url .'admin/tplt/search_version" method="POST">';
         $html .= '<input name="ver" type="text" value="">'; 
         $html .= '<input type="submit" value="Search TPLT forum ver"></form>';
         
         
        
        
         $html .= '<br /><br /><form enctype="multipart/form-data" action="'. awc_url .'admin/css/export_xml" method="POST">';
         $html .= '<input name="ver" type="text" value="">'; 
         $html .= '<input type="submit" value="Export CSS forum ver"></form>';
         
         
         $html .= '<br /><form enctype="multipart/form-data" action="'. awc_url .'admin/css/search_version" method="POST">';
         $html .= '<input name="ver" type="text" value="">'; 
         $html .= '<input name="css_id" type="hidden" value="'.$awcs_forum_config->cf_css_default.'">'; 
         $html .= '<input type="submit" value="Search CSS forum ver"></form>';
         
         
         $html .= '<br /><br />';
         $html .= '<a href="'.awc_url.'admin/dev/create_install_files">Create Install Files</a><hr />';
         
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_uninstall_tables">write_uninstall_tables</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_install_tables">write_install_tables</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_css">write_css</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_tplt">write_tplt</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_lang">write_lang</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_tplt_to_wiki">write_tplt_to_wiki</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_tplt_section_to_wiki">write_tplt_section_to_wiki</a>';
         
         $html .= '<br />';
         $html .= '<a href="'.awc_url.'admin/dev/write_admin_config_to_wiki">write_admin_config_to_wiki</a> ';
         $html .= ' - <a href="'.awc_path.'updates/install/admin_settings.html">admin_settings.html</a>';
         
         
        $html .= '<br /><br />';
        $wgOut->addHTML($html);
    }
    
    
    function write_admin_config_to_wiki(){
    
        $out = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head></head><body>';
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_config = $dbr->tableName( 'awc_f_config' );  
        $sql = "SELECT * 
                FROM $awc_f_config " ; 
        
       # die($sql);
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            #$when = isset($r->thmn_when) ? $r->thmn_when : wfTimestampNow() ;
            
            $out .= $this->wiki_top_editing_box($r->q.' (AdminCP Setting)');
            
            $out .= '<textarea name="wpTextbox1" id="wpTextbox1" rows="0" cols="20" >';
            
            $out .= "\n== Setting Information ==\n";
            
            $out .= "'''Setting Name''' <br />\n";
            $out .= get_awcsforum_word($r->q);
            $out .= "\n\n";
            
            $out .= "'''Default Setting''' <br />\n";
            if($r->typeis == 'yesno' AND $r->a == '1'){
                $out .= "Yes";
            }elseif($r->typeis == 'yesno' AND $r->a == '0'){
                $out .= "No";
            } else {
                $out .= $r->a;
            }
            $out .= "\n\n";
            
            $out .= "'''Setting Type''' <br />\n";
            
            if($r->typeis == 'drop'){
                $out .= "Drop down option";  
            } elseif($r->typeis == 'yesno'){
                $out .= "Yes/No toggle"; 
            }else {
                $out .= "Text entry"; 
            }
            $out .= "\n\n";
            
            
            $out .= "'''Admin Section''' <br />\n";
            switch($r->section){
                
                case 'general':
                    $out .= get_awcsforum_word('admin_display_geneal_options');
                break;
                
                case 'forum':
                    $out .= get_awcsforum_word('admin_display_forum_options');
                break;
                
                case 'mem':
                    $out .= get_awcsforum_word('admin_display_mem_options');
                break;
                
                case 'thread':
                    $out .= get_awcsforum_word('admin_display_thread_options');
                break;
                
                case 'forum_tag':
                    $out .= get_awcsforum_word('admin_display_forumtag_options');
                break;
            
            }

            $out .= "\n\n";
            
            $out .= "\n== What it does ==\n";
            $out .= "coming soon... \n\n\n\n";
            $out .= '[[Category:Forum AdminCP Settings]]';
            $out .= "\n";
            $out .= '</textarea>';
            
            $out .=  $this->wiki_bot_editing_box(str_replace('"', '', $r->q));
            
        }
        $dbr->freeResult( $res );
        
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
        
        //awc_default   
        
        $out .= '</body></html>';
        self::write_file('admin_settings.html', $out);
        
    
    }
    
    function write_install_tables(){
    global $wgDBprefix, $wgDBname;
    
    
            $dbr = wfGetDB( DB_SLAVE );
            
            $out = '<?PHP';
            $out .= "\n";
            $out .= $this->disclaimer;
            $out .= "\n";
            $out .= "\n";
            $out .= '// require_once(awc_dir . "updates/install/install_tables.php")';
            $out .= "\n";
            $out .= "\n";
            $out .= '$sql = array();';
            $out .= "\n";
            $out .= '$sql_table = array();';
            $out .= "\n";
            $out .= "\n";
            $out .= 'Global $wgDBprefix;';
            $out .= "\n";
            $out .= '$dbr = wfGetDB( DB_SLAVE );';
            $out .= "\n";
            $out .= "\n";
            
            $count = 0;
            $sql = "SHOW TABLES FROM $wgDBname " ;   
            $res = $dbr->query($sql); 
            while ($r = $dbr->fetchObject( $res )) {
                
                   $table_name = $r->Tables_in_mw_mainsite;
                   
                   if(strstr($table_name, $wgDBprefix . 'awc_f_')){
                   
                       ++$count ; 
                          
                       $res2 = $dbr->query("SHOW CREATE TABLE $table_name");
                       $r2 = $dbr->fetchRow( $res2 );
                       #$dbr->freeResult( $r2 );
                       
                       $create_table = $r2['Create Table'];
                       $create_table = str_replace('CREATE TABLE `','CREATE TABLE `".$wgDBprefix."', $create_table);
                       
                       $table = $r2['Table']; 
                       
                       $out .= "\n";
                       $out .= '$sql_table['.$count.'] = $wgDBprefix.\''.$table.'\';';
                       $out .= "\n";
                       $out .= '$sql['.$count.'] = "' . $create_table . "; \";";
                       $out .= "\n";
                       $out .= "\n";
                       
                      # awc_pdie($out);
                       
                        #$out .= '$sql_delete_table_name[] = $wgDBprefix."'.str_replace($wgDBprefix, '', $table_name).'";' . "\n";
                   
                   }
            }
            
            $out .= "\n";
            $out .= "\n";
            
            $out .= '
            
    foreach($sql_table as $k => $v ){
        
        $old = $dbr->ignoreErrors( true );
        $res = $dbr->query( "SELECT 1 FROM $v LIMIT 1" );
        $dbr->ignoreErrors( $old );
        if( $res ) {
            $dbr->freeResult( $res );
             unset($sql[$k]);
        }
    }
    unset($sql_table, $res, $k, $v);
        
            ';
            
            self::write_file('install_tables.php', $out);
            
    
    }
    
    function write_uninstall_tables(){
    global $wgDBname, $wgDBprefix ;
    
            $dbr = wfGetDB( DB_SLAVE );
            
            $out = '<?PHP';
            $out .= "\n";
            $out .= $this->disclaimer;
            $out .= "\n";
            $out .= "\n";
            $out .= '// require_once(awc_dir . "updates/install/delete_tables.php")';
            $out .= "\n";
            $out .= "\n";
            $out .= 'global $sql_delete_table_name, $wgDBprefix;';
            $out .= "\n";
            $out .= '$sql_delete_table_name = array();';
            $out .= "\n";
            $out .= "\n";
            
            $sql = "SHOW TABLES FROM $wgDBname " ;   
            $res = $dbr->query($sql); 
            while ($r = $dbr->fetchObject( $res )) {
                
                   $table_name = $r->Tables_in_mw_mainsite;
                   
                   if(strstr($table_name, $wgDBprefix . 'awc_f_')){
                        $out .= '$sql_delete_table_name[] = $wgDBprefix."'.str_replace($wgDBprefix, '', $table_name).'";' . "\n";
                   }
            }
            
            $out .= "\n";
            
            self::write_file('delete_tables.php', $out);
            
    }
    
    function write_lang(){
    
               $out = "<?PHP " . chr(10) . chr(10);
               
                $fields = array();
                $fields[] = 'lang_txt_forum_raw';
                $fields[] = 'lang_txt_admin_raw';
                $fields[] = 'lang_txt_mem_raw';
                $fields[] = 'lang_txt_tag_raw';
                $fields[] = 'lang_txt_search_raw';
                $fields[] = 'lang_txt_errormsg_raw';
                $fields[] = 'lang_txt_thread_raw';
                $fields[] = 'lang_txt_redirects_raw';
                $fields[] = 'lang_owner_info';
                
                $lang_info = lang_getinfo('en' ,$fields);
                
                unset($fields);
                
                $lang_info = array_pop($lang_info);
                
                unset($lang_info['lang_code'],  $lang_info['lang_id'] );
                
                foreach($lang_info as $section => $key){
                    
                        $section_name = str_replace('_raw','',$section);
                        
                        $out .= "$$section_name = array( " . chr(10) ;
                        
                            foreach($lang_info[$section] as $k => $v){
                                $out .= "'" . $k . "' => \"" . str_replace('"', '\"', trim($v)) . '", ' . chr(10);
                            }
                        
                        $out .= ");"  . chr(10)  . chr(10);
                }
                
                self::write_file('lang.txt', $out);
                

    
    }
    
    
    function write_css(){
    global $awcs_forum_config;
        
        require(awc_dir . 'includes/admin/admin_css_funk.php');
        $css_cls = new awc_admin_css_cls();
        $css_cls->css_id = $awcs_forum_config->cf_css_default;
        $out = $css_cls->export_xml(false, true); 
        
        self::write_file('css.xml', $out);
    }
    
    function write_tplt(){
    global $awcs_forum_config;  
    
        require(awc_dir . 'includes/admin/admin_tplt.php');
        $tplt_cls = new awc_admin_tplt_cls();
        $tplt_cls->thmn_id = $awcs_forum_config->thmn_id;
        $out = $tplt_cls->export_xml(true);
        
        self::write_file('tplt.xml', $out);
    }
    
    
    function write_tplt_to_wiki(){
    global $awcs_forum_config, $wgUser;
        
       # awc_pdie($awcs_forum_config->thmn_id);
        $out = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head></head><body>';
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_tplt = $dbr->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT * 
                FROM $awc_f_theme_tplt 
                WHERE tplt_thmn_id=$awcs_forum_config->thmn_id" ; 
        
       # die($sql);
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            #$when = isset($r->thmn_when) ? $r->thmn_when : wfTimestampNow() ;
            
            $token = htmlspecialchars( $wgUser->editToken() );
            
            $out .=  $this->wiki_top_editing_box($r->tplt_function.' (Forum Skin Template)');
                        
                $out .= '<textarea name="wpTextbox1" id="wpTextbox1" rows="0" cols="10" >';
            $out .= '__NOTOC__';
            $out .= "==Default Code== \n";
            $out .= "''Template Name:'' '''" . str_replace('_', ' ' , $r->tplt_function) . "'''\n\n";
            $out .= "''Section:'' " . str_replace('_', ' ' , $r->tplt_section) . "\n\n";
            $out .= "===Version Infomation=== \n";
            $out .= "Introduced in Forum Version $r->tplt_forum_ver <br />";
            $out .= "Code Version $r->tplt_ver \n\n";
            $out .= "===Status=== \n";
            $out .= "''Active''  \n\n";
            $out .= "----  \n";
            $out .= "===Information about this code=== \n";
            $out .= "n/a  \n \n \n";
             $out .= "----  \n";
            $out .= "===Template Code=== \n";
            $out .= '<source lang="html4strict">';
            $out .= htmlentities($r->tplt_code);
            $out .= '</source>';
            
            $out .= "\n\n";
            $out .= '[[Category:Forum Skin Templates]]';
            $out .= "\n";
            $out .= '[[Category:'.$r->tplt_section.' (Forum Skin Templates)]]';
            $out .= '</textarea>';
            
            $out .=  $this->wiki_bot_editing_box($r->tplt_function);
            
        }
        $dbr->freeResult( $res );
        
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
        
        //awc_default   
        
        $out .= '</body></html>';
        self::write_file('tplt.html', $out);
    }
    
    function write_tplt_section_to_wiki(){
    global $awcs_forum_config, $wgUser;
        
       # awc_pdie($awcs_forum_config->thmn_id);
        $out = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head></head><body>';
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_tplt = $dbr->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT * 
                FROM $awc_f_theme_tplt 
                WHERE tplt_thmn_id=$awcs_forum_config->thmn_id GROUP BY tplt_section" ; 
        
       # die($sql);
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            #$when = isset($r->thmn_when) ? $r->thmn_when : wfTimestampNow() ;
            
            $out .=  $this->wiki_top_editing_box($r->tplt_section.' (Forum Skin Templates)');
            
            $out .= '<textarea name="wpTextbox1" id="wpTextbox1" rows="0" cols="10" >';
            $out .= "place holder...\n\n";
            $out .= '[[Category:Forum Skin Templates]]';
            $out .= "\n";
            $out .= '</textarea>';
            
            $out .=  $this->wiki_bot_editing_box($r->tplt_section);
            
        }
        $dbr->freeResult( $res );
        
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
            $out .= '';
        
        //awc_default   
        
        $out .= '</body></html>';
        self::write_file('tplt.html', $out);
    }
    
    
    
    function wiki_top_editing_box($url){
    global $wgUser;
    
    
        $token = htmlspecialchars( $wgUser->editToken() );
      // awc_pdie($wgUser);
       die($token);
         $out = null;   
            $out .= '<form id="editform" name="editform" method="post" action="http://wiki.anotherwebcom.com/'.$url.'&amp;action=submit" enctype="multipart/form-data">'; 
            
            $out .= '<input type="hidden" name="wpAntispam" id="wpAntispam" value="" />';
            $out .= '<input name="username_field" class="nothing" type="hidden" value="" size="0" maxlength="0">';
            $out .= '<input type=\'hidden\' value="'.$token.'" name="wpEditToken" />';
            
            $out .= "<input type=\"hidden\" name=\"wpIgnoreBlankSummary\" value=\"1\" />";
            
            $out .= '<input type=\'hidden\' value="" name="wpSection" />';
            $out .= '<input type=\'hidden\' value="" name="wpStarttime" />';
            $out .= '<input type=\'hidden\' value="" name="wpEdittime" />';
            $out .= '<input type=\'hidden\' value="" name="wpScrolltop" id="wpScrolltop" />';
            $out .= "<input tabindex='2' type='hidden' value='' name='wpSummary' id='wpSummary' maxlength='200' size='60' />";
        
            $out .= '<input name="wpMinoredit" type="hidden" value="1" id="wpMinoredit" />';
            $out .= '<input name="wpWatchthis" type="hidden" value="1" id="wpWatchthis" />';
            
            return $out;
    
    }
    
        function wiki_bot_editing_box($text){
        $out = null; 
            $out .= '<input id="wpSave" name="wpSave" type="submit" tabindex="5" value="'.$text.'"/> ' . $text;
            $out .= '</form>';
            
            return $out;
    }
    
    function write_file($file, $out, $skip = true){
        
            $hd = @fopen(awc_dir . "updates/install/$file", "w");
            @fwrite($hd, $out);
            @fclose($hd);
             
         //  if($skip) awc_pdie( htmlentities($out) . "" . awc_dir . "updates/install/$file");
    }




}