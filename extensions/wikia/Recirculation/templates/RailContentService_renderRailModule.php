<section id="recirculation-rail">
	<section class="rail-module premium-recirculation-rail">
		<h2><?= wfMessage( 'popularpages' )->escaped(); ?></h2>
		<ul class="thumbnails">
			<?php foreach ( $popularPages as $page ): ?>
			<li>
				<a href="<?= Sanitizer::encodeAttribute( $page['url'] ); ?>" title="<?= Sanitizer::encodeAttribute( $page['title'] ); ?>">
					<img src="<?= Sanitizer::encodeAttribute( $page['thumbnail'] ); ?>" alt="" />
					<p><?= htmlspecialchars( $page['title'] ); ?></p>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
</section>
