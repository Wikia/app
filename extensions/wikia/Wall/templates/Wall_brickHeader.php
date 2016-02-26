<div class="BreadCrumbs">
	<? foreach(${WallConst::path} as $key => $val ): ?>
		<? if(!empty($val['url'])):?>
			<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else: ?>
			<?= $val['title'] ?>
		<? endif; ?>
		<? if ($key < (count($path) - 1)): ?>
			<span class="separator">&gt;</span>
		<? endif; ?>
	<? endforeach; ?>
	<? if (!empty(${WallConst::isRemoved}) || !empty(${WallConst::isAdminDeleted})): ?>
		<span class="removed"><?= '('.wfMsg('wall-thread-'.(${WallConst::isAdminDeleted} ? 'deleted' : 'removed')).')' ?></span>
	<? endif; ?>
    <? if (!empty(${WallConst::isNotifyeveryone})): ?>
            <span class="removed">(<?= wfMsg('wall-thread-isnotifyeveryone'); ?>)</span>
    <? endif; ?>
    <? if (!empty(${WallConst::isClosed})): ?>
    	<span class="removed">(<?= wfMsg('wall-thread-closed') ?>)</span>
    <? endif; ?>
</div>