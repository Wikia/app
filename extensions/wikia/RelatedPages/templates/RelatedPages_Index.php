<?php if( !$skipRendering ) { ?>
	<section class="RelatedPagesModule">
		<h1><?= wfMsg('wikiarelatedpages-heading') ?></h1>
		<ul>
		<?php foreach($pages as $page) { ?>
			<li>
				<?php if( isset( $page['imgUrl'] ) ) { ?>
					<img src="<?= $page['imgUrl']; ?>" />
				<?php } else { ?>
					<div class="articleSnippet">"<?= $page['text']; ?>"</div>
				<?php } ?>
				<p>
					<a href="<?= $page['url']; ?>"><?= $page['title'] ?></a>
				</p>
			</li>
		<?php } ?>
		</ul>
	</section>
<?php } // !skipRendering ?>