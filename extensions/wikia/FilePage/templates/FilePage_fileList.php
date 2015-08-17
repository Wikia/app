<? foreach($fileList as $fileUsage): ?>
	<li class="page-listing">
		<div class="grid-1 alpha">
			<a class="page-listing-image" href="<?= $fileUsage['url'] ?>">
				<img src="<?= empty($fileUsage['imageUrl']) ? wfBlankImgUrl() : $fileUsage['imageUrl'] ?>" <? if(empty($fileUsage['imageUrl'])): ?> class="no-image" <? endif; ?>>
			</a>
		</div>
		<div class="grid-3">
			<h3 class="page-listing-title"><a href="<?= $fileUsage['url'] ?>"><?= $fileUsage['titleText'] ?></a></h3>
			<? if($type === 'global'): ?>
				<a href="<?= $fileUsage['wikiUrl'] ?>" class="page-listing-wiki"><?= $fileUsage['wiki'] ?></a>
			<? endif; ?>
			<p class="page-listing-snippet">
				<?= htmlspecialchars($fileUsage['snippet']) ?>
			</p>
		</div>
	</li>
<? endforeach; ?>