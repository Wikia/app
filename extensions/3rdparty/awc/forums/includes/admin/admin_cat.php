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
* @filepath /extensions/awc/forums/admin/admin_cat.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
*  Categories 'todo' entry method
* @uses awcsf_admin_categories
* @uses Set_AWC_Forum_BreadCrumbs
* @uses get_awcsforum_word
* @since Version 2.5.8
*/ 
function awcsf_admin_categories_func(){
global $action_url, $wgRequest;

    $cid = $wgRequest->getVal( 'id' );

    $cat_cls = new awcsf_admin_categories();
    
    switch($action_url['todo']){
        
        case 'create_cat':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_create_new_cat'), true);
            $cat_cls->create_cat();
        break;
        
        case 'do_create_cat':
            $cat_cls->do_create_cat();
        break;
        
        
        case 'get_cat_list':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_word_edit_cat'), true);
            $cat_cls->get_cat_list();
        break;
        
        
        case 'get_cat_id_edit':
            Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('admin_word_edit_cat'), true);
            $cat_cls->cID = (strlen($cid) > 0) ? $cid : $action_url[2];
            $cat_cls->get_cat_id_edit();
        break;
        
        
        case 'edit_cat_do':
            $cat_cls->edit_cat_do();
        break;
        
        case 'delete_cat':
            $cat_cls->delete_cat();
        break;
    
    
    }



}

/**
*  Admin:: Working with categories
* @since Version 2.5.8
*/ 
class awcsf_admin_categories extends awcforum_forumAdmin{

/**#@+
* @since Version 2.5.8
*/ 
    /**
    * Cat ID
    * @var string
    */
    var $cID;
    /**
    * Hold Cat's info
    * @var array
    */
    private $cat_info = array();
    /**
    * Hold Wiki Groups info
    * @var array
    */
    private $wiki_groups = array();
/**#@-*/ 

    function __construct() {
        
        
    }
    
    
    /**
    *  Categories edit, new form
    * 
    * Form is used for creating New Cats and also 8sed for Editing Cats
    * @parameter array $info (holds info abouve the Cat and injects into form)
    * @uses get_awcsforum_word
    * @return string
    * @since Version 2.5.8
    */ 
    function skin_form($info){
        
        $out = '<form action="'. awc_url .'admin/cat/'.$info['todo'].'" method="post">';
        $out .= '<input name="cID" type="hidden" value="'.$info['cID'].'">';
        $out .= '<table width="100%" class="dl_maintable" cellpadding="3" cellspacing="3">';
        $out .= '<tr><td>';
        
        if(!empty($info['cID'])) $out .= ' - <a target="blank" href="'.awc_url.'sc/id'.$info['cID'].'">'.$info['cat_name'].'</a> - <hr />';
        
        $out .= get_awcsforum_word('word_title') . ' <input name="cat_name" type="text" value="'.$info['cat_name'].'" size="50"> '; 
        $out .=  get_awcsforum_word('admin_word_order') . ' ' . $info['cat_order'] .' <br /><br />' ;
        
        $out .= get_awcsforum_word('word_description') . '<br /><textarea name="cat_desc" cols="75%" rows="3" wrap="virtual" class="post_box">'.$info['cat_desc'].'</textarea><br />';
        
        $out .=  '<br /> (<a target="blank" href="http://wiki.anotherwebcom.com/Read Permissions (Admin Settings)">'.get_awcsforum_word('word_help').'</a>) ' ;
        $out .=  get_awcsforum_word('admin_word_read_perm') . "<hr />" ;
        
        $out .= $info['c_wiki_perm'];
        
        $out .= ' <input type="submit" value="'.get_awcsforum_word('submit').'">';
        
        $out .= '</td></tr>';
        $out .= '</table></form>';
        
        if(isset($info['move_to_drop'])) $out .= $info['move_to_drop'];
        
        return $out;
    }
    
