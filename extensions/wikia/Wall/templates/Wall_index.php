<div class="WallGreeting" >
	<?= $greeting ?>
</div>
<div class="Wall" id="Wall">
	<?php if($showNewMessage): ?>
		<?= $app->renderView( 'WallController', 'newMessage' ); ?>
	<?php endif; ?>
	<? if ($showNewMessage): ?>
	<div class="SortingBar">
		<div class="SortingMenu">
			<span class="SortingSelected"><?= $sortingSelected; ?></span>
			<ul class="SortingList">
				<? foreach($sortingOptions as $option): ?>
					<? if (!empty($option['selected'])): ?>
						<li class="current">
							<a href="<?= $option['href'] ?>">
								<?= $option['text'] ?>
							</a>
						</li>
					<? else: ?>
						<li>
							<a href="<?= $option['href'] ?>">
								<?= $option['text'] ?>
							</a>
						</li>
					<? endif ?>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
	<? endif; ?>
	<ul class="comments">
		<? foreach($threads as $value): ?>
			<? echo $app->renderView( 'WallController', 'message', array('condense' => $condenseMessage, 'title' => $title, 'replies' => $value->getRepliesAC(), 'comment' => $value->getThreadAC(), 'isreply' => false ) ); ?>
		<? endforeach; ?>
	</ul>
	<?php if($showPager): ?>
		<?= $app->renderView( 'PaginationController', 'index', array('totalItems' => $totalItems, 'itemsPerPage' => $itemsPerPage, 'currentPage' => $currentPage)); ?>
	<?php endif;?>
	<?= $app->renderView( 'WallController', 'renderUserTalkArchiveAnchor', array('renderUserTalkArchiveAnchor' => $renderUserTalkArchiveAnchor,  'title' => $title ) ); ?>
</div>