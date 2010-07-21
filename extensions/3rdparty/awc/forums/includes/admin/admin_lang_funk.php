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
* @filepath /extensions/awc/forums/admin/lang_funk.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

class awc_admin_lang_cls extends awcforum_forumAdmin{
    
    var $lang_code, $lang_txt;
    
    function awc_admin_lang_cls($action=''){
    global $wgRequest, $wgOut;
    
        
        $this->lang_code = $wgRequest->getVal( 'lang_code' );
        $this->lang_txt = $wgRequest->getVal( 'lang_txt' );
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_get_lang'));
        
        $spl = explode("/", $action);
        $todo = isset($spl[1]) ? str_replace("todo_", "", $spl[2]) : $wgRequest->getVal( 'what' );
        
       # die($todo);
        switch( $todo ) {
            
              case 'do_raw_lang':
                    $this->do_raw_lang();
                    break; 
        
              case 'display_lang_options':
                    $this->display_lang_options();
                    break;  
                    
              case 'get_edit_lang':
                    $this->get_edit_lang();
                    break; 
                    
                    
              case 'update_lang_file':
                    $this->lang_update_lang_file();
                    $info['msg'] = 'lang_file_has_been_updated';
                    $info['url'] = awc_url . "admin/awc_lang/display_lang_options" ;
                    return awcf_redirect($info);
                    #$wgOut->redirect( awc_url . "admin/awc_lang/display_lang_options" );
                    break;
                    
              case 'export_lang':
						$this->lang_do_export_lang();
						$wgOut->redirect( awc_url . "admin/awc_lang/download_lang_file/" );
                    break;
                    
              case 'import_lang':
						$this->lang_do_import_lang();
                         awcsforum_funcs::get_page_lang(array('lang_txt_redirects')); // get lang difinitions... 
						$info['msg'] = 'lang_file_has_been_imported';
						$info['url'] = awc_url . "admin/awc_lang/display_lang_options" ;
						return awcf_redirect($info);
                    break; 
                    
              case 'add_new_lang':
                    $this->lang_add_new_lang($wgRequest->getVal('lang_code'));
                    #$wgOut->redirect( awc_url . "admin/awc_lang/get_awclangfile" );
                    break; 
                    
              case 'save_lang_file':
                    $this->lang_save_lang_file();
                    break;
                    
              case 'download_lang_file':
                    $this->lang_download_lang_file();
                    break; 
                    
              case 'do_delete_lang':
                    $this->lang_do_delete();
                    $wgOut->redirect( awc_url . "admin/awc_lang/get_awclangfile" );
                    break; 
                    
              case 'delete_lang_export_file':
                   // $this->lang_delete_lang_export_file($wgRequest->getVal('todo'));
                   $this->lang_delete_lang_export_file($spl[3]);
                    $wgOut->redirect( awc_url . "admin/awc_lang/download_lang_file" );
                    break;
                    
            }
    
    
    }
    
    
    
    
    function get_edit_lang(){
    global $wgOut, $awc_lang;
        
        $lang_txt = $this->lang_txt;
           
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_lang_selecttoedit'));
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_' . $lang_txt), true);
        
            $lang = array();
        
                $dbw = wfGetDB( DB_MASTER );
                $dbr = wfGetDB( DB_SLAVE );
                
                $table_1 = $dbr->tableName( 'awc_f_langs' );
                $sql = "SELECT $lang_txt, $lang_txt" . '_raw'.", lang_name, lang_owner_info FROM $table_1 WHERE lang_code='".$this->lang_code."'";
                $res = $dbr->query($sql);
                $r = $dbr->fetchRow( $res );
                    $lang = unserialize($r[$lang_txt]) ;
                    $_raw = $lang_txt . '_raw';
                   # die($_raw);
                    $lang_raw = unserialize($r[$_raw]) ;
                    $lang_name = $r['lang_name'];
                    $lang_owner = unserialize($r['lang_owner_info']) ;
                    
                $dbr->freeResult( $res );
        
        
            $html =  get_awcsforum_word('admin_lang_yourareediting') . ' ' . $lang_name . ' (' . $this->lang_code . ') ' . get_awcsforum_word('admin_' . $lang_txt) ;
            
            
            $html .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/awc_lang/save_lang_file" method="post">'; 
            $html .= '<input name="lang_txt" type="hidden" value="'.$lang_txt.'">' ;
            $html .= '<input name="lang_code" type="hidden" value="'.$this->lang_code.'">' ; 
            $html .= '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0">';
            
            
            $html .= '<tr><td width="100%" align="left" nowrap>'; 
            
           # isset($lang_owner['lang_owner']) ? $langowner = $lang_owner['lang_owner'] : $langowner = '';
            $langowner = isset($lang_owner['lang_owner']) ? $lang_owner['lang_owner'] : '';
            $html .= get_awcsforum_word('admin_lang_owner') . ' <input name="lang_owner" type="text" value="'.$langowner.'" size="15"> ';
            
            #isset($lang_owner['lang_owner_contact']) ? $lang_owner_contact = $lang_owner['lang_owner_contact'] : $lang_owner_contact = '';
            $lang_owner_contact = isset($lang_owner['lang_owner_contact']) ? $lang_owner['lang_owner_contact'] : '';
            $html .= get_awcsforum_word('admin_lang_owner_contact') . ' <input name="lang_owner_contact" type="text" value="'.$lang_owner_contact.'" size="25"> ';
            
            #isset($lang_owner['lang_owner_when']) ? $lang_owner_when = $lang_owner['lang_owner_when'] : $lang_owner_when = '';
            $lang_owner_when = isset($lang_owner['lang_owner_when']) ? $lang_owner['lang_owner_when'] : '';
            $html .= get_awcsforum_word('admin_lang_owner_when') . ' <input name="lang_owner_when" type="text" value="'.$lang_owner_when.'" size="10"> ';

            $html .= '<hr></td></tr>';
            
            
            
            #$html .= '<tr><td width="100%" align="left" nowrap>';  
            #$html .=  get_awcsforum_word('admin_lang_yourareediting') . ' ' . $lang_name . ' (' . $this->lang_code . ') ' . get_awcsforum_word('admin_' . $lang_txt) ;
            #$html .= '<hr></td></tr>';
             
            $repl = array("\n", "\r"); 
            #if(isset($lang)) ksort($lang); 
                 
            if(!empty($lang)){ 
               # ksort($lang);     
                 foreach ($lang as $k => $v) {
                     #die(print_r($lang_raw));
                        $html .= '<tr><td width="100%" align="left" nowrap>';  
                        #$html .= "<b>'". $k . "'</b> " . $v . '<br /><input name="'.$k.'" type="text" value="'.str_replace('"', "''", str_replace($repl, '', $v)).'" size="100%"> '; 
                        $html .= "<b>'". $k . "'</b> " . $v . '<br /><input name="'.$k.'" type="text" value="'.str_replace($repl, '', @$lang_raw[$k]).'" size="100%"> ';
                        $html .= '<br /><br /></td></tr>'; 
               }
            }
               
               
        
        unset($lang);
        $html .= '</table>'; 
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form><br />';
        
        
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_' . $lang_txt)); 
       
       $wgOut->addHTML($html);
       
       return;       
    }
    
