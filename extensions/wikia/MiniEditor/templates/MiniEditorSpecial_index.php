<section class="SpecialPageWrapper">
	<h3><?= wfMsg( 'minieditor-new-heading' ) ?></h3>
	<?= $app->getView( 'MiniEditorController', 'Header', array(
		'attributes' => array(
			'id' => 'New',
			'data-min-height' => 200,
			'data-max-height' => 400
		)
	))->render(); ?>
	<?= $app->getView( 'MiniEditorController', 'Editor_Header' )->render(); ?>
	<textarea class="body" placeholder="<?= wfMsg( 'minieditor-placeholder-new' ) ?>"></textarea>
	<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); ?>
	<div class="buttons" data-space-type="buttons">
		<button type="button">Post</button>
	</div>
	<?= $app->getView( 'MiniEditorController', 'Footer' )->render(); ?>
	<?= $app->getView( 'MiniEditorController', 'Header', array(
		'attributes' => array(
			'id' => 'Edit',
			'data-min-height' => 100,
			'data-max-height' => 400
		)
	))->render(); ?>
	<?= $app->getView( 'MiniEditorController', 'Editor_Header')->render(); ?>
	<div class="body">
		<p><span style="font-weight: bold;"><?= wfMsg( 'minieditor-message-edit' ) ?></span></p>
	</div>
	<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); ?>
	<div class="buttons" data-space-type="buttons">
		<button type="button" class="wikia-menu-button contribute secondary">Edit</button>
	</div>
	<?= $app->getView( 'MiniEditorController', 'Footer' )->render(); ?>
	<?= $app->getView( 'MiniEditorController', 'Header', array(
		'attributes' => array(
			'id' => 'Reply',
			'data-min-height' => 100,
			'data-max-height' => 400
		)
	))->render(); ?>
	<?= $app->getView( 'MiniEditorController', 'Editor_Header')->render(); ?>
	<textarea class="body" placeholder="<?= wfMsg( 'minieditor-placeholder-reply' ) ?>"></textarea>
	<?= $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); ?>
	<div class="buttons" data-space-type="buttons">
		<button type="button"><?= wfMsg('minieditor-reply') ?></button>
	</div>
	<?= $app->getView( 'MiniEditorController', 'Footer' )->render(); ?>
</section>