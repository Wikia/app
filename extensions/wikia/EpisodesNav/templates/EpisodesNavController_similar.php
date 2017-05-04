<div class="similars">
	<?php foreach ( $articles as $article ) : ?>
		<div class="similar">
			<a href="<?= $article['link'] ?>">
				<span><?= $article['title'] ?></span>
				<img src="<?= $article['image'] ?>">
			</a>
		</div>
	<?php endforeach; ?>
</div>
