<section class="SpecialPageWrapper">

<? if ($wg->enableMiniEditorExt): echo $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
	'attributes' => array( 'data-min-height' => 200 )
))->render(); endif; ?>

	<textarea id="SpecialMiniEditor" placeholder="<?= wfMsg('minieditor-placeholder-message') ?>"></textarea>

<? if ($wg->enableMiniEditorExt): echo $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); endif; ?>

</section>