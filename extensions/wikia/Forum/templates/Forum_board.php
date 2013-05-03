<? if ($wg->EnableMiniEditorExtForWall): ?>
	<?= $app->renderView('MiniEditorController', 'Setup') ?>
<? endif ?>
<div id="Wall" data-board-namespace="<?= $boardNamespace ?>">
	<section id="Forum" class="Forum Board .comments">
		<?= $app->renderView('ForumController', 'breadCrumbs') ?>
		<div class="board-description">
			<?= $description ?>
		</div>
		<div class="greeting"><?= $greeting ?></div>
		<?= $app->renderView('ForumController', 'boardNewThread', array('isTopicPage' => $isTopicPage)) ?>
		<div class="ContentHeader <?php if($isTopicPage): ?> Topic<?php endif; ?>">
			<?php if($isTopicPage): ?>
				<div class="activity"><?= wfMsgExt(('forum-active-threads-on-topic'), array('parsemag'), $wg->Lang->formatNum( $activeThreads ), "<b><a href='$topicURL'>".$topicText."</a></b>") ?></div>
			<?php else: ?>
				<div class="activity"><?= wfMsgExt(('forum-active-threads'), array('parsemag'), $wg->Lang->formatNum( $activeThreads )) ?></div>
			<?php endif; ?>
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
			<div class="tooltip-text tooltip-highlight-thread"><?= wfMsg('wall-message-notifyeveryone-tooltip') ?></div>
		</div>
	</section>
</div>
