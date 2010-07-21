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
* @filepath /extensions/awc/forums/admin/admin_forum.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();



// delete check...

function awcsf_admin_forum_func(){
global $action_url, $wgRequest;

    $fid = $wgRequest->getVal( 'id' );
    
    $forum_cls = new awcsf_admin_forum();
    
    switch($action_url['todo']){
        
        case 'create_forum':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_create_new_forum'), true);
            $forum_cls->create_forum();
        break;
        
        case 'do_create_forum':
            $forum_cls->do_create_forum();
        break;
        
        
        case 'get_forum_list':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_edit_forum'), true);
            $forum_cls->get_forum_list();
        break;
        
        case 'get_forum_id_edit':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_edit_forum'), true);
            $forum_cls->fID = (strlen($fid) > 0) ? $fid : $action_url[2];
            $forum_cls->get_forum_id_edit();
        break;
        
        case 'edit_forum_do':
            $forum_cls->edit_forum_do();
        break;
        
        case 'delete_forum':
            $forum_cls->delete_forum();
        break;
    
    
    }



}

class awcsf_admin_forum extends awcforum_forumAdmin{

    var $fID, $fName;
    
    private $forum_info = array();
    private $cat_info = array();
    
    function __construct() {
        
        
    }
    
    function skin_form($info){
        
        $out = '<form action="'. awc_url .'admin/forum/'.$info['todo'].'" method="post">';
        $out .= '<input name="f_id" type="hidden" value="'.$info['f_id'].'">';
        $out .= '<table width="100%" class="dl_maintable" cellpadding="3" cellspacing="3">';
        $out .= '<tr><td>';
        
        $out .= get_awcsforum_word('word_title') . ' <input name="f_name" type="text" value="'.$info['f_name'].'" size="50"> '; 
        
        $out .=  get_awcsforum_word('admin_parent_cat') . ' ' . $info['f_parentid'] .' ' ;
        
        $out .=  get_awcsforum_word('admin_word_order') . ' ' . $info['f_order'] . ' ' ;
        
        
        $out .=  '<br /><br />' ;
        
        $out .= get_awcsforum_word('word_description') . '<br /><textarea name="f_desc" cols="75%" rows="3" wrap="virtual" class="post_box">'.$info['f_desc'].'</textarea>';
        
        $out .=  '<br /><br /><hr />' ;
        $out .= get_awcsforum_word('admin_f_passworded') . ' ' . $info['f_passworded'] . '<br />';
        $out .= get_awcsforum_word('admin_f_password') . ' <input name="f_password" type="text" value="'.$info['f_password'].'" size="20"><br />';
        
        $out .=  '<hr /><br /><hr />' ;
        
        $out .=  '(<a target="blank" href="http://wiki.anotherwebcom.com/Top Forum Template (Admin Settings)">'.get_awcsforum_word('word_help').'</a>) ' ;
        $out .= get_awcsforum_word('word_top_forum_wiki_text') . '<br />' ;
        $out .=  '<input name="f_top_tmplt" type="text" value="'.$info['f_top_tmplt'].'" size="50">' ;
        $out .=  '<br />' ;
        
        $out .=  '(<a target="blank" href="http://wiki.anotherwebcom.com/Top Posting Box Template (Admin Settings)">'.get_awcsforum_word('word_help').'</a>) ' ;
        $out .= get_awcsforum_word('word_top_postingbox_wiki_text') . '<br />' ;
        $out .=  '<input name="f_posting_mesage_tmpt" type="text" value="'.$info['f_posting_mesage_tmpt'].'" size="50">' ;
        $out .=  '<br />' ;
        
        $out .=  '<hr />' ;
        
        $out .= '<table width="99%" cellpadding="3" cellspacing="3"><tr><td>';
        
        
        $out .=  '<br /> (<a target="blank" href="http://wiki.anotherwebcom.com/Read Permissions (Admin Settings)">'.get_awcsforum_word('word_help').'</a>) ' ;
        $out .=  get_awcsforum_word('admin_word_read_perm') . "<hr />" ;
        $out .= ' ';
        $out .= $info['f_wiki_read_perm'];
        
        $out .= '</td><td>';
        
        $out .=  '<br /> (<a target="blank" href="http://wiki.anotherwebcom.com/Write Permissions (Admin Settings)">'.get_awcsforum_word('word_help').'</a>) ' ;
        $out .=  get_awcsforum_word('admin_word_write_perm') . "<hr />" ;
        $out .= ' ';
        $out .= $info['f_wiki_write_perm'];
        
        $out .= '</td></tr></table>';
        
        $out .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
        
        $out .= '</td></tr>';
        $out .= '</table></form>';
        
        if(isset($info['move_to_drop'])) $out .= $info['move_to_drop'];
        
        return $out;
    }
    
