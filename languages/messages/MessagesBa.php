<?php
/** Bashkir (Башҡортса)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Assele
 * @author Comp1089
 * @author Haqmar
 * @author Kaganer
 * @author Reedy
 * @author Roustammr
 * @author Timming
 * @author Рустам Нурыев
 */

$fallback = 'ru';

$namespaceNames = array(
	NS_MEDIA            => 'Медиа',
	NS_SPECIAL          => 'Ярҙамсы',
	NS_TALK             => 'Фекер_алышыу',
	NS_USER             => 'Ҡатнашыусы',
	NS_USER_TALK        => 'Ҡатнашыусы_м-н_фекер_алышыу',
	NS_PROJECT_TALK     => '$1_б-са_фекер_алышыу',
	NS_FILE             => 'Рәсем',
	NS_FILE_TALK        => 'Рәсем_б-са_фекер_алышыу',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki_б-са_фекер_алышыу',
	NS_TEMPLATE         => 'Ҡалып',
	NS_TEMPLATE_TALK    => 'Ҡалып_б-са_фекер_алышыу',
	NS_HELP             => 'Белешмә',
	NS_HELP_TALK        => 'Белешмә_б-са_фекер_алышыу',
	NS_CATEGORY         => 'Категория',
	NS_CATEGORY_TALK    => 'Категория_б-са_фекер_алышыу',
);

// Remove Russian aliases
$namespaceGenderAliases = array();

$linkTrail = '/^((?:[a-z]|а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я|ә|ө|ү|ғ|ҡ|ң|ҙ|ҫ|һ|“|»)+)(.*)$/sDu';

