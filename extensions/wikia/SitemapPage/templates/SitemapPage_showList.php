<div class="sitemap-page">
	<h1 class="showlist"><?= wfMessage('sitemap-page-header')->escaped() ?></h1>
	<table class="sitemap-showlist">
		<tr>
			<th><?= wfMessage( 'sitemap-page-wiki-title' )->escaped() ?></th>
			<th><?= wfMessage( 'sitemap-page-wiki-language' )->escaped() ?></th>
			<th><?= wfMessage( 'sitemap-page-wiki-vertical' )->escaped() ?></th>
			<th><?= wfMessage( 'sitemap-page-wiki-description' )->escaped() ?></th>
		</tr>
		<? foreach ( $wikis as $wiki ) { ?>
			<tr>
				<td><a class="title" href="<?= $wiki['url'] ?>"><?= $wiki['title'] ?></a></td>
				<td><?= $wiki['language'] ?></td>
				<td><?= $wiki['vertical'] ?></td>
				<td><?= empty( $wiki['description'] ) ? wfMessage( 'wikiasearch2-crosswiki-description', $wiki['title'] )->escaped() : $wiki['description'] ?></td>
			</tr>
		<? } ?>
	</table>
</div>
