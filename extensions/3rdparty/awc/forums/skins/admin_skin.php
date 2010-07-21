<?PHP
if ( !defined( 'MEDIAWIKI' ) ) die();

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


class awc_admin_skin  extends awcforum_forumAdmin{

	function AdminGetForums(){
	global $wgTitle, $awc;
	
	}
    
    
    function wiki_groups($selected){
    
    
    }
    
    
    
    function Maintance($e){
	global $wgTitle, $awc, $wgUser;
	
	
		$tmp = awc_url . 'admin/do_prune';
		
		#$html = '<a href="http://wiki.anotherwebcom.com/Category:MediaWiki:Forum" target="new"><img src="http://anotherwebcom.com/awc_forum_update.gif"></a>';
        $html = null;
        if(in_array('bureaucrat', $wgUser->getGroups())) { 
            $txt = get_awcsforum_word('admin_maint_Deleteall');        
            $html = '<br /><table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
		    $html .= '<td width="100%" class="dl_maintable_head" nowrap>';
            $html .= get_awcsforum_word('admin_PrunThreads') . '  <a target="blank" href="http://wiki.anotherwebcom.com/Pruning_Thread(AWC_Wiki_Forum)">'.get_awcsforum_word('word_caution').': '.get_awcsforum_word('word_moreinfo').'</a><br />';
            $html .= '<form name="prun" onsubmit="return delete_form_check(\''.get_awcsforum_word('admin_prun_deletelangcheck').'\')";" action="'. $tmp .'" method="post">';
            #$html .= '<form name="prun" action="'. $tmp .'" method="post" onsubmit="return prun_check('. "'" . $tmp . "','" . $txt ."'" .')">';
            $html .= $e['forums_drop'];
            $html .= $e['month_drop'];
            $html .= $e['day_drop'];
            $html .= $e['year_drop'];
            $html .= '<input type="submit" value="'.get_awcsforum_word('submit').'">';
            $html .= '</form></td>';
		    $html .= '</tr></table><br /><br />';
        } 
        
        #$html .= get_awcsforum_word('admin_maint_recount'); 
        $tmp = awc_url . 'admin/do_Trecount';
        $html .= '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
        $html .= '<td width="100%" class="dl_maintable_head" nowrap>';
        $html .= get_awcsforum_word('admin_maint_Thread_recount') . '  <a target="blank" href="http://wiki.anotherwebcom.com/Pruning_Thread(AWC_Wiki_Forum)">'.get_awcsforum_word('word_caution').': '.get_awcsforum_word('word_moreinfo').'</a><br />';
        $html .= '<form name="recount" action="'. $tmp .'" method="post">';
        #$html .= '<form name="prun" action="'. $tmp .'" method="post" onsubmit="return prun_check('. "'" . $tmp . "','" . $txt ."'" .')">';
        $html .= $e['forums_drop'] . ' ' ;
       # $html .= get_awcsforum_word('admin_limit'). ' <input name="limit" type="text" value="500" size="10"> '; 
        $html .= '<input type="submit" value="'.get_awcsforum_word('submit').'">';
        $html .= '</form></td>';
        $html .= '</tr></table><br />';
        
        return $html;
    
    
    
    }
	
