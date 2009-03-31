<?php

class FreeColMessageGroup extends MessageGroup {
	protected $label = 'FreeCol (open source game)';
	protected $id    = 'out-freecol';
	protected $type  = 'freecol';

	protected   $fileDir  = '__BUG__';

	public function getPath() { return $this->fileDir; }
	public function setPath( $value ) { $this->fileDir = $value; }

	protected $codeMap = array(
		'cs' => 'cs_CZ',
		'es' => 'es_ES',
		'it' => 'it_IT',
		'no' => 'nb_NO',
		'pl' => 'pl_PL',
		'sv' => 'sv_SE',
		'nl-be' => 'nl_BE',
		'en-gb' => 'en_GB',
		'en-us' => 'en_US',
		'pt'    => 'pt_PT',
		'pt-pt' => 'pt_PT',
		'pt-br' => 'pt_BR',
	);

	protected $optional = array(
		'model.foundingFather.adamSmith.birthAndDeath', 'model.foundingFather.adamSmith.name',
		'model.foundingFather.bartolomeDeLasCasas.birthAndDeath', 'model.foundingFather.bartolomeDeLasCasas.name', 'model.foundingFather.benjaminFranklin.birthAndDeath',
		'model.foundingFather.benjaminFranklin.name', 'model.foundingFather.fatherJeanDeBrebeuf.birthAndDeath', 'model.foundingFather.fatherJeanDeBrebeuf.name',
		'model.foundingFather.ferdinandMagellan.birthAndDeath', 'model.foundingFather.ferdinandMagellan.name', 'model.foundingFather.francisDrake.birthAndDeath',
		'model.foundingFather.francisDrake.name', 'model.foundingFather.franciscoDeCoronado.birthAndDeath', 'model.foundingFather.franciscoDeCoronado.name',
		'model.foundingFather.georgeWashington.birthAndDeath', 'model.foundingFather.georgeWashington.name', 'model.foundingFather.henryHudson.birthAndDeath',
		'model.foundingFather.henryHudson.name', 'model.foundingFather.hernanCortes.birthAndDeath', 'model.foundingFather.hernanCortes.name',
		'model.foundingFather.hernandoDeSoto.birthAndDeath', 'model.foundingFather.hernandoDeSoto.name', 'model.foundingFather.jacobFugger.name',
		'model.foundingFather.janDeWitt.birthAndDeath', 'model.foundingFather.janDeWitt.name', 'model.foundingFather.johnPaulJones.birthAndDeath',
		'model.foundingFather.johnPaulJones.name', 'model.foundingFather.juanDeSepulveda.birthAndDeath', 'model.foundingFather.juanDeSepulveda.name',
		'model.foundingFather.laSalle.birthAndDeath', 'model.foundingFather.laSalle.name', 'model.foundingFather.paulRevere.birthAndDeath',
		'model.foundingFather.paulRevere.name', 'model.foundingFather.peterMinuit.birthAndDeath', 'model.foundingFather.peterMinuit.name',
		'model.foundingFather.peterStuyvesant.birthAndDeath', 'model.foundingFather.peterStuyvesant.name', 'model.foundingFather.pocahontas.birthAndDeath',
		'model.foundingFather.pocahontas.name', 'model.foundingFather.simonBolivar.birthAndDeath', 'model.foundingFather.simonBolivar.name',
		'model.foundingFather.thomasJefferson.birthAndDeath', 'model.foundingFather.thomasJefferson.name', 'model.foundingFather.thomasPaine.birthAndDeath',
		'model.foundingFather.thomasPaine.name', 'model.foundingFather.williamBrewster.birthAndDeath', 'model.foundingFather.williamBrewster.name',
		'model.foundingFather.williamPenn.birthAndDeath', 'model.foundingFather.williamPenn.name', 'model.goods.goodsAmount',
		'model.model.foundingFather.jacobFugger.birthAndDeath', 'model.nation.Apache.ruler', 'model.nation.Arawak.ruler',
		'model.nation.Aztec.ruler', 'model.nation.Cherokee.ruler', 'model.nation.Dutch.ruler',
		'model.nation.English.ruler', 'model.nation.French.ruler', 'model.nation.Inca.ruler',
		'model.nation.Iroquois.ruler', 'model.nation.Portuguese.Europe', 'model.nation.Portuguese.ruler',
		'model.nation.Sioux.ruler', 'model.nation.Spanish.ruler', 'model.nation.Tupi.ruler',
		'model.nation.danish.ruler', 'model.nation.danishREF.ruler', 'model.nation.dutch.newColonyName.0',
		'model.nation.dutch.newColonyName.1', 'model.nation.dutch.newColonyName.10', 'model.nation.dutch.newColonyName.11',
		'model.nation.dutch.newColonyName.12', 'model.nation.dutch.newColonyName.13', 'model.nation.dutch.newColonyName.14',
		'model.nation.dutch.newColonyName.15', 'model.nation.dutch.newColonyName.16', 'model.nation.dutch.newColonyName.17',
		'model.nation.dutch.newColonyName.18', 'model.nation.dutch.newColonyName.19', 'model.nation.dutch.newColonyName.2',
		'model.nation.dutch.newColonyName.20', 'model.nation.dutch.newColonyName.21', 'model.nation.dutch.newColonyName.22',
		'model.nation.dutch.newColonyName.23', 'model.nation.dutch.newColonyName.24', 'model.nation.dutch.newColonyName.25',
		'model.nation.dutch.newColonyName.26', 'model.nation.dutch.newColonyName.27', 'model.nation.dutch.newColonyName.28',
		'model.nation.dutch.newColonyName.29', 'model.nation.dutch.newColonyName.3', 'model.nation.dutch.newColonyName.30',
		'model.nation.dutch.newColonyName.31', 'model.nation.dutch.newColonyName.4', 'model.nation.dutch.newColonyName.5',
		'model.nation.dutch.newColonyName.6', 'model.nation.dutch.newColonyName.7', 'model.nation.dutch.newColonyName.8',
		'model.nation.dutch.newColonyName.9', 'model.nation.dutch.region.land.1', 'model.nation.dutch.region.land.10',
		'model.nation.dutch.region.land.2', 'model.nation.dutch.region.land.3', 'model.nation.dutch.region.land.4',
		'model.nation.dutch.region.land.5', 'model.nation.dutch.region.land.6', 'model.nation.dutch.region.land.7',
		'model.nation.dutch.region.land.8', 'model.nation.dutch.region.land.9', 'model.nation.dutch.region.mountain.1',
		'model.nation.dutch.region.mountain.2', 'model.nation.dutch.region.mountain.3', 'model.nation.dutch.region.mountain.4',
		'model.nation.dutch.region.mountain.5', 'model.nation.dutch.region.mountain.6', 'model.nation.dutch.region.mountain.7',
		'model.nation.dutch.region.mountain.8', 'model.nation.dutch.region.mountain.9', 'model.nation.dutch.region.river.1',
		'model.nation.dutch.region.river.2', 'model.nation.dutch.region.river.3', 'model.nation.dutch.region.river.4',
		'model.nation.dutch.region.river.5', 'model.nation.dutch.region.river.6', 'model.nation.dutch.region.river.7',
		'model.nation.dutch.region.river.8', 'model.nation.english.newColonyName.0', 'model.nation.english.newColonyName.1',
		'model.nation.english.newColonyName.10', 'model.nation.english.newColonyName.11', 'model.nation.english.newColonyName.12',
		'model.nation.english.newColonyName.13', 'model.nation.english.newColonyName.14', 'model.nation.english.newColonyName.15',
		'model.nation.english.newColonyName.16', 'model.nation.english.newColonyName.17', 'model.nation.english.newColonyName.18',
		'model.nation.english.newColonyName.19', 'model.nation.english.newColonyName.2', 'model.nation.english.newColonyName.20',
		'model.nation.english.newColonyName.21', 'model.nation.english.newColonyName.22', 'model.nation.english.newColonyName.23',
		'model.nation.english.newColonyName.24', 'model.nation.english.newColonyName.25', 'model.nation.english.newColonyName.26',
		'model.nation.english.newColonyName.27', 'model.nation.english.newColonyName.28', 'model.nation.english.newColonyName.29',
		'model.nation.english.newColonyName.3', 'model.nation.english.newColonyName.30', 'model.nation.english.newColonyName.31',
		'model.nation.english.newColonyName.32', 'model.nation.english.newColonyName.33', 'model.nation.english.newColonyName.34',
		'model.nation.english.newColonyName.35', 'model.nation.english.newColonyName.4', 'model.nation.english.newColonyName.5',
		'model.nation.english.newColonyName.6', 'model.nation.english.newColonyName.7', 'model.nation.english.newColonyName.8',
		'model.nation.english.newColonyName.9', 'model.nation.english.region.land.1', 'model.nation.english.region.land.10',
		'model.nation.english.region.land.2', 'model.nation.english.region.land.3', 'model.nation.english.region.land.4',
		'model.nation.english.region.land.5', 'model.nation.english.region.land.6', 'model.nation.english.region.land.7',
		'model.nation.english.region.land.8', 'model.nation.english.region.land.9', 'model.nation.english.region.mountain.1',
		'model.nation.english.region.mountain.2', 'model.nation.english.region.mountain.3', 'model.nation.english.region.mountain.4',
		'model.nation.english.region.mountain.5', 'model.nation.english.region.mountain.6', 'model.nation.english.region.mountain.7',
		'model.nation.english.region.mountain.8', 'model.nation.english.region.mountain.9', 'model.nation.english.region.river.1',
		'model.nation.english.region.river.10', 'model.nation.english.region.river.2', 'model.nation.english.region.river.3',
		'model.nation.english.region.river.4', 'model.nation.english.region.river.5', 'model.nation.english.region.river.6',
		'model.nation.english.region.river.7', 'model.nation.english.region.river.8', 'model.nation.english.region.river.9',
		'model.nation.french.newColonyName.0', 'model.nation.french.newColonyName.1', 'model.nation.french.newColonyName.10',
		'model.nation.french.newColonyName.11', 'model.nation.french.newColonyName.12', 'model.nation.french.newColonyName.13',
		'model.nation.french.newColonyName.14', 'model.nation.french.newColonyName.15', 'model.nation.french.newColonyName.16',
		'model.nation.french.newColonyName.17', 'model.nation.french.newColonyName.18', 'model.nation.french.newColonyName.19',
		'model.nation.french.newColonyName.2', 'model.nation.french.newColonyName.20', 'model.nation.french.newColonyName.21',
		'model.nation.french.newColonyName.22', 'model.nation.french.newColonyName.23', 'model.nation.french.newColonyName.24',
		'model.nation.french.newColonyName.25', 'model.nation.french.newColonyName.26', 'model.nation.french.newColonyName.27',
		'model.nation.french.newColonyName.28', 'model.nation.french.newColonyName.29', 'model.nation.french.newColonyName.3',
		'model.nation.french.newColonyName.30', 'model.nation.french.newColonyName.31', 'model.nation.french.newColonyName.32',
		'model.nation.french.newColonyName.33', 'model.nation.french.newColonyName.34', 'model.nation.french.newColonyName.35',
		'model.nation.french.newColonyName.36', 'model.nation.french.newColonyName.37', 'model.nation.french.newColonyName.38',
		'model.nation.french.newColonyName.39', 'model.nation.french.newColonyName.4', 'model.nation.french.newColonyName.40',
		'model.nation.french.newColonyName.41', 'model.nation.french.newColonyName.42', 'model.nation.french.newColonyName.43',
		'model.nation.french.newColonyName.44', 'model.nation.french.newColonyName.45', 'model.nation.french.newColonyName.46',
		'model.nation.french.newColonyName.47', 'model.nation.french.newColonyName.48', 'model.nation.french.newColonyName.49',
		'model.nation.french.newColonyName.5', 'model.nation.french.newColonyName.50', 'model.nation.french.newColonyName.51',
		'model.nation.french.newColonyName.52', 'model.nation.french.newColonyName.53', 'model.nation.french.newColonyName.54',
		'model.nation.french.newColonyName.55', 'model.nation.french.newColonyName.56', 'model.nation.french.newColonyName.57',
		'model.nation.french.newColonyName.58', 'model.nation.french.newColonyName.59', 'model.nation.french.newColonyName.6',
		'model.nation.french.newColonyName.60', 'model.nation.french.newColonyName.61', 'model.nation.french.newColonyName.62',
		'model.nation.french.newColonyName.63', 'model.nation.french.newColonyName.64', 'model.nation.french.newColonyName.65',
		'model.nation.french.newColonyName.7', 'model.nation.french.newColonyName.8', 'model.nation.french.newColonyName.9',
		'model.nation.french.region.land.1', 'model.nation.french.region.land.2', 'model.nation.french.region.land.3',
		'model.nation.french.region.land.4', 'model.nation.french.region.land.5', 'model.nation.french.region.land.6',
		'model.nation.french.region.land.7',
		'model.nation.french.region.mountain.1', 'model.nation.french.region.mountain.10', 'model.nation.french.region.mountain.2',
		'model.nation.french.region.mountain.3', 'model.nation.french.region.mountain.4', 'model.nation.french.region.mountain.5',
		'model.nation.french.region.mountain.6', 'model.nation.french.region.mountain.7', 'model.nation.french.region.mountain.8',
		'model.nation.french.region.mountain.9', 'model.nation.french.region.river.1', 'model.nation.french.region.river.10',
		'model.nation.french.region.river.2', 'model.nation.french.region.river.3', 'model.nation.french.region.river.4',
		'model.nation.french.region.river.5', 'model.nation.french.region.river.6', 'model.nation.french.region.river.7',
		'model.nation.french.region.river.8', 'model.nation.french.region.river.9', 'model.nation.portuguese.newColonyName.0',
		'model.nation.portuguese.newColonyName.1', 'model.nation.portuguese.newColonyName.10', 'model.nation.portuguese.newColonyName.11',
		'model.nation.portuguese.newColonyName.12', 'model.nation.portuguese.newColonyName.13', 'model.nation.portuguese.newColonyName.14',
		'model.nation.portuguese.newColonyName.15', 'model.nation.portuguese.newColonyName.16', 'model.nation.portuguese.newColonyName.17',
		'model.nation.portuguese.newColonyName.18', 'model.nation.portuguese.newColonyName.19', 'model.nation.portuguese.newColonyName.2',
		'model.nation.portuguese.newColonyName.20', 'model.nation.portuguese.newColonyName.21', 'model.nation.portuguese.newColonyName.22',
		'model.nation.portuguese.newColonyName.23', 'model.nation.portuguese.newColonyName.24', 'model.nation.portuguese.newColonyName.25',
		'model.nation.portuguese.newColonyName.26', 'model.nation.portuguese.newColonyName.27', 'model.nation.portuguese.newColonyName.28',
		'model.nation.portuguese.newColonyName.29', 'model.nation.portuguese.newColonyName.3', 'model.nation.portuguese.newColonyName.4',
		'model.nation.portuguese.newColonyName.5', 'model.nation.portuguese.newColonyName.6', 'model.nation.portuguese.newColonyName.7',
		'model.nation.portuguese.newColonyName.8', 'model.nation.portuguese.newColonyName.9', 'model.nation.refDutch.ruler',
		'model.nation.refEnglish.ruler', 'model.nation.refFrench.ruler', 'model.nation.refPortuguese.ruler',
		'model.nation.refSpanish.ruler', 'model.nation.russian.ruler', 'model.nation.russianREF.ruler',
		'model.nation.spanish.newColonyName.0', 'model.nation.spanish.newColonyName.1', 'model.nation.spanish.newColonyName.10',
		'model.nation.spanish.newColonyName.11', 'model.nation.spanish.newColonyName.12', 'model.nation.spanish.newColonyName.13',
		'model.nation.spanish.newColonyName.14', 'model.nation.spanish.newColonyName.15', 'model.nation.spanish.newColonyName.16',
		'model.nation.spanish.newColonyName.17', 'model.nation.spanish.newColonyName.18', 'model.nation.spanish.newColonyName.19',
		'model.nation.spanish.newColonyName.2', 'model.nation.spanish.newColonyName.20', 'model.nation.spanish.newColonyName.21',
		'model.nation.spanish.newColonyName.22', 'model.nation.spanish.newColonyName.23', 'model.nation.spanish.newColonyName.24',
		'model.nation.spanish.newColonyName.25', 'model.nation.spanish.newColonyName.26', 'model.nation.spanish.newColonyName.27',
		'model.nation.spanish.newColonyName.28', 'model.nation.spanish.newColonyName.29', 'model.nation.spanish.newColonyName.3',
		'model.nation.spanish.newColonyName.30', 'model.nation.spanish.newColonyName.31', 'model.nation.spanish.newColonyName.32',
		'model.nation.spanish.newColonyName.33', 'model.nation.spanish.newColonyName.34', 'model.nation.spanish.newColonyName.35',
		'model.nation.spanish.newColonyName.36', 'model.nation.spanish.newColonyName.37', 'model.nation.spanish.newColonyName.38',
		'model.nation.spanish.newColonyName.4', 'model.nation.spanish.newColonyName.5', 'model.nation.spanish.newColonyName.6',
		'model.nation.spanish.newColonyName.7', 'model.nation.spanish.newColonyName.8', 'model.nation.spanish.newColonyName.9',
		'model.nation.spanish.region.land.1', 'model.nation.spanish.region.land.2', 'model.nation.spanish.region.land.3',
		'model.nation.spanish.region.land.4', 'model.nation.spanish.region.land.5', 'model.nation.spanish.region.river.1',
		'model.nation.spanish.region.river.2', 'model.nation.swedish.europe', 'model.nation.swedish.ruler',
		'model.nation.swedishREF.ruler', 'model.unit.occupation.activeNoMovesLeft',
		'shipName.3.0', 'model.nation.spanish.region.mountain.1', 'model.nation.spanish.region.mountain.2',
		'model.nation.spanish.region.mountain.3', 'model.nation.spanish.region.mountain.4', 'model.nation.spanish.region.mountain.5',
		'model.nation.spanish.region.river.3', 'model.nation.spanish.region.river.4', 'model.nation.spanish.region.river.5',
		'model.region.default', 'model.nation.danish.newColonyName.0', 'model.nation.danish.newColonyName.1',
		'model.nation.danish.newColonyName.2',
		'model.nation.danish.newColonyName.10', 'model.nation.danish.newColonyName.11', 'model.nation.danish.newColonyName.12',
		'model.nation.danish.newColonyName.3', 'model.nation.danish.newColonyName.4', 'model.nation.danish.newColonyName.5',
		'model.nation.danish.newColonyName.6', 'model.nation.danish.newColonyName.7', 'model.nation.danish.newColonyName.8',
		'model.nation.danish.newColonyName.9', 'model.nation.danish.region.land.1', 'model.nation.danish.region.land.2',
		'model.nation.danish.region.land.3', 'model.nation.danish.region.land.4', 'model.nation.danish.region.land.5',
		'model.nation.danish.region.land.6', 'model.nation.danish.region.mountain.1', 'model.nation.danish.region.mountain.2',
		'model.nation.danish.region.mountain.3', 'model.nation.danish.region.mountain.4', 'model.nation.danish.region.mountain.5',
		'model.nation.danish.region.mountain.6', 'model.nation.danish.region.river.1', 'model.nation.danish.region.river.2',
		'model.nation.danish.region.river.3', 'model.nation.russian.newColonyName.0', 'model.nation.russian.newColonyName.1',
		'model.nation.russian.newColonyName.10',
		'model.nation.russian.newColonyName.11', 'model.nation.russian.newColonyName.12', 'model.nation.russian.newColonyName.13',
		'model.nation.russian.newColonyName.14', 'model.nation.russian.newColonyName.15', 'model.nation.russian.newColonyName.16',
		'model.nation.russian.newColonyName.17', 'model.nation.russian.newColonyName.18', 'model.nation.russian.newColonyName.19',
		'model.nation.russian.newColonyName.2', 'model.nation.russian.newColonyName.20', 'model.nation.russian.newColonyName.21',
		'model.nation.russian.newColonyName.22', 'model.nation.russian.newColonyName.23', 'model.nation.russian.newColonyName.3',
		'model.nation.russian.newColonyName.4', 'model.nation.russian.newColonyName.5', 'model.nation.russian.newColonyName.6',
		'model.nation.russian.newColonyName.7', 'model.nation.russian.newColonyName.8', 'model.nation.russian.newColonyName.9',
		'model.nation.russian.region.land.1', 'model.nation.russian.region.land.2', 'model.nation.russian.region.land.3',
		'model.nation.russian.region.land.4', 'model.nation.russian.region.land.5', 'model.nation.russian.region.mountain.1',
		'model.nation.russian.region.mountain.2', 'model.nation.russian.region.mountain.3', 'model.nation.russian.region.mountain.4',
		'model.nation.russian.region.mountain.5', 'model.nation.russian.region.river.1', 'model.nation.russian.region.river.2',
		'model.nation.russian.region.river.3', 'model.nation.russian.region.river.4', 'model.nation.swedish.newColonyName.0',
		'model.nation.swedish.newColonyName.1', 'model.nation.swedish.newColonyName.10', 'model.nation.swedish.newColonyName.11',
		'model.nation.swedish.newColonyName.12', 'model.nation.swedish.newColonyName.13', 'model.nation.swedish.newColonyName.14',
		'model.nation.swedish.newColonyName.15', 'model.nation.swedish.newColonyName.16', 'model.nation.swedish.newColonyName.17',
		'model.nation.swedish.newColonyName.18', 'model.nation.swedish.newColonyName.19', 'model.nation.swedish.newColonyName.2',
		'model.nation.swedish.newColonyName.20', 'model.nation.swedish.newColonyName.21', 'model.nation.swedish.newColonyName.3',
		'model.nation.swedish.newColonyName.4', 'model.nation.swedish.newColonyName.5', 'model.nation.swedish.newColonyName.6',
		'model.nation.swedish.newColonyName.7', 'model.nation.swedish.newColonyName.8', 'model.nation.swedish.newColonyName.9',
		'model.nation.swedish.region.land.1', 'model.nation.swedish.region.land.2', 'model.nation.swedish.region.land.3',
		'model.nation.swedish.region.river.1', 'model.nation.swedish.region.river.2', 'model.nation.swedish.region.river.3',
		'model.nation.swedish.region.river.4',
	);

	protected $ignored = array(
		'headerFont',
	);

	public function getMessageFile( $code ) {
		if ( $code == 'en' ) {
			return 'FreeColMessages.properties';
		} else {
			if ( isset( $this->codeMap[$code] ) ) {
				$code = $this->codeMap[$code];
			}
			return "FreeColMessages_$code.properties";
		}
	}

	protected function getFileLocation( $code ) {
		return $this->fileDir . '/' . $this->getMessageFile( $code );
	}

	public function getReader( $code ) {
		return new JavaFormatReader( $this->getFileLocation( $code ) );
	}

	public function getWriter() {
		return new JavaFormatWriter( $this );
	}
}
