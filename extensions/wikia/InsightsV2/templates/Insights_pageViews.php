<div class="insights-header-sorting">
	<label for="sort"><?= wfMessage( 'insights-sort-label' )->escaped() ?></label>
	<select class="insights-sorting" name="sort">
		<?php foreach( $dropdown as $sortType => $sortLabel ): ?>
			<option value="<?= Sanitizer::encodeAttribute( $sortType ) ?>" <?php if ( $sortType == $current ): ?>selected<?php endif ?>><?= htmlspecialchars( $sortLabel ) ?></option>
		<?php endforeach ?>
	</select>
</div>
