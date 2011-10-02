<div class="Wall" id="Wall">
	<?php if($showNewMessage): ?>
		<?= $app->renderView( 'WallController', 'newMessage' ); ?>
	<?php endif; ?>	
	<ul class="comments">
		<? foreach($commentListRaw as $value): ?>
			<? echo $app->renderView( 'WallController', 'message', array('condense' => $condenseMessage, 'title' => $title, 'replies' => empty($value['level2']) ? array():$value['level2'], 'comment' => empty($value['level1']) ? array():$value['level1'], 'isreply' => false ) ); ?>
		<? endforeach; ?>
	</ul>
	<?php if($showPager): ?>
		<?= $app->renderView( 'PaginationController', 'index', array('totalItems' => $totalItems, 'itemsPerPage' => $itemsPerPage, 'currentPage' => $currentPage)); ?>
	<?php endif;?>
	<?= $app->renderView( 'WallController', 'renderUserTalkArchiveAnchor', array('renderUserTalkArchiveAnchor' => $renderUserTalkArchiveAnchor,  'title' => $title ) ); ?>
</div>