	function MainAdmin(){
	global $wgTitle, $awc_lang, $wgUser;
    
		$tmp = awc_url . 'admin/';
        
		#$html = '<a href="http://wiki.anotherwebcom.com/Category:MediaWiki:Forum" target="new"><img src="http://anotherwebcom.com/awc_forum_update.gif"></a>';
        $html = '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
		$html .= '<td width="25%" class="dl_maintable_head" nowrap>'.get_awcsforum_word('admin_controls').'</td>';
		$html .= '<td width="75%" class="dl_maintable_head" nowrap><a href="http://wiki.anotherwebcom.com/Category:MediaWiki:Forum" target="new"><img src="http://anotherwebcom.com/awc_forum_update.gif"></a></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
		$html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. $tmp .'cat/create_cat">'.get_awcsforum_word('admin_create_new_cat').'</a></td>';
		$html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; </td>';
		$html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. $tmp .'cat/get_cat_list">'.get_awcsforum_word('admin_word_edit_cat').'</a></td>';
        
        $html .= '<td width="85%" align="left" nowrap class="thread_rows1">';
        
        $html .= '<form action="'.awc_url.'admin/cat/get_cat_id_edit/" method="post">';
        $html .= '<select name="id">';
        $cats_array = parent::cats_get_all_array();
        foreach($cats_array as $id => $info){
            $html .= '<option value="'.$id.'"> '.$info['cat_name'].'</option>';
        }
        $html .= '</select>';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('edit').'">';
        $html .= '</form>';
        $html .= '</td></tr>';
        
        
        $html .= '<tr>';
		$html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. $tmp .'forum/create_forum">'.get_awcsforum_word('admin_create_new_forum').'</a></td>';
		$html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; </td>';
		$html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. $tmp .'forum/get_forum_list">'.get_awcsforum_word('admin_edit_forum').'</a></td>';
        
        $html .= '<td width="85%" align="left" nowrap class="thread_rows1">';
        
        $html .= '<form action="'.awc_url.'admin/forum/get_forum_id_edit/" method="post">';
        $html .= '<select name="id">';
        $cats_array = parent::forums_get_all_array();
        foreach($cats_array as $id => $info){
            $html .= '<option value="'.$id.'"> '.$info['f_name'].'</option>';
        }
        $html .= '</select>';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('edit').'">';
        $html .= '</form>';
        $html .= '</td></tr>';
        
        
        $html .= '<tr>';
        $html .= '<td width="15%" align="left" nowrap class="thread_rows0">'.get_awcsforum_word('admin_get_config').' <br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/admin_get_config/general">'.get_awcsforum_word('admin_display_geneal_options').'</a><br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/admin_get_config/forum">'.get_awcsforum_word('admin_display_forum_options').'</a><br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/admin_get_config/mem">'.get_awcsforum_word('admin_display_mem_options').'</a><br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/admin_get_config/thread">'.get_awcsforum_word('admin_display_thread_options').'</a><br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/admin_get_config/forum_tag">'.get_awcsforum_word('admin_display_forumtag_options').'</a><br />
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/get_emotions">'.get_awcsforum_word('admin_emotions_edit').'</a><br />  
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/mem_title/get_all">'.get_awcsforum_word('cf_display_mem_titles').'</a><br />
        </td>';
		$html .= '<td width="85%" align="left" nowrap class="thread_rows1" valign="top"> &nbsp; '.get_awcsforum_word('admin_get_config_des').'</td>';
		$html .= '</tr>';
        
        
        # &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/theme">'.get_awcsforum_word('word_forum_theme').'</a><br />
        $html .= '<tr>';
        $html .= '<td width="15%" align="left" nowrap class="thread_rows0">'.get_awcsforum_word('word_forum_theme').' <br />
         
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/css/css_edit_get">'.get_awcsforum_word('admin_editcss').'</a><br /> 
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/tplt/display">'.get_awcsforum_word('admin_edittplt').'</a><br /> 
         &nbsp;  &nbsp; - &nbsp; <a href="'. awc_url . 'admin/css/exported_css_list">'.get_awcsforum_word('admin_exportedfiles').'</a><br /> 
         
         
         </td>';
        $html .= '<td width="85%" align="left" nowrap class="thread_rows1" valign="top"> &nbsp; '.get_awcsforum_word('word_forum_theme_desc').'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
		$html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. awc_url . 'admin/awc_lang/display_lang_options">'.get_awcsforum_word('admin_get_lang').'</a></td>';
		$html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; '.get_awcsforum_word('admin_get_lang_des').'</td>';
		$html .= '</tr>';
        
        $html .= '<tr>';
		$html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. awc_url . 'admin/maintenance">'.get_awcsforum_word('admin_maintenance').'</a></td>';
		$html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; '.get_awcsforum_word('admin_maintenancedesc').'</td>';
		$html .= '</tr>';
        
        $html .= '<tr>';
		$html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'.awcsf_wiki_url.'Special:ListGroupRights">'.get_awcsforum_word('admin_MemberLookup').'</a></td>';
        $html .= '<td width="85%" align="left" nowrap class="thread_rows1">';
        
            $html .= '<form method="get" action="'.awcsf_wiki_url.'Special:Userrights" name="uluser">';
            $html .= '<input name="title" type="hidden" value="Special:Userrights" />';
            
            $html.= '<input name="user" size="30" value="" id="username" />';
            $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form>';
		$html .= '</td></tr>';
        
        
         if(in_array('sysop', $wgUser->getGroups())){
            
            $html .= '<tr>';
            get_awcsforum_word('admin_forum_update') == '' ?  $up = 'Forum Up-date Installer' : $up = get_awcsforum_word('admin_forum_update');
            $html .= '<td width="15%" align="left" nowrap class="thread_rows0"><a href="'. awc_url . 'admin/forum_update">'.$up.'</a></td>';
            $html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; '.get_awcsforum_word('admin_forum_updatedesc').'</td>';
            $html .= '</tr><tr>';
         }
         
         if('autoupdate' == 'yes'){
           $html .= '<tr>';
           $up = '<a href="'. awc_url . 'admin/forum_autoupdate">'.get_awcsforum_word('admin_autoupdate') . ' ' . $ver .'</a>';

           $html .= '<td width="15%" align="left" nowrap class="thread_rows0">'.$up.'</td>';
           $html .= '<td width="85%" align="left" nowrap class="thread_rows1"> &nbsp; ' .get_awcsforum_word('admin_expearimental').'</td>';
           $html .= '</tr><tr>';

         }
        
		$html .= '</tr></table><br />';
        
        
        
	return $html ;
	}
    
