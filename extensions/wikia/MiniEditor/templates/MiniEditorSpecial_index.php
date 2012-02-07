<section class="SpecialPageWrapper">
	<div id="MiniEditorNew" class="Instance">
		<h3><?= wfMsg( 'minieditor-new-heading' ) ?></h3>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 200,
				'data-max-height' => 400
			)
		))->render(); ?>

		<textarea id="MiniEditorOne" class="TextareaToReplace" placeholder="<?= wfMsg( 'minieditor-placeholder-new' ) ?>"></textarea>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>

		<div id="MiniEditorOneButtons" class="MiniEditorButtons">
			<button type="button">Post</button>
		</div>
	</div>

	<div id="MiniEditorEdit" class="Instance">
		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 100,
				'data-max-height' => 400
			)
		))->render(); ?>

		<div id="MiniEditorTwo" class="DivToReplace">
			<p><span style="font-weight: bold;"><?= wfMsg( 'minieditor-message-edit' ) ?></span></p>
		</div>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>
		
		<div id="MiniEditorTwoButtons" class="MiniEditorButtons">
			<button type="button">Edit</button>
		</div>
	</div>
	<div class="buttons">
		<div class="wikia-menu-button contribute secondary" id="MiniEditorEditButton">Edit</div>
	</div>

	<div id="MiniEditorReply" class="Instance">
		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_Begin', array(
			'attributes' => array(
				'data-min-height' => 100,
				'data-max-height' => 400
			)
		))->render(); ?>

		<textarea id="MiniEditorThree" class="TextareaToReplace" placeholder="<?= wfMsg( 'minieditor-placeholder-reply' ) ?>"></textarea>

		<?= $app->getView( 'MiniEditorController', 'EditorWrapper_End' )->render(); ?>

		<div id="MiniEditorThreeButtons" class="MiniEditorButtons">
			<button type="button">Reply</button>
		</div>
	</div>
</section>