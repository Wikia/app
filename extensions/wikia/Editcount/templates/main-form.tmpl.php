<!-- s:<?= __FILE__ ?> -->
<style>
.ecmaintable {background-color:#ffffdd; border:1px solid #808080;font-size:7.7pt;line-height:1.1em;width:350px;}
.ecrowright { border:1px outset #FFFFFF; text-align:right;}
.ecrowcenter { border:1px outset #FFFFFF; text-align:center;}
.ecrowleft { border:1px outset #FFFFFF; text-align:left;}
</style>
<form id='editcount' method='post' action="<?=$action?>">
<table>
<tr>
	<td><?=$user?></td>
	<td><input tabindex='1' type='text' size='30' name='username' value="<?=htmlspecialchars( $username )?>" /><input type='submit' name='submit' value="<?=$submit?>"/></td>
	<td>&nbsp;</td>
</tr>
<? if (!empty($editcounttable)) { ?>
<tr>
	<td>&nbsp;</td>
	<td><?=$editcounttable?></td>
	<td>&nbsp;</td>
</tr>
<? } ?>
</table>
</form>
<!-- e:<?= __FILE__ ?> -->
