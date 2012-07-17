<? if ($wg->EnableMiniEditorExtForWall): ?>
	<?= $app->renderView('MiniEditorController', 'Setup') ?>
<? endif ?>
<section id="Forum" class="Forum Thread">
	<?= $app->renderView( 'ForumController', 'breadCrumbs', array( 'id' => $wg->WallBrickHeader) ) ?>
	<div class="greeting" ><?= $greeting ?></div>
	<? foreach($threads as $value): ?>
		<?= $app->renderView('ForumController', 'threadMessage', array(
			'showDeleteOrRemoveInfo' => $showDeleteOrRemoveInfo,
			'condense' => false,
			'title' => $title,
			'replies' => $value->getRepliesWallMessages(),
			'comment' => $value->getThreadMainMsg(),
			'isreply' => false
		)) ?>
	<? endforeach ?>
	<? if (0 && $showPager): ?>
		<?= $app->renderView('PaginationController', 'Index', array(
			'data' => array('controller' => 'ForumExternalController'),
			'totalItems' => $totalItems,
			'itemsPerPage' => $itemsPerPage,
			'currentPage' => $currentPage
		)) ?>
	<? endif ?>
</section>