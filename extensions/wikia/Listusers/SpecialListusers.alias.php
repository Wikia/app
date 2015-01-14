<?php
/**
 * Aliases for non-core Special:ListUsers redirects
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/**
 * English (English)
 */
$specialPageAliases['en'] = array(
	'Listvstf'	=> array( 'Listvstf' ),
	'Liststaff'	=> array( 'Liststaff' ),
	'Listhelpers'	=> array( 'Listhelpers' ),
);

/**
 * German (Deutsch)
 */
$specialPageAliases[ 'de' ] = array(
	'Listvstf'	=> array( 'Vstf' ),
	'Liststaff'	=> array( 'Wikia-mitarbeiter' ),
	'Listhelpers'	=> array( 'Wikia-helfer' ),
);

/**
 * French (Français)
 */
$specialPageAliases['fr'] = array(
	'Listvstf'	=> array( 'Listevstf', 'Liste_vstf' ),
	'Liststaff'	=> array( 'Listestaff', 'Liste_staff' ),
	'Listhelpers'	=> array( 'Listedesassistants', 'Liste_des_assistants' ),
);

/**
 * Italian (Italiano)
 */
$specialPageAliases['it'] = array(
	'Listvstf'	=> array( 'Vstf', 'Elencovstf' ),
	'Liststaff'	=> array( 'Staff', 'Elencostaff' ),
	'Listhelpers'	=> array( 'Helper', 'Elencohelper' ),
);

/**
 * Korean (한국어)
 */
$specialPageAliases['ko'] = array(
	'Listvstf'	=> array( '스태프' ),
	'Liststaff'	=> array( '헬퍼' ),
	'Listhelpers'	=> array( 'VSTF' ),
);

/**
 * Dutch (Nederlands)
 */
$specialPageAliases['nl'] = array(
	'Listvstf'	=> array( 'Vstflijst' ),
	'Liststaff'	=> array( 'Medewerkerlijst', 'Medewerkerslijst', 'Stafledenlijst' ),
	'Listhelpers'	=> array( 'Helperlijst', 'Helperslijst' ),
);

/**
 * Polish (Polski)
 */
$specialPageAliases['pl'] = array(
	'Listvstf'	=> array( 'Vstf' ),
	'Liststaff'	=> array( 'Staffowie' ),
	'Listhelpers'	=> array( 'Helperzy' ),
);

/**
 * Vietnamese (Tiếng Việt)
 */
$specialPageAliases['vi'] = array(
	'Listvstf'	=> array( 'Danh_sách_nhân_viên' ),
	'Liststaff'	=> array( 'Danh_sách_hỗ_trợ_viên' ),
	'Listhelpers'	=> array( 'Danh_sách_vstf' ),
);