    function delete_form($fID, $fName){
        
        $out = '<form onsubmit="return delete_form_check(\''.get_awcsforum_word('admin_delete_forum').' ?\')";"  action="'. awc_url .'admin/forum/delete_forum" method="post">';
        $out .= '<input name="fID" type="hidden" value="'.$fID.'">';
        
        $out .= get_awcsforum_word('admin_delete_forum') . ' ( <b>' . $fName . '</b> )<br />' ;
        $out .= get_awcsforum_word('admin_move_threads_to') . ' '  ;
        
        $out .= '<select name="move_to">';
        
        foreach($this->forum_info as $id => $info){
            
            if($fID != $id){
                $out .= '<option value="'.$id.'"> '.$info['f_name'].'</option>';
            }
            
        }
        
        $out .= '</select>';
        $out .= ' <input type="submit" value="'.get_awcsforum_word('delete').'">';
        $out .= '</form><hr />';
        return $out;
    }
    
    function get_all_cats(){
        $this->cat_info = parent::cats_get_all_array();
    }
    
    function cat_drop($parent_id = null){
        
        $out = '<select name="parent_id">';
        
        foreach($this->cat_info as $id => $info){
            
            if($parent_id != null AND $parent_id == $info['cat_id']){
                $out .= '<option value="'.$info['cat_id'].'" SELECTED> '.$info['cat_name'].'</option>';
            } else {
                $out .= '<option value="'.$info['cat_id'].'"> '.$info['cat_name'].'</option>';
            }
            
        }
        
        $out .= '</select>';
        
        return $out;
    }
    
    function get_forum_to_edit($info){
        
            self::get_all_cats();
                
            $skin['todo'] = "edit_forum_do";
            $skin['f_id'] = $info['f_id'];
            
            $skin['f_name'] = $info['f_name'];
            $skin['f_desc'] = $info['f_desc'];
            
            
            $skin['f_passworded'] = awcsf_CheckYesNo('f_passworded', $info['f_passworded']);
            $skin['f_password'] = awcsf_decode_password($info['f_password']);
            
            $skin['f_top_tmplt'] = $info['f_top_tmplt'];
            $skin['f_posting_mesage_tmpt'] = $info['f_posting_mesage_tmpt'];
            
            
            $skin['f_parentid'] = self::cat_drop($info['f_parentid']);
           // $skin['f_desc'] = $info['f_desc'];
           // $skin['cat_desc'] = $info['cat_desc'];
            $skin['f_wiki_read_perm'] = parent::wikigroup_get_checkboxs('f_wiki_read_perm', $info['f_wiki_read_perm']);
            $skin['f_wiki_write_perm'] = parent::wikigroup_get_checkboxs('f_wiki_write_perm', $info['f_wiki_write_perm']);
            $skin['f_order'] = self::order_by($info['f_order']);
            $skin['move_to_drop'] = self::delete_form($info['f_id'], $info['f_name']);
            
            
            
            return $this->skin_form($skin) . '<br /><br />';
    }
    
    function order_by($select = null){
        
        $out = '<select name="f_order">';
        $count_to = ($select == null) ? count($this->forum_info) + 1 : count($this->forum_info);
        for ($i=1; $i<=$count_to; $i++){
            
            if($i == $select){
                $out .= "<option value='$i' SELECTED>$i</option>";
            } else {
                $out .= "<option value='$i' >$i</option>";
            }
            
        }
        
        $out .= '</select>';
        
        
        return $out;
    }
    
    function get_all_forums(){
        $this->forum_info = parent::forums_get_all_array();
    }
 
