<div id="pageHeader" class="page-header corporate">
	<h1><?= $title ?></h1>
	<?php if ( !empty( $button['action'] ) && $canAct ) {
		echo $app->renderView(
			'MenuButton',
			'Index',
			$button
		);
	}

	if ( !empty( $subtitle ) ) { ?>
		<h2 class="breadcrumbs"><?= $subtitle ?></h2>
	<?php } ?>
</div>
