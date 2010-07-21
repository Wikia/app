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
* @filepath /extensions/awc/forums/ajax.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();



global $wgAjaxExportList;
$wgAjaxExportList[] = 'awcforum_ajax::GetPMnames';


class awcforum_ajax{
    
    
    function GetPMnames($name){
    
    
    $limit = 8; //number of results to spit back

    $response = new AjaxResponse();
    $dbr = wfGetDB( DB_SLAVE );
    
    $sql = "SELECT m_idname FROM ". $dbr->tableName('awc_f_mems')." WHERE  UPPER(m_idname)  LIKE '%".$dbr->strencode( strtoupper ($name)). "%' ORDER BY m_idname LIMIT {$limit}";
            
    $res = $dbr->query($sql); 
     $r = "";   
    while ($row = $dbr->fetchObject( $res ) ){
        
        $r .= "<li><a href='javascript:void(0);' onclick=\"javascript:SetPMname('".$row->m_idname."')\">" . $row->m_idname . "</a></li>\n";
       // $r .=   "<a href='javascript:void(0);' onclick=\"javascript:SetPMname('".$row->m_idname."')\">" . $row->m_idname . "</a><br>";
 
    }
    $html ='<ul>' .$r .'</ul> <hr/>';
 
    return $html .'<hr/>';


}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}