    function create_forum(){
    global $wgOut;
    
        self::get_all_cats();
        
        $this->forum_info = parent::forums_get_all_array(); // use to get number of current cats to create the 'cat_order' drop-down
        
        $skin = array();
        $skin['todo'] = "do_create_forum";
        
        $skin['f_id'] = null;
        
        $skin['f_name'] = null;
        $skin['f_desc'] = null;
        
        $skin['f_passworded'] = awcsf_CheckYesNo('f_passworded', '0');
        $skin['f_password'] = null;
        
        $skin['f_top_tmplt'] = null;
        $skin['f_posting_mesage_tmpt'] = null;
            
        $skin['f_parentid'] = self::cat_drop();
        
        $skin['f_wiki_read_perm'] = parent::wikigroup_get_checkboxs('f_wiki_read_perm');
        $skin['f_wiki_write_perm'] = parent::wikigroup_get_checkboxs('f_wiki_write_perm');
        $skin['f_order'] = self::order_by();
        $skin['move_to_drop'] = null;

        $wgOut->addHTML($this->skin_form($skin));
    }
    
    function do_create_forum(){
    global $wgRequest;
    
        $f_name = $wgRequest->getVal( 'f_name' );
        $f_desc = $wgRequest->getVal( 'f_desc' );
        $parent_id = $wgRequest->getVal( 'parent_id' );
        $f_wiki_read_perm = parent::wikigroup_check_for_save('f_wiki_read_perm');
        $f_wiki_write_perm = parent::wikigroup_check_for_save('f_wiki_write_perm');
        $f_order = $wgRequest->getVal( 'f_order' );
        $f_passworded = $wgRequest->getVal( 'f_passworded' ); 
        $f_password = awcsf_encode_password($wgRequest->getVal( 'f_password' ));
        $f_top_tmplt = $wgRequest->getVal( 'f_top_tmplt' );
        $f_posting_mesage_tmpt = $wgRequest->getVal( 'f_posting_mesage_tmpt' );
        
        if(strlen($f_desc) == 0) $f_desc = ' ';
        if(strlen($f_name) == 0) $f_name = 'Forum Name ???';
        
        if(strlen($f_top_tmplt) == 0) $f_top_tmplt = ' ';
        if(strlen($f_posting_mesage_tmpt) == 0) $f_posting_mesage_tmpt = ' ';
        
        $dbw = wfGetDB( DB_MASTER );
        
        $dbw->insert( 'awc_f_forums', array(
                            'f_name'        => $f_name,
                            'f_desc'           => $f_desc,
                            'f_parentid'           => $parent_id,
                            'f_wiki_read_perm'           => $f_wiki_read_perm,
                            'f_wiki_write_perm'           => $f_wiki_write_perm,
                            'f_order'           => $f_order,
                            'f_passworded'           => $f_passworded,
                            'f_password'           => $f_password,
                            'f_top_tmplt'           => $f_top_tmplt,
                            'f_posting_mesage_tmpt'           => $f_posting_mesage_tmpt,
                            'f_threads'           => 0,
                            'f_replies'           => 0,
                            'f_lastdate'           => $dbw->timestamp(),
                            'f_lastuser'           => ' ',
                            'f_lastuserid'           => 0,
                            'f_lasttitle'           => ' ',
                            'f_threadid'           => 0,
                            'f_perm'           => 0,));
                            
                            
        
        $info['msg'] = 'forum_created';
        $info['url'] = awc_url . 'sc/id' . $parent_id;
       return awcf_redirect($info);
        
    }
    
    function get_forum_list(){
    global $wgOut;
        
        self::get_all_forums(); // use to get number of current cats to create the 'cat_order' drop-down
        
        $out = null;
        
        foreach($this->forum_info as $fID => $info){
                $out .= self::get_forum_to_edit($info) ;
        }
       $wgOut->addHTML($out);
        
    }
    
    function get_forum_id_edit(){
    global $wgOut;
        
        self::get_all_forums(); // use to get number of current cats to create the 'cat_order' drop-down
        
        $out = self::get_forum_to_edit($this->forum_info[$this->fID]);
        $wgOut->addHTML($out);
        
    }
    
