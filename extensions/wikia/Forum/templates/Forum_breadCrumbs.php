<div class="BreadCrumbs">
	<? $total = count($path) - 1 ?>
	<? foreach($path as $index => $val): ?>
		<span class="crumb">
			<? if (!empty($val['url'])): ?>
				<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
			<? else: ?>
				<?= $val['title'] ?>
			<? endif ?>
		</span>
		<? if ($index < $total): ?>
			<span class="crumb separator">&gt;</span>
		<? endif ?>
	<? endforeach ?>
	<? if (!empty($isRemoved) || !empty($isAdminDeleted)): ?>
		<span class="crumb removed"><?= '(' . wfMsg('wall-thread-' . ($isAdminDeleted ? 'deleted' : 'removed')) . ')' ?></span>
	<? endif ?>
</div>