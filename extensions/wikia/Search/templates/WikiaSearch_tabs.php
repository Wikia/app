<ul class="search-tabs grid-1 alpha">
	<?php foreach($searchProfiles as $profileId => $profile): ?>
		<? if( $profileId == SEARCH_PROFILE_ADVANCED) {
			continue;
		} ?>
		<?php $tooltipParam = isset( $profile['namespace-messages'] ) ? $wg->Lang->commaList( $profile['namespace-messages'] ) : null; ?>
		<li class="<?=($activeTab == $profileId) ? 'selected' : 'normal';?>">
			<?= $app->renderView( 'WikiaSearch', 'advancedTabLink', array(
				'term' => $bareterm,
				'namespaces' => $profile['namespaces'],
				'label' => wfMsg( $profile['message'] ),
				'tooltip' => wfMsg( $profile['tooltip'], $tooltipParam ),
				'redirs' => $redirs,
				'params' => isset( $profile['parameters'] ) ? $profile['parameters'] + array('fulltext'=>'Search') : array('fulltext'=>'Search') ) );
			?>
			<? if( $activeTab == $profileId && $profile['namespaces'][0] == '6' ) { ?>
				<div class="search-filter-sort">
					<p><?= wfMessage('wikiasearch-filter-options-label') ?>:</p>
					<ul>
						<li><input type="checkbox" /><?= wfMessage('wikiasearch-filter-all') ?></li>
						<li>
							<input type="checkbox" /><?= wfMessage('wikiasearch-filter-category') ?>
							<select name="filter[]">
								<option value="cat_videogames"><?= wfMessage('hub-Gaming') ?></option>
								<option value="cat_entertainment"><?= wfMessage('hub-Entertainment') ?></option>
								<option value="cat_lifestyle"><?= wfMessage('hub-Lifestyle') ?></option>
							</select>
						</li>
						<li><input type="checkbox" name="filter[]" value="is_hd" /><?= wfMessage('wikiasearch-filter-hd') ?></li>
						<li><input type="checkbox" name="filter[]" value="is_photo" /><?= wfMessage('wikiasearch-filter-photos') ?></li>
						<li><input type="checkbox" name="filter[]" value="is_video" /><?= wfMessage('wikiasearch-filter-videos') ?></li>
					</ul>
					<p><?= wfMessage('wikiasearch-sort-options-label') ?>:</p>
					<select>
						<option><?= wfMessage('wikiasearch-sort-relevancy') ?></option>
						<option><?= wfMessage('wikiasearch-sort-publish-date') ?></option>
						<option><?= wfMessage('wikiasearch-sort-duration') ?></option>
					</select>
					
				</div>
			
			<? } ?>
		</li>
	<?php endforeach; ?>
</ul>