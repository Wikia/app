<?php
$namespaceNames = array(
	NS_MEDIA          => 'Media',
	NS_SPECIAL        => 'Especial',
	NS_MAIN           => '',
	NS_TALK           => 'Discussió',
	NS_USER           => 'Usuari',
	NS_USER_TALK      => 'Usuari_Discussió',
	# NS_PROJECT set by $wgMetaNamespace
	NS_PROJECT_TALK   => '$1_Discussió',
	NS_IMAGE          => 'Image',
	NS_IMAGE_TALK     => 'Image_Discussió',
	NS_MEDIAWIKI      => 'MediaWiki',
	NS_MEDIAWIKI_TALK => 'MediaWiki_Discussió',
	NS_TEMPLATE       => 'Plantilla',
	NS_TEMPLATE_TALK  => 'Plantilla_Discussió',
	NS_HELP           => 'Ajuda',
	NS_HELP_TALK      => 'Ajuda_Discussió',
	NS_CATEGORY       => 'Categoria',
	NS_CATEGORY_TALK  => 'Categoria_Discussió'
);

$separatorTransformTable = array(',' => '.', '.' => ',' );

$dateFormats = array(
	'mdy time' => 'H:i',
	'mdy date' => 'M j, Y',
	'mdy both' => 'H:i, M j, Y',

	'dmy time' => 'H:i',
	'dmy date' => 'j M Y',
	'dmy both' => 'H:i, j M Y',

	'ymd time' => 'H:i',
	'ymd date' => 'Y M j',
	'ymd both' => 'H:i, Y M j',
);

$linkTrail = '/^([a-zàèéíòóúç·ïü\']+)(.*)$/sDu';

