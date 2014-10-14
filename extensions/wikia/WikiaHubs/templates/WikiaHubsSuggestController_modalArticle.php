<div class="WikiaHubsModal ArticleSuggestModal">
	<h1><?= wfMsg('wikiahubs-suggest-article-header') ?></h1>
<?
	$form = array(
		'class' => 'WikiaHubs',
		'inputs' => array(
			array(
				'class' => 'articleurl',
				'type' => 'text',
				'name' => 'articleurl',
				'isRequired' => true,
				'label' => wfMsg('wikiahubs-suggest-article-what-article'),
				'value' => '',
			),
			array(
				'type' => 'custom',
				'isRequired' => true,
				'output' => '<label>'.wfMsg('wikiahubs-suggest-article-reason').'</label><textarea name="reason" class="reason"></textarea>',
			),
			array(
				'class' => 'submit-button',
				'type' => 'custom',
				'output' => '<button class="wikia-button secondary cancel" >'.wfMsg('wikiahubs-button-cancel').'</button>'.
							'<button class="wikia-button submit" disabled="disabled" >'.wfMsg('wikiahubs-suggest-article-submit-button').'</button>',
			),
		),
	);

	$form['isInvalid'] = !empty($result) && !empty($msg);
	$form['errorMsg'] = !empty($msg) ? $msg : '';

	echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $form) );

?>

	<div class="close-button">
		<button class="wikia-button close"><?= wfMsg( 'wikiahubs-button-close' ) ?></button>
	</div>
</div>