<section class=WikiFeatures id=WikiFeatures>
    <ul class=features>
		<?=
		$app->getView( 'WikiFeaturesSpecial', 'feature',
			array(
				'feature' => array(
					'name' => 'wgGameGuidesContentForAdmins',
					'enabled' => $enabled,
				),
				'editable' => true
			)
		)
		?>
    </ul>
</section>
<div id=DeactivateDialog class=DeactivateDialog>
    <h1><?= $wf->Msg('wikifeatures-deactivate-heading') ?></h1>
    <p><?= $wf->Msg('wikifeatures-deactivate-notification') ?></p>
    <nav>
        <button class="cancel secondary"><?= $wf->Msg('wikifeatures-deactivate-cancel-button') ?></button>
        <button class=confirm><?= $wf->Msg('wikifeatures-deactivate-confirm-button') ?></button>
    </nav>
</div>