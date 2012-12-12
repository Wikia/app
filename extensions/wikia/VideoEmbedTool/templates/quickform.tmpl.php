<p><?= wfMessage('vet-video-add-intro')->parse() ?></p>

<?

$urlInput = array(
    'label' => wfMsg('wva-url'),
    'type' => 'text',
    'name' => 'wpWikiaVideoAddUrl',
    'value' => $wpWikiaVideoAddUrl,
    'isInvalid' => (!empty($errors) && array_key_exists('videoUrl', $errors) ),
    'attributes' => array(
        'id' => 'wpWikiaVideoAddUrl',
        'size' => 50,
    ),
);
$urlInput['errorMsg'] = $urlInput['isInvalid'] ? $errors['videoUrl'] : '';

$formAttributes = array(
	'name' => 'quickaddform',
	'method' => 'post',
	'action' => $action,
);

$formSubmits = array(
	array(
    	'value' => wfMsg( 'wva-add' ),
    ),
);

// Name will already be set if a user is re-uploading a video
$nameInput = array(
	'type' => 'hidden',
	'name' => 'name',
	'value' => $name,
);

$form = array(
	'inputs' => array(
		$nameInput,
		$urlInput,
	),
	'attributes' => $formAttributes,
	'submits' => $formSubmits,
);




echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

?>



