<?php
/*
  Configuration file for automatically generated sprites.

  To regenerate the chosen sprite issue this command on your devbox (replace SPRITE_NAME with one of the configured below):
    SERVER_ID=177 php /usr/wikia/source/wiki/maintenance/wikia/generateSprites.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --sprite SPRITE_NAME
  However if you skip the sprite parameter the script will go through entire configuration file and regenerate them.

*/


$config = array();

/*
$config['oasis'] = array(
	'name'   => 'oasis',
	'source' => "$IP/skins/oasis/images/sprite-oasis/",
	'sprite' => "$IP/skins/oasis/images/sprite-oasis.png",
	'scss'   => "$IP/skins/oasis/css/mixins/sprite-oasis.scss"
);
*/

$config['EditPageLayout'] = array(
	'name'   => 'edit-page',
	'source' => "$IP/extensions/wikia/EditPageLayout/images/sprite-edit-page/",
	'sprite' => "$IP/extensions/wikia/EditPageLayout/images/sprite-edit-page.png",
	'scss'   => "$IP/extensions/wikia/EditPageLayout/css/mixins/_sprite-edit-page.scss",
	/*
	// POSTPROCESSING EXAMPLE
	// Use [INPUT] and [OUTPUT] in the command
	'postprocess' => array(
		'pngout -c6 -d8 [INPUT] [OUTPUT]',
	),
	*/
);

$config['EditPageLayout_mw_toolbar'] = array(
	'name' => 'edit-mw-toolbar',
	'source' => "$IP/skins/common/images/",
	'sprite' => "$IP/extensions/wikia/EditPageLayout/images/sprite-edit-mw-toolbar.png",
	'scss' => "$IP/extensions/wikia/EditPageLayout/css/mixins/_sprite-edit-mw-toolbar.scss",
	'sourceFiles' => array(
		'button_bold.png',
		'button_italic.png',
		'button_link.png',
		'button_extlink.png',
		'button_headline.png',
		'button_image.png',
		'button_media.png',
		'button_math.png',
		'button_nowiki.png',
		'button_sig.png',
		'button_hr.png',
		'ar/button_nowiki.png',
		'ar/button_italic.png',
		'ar/button_headline.png',
		'ar/button_link.png',
		'ar/button_bold.png',
		'be-tarask/button_italic.png',
		'be-tarask/button_link.png',
		'be-tarask/button_bold.png',
		'cyrl/button_italic.png',
		'cyrl/button_link.png',
		'cyrl/button_bold.png',
		'de/button_italic.png',
		'de/button_bold.png',
		'fa/button_nowiki.png',
		'fa/button_italic.png',
		'fa/button_headline.png',
		'fa/button_link.png',
		'fa/button_bold.png',
		'ksh/button_S_italic.png',
		'../../../extensions/wikia/WikiaMiniUpload/images/button_wmu.png',
		'../../../extensions/wikia/WikiaPhotoGallery/images/gallery_add.png',
		'../../../extensions/wikia/VideoEmbedTool/images/button_vet.png',
	),
	'cssClassMap' => array(
		'ksh/button_S_italic' => 'ksh-button-italic',
		'extensions/wikia/WikiaMiniUpload/images/button_wmu' => 'button-wmu',
		'extensions/wikia/WikiaPhotoGallery/images/gallery_add' => 'button-wpg',
		'extensions/wikia/VideoEmbedTool/images/button_vet' => 'button-vet',
	)
);

/*
$config['PageLayoutEditor'] = array(
	'name'   => 'page-layout-builder',
	'source' => "$IP/extensions/wikia/PageLayoutBuilder/images/sprite-page-layout-builder/",
	'sprite' => "$IP/extensions/wikia/PageLayoutBuilder/images/sprite-page-layout-builder.png",
	'scss'   => "$IP/extensions/wikia/PageLayoutBuilder/css/_sprite-page-layout-builder.scss",
);
*/

$config['MiniEditor'] = array(
	'name'   => 'MiniEditor',
	'source' => "$IP/extensions/wikia/MiniEditor/images/sprite-MiniEditor/",
	'sprite' => "$IP/extensions/wikia/MiniEditor/images/sprite-MiniEditor.png",
	'scss'   => "$IP/extensions/wikia/MiniEditor/css/mixins/_sprite-MiniEditor.scss"
);

$config['Chat2'] = array(
	'name'   => 'Chat',
	'source' => "$IP/extensions/wikia/Chat2/images/sprite-Chat/",
	'sprite' => "$IP/extensions/wikia/Chat2/images/sprite-Chat.png",
	'scss'   => "$IP/extensions/wikia/Chat2/css/mixins/_sprite-Chat.scss"
);

$config['Lightbox'] = array(
	'name'   => 'Lightbox',
	'source' => "$IP/extensions/wikia/Lightbox/images/sprite-Lightbox/",
	'sprite' => "$IP/extensions/wikia/Lightbox/images/sprite-Lightbox.png",
	'scss'   => "$IP/extensions/wikia/Lightbox/css/mixins/_sprite-Lightbox.scss"
);

$config['LicensedVideoSwap'] = array(
	'name'   => 'LicensedVideoSwap',
	'source' => "$IP/extensions/wikia/LicensedVideoSwap/images/sprite-LicensedVideoSwap/",
	'sprite' => "$IP/extensions/wikia/LicensedVideoSwap/images/sprite-LicensedVideoSwap.png",
	'scss'   => "$IP/extensions/wikia/LicensedVideoSwap/css/mixins/_sprite-LicensedVideoSwap.scss"
);

$config['VideoPageTool'] = array(
	'name' => 'VideoPageTool',
	'source' => "$IP/extensions/wikia/VideoPageTool/images/sprite-VideoPageTool/",
	'sprite' => "$IP/extensions/wikia/VideoPageTool/images/sprite-VideoPageTool.png",
	'scss'   => "$IP/extensions/wikia/VideoPageTool/css/mixins/_sprite-VideoPageTool.scss"

);
