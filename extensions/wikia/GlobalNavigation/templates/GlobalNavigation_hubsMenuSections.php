<? foreach( $menuSections as $sections ): ?>
	<div class="hub-menu-section <?= $sections['specialAttr'] ?>-links active">
		<div class="hub-menu-columns">
			<? foreach( $sections['children'] as $category ): ?>
				<strong><?= $category['text'] ?></strong>
				<ul>
					<? foreach( $category['children'] as $node ): ?>
						<li>
							<a href="<?= $node['href'] ?>"><?= $node['text'] ?></a>
						</li>
					<? endforeach; ?>
				</ul>
			<? endforeach; ?>
		</div>
		<a class="more" href="<?= $sections['href']; ?>"><?= wfMessage('global-navigation-hubs-menu-more-of', $sections['text'])->parse(); ?></a>
	</div>
<? endforeach; ?>
