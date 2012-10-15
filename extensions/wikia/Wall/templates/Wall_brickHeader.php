<div class="BreadCrumbs">
	<? foreach($path as $key => $val ): ?>
		<? if(!empty($val['url'])):?>
			<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else: ?>
			<?= $val['title'] ?>
		<? endif; ?>
		<? if ($key < (count($path) - 1)): ?>
			<span class="separator">&gt;</span>
		<? endif; ?>
	<? endforeach; ?>
	<? if (!empty($isRemoved) || !empty($isAdminDeleted)): ?>
		<span class="removed"><?= '('.wfMsg('wall-thread-'.($isAdminDeleted ? 'deleted' : 'removed')).')' ?></span>
	<? endif; ?>
    <? if (!empty($isNotifyeveryone)): ?>
            <span class="removed">(<?= wfMsg('wall-thread-isnotifyeveryone'); ?>)</span>
    <? endif; ?>
    <? if (!empty($isClosed)): ?>
    	<span class="removed">(<?= wfMsg('wall-thread-closed') ?>)</span>
    <? endif; ?>
</div>