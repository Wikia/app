<? if ($wg->EnableMiniEditorExtForWall): ?>
	<?= $app->renderView('MiniEditorController', 'Setup') ?>
<? endif ?>
<div id="Wall">
	<section id="Forum" class="Forum Board .comments">
		<?= $app->renderView('ForumController', 'breadCrumbs') ?>
		<div class="greeting"><?= $greeting ?></div>
		<? if ($showNewMessage): ?>
			<?= $app->renderView('ForumController', 'boardNewThread') ?>
			<div class="ContentHeader">
				<div class="activity"><?= $wf->MsgExt(('forum-active-threads'), array('parsemag'), $activeThreads) ?></div>
				<div class="sorting">
					<span class="selected"><?= $sortingSelected ?><img class="arrow" src="<?= $wg->BlankImgUrl ?>" /></span>
					<ul class="menu">
						<? foreach($sortingOptions as $option): ?>
							<li class="<?= $option['id'] ?><?= !empty($option['selected']) ? ' current' : '' ?>">
								<a href="<?= $option['href'] ?>" class="option"><?= $option['text'] ?></a>
							</li>
						<? endforeach ?>
					</ul>
				</div>
			</div>
		<? endif ?>
		<ul class="ThreadList">
			<? foreach( $threads as $thread ): ?>
				<?= $app->renderView('ForumController', 'boardThread', array(
					'replies' => $thread->getRepliesWallMessages(),
					'comment' => $thread->getThreadMainMsg()
				)) ?>
			<? endforeach ?>
		</ul>
		<? if ($showPager): ?>
			<?= $app->renderView('PaginationController', 'index', array(
				'data' => array('controller' => 'ForumExternalController'),
				'totalItems' => $totalItems,
				'itemsPerPage' => $itemsPerPage,
				'currentPage' => $currentPage
			)) ?>
		<? endif ?>
		<div id="WallTooltipMeta">
			<div class="tooltip-highlight-thread"><?= wfMsg('wall-message-notifyeveryone-tooltip') ?></div>
		</div>
	</section>
</div>