<?php
/**
 * @author Yaron Koren (Translation: Bernhard Krabina:krabina@cornerstone.at)
 */

class SD_LanguageDe extends SD_Language {

/* private */ var $m_SpecialProperties = array(
        //always start upper-case
	// category properties
	SD_SP_HAS_FILTER  => 'Hat Filter',
	// filter properties
	SD_SP_COVERS_PROPERTY  => 'Betrifft Attribut',
	SD_SP_HAS_VALUE  => 'Hat Wert',
	SD_SP_GETS_VALUES_FROM_CATEGORY => 'Erhält Werte aus der Kategorie',
	SD_SP_USES_TIME_PERIOD => 'Verwendet Zeitangabe',
	SD_SP_REQUIRES_FILTER => 'Benötigt Filter',
        SD_SP_HAS_LABEL  => 'Hat Bezeichnung'
);

var $m_Namespaces = array(
	SD_NS_FILTER		=> 'Filter',
	SD_NS_FILTER_TALK	=> 'Filter_Diskussion'
);

}
