<div class="BreadCrumbs">
	<? $total = count($path) - 1 ?>
	<? foreach($path as $index => $val): ?>
			<? if (!empty($val['url'])): ?>
				<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
			<? else: ?>
				<?= $val['title'] ?>
			<? endif ?>
		<? if ($index < $total): ?>
			&gt;
		<? endif ?>
	<? endforeach ?>
	<? if (!empty($isRemoved) || !empty($isAdminDeleted)): ?>
		<?= '(' . wfMsg('wall-thread-' . ($isAdminDeleted ? 'deleted' : 'removed')) . ')' ?>
	<? endif ?>
</div>