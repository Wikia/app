<div class="insights-header-sorting">
	<form class="insights-sorting-form" method="GET">
		<label for="sort"><?= wfMessage( 'insights-flags-filter-label' )->escaped(); ?></label>
		<select class="insights-sorting" name="flagTypeId" onchange="this.form.submit()">
			<?php
			foreach ( $flagTypes as $flagType ):
				$selected = ( $flagType['flag_type_id'] == $selectedFlagTypeId ) ? true : false;
			?>
				<option value="<?= $flagType['flag_type_id']; ?>" <?= $selected ? 'selected="selected"' : ''; ?>><?= Sanitizer::escapeHtmlAllowEntities( $flagType['flag_name'] ) ?></option>
			<?php
			endforeach;
			?>
		</select>
	</form>
</div>