    function forum_update(){
    
    
    
    
    }
	
	function Admin_AddCat($str, $info='', $drop='', $id='', $order='', $perm='', $title_is='', $body='', $info=null){
	global $wgTitle, $awc, $wgGroupPermissions;
		
		$html = '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
		$html .= '<td width="100%" nowrap >' . $info .'<hr></td></tr><tr><td>';
		$html .= '<form action="'. awc_url.'" method="post">';
		$html .= '<input name="action" type="hidden" value="admin">';
		$html .= '<input name="todo" type="hidden" value="'.$str.'">';
		$html .= '<input name="id" type="hidden" value="'.$id.'">';
		$html .= ''.get_awcsforum_word('word_title').': <input name="name" type="text" value="'.$title_is.'" size="50%"><br />';  
        
        if(what_page == 'add_forum' | what_page == 'editForum' ){
            $html .= '<br />'.get_awcsforum_word('word_top_forum_wiki_text').': <input name="f_top_tmplt" type="text" value="'.$info['f_top_tmplt'].'" size="50%"><br />';
            $html .= '<br />'.get_awcsforum_word('word_top_postingbox_wiki_text').': <input name="f_posting_mesage_tmpt" type="text" value="'.$info['f_posting_mesage_tmpt'].'" size="50%"><br /><br />';
        }
        $html .= $order ;
		# $html .= 'Order: <input name="order" type="text" value="'.$order.'" size"10"><br />';
		$html .= $drop ;
        

       $permE=null;
       $permM=null;
       $permMo=null;
       $permA=null;
        switch ($perm){
            case '-1';
                $permN = 'SELECTED';
                break;
                
            case '0';
                $permE = 'SELECTED';
                break;
                
            case '1';
                $permM = 'SELECTED';
                break;
                
            case '2';
                $permMo = 'SELECTED';
                break;
                
            case '10';
                $permA = 'SELECTED';
                break;
                
            default;
            $permE = 'SELECTED'; 
                
        }
		#$html .= '<br />Permisison: <input name="perm" type="text" value="'.$perm.'" size="5"> Everyone=<b>0</b> Members=<b>1</b> Mods=<b>2</b> Admin=<b>3</b> '; 
		$html .= '<br />'.get_awcsforum_word('admin_word_forum_perm').': <select name="perm">';
        $html .= "<option value='-1' $permN>".get_awcsforum_word('admin_word_noone')."</option>";
        $html .= "<option value='0' $permE>".get_awcsforum_word('admin_word_everyone')."</option>";
        $html .= "<option value='1' $permM>".get_awcsforum_word('admin_word_onlymem')."</option>";
        $html .= "<option value='2' $permMo>".get_awcsforum_word('admin_word_onlymodandadmin')."</option>";
        $html .= "<option value='10' $permA>".get_awcsforum_word('admin_word_onlyadmin')."</option>";
        $html .= '</select>';
        
        
        
        $html .= '<br />'.get_awcsforum_word('admin_word_wiki_perm').': <select name="wiki_perm">';
        foreach($wgGroupPermissions as $wiki_group => $bla){
            $html .= "<option value='$wiki_group' $permE>$wiki_group</option>";

        }
        #$html .= "<option value='0' $permE>".get_awcsforum_word('admin_word_everyone')."</option>";
        #$html .= "<option value='1' $permM>".get_awcsforum_word('admin_word_onlymem')."</option>";
        #$html .= "<option value='2' $permMo>".get_awcsforum_word('admin_word_onlymodandadmin')."</option>";
        #$html .= "<option value='10' $permA>".get_awcsforum_word('admin_word_onlyadmin')."</option>";
        $html .= '</select>';
        
        
        $html .= '<br /> <textarea name="desc" cols="50%" rows="10" wrap="virtual" class="post_box">'.$body.'</textarea>';
		$html .= '<br /><input type="submit" value="'.get_awcsforum_word('submit').'"></form>';
		
		$html .= '</td>';
		$html .= '</tr></table><br />';
	
	return $html ;
	}
	
	
	 function admin_GetConfig($todo){
     global $awc, $wgOut;
     
              # die($todo);
        $dbr = wfGetDB( DB_SLAVE );
		$table_1 = $dbr->tableName( 'awc_f_config' );
		$sql = "SELECT * FROM $table_1 WHERE section='$todo' ORDER BY q DESC ";
		$res = $dbr->query($sql);
        
        
        #$chr_selected = null;
        $cf_dropdown['cf_chrset'] = '<br />
                        <select name="cf_chrset">
                          <option value="iso-8859-1">ISO-8859-1 (Western European, Latin-1)</option>
                          <option value="iso-8859-2">ISO-8859-2 (Latin-2)</option>
                          <option value="iso-8859-15">ISO8859-15 (Western European, Latin-9. Adds the Euro sign, French and Finnish letters missing in Latin-1(ISO-8859-1).)</option>
                          <option value="UTF-8">UTF-8 (ASCII compatible multi-byte 8-bit Unicode.)</option>
                          <option value="cp866">cp866 (DOS-specific Cyrillic charset. This charset is supported in 4.3.2.)</option>
                          <option value="cp1251">cp1251 (Windows-specific Cyrillic charset. This charset is supported in 4.3.2.)</option>
                          <option value="cp1252">cp1252 (Windows specific charset for Western European.)</option>
                          <option value="KOI8-R">KOI8-R (Russian. This charset is supported in 4.3.2.)</option>
                          <option value="BIG5">BIG5 (Traditional Chinese, mainly used in Taiwan.)</option>
                          <option value="GB2312">GB2312 (Simplified Chinese, national standard character set.)</option>
                          <option value="BIG5-HKSCS">BIG5-HKSCS (Big5 with Hong Kong extensions, Traditional Chinese.)</option>
                          <option value="Shift_JIS">Shift_JIS (Japanese)</option>
                          <option value="EUC-JP">EUC-JP (Japanese)</option>
                        </select>';
        
        
        
        $html = '<form id="config" name="config " action="'.awc_url.'admin/config_forum" method="post">'; 
		$html .= '<table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
		$html .= '<td width="100%" class="dl_maintable_head" nowrap colspan="1"><br /></td>';
		$html .= '</tr><tr>';
        
        
        $help = get_awcsforum_word('word_help');
        
         while ($r = $dbr->fetchObject( $res )) {
         	
						    if($r->q != 'cf_forumversion' AND
                                 $r->q != 'cf_forumlang' AND
                                 $r->q != 'cf_css_active_ids' AND
                                 $r->q != 'cf_css_default'){
                                 	
                                 	#die($r->typeis);
				                
				                $html .= '<tr><td width="100%" align="left" nowrap>';  
				                
				                $out = get_awcsforum_word($r->q);
				                $out = str_replace('a href=', 'a target="blank" href=', $out);
				                
				                $html .= "(<a target='blank' href='http://wiki.anotherwebcom.com/$r->q (AdminCP Setting)'>$help</a>) " . $out;
				                
				                if($r->q == 'cf_chrset'){
				                    
				                    /*  Need to do something here wiht an array for furture dropdown menus  */
				                    $option_selected[$r->q] = '<option value="'.$r->a.'" SELECTED>';
				                    $html .= '<dropdown-placeholder_'.$r->q.'>';
												
				                } elseif($r->q == 'cf_css_default'){
				                    
				                    # css
				                    $css_id = unserialize($r->a);
				                    $html .= '<hr /><select name="cf_css_default">';
				                    $html .= self::css_getdropdown($css_id['Default']); #
				                    $html .= '</select>';
				                    
				                } elseif($r->typeis == 'yesno'){
				                    
				                    $html .= '<hr />' . awcsf_CheckYesNo($r->q, $r->a); 
				                    
				                } else {
				                    
				                    $html .= '<br /><input name="'.$r->q.'" type="text" value="'.$r->a.'" size="50"> '; 
				                    
				                }
				                
				                
				                
				                $html .= '<br /><br /></td></tr>'; 
				            }
        } 
        $dbr->freeResult( $res );       
		$html .= '</table>';
        $html .= ' <input type="submit" value="'.get_awcsforum_word('submit').'"></form>';
        
        if(isset($option_selected)){
            foreach($option_selected as $k => $v){
                
                    $option_selected_find_replace = str_replace(' SELECTED', '', $option_selected[$k]);
                    $selected = str_replace($option_selected_find_replace, $option_selected[$k], $cf_dropdown[$k]);
                    
                    $html = str_replace('<dropdown-placeholder_'.$k.'>', $selected, $html);
                    
            }
            unset($option_selected);
            unset($cf_dropdown);
        }
        
        /*  Funcky find and replace for chr-set SELECTED dropdown  */
        # $chr_find_replace = str_replace(' SELECTED', '', $chr_selected);
        #  $chr_selected = str_replace($chr_find_replace, $chr_selected, $cf_chrset_drop);
        # $html = str_replace('<chr-set-placeholder>', $chr_selected, $html);
        
        
        return $html;
        
         
     }
     
     
     
