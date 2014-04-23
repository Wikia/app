<?
/**
 * @var $fromAjax
 * @var $data
 * @var $paginator
 */
?>
<? if ( !$fromAjax ) { ?>
	<div id="mw-images">
		<h2><?= wfMsg( 'category-exhibition-media-header', htmlspecialchars( $category ) ) ?></h2>

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
								<a href="<?= $row['url'] ?>"
								   data-ref="<?= $row['data-ref']; ?>"
								   class="<?= $row['class']; ?>"
								   title="<?= htmlspecialchars( $row['title'] ); ?>">
									<? if ( $row['isVideo'] == true ) { ?>
										<span class="play-circle"></span>
									<? } ?>
									<img src="<?= $row['img'] ?>" alt="<?= htmlspecialchars( $row['title'] ) ?>"<?
									if ( !empty( $row['dimensions']['w'] ) ) {
										echo ' width="' . $row['dimensions']['w'] . '"';
									}
									if ( !empty( $row['dimensions']['h'] ) ) {
										echo ' height="' . $row['dimensions']['h'] . '"';
									}
									if ( $row['isVideo'] == true ) {
										echo ' data-video-name=' . htmlspecialchars( $row['title'] );
										echo ' data-video-key=' . htmlspecialchars( urlencode( $row['key'] ) );
									} else {
										echo ' data-image-name=' . htmlspecialchars( $row['title'] );
										echo ' data-image-key=' . htmlspecialchars( urlencode( $row['key'] ) );
									}
									?> />
								</a>
							</span>
						<? } ?>
						<div class="title">
							<a href="<?= $row['url'] ?>"
							   class="<?= $row['class']; ?>"
							   title="<?= htmlspecialchars( $row['title'] ); ?>">
								<?= htmlspecialchars( $row['title'] ); ?>
							</a>
						</div>
						<div class="title bigger">
							<? if ( !empty( $row['targetUrl'] ) && !empty( $row['targetText'] ) ) { ?>
								Posted in: <a href="<?= $row['targetUrl'] ?>" title="<?=$row['targetText']?>">
									<?=$row['targetText'] ?>
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