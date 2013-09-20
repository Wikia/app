<table class="wiki-list wikitable" width="100%">
	<thead>
		<tr>
			<th><?= wfMessage('manage-wikia-home-wiki-list-id')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-vertical')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-headline')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-blocked')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-promoted')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-official')->text() ?></th>
			<th><?= wfMessage('manage-wikia-home-wiki-list-collection')->text() ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $wiki): ?>
		<tr>
			<td>
				<?= $wiki->city_id ?>
			</td>
			<td>
				<?= $verticals[$wiki->city_vertical] ?>
			</td>
			<td>
				<?= $wiki->city_title ?>
			</td>
			<td>
				<a href="#" class="status-blocked" data-id="<?= $wiki->city_id; ?>" data-vertical="<?= $wiki->city_vertical ?>" data-flags="<?= CityVisualization::isBlockedWiki($wiki->city_flags) ?>" data-flag-type="<?= WikisModel::FLAG_BLOCKED?>">
					<?= (CityVisualization::isBlockedWiki($wiki->city_flags)) ? wfMessage('manage-wikia-home-wiki-list-blocked-yes')->text() : wfMessage('manage-wikia-home-wiki-list-blocked-no')->text() ?>
				</a>
			</td>
			<td>
				<a href="#" class="status-promoted" data-id="<?= $wiki->city_id; ?>" data-vertical="<?= $wiki->city_vertical ?>" data-flags="<?= CityVisualization::isPromotedWiki($wiki->city_flags) ?>" data-flag-type="<?= WikisModel::FLAG_PROMOTED?>">
					<?= (CityVisualization::isPromotedWiki($wiki->city_flags)) ? wfMessage('manage-wikia-home-wiki-list-promoted-yes')->text() : wfMessage('manage-wikia-home-wiki-list-promoted-no')->text() ?>
				</a>
			</td>
			<td>
				<a href="#" class="status-official" data-id="<?= $wiki->city_id; ?>" data-vertical="<?= $wiki->city_vertical ?>" data-flags="<?= CityVisualization::isOfficialWiki($wiki->city_flags) ?>" data-flag-type="<?= WikisModel::FLAG_OFFICIAL?>">
					<?= (CityVisualization::isOfficialWiki($wiki->city_flags)) ? wfMessage('manage-wikia-home-wiki-list-official-yes')->text() : wfMessage('manage-wikia-home-wiki-list-official-no')->text() ?>
				</a>
			</td>
			<td>
				<? $i = 1;?>
				<? foreach ($collections as $collection): ?>
					<label><input type="checkbox" class="collection-checkbox" value="<?= $collection['id']?>" <? if (in_array($collection['id'], $wiki->collections)): ?> checked="checked"<? endif ?> data-id="<?= $wiki->city_id ?>"/> <?= $collection['name']?></label><br/>
					<? $i++ ?>
				<? endforeach ?>
				<? for ($i=$i; $i <= WikiaCollectionsModel::COLLECTIONS_COUNT; $i++): ?>
					<label class="alternative"><input type="checkbox" disabled="disabled"/> <?=wfMessage('manage-wikia-home-wiki-list-disabled-collection')->text();?></label><br/>
				<? endfor ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if( !empty($pagination) ): ?>
	<?= $pagination; ?>
<?php endif; ?>
