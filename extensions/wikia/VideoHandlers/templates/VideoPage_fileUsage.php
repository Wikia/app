<? if(!empty($fileList)): ?>
	<section class="page-listings">
		<h2>
			<?= $heading ?>
			<div class="page-list-pagination">
				<img src="<?= wfBlankImgUrl() ?>" class="arrow left disabled">
				<?= wfMessage('video-page-file-list-pagination', '<span class="page-list-current">1</span>', '<span class="page-list-pages">2</span>')->text() ?>
				<img src="<?= wfBlankImgUrl() ?>" class="arrow right">
			</div>
		</h2>
		<ul class="WikiaGrid">
			<? foreach($fileList as $fileUsage): ?>
				<li class="page-listing">
					<div class="grid-1 alpha">
						<a href="<?= $fileUsage['url'] ?>">
							<img src="<?= $fileUsage['imageUrl'] ?>" class="page-listing-image" height="90" width="160">
						</a>
					</div>
					<div class="grid-3">
						<h3 class="page-listing-title"><a href="<?= $fileUsage['url'] ?>"><?= $fileUsage['titleText'] ?></a></h3>
						<a href="<?= $fileUsage['wikiUrl'] ?>" class="page-listing-wiki"><?= $fileUsage['wiki'] ?></a>
						<p class="page-listing-snippet">
							<?= $fileUsage['snippet'] ?>
						</p>
					</div>
				</li>
			<? endforeach; ?>
		</ul>
	</section>
<? endif; ?>