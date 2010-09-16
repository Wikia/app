<?php if( !$skipRendering ) { ?>
	<nav class="RelatedPagesModule">
		<h1><?= wfMsg('wikiarelatedpages-heading') ?></h1>
		<ul>
		<?php foreach($pages as $page) { ?>
			<li>
				<div class="content">
				<?php if( isset( $page['imgUrl'] ) ) { ?>
					<img src="<?= $page['imgUrl']; ?>" width="200" height="100">
				<?php } else { ?>
					<div class="articleSnippet"><p><?= $page['text']; ?></p></div>
				<?php } ?>
				</div>
				<p>
					<a href="<?= $page['url']; ?>"><?= $page['wrappedTitle'] ?></a>
				</p>
			</li>
		<?php } ?>
		</ul>
	</nav>
<?php } // !skipRendering ?>