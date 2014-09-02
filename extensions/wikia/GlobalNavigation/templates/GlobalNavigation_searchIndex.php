<div class="search-form-wrapper">
	<form action="<?= $defaultSearchUrl; ?>" class="search-form" id="search-form" method="get">
		<span class="search-label-bold table-cell"><?= wfMessage( 'global-navigation-search-label' )->text(); ?></span>
		<div class="search-select-wrapper table-cell">
			<? if (empty($disableLocalSearchOptions)): ?>
			<div class="search-select-overlay">
				<span class="search-label-inline" id="search-label-inline"><?= $defaultSearchMessage; ?></span>
				<img class="chevron" id="search-form-chevron" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"/>
			</div>
			<select class="search-select" id="search-select">
				<option value="local"  selected="selected" data-search-url="<?= $localSearchUrl; ?>"><?= wfMessage( 'global-navigation-local-search' )->text(); ?></option>
				<option value="global" data-search-url="<?= $globalSearchUrl; ?>"><?= wfMessage( 'global-navigation-global-search' )->text(); ?></option>
			</select>
			<? else: ?>
				<div class="search-select-overlay">
					<span class="search-label-inline" id="search-label-inline"><?= wfMessage( 'global-navigation-global-search' )->text(); ?></span>
				</div>
			<? endif ?>
		</div>
		<div class="global-nav-search-input-wrapper table-cell">
			<input accesskey="f" autocomplete="off" class="search-input" name="search" type="text" value="<?= $query; ?>"/>
			<input name="fulltext" type="hidden" value="Search"/>
			<input disabled id="search-input-resultLang" type="hidden" name="resultLang" value="<?= $lang; ?>"/>
			<button class="search-submit" type="submit"></button>
		</div>
	</form>
</div>
