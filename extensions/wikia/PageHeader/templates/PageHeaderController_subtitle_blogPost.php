<div class="page-header__subtitle-blog-post">
	<?= $avatar ?>
	<div class="page-header__blog-post-details">
		<a href="<?= $userPageUrl ?>"><?= $userName ?></a>
		<?= wfMessage( 'pipe-separator' )->escaped() ?>
		<?= $pageCreatedDate ?>
		<?= wfMessage( 'pipe-separator' )->escaped() ?>
		<a href="<?= $userBlogPageUrl ?>"><?= $userBlogPageText ?></a>
	</div>
</div>

