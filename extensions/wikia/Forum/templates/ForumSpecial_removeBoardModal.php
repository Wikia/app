<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMessage( 'forum-admin-delete-and-merge-board-modal-heading', $boardTitle )->escaped() ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-delete-board-title' )->escaped(),
			),
			array(
				'type' => 'custom',
				'output' => wfMessage( 'forum-admin-merge-board-warning' )->escaped(),
			),
			array(
				'type' => 'select',
				'name' => 'destinationBoardId',
				'class' => 'destinationBoardId',
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-merge-board-destination', $boardTitle )->escaped(),
				'options' => $destinationBoards,
			),
		),
		'method' => 'post',
		'action' => '',
	);

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>

	<div class="neutral modalToolbar">
		<button class="secondary cancel">
			<?= wfMessage( 'cancel' )->escaped() ?>
		</button>
		<button class="submit">
			<?= wfMessage( 'forum-admin-delete-and-merge-button-label' )->escaped() ?>
		</button>
	</div>
</section>
