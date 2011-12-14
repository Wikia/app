<!-- <p><strong>Search Wikia</strong></p>-->
<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
	<input type="text" name="query" value="<?=$query;?>" /><a class="wikia-button" id="search-v2-button">Search</a><br />
	<input type="checkbox" name="crossWikia" value="1" /> Search all of Wikia
</form>
<br />
<?php if( $results !== false ): ?>
	<?php if( count( $results ) ): ?>
		<strong>Search results:</strong>&nbsp;<strong><?= $results->start; ?> - <?= (($results->start+$resultsPerPage) < $results->found) ? ($results->start+$resultsPerPage) : $results->found; ?></strong> of <strong><?= $results->found; ?></strong> document(s)<br />
		<?= $paginationLinks; ?>
		<?php foreach( $results->hit as $hit ): ?>
			<strong><a href="<?= $hit->data->url; ?>"><?=$hit->data->title;?></a></strong><br />
			<div style="width: 50%">
				<?= substr( $hit->data->text, 0, 250 ); ?>...
			</div>
			<a href="<?= $hit->data->url; ?>"><?=$hit->data->url;?></a><br />
			<br />
			<?php ?>
		<?php endforeach; ?>
		<?= $paginationLinks; ?>
	<?php else: ?>
		<i>No results.</i>
	<?php endif; ?>
<?php endif; ?>
