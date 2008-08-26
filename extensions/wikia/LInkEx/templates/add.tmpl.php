<!-- s:<?= __FILE__ ?> -->
<? include('style.php'); ?>

<table cellspacing="2" cellpadding="2" width="100%" border="0">
<form id="linkex" method="post" action="<?= $GLOBALS['wgTitle']->getLocalUrl() ?>">
<input type="hidden" name="action" value='verify'>

<tr>
<td valign=top height=40 colspan=2 class="lex_main_title"><?= $data['msg.title'] ?> - <?= $data['msg.info'] ?> </td>
</tr>
<tr>
<td align="left" colspan="2">
<textarea rows=3 style='width:400pt; font-size:10pt; FONT-FAMILY:Arial; background:lightgray;'>
<?= $data['msg.homelink'] ?>
</textarea>
</td>
</tr>


<? 
if( $data['msg.err'] != '' ){
?>

<tr>
<td class="errmsg" colspan="2"><?= $data['msg.err'] ?></td>
</tr>

<?
}
?>

<tr>
<td width="120" align="right" class="main">Title:<br><small>10-30 chars</small></td>
<td align="left"><input type=text name="data.site_name" style='font-size:10pt; width:250pt;' value="<?= $data['data.site_name']?>"></td>
</tr>

<tr>
<td align="right" class="main">URL:</td>
<td align="left"><input type=text name="data.site_url" value="<?php echo 'http://' . str_replace('http://','', $data['data.site_url'])?>" style='font-size:10pt; FONT-FAMILY:Tahoma; width:250pt;'></td>
</tr>

<tr>
<td align="right" class="main" valign="top">Description:<br><font style='font-size:8pt; FONT-FAMILY:Arial;'>0-255 chars</font></td>
<td align="left"><textarea rows=3 name="data.site_description" style='font-size:8pt; FONT-FAMILY:Tahoma; width:250pt;'><?= $data['data.site_description']?></textarea></td>
</tr>

<tr>
<td align="right" class="main">Your Contact E-mail:</td>
<td align="left"><input type=text name="data.site_email" style='font-size:10pt; FONT-FAMILY:Tahoma; width:250pt;' value="<?= $data['data.site_email']?>"></td>
</tr>

<tr>
<td align="right" class="main">Reciprocal Link URL?</td>
<td align="left"><input type=text name="data.site_receip" style='font-size:10pt; FONT-FAMILY:Tahoma; width:250pt;' value="<?php echo 'http://' . str_replace('http://','',$data['data.site_receip']);?>"></td>
</tr>

<td class="main" align="middle" colspan="2">

<input type="submit" class="btn-add" value="<?= $data['msg.addthislink'] ?>"> 

</td>
</tr>

</form>
</table>


<!-- e:<?= __FILE__ ?> -->