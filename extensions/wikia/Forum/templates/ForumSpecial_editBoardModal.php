<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMsg('forum-admin-edit-board-modal-heading', $boardTitle) ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'value' => htmlspecialchars($boardTitle),
				'isRequired' => true,
				'label' => wfMsg('forum-admin-edit-board-title'),
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'value' => htmlspecialchars($boardDescription),
				'isRequired' => true,
				'label' => wfMsg('forum-admin-edit-board-description'),
				'attributes' => array(
					'maxlength' => '255'
				),
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
			<?= wfMsg('save') ?>
		</button>
	</div>
</section>