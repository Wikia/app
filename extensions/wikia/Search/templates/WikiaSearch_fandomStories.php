<?php $counter = 0; ?>

<?php if ( !empty( $stories ) ) : ?>
	<div class="top-wiki-articles RailModule">
		<h1 class="top-wiki-main">Related Fandom Stories</h1>
		<?php foreach ( $stories as $story ) : ?>
			<div class="top-wiki-article result">
				<div>Vertical: <?= $story['vertical'] ?></div>
				<div class="top-wiki-article-thumbnail">
					<? if ( isset( $story['image'] ) ) : ?>
						<a href="<?=$story['url']?>" data-pos="<?= $counter ?>">
							<img src="<?= $story['image'] ?>" />
						</a>
					<? endif; ?>
				</div>
				<div class="top-wiki-article-text">
					<a href="<?= $story['url'] ?>" data-pos="<?= $counter ?>"><?= $story['title'] ?><!-- comment to remove whitespace
				--><span class="top-wiki-article-text-synopsis subtle">
							<?= $story['excerpt'] ?></span></a>
				</div>
			</div>
			<?php if ( $counter++ >= 4 ) { break; } ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
