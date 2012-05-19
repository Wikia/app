<div class="BreadCrumbs">
	<? foreach($path as $key => $val ): ?>
		<? if(!empty($val['url'])):?>
			<span class="crumb">
				<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
			</span>
		<? else: ?>
			<span class="crumb"><?= $val['title'] ?></span>
		<? endif; ?>
		<? if ($key < (count($path) - 1)): ?>
			<span class="crumb separator">&gt;</span>
		<? endif; ?>
	<? endforeach; ?>
	<? if (!empty($isRemoved) || !empty($isAdminDeleted)): ?>
		<span class="crumb removed"><?= '('.wfMsg('wall-thread-'.($isAdminDeleted ? 'deleted' : 'removed')).')' ?></span>
	<? endif; ?>
</div>