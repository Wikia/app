<nav class="article-navigation multiple-share">
	<ul>
		<li>
			<span class="nav-icon toc" id="articleNavToc">&#xF000;</span>
		</li>
		<li>
			<span class="nav-icon edit" id="articleNavEdit">&#xF001;</span>
		</li>
		<li>
			<span class="nav-icon settings" id="articleNavSettings">&#xF002;</span>
		</li>
		<? if ( false ): // disable this for now ?>
		<li data-share-type="single">
			<span class="nav-icon share" id="articleNavShare">&#xF006;</span>
		</li>
		<? endif; ?>
		<? foreach ($shareData as $share): ?>
			<li data-share-type="multiple">
				<span class="nav-icon share-<?= $share['name'] ?>" id="articleNavShare<?= $share['name_cased'] ?>">
					<a class="share-link" href="<?= $share['full_url'] ?>" target="_blank" title="<?= $share['title'] ?>" data-share-name="<?= $share['name'];?>"><?= $share['icon'] ?></a>
				</span>
			</li>
		<? endforeach; ?>
	</ul>
</nav>
