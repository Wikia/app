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
						<? for($i = 0; $i < 5; $i++): ?>
							<li><input type="checkbox" />Label</li>
						<? endfor; ?>
					</ul>
					<p><?= wfMessage('wikiasearch-sort-options-label') ?>:</p>
					<select><option>Test</option></select>
					
				</div>
			
			<? } ?>
		</li>
	<?php endforeach; ?>
</ul>