    /**
    *  Categories delete form
    * 
    * Displays drop down to move Forums to along with Delete button
    * @parameter string $cID (Cat ID, used so not to display current Cat in "move to" drop down)
    * @parameter string $cName (Current Cat name used for display)
    * @uses get_awcsforum_word
    * @return string
    * @since Version 2.5.8
    */ 
    function delete_forum($cID, $cName){
        
        
        $out = '<form onsubmit="return delete_form_check(\''.get_awcsforum_word('admin_delete_cat').' ?\')";" action="'. awc_url .'admin/cat/delete_cat" method="post">';
        $out .= '<input name="cID" type="hidden" value="'.$cID.'">';
        
        $out .= get_awcsforum_word('admin_delete_cat') . ' ( <b>' . $cName . '</b> )<br />' ;
        $out .= get_awcsforum_word('admin_move_forums_to') . ' '  ;
        
        $out .= '<select name="move_to">';
        
        foreach($this->cat_info as $id => $info){
            
            if($cID != $id){
                $out .= '<option value="'.$id.'"> '.$info['cat_name'].'</option>';
            }
            
        }
        
        $out .= '</select>';
        $out .= ' <input type="submit" value="'.get_awcsforum_word('delete').'">';
        $out .= '</form><hr />';
        return $out;
    }
    
    /**
    *  Put togeather cat Edit form
    * 
    * @parameter array $info (Holds Cat info)
    * @uses wikigroup_get_checkboxs
    * @uses order_by
    * @uses delete_forum
    * @uses skin_form
    * @return string
    * @since Version 2.5.8
    */ 
    function get_cat_to_edit($info){
        
        $skin['todo'] = "edit_cat_do";
        $skin['cat_name'] = $info['cat_name'];
        $skin['cat_desc'] = $info['cat_desc'];
        $skin['cID'] = $info['cat_id'];
        $skin['c_wiki_perm'] = parent::wikigroup_get_checkboxs('c_wiki_perm',$info['c_wiki_perm']);
        $skin['cat_order'] = self::order_by($info['cat_order']);
        $skin['move_to_drop'] = self::delete_forum($info['cat_id'], $info['cat_name']);
        
        return $this->skin_form($skin) . '<br /><br />';
    }
    
