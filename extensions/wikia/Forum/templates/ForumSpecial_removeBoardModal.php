<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMsg('forum-admin-delete-and-merge-board-modal-heading', $boardTitle) ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-delete-board-title'),
			),
			array(
				'type' => 'custom',
				'output' => wfMsg('forum-admin-merge-board-warning'),
			),
			array(
				'type' => 'select',
				'name' => 'destinationBoardId',
				'class' => 'destinationBoardId',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-merge-board-destination', $boardTitle),
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
			<?= wfMsg('cancel') ?>
		</button>
		<button class="submit">
			<?= wfMsg('forum-admin-delete-and-merge-button-label') ?>
		</button>
	</div>
</section>