<section class="SpecialPageWrapper">

<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
	'attributes' => array(
		'data-min-height' => 200,
		'data-max-height' => 400
	)
))->render(); ?>

	<textarea id="SpecialMiniEditor" placeholder="<?= wfMsg('minieditor-placeholder-message') ?>"></textarea>

<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>

</section>