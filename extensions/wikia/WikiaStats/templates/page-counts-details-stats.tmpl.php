<!-- s:<?= __FILE__ ?> -->
<!-- PAGE EDITED DETAILS TABLE -->
<table cellspacing="0" cellpadding="0" border="0" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;">
<tr>
<td class="wk-select-class">&nbsp;</td>
<?php
foreach ($userStats as $id => $stats)
{
	$details = ($id == 0) ? "" : "UN";
?>	
<td valign="top">
<!-- <?= $details ?>REGISTER USERS DETAILS TABLE -->
	<table cellspacing="0" cellpadding="0" border="1" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
	<tr bgcolor="#ffdead">
		<td class="cb"><b>#</b></td>	
		<td class="cb"><b><?= wfMsg('wikiastats_username') ?></b></td>
		<td class="cb"><b><?= wfMsg('wikiastats_edits') ?></b></td>
	</tr>	
<?php
	$rank = 0; 
	if (is_array($stats)) {
        foreach ($stats as $cnt => $info)
        {
            $rank++;
?>
	<tr>
		<td class="eb" nowrap><?= $rank ?></td>
		<td class="ebl" nowrap><a href="<?= $city_url ?><?= Title::makeTitle(NS_USER, $info['user_text'])->getLocalURL() ?>" target="new"><?= $info['user_text'] ?></a></td>
		<td class="eb" nowrap><?= $cnt ?></td>
	</tr>	
<?php
        }
    }
?>
	</table>
</td>
<td>&nbsp;</td>
<?
}
?>	
</table>
<!-- END OF PAGE EDITED DETAILS TABLE -->
<!-- e:<?= __FILE__ ?> -->
