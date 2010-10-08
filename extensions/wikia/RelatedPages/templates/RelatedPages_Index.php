<?php if( !$skipRendering ) { ?>
	<nav class="RelatedPagesModule">
		<h2><?= wfMsg('wikiarelatedpages-heading') ?></h2>
		<ul>
		<?php foreach($pages as $page) { ?>
			<li>
				<?php if( isset( $page['imgUrl'] ) ) { ?>
				<img src="<?= $page['imgUrl']; ?>" width="200" height="100">
				<?php } else { ?>
				<div class="articleSnippet"><p><?= $page['text']; ?></p></div>
				<?php } ?>
				<a href="<?= $page['url']; ?>" class="more"><?= $page['wrappedTitle'] ?></a>
			</li>
		<?php } ?>
		</ul>
	</nav>
<?php } // !skipRendering ?>