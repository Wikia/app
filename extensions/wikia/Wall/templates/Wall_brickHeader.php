<nav<? if ( !empty( $className ) ) : ?> class="<?= $className ?>"<? endif; ?> itemprop="breadcrumb">
	<? $total = count( $path ) - 1 ?>
	<? foreach ( $path as $index => $val ): ?>
		<? if ( !empty( $val['url'] ) ): ?>
			<a href="<?= $val['url'] ?>" title="<?= $val['title'] ?>"><?= $val['title'] ?></a>
		<? else: ?>
			<?= $val['title'] ?>
		<? endif; ?>
		<? if ( $index < $total ): ?>
			<span class="separator">&gt;</span>
		<? endif; ?>
	<? endforeach; ?>

	<? if ( !empty( $isRemoved ) || !empty( $isAdminDeleted ) ): ?>
		<? $deletedOrRemovedKey = $isAdminDeleted ? 'wall-thread-deleted' : 'wall-thread-removed' ?>
		<span class="removed"><?= wfMessage( 'parentheses' )
				->params( wfMessage( $deletedOrRemovedKey )->plain() )
				->escaped(); ?></span>
	<? endif; ?>

	<? if ( !empty( $isNotifyeveryone ) ): ?>
		<span class="removed"><?= wfMessage( 'parentheses' )
				->params( wfMessage( 'wall-thread-isnotifyeveryone' )->plain() )
				->escaped(); ?></span>
	<? endif; ?>

	<? if ( !empty( $isClosed ) ): ?>
		<span class="removed"><?= wfMessage( 'parentheses' )
				->params( wfMessage( 'wall-thread-closed' )->plain() )
				->escaped(); ?></span>
	<? endif; ?>
</nav>
