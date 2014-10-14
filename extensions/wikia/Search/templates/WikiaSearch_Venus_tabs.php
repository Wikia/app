<div class="SearchTabsContainer">
	<ul class="SearchTabs row">
		<?php foreach($searchProfiles as $profileId => $profile): ?>
			<? if( $profileId == SEARCH_PROFILE_ADVANCED) {
				continue;
			} ?>
			<?php $tooltipParam = isset( $profile['namespace-messages'] ) ? $wg->Lang->commaList( $profile['namespace-messages'] ) : null; ?>
			<li <?=($activeTab == $profileId) ? 'class="selected"' : '';?>>
				<?= $app->renderView( 'WikiaSearch', 'advancedTabLink', array(
					'term' => $bareterm,
					'namespaces' => $profile['namespaces'],
					'label' => wfMsg( $profile['message'] ),
					'tooltip' => wfMsg( $profile['tooltip'], $tooltipParam ),
					'params' => isset( $profile['parameters'] ) ? $profile['parameters'] + array('fulltext'=>'Search') : array('fulltext'=>'Search') ) );
				?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
