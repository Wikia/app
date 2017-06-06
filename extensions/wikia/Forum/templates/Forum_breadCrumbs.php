<nav class="BreadCrumbs" itemprop="breadcrumb">
	<? $total = count( $path ) - 1 ?>
	<? foreach ( $path as $index => $val ): ?>
		<? if ( !empty( $val['url'] ) ): ?>
			<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else : ?>
			<?= $val['title'] ?>
		<? endif ?>
		<? if ( $index < $total ): ?>
			<span class="separator">&gt;</span>
		<? endif ?>
	<? endforeach ?>
	<? if ( !empty( $isRemoved ) || !empty( $isAdminDeleted ) ): ?>
		<span class="removed"><?= wfMessage( 'parentheses' )->params( wfMessage( 'wall-thread-' . ( $isAdminDeleted ? 'deleted' : 'removed' ) )->plain() )->escaped(); ?></span>
	<? endif ?>
</nav>
