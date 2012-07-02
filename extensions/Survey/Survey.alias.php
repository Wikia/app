<?php

/**
 * Aliases for the special pages of the Survey extension.
 *
 * @since 0.1
 *
 * @file Survey.alias.php
 * @ingroup Survey
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'EditSurvey' => array( 'EditSurvey', 'Survey' ),
	'Surveys' => array( 'Surveys' ),
	'SurveyStats' => array( 'SurveyStats', 'SurveyStatistics' ),
	'TakeSurvey' => array( 'TakeSurvey' ),
);

/** German (Deutsch) */
$specialPageAliases['de'] = array(
	'EditSurvey' => array( 'Umfrage_bearbeiten' ),
	'Surveys' => array( 'Umfragen' ),
	'SurveyStats' => array( 'Umfragestatistiken' ),
	'TakeSurvey' => array( 'Umfrage_beantworten' ),
);

/** Interlingua (Interlingua) */
$specialPageAliases['ia'] = array(
	'EditSurvey' => array( 'Modificar_questionario', 'Questionario' ),
	'Surveys' => array( 'Questionarios' ),
	'SurveyStats' => array( 'Statisticas_de_questionarios' ),
	'TakeSurvey' => array( 'Responder_a_questionario' ),
);

/** Japanese (日本語) */
$specialPageAliases['ja'] = array(
	'EditSurvey' => array( '編集アンケート' ),
	'Surveys' => array( 'アンケート' ),
	'SurveyStats' => array( 'アンケート統計情報' ),
);

/** Macedonian (Македонски) */
$specialPageAliases['mk'] = array(
	'EditSurvey' => array( 'УредиАнкета', 'Анкета' ),
	'Surveys' => array( 'Анкети' ),
	'SurveyStats' => array( 'СтатистикиЗаАнкети' ),
	'TakeSurvey' => array( 'ПополниАнкета' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'EditSurvey' => array( 'Bewerkingsvragenlijst' ),
	'Surveys' => array( 'Vragenlijsten' ),
	'SurveyStats' => array( 'Vragenlijstresultaten' ),
	'TakeSurvey' => array( 'VragenlijstBeantwoorden' ),
);