<div class="category-page__trending-pages-header">Trending pages</div>
<ul class="category-page__trending-pages">
	<?php foreach ( $trendingPages as $trendingPage ) : ?>
		<li class="category-page__trending-page">
			<a href="<?= $trendingPage['url'] ?>">
				<figure>
					<img src="<?= Sanitizer::encodeAttribute( $trendingPage['thumbnail'] ); ?>"
						 srcset="<?= CategoryPage3::getSrcset( $trendingPage['thumbnail'] ) ?>"
						 sizes="auto"
						 alt="<?= Sanitizer::encodeAttribute( $trendingPage['title'] ); ?>"
						 class="category-page__trending-page-thumbnail"
					>
					<figcaption class="category-page__trending-page-title"><?= htmlspecialchars( $trendingPage['title'] ) ?></figcaption>
				</figure>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
