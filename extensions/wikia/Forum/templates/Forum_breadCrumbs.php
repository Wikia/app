<nav class="BreadCrumbs" itemprop="breadcrumb">
	<? $total = count( ${ForumConst::path} ) - 1 ?>
	<? foreach ( ${ForumConst::path} as $index => $val ): ?>
		<? if ( !empty( $val['url'] ) ): ?>
			<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else : ?>
			<?= $val['title'] ?>
		<? endif ?>
		<? if ( $index < $total ): ?>
			<span class="separator">&gt;</span>
		<? endif ?>
	<? endforeach ?>
	<? if ( !empty( ${ForumConst::isRemoved} ) || !empty( ${ForumConst::isAdminDeleted} ) ): ?>
		<span class="removed"><?= '(' . wfMessage( 'wall-thread-' . ( ${ForumConst::isAdminDeleted} ? 'deleted' : 'removed' ) )->escaped() . ')' ?></span>
	<? endif ?>
</nav>