    function lang_do_delete(){
    global $wgUser;
        
        if(in_array('bureaucrat', $wgUser->getGroups())) { 
            $dbw = wfGetDB( DB_MASTER );
            $dbw->delete( 'awc_f_langs', array( 'lang_code' => $this->lang_code ), '');
        }
    }
    
    function lang_delete_lang_export_file($link){
    global $awc, $wgOut;
    
        $dir = awc_dir . 'xported_files/' . $link;       
        @unlink( $dir);
        
       # return $wgOut->addHTML('<b>' . $link .'</b> <br />'. get_awcsforum_word('admin_lang_hasbeendeleted')); 
        
    }
    
    function lang_download_lang_file(){
     global $wgOut, $awc;
        
        Set_AWC_Forum_BreadCrumbs('<a href="'. awc_url .'admin/awc_lang/get_awclangfile'. '">' . get_awcsforum_word('save_lang') .'</a>');
        Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_lang_expotlist'), true);
            
            
            $url = awc_path . 'xported_files/';
            $dir = awc_dir . 'xported_files/';
            
            $d = dir($dir);
            while (false !== ($entry = $d->read())) {
                
                if(substr($entry, 0, 5) == 'lang_' AND substr($entry, (strlen($entry) - 4), 4) == '.txt') {
                    $export_files[] = $entry ;
               }
               
            }
            $d->close();
           # die(print_r($export_files));
            
            $html = '<hr><br />'. get_awcsforum_word('admin_lang_download_export') . '<hr><br />';
            
            
            if(!isset($export_files)) return $wgOut->addHTML($html);
            
            arsort($export_files);
            foreach($export_files as $file){
                $html .= '(<a href="' . awc_url . 'admin/awc_lang/delete_lang_export_file/'  . $file .'">'. get_awcsforum_word('delete') . '</a>) - ';
                $html .= ' <a target="blank" href="' . $url . $file .'">'. str_replace('export_', '', $file) . '</a><br>';
            }
           # $html .= get_awcsforum_word('admin_lang_download_export');
            
        
        return $wgOut->addHTML($html);    
    }
    