    /**
    *  Order by drop down option
    * 
    * @parameter boolean $select 
    * @return string
    * @since Version 2.5.8
    */     
    function order_by($select = null){
        
        $out = '<select name="cat_order">';
        $count_to = ($select == null) ? count($this->cat_info) + 1 : count($this->cat_info);
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
    
    /**
    *  Set class var array 'cat_info'
    * 
    * @uses cats_get_all_array
    * @since Version 2.5.8
    */
    function get_all_cats(){
        $this->cat_info = parent::cats_get_all_array();
    }
 
 
    /**
    *  Put togeather New cat  form
    * 
    * @uses get_all_cats
    * @uses wikigroup_get_checkboxs
    * @uses order_by
    * @uses skin_form
    * @since Version 2.5.8
    */
    function create_cat(){
    global $wgOut;
    
        self::get_all_cats(); // use to get number of current cats to create the 'cat_order' drop-down
        
        $skin = array();
        $skin['todo'] = "do_create_cat";
        $skin['cat_name'] = null;
        $skin['cat_desc'] = null;
        $skin['cID'] = null;
        $skin['c_wiki_perm'] = parent::wikigroup_get_checkboxs('c_wiki_perm');
        $skin['cat_order'] = self::order_by();
   
        $wgOut->addHTML($this->skin_form($skin));
    }
     
     
    /**
    *  Save newly created cat
    * 
    * @uses awcf_redirect
    * @since Version 2.5.8
    */
    function do_create_cat(){
    global $wgRequest;
    
        $cat_name = $wgRequest->getVal( 'cat_name' );
        $cat_desc = $wgRequest->getVal( 'cat_desc' );
        $cat_perm = $wgRequest->getVal( 'cat_perm' );
        $c_wiki_perm = parent::wikigroup_check_for_save('c_wiki_perm');
        $cat_order = $wgRequest->getVal( 'cat_order' );
        
        if($c_wiki_perm == 'Blank_Wiki_Group_Error') return  awcs_forum_error('admin_need_wiki_group');
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->insert( 'awc_f_cats', array(
            'cat_name'        => $cat_name,
            'cat_desc'           => $cat_desc,
            'cat_order'           => $cat_order,
            'c_wiki_perm'           => $c_wiki_perm,
        ) );
        
        
        $info['msg'] = 'cat_created';
        $info['url'] = awc_url . 'admin';
       return awcf_redirect($info);
        
    }
    
    /**
    *  List off Cat's
    * 
    * @uses get_cat_to_edit
    * @uses get_all_cats
    * @since Version 2.5.8
    */
    function get_cat_list(){
    global $wgOut;
        
       // $this->wiki_groups = parent::get_wiki_groups();
        self::get_all_cats(); // use to get number of current cats to create the 'cat_order' drop-down
            
        $skin = array();
        $out = null;
        
        foreach($this->cat_info as $cID => $info){
                $out .= self::get_cat_to_edit($info) ;
        }
       $wgOut->addHTML($out);
        
    }
    
    /**
    *  Get single Cat to edit
    * 
    * @uses get_cat_to_edit
    * @uses get_all_cats
    * @since Version 2.5.8
    */
    function get_cat_id_edit(){
    global $wgOut;
    
        self::get_all_cats(); // use to get number of current cats to create the 'cat_order' drop-down
        
        $out = self::get_cat_to_edit($this->cat_info[$this->cID]);
        $wgOut->addHTML($out);
        
    }
    
    /**
    *  Save Cat edit
    * 
    * @uses wikigroup_check_for_save
    * @uses awcf_redirect
    * @since Version 2.5.8
    */
    function edit_cat_do(){
    global $wgRequest;
        
        
        $cat_name = $wgRequest->getVal( 'cat_name' );
        $cat_desc = $wgRequest->getVal( 'cat_desc' );
        $c_wiki_perm = parent::wikigroup_check_for_save('c_wiki_perm');
        $cat_order = $wgRequest->getVal( 'cat_order' );
        $cID = $wgRequest->getVal( 'cID' );
        
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_cats', array(
            'cat_name'        => $cat_name,
            'cat_desc'           => $cat_desc,
            'cat_order'           => $cat_order,
            'c_wiki_perm'           => $c_wiki_perm, ), 
            array( 'cat_id' => $cID ), '' );
        

        
        $info['msg'] = 'cat_edited';
        $info['url'] = awc_url . 'admin/cat/get_cat_id_edit/' . $cID;
       return awcf_redirect($info);
    }
    
    
    /**
    *  Delete Cat
    * 
    * @uses get_all_cats
    * @uses awcf_redirect
    * @since Version 2.5.8
    */
    function delete_cat(){
    global $wgRequest;
        
        self::get_all_cats();
    
        $current_id = $cid = $wgRequest->getVal( 'cID' );
        $move_to_id = $cid = $wgRequest->getVal( 'move_to' );
        
        if(strlen($current_id) == 0){
            return  awcs_forum_error('admin_no_cat_to_delete');
        }
        
        if(strlen($move_to_id) == 0){
            return  awcs_forum_error('admin_no_forum_to_move_to');
        }
        
        if($current_id == $move_to_id){
            return  awcs_forum_error('admin_deletemovethesamecat');
        }
        
        if(empty($this->cat_info[$move_to_id])){
            return  awcs_forum_error('admin_no_forum_to_move_to');
        }
        
        if(empty($this->cat_info[$current_id])){
            return  awcs_forum_error('admin_no_cat_to_delete');
        }
        
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'awc_f_forums', array(
                        'f_parentid'        => $move_to_id, ), 
                        array( 'f_parentid' => $current_id ), '' );
                        
        $dbw->delete( 'awc_f_cats', array( 'cat_id' => $current_id ), '');
         
                        
        $info['msg'] = 'cat_was_deleted';
        $info['url'] = awc_url . 'sc/id' . $move_to_id;
        return awcf_redirect($info);
        
    
    }








}