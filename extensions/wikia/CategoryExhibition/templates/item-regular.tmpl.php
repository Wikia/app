<div class="category-gallery-item">
	<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>"
	   title="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>">
		<div class="category-gallery-item-image">
			<? if ( !empty( $row['img'] ) ): ?>
				<img src="<?= Sanitizer::encodeAttribute( $row['img'] ); ?>"
					 alt="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>"
					 width="<?= Sanitizer::encodeAttribute( $row['width'] ); ?>"
					 height="<?= Sanitizer::encodeAttribute( $row['height'] ); ?>"
				/>
			<? elseif ( !empty( $row['snippet'] ) ): ?>
				<div class="snippet">
					<span class="quote">&#x201C;</span>
					<span class="text"><?= htmlspecialchars( $row['snippet'] ); ?></span>
				</div>
			<? else: ?>
				<div class="snippet category-gallery-placeholder"></div>
			<? endif; ?>
		</div>
		<div class="title"><?= htmlspecialchars( $row['title'] ); ?></div>
	</a>
</div>
