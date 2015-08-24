<div id="pageHeader" class="page-header editpage">
	<h1><?= $title ?></h1>
	<?php if ( !empty( $button['action'] ) ) {
		echo $app->renderView(
			'MenuButton',
			'Index',
			$button
		);
	}

	if( !empty( $isHistory ) && !empty( $isUserTalkArchiveModeEnabled ) ) {
		echo $app->renderView(
			'CommentsLikes',
			'Index',
			[ 'comments' => $comments ]
		);
	}

	if ( !empty( $subtitle ) ) { ?>
		<h2 class="breadcrumbs"><?= $subtitle ?></h2>
	<?php } ?>
</div>
