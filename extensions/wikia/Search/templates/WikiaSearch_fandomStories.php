<?php if ( !empty( $stories ) ) : ?>
	<div class="fandom-stories RailModule">
	<h2>Related Fandom Stories</h2>
	<?php foreach ( $stories as $story ) : ?>
		<div class="fandom-story">
			<a href="<?= $story['url'] ?>">
				<h3><?= $story['title'] ?></h3>
			</a>
			<?= $story['excerpt'] ?>
			<div>Vertical: <?= $story['vertical'] ?></div>
			<img src="<?= $story['image'] ?>">
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
