<section class="SpecialPageWrapper">
	<div id="MiniEditorNew" class="Instance">
		<h3><?= wfMsg( 'minieditor-new-heading' ) ?></h3>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 200,
				'data-max-height' => 400
			)
		))->render(); ?>

		<textarea id="UniqueIdTest" class="ElementToReplace" placeholder="<?= wfMsg( 'minieditor-placeholder-new' ) ?>"></textarea>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>
	</div>

	<div id="MiniEditorEdit" class="Instance">
		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 100,
				'data-max-height' => 400
			)
		))->render(); ?>

		<div class="ElementToReplace">
			<p><span style="font-weight: bold;"><?= wfMsg( 'minieditor-message-edit' ) ?></span></p>
		</div>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>
	</div>

	<div id="MiniEditorReply" class="Instance">
		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 100,
				'data-max-height' => 400
			)
		))->render(); ?>
		
		<textarea class="ElementToReplace" placeholder="<?= wfMsg( 'minieditor-placeholder-reply' ) ?>"></textarea>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>
	</div>
</section>