    function edit_forum_do(){
    global $wgRequest;
        
        
        $f_name = $wgRequest->getVal( 'f_name' );
        $f_desc = $wgRequest->getVal( 'f_desc' );
        $parent_id = $wgRequest->getVal( 'parent_id' );
        $f_wiki_read_perm = parent::wikigroup_check_for_save('f_wiki_read_perm');
        $f_wiki_write_perm = parent::wikigroup_check_for_save('f_wiki_write_perm');
        $f_order = $wgRequest->getVal( 'f_order' );
        $f_passworded = $wgRequest->getVal( 'f_passworded' ); 
        $f_password = awcsf_encode_password($wgRequest->getVal( 'f_password' ));
        $f_top_tmplt = $wgRequest->getVal( 'f_top_tmplt' );
        $f_posting_mesage_tmpt = $wgRequest->getVal( 'f_posting_mesage_tmpt' );
        
        $f_id = $wgRequest->getVal( 'f_id' );
        
        if(strlen($f_desc) == 0) $f_desc = ' ';
        if(strlen($f_name) == 0) $f_name = 'Forum Name ???';
        
        if(strlen($f_top_tmplt) == 0) $f_top_tmplt = ' ';
        if(strlen($f_posting_mesage_tmpt) == 0) $f_posting_mesage_tmpt = ' ';
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_forums', array(
            'f_name'                => $f_name,
            'f_desc'                => $f_desc,
            'f_parentid'             => $parent_id,
            'f_wiki_read_perm'      => $f_wiki_read_perm,
            'f_wiki_write_perm'     => $f_wiki_write_perm,
            'f_order'               => $f_order,
            'f_passworded'          => $f_passworded,
            'f_password'            => $f_password,
            'f_top_tmplt'           => $f_top_tmplt,
            'f_posting_mesage_tmpt'           => $f_posting_mesage_tmpt,), 
            array( 'f_id' => $f_id ), '' );
        

        
        $info['msg'] = 'forum_edited';
        $info['url'] = awc_url . 'sc/id' . $parent_id;
       return awcf_redirect($info);
    }

    function delete_forum(){
    global $wgRequest;
        
        self::get_all_forums();
    
        $current_id = $cid = $wgRequest->getVal( 'fID' );
        $move_to_id = $cid = $wgRequest->getVal( 'move_to' );
        
        if(strlen($current_id) == 0){
            return  awcs_forum_error('admin_no_forum_to_delete');
        }
        
        if(strlen($move_to_id) == 0){
            return  awcs_forum_error('admin_no_forum_to_move_to');
        }
        
        if($current_id == $move_to_id){
            return  awcs_forum_error('admin_deletemovethesameforum');
        }
        
        if(empty($this->forum_info[$move_to_id])){
            return  awcs_forum_error('admin_no_forum_to_move_to');
        }
        
        if(empty($this->forum_info[$current_id])){
            return  awcs_forum_error('admin_no_forum_to_delete');
        }
        
        $t_count = 0;
        $p_count = 0;
        
        foreach($this->forum_info as $id => $info){
            if($id == $current_id OR $id == $move_to_id ){
                $t_count = $t_count + $info['f_threads'];
                $p_count = $p_count + $info['f_replies'];
            }
        }
        
        $dbw = wfGetDB( DB_MASTER );
        
        $dbw->update( 'awc_f_forums', array(
                        'f_threads'        => $t_count,
                        'f_replies'        => $p_count, ), 
                        array( 'f_id' => $move_to_id ), '' );
                        
                        
        $dbw->update( 'awc_f_threads', array(
                        't_forumid'        => $move_to_id, ), 
                        array( 't_forumid' => $current_id ), '' );               
                        
        require_once(awc_dir . 'includes/mod_post.php');
        awcs_forum_mod_post::update_forum_last_thread($move_to_id);
            
        $dbw->delete( 'awc_f_forums', array( 'f_id' => $current_id ), '');
         
                        
        $info['msg'] = 'forum_was_deleted';
        $info['url'] = awc_url . 'sf/id' . $move_to_id;
        return awcf_redirect($info);
        
    
    }


}