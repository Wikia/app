<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= $wf->Msg('forum-admin-delete-and-merge-board-modal-heading', $boardTitle) ?>
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
				'type' => 'select',
				'name' => 'destinationBoardId',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-merge-board-destination'),
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
			<?= $wf->Msg('cancel') ?>
		</button>
		<button class="submit">
			<?= $wf->Msg('forum-admin-delete-and-merge-button-label') ?>
		</button>
	</div>
</section>