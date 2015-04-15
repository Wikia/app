<div class="insights-container-nav">
	<ul class="insights-nav-list">
		<? foreach( InsightsModel::$insightsPages as $key => $subpage ) : ?>
			<li class="insights-nav-item">
				<a href="<?= SpecialPage::getTitleFor( 'Insights', $key )->getLocalURL() ?>" class="insights-nav-link">
					<?= wfMessage( 'insights-list-' . $key . '-subtitle' )->parse() ?>
				</a>
			</li>
		<? endforeach; ?>
	</ul>
</div>
<div class="insights-container-main">
	<div class="insights-header clearfix">
		<img src="<?= $iconUrl ?>" alt="<?= $subtitle ?>" class="insights-header-icon"/>
		<h2 class="insights-header-subtitle"><?= $subtitle ?></h2>
		<p class="insights-header-description"><?= $description ?></p>
	</div>
	<table class="insights-list">
		<? foreach( $list as $item ): ?>
			<tr>
				<td class="item-number"><?= ++$offset ?></td>
				<td><a href="<?= $item['link'] ?>"><?= $item['title'] ?></a></td>
				<td><?= wfMessage( 'insights-last-edit' )->rawParams(
						Xml::element('a', [
							'href' => $item['revision']['userpage']
						],
							$item['revision']['username']
						),
						date('F j, Y', $item['revision']['timestamp'])
					)->escaped() ?></td>
				<td># of views</td>
			</tr>
		<? endforeach ?>
	</table>
</div>