<? if( !empty($wikiInfo['images']) ): ?>
<header class="preview-header">
	<span class="hotNew">
		<? if($wikiInfo['official'] == 1): ?>
			<strong class="official"></strong>
		<? endif; ?>
	</span>
	<h1><?= htmlspecialchars($wikiInfo['name']) ?></h1>
	<ul class="stats">
		<? if (!empty($wg->EnableWAMPageExt)): ?>
			<li class="stat wam">
				<a href="<?=$wamUrl?>"<? if (is_null($wikiWamScore)): ?> class="inactive"<? endif ?>>
					<?= wfMessage('wikiahome-preview-stats-wam')->params( isset($wikiWamScore) ? $wg->Lang->formatNum($wikiWamScore) : wfMessage('wikiahome-preview-stats-wam-empty-label')->text())->parse() ?>
				</a>
			</li>
		<? endif ?>
		<li class="stat">
			<?= wfMessage('wikiahome-preview-stats-page')->params(empty($wikiStats['articles']) ? 0 : $wikiStats['articles'])->parse() ?>
		</li>
		<li class="stat">
			<?= wfMessage('wikiahome-preview-stats-photos')->params(empty($wikiStats['images']) ? 0 : $wikiStats['images'])->parse() ?>
		</li>
		<li class="stat">
			<?= wfMessage('wikiahome-preview-stats-videos')->params(empty($wikiStats['videos']) ? 0 : $wikiStats['videos'])->parse() ?>
		</li>
	</ul>
</header>
<div class="preview-aside">
	<div class="wiki-description">
		<h2 class="wiki-welcome-title"><?= wfMsg('wikiahome-preview-description-heading', htmlspecialchars($wikiInfo['headline'])) ?></h2>
		<?= htmlspecialchars($wikiInfo['description']) ?>
	</div>
	<a href="<?= $wikiInfo['url'] ?>" class="button secondary big visit">
		<img class="preview-grey" src="<?= $wg->BlankImgUrl; ?>" />
		<?= wfMsg('wikiahome-preview-go-to-wiki-label') ?>
	</a>
</div>
<div class="preview-body">
	<?= F::app()->getView('WikiaHomePage', 'renderPreviewUser', array(
		'userType' => 'admins',
		'users' => $wikiAdminAvatars,
		'limit' => WikiaHomePageHelper::LIMIT_ADMIN_AVATARS
	))->render() ?>
	<?= F::app()->getView('WikiaHomePage', 'renderPreviewUser', array(
		'userType' => 'contributors',
		'users' => $wikiTopEditorAvatars,
		'limit' => WikiaHomePageHelper::LIMIT_TOP_EDITOR_AVATARS
	))->render() ?>
	<div style="clear:left"><!-- Please leave clear:left here for spacing --></div>
	<a href="<?= $wikiInfo['url']; ?>">
		<img src="<?= $wikiMainImageUrl; ?>" alt="<?= $wikiInfo['name'] ?>" class="hero-image">
	</a>
	<?= $imagesSlider; ?>
</div>
<? else: ?>
	<?= wfMsg('wikiahome-preview-error') ?>
<? endif; ?>