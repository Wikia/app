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
* @filepath /extensions/awc/forums/admin/admin_css_funk.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcs_forum_admin_css($action){
global $wgRequest;

    $css_cls = new awc_admin_css_cls();
    
    $spl = explode("/", $action);
    $todo = $spl[2];
    
    $css_cls->css_id = $spl[3];
    if($css_cls->css_id == '') $css_cls->css_id = $wgRequest->getVal('id');
    
    $css_cls->css_what = $wgRequest->getVal('what');
    
    $css_cls->todo2 = $wgRequest->getVal('todo2'); 
    if($css_cls->todo2 == null) $css_cls->todo2 = $spl[3];
    
    $css_cls->todo($todo);
    
}


class awc_admin_css_cls extends awcforum_forumAdmin{
    
    var $css_id = null ;
    var $thm_id = '1' ;
    var $css_what = null ;
    var $todo2 = null ; 
 
    function __construct(){
    #global $wgRequest;
            
    }
    
    

        
    function todo($todo){
    global $wgOut; 
    
 
        if($todo != 'css_edit_get'){
            Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'admin/css/css_get_list'. '">' . get_awcsforum_word('admin_editcss') .'</a>'); 
        } else {
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_editcss'), true); 
        }
        
        switch( $todo ) {
            
          case 'export':
                $done = self::export_xml();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/exported_css_list' );
                break;
                
          case 'add_new_value':
                self::add_new_value();
                $wgOut->redirect( awc_url . 'admin/css/exported_css_list' );
                break;
          
          case 'exported_css_list':
                self::exported_css_list();
                break;
                
          case 'saved_css_list':
                self::exported_css_list('.css');
                break;
                
          case 'delete_export_file':
                self::delete_export_file($this->todo2);
                $wgOut->redirect( awc_url . 'admin/css/exported_css_list' ); 
                break;
                
                
          case 'css_get_list':
                self::css_get_list();
                break;
                
          case 'css_get_id':
                self::css_get_id($this->css_id);
                break;
          
          case 'css_edit_section':
                self::css_edit_section();
                break;          
                
          case 'css_edit_save':
                $done = self::css_edit_save();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_setdefault':
                $done = self::css_setdefault();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_import':
                $done = self::css_import();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_setnotactive':
                $done = self::css_actived(false);
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_setactive':
                $done = self::css_actived(true);
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_change':
                $done = self::css_change();
                #if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_delete':
                $done = self::css_delete();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'create_new_from_old':
                $done = self::create_new_from_old();
                if($done == true) $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
          case 'css_create_new':
                self::css_create_new();
                break;
                
          case 'search':
                self::search();
                break;
                
                
          case 'single_edit':
                self::display_code_for_edit();
                break;
                
                
          case 'search_version':
                self::search_version();
                break;
                
                
          case 'save_whowheretitle':
                self::save_whowheretitle();
                $wgOut->redirect( awc_url . 'admin/css/css_get_list' );
                break;
                
                
          default:
                self::css_get_list();
                break;
            
        }
    
    
    }
    
    
    function search_version(){
    global $wgOut, $wgRequest, $ADskin;
    
        $w = $wgRequest->getVal('ver');
        $css_id = $wgRequest->getVal('css_id');
        $out = null;
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );  
        $sql = "SELECT css_id, css_att, css_custom, css_ver
                FROM $awc_f_theme_css 
                WHERE (css_thmn_id=$css_id) AND css_ver LIKE '%" . trim($w) . "%' OR css_forumver LIKE '%" . trim($w) . "%'";
                         
        $res = $dbr->query($sql);
        
        $out = '<form action="'. awc_url .'admin/css/css_edit_save" method="post">';
        $out .= '<input name="id" type="hidden" value="'.$css_id.'">' ;
        $out .= '<table>';
        while ($r = $dbr->fetchObject( $res )) {
            
            $css_info['css_att'] = $r->css_att; 
            $css_info['custom'] = $r->css_custom; 
           //  $css_info['code'] = $r->css_code; 
            $css_info['ver'] = $r->css_ver; 
            $css_id = $r->css_id; 
            
            $out .= "<tr><td><hr />"; 
            
            $out .= "<a href='".awc_url . "admin/css/single_edit/".$css_id."'>".$css_info['css_att']."</a>"; 
            
            $out .= '</td></tr>'; 
            
        }
        $dbr->freeResult( $res );
        
        $out .= '</table></form>';
        
        $wgOut->addHTML($out);
    
    }
    
    function addto_in($f, $a){
    
        // used to print info for update page...    
        $out = "<b><u>CSS</u> Add to Attribute:</b><br /> - Attribute=$f<br /> - Adding=".awcsforum_funcs::awc_htmlentities($a)."<br /><br />";
        
        
        $add_to = str_replace(array('"', '\''),array('\"', "\'"),$a);
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );  
        
        $awc_f_theme_css = $dbw->tableName( 'awc_f_theme_css' ); 
        
        $sql = "SELECT *
                FROM $awc_f_theme_css 
                WHERE css_att='$f'" ; 
                      
        $res = $dbr->query($sql);
            while ($r = $dbr->fetchObject( $res )) {
                
                $css_code =  $r->css_code;
                
                if(!strstr($css_code, $add_to)){
                        
                        $dbw->insert( 'awc_f_theme_css_history', 
                                                        array('cssh_cssid'        => $r->css_id,
                                                                'cssh_ver'     => $r->css_ver,
                                                                'cssh_forum_ver'     => $r->css_forumver,
                                                                'cssh_code'         => $r->css_code,
                                                                'cssh_date'    => $dbw->timestamp(),) );
                                                                
                    
                        $tplt_ver = explode('.', $r->css_ver);
                        $css_save = $tplt_ver[0] . '.' . ($tplt_ver[1] + 1) . '.' . $tplt_ver[2];
                
                        $css_code .= "\n" . $add_to;
                    
                    // die($css_save);
                        $css_id = $r->css_id;
                        $code = str_replace($str_find,$str_replace, $r->css_code);
                        $dbw->query( "UPDATE {$awc_f_theme_css} SET css_code = '$css_code', css_ver = '$css_save' 
                                        WHERE css_id=$css_id" );      
                    }
                
            }
        
        return $out;
        
    }
    
    
    
    
    
    function find_and_replace_in($w, $f, $r){
        // used to print info for update page...
        $out = "<b><u>CSS</u> Find/Replace:</b><br /> - Section=$w<br /> - Find=".awcsforum_funcs::awc_htmlentities($f)."<br /> - Replace With=".awcsforum_funcs::awc_htmlentities($r)."<br /><br />";
    
        $str_find = str_replace(array('"', '\''),array('\"', "\'"),$f);
        $str_replace = str_replace(array('"', '\''),array('\"', "\'"),$r);
         
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );  
        
        $awc_f_theme_css = $dbw->tableName( 'awc_f_theme_css' ); 
        
        $sql = "SELECT *
                FROM $awc_f_theme_css 
                WHERE css_att='$w'" ; 
                      
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            
            $change = true;
            $check = explode("\n", str_replace($str_find, '', $str_replace));
            foreach($check as $c){
                $look_in = str_replace($str_find, '', $r->css_code);
                if(strlen($c) > 2) if(strstr($look_in, $c)) $change = false;
            }
            
            
            if($change == true){
                    
                        $dbw->insert( 'awc_f_theme_css_history', 
                                                        array('cssh_cssid'        => $r->css_id,
                                                                'cssh_ver'     => $r->css_ver,
                                                                'cssh_forum_ver'     => $r->css_forumver,
                                                                'cssh_code'         => $r->css_code,
                                                                'cssh_date'    => $dbw->timestamp(),) );
                                                                
                    
                        $tplt_ver = explode('.', $r->css_ver);
                        $css_save = $tplt_ver[0] . '.' . ($tplt_ver[1] + 1) . '.' . $tplt_ver[2];
            
                    // die($css_save);
                        $css_id = $r->css_id;
                        $code = str_replace($str_find,$str_replace, $r->css_code);
                        $dbw->query( "UPDATE {$awc_f_theme_css} SET css_code = '$code', css_ver = '$css_save'
                         WHERE css_id=$css_id" );     
            }
                    
        }
        
        return $out;
                         
    }   
    
    
    function display_code_for_edit(){
    global $ADskin, $wgOut;
    
         
    
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );  
        $sql = "SELECT css_id, css_att, css_custom, css_code, css_ver , css_section
                FROM $awc_f_theme_css 
                WHERE (css_id=$this->css_id) LIMIT 1 ";
                
        $res = $dbr->query($sql);
        
        $out = '<form action="'. awc_url .'admin/css/css_edit_save" method="post">';
        $out .= '<input name="id" type="hidden" value="'.$this->css_id.'">' ;
        
        $out .= '<table>';
        $r = $dbr->fetchObject( $res );
            $css_info['css_att'] = $r->css_att; 
            $css_info['custom'] = $r->css_custom; 
            $css_info['code'] = $r->css_code; 
            $css_info['ver'] = $r->css_ver; 
            $css_id = $r->css_id; 
            $out .= "<tr><td><hr />"; 
            $out .= '<input name="ver" type="hidden" value="'.$r->css_ver.'">' ;                    
            $out .= $ADskin->css_editing_boxs($css_info, $css_id);
            $out .= '</td></tr>'; 
            
        $dbr->freeResult( $res );
        
        $out .= '</table></form>';
        
        Set_AWC_Forum_BreadCrumbs('<a target="blank" href="http://wiki.anotherwebcom.com/Category:'.str_replace('css_', 'CSS_', $r->css_section) . '">' . $r->css_section . '</a>');
        Set_AWC_Forum_BreadCrumbs($r->css_att , true);
        
        
        
        $out .= "<br />"; 
        
        $awc_f_theme_css_history = $dbr->tableName( 'awc_f_theme_css_history' );  
        $sql = "SELECT cssh_code, cssh_ver, cssh_date
                FROM $awc_f_theme_css_history 
                WHERE cssh_cssid=$css_id ORDER BY cssh_date DESC";
                
       $res = $dbr->query($sql);        
       while ($r = $dbr->fetchObject( $res )) { 
            $out .= get_awcsforum_word('admin_edit_ver') . ' ' .  $r->cssh_ver  . ' (' . awcsforum_funcs::convert_date($r->cssh_date, 'l') . ') <br />';
            $out .= "<textarea cols='75' rows='5' wrap='virtual' class='post_box'>{$r->cssh_code}</textarea> <br /><br />";
       }
       
        $wgOut->addHTML($out);
    
    } 
    
    function search(){
    global $wgOut, $wgRequest, $ADskin;
    
        $w = $wgRequest->getVal('k');
        $css_id = $wgRequest->getVal('css_id');
        $out = null;
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );  
        $sql = "SELECT css_id, css_att, css_custom, css_ver
                FROM $awc_f_theme_css 
                WHERE (css_thmn_id=$css_id) AND css_att LIKE '%" . trim($w) . "%' OR css_code LIKE '%" . trim($w) . "%'";
                         
        $res = $dbr->query($sql);
        
        $out = '<form action="'. awc_url .'admin/css/css_edit_save" method="post">';
        $out .= '<input name="id" type="hidden" value="'.$css_id.'">' ;
        $out .= '<table>';
        while ($r = $dbr->fetchObject( $res )) {
            
            $css_info['css_att'] = $r->css_att; 
            $css_info['custom'] = $r->css_custom; 
           //  $css_info['code'] = $r->css_code; 
            $css_info['ver'] = $r->css_ver; 
            $css_id = $r->css_id; 
            
            $out .= "<tr><td><hr />"; 
            
            $out .= "<a href='".awc_url . "admin/css/single_edit/".$css_id."'>".$css_info['css_att']."</a>"; 
            
            $out .= '</td></tr>'; 
            
        }
        $dbr->freeResult( $res );
        
        $out .= '</table></form>';
        
        $wgOut->addHTML($out);
    
    }
    
    
    function css_create_new(){
    global $wgOut;    
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('addnewcssbaisedon'), true); 
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_id, thmn_title FROM $awc_f_theme_names WHERE thmn_id=$this->css_id" ;   
        $res = $dbr->query($sql);
        $r = $dbr->fetchObject( $res );
        $dbr->freeResult( $res );
        
            
        $out = '<form action="'. awc_url .'admin/css/create_new_from_old" method="post">';
            $out .= '<input name="id" type="hidden" value="'.$this->css_id.'">' ;
            $out .=  get_awcsforum_word('addnewcssbaisedon') . ":  <b>$r->thmn_title</b><br />";
                
                $out .= get_awcsforum_word('word_csstitle') . ' <input name="css_title" type="text" size="25%" value=""> <br /> ';
                $out .= get_awcsforum_word('word_csswho') . ' <input name="css_who" type="text" size="25%" value=""> <br /> '; 
                $out .= get_awcsforum_word('word_csswhere') . ' <input name="css_where" type="text" size="25%" value="">  ';
                
                $out .= '<input type="submit" value="'.get_awcsforum_word('submit').'">'; 
            $out .=  '</form>';
            
            
        $wgOut->addHTML($out);
        
        
    
    }
    
    
    function create_new_from_old(){
     // Create new CSS based on this theme
        
        $xml = self::export_xml(true);
        self::css_import(true, $xml);
        
    return true;
    }
    
    function css_delete($redirect = true){
        
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_id FROM $awc_f_theme_names WHERE thmn_what='css'" ;   
            $res = $dbr->query($sql); 
            $total = $dbr->numRows($res);
            
            if($total == '1') return awcs_forum_error(get_awcsforum_word('word_css_cant_delete'));
        
        $dbw = wfGetDB( DB_MASTER ); 
        $dbw->delete('awc_f_theme_css', array( 'css_thmn_id' => $this->css_id ), '');
        $dbw->delete('awc_f_theme_names', array( 'thmn_id' => $this->css_id ), '');
        $dbw->delete('awc_f_theme_css_history', array( 'cssh_cssid' => $this->css_id ), '');
        
        self::css_actived(false);
        
        if($redirect){
            $info['msg'] = 'css_has_been_deleted';
            $info['url'] = awc_url . "admin/css/css_edit_get" ;
            return awcf_redirect($info);
        }
        
        return true ;
    }
    
    function css_actived($yesno){
    global $awcs_forum_config, $wgOut ; 
    
        $cf_css_active_ids = null;
        foreach($awcs_forum_config->cf_css_active_ids as $css_ids ){
            
            if($yesno == false){
                if($css_ids != $this->css_id) $cf_css_active_ids .= $css_ids . ',';
            } else {
                $cf_css_active_ids .= $css_ids . ',';
            }
            
        }
        
        
        if($yesno == true) {
            $cf_css_active_ids .= $this->css_id; 
        } else {
            $cf_css_active_ids = substr($cf_css_active_ids , 0, -1);
        }
        
        if($cf_css_active_ids == '') return awcs_forum_error(get_awcsforum_word('word_css_need_active'));
      
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_config', array('a' => $cf_css_active_ids), array('q' => 'cf_css_active_ids'));
        
        return true ;
    }
 
    function css_setdefault(){
        
        $dbw = wfGetDB( DB_MASTER );
       # $dbw->update( 'awc_f_config', array('a' => serialize(array('Default' => $this->css_id)),), 
       # array('q' => 'cf_css_default'));
        
        $dbw->update( 'awc_f_theme',
                            array('thm_css_id' => $this->css_id), 
                            array('thm_id' =>'1'),'' ); 
                            
        $dbr = wfGetDB( DB_SLAVE );
                $r = $dbr->selectRow( 'awc_f_theme', 
                                        array( 'thm_css_id','thm_tplt_id' ), 
                                        array( 'thm_id' => 1 ) );
                
        $tplt = $r->thm_tplt_id;
        $css = $r->thm_css_id;
                
        $r = $dbr->selectRow( 'awc_f_theme_names', 
                                    array( 'thmn_who','thmn_where', 'thmn_item_count' ), 
                                    array( 'thmn_id' => $css ) );
                 
        $dbw = wfGetDB( DB_MASTER );                  
        $dbw->update('awc_f_config',
                            array('a' => serialize(array('css'=> $css,
                                                         'tplt'=> $tplt, 
                                                         'css_count'=> $r->thmn_item_count,
                                                         'who'=> $r->thmn_who, 
                                                         'where'=> $r->thmn_where))
                                                         ), 
                            array('q' =>'cf_default_forum_theme'),'' );
                            
                            
         self::css_actived($this->css_id, true);                   
    }

    function css_get_list(){
    global $wgOut, $awcs_forum_config;
    
       # Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_editcss'), true);
        
        
        $css_info = array('css_wiki_changes',
                                'css_memcp',
                                'css_search',
                                'css_forum_thread_list',
                                'css_general',
                                'css_main_forums', 
                                'css_thread', 
                                'css_page_jumps',
                                'css_top_menu',
                                'css_poll');
        
        $dbr = wfGetDB( DB_SLAVE );
        
        

        
        $out = '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0">';
        $out .= '<tr><td>';
        
                    $out .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/css/css_import" method="post">';
                    $out .=  get_awcsforum_word('importnewcssbaisedon') . "  <br />";
                    $out .= ' <input name="new_css_file" type="file" size="57" /> ';
                    $out .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
                $out .=  '</form>';
                
        $out .= '<br />';
        $out .= ' <a href="'.awc_url.'admin/css/exported_css_list">'.get_awcsforum_word('word_exported_files').'<a/> - ';        
        $out .= ' <a href="'.awc_url.'admin/css/saved_css_list">'.get_awcsforum_word('word_save_as_file').'<a/> ';
                        
        $out .= '</td></tr>';
        $out .= '</table>';
        
        
        $out .= '<br /><hr />';
        $out .= '<a href="http://wiki.anotherwebcom.com/CSS editing (Forum AdminCP)" target="break">' . get_awcsforum_word('word_help') . '</a>';
        $out .= '<hr /><br />';
        
        
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_id, thmn_title, thmn_when, thmn_who, thmn_where FROM $awc_f_theme_names WHERE thmn_what = 'css' ORDER BY thmn_title" ;   
            $res = $dbr->query($sql); 
            while ($r = $dbr->fetchObject( $res )) {
                
                #$info = unserialize($r->thmn_who thmn_where);
               # awc_pdie($awcs_forum_config->cf_css_default);
                
                if($r->thmn_id == $awcs_forum_config->cf_css_default){
                    $default = 'CHECKED';
                    $default_word = '<b>' . get_awcsforum_word('word_default') . '</b>';
                    $delete = null;
                    $default_css = " class='thread_rows0' ";
                } else {
                    $default = null;
                    $default_word = get_awcsforum_word('word_default') ;
                    $default_css = " class='thread_rows1' ";
                    
                    $delete = ' -  &nbsp; <b><a href="javascript:void(0);" onclick="javascript:msgcheck('. "'" . awc_url. "admin/css/css_delete/". $r->thmn_id .  "','" . get_awcsforum_word('delete') ."'" .')">'.get_awcsforum_word('delete').'</a></b>';
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
                    
                    $out .= '<form action="'. awc_url .'admin/css/css_edit_section" method="post">';
                    $out .= ' <input name="id" type="hidden" value="'.$r->thmn_id.'">' ;
                        
                        $out .= "<b>$r->thmn_title</b> " ;
                        
                        $out .= '<select name="what">';   
                        foreach($css_info as $k){
                            $out .=  "<option value='$k'>".str_replace(array('css_'), '', $k)."</option>"; 
                            }
                        $out .=  '</select> ';
                        $out .=  ' <input type="submit" value="'.get_awcsforum_word('word_edit').'"> ';
                        $out .=  ' <input type="submit" name="add" value="'.get_awcsforum_word('word_add').'"> ';
                    
                    $out .=  get_awcsforum_word('admin_lang_owner') . ' <a target="blank" href="http://' . str_replace('http://', '', $r->thmn_where) . '">' .$r->thmn_who . '</a>' ;
                    $out .=  '</form>';
                    
                    $out .= '</td></tr>'; 
                    $out .= "<tr> <td $default_css>";
                    
                        $out .= '<form action="'. awc_url .'admin/css/css_change" method="post">';
                        $out .= '<input name="id" type="hidden" value="'.$r->thmn_id.'">' ;   
                    
                        $out .= "$default_word <INPUT type='checkbox' name='css_default' value='default' $default> ";
                       // $out .= "$active_word <INPUT type='checkbox' name='css_active' value='active' $active> ";
                    
                       # $out .= get_awcsforum_word('word_active') . ' <INPUT type="checkbox" name="active" value="active" '. $active .'> ';
                    
                        $out .=  '<input type="submit" value="'.get_awcsforum_word('submit').'"> ';
                        
                        $out .=  ' <input type="submit" name="save_css_file" value="'.get_awcsforum_word('word_save_as_file').'">';
                        
                        
                        
                        $out .= ' &nbsp; <a href="'. awc_url .'admin/css/css_create_new/'.$r->thmn_id.'">' . get_awcsforum_word('addnewcssbaisedon') . '</a>  &nbsp;  ' ;
                        
                        $out .= $delete ;
                        
                        
                        $out .= "  &nbsp;  <a href='". awc_url .'admin/css/export/'.$r->thmn_id."'>export</a>" ;
                        
                        
                        $out .= '</form>';
                        
                
            $out .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/css/search" method="post">';
            $out .= ' <input name="k" type="text" size="37" /> ';
            $out .= '<input name="css_id" type="hidden" value="'.$r->thmn_id.'">' ;
            $out .= ' <input type="submit" value="'.get_awcsforum_word('search_css').'">'; 
            $out .=  '</form>';
                        
                $out .= '</td></tr>'; 
                $out .= '</table>';
                $out .= "<br />";
            
        }
        $dbr->freeResult( $res );
        
       # $out .= '</table>';
        
        $wgOut->addHTML($out);
            
        return true ;
    
    }
    
    function save_css_to_file(){
    global $wgOut;    
        
        $css= self::css_get_section(true);
        
        unset($css['css_info'], $css['css_section'], $css['css_title']);
        
        
        $out = null;
        foreach($css as $css_info){
            $out .= $css_info['css_att'] . "{" . $css_info['code'] . "}\n";
        }
        
        
        $filename = awc_dir . "skins/css/id{$this->css_id}.css";
        #die($filename);
        if($hd = fopen($filename . "", "w")){
	        fwrite($hd, $out);
	        fclose($hd);
	        $wgOut->redirect( awc_url . 'admin/css/saved_css_list' );
        } else {
        	return awcs_forum_error('word_cssfile');
        }
        
        
    
    }
    
    function css_change($redirect = true){
    global $wgRequest;
    
        
        $add = ($wgRequest->getVal( 'save_css_file' ));
        if($add != null) return self::save_css_to_file();
        
        $default = $wgRequest->getVal('css_default');
        $active = $wgRequest->getVal('css_active');
        
        if($active == 'active'){
            $this->css_actived(true);
        } else {
            $this->css_actived(false);
        }
        
        
        if($default == 'default'){
            $this->css_setdefault();
        }
        
        
        if($redirect){
            $info['msg'] = 'css_has_been_changed';
            $info['url'] = awc_url . "admin/css/css_edit_get" ;
            return awcf_redirect($info);
        }
        
      return true ;            
    } 
    
    function save_whowheretitle(){
    global $wgRequest;
       
        $thmn_id = $wgRequest->getVal( 'id' ) ;
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_theme_names',
                array('thmn_title'    => $wgRequest->getVal( 'css_title' ),
                        'thmn_when'    => $dbw->timestamp(),
                        'thmn_who'    => $wgRequest->getVal( 'css_who' ),
                        'thmn_where'    => $wgRequest->getVal( 'css_where' ),), 
                 array('thmn_id' => $thmn_id), '');
                 
    }  
    
    function css_edit_save($redirect = true){
     global $wgOut, $ADskin, $wgRequest; 
          
     
        // $info = array('who' => $wgRequest->getVal( 'css_who' ), 'where' => $wgRequest->getVal( 'css_where' ),);
        
        
        $css_id = $wgRequest->getVal( 'id' ) ;
        $css_code = $wgRequest->getVal( 'css_code' ) ;
        $css_ver = $wgRequest->getVal( 'ver' ) ;
        
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
            $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );
            $sql = "SELECT *
                    FROM $awc_f_theme_css 
                    WHERE css_id=$css_id" ;
                    
            $res = $dbr->query($sql);
            while ($r = $dbr->fetchObject( $res )) {
                
                    $dbw->insert( 'awc_f_theme_css_history', 
                                        array('cssh_cssid'        => $r->css_id,
                                                'cssh_ver'     => $r->css_ver,
                                                'cssh_forum_ver'     => $r->css_forumver,
                                                'cssh_code'         => $r->css_code,
                                                'cssh_date'    => $dbw->timestamp(),) );
                                                        
            
                $tplt_ver = explode('.', $css_ver);
                $css_save = $tplt_ver[0] . '.' . $tplt_ver[1] . '.' . ($tplt_ver[2] + 1);
                
               // $code = $wgRequest->getVal('tplt_code');
                
                $dbw->update( 'awc_f_theme_css', 
                            array('css_code' => $css_code, 'css_ver' => $css_save,), 
                            array('css_id' => $css_id), '');
      
                                    
            
            }
       
       
        if($redirect){
            $info['msg'] = 'css_has_been_saved';
            $info['url'] = awc_url . "admin/css/css_edit_get" ;
            return awcf_redirect($info);
        }
        
        return true ;
    
    }
    
    function css_edit_section(){
     global $wgOut, $ADskin, $wgRequest;
     
        $add = ($wgRequest->getVal( 'add' ));
        if($add != null) return self::add_new_value_form();
        
        $css = self::css_get_section();
        if($css == false) return awcs_forum_error('word_no_css');
        #$info =  $css['css_info'] ;
        $thmn_who = $css['thmn_who'];
        $thmn_where = $css['thmn_where'];
        $what =  $css['css_section'] ;
        $name =  $css['css_title'] ;
        
        unset($css['thmn_where'], $css['thmn_who'], $css['css_title'], $css['css_section']);
        
       
        #$b[] = $name . ' - <a target="blank" href="http://'.str_replace('http://', '', $info['where']).'">' . $info['who'] . '</a>';
        Set_AWC_Forum_BreadCrumbs(str_replace('_', ' ', $what) , true);
        
       # die($what);
        
        $html = '<table> ';
        
       $html .= '<form action="'. awc_url .'admin/css/save_whowheretitle" method="post">';
       $html .= '<input name="id" type="hidden" value="'.$this->css_id.'">' ;
       # $html .= '<input name="what" type="hidden" value="'.$what.'">' ;
       $html .= '<tr><td>';
       
            $html .= get_awcsforum_word('word_title') . ' <input name="css_title" type="text" size="25" value="'.$name.'"> <br />';
            $html .= get_awcsforum_word('word_name') . ' <input name="css_who" type="text" size="25" value="'.$thmn_who.'"> <br />'; 
            $html .= get_awcsforum_word('word_site') . ' <input name="css_where" type="text" size="75" value="'.$thmn_where.'">  ';
            $html .= '<input type="submit" value="'.get_awcsforum_word('word_edit').'">';    
       
       $html .= "<br /><br /><hr /><b><a href='http://wiki.anotherwebcom.com/Category:".str_replace('css_', 'CSS_', $what)."' target='_blank'>$what</a></b><br />";
       $html .= '</td></tr>';
       
       
                 foreach($css as $css_id => $css_info){
                    
                                $html .= "<tr><td><hr />"; 
                                
                                    $html .= "<a href='".awc_url . "admin/css/single_edit/".$css_id."'>".$css_info['css_att']."</a>"; 
                                            
                                 // $html .= $ADskin->css_editing_boxs($css_info, $css_id);
                                
                                 $html .= '</td></tr>';                            
                 }  
         
         $html .= '</form></table>';
         
         $wgOut->addHTML($html); 
         
         return true ;
            
    }
    
    function css_get_section($all = false){
        
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );  
        $sql = "SELECT thmn_title, thmn_when, thmn_who, thmn_where FROM $awc_f_theme_names WHERE thmn_id = {$this->css_id}" ;   
            $res = $dbr->query($sql); 
            $r = $dbr->fetchObject( $res );
        $dbr->freeResult( $res );
        
        if(!isset($r)) return false;
        $css['thmn_who'] = $r->thmn_who;
        $css['thmn_where'] = $r->thmn_where;
        $css['css_title'] = $r->thmn_title  ;
         
        
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );  
        $sql = "SELECT css_id, css_section, css_ver, css_att, css_code, css_custom 
                FROM $awc_f_theme_css 
                WHERE css_thmn_id = {$this->css_id} AND css_section = '{$this->css_what}'" ;   
        
        if($all){
            $sql = "SELECT css_id, css_section, css_ver, css_att, css_code, css_custom 
                    FROM $awc_f_theme_css 
                    WHERE css_thmn_id = {$this->css_id}" ; 
        }
        $res = $dbr->query($sql); 
            
            while ($r = $dbr->fetchObject( $res )) {
                $css[$r->css_id]['ver'] = $r->css_ver;
                $css[$r->css_id]['css_att'] = $r->css_att; 
                $css[$r->css_id]['code'] = $r->css_code;
                $css[$r->css_id]['custom'] = $r->css_custom;
            }
            
        $dbr->freeResult( $res );
        
        $css['css_section'] = $this->css_what  ;
        
        return $css;
        
    }    
    
    function css_get_all_id($what, $where){
        
        die($where);
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_css = $dbr->tableName( 'awc_f_css' );  
        $sql = "SELECT $what, css_title, css_info FROM $awc_f_css $where" ;   
            $res = $dbr->query($sql); 
            $r = $dbr->fetchObject( $res );
        $dbr->freeResult( $res );
        
        if(!isset($r)) return false; 
        
        $css_cols = explode(',', $what);
        foreach($css_cols as $css_col){
            $css[$css_col] = unserialize($r->$css_col);
        
        }
        $css['css_info'] = unserialize($r->css_info);
        $css['css_title'] = $r->css_title  ;
        #awc_pdie($css);
        
        unset($r, $res);
              
        return $css;
        
    }
    
    function css_convert($file, $ver, $css_id, $thm_id){
    global $awcs_forum_config;        
      #  die($this->awcdir);
        
        $css_file = $this->awcdir . $file ;
        $fh = fopen($css_file, 'r');
        $css_content = fread($fh, filesize($css_file));
        fclose($fh);
        
        $css_get = array();
        $css_save = array();
        
        $css_get['css_wiki_changes'] = array('#bodyContent a[href ^="http://"]',
                                                '#bodyContent a.external',
                                                '#p-cactions li a',
                                                '#contentSub',
                                                'pre', );
        foreach($css_get['css_wiki_changes'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_wiki_changes'][trim($k)] = trim($css_code); 
        }
        
        
        
        $css_get['css_memcp'] = array('.main_memtable',
                                                '.main_leftmenu',
                                                '.leftmenuheaders',
                                                '.leftmenu',
                                                '.right_body',
                                                '.mem_pm_table',
                                                '.pm_header_new',
                                                '.pm_header_title',
                                                '.pm_header_sender',
                                                '.pm_header_date',
                                                '.pm_row',);
        foreach($css_get['css_memcp'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_memcp'][trim($k)] = trim($css_code); 
        }
        
        
        
        $css_get['css_search'] = array('#search_box',
                                                '.search_box',
                                                '.highlightsearchword',);
        foreach($css_get['css_search'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_search'][trim($k)] = trim($css_code); 
        }
        
            
        
        $css_get['css_forum_thread_list'] = array('.thread_rows0',
                                                '.thread_rows1',
                                                '.thread_rows',
                                                '#annc',
                                                '.sticky',
                                                '.thread_lastaction',
                                                '.pagejumps_PostOnForumPage:hover',
                                                '.pagejumps_PostOnForumPage',
                                                '.new_thread_button:hover',
                                                '.new_thread_button',
                                                '#row_info td',
                                                '.page_jumps_holder_thread_bot',
                                                '.page_jumps_holderBot',);
        foreach($css_get['css_forum_thread_list'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_forum_thread_list'][trim($k)] = trim($css_code); 
        }
        
        
        
        
        $css_get['css_general'] = array('.thread_col_head',
                                                '.bread_crumbs',
                                                '.dl_maintable_head',
                                                '.dl_maintable',
                                                '.right_float',
                                                '.right',
                                                '.spacer', );
        foreach($css_get['css_general'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_general'][trim($k)] = trim($css_code); 
        }
         
        
        
        $css_get['css_main_forums'] = array('#cat_list_lastaction_user ',
                                                '#cat_list_lastaction_date ',
                                                '#cat_list_lastaction_title ',
                                                '#small_desc ',
                                                '#cat_forumdisc ',
                                                '.cat_forumrows ', );
        foreach($css_get['css_main_forums'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_main_forums'][trim($k)] = trim($css_code); 
        }       
        
        
        $css_get['css_thread'] = array('.group_text',
                                                '.edited_on',
                                                '.post_title',
                                                '.post_date',
                                                '.post_td',
                                                '.post_body',
                                                '.post0',
                                                '.post1',
                                                '.post_footer',
                                                '.post_box',
                                                '.mem_name',
                                                '.adv',
                                                '.thread_sig',
                                                '#subscribe_menu',
                                                '.drop_down_buttons:hover',
                                                '.drop_down_buttons',
                                                '.mod_menu_row',
                                                '.post_buttons:hover',
                                                '.post_buttons',
                                                '.quote_title',
                                                '.quote',
                                                '.user_options_row',
                                                '.t_userinfo',
                                                '.ThreadOtions',
                                                '#ThreadOtions a:visited',
                                                '#ThreadOtions li a:hover',
                                                '#ThreadOtions li a',
                                                '#ThreadOtions li',
                                                '#ThreadOtions div a:hover',
                                                '#ThreadOtions div a',
                                                '#ThreadOtions div',
                                                '#ThreadOtions',
                                                '.forum_posts',
                                                '.post',);
                                                
        foreach($css_get['css_thread'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            if($k == '.forum_posts') $css_code .= "\n width: 100%;";
            $css_save['css_thread'][trim($k)] = trim($css_code); 
        }  
        
        
        $css_get['css_page_jumps'] = array('.page_jumps_top:hover',
                                                '.page_jumps_top',
                                                '.page_jumps_bot:hover',
                                                '.page_jumps_bot',);
        foreach($css_get['css_page_jumps'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_page_jumps'][trim($k)] = trim($css_code); 
        } 
        
        
        
        $css_get['css_top_menu'] = array('.top_user_links',
                                                '#TopMenuLinksHolder li a:hover',
                                                '#TopMenuLinksHolder li a',
                                                '#TopMenuLinksHolder li',
                                                '#TopMenuLinksHolder a:visited',
                                                '#TopMenuLinksHolder div a:hover',
                                                '#TopMenuLinksHolder div a',
                                                '#TopMenuLinksHolder div',
                                                '#TopMenuLinksHolder',
                                                '.UserNameOptions',
                                                '#UserNameOptions a:visited',
                                                '#UserNameOptions li a:hover',
                                                '#UserNameOptions li a',
                                                '#UserNameOptions li',
                                                '#UserNameOptions div a:hover',
                                                '#UserNameOptions div a',
                                                '#UserNameOptions div',
                                                '#UserNameOptions',);
        foreach($css_get['css_top_menu'] as $k ){
            $tmp = explode($k, $css_content);
            $tmp = explode('}', $tmp[1]);
            $css_code = str_replace('{', '' , $tmp[0]);
            $css_content = str_replace($k . $tmp[0] . '}', '' , $css_content);
            $css_save['css_top_menu'][trim($k)] = trim($css_code); 
        } 
        
        
        $dbw = wfGetDB( DB_MASTER );
        
        $css_code_count = 0;
         
        foreach($css_save as $section_name => $section_arr){
            
            foreach($section_arr as $att => $code){
                ++$update_count;
                    $dbw->insert( 'awc_f_theme_css', 
                            array('css_section'     => $section_name,
                                    'css_att'       => $att,
                                    'css_thmn_id'   => $css_id,
                                    'css_code'      => $code,
                                    'css_thm_id'    => $thm_id,
                                    'css_ver'       => $ver,) );
            }
            
        }
        
        
        $awc_f_theme_names = $dbw->tableName( 'awc_f_theme_names' );
        $sql = "UPDATE $awc_f_theme_names ";
        $sql .= "SET thmn_item_count = $update_count ";
        $sql .= "WHERE thmn_id =" . $css_id;
        $dbw->query($sql);
        
       #die(">..." . $awcs_forum_config->css_code_count);
       // update awc_config
        
        return ;
        
    }  
    
    function add_new_value_form(){
    global $wgOut;
    
    
    $css_info = array('css_wiki_changes',
                                'css_memcp',
                                'css_search',
                                'css_forum_thread_list',
                                'css_general',
                                'css_main_forums', 
                                'css_thread', 
                                'css_page_jumps',
                                'css_top_menu',
                                'css_poll');
                                

                        
    
    
    
        $out = '<br /><form action="'. awc_url .'admin/css/add_new_value" method="post">';
        $out .= '<input name="id" type="hidden" value="'.$this->css_id.'">' ;
            $out .= ' <select name="what">';   
                foreach($css_info as $k){
                    $out .=  "<option value='$k'>".str_replace(array('css_'), '', $k)."</option>"; 
                }
                $out .=  '</select> ';
                
               $out .= ' <input name="css_att" type="text" value="" size="50"><br />  '; 
        
                
                $out .= "<textarea name='css_code' cols='75' rows='5' wrap='virtual' class='post_box'></textarea> <br />";
                $out .= '<input type="submit" value="'.get_awcsforum_word('word_add').'">';
                        
        $out .= '</form>';
        
        $wgOut->addHTML($out);
    }
    
    function add_new_value(){
    global $wgRequest, $awcs_forum_config ;
    
    $out='';
    
    $att = $wgRequest->getVal( 'css_att' );
    $code = $wgRequest->getVal( 'css_code' );
    
    $allready_here = false;
    
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' ); 
        $sql = "SELECT css_att, css_thm_id FROM $awc_f_theme_css WHERE css_section='$this->css_what' AND css_thmn_id=$this->css_id";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
                                                     
            if($r->css_att == $att) $allready_here = true;
            $css_thm_id = $r->css_thm_id ;
                                 
        }
        
        $dbr->freeResult( $res );
        unset($r, $res);
        
        if($allready_here == false){
               // used to print info for update page...
           $out = "<b><u>CSS</u> New Attribute:</b><br /> - Attribute=".awcsforum_funcs::awc_htmlentities($att)."<br /> - Code=".awcsforum_funcs::awc_htmlentities($code)."<br /><br />";
        
                    $dbw->insert( 'awc_f_theme_css', 
                                        array('css_section'     => $this->css_what,
                                                'css_att'       => $att,
                                                'css_thmn_id'   => $this->css_id,
                                                'css_code'      => $code,
                                                'css_thm_id'    => $css_thm_id,
                                                'css_custom'    => 1,
                                                'css_ver'       => '1.0.0',
                                                'css_forumver'       => $awcs_forum_config->cf_forumversion,) );
                                                
          
               $awc_f_theme_names = $dbw->tableName( 'awc_f_theme_names' );
                    $sql = "UPDATE $awc_f_theme_names " ;
                    $sql .= "SET thmn_item_count = thmn_item_count + 1 "  ;
                    $sql .= "WHERE thmn_id =" . $this->css_id;
               $dbw->query($sql);
               
                                                
        }
        
      return $out;                      
    
    }
    
    function add_new_values($css_Path){
    global $wgRequest ;
    
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $out='';
        
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );
        $sql = "SELECT css_thmn_id, css_thm_id FROM $awc_f_theme_css GROUP BY css_thmn_id";
        $sql = "SELECT css_thmn_id, css_thm_id FROM $awc_f_theme_css";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            $thmn_id[] = $r->css_thmn_id;
            $css_thm_id[$r->css_thmn_id] = $r->css_thm_id;
        }
        $dbr->freeResult( $res );
        
        $css = simplexml_load_file($css_Path);
        

        foreach($css as $info => $arr){
           
               $att_attributes = $arr->attributes();
               $group_name =  $att_attributes['css_section'];
               $group_name = html_entity_decode($group_name, ENT_QUOTES, 'UTF-8');
                 
                         #awc_pdie($att_attributes);   
               # foreach($arr as $info2 => $code){
                            
                    #$att_attributes = $code->attributes();
                        $att = $att_attributes['css_att'];
                        $att = html_entity_decode($att, ENT_QUOTES, 'UTF-8');
                        
                        $forum_ver = $att_attributes['css_forumver'];
                        $forum_ver = html_entity_decode($forum_ver, ENT_QUOTES, 'UTF-8');
                        
                        $code = html_entity_decode($arr, ENT_QUOTES, 'UTF-8');
                        
                        $add_array[$group_name][$att]['css_att'] = $att;
                        $add_array[$group_name][$att]['ver'] = $forum_ver;
                        $add_array[$group_name][$att]['code'] = $code;
                             
                        // used to print info for update page...
                        $out .= "<b><u>CSS</u> New Attribute:</b><br /> - Section=$group_name<br /> - Attribute=".awcsforum_funcs::awc_htmlentities($att)."<br /> - Code=".awcsforum_funcs::awc_htmlentities($code)."<br /><br />";
        
                        
                #}
                
                
        }
        
        
              
        foreach($thmn_id as $id){
                    
                    $css_id[$id] = $add_array;  
                    if(isset($css_id[$id]) AND !empty($css_id[$id])){
                        foreach($css_id[$id] as $css_section => $ii){ 
                            
                                $sql = "SELECT css_att FROM $awc_f_theme_css WHERE css_section='$css_section' AND css_thmn_id=$id";
                                $res = $dbr->query($sql);
                                while ($r = $dbr->fetchObject( $res )) {
                                    
                                   # ++$css_code_count;
                                    
                                    if(array_key_exists($r->css_att, $css_id[$id][$css_section])){
                                        unset($css_id[$id][$css_section][$r->css_att]) ;
                                    }
                                     
                                }
                                $dbr->freeResult( $res );
                                unset($r, $ii);   
                                
                        } 
                    }           
        }
        
     
        $awc_f_theme_names = $dbw->tableName( 'awc_f_theme_names' );  
        foreach($css_id as $css_nameID => $arrs){
                              
            $update_count = 0;
            
             if(isset($arrs) AND !empty($arrs)){
                 
                    foreach($arrs as $section_name => $section_arr){       
                              
                              foreach($section_arr as $att){
                                    ++$update_count;
                                    
                                        $dbw->insert( 'awc_f_theme_css', 
                                                array('css_section'     => $section_name,
                                                        'css_att'       => trim($att['css_att']),
                                                        'css_thmn_id'   => $css_nameID,
                                                        'css_code'      => trim($att['code']),
                                                        'css_thm_id'    => $css_thm_id[$css_nameID],
                                                        'css_custom'    => 0,
                                                        'css_ver'       => $att['ver'],) );
                                                        
                              } unset($att);
                                
                    } unset($section_name, $section_arr);
             }
             
             $sql = "UPDATE $awc_f_theme_names " ;
             $sql .= "SET thmn_item_count = thmn_item_count + $update_count "  ;
             $sql .= "WHERE thmn_id =" . $css_nameID;
             $dbw->query($sql);
                   
        }
                
        unset($thmn_id, $css_thm_id, $add_array, $res, $r, $arrs );
        
        return $out ;
        
    
    }  
    
    function export_xml($for_new_css = false, $forum_installer = false){
    global $wgRequest;
    
       $v = $wgRequest->getVal('ver');
        if(strlen($v) > 1){
            $and_ver = " AND  css_ver='$v'";
        } else {
            $and_ver = null;
        }
    
        $dbr = wfGetDB( DB_SLAVE );
        
        $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
        
        
            $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );
            $sql = "SELECT * FROM $awc_f_theme_names WHERE thmn_id=$this->css_id $and_ver";
            $res = $dbr->query($sql); 
            $r = $dbr->fetchObject( $res );
            $dbr->freeResult( $res );
            
            $css_who = $r->thmn_who;
            $title = htmlentities($r->thmn_title, ENT_QUOTES, 'UTF-8');
            //$css_ver = '1.0.0';
            $css_name_count = $r->thmn_item_count;
            $where = $r->thmn_where;
            $who = htmlentities($r->thmn_who, ENT_QUOTES, 'UTF-8');
            
        if($for_new_css){
           # awc_pdie($wgRequest);
            $who = $wgRequest->getVal('css_who');
            $where = $wgRequest->getVal('css_where');
            $title = $wgRequest->getVal('css_title');
        }
           
        $xml .= "<style title=\"{$title}\" css_ver=\"1.0.0\" who=\"{$who}\" where=\"{$where}\" count=\"{$css_name_count}\">\n";
        
        
        $awc_f_theme_css = $dbr->tableName( 'awc_f_theme_css' );
        $sql = "SELECT css_id, css_section, css_ver, css_att, css_code, css_custom, css_forumver, css_date 
                    FROM $awc_f_theme_css 
                    WHERE css_thmn_id=$this->css_id ORDER BY css_custom DESC";
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
               
            
            $xml .= "\t <css css_section=\"{$r->css_section}\" custom=\"{$r->css_custom}\" css_att=\"".htmlentities($r->css_att, ENT_QUOTES, 'UTF-8')."\" css_ver=\"{$r->css_ver}\" forum_ver=\"{$r->css_forumver}\" css_date=\"". awcsforum_funcs::wikidate($r->css_date) ."\">".htmlentities($r->css_code, ENT_QUOTES, 'UTF-8')."</css>\n";
                
            #$css[$r->css_section][$r->css_id] = array($r->css_att, $r->css_code, $r->css_ver, $r->css_custom, $r->css_forumver); 
            
        }
        $dbr->freeResult( $res );
        
        /**
        foreach($css as $group_name => $group_info){
            
            
            $xml .= "   <css_group name=\"$group_name\">\n";
                
                foreach($group_info as $info){
                    
                    if($forum_installer){
                        $dateis = wfTimestampNow() ;
                    } else {
                        $dateis = awcsforum_funcs::wikidate($info[5]);
                    }
                    
                    #$xml .= "       <template css_att=\"".str_replace('"', '\"', $info[0])."\" forum_ver=\"{$info[2]}\">{$info[1]}</template>\n";
                    $xml .= "       <css custom=\"{$info[3]}\" css_att=\"".htmlentities($info[0], ENT_QUOTES, 'UTF-8')."\" css_ver=\"{$info[2]}\" forum_ver=\"{$info[4]}\" css_date=\"{$dateis}\">".htmlentities($info[1], ENT_QUOTES, 'UTF-8')."</css>\n";
                }
            
            $xml .= "   </css_group>\n\n";
        }
        */
        
        $xml .= '</style>';
        
        
        
        if($forum_installer) return $xml ;
        if($for_new_css) return $xml ;

            $d = awcsforum_funcs::readabledate(wfTimestampNow());
            $filename = awc_dir . "xported_files/css_".preg_replace("/[^a-z0-9-]/", "-", strtolower($title))."_".preg_replace("/[^a-z0-9-]/", "-", strtolower($who))."_$css_ver.xml";

                if(strlen($v) > 1){
                    $hd = @fopen(awc_dir . "updates/$v/css.xml", "w");
                } else {
                    $hd = @fopen($filename . "", "w");
                }
                
            @fwrite($hd, $xml);
            @fclose($hd);
            
            return true;
    
    }
    
    
    
    function css_import($for_new_css = false, $xml_string = null, $fresh_install = false){
    global $wgRequest, $awcs_forum_config ;
    
        if(!$for_new_css){
        	
            if($_FILES["new_css_file"]["error"] == '0'){
                $css_Path = $_FILES["new_css_file"]["tmp_name"] ;
                // $css_name = $_FILES["new_css_file"]["name"] ;
                $css_type = $_FILES["new_css_file"]["type"] ;
            }   else {
                return awcs_forum_error('word_cssfile');
            }
            
           
            
            if (! file_exists($css_Path)){
                 return awcs_forum_error('word_cssfile');
            }
            
            if($css_type != 'text/xml'){
                return awcs_forum_error('word_cssfile');
            }
        }
        
        
        if(!$for_new_css){
            $css = simplexml_load_file($css_Path);
        } else {
            $css = simplexml_load_string($xml_string);
        }
        
        
        
        
        if($fresh_install) $css = simplexml_load_file($for_new_css);
        
        
        $css_info = $css->attributes();
        $title = html_entity_decode( $css_info['title'], ENT_QUOTES, 'UTF-8');
        $css_ver = $css_info['css_ver'];
        $who = html_entity_decode( $css_info['who'], ENT_QUOTES, 'UTF-8');
        $where = html_entity_decode( $css_info['where'], ENT_QUOTES, 'UTF-8');
        $css_name_count = html_entity_decode( $css_info['count'], ENT_QUOTES, 'UTF-8');
        
        
        $info = array('who' => $who, 'where' => $where,);
        $dbw = wfGetDB( DB_MASTER );
        
       # $theme_names_CSS_id = $dbw->nextSequenceValue( 'awc_f_theme_names_thmn_id_seq' );
        $dbw->insert( 'awc_f_theme_names', array(
                    'thmn_title'      => $title,
                    'thmn_when'        => $dbw->timestamp(),
                    'thmn_who'        => $who,
                    'thmn_what'        => 'css',
                    'thmn_where'       => $where,
                    'thmn_item_count'       => $css_name_count,
                ) );
         
        $theme_names_CSS_id = awcsforum_funcs::lastID($dbw, 'awc_f_theme_names', 'thmn_id');
       # print('>thmn_css_id=' . $theme_names_CSS_id . '<br>');
                
        $css_code_count = 0;
        
        
        foreach($css as $obj){
			
            $att_attributes = $obj->attributes();
            
            $css_section = $att_attributes['css_section'];
            $css_att = $att_attributes['css_att'];
            $css_att = html_entity_decode($css_att, ENT_QUOTES, 'UTF-8');
            $css_forumver = $att_attributes['forum_ver'];
            $css_ver = $att_attributes['css_ver'];
            $css_custom = $att_attributes['custom'];
            $css_date = $att_attributes['css_date'];
            
            $css_code = html_entity_decode($obj, ENT_QUOTES, 'UTF-8');
            
            $dbw->insert( 'awc_f_theme_css', 
					array('css_section'     => $css_section,
							'css_att'       => $css_att,
							'css_thmn_id'   => $theme_names_CSS_id,
							'css_code'      => $css_code,
							'css_thm_id'    => $this->thm_id,
							'css_custom'    => $css_custom,
							'css_ver'       => $css_ver,
							'css_date'       => $dbw->timestamp(),
							'css_forumver'       => $css_forumver,) );
		}
		
        if($fresh_install) {
        	$dbw->begin();
            $dbw->update( 'awc_f_theme',
                                array('thm_css_id' => $theme_names_CSS_id), 
                                array('thm_id' =>$this->thm_id),'' );
            $dbw->commit();
        }
        
        if(!$fresh_install) {
            awc_admin_css_cls::add_new_values(awc_dir . "updates/{$awcs_forum_config->cf_forumversion}/css.xml");
        }
        
        return true ;
         
    }

    
    function exported_css_list($ext = '.xml'){
     global $wgOut, $awc;
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('word_exported_files'), true);
        
        // xported_files
        if($ext == '.xml'){
            $url = awc_path . 'xported_files/';
            $dir = awc_dir . 'xported_files/';
        
        } else {
            $url = awc_path . 'skins/css/';
            $dir = awc_dir . 'skins/css/';
        }
            
            
            $d = dir($dir);
            while (false !== ($entry = $d->read())) {
                if(substr($entry , -4) == $ext) {
                    $export_files[] = $entry ;
               }
            }
            $d->close();
           # die(print_r($export_files));
            
            $html = '<hr><br />'. get_awcsforum_word('admin_lang_download_export') . '<hr><br />';
            
            
            if(!isset($export_files)) return $wgOut->addHTML($html);
            
            arsort($export_files);
            foreach($export_files as $file){
                $html .= '(<a href="' . awc_url . 'admin/css/delete_export_file/'  . $file .'">'. get_awcsforum_word('delete') . '</a>) - ';
                $html .= ' <a target="blank" href="' . $url . $file .'">'. str_replace('export_', '', $file) . '</a><br>';
            }
           # $html .= get_awcsforum_word('admin_lang_download_export');
            
        
        return $wgOut->addHTML($html);
    
    
    }
    
    function delete_export_file($file){
    
        $file  = $dir = awc_dir . "xported_files/$file";
        @unlink( $file);

    }
    
    
    
    
    
    
}
