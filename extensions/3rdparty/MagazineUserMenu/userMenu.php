<?php
$wgExtensionFunctions[] = 'wfSpecialUserMenu';


function wfSpecialUserMenu(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class UserMenu extends UnlistedSpecialPage {

  function UserMenu(){
    UnlistedSpecialPage::UnlistedSpecialPage("UserMenu");
  }

  function execute(){
global $wgUser, $wgOut;
$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/MagazineUserMenu/userMenu.js\"></script>\n");

$dbr =& wfGetDB( DB_SLAVE );
  $sql = "SELECT user_menuitems FROM user_menu WHERE user_id = " . $wgUser->mId;
  $res = $dbr->query($sql);
  while ($row = $dbr->fetchObject( $res ) ) {
  	$MenuItems = $row->user_menuitems;
  }
  if(!$MenuItems)$MenuItems = "MLB|NFL|NBA|NHL|College|Soccer|Other";
  $MenuArray = explode ("|",$MenuItems);
  
  $output = '<form name="sports">';
  $output .= '<table cellpadding=0 cellspacing=0 border=0 width=600>';
  $output .= '<tr>';
  $output .= '<td colspan="4">';
  $output .= '<table border=0 cellpadding=0 cellspacing=0 width=600>';
  $output .= '<tr>';
  $output .= '<td width=28><img src="../images/arrowmain.gif"></td>';
  $output .= '<td width=572 class=title>select sport</td>';
  $output .= '</tr>';
  $output .= '<tr>';
  $output .= '<td width=600 colspan=2 class=subtitle>to add a sport to the top green menu check a box, to remove a sport uncheck a box</td>';
  $output .= '</tr>';
  $output .= '</table>';
  $output .= '</td>';
  $output .= '</tr>';
  $output .= '<tr>';
  $output .= '<td width=100><input type="checkbox" id="MLB" onclick="clickButton(\'MLB\');"';
  if (in_array("MLB", $MenuArray)) { $output .=  " checked ";}$output .= '>MLB</td>
<td width=100><input type="checkbox" id="NFL" onclick="clickButton(\'NFL\');"';
  if (in_array("NFL", $MenuArray)) { $output .=  " checked ";}$output .= '>NFL</td>
<td width=100><input type="checkbox" id="NBA" onclick="clickButton(\'NBA\');"';
  if (in_array("NBA", $MenuArray)) { $output .=  " checked ";}$output .= '>NBA</td>
<td width=100><input type="checkbox" id="NHL" onclick="clickButton(\'NHL\');"';
  if (in_array("NHL", $MenuArray)) { $output .=  " checked ";}$output .= '>NHL</td>
</tr>
<tr>
<td width=100><input type="checkbox" id="CFB" onclick="clickButton(\'CFB\');"';
if (in_array("CFB", $MenuArray)) { $output .= " checked ";} $output .= '>CFB</td>
<td width=100><input type="checkbox" id="CBB" onclick="clickButton(\'CBB\');"';
if (in_array("CBB", $MenuArray)) { $output .= " checked ";} $output .= '>CBB</td>
<td width=100><input type="checkbox" id="Soccer" onclick="clickButton(\'Soccer\');"';
if(in_array("Soccer", $MenuArray)) { $output .=  " checked ";}$output .= '>Soccer</td>
<td width=100><input type="checkbox" id="Nascar" onclick="clickButton(\'Nascar\');"';
if(in_array("Nascar", $MenuArray)) { $output .=  " checked ";}$output .= '>NASCAR</td>
</tr>
<tr>
<td width=100><input type="checkbox" id="Cricket" onclick="clickButton(\'Cricket\');"';
if(in_array("Cricket", $MenuArray)) { $output .=  " checked ";}$output .= '>Cricket</td>
<td width=100><input type="checkbox" id="Golf" onclick="clickButton(\'Golf\');"';
if(in_array("Golf", $MenuArray)) { $output .=  " checked ";}$output .= '>Golf</td>
<td width=100><input type="checkbox" id="Tennis" onclick="clickButton(\'Tennis\');"';
if(in_array("Tennis", $MenuArray)) { $output .=  " checked ";}$output .= '>Tennis</td>
<td width=100><input type="checkbox" id="Snooker" onclick="clickButton(\'Snooker\');"';
if(in_array("Snooker", $MenuArray)) { $output .=  " checked ";}$output .= '>Snooker</td>';
$output .= '</tr>';
$output .= '<tr>';
$output .= '<td colspan=4>';
$output .= '<table border=0 cellpadding=0 cellspacing=0 width=600>';
$output .= '<tr>';
$output .= '<td width=28><img src="../images/arrowmain.gif"></td>';
$output .= '<td width=572 class=title>select country</td>';
$output .= '</tr>';
$output .= '<tr>';
$output .= '<td width=600 colspan=2 class=subtitle>to add a country to the top green menu check a box, to remove a sport uncheck a box</td>';
$output .= '</tr>';
$output .= '</table>';
$output .= '</td>';
$output .= '</tr>';
$output .= '<tr>';
$output .= '<td width=100><input type="checkbox" id="England" onclick="clickButton(\'England\');"';
if (in_array("England", $MenuArray)) { $output .= " checked ";} $output .= '>England</td>';
$output .= '<td width=100><input type="checkbox" id="Canada" onclick="clickButton(\'Canada\');"';
if (in_array("Canada", $MenuArray)) { $output .= " checked ";} $output .= '>Canada</td>';
$output .= '<td width=100></td>';
$output .= '<td width=100></td>';
$output .= '</tr>';
$output .= '</table>';
$output .= '</form>';

 $output .= '<div id="menucreate">
<table border=0 cellpadding=0 cellspacing=0 width=800>
<tr>
  <td width=28><img src="../images/arrowmain.gif"></td>
  <td width=772 class=title align=left>your menu</td>
</tr>
<tr>
  <td colspan="2" class="subtitle">drag and drop menu items in the order you would like them appear.  Next time you refresh the page the changes will appear. </td>
</tr>
<tr>
  <td colspan="2">
  <ul id=menu>';
  
  	 foreach($MenuArray as $item ){
  		 $output .= '<li id="menu_' . $item . '">' . strtoupper($item) . '</li>';
  	}
	
 $output .= '</ul>
 <br><br>
 <div class="editButtons"
 <input type=button onClick=updateUserMenu() value="Save Changes" class="editButtons"> <input type=button onClick=history.go(-1) value="Cancel" class="editButtons"></div>
  <script type="text/javascript">
  Sortable.create("menu",{ghosting:true,constraint:false});    
  </script>
  </td>
</tr>
</table>
</div>';

$wgOut->addHTML($output);
}

}

 SpecialPage::addPage( new UserMenu );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}
?>
