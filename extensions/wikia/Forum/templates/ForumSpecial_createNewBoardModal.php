<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMsg('forum-admin-create-new-board-modal-heading') ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-title'),
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-description'),
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
			<?= wfMsg('forum-admin-create-new-board-label') ?>
		</button>
	</div>
</section>