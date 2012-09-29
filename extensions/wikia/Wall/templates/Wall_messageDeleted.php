<header id="WikiaPageHeader" class="WikiaPageHeader separator">
	<h1><?= wfMsg('wall-deleted-msg-pagetitle'); ?></h1>
</header>
<div class="WikiaArticle" id="WikiaArticle">
	<?= wfMsg('wall-deleted-msg-text'); ?>
	<?php if(!empty($wallUrl)): ?>
		<a href="<?= $wallUrl ?>"><?=  $returnTo ?></a>
	<?php endif; ?>
	<?php if($showViewLink): ?>
		<p>
			<a href="<?php echo $viewUrl; ?>" >
				<?php echo wfMsg('wall-deleted-msg-view'); ?>
			</a>
		</p> 
	<?php endif; ?>
</div>
