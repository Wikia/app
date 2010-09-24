<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<header>
		<? if ($wgSingleH1) { ?>
		<div class="headline-div"><?= wfMsg($titleMsg) ?></div>
		<? } else { ?>
		<h1><?= wfMsg($titleMsg) ?></h1>
		<? } ?>
		<? if ($mode=='RAIL') { ?>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
		<? } elseif ($mode=='FOOTER') { ?>
		<?= wfRenderModule('RandomWiki') ?>
		<? } ?>
	</header>
	<ul>
		<? for ($i=0; $i<$n_adslots; $i++) { ?>
		<li class="WikiaSpotlight item-<?= $i+1 ?>">
			<?= AdEngine::getInstance()->getPlaceHolderIframe($adslots[$i]) ?>
		</li>
		<? } ?>
	</ul>
</section>
