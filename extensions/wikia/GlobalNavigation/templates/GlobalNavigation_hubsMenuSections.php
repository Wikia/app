<? foreach( $menuSections as $sections ): ?>
	<div class="hub-menu-section <?= $sections['specialAttr'] ?>-links active">
		<div class="hub-menu-columns">
			<? if ( array_key_exists( 'children', $sections ) ) : ?>
				<? foreach( $sections['children'] as $category ): ?>
					<strong><?= $category['text'] ?></strong>
					<? if ( array_key_exists( 'children', $category ) ) : ?>
						<ul>
							<? foreach( $category['children'] as $node ): ?>
								<li>
									<a href="<?= $node['href'] ?>"><?= $node['text'] ?></a>
								</li>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				<? endforeach; ?>
			<? endif; ?>
		</div>
		<a class="more" href="<?= $sections['href']; ?>"><?= wfMessage('global-navigation-hubs-menu-more-of', $sections['text'])->parse(); ?></a>
	</div>
<? endforeach; ?>
