<div id="ImageUploadHeadline">
<div id="ImageUploadPagination">
<?php
if($results['page'] > 1) {
?>
	<a onclick="VET_sendQuery('<?= $query ?>', <?= $results['page']-1 ?>, 0, 'prev'); return false;" href="#"><?= wfMsg('vet-prev') ?></a>
<?php
}
if($results['page'] > 1 && $results['page'] < $results['pages']) {
?>
	|
<?php
}
if($results['page'] < $results['pages']) {
?>
	<a onclick="VET_sendQuery('<?= $query ?>', <?= $results['page']+1 ?>, 0, 'next'); return false;" href="#"><?= wfMsg('vet-next') ?></a>
<?php
}
?>
</div>
<?= wfMsg('vet-metacafe', $results['total']) ?>
</div>

<table cellspacing="0" id="ImageUploadFindTable">
	<tbody>
<?php
for($j = 0; $j < ceil(count($results['item']) / 4); $j++) {
?>
		<tr class="ImageUploadFindImages">
<?php
	for($i = $j*4; $i < ($j+1)*4; $i++) {
		if(isset($results['item'][$i])) {
?>
			<td style="width: 167px;"><a href="#" alt="<?= addslashes($results['item'][$i]['title']) ?>" title="<?= addslashes($results['item'][$i]['title']) ?>" onclick="VET_chooseImage(0, '<?= $results['item'][$i]['id'] ?>',  '<?= $results['item'][$i]['link'] ?>',  '<?= $results['item'][$i]['title'] ?>' ); return false;"><img src="http://www.metacafe.com/thumb/<?=$results['item'][$i]['id']?>.jpg" /></a></td>
<?php
		}
	}
?>
		</tr>
		<tr class="ImageUploadFindLinks">
<?php
	for($i = $j*4; $i < ($j+1)*4; $i++) {
		if(isset($results['item'][$i])) {
?>
			<td><a href="#" onclick="VET_chooseImage(0, '<?= $results['item'][$i]['id'] ?>', '<?= $results['item'][$i]['link'] ?>', '<?= $results['item'][$i]['title'] ?>'); return false;"><?= $results['item'][$i]['title'] ?></a></td>
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
