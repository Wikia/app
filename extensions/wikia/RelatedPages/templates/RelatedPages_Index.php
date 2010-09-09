<?php if( !$skipRendering ) { ?>
	<div class="RelatedPagesModule">
		<h1><?= wfMsg('wikiarelatedpages-heading') ?></h1>
		<ul>
		<?php foreach($pages as $page) { ?>
			<li>
				<section class="content">
				<?php if( isset( $page['imgUrl'] ) ) { ?>
					<img src="<?= $page['imgUrl']; ?>" />
				<?php } else { ?>
					<div class="articleSnippet"><p><?= $page['text']; ?></p></div>
				<?php } ?>
				</section>
				<p>
					<a href="<?= $page['url']; ?>"><?= $page['wrappedTitle'] ?></a>
				</p>
			</li>
		<?php } ?>
		</ul>
	</div>
<?php } // !skipRendering ?>