    function lang_save_lang_file(){
    global $awc, $wgRequest, $awc_lang, $wgOut;

    
            $lang_txt = $this->lang_txt;

        
            $lang = array();
        
            $dbw = wfGetDB( DB_MASTER );
            $dbr = wfGetDB( DB_SLAVE );
                
            
          #  die($lang_txt); 
            if($lang_txt != 'lang_update'){
                
                        $table_1 = $dbr->tableName( 'awc_f_langs' );
                        $sql = "SELECT $lang_txt, lang_owner_info FROM $table_1 WHERE lang_code='".$this->lang_code."'";
                        $res = $dbr->query($sql);
                        $r = $dbr->fetchRow( $res );
                            $lang[$lang_txt] = unserialize($r[0]) ;
                            $lang['lang_owner_info'] = unserialize($r[1]) ;
                        $dbr->freeResult( $res );
                        
                        foreach($lang[$lang_txt] as $k => $v ){
                            
                            if($lang_txt != 'lang_owner_info'){
                                $lang[$lang_txt][$k] = awc_admin_wikipase(trim($wgRequest->getVal($k)));
                                $lang[$lang_txt . '_raw'][$k] = $wgRequest->getVal($k); 
                            } else {
                                $lang[$lang_txt][$k] = $wgRequest->getVal($k);
                            }
                                
                                                       
                        }
                        
                        $lang['lang_owner_info']['lang_owner'] = $wgRequest->getVal('lang_owner');
                        $lang['lang_owner_info']['lang_owner_contact'] = $wgRequest->getVal('lang_owner_contact');
                        $lang['lang_owner_info']['lang_owner_when'] = $wgRequest->getVal('lang_owner_when');
                        
                        $dbw->update( 'awc_f_langs',
                                        array( /* SET */
                                                    $lang_txt            => serialize($lang[$lang_txt]) ,
                                                    $lang_txt . '_raw'   => serialize($lang[$lang_txt . '_raw']) ,
                                                    'lang_owner_info'    => serialize($lang['lang_owner_info']) ,
                                                    ), 
                                            array( /* WHERE */
                                                    'lang_code' => $this->lang_code
                                            ), ''
                                        
                                        );
                                        
            } else {
                
                        $table_1 = $dbr->tableName( 'awc_f_langs' );
                        $sql = "SELECT * FROM $table_1 WHERE lang_code='".$this->lang_code."'";
                        $res = $dbr->query($sql);
                        $r = $dbr->fetchRow( $res );
                        
                            $lang['lang_txt_forum'] = unserialize($r['lang_txt_forum']) ;
                            $lang['lang_txt_thread'] = unserialize($r['lang_txt_thread']) ;
                            $lang['lang_txt_admin'] = unserialize($r['lang_txt_admin']) ;
                            $lang['lang_txt_mem'] = unserialize($r['lang_txt_mem']) ;
                            $lang['lang_txt_tag'] = unserialize($r['lang_txt_tag']) ;
                            $lang['lang_txt_search'] = unserialize($r['lang_txt_search']) ;
                            $lang['lang_update'] = unserialize($r['lang_update']) ;
                            $lang['lang_txt_redirects'] = unserialize($r['lang_txt_redirects']) ;
                            $lang['lang_owner_info'] = unserialize($r['lang_owner_info']) ;
                            
                        $dbr->freeResult( $res );
                        
                       # print_r($lang['lang_txt_search']);
                        
                        foreach($lang[$lang_txt] as $k => $v ){
                           
                                $lang['tmp'][$k] = $wgRequest->getVal($k);
                                
                                if(array_key_exists($k, $lang['lang_txt_forum'])){
                                    #$lang['lang_txt_forum'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_forum'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_forum_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_thread'])){
                                    #$lang['lang_txt_thread'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_thread'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_thread_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_admin'])){
                                   # $lang['lang_txt_admin'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_admin'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_admin_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_mem'])){
                                    #$lang['lang_txt_mem'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_mem'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_mem_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_tag'])){
                                   # $lang['lang_txt_tag'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_tag'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_tag_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_search'])){
                                    #$lang['lang_txt_search'][$k] = $lang['tmp'][$k] ;
                                    $lang['lang_txt_search'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_search_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                if(array_key_exists($k, $lang['lang_txt_redirects'])){
                                    $lang['lang_txt_redirects'][$k] = awc_admin_wikipase(trim($lang['tmp'][$k]));
                                    $lang['lang_txt_redirects_raw'][$k] = $lang['tmp'][$k];
                                }
                                
                                
                                
                        
                        }
                        
                        
                        $lang['lang_owner_info']['lang_owner'] = $wgRequest->getVal('lang_owner');
                        $lang['lang_owner_info']['lang_owner_contact'] = $wgRequest->getVal('lang_owner_contact');
                        $lang['lang_owner_info']['lang_owner_when'] = $wgRequest->getVal('lang_owner_when');
                        
                        $dbw->update( 'awc_f_langs',
                                        array( /* SET */
                                                    'lang_txt_forum'            => serialize($lang['lang_txt_forum']) ,
                                                    'lang_txt_forum_raw'            => serialize($lang['lang_txt_forum_raw']) ,
                                                    'lang_txt_thread'            => serialize($lang['lang_txt_thread']) ,
                                                    'lang_txt_thread_raw'            => serialize($lang['lang_txt_thread_raw']) ,
                                                    'lang_txt_admin'            => serialize($lang['lang_txt_admin']) ,
                                                    'lang_txt_admin_raw'            => serialize($lang['lang_txt_admin_raw']) ,
                                                    'lang_txt_mem'            => serialize($lang['lang_txt_mem']) ,
                                                    'lang_txt_mem_raw'            => serialize($lang['lang_txt_mem_raw']) ,
                                                    'lang_txt_tag'            => serialize($lang['lang_txt_tag']) ,
                                                    'lang_txt_tag_raw'            => serialize($lang['lang_txt_tag_raw']) ,
                                                    'lang_txt_search'            => serialize($lang['lang_txt_search']) ,
                                                    'lang_txt_search_raw'            => serialize($lang['lang_txt_search_raw']) ,
                                                    'lang_txt_redirects'            => serialize($lang['lang_txt_redirects']) ,
                                                    'lang_txt_redirects_raw'            => serialize($lang['lang_txt_redirects_raw']) ,
                                                    'lang_update'    => '' ,
                                                    ), 
                                            array( /* WHERE */
                                                    'lang_code' => $this->lang_code
                                            ), ''
                                        
                                        );
            
            
            }
            
        $wgOut->redirect( awc_url . "admin/awc_lang/display_lang_options" );
    }
    
    
    
    function lang_add_new_lang($abbr){
    global $awcs_forum_config, $wgOut ;
    
    // redirects and errors...
    
         if($abbr == '') return $wgOut->addHTML('<hr><br />'. get_awcsforum_word('admin_lang_newlangempty')) ;
         
         $languages = Language::getLanguageNames( true );
         $lang_name = $languages[$abbr];
         
        # die("<>>". $lang_name);
                
                $en_lang = array();
                
                $dbw = wfGetDB( DB_MASTER );
                $dbr = wfGetDB( DB_SLAVE );
                
                $table_1 = $dbr->tableName( 'awc_f_langs' );
                $sql = "SELECT * FROM $table_1 WHERE lang_code='".$abbr."' OR lang_code='en'";
                $res = $dbr->query($sql);
                 while ($r = $dbr->fetchObject( $res )) {
                     
                     if($r->lang_code == $abbr){
                         return  awcs_forum_error(get_awcsforum_word('admin_lang_newlangalreadythere') . ' <b>' . $lang_name . '</b>');
                     }
                     
                     $en_lang['lang_txt_forum'] = $r->lang_txt_forum ;
                     $en_lang['lang_txt_thread'] = $r->lang_txt_thread ;
                     $en_lang['lang_txt_admin'] = $r->lang_txt_admin ;
                     $en_lang['lang_txt_mem'] = $r->lang_txt_mem ;
                     $en_lang['lang_txt_tag'] = $r->lang_txt_tag ;
                     $en_lang['lang_txt_search'] = $r->lang_txt_search ;
                     $en_lang['lang_txt_redirects'] = $r->lang_txt_redirects ;
                     
                     $en_lang['lang_txt_forum_raw'] = $r->lang_txt_forum_raw ;
                     $en_lang['lang_txt_thread_raw'] = $r->lang_txt_thread_raw ;
                     $en_lang['lang_txt_admin_raw'] = $r->lang_txt_admin_raw ;
                     $en_lang['lang_txt_mem_raw'] = $r->lang_txt_mem_raw ;
                     $en_lang['lang_txt_tag_raw'] = $r->lang_txt_tag_raw ;
                     $en_lang['lang_txt_search_raw'] = $r->lang_txt_search_raw ;
                     $en_lang['lang_txt_redirects_raw'] = $r->lang_txt_redirects_raw ;
                     
                     
                     
                 }
                 
                $dbr->freeResult( $res );
                
                            $dbw->insert( 'awc_f_langs', array(
                                'lang_code'        => $abbr,
                                'lang_name'        => $lang_name,
                                'lang_txt_forum'   => $en_lang['lang_txt_forum_raw'],
                                'lang_txt_admin'   => $en_lang['lang_txt_admin_raw'],
                                'lang_txt_mem'     => $en_lang['lang_txt_mem_raw'],
                                'lang_txt_search'  => $en_lang['lang_txt_search_raw'],
                                'lang_txt_tag'     => $en_lang['lang_txt_tag_raw'],
                                'lang_txt_thread'  => $en_lang['lang_txt_thread_raw'],
                                'lang_txt_redirects'   => $en_lang['lang_txt_redirects'],
                                
                                'lang_txt_forum_raw'   => $en_lang['lang_txt_forum_raw'],
                                'lang_txt_admin_raw'   => $en_lang['lang_txt_admin_raw'],
                                'lang_txt_mem_raw'     => $en_lang['lang_txt_mem_raw'],
                                'lang_txt_search_raw'  => $en_lang['lang_txt_search_raw'],
                                'lang_txt_tag_raw'     => $en_lang['lang_txt_tag_raw'],
                                'lang_txt_thread_raw'  => $en_lang['lang_txt_thread_raw'],
                                'lang_txt_redirects_raw'  => $en_lang['lang_txt_redirects_raw'],
                            ) );
                            
                            $dbw->update( 'awc_f_config',
                                array( /* SET */
                                            'a'    => $awcs_forum_config->cf_forumlang . ',' . $abbr ,
                                            ), 
                                    array( /* WHERE */
                                            'q' => 'cf_forumlang'
                                    ), ''
                                
                                );
                                
                $awcs_forum_config->cf_forumlang = $awcs_forum_config->cf_forumlang . ',' . $abbr;
         
         
                $this->lang_update_lang_file();
                $info['msg'] = get_awcsforum_word('admin_lang_newlangreated') . ' <b>' . $lang_name . '</b>';
                $info['url'] = awc_url . "admin/awc_lang/display_lang_options" ;
                return awcf_redirect($info);
                    
       # return $wgOut->addHTML('<hr><br />'. get_awcsforum_word('admin_lang_newlangreated') . ' <b>' . $lang_name . '</b>' );
        
    }
    
    function display_lang_options(){
    global $wgOut, $awc_lang, $awc, $wgLanguageCode, $wgUser ;
    
        Set_AWC_Forum_BreadCrumbs('', true);
        
        # pull form Wiki... used for "Create New Lang Pack" option
        $languages = Language::getLanguageNames( false );
        #sort($languages);       
        
        $html = '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0">';
        
               $e = null;
               $d = null;
               
                $dbr = wfGetDB( DB_SLAVE );
                $table_1 = $dbr->tableName( 'awc_f_langs' );
                $sql = "SELECT lang_code, lang_name FROM $table_1";
                $res = $dbr->query($sql);
                while ($r = $dbr->fetchObject( $res )) {
                    
                    if($wgLanguageCode == $r->lang_code){
                            $e .= '<option value="'. $r->lang_code .'" SELECTED>'. $r->lang_name .'</option>';
                            if($r->lang_code != 'en') $d .= '<option value="'. $r->lang_code .'" SELECTED>'. $r->lang_name .'</option>';
                        } else {
                            $e .= '<option value="'. $r->lang_code .'">'. $r->lang_name .'</option>';
                            if($r->lang_code != 'en') $d .= '<option value="'. $r->lang_code .'">'. $r->lang_name .'</option>';
                        }
                    
                }
                $dbr->freeResult( $res );
                
        
        $html .= '<tr><td width="100%" align="left" nowrap> <br />';  
        $html .= '<hr /><form enctype="multipart/form-data" action="'.awc_url.'admin/awc_lang/get_edit_lang" method="post">';
        $html .= get_awcsforum_word('admin_lang_selecttoedit') . '<br /> <select name="lang_code">' . $e . '</select>'; 
        $html .= " <select name='lang_txt'>
                   <option value='lang_txt_forum'>". get_awcsforum_word('admin_lang_txt_forum') ."</option>
                   <option value='lang_txt_mem'>". get_awcsforum_word('admin_lang_txt_mem') ."</option>
                   <option value='lang_txt_admin'>". get_awcsforum_word('admin_lang_txt_admin') ."</option>
                   <option value='lang_txt_tag'>". get_awcsforum_word('admin_lang_txt_tag') ."</option>
                   <option value='lang_txt_search'>". get_awcsforum_word('admin_lang_txt_search') ."</option>
                   <option value='lang_txt_thread'>". get_awcsforum_word('admin_lang_txt_threads') ."</option>
                   <option value='lang_txt_redirects'>". get_awcsforum_word('admin_lang_txt_redirects') ."</option>
                   <option value='lang_txt_errormsg'>". get_awcsforum_word('admin_lang_txt_errormsg') ."</option>
                    <option value='lang_update'>". get_awcsforum_word('admin_new_lang_update') ."</option>
        </select>";
        
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
        $html .= ' </form> <hr><br />';
        
        
         if(in_array('bureaucrat', $wgUser->getGroups())) {
            $html .= '<hr /><form enctype="multipart/form-data" onsubmit="return delete_form_check(\''.get_awcsforum_word('admin_lang_deletelangcheck').'\')";" action="'.awc_url.'admin/awc_lang/do_delete_lang" method="post">';
            $html .= get_awcsforum_word('admin_lang_selecttodelete') . '<br /> <select name="lang_code">' . $d . '</select>'; 
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
            $html .= ' </form> <hr><br />';
         }
        $html .= '</td></tr>';
        
        $html .= '<tr>';
        $html .= '<td width="100%" class="dl_maintable_head" nowrap>';
        
        
        
        $html .= '<hr /><form enctype="multipart/form-data" id="config" name="config " action="'.awc_url.'admin/awc_lang/add_new_lang" method="post">'; 
        $html .=  get_awcsforum_word('admin_lang_addnew_langfile') ; 
        $html .= ' <br /><a target="blank" href="http://wiki.anotherwebcom.com/Creating_New_Lang_Files">'.get_awcsforum_word('word_moreinfo').'</a><br />';
        
        $html .= '<select name="lang_code">';
        foreach($languages as $l_code => $l_txt){
            $html .= '<option value="'. $l_code .'">'. $l_txt .'</option>';
        }
        $html .= '</select>';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
        $html .= ' </form> <hr><br />'; 
                
        
        $html .= '<hr /><b>'. get_awcsforum_word('admin_word_import_export_update') . '</b><br />' . get_awcsforum_word('admin_lang_import_update_diff') . '<hr><br />';
        $html .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/awc_lang/update_lang_file" method="post">'; 
        $html .= '<a target="blank" href="http://wiki.anotherwebcom.com/Updating%2C_Importing_and_Exporting_of_the_Lang_File">'.get_awcsforum_word('word_readthis').'</a>: ';
        $html .= get_awcsforum_word('admin_lang_update_langfile') . '<br />';
        #$html .= ' <select name="lang_code">' . $e . '</select>'; 
        $html .= ' <input name="new_lang" type="file" size="57" /> '; 
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
        $html .= ' </form> <hr><br />';

        
        $html .= '<form enctype="multipart/form-data" action="'.awc_url.'admin/awc_lang/export_lang" method="post">'; 
        $html .= '<a target="blank" href="http://wiki.anotherwebcom.com/Updating%2C_Importing_and_Exporting_of_the_Lang_File">'.get_awcsforum_word('word_readthis').'</a>: ' . get_awcsforum_word('admin_lang_export_langfile') ; 
        $html .= ' <br /><select name="lang_code">' . $e . '</select> ';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
        $html .= ' <br /> <a href="'.awc_url.'admin/awc_lang/download_lang_file">'.get_awcsforum_word('admin_lang_viewexportedfiles').'</a> ';
        $html .= ' </form> <hr><br />'; 

        
        $html .= '<form enctype="multipart/form-data" id="config" name="config " action="'.awc_url.'admin/awc_lang/import_lang" method="post">'; 
        $html .= '<a target="blank" href="http://wiki.anotherwebcom.com/Updating%2C_Importing_and_Exporting_of_the_Lang_File">'.get_awcsforum_word('word_readthis').'</a>: ' . get_awcsforum_word('admin_lang_import_langfile') ; 
        $html .= ' <br /><select name="lang_code">' . $e . '</select>';
        $html .= ' <input name="new_lang" type="file" size="57" /> ';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">'; 
        $html .= '</form></tr><tr>';
               
        $html .= '</table>'; 
        
        
       $wgOut->addHTML($html);     
    
    }
    
    function lang_do_export_lang(){
     global $awcs_forum_config ; 
        
               $out = "<?PHP " . chr(10) . chr(10);
               
                $fields = array();
                $fields[] = 'lang_txt_admin_raw';
                $fields[] = 'lang_txt_mem_raw';
                $fields[] = 'lang_txt_forum_raw';
                $fields[] = 'lang_txt_tag_raw';
                $fields[] = 'lang_txt_search_raw';
                $fields[] = 'lang_txt_thread_raw';
                $fields[] = 'lang_txt_redirects_raw';
                
                
                $lang_info = lang_getinfo($this->lang_code ,$fields);
                unset($fields);
                
                foreach($lang_info as $id => $info){
                    
                    if($id != 'array_fields' AND $id != 'single_fields'){
                        
                        foreach($lang_info[$id] as $section => $key){
                                                  #          die($section);
                            if($id != 'array_fields' 
                                AND $id != 'single_fields' 
                                AND !in_array($section, $lang_info['single_fields'])
                                AND strstr($section,'_raw')
                             ){
								 
                                $section_name = str_replace('_raw','',$section);
                                $section_name = $section ;
                                
                                $out .= "$$section_name = array( " . chr(10) ;
                                
                                    foreach($lang_info[$id][$section] as $k => $v){
                                        $out .= "'" . $k . "' => \"" . str_replace('"', '\"', trim($v)) . '", ' . chr(10);
                                       # $out .= "[[" . $k . " - Forum Definition|" . $k . "]] = " . str_replace('"', '\"', $v) . chr(10) . chr(10);
                                    }
                                
                                $out .= ");"  . chr(10)  . chr(10);
                                #$out .= chr(10)  . chr(10);
                            }
                            
                        }
                    
                    }
                }
                
            $d = awcsforum_funcs::readabledate(wfTimestampNow());
            $filename = awc_dir . "xported_files/lang_{$this->lang_code}_$d.txt";
            $hd = @fopen($filename . "", "w");
            @fwrite($hd, $out);
            @fclose($hd);
            
            return true;
    }
    
    function lang_update_lang_file($file_path=''){
    global $awc_lang, $delete_langs ;        
        
          $out ='';
        if(isset($_FILES["new_lang"])){
            $lang_Path = $_FILES["new_lang"]["tmp_name"] ;
        }  else {
            $lang_Path = $file_path;
        }
          
        if($lang_Path == '') return ;
        require($lang_Path);
        
        $fields = array();
        
        $fields[] = 'lang_update';
        $fields[] = 'lang_update_raw';
                    
        if(isset($lang_txt_admin_raw)){
            $fields[] = 'lang_txt_admin';
            $fields[] = 'lang_txt_admin_raw';
        }
                
        if(isset($lang_txt_mem_raw)){
            $fields[] = 'lang_txt_mem';
            $fields[] = 'lang_txt_mem_raw';
        }
                
        if(isset($lang_txt_forum_raw)){
            $fields[] = 'lang_txt_forum';
            $fields[] = 'lang_txt_forum_raw';
        }
                
        if(isset($lang_txt_tag_raw)){
            $fields[] = 'lang_txt_tag';
            $fields[] = 'lang_txt_tag_raw';
        }
                
        if(isset($lang_txt_search_raw)){
            $fields[] = 'lang_txt_search';
            $fields[] = 'lang_txt_search_raw';
        }
                
        if(isset($lang_txt_thread_raw)){
            $fields[] = 'lang_txt_thread';
            $fields[] = 'lang_txt_thread_raw';
        }
        
        if(isset($lang_txt_errormsg_raw)){
            $fields[] = 'lang_txt_errormsg';
            $fields[] = 'lang_txt_errormsg_raw';
        }
        
        
        if(isset($lang_txt_redirects_raw)){
            $fields[] = 'lang_txt_redirects';
            $fields[] = 'lang_txt_redirects_raw';
        }
        
        $current_lang = array(); 
        $current_lang = lang_getinfo('',$fields);
        #awc_pdie($current_lang);
        
        if ( file_exists( awc_dir .'updates/lang_delete.txt')){
            require(awc_dir .'updates/lang_delete.txt'); 
        } else {
            
            if(!isset($delete_langs) OR empty($delete_langs)){
                $delete_langs[] = 'tmp';  
            } 
            
        }
                
        if(!isset($delete_langs)) $delete_langs[] = 'tmp' ;
                       
        foreach($current_lang as $lang_id => $all_keys){         
            
            $working_lang = $all_keys['lang_code'] ;
            $working_id = $all_keys['lang_id'] ;
            $array_fields = @$current_lang['array_fields'] ;
            
                        
            unset($current_lang[$lang_id]['lang_code'],
                    $current_lang[$lang_id]['lang_id'],
                    $current_lang['array_fields'], 
                    $all_keys['lang_code'],
                    $all_keys['lang_id']);
                    
            #awc_pdie($lang_txt_redirects_raw); 
                   
            foreach($all_keys as $current_key => $no){
                #unset($no);
                
                $get_update_key_name = str_replace('_raw', '', $current_key);
                 /** @changeVer 2.5.8 change ($get_update_key_name) to look up with '_raw' to make complient with the import/export */
                $get_update_key_name = $current_key;
                                        
                if($current_key != 'lang_update_raw' AND
                    $current_key != 'lang_update' AND 
                    strstr($current_key, '_raw')){
                    
                        $current_key_no_raw = str_replace('_raw', '', $current_key);
                        
                        if(empty($current_lang[$lang_id][$current_key]) OR !isset($current_lang[$lang_id][$current_key])){
                           $current_lang[$lang_id][$current_key] = array('tmp' => 'tmp');
                        }
                        
                        if(empty($current_lang[$lang_id][$current_key_no_raw]) OR !isset($current_lang[$lang_id][$current_key_no_raw])){
                            $current_lang[$lang_id][$current_key_no_raw] = array('tmp' => 'tmp');
                        }
                        
                        /*
                         return's 'updated', 'dif' and $update_current
                            'updated' has fully updated the array_raw
                            'dif' is new array with the new keys and values
                            'phased' text in array have been wiki_phased
                            $update_current - nothing was different so it just passes the origenal array through
                        */
                        $update_current = array();
                        $update_current = arr_CheckIn($$get_update_key_name,
                                                        $current_lang[$lang_id][$current_key], 
                                                        true, true);
                                                                                      
                        if(isset($update_current['updated'])){
                            
                            $current_lang[$lang_id][$current_key] = $update_current['updated'];
                            
                            // add the phased lang text
                            $current_lang[$lang_id][$current_key_no_raw] = arr_AddTo($update_current['phased'], $current_lang[$lang_id][$current_key_no_raw]);
                            
                            // used to print info for update page...  
                            $out .= "<b><u>Language</u> definsion added:</b><br /> - Key=$current_key_no_raw<br /> - Text=$current_lang[$lang_id][$current_key_no_raw]<br /><br />";
         
                                if($working_lang != 'en'){
                                    
                                    $check2 = array();
                                    $check2 = arr_CheckIn($update_current['dif'],
                                                            $current_lang[$lang_id]['lang_update_raw'], 
                                                            true, true); 
                                                            
                                    if(isset($check2['updated'])){
                                        $current_lang[$lang_id]['lang_update_raw'] = $check2['updated'];
                                        $current_lang[$lang_id]['lang_update'] = arr_AddTo($check2['phased'], $current_lang[$lang_id]['lang_update']);
                                    } 
                                    unset($check2);       
                                }
                                 
                        } else {
                            
                           // $current_lang[$lang_id][$current_key] = $update_current;
                        }
                        unset($update_current);
                                                                                       
                }
                
                
                    if(!empty($current_lang[$lang_id][$current_key])){
                        foreach($current_lang[$lang_id][$current_key] as $key => $difi){
                            if(in_array($key, $delete_langs)){
                                unset($current_lang[$lang_id][$current_key][$key]);
                                unset($current_lang[$lang_id][$current_key_no_raw][$key]);
                            }
                        }
                    }
                                                        
                                
            }
            // done with one lang-id 
            unset($all_keys);
            
            $current_lang[$lang_id]['array_fields'] = $fields ;
            
            lang_sql_update($current_lang[$lang_id], $working_id);
            unset($current_lang[$lang_id]);         
            
        }
         unset($fields);
                
                 
        return $out;
    }
     
     /** @changeVer 2.5.8 did a bit of work to this function... */
     function lang_do_import_lang($lang_Path =''){
     global $wgRequest, $wgOut;
     
          if($lang_Path == ''){
                 
                 if($_FILES["new_lang"]["error"] == '0'){
                     $lang_Path = $_FILES["new_lang"]["tmp_name"] ;
                     $lang_name = $_FILES["new_lang"]["name"] ;
                 }   else {
                     $lang_Path  = $lang_Path;
                 }
                 
                 
                if($wgRequest->getVal('lang_code') == '') {
                      return awcs_forum_error('admin_lang_needtoselectlang');
                } 
                $lang_code =  $wgRequest->getVal('lang_code');
                
          }      
                
                
                
                # put a check if file exitsts...
                if (! file_exists($lang_Path)){
                    return awcs_forum_error('admin_update_sorrynofile');
                }
                require($lang_Path);
                 
                $lang_info = array();
                $save_lang_info = array(); 
                
                $save_lang_info_raw = array();  
                $lang_info_raw = array(); 
                 
                
                $fields = array();
                #$fields[] = 'lang_owner_info';
                $fields[] = 'lang_txt_admin_raw';
                $fields[] = 'lang_txt_mem_raw';
                $fields[] = 'lang_txt_forum_raw';
                $fields[] = 'lang_txt_tag_raw';
                $fields[] = 'lang_txt_search_raw';
                $fields[] = 'lang_txt_thread_raw';
                $fields[] = 'lang_txt_errormsg_raw';
                $fields[] = 'lang_txt_redirects_raw';
                
                /** @todo get rid of this and add a query to get id */
                $lang_info = lang_getinfo($this->lang_code ,$fields);
                #awc_pdie($lang_info);
                // get ID from first key
                $lang_id = key($lang_info);
                
                $update_vals = array();
                foreach($fields as $key){
                    
                    $import_key = str_replace('_raw', '', $key);
                    
                    if(isset($$key)){
						
							foreach($$key as $k => $v){
							   $lang_info[$key][$k] = $v ;
							   $lang_info[$import_key][$k] = awc_wikipase($v, $wgOut);
							}
							
						   $update_vals[$key] = serialize($lang_info[$key]);
						   $update_vals[$import_key] = serialize($lang_info[$import_key]);

				   }                
                
                }
                
                if(empty($lang_owner_info) or !isset($lang_owner_info)){
					$lang_owner_info = array('lang_owner_when'=>"", 'lang_owner'=>"", 'lang_owner_contact'=>""	);
				}
                $update_vals['lang_owner_info'] = serialize($lang_owner_info);
                
               #  awc_pdie($update_vals);
                
                $dbw = wfGetDB( DB_MASTER );
                $dbw->update( 'awc_f_langs', $update_vals, array('lang_id' => $lang_id), '' );                
                
                return ;
     }
     
     function write_lang_file($info, $file, $arr, $lang=''){
     global $awc, $wgLanguageCode ;
     
         $lang == ''? $lang = awc_dir: $lang = $lang ;
     
            $filename = awc_dir . 'languages/'.$lang.'/' . $file . '_lang.php';
            
           # die($filename);
            #$filename = awc_dir . 'languages/LanguageEn.php';
            #die($filename);
            $handle = @fopen($filename, "r");
            $contents = @fread($handle, filesize($filename));
            @fclose($handle);
            
            $hd = @fopen($filename . ".bak", "w");
            @fwrite($hd, $contents);
            @fclose($hd);
            
            
            
        $out = '<?php
#-------------------------------------------------------------------
# When making other Language files
# follow the same format as this
$'.$arr.' = array(
';
        
         $out .= $info;
         
         $out .= ");
";


            $hd = @fopen($filename . "", "w");
            @fwrite($hd, $out);
            @fclose($hd);
            
            
     }
     
    
    function do_raw_lang(){
    global $wgOut;
    
        $dbw = wfGetDB( DB_MASTER );
        $dbr = wfGetDB( DB_SLAVE );
        
        $awc_f_langs = $dbr->tableName('awc_f_langs');
        
        $sql = "SELECT lang_id, 
                        lang_txt_forum,
                        lang_txt_thread, 
                        lang_txt_admin, 
                        lang_txt_mem, 
                        lang_txt_tag, 
                        lang_txt_search, 
                        lang_txt_errormsg,
                        lang_txt_redirects
                   FROM $awc_f_langs ";
                   
               //   die($sql);
        
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            
                $lang_txt_forum_raw =       unserialize($r->lang_txt_forum);
                $lang_txt_thread_raw =      unserialize($r->lang_txt_thread);
                $lang_txt_admin_raw =       unserialize($r->lang_txt_admin);
                $lang_txt_mem_raw =         unserialize($r->lang_txt_mem);
                $lang_txt_tag_raw =         unserialize($r->lang_txt_tag);
                $lang_txt_search_raw =      unserialize($r->lang_txt_search);
                $lang_txt_errormsg_raw =    unserialize($r->lang_txt_errormsg);
                $lang_txt_redirects_raw =   unserialize($r->lang_txt_redirects);
                
                if(isset($lang_txt_redirects_raw) AND !empty($lang_txt_redirects_raw)){     
                        foreach ($lang_txt_redirects_raw as $k => $v) {
                            $new_lang_txt_redirects[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_redirects_raw['tmp'] = 'tmp';
                    $new_lang_txt_redirects['tmp'] = 'tmp';
                }
                
                
                if(isset($lang_txt_forum_raw) AND !empty($lang_txt_forum_raw)){     
                        foreach ($lang_txt_forum_raw as $k => $v) {
                            $new_lang_txt_forum[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_forum_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_thread_raw) AND !empty($lang_txt_thread_raw)){ 
                        foreach ($lang_txt_thread_raw as $k => $v) {
                            $new_lang_txt_thread[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_thread_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_admin_raw) AND !empty($lang_txt_admin_raw)){ 
                        foreach ($lang_txt_admin_raw as $k => $v) {
                            $new_lang_txt_admin[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_admin_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_mem_raw) AND !empty($lang_txt_mem_raw)){         
                        foreach ($lang_txt_mem_raw as $k => $v) {
                            $ew_lang_txt_mem[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_mem_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_search_raw) AND !empty($lang_txt_search_raw)){        
                        foreach ($lang_txt_search_raw as $k => $v) {
                            $new_lang_txt_search[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_search_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_tag_raw) AND !empty($lang_txt_tag_raw)){     
                        foreach ($lang_txt_tag_raw as $k => $v) {
                            $new_lang_txt_tag[$k] = awc_wikipase($v, $wgOut);
                        }
                } else {
                    $lang_txt_tag_raw['tmp'] = 'tmp';
                    $new_lang_txt_tag['tmp'] = 'tmp';
                }
            
                if(isset($lang_txt_errormsg_raw) AND !empty($lang_txt_errormsg_raw)){
                    foreach ($lang_txt_errormsg_raw as $k => $v) {
                        $new_lang_txt_errormsg[$k] = awc_wikipase($v, $wgOut);
                    }
                } else {
                    $lang_txt_errormsg_raw['tmp'] = 'tmp';
                    $new_lang_txt_errormsg['tmp'] = 'tmp';
                }
                
                $dbw->update( 'awc_f_langs',
                                array('lang_txt_forum' => serialize($new_lang_txt_forum),
                                      'lang_txt_thread' => serialize($new_lang_txt_thread),
                                      'lang_txt_admin' => serialize($new_lang_txt_admin),
                                      'lang_txt_mem' => serialize($ew_lang_txt_mem),
                                      'lang_txt_tag' => serialize($new_lang_txt_tag),
                                      'lang_txt_search' => serialize($new_lang_txt_search),
                                      'lang_txt_redirects' => serialize($new_lang_txt_redirects),
                                      'lang_txt_errormsg' => serialize($new_lang_txt_errormsg),
                                      
                                      'lang_txt_forum_raw' => serialize($lang_txt_forum_raw),
                                      'lang_txt_thread_raw' => serialize($lang_txt_thread_raw),
                                      'lang_txt_admin_raw' => serialize($lang_txt_admin_raw),
                                      'lang_txt_mem_raw' => serialize($lang_txt_mem_raw),
                                      'lang_txt_tag_raw' => serialize($lang_txt_tag_raw),
                                      'lang_txt_search_raw' => serialize($lang_txt_search_raw),
                                      'lang_txt_redirects_raw' => serialize($lang_txt_redirects_raw),
                                      'lang_txt_errormsg_raw' => serialize($lang_txt_errormsg_raw),),
                                array('lang_id' => $r->lang_id),
                                '' );
                                
                unset($new_lang_txt_forum, $new_lang_txt_thread, $new_lang_txt_admin, $new_lang_txt_mem, $new_lang_txt_tag, $new_lang_txt_search, $new_lang_txt_redirects, $new_lang_txt_errormsg, $lang_txt_forum_raw, $lang_txt_thread_raw, $lang_txt_admin_raw, $lang_txt_mem_raw, $lang_txt_tag_raw, $lang_txt_search_raw, $lang_txt_redirects_raw, $lang_txt_errormsg_raw);
                    
                            
        }
        
    }
     
}




