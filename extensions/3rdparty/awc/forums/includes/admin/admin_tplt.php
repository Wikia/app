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
* @filepath /extensions/awc/forums/admin/admin_tplt.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcs_forum_admin_tplt($action){
global $wgRequest, $action_url;

    $tplt_cls = new awc_admin_tplt_cls();
    $tplt_cls->tplt_id = 1;
    $tplt_cls->thm_id = 0;
    
    $spl = explode("/", $action);
    $todo = $spl[2];
    
    $tplt_cls->id = $spl[3];
    if($tplt_cls->id == '' || !is_numeric($tplt_cls->id)) $tplt_cls->id = $wgRequest->getVal('id');
    
    $tplt_cls->tplt_what = $wgRequest->getVal('what');
    
    $tplt_cls->todo2 = $wgRequest->getVal('todo2'); 
    if($tplt_cls->todo2 == null) $tplt_cls->todo2 = $spl[3];
    
        if($todo != 'display'){
            Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'admin/tplt/display">' . get_awcsforum_word('admin_edittplt') . '</a>'); 
        } else {
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_edittplt')); 
        }
    
        switch($todo){
            
          case 'save_func':
                $tplt_cls->save_func();
                break;
          case 'show_func':
                $tplt_cls->show_func();
                break;
          case 'show_section':
                $tplt_cls->section = $wgRequest->getVal('tplt_section');
                $tplt_cls->show_section();
                break;
                
                
                
          case 'export_xml':
                $tplt_cls->export_xml();
                break;
          case 'import_xml':
                $tplt_cls->import_xml();
                break;
          case 'update_tplt':
                $tplt_cls->update_tplt();
                break;
                
          case 'search':
                $tplt_cls->search();
                break;
                
                
          case 'find_and_replace':
                $tplt_cls->find_and_replace();
                break;
                
                
          case 'search_version':
                $tplt_cls->search_version();
                break;
                
                
                
                
          case 'tplt_delete':
                $tplt_cls->delete_all_tplt();
                break;
                
          case 'set_default':
                $tplt_cls->set_default();
                break;
                
                
                
          default:
                $tplt_cls->show_sections_list();
                break;
                
        }
    
    


}


class awc_admin_tplt_cls extends awcforum_forumAdmin{
    
    var $tplt_id;
    var $thmn_id;
    var $section;
    var $id;
    
    var $rDB, $wDB;
    
    function __construct(){
    global $awcs_forum_config, $wgRequest, $action_url;
    
        $this->wDB = wfGetDB( DB_MASTER );
        $this->rDB = wfGetDB( DB_SLAVE );
        
        $this->thmn_id = $awcs_forum_config->thmn_id;
        
       // awc_pdie($action_url);
        
        if(isset($action_url[3]) AND is_numeric($action_url[3])){
            $this->thmn_id = $action_url[3];
        }
        
        $them_id = $wgRequest->getVal('them_id');
        if(strlen($them_id) > 0){
         $this->thmn_id = $them_id;
        }
            
    }
    
