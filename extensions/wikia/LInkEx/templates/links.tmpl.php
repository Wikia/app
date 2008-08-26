<!-- s:<?= __FILE__ ?> -->
<? include('style.php'); ?>

<table width=100% cellspacing=4 cellpadding=4 border=0>
 <tr>
  <td colspan=3 align="middle">

	<table height=40 width=300 cellspacing=0 cellpadding=0 border=0>
	<tr><td class="lex_main_title" valign="top"><?= $data['msg.title'] ?></td>
	<td align="right" valign="top">
		<form id="linkex" method="post" action="<?= $GLOBALS['wgTitle']->getLocalUrl() ?>">
			<input type="hidden" name="action" value="add">	  
			<input type="submit" class="btn-action" value="<?= $data['msg.addyoursitelink'] ?>"> 
		</form>
		</td>
	</tr>
	</table>

  </td>
 </tr>
 <tr>
  <td width=10><?= $data['msg.rank'] ?></td>
  <td><?= $data['msg.sitedescription'] ?></td>
 </tr>

<?
	if($data['newlink']){
	  echo '<tr><td colspan="2" align="middle">'. $data['msg.newlink'] . '</td></tr>';
	}
	

    $row = 0;
	
	foreach ($data['links'] as $key => $value){
		$row++;
    	echo '<tr '.(($row%2)?('style="lex.alttab"'):('')).'>';
    	echo '<td class="lex main">'.$value['pr'].'</td>';
    	echo '<td class="lex main">';
    	echo '<a href="' . $value['site_url'] . '" title="' . htmlspecialchars( $value['site_title'] ) . '[' . $value['referals'] . ']"><b>' . htmlspecialchars($value['site_title'] );
    	echo '</b></a> - <span class="lex main green" >' . htmlspecialchars( $value['site_url'] ) . '</span>';
       	echo '</br>' . htmlspecialchars( $value["description"] ) . '</td>';
       	echo '</tr>';
	}

?>

</table>

<!-- e:<?= __FILE__ ?> -->