     function css_getdropdown($selected_css_id){
     
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_theme_names = $dbr->tableName( 'awc_f_theme_names' );
        $sql = "SELECT * FROM $awc_f_theme_names WHERE thmn_what='css'";
        
        $css = null;
        $res = $dbr->query($sql);
         
            while ($r = $dbr->fetchObject( $res )) {
                if($selected_css_id == $r->thmn_id){
                    $css .= '<option value="'. $r->thmn_id .'|'.$r->thmn_title.'" SELECTED>'. $r->thmn_title .'</option>';
                } else {
                    $css .= '<option value="'. $r->thmn_id .'|'.$r->thmn_title.'">'. $r->thmn_title .'</option>';
                }
            }
            
            return $css;
     
     }
     
     
     
    
    function Admin_DeleteCat($todo, $id, $info, $drop){
		
		$html = '<br /><table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
		$html .= '<td width="100%" nowrap >' . $info .'<hr></td></tr><tr><td>';
		$html .= '<form action="'. awc_url .'" method="post">';
		$html .= '<input name="action" type="hidden" value="admin">';
		$html .= '<input name="todo" type="hidden" value="'.$todo.'">';
		$html .= '<input name="id" type="hidden" value="'.$id.'">';
		$html .= $drop ;
		$html .= '<br /><input type="submit" value="'.get_awcsforum_word('delete').'"></form>'   ;
		$html .= '</td>';
		$html .= '</tr></table><br />';
	
	return $html ;
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    function cats_edit($info, $cID, $cCount, $delete_drop){
    global $wgGroupPermissions;
    
        # die(print_r($info));
        $delete_cat_list = null;
        
        unset($delete_drop[$cID]);
        foreach($delete_drop as $cList){
                $delete_cat_list .= $cList ;
        }
        
        $child = explode(',', $info[$cID]['kids']);
        $childs = null;
        $child_id = array();
        foreach($child as $tmp){
            $child_id = explode('|', $tmp);
            $childs .= " <a href='". awc_url."admin/editForum/id".$child_id[0]."'>".$child_id[1]."</a> | ";
        }
        $childs = substr($childs, 0, -2);
        
        $order = '<select name="cat_order">';
            for ($i=0; $i<=$cCount -1; $i++){
                if($i == $info[$cID]['cat_order']){
                    $order .= '<option value="'. $i .'" SELECTED>'. $i .'</option>';
                } else {
                    $order .= '<option value="'. $i .'">'. $i .'</option>';
                }
            }
         $order .= '</select>';
         
        $html = '<br /><table width="100%" class="dl_maintable" cellpadding="0" cellspacing="0"><tr>';
        $html .= '<td width="100%" nowrap >' . get_awcsforum_word('admin_word_edit_cat') .': '.$info[$cID]['cat_name'].'<hr></td></tr><tr><td>';
        $html .= '<form action="'. awc_url .'" method="post">';
        $html .= '<input name="action" type="hidden" value="admin">';
        $html .= '<input name="todo" type="hidden" value="cat_do_edit">';
        $html .= '<input name="cID" type="hidden" value="'.$cID.'">';
        
        $html .= get_awcsforum_word('word_title') . ' <input name="cat_name" type="text" value="'.$info[$cID]['cat_name'].'" size="50">  '; 
        
        $html .=  get_awcsforum_word('admin_word_order') . " $order <br />" ; 
        
        $html .= get_awcsforum_word('word_description') . '<br /><textarea name="cat_desc" cols="75%" rows="4" wrap="virtual" class="post_box">'.$info[$cID]['cat_desc'].'</textarea><br />';
        
        $html .=  "<br />". get_awcsforum_word('admin_word_read_perm') . "<hr />" ;
        
        $per = array('wiki_perm' => $info[$cID]['c_wiki_perm'],
                     'forum_perm' => $info[$cID]['cat_perm'],
                     'forum_what' => 'cat_perm',
                     'wiki_what' => 'c_wiki_perm',
                     ) ;           
             $html .= self::perm_list($per, $wgGroupPermissions);
        unset($per);
        
        $html .= '<hr />';
        $html .= '<br /><input type="submit" value="'.get_awcsforum_word('submit').'"></form><br /><hr />';
        

           
        if(count($delete_drop) > 0) $html .= self::cats_delete($info, $cID, $delete_cat_list); 
        
        
        $html .=  "<hr /><br />" . get_awcsforum_word('admin_word_child_forum') . "<br />" ;
        
        $html .= $childs;
        
        $html .= '</td>';
        $html .= '</tr></table><br />';
        
        
    
    return $html ;
    
    
    }
    
    function perm_list($info, $WikiGroups){
        
        
        
       $permE=null;
       $permM=null;
       $permMo=null;
       $permA=null;
         # $info[$cID]['c_canread']['forum_perm']
        switch ($info['forum_perm']){
            
            case '0';
                $permE = 'SELECTED';
                break;
                
            case '1';
                $permM = 'SELECTED';
                break;
                
            case '2';
                $permMo = 'SELECTED';
                break;
                
            case '10';
                $permA = 'SELECTED';
                break;
                
            default;
            $permE = 'SELECTED'; 
                
        }
        
        $html = '<table width="%100">';
        $html .= '<tr><td>';
         
        $html .= get_awcsforum_word('admin_word_forum_perm').': <select name="'.$info['forum_what'].'">';
        $html .= "<option value='0' $permE>".get_awcsforum_word('admin_word_everyone')."</option>";
        $html .= "<option value='1' $permM>".get_awcsforum_word('admin_word_onlymem')."</option>";
        $html .= "<option value='2' $permMo>".get_awcsforum_word('admin_word_onlymodandadmin')."</option>";
        $html .= "<option value='10' $permA>".get_awcsforum_word('admin_word_onlyadmin')."</option>";
        $html .= '</select>';
        
        $html .= '</td>';
        $html .= '<td>';
        
        $html .= get_awcsforum_word('admin_word_wiki_perm').': <select name="'.$info['wiki_what'].'">';
        foreach($WikiGroups as $wiki_group => $bla){
            
            if($wiki_group == $info['wiki_perm']){
                $html .= "<option value='$wiki_group' SELECTED>$wiki_group</option>";
            } else {
                $html .= "<option value='$wiki_group'>$wiki_group</option>";
            }

        }
        $html .= '</select>';
        
        $html .= '</td></tr>';
        $html .= '</table>';
        
        return $html;
        
    }
    
    
    function cats_delete($info, $cID, $drop){
        
        $html = '<table width="100%" cellpadding="0" cellspacing="0"><tr><td>';
        $html .= '<form action="'. awc_url .'" method="post">';
        $html .= '<input name="action" type="hidden" value="admin">';
        $html .= '<input name="todo" type="hidden" value="do_deleteCat">';
        $html .= '<input name="delete_catid" type="hidden" value="'.$cID.'"> ';
        
        $html .= get_awcsforum_word('admin_delete_cat') . ': <b>' . $info[$cID]['cat_name'] .  '</b> ';
        $html .= str_replace("|$|", get_awcsforum_word('admin_word_child_forum'), get_awcsforum_word('move_to')) . ' '  ;
        
        $html .= ' <select name="move_id">';
        $html .= $drop ;
        $html .= '</select">';
        $html .= '<br /><input type="submit" value="'.get_awcsforum_word('delete').'"></form>';
        $html .= '</td>';
        $html .= '</tr></table>';
    
    return $html ;
    }
    
    
    function css_editing_boxs($css_info, $css_id){
    
       # awc_pdie($css_info);
        #$html = '<input name="'.$att.'_ver" type="hidden" value="'.$ver.'">' ;
        
        if($css_info['att'][0] == "#" || $css_info['att'][0] == ".") {
            $link = substr($css_info['att'],1,strlen($css_info['att'])); 
        } else {
            $link = $css_info['att'];
        }
         
        $link = str_replace(array('}', '[', ']', '{',), '', $link);
        
        if($css_info['custom'] == 0){
            $html = "<a href='http://wiki.anotherwebcom.com/$link (Forum CSS)' target='_blank'>{$css_info['att']}</a> ".get_awcsforum_word('admin_edit_ver') . " {$css_info['ver']}<br />" ;
        } else {
            $html = $css_info['att'] ."  ".get_awcsforum_word('admin_edit_ver') . " {$css_info['ver']} <b>" .get_awcsforum_word('word_custom'). '</b><br />';
        }
        
        $code = htmlentities($css_info['code'], ENT_NOQUOTES);
        $html .= "<textarea name='css_code' cols='75' rows='5' wrap='virtual' class='post_box'>{$code}</textarea> <br />";
        $html .= '<input type="submit" value="'.get_awcsforum_word('word_edit').'"> <br /><br />';
        return $html;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	

}