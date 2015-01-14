<?
/**
 * @var $fromAjax
 * @var $data
 * @var $paginator
 */
?>
<? if ( !$fromAjax ) { ?>
	<div id="mw-images">
		<h2><?= wfMessage( 'category-exhibition-media-header', $category )->escaped() ?></h2>

		<div class="category-gallery">
			<div class="category-gallery-holder">
				<div class="category-gallery-room1">
<? } ?>
				<? foreach ( $data as $row ) { ?>
					<div class="category-gallery-media ">
						<? if ( empty( $row['img'] ) ) { ?>
							<span class="category-gallery-placeholder"></span>
						<? } else { ?>
							<span class="category-gallery-item-image">
								<a href="<?= Sanitizer::encodeAttribute( $row['url'] ) ?>"
								   data-ref="<?= Sanitizer::encodeAttribute( $row['data-ref'] ); ?>"
								   class="<?= Sanitizer::encodeAttribute( $row['class'] ); ?>"
								   title="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>">
									<? if ( $row['isVideo'] == true ) { ?>
										<span class="play-circle"></span>
									<? } ?>
									<img src="<?= Sanitizer::encodeAttribute( $row['img'] ) ?>" alt="<?= Sanitizer::encodeAttribute( $row['title'] ) ?>"<?
									if ( !empty( $row['dimensions']['w'] ) ) {
										echo ' width="' . Sanitizer::encodeAttribute( $row['dimensions']['w'] ) . '"';
									}
									if ( !empty( $row['dimensions']['h'] ) ) {
										echo ' height="' . Sanitizer::encodeAttribute( $row['dimensions']['h'] ) . '"';
									}
									if ( $row['isVideo'] == true ) {
										echo ' data-video-name="' . Sanitizer::encodeAttribute( $row['title'] ) . '"';
										echo ' data-video-key="' . Sanitizer::encodeAttribute( urlencode( $row['key'] ) ) . '"';
									} else {
										echo ' data-image-name="' . Sanitizer::encodeAttribute( $row['title'] ) . '"';
										echo ' data-image-key="' . Sanitizer::encodeAttribute( urlencode( $row['key'] ) ) . '"';
									}
									?> />
								</a>
							</span>
						<? } ?>
						<div class="title">
							<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>"
							   class="<?= Sanitizer::encodeAttribute( $row['class'] ); ?>"
							   title="<?= Sanitizer::encodeAttribute( $row['title'] ); ?>">
								<?= htmlspecialchars( $row['title'] ); ?>
							</a>
						</div>
						<div class="title bigger">
							<? if ( !empty( $row['targetUrl'] ) && !empty( $row['targetText'] ) ) { ?>
								Posted in: <a href="<?= Sanitizer::encodeAttribute( $row['targetUrl'] ); ?>" title="<?= Sanitizer::encodeAttribute( $row['targetText'] ); ?>">
									<?= htmlspecialchars( $row['targetText'] ) ?>
								</a>
							<? } ?>
						</div>
					</div>
				<? } ?>

<? if ( !$fromAjax ) { ?>
				</div>
				<div class="category-gallery-room2"></div>
			</div>
			<div class="category-gallery-paginator"><?= $paginator; ?></div>
		</div>
	</div>
<? } ?>
