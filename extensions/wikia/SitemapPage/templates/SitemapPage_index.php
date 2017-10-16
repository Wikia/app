<div class="sitemap-page">
	<h1><?= wfMessage('sitemap-page-header')->escaped() ?></h1>
	<div class="sitemap-top-level">
		<?php
		while ( count( $wikis ) > 0 ) {
			$from = array_shift( $wikis );
			$to = array_shift( $wikis );
			$url = $wg->Title->getLocalURL( "level=$level&namefrom=$from[dbname]&nameto=$to[dbname]" );
			?>
			<span>
			<a class="title" href="<?= $url ?>">
				<?= $from['title'] ?>
				<span>to</span>
				<?= $to['title'] ?>
			</a>
		</span>
		<?php } ?>
	</div>
</div>
