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
* @filepath /extensions/awc/forums/admin/admin_memtitle.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();


function awcsf_admin_membertitle_func(){
global $action_url, $wgRequest;

    $mem_cls = new awcsf_admin_membertitle();
    Set_AWC_Forum_BreadCrumbs(get_awcsforum_word('cf_display_mem_titles'), true);
    switch($action_url['todo']){
        
        case 'insert_new':
            
            $mem_cls->insert_new();
        break;
        
        case 'get_all':
            $mem_cls->get_all();
        break;
        
        case 'saveEdit':
            $mem_cls->saveEdit();
        break;
    
    }



}

class awcsf_admin_membertitle extends awcforum_forumAdmin{

    var $mtID;
    
    function __construct() {
        
        
    }
    
    function insert_new($title, $pCount, $img = "", $css = ""){
    
        $dbr = wfGetDB( DB_SLAVE );
        $r = $dbr->selectRow( 'awc_f_member_titles', 
                    array( 'memtitle_id' ), 
                    array( 'memtitle_title' => $title ) );
         
         if(!isset($r->memtitle_id)){                                   
        
            $dbw = wfGetDB( DB_MASTER );
                $dbw->insert( 'awc_f_member_titles', array(
                        'memtitle_title'        => $title,
                        'memtitle_postcount'    => $pCount,
                        'memtitle_img'          => $img,
                        'memtitle_css'          => $css,
                    ) );
                
         }
                
    }
    
    
    
    function get_all(){
    global $wgOut;
    
        $dbr = wfGetDB( DB_SLAVE );
        $awc_f_member_titles = $dbr->tableName( 'awc_f_member_titles' );
        
        $sql = "SELECT * FROM $awc_f_member_titles ";
        $res = $dbr->query($sql);
        
        while ($r = $dbr->fetchObject( $res )) {
        	$memtitles .= get_awcsforum_word('cf_display_mem_title') .' <input name="'.$r->memtitle_id.'" type="text" value="'.$r->memtitle_title.'"> '. get_awcsforum_word('cf_display_mem_count') .' <input name="'.$r->memtitle_id.'_count" type="text" value="'.$r->memtitle_postcount.'"> '. get_awcsforum_word('cf_display_mem_img') .' <input name="'.$r->memtitle_id.'_img" type="text" value="'.$r->memtitle_img.'"> '. get_awcsforum_word('cf_display_mem_css') .' <input name="'.$r->memtitle_id.'_css" type="text" value="'.$r->memtitle_css.'"><br />' ; 
        }
        
        $html .= '<form action="'.awc_url.'admin/mem_title/saveEdit/" method="post">';
        $html .= $memtitles;
        $html .= ' <br /><input type="submit" value="'.get_awcsforum_word('edit').'">';
        $html .= '</form><br />';
        
        
        $wgOut->addHTML($html);
        
        #return $memtitles;
    
    }
    
    
    
    function saveEdit(){
    global $wgRequest, $wgOut;
    
    	$dbw = wfGetDB( DB_MASTER );
    	$dbr = wfGetDB( DB_SLAVE );
        $awc_f_member_titles = $dbr->tableName( 'awc_f_member_titles' );
        
        $sql = "SELECT * FROM $awc_f_member_titles ";
        $res = $dbr->query($sql);
        
        
        while ($r = $dbr->fetchObject( $res )) {
        	
							$dbw->update( 'awc_f_member_titles',
                                    array( 
                                            'memtitle_title'   		=> $wgRequest->getVal( $r->memtitle_id ),
                                            'memtitle_postcount'    => $wgRequest->getVal( $r->memtitle_id .'_count' ),
                                    		'memtitle_img'    		=> $wgRequest->getVal( $r->memtitle_id .'_img' ),
                                    		'memtitle_css'   		=> $wgRequest->getVal( $r->memtitle_id .'_css' ),
                                            ), 
                                    array( 
                                            'memtitle_id' => $r->memtitle_id
                                    ), ''
                                
                                );
        }
        
        $wgOut->redirect( awc_url . "admin" );
    
    }



}
