<?php

/**
 * CodeLint
 *
 * Provides interface for linting JS and CSS code.
 *
 * Beware! JSLint will hurt your feelings.
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CodeLint/CodeLint.setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'CodeLint',
	'version' => '1.0',
	'author' => 'Maciej Brencz',
	'description' => 'Provides interface for linting JS and CSS code',
);

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

// classes
$app->registerClass('CodeLint', $dir . '/CodeLint.class.php');
$app->registerClass('CodeLintReport', $dir . '/CodeLintReport.class.php');
$app->registerClass('CodeLintReportHtml', $dir . '/reports/CodeLintReportHtml.class.php');
$app->registerClass('CodeLintReportText', $dir . '/reports/CodeLintReportText.class.php');
$app->registerClass('JsLint', $dir . '/JsLint.class.php');