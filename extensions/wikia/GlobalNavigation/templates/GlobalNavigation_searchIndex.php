<div class="search-form-wrapper">
	<form action="<?= $defaultSearchUrl; ?>" class="search-form" id="searchForm" method="get">
		<span class="search-label-bold table-cell"><?= wfMessage( 'global-navigation-search-label' )->escaped(); ?></span>
		<div class="search-select-wrapper table-cell">
			<? if (empty($disableLocalSearchOptions)): ?>
				<div class="search-select-underlay">
					<span class="search-label-inline" id="searchLabelInline"><?= $defaultSearchMessage; ?></span>
					<img class="chevron" id="searchFormChevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
					<select class="search-select" id="searchSelect">
						<option value="local" selected="selected" data-search-url="<?= Sanitizer::encodeAttribute( $localSearchUrl ); ?>"><?= wfMessage( 'global-navigation-local-search' )->escaped(); ?></option>
						<option value="global" data-search-url="<?= Sanitizer::encodeAttribute( $globalSearchUrl ); ?>"><?= wfMessage( 'global-navigation-global-search' )->escaped(); ?></option>
					</select>
				</div>
			<? else: ?>
				<div class="search-select-underlay">
					<span class="search-label-inline" id="search-label-inline"><?= wfMessage( 'global-navigation-global-search' )->escaped(); ?></span>
				</div>
			<? endif ?>
		</div>
		<div class="global-nav-search-input-wrapper table-cell">
			<input id="searchInput" accesskey="f" autocomplete="off" class="search-input" name="search" type="text" value="<?= Sanitizer::encodeAttribute( $query ); ?>"/>
			<input name="fulltext" type="hidden" value="<?= Sanitizer::encodeAttribute( $fulltext ) ?>"/>
			<input disabled id="searchInputResultLang" type="hidden" name="resultsLang" value="<?= Sanitizer::encodeAttribute( $lang ); ?>"/>
			<button class="search-submit" type="submit"></button>
		</div>
	</form>
</div>
