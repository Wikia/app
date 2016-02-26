<? if ( $wg->EnableMiniEditorExtForWall ): ?>
	<?= $app->renderView( 'MiniEditorController', 'Setup' ) ?>
<? endif ?>
<div id="Wall" data-board-namespace="<?= ${ForumConst::boardNamespace} ?>">
	<section id="Forum" class="Forum Board .comments">
		<?= $app->renderView( 'ForumController', 'breadCrumbs' ) ?>
		<div class="board-description">
			<?= ${ForumConst::description} ?>
		</div>
		<div class="greeting"><?= ${ForumConst::greeting} ?></div>
		<?= $app->renderView( 'ForumController', 'boardNewThread', [ 'isTopicPage' => ${ForumConst::isTopicPage} ] ) ?>
		<div class="ContentHeader <?php if ( ${ForumConst::isTopicPage} ): ?> Topic<?php endif; ?>">
			<?php if ( ${ForumConst::isTopicPage} ): ?>
				<div class="activity"><?= wfMessage( 'forum-active-threads-on-topic', $wg->Lang->formatNum( ${ForumConst::activeThreads} ), ${ForumConst::topicText} )->parse(); ?></div>
			<?php else : ?>
				<div class="activity"><?= wfMessage( 'forum-active-threads', $wg->Lang->formatNum( ${ForumConst::activeThreads} ) )->escaped(); ?></div>
			<?php endif; ?>
			<div class="sorting">
				<span class="selected"><?= ${ForumConst::sortingSelected} ?><img class="arrow" src="<?= $wg->BlankImgUrl ?>" /></span>
				<ul class="menu">
					<? foreach ( ${ForumConst::sortingOptions} as $option ): ?>
						<li class="<?= $option['id'] ?><?= !empty( $option['selected'] ) ? ' current' : '' ?>">
							<a href="<?= $option['href'] ?>" class="option"><?= $option['text'] ?></a>
						</li>
					<? endforeach ?>
				</ul>
			</div>
		</div>
		<ul class="ThreadList">
			<? foreach ( ${ForumConst::threads} as $thread ): ?>
				<?= $app->renderView( 'ForumController', 'boardThread', [
					'replies' => $thread->getRepliesWallMessages(),
					'comment' => $thread->getThreadMainMsg()
				] ) ?>
			<? endforeach ?>
		</ul>
		<? if ( ${ForumConst::showPager} ): ?>
			<?= $app->renderView( 'PaginationController', 'index', [
				'data' => [ 'controller' => 'ForumExternalController' ],
				'totalItems' => ${ForumConst::totalItems},
				'itemsPerPage' => ${ForumConst::itemsPerPage},
				'currentPage' => ${ForumConst::currentPage}
			] ) ?>
		<? endif ?>
		<div id="WallTooltipMeta">
			<div class="tooltip-text tooltip-highlight-thread"><?= wfMsg( 'wall-message-notifyeveryone-tooltip' ) ?></div>
		</div>
	</section>
</div>
