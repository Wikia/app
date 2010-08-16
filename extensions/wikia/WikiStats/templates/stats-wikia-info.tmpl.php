<!-- WIKI's INFORMATION -->
<fieldset style="margin: -50px 2px 0px 0px; padding: 0px 10px; width: 30%; position:absolute">
<legend><?=wfMsg("wikistats_wikia_information")?></legend>
<div class="ws-wikia-main-info">
	<ul>
		<li><strong><?= wfMsg('wikistats_wikiname')?></strong> <?= @$oWikia->city_title ?> ( <strong><?= wfMsg('wikistats_wikiid')?></strong> <?= (!empty($cityId)) ? $cityId : " - " ?> ) </li>
		<li><strong><?= wfMsg('wikistats_wikiurl')?></strong> <?= @$oWikia->city_url ?> </li>
		<li><strong><?= wfMsg('wikistats_wikicreated')?></strong> <?= @$oWikia->city_created_txt ?> </li>
	</ul>
	<ul>
		<li>
			<strong><?= wfMsg('wikistats_wikilang')?></strong> <?= @$oWikia->city_lang ?>
		</li>
		<li><strong><?= wfMsg('wikistats_wikicategory')?></strong> <?= @$oWikia->category->cat_name ?>
		</li>
	</ul>
</div>
</fieldset>