    function find_and_replace($f, $r){
    global $awc_tables;
     
         // used to print info for update page...  
        $out = "<b><u>Skin</u> Find/Replace:</b><br /> - Template=All<br /> - Find=".awcsforum_funcs::awc_htmlentities($f)."<br /> - Replace With=".awcsforum_funcs::awc_htmlentities($r)."<br /><br />";
            
            // update TABLE_NAME set FIELD_NAME = replace(FIELD_NAME, �find this string�, �replace found string with this string�);
        $awc_f_theme_tplt = $this->wDB->tableName( 'awc_f_theme_tplt' );  
        $this->wDB->query( "UPDATE {$awc_f_theme_tplt} 
                            SET tplt_code = REPLACE(tplt_code, \"$f\", \"$r\")" );
                            
    }
    
    function find_and_replace_in($w, $str_f, $str_r){
    global $awc_tables;
    
        // used to print info for update page...
        $out = "<b><u>Skin</u> Find/Replace:</b><br /> - Template=$w<br /> - Find=".awcsforum_funcs::awc_htmlentities($str_f)."<br /> - Replace With=".awcsforum_funcs::awc_htmlentities($str_r)."<br /><br />";
        
        // update TABLE_NAME set FIELD_NAME = replace(FIELD_NAME, �find this string�, �replace found string with this string�);
        
            //$str_find = str_replace(array('"', '\''),array('\"', "\'"),$str_f);
            $str_find = $str_f ;
            
            $str_replace = str_replace(array('"', '\''),array('\"', "\'"),$str_r);
                
            $awc_f_theme_tplt = $this->wDB->tableName( 'awc_f_theme_tplt' );
            
            $sql = "SELECT *
                    FROM $awc_f_theme_tplt 
                    WHERE tplt_function='$w'" ; 
              
                    
            $res = $this->rDB->query($sql);
            while ($r = $this->rDB->fetchObject( $res )) {
                
                
                $change = true;
                
                /*
                $check = explode(' ', str_replace($str_find, '', $str_replace));
                foreach($check as $c){
                    $look_in = str_replace($str_find, '', $r->tplt_code);
                    if(strlen($c) > 2) if(strstr($look_in, $c)) $change = false;
                }
                */
               
               if(strstr($r->tplt_code, $str_r)) $change = false;
                // awc_pdie($str_r);
                
                if($change == true){
                    
                        $this->wDB->insert( 'awc_f_theme_tplt_history', 
                                                        array('tplth_tplt_id'        => $r->tplt_id,
                                                                'tplth_ver'     => $r->tplt_ver,
                                                                'tplth_code'         => $r->tplt_code,
                                                                'tplth_forum_ver'          => $r->tplt_forum_ver,
                                                                'tplth_find'          => $str_find,
                                                                'tplth_replace'          => $str_replace,
                                                                'tplth_date'    => $this->wDB->timestamp(),) ); 
                                                                
                    
                        $tplt_ver = explode('.', $r->tplt_ver);
                        $tplt_save = $tplt_ver[0] . '.' . ($tplt_ver[1] + 1) . '.' . $tplt_ver[2];
                

                        
                        $tplt_id = $r->tplt_id;
                        $this->wDB->query( "UPDATE {$awc_f_theme_tplt} 
                                SET tplt_code = REPLACE(tplt_code, \"$str_find\", \"$str_replace\"), tplt_ver = '$tplt_save' 
                                WHERE tplt_id=$tplt_id" );   
                }
                
                
                  
                      
            
            }
            
            return $out;
            
                       
    }
    
    function save_func($redirect = true){
    global $wgRequest;
    
        // &nbsp;  
        
            $awc_f_theme_tplt = $this->wDB->tableName( 'awc_f_theme_tplt' );
            $sql = "SELECT *
                    FROM $awc_f_theme_tplt 
                    WHERE tplt_id=$this->id" ;
                    
            $res = $this->rDB->query($sql);
            while ($r = $this->rDB->fetchObject( $res )) {
                
                $this->wDB->insert( 'awc_f_theme_tplt_history', 
                                                array('tplth_tplt_id'        => $r->tplt_id,
                                                        'tplth_ver'     	 => $r->tplt_ver,
                                                        'tplth_code'         => $r->tplt_code,
                                                        'tplth_forum_ver'    => $r->tplt_forum_ver,
                                                		'tplth_thmn_id'      => $r->tplt_thmn_id,
                                                        'tplth_date'    	 => $this->wDB->timestamp(),) );
                                                        
            
                $tplt_ver = explode('.', $r->tplt_ver);
                $tplt_save = $tplt_ver[0] . '.' . $tplt_ver[1] . '.' . ($tplt_ver[2] + 1);
                
                $code = $wgRequest->getVal('tplt_code');
                $this->wDB->update( 'awc_f_theme_tplt',
                                array('tplt_code' => $code, 'tplt_ver' => $tplt_save), 
                                array('tplt_id' => $this->id), ''); 
                                    
            
            }
                                

        if($redirect){
            $info['msg'] = 'tplt_has_been_saved';
            $info['url'] = awc_url . "admin/tplt/show_func/" . $this->id ;
            return awcf_redirect($info);
        }
        
                                    
    }
    
    function show_func(){
    global $wgOut;
       
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT *
                FROM $awc_f_theme_tplt 
                WHERE tplt_id=$this->id" ; 
                  
        $res = $this->rDB->query($sql);
        $r = $this->rDB->fetchObject( $res );
        $this->rDB->freeResult( $res );
        
        $tplt_section = $r->tplt_section;
        $tplt_function = $r->tplt_function;
        
        $html = '<a target="blank" href="http://wiki.anotherwebcom.com/'. $r->tplt_function .' (Forum Skin Template)">' . $r->tplt_function . '</a> ';
        
        $html .= ' ( ' . get_awcsforum_word('admin_edit_ver') . ' ' .  $r->tplt_ver  . ' )';
        
        $html .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/tplt/save_func" method="post">'; 
        $html .= '<input name="id" type="hidden" value="'.$this->id.'">' ;
        #$html .= "<textarea name='tplt_code' cols='95' rows='20' style='width:98%' wrap='virtual' class='post_box'>".str_replace(array('<','>'),array('&lt;','&gt;'),$r->tplt_code)."</textarea> <br />";
        $html .= "<textarea name='tplt_code' cols='95' rows='20' style='width:98%' wrap='virtual' class='post_box'>".htmlentities($r->tplt_code, ENT_NOQUOTES)."</textarea> <br />";
        
        
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
        $html .= '</form>';
        $html .= "<br />"; 
        
        $awc_f_theme_tplt_history = $this->rDB->tableName( 'awc_f_theme_tplt_history' );  
        $sql = "SELECT tplth_code, tplth_ver, tplth_date
                FROM $awc_f_theme_tplt_history 
                WHERE tplth_tplt_id=$this->id ORDER BY tplth_date DESC";
                
        $res = $this->rDB->query($sql);        
       while ($r = $this->rDB->fetchObject( $res )) { 
            $html .= get_awcsforum_word('admin_edit_ver') . ' ' .  $r->tplth_ver  . ' (' . awcsforum_funcs::convert_date($r->tplth_date, 'l') . ') <br />';
            $html .= "<textarea cols='75' rows='5' wrap='virtual' class='post_box'>{$r->tplth_code}</textarea> <br /><br />";
       }
        

        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'admin/tplt/show_section/'. $tplt_section .'">' . $tplt_section . '</a>');
        Set_AWC_Forum_BreadCrumbs($tplt_function , true);
        
        $wgOut->addHTML($html);
    }
    
    
    function show_section(){
    global $wgOut;
    
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT tplt_function, tplt_id, tplt_ver
                FROM $awc_f_theme_tplt 
                WHERE tplt_thmn_id=$this->thmn_id AND 
                        tplt_section='{$this->section}' ORDER BY tplt_function" ; 
                  
        $res = $this->rDB->query($sql);
        $out = null;
        while ($r = $this->rDB->fetchObject( $res )) {
            $out .= '( '.$r->tplt_ver.' ) <a href="'.awc_url.'admin/tplt/show_func/'.$r->tplt_id .'">' . $r->tplt_function . '</a><br />';
        }
        $this->rDB->freeResult( $res );
        

        Set_AWC_Forum_BreadCrumbs($this->section , true);
        $wgOut->addHTML($out);
    
    }
    
    function show_sections_list(){
    global $wgOut, $awcs_forum_config;
       
       
       
        $tplt_info = array('all',
                                'buttons',
                                'cat',
                                'forms',
                                'mem_profile',
                                'memcp', 
                                'page_jumps', 
                                'poll',
                                'search',
                                'special',
                                'thread',
                                'thread_listing');
       
       
       
       
       // $out = ' <a href="'.awc_url.'admin/tplt/export_xml/">(export)</a><br /><br />';
        $out = '<br /><hr />';
        $out .= '<a href="http://wiki.anotherwebcom.com/Skin Template editing (Forum AdminCP)" target="break">' . get_awcsforum_word('word_help') . '</a>';
        $out .= '<hr />';
        
        $out .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/tplt/import_xml" method="post">';
        $out .=  get_awcsforum_word('admin_import_tplt') . "  <br />";
        $out .= ' <input name="new_tplt_file" type="file" size="57" /> ';
        $out .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
        $out .=  '</form><hr /><br />';
        
        $awc_f_theme_names = $this->rDB->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_id, thmn_title, thmn_when, thmn_who, thmn_where FROM $awc_f_theme_names WHERE thmn_what = 'tplt' ORDER BY thmn_title" ;   
            $res = $this->rDB->query($sql); 
            while ($r = $this->rDB->fetchObject( $res )) {
                if($r->thmn_id == $awcs_forum_config->thmn_id){
                    $default = 'CHECKED';
                    $default_word = '<b>' . get_awcsforum_word('word_default') . '</b>';
                    $delete = null;
                    $default_css = " class='thread_rows0' ";
                } else {
                    $default = null;
                    $default_word = get_awcsforum_word('word_default') ;
                    $default_css = " class='thread_rows1' ";
                    
                    $delete = ' -  &nbsp; <b><a href="javascript:void(0);" onclick="javascript:msgcheck('. "'" . awc_url. "admin/tplt/tplt_delete/". $r->thmn_id .  "','" . get_awcsforum_word('delete') ."'" .')">'.get_awcsforum_word('delete').'</a></b>';
                }
                
                if(in_array($r->thmn_id, $awcs_forum_config->cf_css_active_ids)) {
                   $active = 'CHECKED';
                    $active_word = '<b>' . get_awcsforum_word('word_active') . '</b>';
                } else {
                    $active = '';
                    $active_word = get_awcsforum_word('word_active')  ;
                }
                
                
                
                    $out .= '<table width="100%" class="dl_maintable">';
                    $out .= "<tr> <td $default_css>";
                    
                    $out .= '<form action="'. awc_url .'admin/tplt/show_section" method="post">';
                    $out .= ' <input name="them_id" type="hidden" value="'.$r->thmn_id.'">' ;
                        
                        $out .= "<b>$r->thmn_title</b> " ;
                        
                        
                        $out .= '<select name="tplt_section">';   
                        foreach($tplt_info as $k){
                            $out .=  "<option value='$k'>$k</option>"; 
                            }
                        $out .=  '</select> ';
                        $out .=  ' <input type="submit" value="'.get_awcsforum_word('word_edit').'"> ';
                       // $out .=  ' <input type="submit" name="add" value="'.get_awcsforum_word('word_add').'"> ';
                    
                    $out .=  get_awcsforum_word('admin_lang_owner') . ' <a target="blank" href="http://' . str_replace('http://', '', $r->thmn_where) . '">' .$r->thmn_who . '</a>' ;
                    $out .=  '</form>';
                    
                    $out .= '</td></tr>'; 
                    $out .= "<tr> <td $default_css>";
                    
                        $out .= '<form action="'. awc_url .'admin/tplt/set_default" method="post">';
                        $out .= '<input name="them_id" type="hidden" value="'.$r->thmn_id.'">' ;   
                    
                        $out .= "$default_word <INPUT type='checkbox' name='css_default' value='default' $default> ";
                       // $out .= "$active_word <INPUT type='checkbox' name='css_active' value='active' $active> ";
                    
                      
                    
                        $out .=  '<input type="submit" value="'.get_awcsforum_word('submit').'"> ';
                        
                       // $out .=  ' <input type="submit" name="save_css_file" value="'.get_awcsforum_word('word_save_as_file').'">';
                        
                        
                        
                       // $out .= ' &nbsp; <a href="'. awc_url .'admin/tplt/create_new_based_on/'.$r->thmn_id.'">' . get_awcsforum_word('admin_create_new_tmplt_based_on') . '</a>  &nbsp;  ' ;
                        
                        $out .= $delete ;
                        
                        
                        $out .= "  &nbsp;  <a href='". awc_url .'admin/tplt/export_xml/'.$r->thmn_id."'>export</a>" ;
                        
                        
                        $out .= '</form>';
                        
                
            $out .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/tplt/search" method="post">';
            $out .= ' <input name="k" type="text" size="37" /> ';
            $out .= '<input name="them_id" type="hidden" value="'.$r->thmn_id.'">' ;
            $out .= ' <input type="submit" value="'.get_awcsforum_word('admin_search_tplt').'">'; 
            $out .=  '</form>';
                        
                $out .= '</td></tr>'; 
                $out .= '</table>';
                $out .= "<br />";
       
    }
        
        
        
/*
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT tplt_section
                FROM $awc_f_theme_tplt 
                WHERE tplt_thmn_id=$this->thmn_id
                GROUP BY tplt_section" ;
                         
        $res = $this->rDB->query($sql);
        while ($r = $this->rDB->fetchObject( $res )) {
            $out .= '<a href="'.awc_url.'admin/tplt/show_section/'.$r->tplt_section .'">' . $r->tplt_section . '</a> <br /> ';
            
            
        }
        
        */
        
        $this->rDB->freeResult( $res );
        
        Set_AWC_Forum_BreadCrumbs('' , true);
        
        $wgOut->addHTML($out);
    
    
    }
    
    
    function search_version(){
    global $wgOut, $wgRequest;
    
        $w = $wgRequest->getVal('ver');
        $out = null;
        
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT tplt_id, tplt_function
                FROM $awc_f_theme_tplt 
                WHERE tplt_ver LIKE '%" . trim($w) . "%' OR tplt_forum_ver LIKE '%" . trim($w) . "%'";
                         
        $res = $this->rDB->query($sql);
        while ($r = $this->rDB->fetchObject( $res )) {
            $out .= '<a href="'.awc_url.'admin/tplt/show_func/'.$r->tplt_id .'">' . $r->tplt_function . '</a><br />';
        }
        $this->rDB->freeResult( $res );
        
        $wgOut->addHTML($out);
    
    }
    
    
    
    function search(){
    global $wgOut, $wgRequest;
    
        $w = $wgRequest->getVal('k');
        $them_id = $wgRequest->getVal('them_id');
        
        $extra = null;
        if(strlen($them_id) > 0) $extra = " tplt_thmn_id=$them_id AND ";
        $out = null;
        
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT tplt_id, tplt_function
                FROM $awc_f_theme_tplt 
                WHERE $extra tplt_function LIKE '%" . trim($w) . "%' OR tplt_code LIKE '%" . trim($w) . "%'";
                         
        $res = $this->rDB->query($sql);
        while ($r = $this->rDB->fetchObject( $res )) {
            $out .= '<a href="'.awc_url.'admin/tplt/show_func/'.$r->tplt_id .'">' . $r->tplt_function . '</a><br />';
        }
        $this->rDB->freeResult( $res );
        
        $wgOut->addHTML($out);
    
    }
    
    
    
    
    
   function export_xml($for_new_tplt = false, $redirect = true){
    global $wgRequest, $action_url;
  
    
      #  awc_pdie($action_url);
       $v = $wgRequest->getVal('ver');
        if(strlen($v) > 1){
            $and_ver = " AND  tplt_forum_ver='$v'";
        } else {
            $and_ver = null;
        }
        
        
        
        $r = $this->rDB->selectRow( 'awc_f_theme_names', 
                                        array( 'thmn_title','thmn_when', 'thmn_who', 'thmn_where' ), 
                                        array( 'thmn_id' => $this->thmn_id ) );
                
        $thmn_title = $r->thmn_title;
        $thmn_when = $r->thmn_when;
        $thmn_who = $r->thmn_who;
        $thmn_where = $r->thmn_where;
                
        
        
        
        
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        
        $xml .= "<skin_tplts>\n";
        
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT * 
                FROM $awc_f_theme_tplt 
                WHERE tplt_thmn_id=$this->thmn_id $and_ver" ; 
        
       # die($sql);
        $res = $this->rDB->query($sql);
        while ($r = $this->rDB->fetchObject( $res )) {
            $when = isset($r->thmn_when) ? $r->thmn_when : $this->rDB->timestamp() ;
$xml .= "   <tplt thmn_title=\"awc_default\" thmn_who=\"{$thmn_who}\" thmn_where=\"{$thmn_where}\" thmn_when=\"{$when}\" tplt_ver=\"{$r->tplt_ver}\" tplt_forum_ver=\"{$r->tplt_forum_ver}\">
        <tplt_section>{$r->tplt_section}</tplt_section>
        <tplt_function>{$r->tplt_function}</tplt_function>
        <tplt_code><![CDATA[{$r->tplt_code}]]></tplt_code>
    </tplt>
"; 
          #  $xml .= "   <tplt   tplt_when=\"{$r->tplt_when}\" tplt_who=\"{$r->tplt_who}\"><![CDATA[".$r->tplt_code."]]></tplt>\n"; 
        }
        $this->rDB->freeResult( $res );

        $xml .= '</skin_tplts>';
        
        
        if($for_new_tplt) return $xml ;

            $d = awcsforum_funcs::readabledate(wfTimestampNow());
            $filename = awc_dir . "xported_files/skin_".preg_replace("/[^a-z0-9-]/", "-", strtolower($thmn_title))."_".preg_replace("/[^a-z0-9-]/", "-", strtolower($thmn_who))."_.xml";
            
            
                if(strlen($v) > 1){
                    $hd = @fopen(awc_dir . "updates/$v/tplt.xml", "w");
                } else {
                    $hd = @fopen($filename . "", "w");
                }
            
            @fwrite($hd, $xml);
            @fclose($hd);
            
        if($redirect){
            $info['msg'] = 'tplt_has_been_exported';
            $info['url'] = awc_url . "admin/tplt/display" ;
             return awcf_redirect($info);
        }
        
            return true;
    
    }
    
   function import_xml($for_new_tplt = false, $xml_string = null, $redirect = true, $installer = false){
    global $wgRequest, $awcs_forum_config ;
    
    // $cf_them = unserialize($awcs_forum_config->cf_default_forum_theme);
    
    // cf_default_forum_theme
    
        if(!$for_new_tplt){
        	
            if($_FILES["new_tplt_file"]["error"] == '0'){
                $tplt_Path = $_FILES["new_tplt_file"]["tmp_name"] ;
                // $tplt_name = $_FILES["new_tplt_file"]["name"] ;
                $tplt_type = $_FILES["new_tplt_file"]["type"] ;
            }   else {
                return awcs_forum_error('word_tpltfile');
            }
            
           
            
            if (! file_exists($tplt_Path)){
                 return awcs_forum_error('word_tpltfile');
            }
            
            if($tplt_type != 'text/xml'){
                return awcs_forum_error('word_tpltfile');
            }
            
        } else {
            $tplt_Path = $for_new_tplt;
        }
        
        
        if(strlen($xml_string) >= 0){
            $tplt = simplexml_load_file($tplt_Path);
            #$tplt = simplexml_load_file($tplt_Path, 'SimpleXMLElement', LIBXML_NOCDATA);
        } else {
            $tplt = simplexml_load_string($xml_string);
        }
        
        
        $t = $tplt->tplt->attributes();
        #$thmn_who = html_entity_decode($t['thmn_who'], ENT_NOQUOTES, 'UTF-8');
        #$thmn_where = html_entity_decode($t['thmn_where'], ENT_NOQUOTES, 'UTF-8');
        #$thmn_title = html_entity_decode($t['thmn_title'], ENT_NOQUOTES, 'UTF-8');
        #$thmn_when = html_entity_decode($t['thmn_when'], ENT_NOQUOTES, 'UTF-8');
        
        $thmn_who = $t['thmn_who'];
        $thmn_where = $t['thmn_where'];
        $thmn_title = $t['thmn_title'];
        $thmn_when = $t['thmn_when'];

       // $this->wDB->delete( 'awc_f_theme_tplt', array( 'tplt_thmn_id' => $this->thmn_id ), '');
      //  $this->wDB->delete( 'awc_f_theme_names', array( 'thmn_id' => $this->thmn_id ), '');
      
        if($thmn_when == "0000.00.00"){
        	#$thmn_when = str_replace('.', '', $thmn_when) . '000000';
        	$thmn_when = $this->wDB->timestamp();
        }
       
       # $thmn_id = $this->wDB->nextSequenceValue( 'awc_f_theme_names_thmn_id_seq' );
        $this->wDB->insert( 'awc_f_theme_names', 
                                        array('thmn_title'        => $thmn_title,
                                                'thmn_when'     => $thmn_when,
                                                'thmn_who'         => $thmn_who,
                                                'thmn_where'          => $thmn_where,
                                                'thmn_what'    => 'tplt',) );
        $thmn_id = awcsforum_funcs::lastID($this->wDB, 'awc_f_theme_names', 'thmn_id');
       # print('>thmm_tplt_id=' . $thmn_id . '<br>');
       
      if($installer){ 
      		$this->wDB->begin();   
            $this->wDB->update( 'awc_f_theme',
                                array('thm_tplt_id' => $thmn_id), 
                                array('thm_id' =>$this->thm_id),'' );
            $this->wDB->commit();
       }
       
       
        foreach($tplt as $code){
            
            
            $info = $code->attributes();
            
            #$tplt_ver = html_entity_decode($info['tplt_ver'], ENT_NOQUOTES, 'UTF-8'); 
            #$tplt_forum_ver = html_entity_decode($info['tplt_forum_ver'], ENT_NOQUOTES, 'UTF-8');
            #$tplt_section = html_entity_decode($code->tplt_section, ENT_NOQUOTES, 'UTF-8');
            #$tplt_function= html_entity_decode($code->tplt_function, ENT_NOQUOTES, 'UTF-8');
            #$tplt_code = html_entity_decode($code->tplt_code, ENT_NOQUOTES, 'UTF-8');
            
            $tplt_ver = $info['tplt_ver']; 
            $tplt_forum_ver = $info['tplt_forum_ver'];
            
            $tplt_section = $code->tplt_section;
            $tplt_function= $code->tplt_function;
            $tplt_code = $code->tplt_code;
            
                        $this->wDB->insert( 'awc_f_theme_tplt', 
                                        array('tplt_section'        => $tplt_section,
                                                'tplt_function'     => $tplt_function,
                                                'tplt_code'         => $tplt_code,
                                                'tplt_ver'          => $tplt_ver,
                                                'tplt_forum_ver'    => $tplt_forum_ver,
                                                'tplt_thmn_id'       => $thmn_id,) );
                                                
           # awc_pdie($code);
        }
        unset($info);
        if($redirect){
            $info['msg'] = 'tplt_has_been_imported';
            $info['url'] = awc_url . "admin/tplt/display" ;
             return awcf_redirect($info);
        }
        
        return ;
         
    }
    
    
    function set_default($redirect = true){
        
        $dbw = wfGetDB( DB_MASTER );
        
        $dbw->update( 'awc_f_theme',
                            array('thm_tplt_id' => $this->thmn_id), 
                            array('thm_id' =>'1'),'' ); 
                            
        $dbr = wfGetDB( DB_SLAVE );
                $r = $dbr->selectRow( 'awc_f_theme', 
                                        array( 'thm_css_id','thm_tplt_id' ), 
                                        array( 'thm_id' => 1 ) );
                
        $tplt = $r->thm_tplt_id;
        $css = $r->thm_css_id;
                
        $r = $dbr->selectRow( 'awc_f_theme_names', 
                                    array( 'thmn_who','thmn_where' ), 
                                    array( 'thmn_id' => $css ) );
                 
        $dbw = wfGetDB( DB_MASTER );                  
        $dbw->update('awc_f_config',
                            array('a' => serialize(array('css'=> $css,
                                                         'tplt'=> $tplt, 
                                                         'who'=> $r->thmn_who, 
                                                         'where'=> $r->thmn_where))
                                                         ), 
                            array('q' =>'cf_default_forum_theme'),'' );
                            
                            
        if($redirect){
            $info['msg'] = 'tplt_has_been_saved_as_default';
            $info['url'] = awc_url . "admin/tplt/display" ;
             return awcf_redirect($info);
        }
                           
    }
    
    
    
   function delete_all_tplt($redirect = true){
    
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_id FROM $awc_f_theme_names WHERE thmn_what='tplt'" ;   
            $res = $dbr->query($sql); 
            $total = $dbr->numRows($res);
            
            if($total == '1') return awcs_forum_error(get_awcsforum_word('word_css_cant_delete'));
            
        $this->wDB->delete( 'awc_f_theme_tplt', array( 'tplt_thmn_id' => $this->thmn_id ), '');
        $this->wDB->delete( 'awc_f_theme_names', array( 'thmn_id' => $this->thmn_id ), '');
        $this->wDB->delete( 'awc_f_theme_tplt_history', array( 'tplth_thmn_id' => $this->thmn_id ), '');
        
        if($redirect){
            $info['msg'] = 'tplt_has_been_deleted';
            $info['url'] = awc_url . "admin/tplt/display" ;
             return awcf_redirect($info);
        }
    
    }
    
   function delete_tplt($delete_what){
    
        $this->wDB->delete( 'awc_f_theme_tplt', array( 'tplt_function' => $delete_what ), '');
    
    }
    
     // should be working...
    function update_tplt($load_file = false, $redirect = true){
    global $wgRequest, $awcs_forum_config ;
    
    
    
        if(strlen($load_file) < 0){
            
            if($_FILES["new_tplt_file"]["error"] == '0'){
                $tplt_Path = $_FILES["new_tplt_file"]["tmp_name"] ;
                $tplt_type = $_FILES["new_tplt_file"]["type"] ;
            }   else {
                return awcs_forum_error('word_tpltfile');
            }
            
           
            
            if (! file_exists($tplt_Path)){
                 return awcs_forum_error('word_tpltfile');
            }
            
            if($tplt_type != 'text/xml'){
                return awcs_forum_error('word_tpltfile');
            }
            
            $tplt = @simplexml_load_file($tplt_Path);
            
        }  else {
            
           $tplt = @simplexml_load_file($load_file);
            
        }
        
        if($tplt == null){
			return;
		}
        
        
        
        
        $awc_f_theme_tplt = $this->rDB->tableName( 'awc_f_theme_tplt' );  
        $sql = "SELECT tplt_thmn_id, tplt_function FROM $awc_f_theme_tplt " ; 
        
        $res = $this->rDB->query($sql);
        while ($r = $this->rDB->fetchObject( $res )) {
            $curr_tplt[$r->tplt_thmn_id][$r->tplt_function] = true ; #"   <tplt section=\"{$r->tplt_section}\" function=\"".$r->tplt_function."\" tplt_ver=\"{$r->tplt_ver}\" tplt_forum_ver=\"{$r->tplt_forum_ver}\" tplt_when=\"{$r->tplt_when}\" tplt_who=\"{$r->tplt_who}\" tplt_when=\"{$r->tplt_when}\"><![CDATA[".$r->tplt_code."]]></tplt>\n"; 
        }
        $this->rDB->freeResult( $res );
        
        $tplt_info = $tplt->attributes();
        
        foreach($tplt as $code){
            
            $info = $code->attributes();
            #awc_pdie($code->tplt_section);
            $section = $code->tplt_section;
            $function = $code->tplt_function;
            $tplt_code = $code->tplt_code;
            $tplt_ver = $info['tplt_ver'];
            $tplt_forum_ver = $info['tplt_forum_ver'];
            
            foreach($curr_tplt as $theme_id => $curr_tplt_array){
                
                $function = html_entity_decode($function, ENT_NOQUOTES, 'UTF-8'); 
                $section = html_entity_decode($section, ENT_NOQUOTES, 'UTF-8');
                $tplt_code = html_entity_decode($tplt_code, ENT_NOQUOTES, 'UTF-8');
               
              #  awc_pdie($tplt_code);
                
                if(!array_key_exists($function, $curr_tplt_array)){
                
                        $this->wDB->insert( 'awc_f_theme_tplt', 
                                        array('tplt_section'        => $section,
                                                'tplt_function'     => $function,
                                                'tplt_code'         => $tplt_code,
                                                'tplt_ver'          => $tplt_ver,
                                                'tplt_forum_ver'    => $tplt_forum_ver,
                                                'tplt_thmn_id'       => $theme_id,) );
                }
               
            
            }
            
        }
        
        $this->wDB->commit();
        
        unset($info);
        
        if($redirect){
            $info['msg'] = 'tplt_has_been_updated';
            $info['url'] = awc_url . "admin/tplt/display" ;
            return awcf_redirect($info);
        } 
        
        return true;   
    
    }
    
    
    
    
    
}