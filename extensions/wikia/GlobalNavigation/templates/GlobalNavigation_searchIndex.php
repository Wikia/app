<div class="search-form-wrapper">
	<form action="<?= $defaultSearchUrl; ?>" class="search-form" id="searchForm" method="get">
		<div class="global-nav-search-input-wrapper">
			<div class="search-select-wrapper">
				<div class="search-select-underlay">
					<button class="search-submit"></button>
					<? if (empty($disableLocalSearchOptions)): ?>
							<img class="chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
							<select class="search-select" id="searchSelect">
								<option value="local" selected="selected" data-placeholder="<?= Sanitizer::encodeAttribute($localSearchPlaceholder); ?>" data-search-url="<?= Sanitizer::encodeAttribute( $localSearchUrl ); ?>"><?= wfMessage( 'global-navigation-local-search' )->escaped(); ?></option>
								<option value="global" data-placeholder="<?=wfMessage( 'global-navigation-global-search' )->escaped(); ?>" data-search-url="<?= Sanitizer::encodeAttribute( $globalSearchUrl ); ?>"><?= wfMessage( 'global-navigation-global-search' )->escaped(); ?></option>
							</select>
					<? endif ?>
				</div>
			</div>
			<input id="searchInput" accesskey="f" autocomplete="off" class="search-input" name="search" placeholder="<?= Sanitizer::encodeAttribute($defaultSearchPlaceholder); ?>" type="text" value="<?= Sanitizer::encodeAttribute( $query ); ?>"/>
			<input name="fulltext" type="hidden" value="<?= Sanitizer::encodeAttribute( $fulltext ) ?>"/>
			<input disabled id="searchInputResultLang" type="hidden" name="resultsLang" value="<?= Sanitizer::encodeAttribute( $lang ); ?>"/>
		</div>
	</form>
</div>
