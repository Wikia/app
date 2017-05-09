<div class="category-gallery-media ">
	<? if ( empty( $row['img'] ) ): ?>
		<span class="category-gallery-placeholder"></span>
	<? else: ?>
		<span class="category-gallery-item-image">
			<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>"
			   data-ref="<?= Sanitizer::encodeAttribute( $row['data-ref'] ); ?>"
			   class="<?= Sanitizer::encodeAttribute( $row['class'] ); ?>"
			   title="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>"
			>
				<? if ( $row['isVideo'] == true ): ?>
					<span class="play-circle"></span>
				<? endif; ?>
				<img src="<?= Sanitizer::encodeAttribute( $row['img'] ); ?>"
					 alt="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>"
					<? if ( !empty( $row['dimensions']['w'] ) ): ?>
						width="<?= Sanitizer::encodeAttribute( $row['dimensions']['w'] ); ?>"
					<? endif; ?>
					<? if ( !empty( $row['dimensions']['h'] ) ): ?>
						height="<?= Sanitizer::encodeAttribute( $row['dimensions']['h'] ); ?>"
					<? endif; ?>
					<? if ( $row['isVideo'] == true ): ?>
						data-video-name="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>"
						data-video-key="<?= Sanitizer::encodeAttribute( urlencode( $row['key'] ) ); ?>"
					<? else: ?>
						data-image-name="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>"
						data-image-key="<?= Sanitizer::encodeAttribute( urlencode( $row['key'] ) ); ?>"
					<? endif; ?>
				/>
			</a>
		</span>
	<? endif; ?>
	<div class="title">
		<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>"
		   class="<?= Sanitizer::encodeAttribute( $row['class'] ); ?>"
		   title="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>">
			<?= htmlspecialchars( $row['title'] ); ?>
		</a>
	</div>
	<div class="title bigger">
		<? if ( !empty( $row['targetUrl'] ) && !empty( $row['targetText'] ) ): ?>
			Posted in: <a href="<?= Sanitizer::encodeAttribute( $row['targetUrl'] ); ?>"
						  title="<?= Sanitizer::encodeAttribute( $row['targetText'] ); ?>">
				<?= htmlspecialchars( $row['targetText'] ); ?>
			</a>
		<? endif; ?>
	</div>
</div>
