<header id="pageHeader" class="page-header separator">
	<h1><?= wfMessage( 'wall-deleted-msg-pagetitle' )->escaped() ?></h1>
</header>
<div class="WikiaArticle" id="WikiaArticle">
	<?= wfMessage( 'wall-deleted-msg-text' )->escaped(); ?>

	<?php if ( !empty( $wallUrl ) ) { ?>
		<a href="<?= $wallUrl ?>"><?=  $returnTo ?></a>
	<?php }

	if ( $showViewLink ) { ?>
		<p>
			<a href="<?= $viewUrl ?>">
				<?= wfMessage( 'wall-deleted-msg-view' )->escaped() ?>
			</a>
		</p> 
	<?php } ?>
</div>
