<? 
if ($wg->EnableMiniEditorExtForWall) {
	echo $app->renderView('MiniEditorController', 'Setup');
}?>

<div class="WallGreeting" >
	<?= ${WallConst::greeting} ?>
</div>
<div class="Wall <?= ${WallConst::type} ?>" id="Wall">
	<?php if(${WallConst::showNewMessage}): ?>
		<?= $app->renderView( 'WallController', 'newMessage' ); ?>
	<?php endif; ?>
	<? if (${WallConst::showNewMessage}): ?>
	<div class="SortingBar">
		<div class="SortingMenu">
			<span class="SortingSelected"><?= ${WallConst::sortingSelected}; ?></span>
			<ul class="SortingList">
				<? foreach(${WallConst::sortingOptions} as $option): ?>
					<li class="<? if (!empty($option['selected'])): ?>current<? endif ?> <?= $option['id']; ?>">
						<a href="<?= $option['href'] ?>" class="sortingOption">
							<?= $option['text'] ?>
						</a>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
	<? endif; ?>
	<ul class="comments">
		<? foreach(${WallConst::threads} as $value): ?>
			<? echo $app->renderView( 'WallController', 'message', [ 'isThreadPage' => false, 'condense' => ${WallConst::condenseMessage}, 'title' => ${WallConst::title}, 'replies' => $value->getRepliesWallMessages(), 'comment' => $value->getThreadMainMsg(), 'isreply' => false ] ); ?>
		<? endforeach; ?>
	</ul>
	<?php if(${WallConst::showPager}): ?>
		<?= $app->renderView( 'PaginationController', 'index', [ 'totalItems' => ${WallConst::totalItems}, 'itemsPerPage' => ${WallConst::itemsPerPage}, 'currentPage' => ${WallConst::currentPage} ] ); ?>
	<?php endif;?>
	<?= $app->renderView( 'WallController', 'renderUserTalkArchiveAnchor', [ 'renderUserTalkArchiveAnchor' => ${WallConst::renderUserTalkArchiveAnchor},  'title' => ${WallConst::title} ] ); ?>
	<?= $app->renderPartial('Wall', 'TooltipMeta' ); ?>
</div>
