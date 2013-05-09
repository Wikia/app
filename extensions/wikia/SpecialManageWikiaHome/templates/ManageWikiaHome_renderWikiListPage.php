<table class="wiki-list wikitable" width="100%">
	<thead>
		<tr>
			<th><?= wfMsg('manage-wikia-home-wiki-list-id') ?></th>
			<th><?= wfMsg('manage-wikia-home-wiki-list-vertical') ?></th>
			<th><?= wfMsg('manage-wikia-home-wiki-list-headline') ?></th>
			<th><?= wfMsg('manage-wikia-home-wiki-list-blocked') ?></th>
			<th><?= wfMsg('manage-wikia-home-wiki-list-promoted') ?></th>
			<th><?= wfMsg('manage-wikia-home-wiki-list-collection') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $wiki): ?>
		<tr>
			<td>
				<?= $wiki->city_id ?>
			</td>
			<td>
				<?= $wiki->city_vertical ?>
			</td>
			<td>
				<?= $wiki->city_title ?>
			</td>
			<td>
				<a href="#" class="status-blocked" data-id="<?= $wiki->city_id; ?>" data-vertical="<?= $wiki->city_vertical ?>" data-flags="<?= CityVisualization::isBlockedWiki($wiki->city_flags) ?>">
					<?= (CityVisualization::isBlockedWiki($wiki->city_flags)) ? wfMsg('manage-wikia-home-wiki-list-blocked-yes') : wfMsg('manage-wikia-home-wiki-list-blocked-no') ?>
				</a>
			</td>
			<td>
				<a href="#" class="status-promoted" data-id="<?= $wiki->city_id; ?>" data-vertical="<?= $wiki->city_vertical ?>" data-flags="<?= CityVisualization::isPromotedWiki($wiki->city_flags) ?>">
					<?= (CityVisualization::isPromotedWiki($wiki->city_flags)) ? wfMsg('manage-wikia-home-wiki-list-blocked-yes') : wfMsg('manage-wikia-home-wiki-list-blocked-no') ?>
				</a>
			</td>
			<td>
				<? $i = 1;?>
				<? foreach ($collections as $collection): ?>
					<label><input type="checkbox" class="collection-checkbox" value="<?= $collection['id']?>" <? if (in_array($collection['id'], $wiki->collections)): ?> checked="checked"<? endif ?>/> <?= $collection['name']?></label>
					<? $i++ ?>
				<? endforeach ?>
				<? for ($i=$i; $i <= WikiaCollectionsModel::COLLECTIONS_COUNT; $i++): ?>
					<label class="alternative"><input type="checkbox" disabled="disabled"/> <?=wfMessage('manage-wikia-home-wiki-list-disabled-collection')->text();?></label>
				<? endfor ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if( !empty($pagination) ): ?>
	<?= $pagination; ?>
<?php endif; ?>