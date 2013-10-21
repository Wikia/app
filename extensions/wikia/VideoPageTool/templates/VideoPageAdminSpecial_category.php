<form class="WikiaForm vpt-form latest-video-form" method="post">

	<? for( $x = 1; $x <= count($categories); $x++ ): ?>

		<?
			$category = $categories[ $x ];
		?>

		<div class="form-box latest-video with-nav">
			<span class="count"><?= $x ?>.</span>
			<div class="input-group border">
				<label for="category-name-<?= $x ?>"><?= wfMessage( 'videopagetool-category-label-name' )->plain() ?></label>
				<input
					class="category-name"
					id="category-name-<?= $x ?>"
					type="text"
					name="categoryName[]"
					placeholder="<?= wfMessage( 'videopagetool-category-name-placeholder' )->plain() ?>"
					value="<?= $category[ 'categoryName' ] ?>">
			</div>
			<button class="search-button"><?= wfMessage( 'videopagetool-button-search' )->plain() ?></button>

			<div class="input-group">
				<label for="display-title-<?= $x ?>"><?= wfMessage( 'videopagetool-category-label-display-title' )->plain() ?></label>
				<input
					class="display-title"
					id="display-title-<?= $x ?>"
					type="text"
					name="displayTitle[]"
					placeholder="<?= wfMessage( 'videopagetool-category-display-title-placeholder' )->plain() ?>"
					value="<?= $category[ 'displayTitle' ] ?>">
			</div>
			<button class="secondary navigation nav-up">
				<img class="chevron chevron-up" src="<?= $wg->BlankImgUrl ?>">
			</button>
			<button class="secondary navigation nav-down">
				<img class="chevron chevron-down" src="<?= $wg->BlankImgUrl ?>">
			</button>
		</div>
		<a class="preview" href="#"><span></span><?= wfMessage( 'videopagetool-category-preview' )->plain() ?><span></span></a>

	<? endfor; ?>

	<input type="hidden" value="<?= $date ?>" name="date">
	<input type="hidden" value="<?= $language ?>" name="language">

	<div class="submits">
		<button type="submit"><?= wfMessage( 'videopagetool-button-save' )->text() ?></button>
		<button class="secondary reset"><?= wfMessage( 'videopagetool-button-clear' )->text() ?></button>
	</div>

</form>
