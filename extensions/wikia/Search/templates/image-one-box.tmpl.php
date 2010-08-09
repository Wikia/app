<div class="clearfix">
	<ul class="search-images">
		<div class="search-images-title">
			<?php echo wfMsg( 'wikiasearch-image-results', array( $searchTerm ) ); ?>
		</div>
		<?php foreach ($images as $info): ?>
		<li>
			<div>
				<a<?= $info['lightBox'] ? ' class="lightbox"' : '' ?> href="<?= $info['mainImageLink'] ?>">
					<img class="search-image" src="<?= $info['thumbUrl'] ?>" /></a><br />
				<?php if (count($info['titles']) > 0): ?>
					<div>
					<p>Articles: <br/ >
					<?php foreach ($info['titles'] as $t): ?>
					<a href="<?= $t->getLocalUrl() ?>"><?= $t->getText() ?></a><br />
					<?php endforeach; ?>
					<?php if ($info['seeMore']): ?>
					<a href="<?= $info['seeMore'] ?>">See more</a>
					<?php endif; ?>
					</p></div>
				<?php endif; ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>