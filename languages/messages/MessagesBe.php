<?php
/** Belarusian (Беларуская)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Cesco
 * @author Jim-by
 * @author Kaganer
 * @author LexArt
 * @author Maksim L.
 * @author Mienski
 * @author Prima klasy4na
 * @author Riwnodennyk
 * @author Urhixidur
 * @author Wizardist
 * @author Yury Tarasievich
 * @author Тест
 * @author Хомелка
 * @author Чаховіч Уладзіслаў
 * @author לערי ריינהארט
 */

$bookstoreList = array(
	'OZ.by' => 'http://oz.by/search.phtml?what=books&isbn=$1',
	'Amazon.com' => 'http://www.amazon.com/exec/obidos/ISBN=$1'
);

$datePreferences = array(
	'default',
	'dmy',
	'ISO 8601',
);

$defaultDateFormat = 'dmy';

$dateFormats = array(
	'dmy time' => 'H:i',
	'dmy date' => 'j xg Y',
	'dmy both' => 'H:i, j xg Y',
);

$namespaceNames = array(
	NS_MEDIA            => 'Мультымедыя',
	NS_SPECIAL          => 'Адмысловае',
	NS_TALK             => 'Размовы',
	NS_USER             => 'Удзельнік',
	NS_USER_TALK        => 'Размовы_з_удзельнікам',
	NS_PROJECT_TALK     => '$1_размовы',
	NS_FILE             => 'Выява',
	NS_FILE_TALK        => 'Размовы_пра_выяву',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Размовы_пра_MediaWiki',
	NS_TEMPLATE         => 'Шаблон',
	NS_TEMPLATE_TALK    => 'Размовы_пра_шаблон',
	NS_HELP             => 'Даведка',
	NS_HELP_TALK        => 'Размовы_пра_даведку',
	NS_CATEGORY         => 'Катэгорыя',
	NS_CATEGORY_TALK    => 'Размовы_пра_катэгорыю',
);

$magicWords = array(
	'img_thumbnail'           => array( '1', 'міні', 'мініяцюра', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'міні=$1', 'мініяцюра=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'справа', 'right' ),
	'img_left'                => array( '1', 'злева', 'left' ),
	'img_none'                => array( '1', 'няма', 'none' ),
	'img_width'               => array( '1', '$1пкс', '$1px' ),
	'img_center'              => array( '1', 'цэнтр', 'center', 'centre' ),
	'img_framed'              => array( '1', 'безрамкі', 'framed', 'enframed', 'frame' ),
);

# Per discussion on http://translatewiki.net/wiki/Thread:Support/Customization_of number format
$separatorTransformTable = array(
	',' => "\xc2\xa0", # nbsp
	'.' => ','
);

$linkTrail = '/^([абвгґджзеёжзійклмнопрстуўфхцчшыьэюяćčłńśšŭźža-z]+)(.*)$/sDu';

