<form id="LatestVideos" class="WikiaForm vpt-form latest-video-form" method="post">
	<p class="alternative"><?= wfMessage( 'videopagetool-category-instructions' )->escaped() ?></p>
	<? for( $x = 1; $x <= count($categories); $x++ ): ?>
		<? $category = $categories[ $x ]; ?>

		<div class="form-wrapper">
			<div class="form-box latest-video with-nav">
				<div class="autocomplete">
					<!-- empty element to be used for autocomplete -->
				</div>
				<span class="count"><?= $x ?>.</span>
				<div class="input-group border">
					<label for="category-name-<?= $x ?>"><?= wfMessage( 'videopagetool-category-label-name' )->escaped() ?></label>
					<input
						data-autocomplete
						autocomplete="off"
						class="category-name"
						id="category-name-<?= $x ?>"
						type="text"
						name="categoryName[]"
						placeholder="<?= wfMessage( 'videopagetool-category-name-placeholder' )->escaped() ?>"
						value="<?= Sanitizer::encodeAttribute( $category[ 'categoryName' ] ); ?>">
				</div>
				<button class="search-button">
					<?= wfMessage( 'videopagetool-button-search' )->escaped(); ?>
				</button>

				<div class="input-group">
					<label for="display-title-<?= $x ?>">
						<?= wfMessage( 'videopagetool-category-label-display-title' )->escaped(); ?>
					</label>
					<input
						class="display-title"
						id="display-title-<?= $x ?>"
						type="text"
						name="displayTitle[]"
						placeholder="<?= wfMessage( 'videopagetool-category-display-title-placeholder' )->escaped(); ?>"
						value="<?= Sanitizer::encodeAttribute( $category[ 'displayTitle' ] ); ?>">
				</div>
				<button class="secondary navigation nav-up">
					<img class="chevron chevron-up" src="<?= $wg->BlankImgUrl ?>">
				</button>
				<button class="secondary navigation nav-down">
					<img class="chevron chevron-down" src="<?= $wg->BlankImgUrl ?>">
				</button>
			</div>
			<div class="carousel-wrapper">
			</div>
			<a class="preview" href="#">
				<span></span>
				<?= wfMessage( 'videopagetool-category-preview' )->escaped(); ?>
				<span></span>
			</a>
		</div>

	<? endfor; ?>

	<input type="hidden" value="<?= Sanitizer::encodeAttribute( $date ); ?>" name="date">
	<input type="hidden" value="<?= Sanitizer::encodeAttribute( $language ); ?>" name="language">

	<div class="submits">
		<button type="submit">
			<?= wfMessage( 'videopagetool-button-save' )->escaped(); ?>
		</button>
		<button class="secondary reset">
			<?= wfMessage( 'videopagetool-button-clear' )->escaped(); ?>
		</button>
	</div>

</form>
