<div class="BreadCrumbs">
	<? foreach($path as $key => $val ): ?>
		<? if(!empty($val['url'])):?>
				<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else: ?>
			<?= $val['title'] ?>
		<? endif; ?>
		<? if ($key < (count($path) - 1)): ?>
			&gt;
		<? endif; ?>
	<? endforeach; ?>
	<? if (!empty($isRemoved) || !empty($isAdminDeleted)): ?>
		<?= '('.wfMsg('wall-thread-'.($isAdminDeleted ? 'deleted' : 'removed')).')' ?>
	<? endif; ?>
    <? if (!empty($isNotifyeveryone)): ?>
            (<?= wfMsg('wall-thread-isnotifyeveryone'); ?>)
    <? endif; ?>
</div>
