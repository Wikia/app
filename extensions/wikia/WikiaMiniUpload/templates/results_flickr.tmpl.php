<div id="ImageUploadHeadline">
<div id="ImageUploadPagination">
<?php
if($results['page'] > 1) {
?>
	<a onclick="WMU_sendQuery('<?= $query ?>', <?= $results['page']-1 ?>, 1, 'prev'); return false;" href="#"><?= wfMsg('wmu-prev') ?></a>
<?php
}
if($results['page'] > 1 && $results['page'] < $results['pages']) {
?>
	|
<?php
}
if($results['page'] < $results['pages']) {
?>
	<a onclick="WMU_sendQuery('<?= $query ?>', <?= $results['page']+1 ?>, 1, 'next'); return false;" href="#"><?= wfMsg('wmu-next') ?></a>
<?php
}
?>
</div>
<?= wfMsg('wmu-flickr2', $results['total']) ?>
</div>

<table cellspacing="0" id="ImageUploadFindTable">
	<tbody>
<?php
for($j = 0; $j < ceil(count($results['photo']) / 4); $j++) {
?>
		<tr class="ImageUploadFindImages">
<?php
	for($i = $j*4; $i < ($j+1)*4; $i++) {
		if(isset($results['photo'][$i])) {
?>
			<td style="width: 167px;"><a href="#" alt="<?= addslashes($results['photo'][$i]['title']) ?>" title="<?= addslashes($results['photo'][$i]['title']) ?>" onclick="WMU_chooseImage(1, '<?= $results['photo'][$i]['id'] ?>'); return false;"><img src="http://farm<?=$results['photo'][$i]['farm']?>.static.flickr.com/<?=$results['photo'][$i]['server']?>/<?=$results['photo'][$i]['id']?>_<?=$results['photo'][$i]['secret']?>_t.jpg" /></a></td>
<?php
		}
	}
?>
		</tr>
		<tr class="ImageUploadFindLinks">
<?php
	for($i = $j*4; $i < ($j+1)*4; $i++) {
		if(isset($results['photo'][$i])) {
?>
			<td><a href="#" onclick="WMU_chooseImage(1, '<?= $results['photo'][$i]['id'] ?>'); return false;"><?= wfMsg('wmu-insert3') ?></a></td>
<?php
		}
	}
?>
		</tr>
<?php
}
?>
	</tbody>
</table>
