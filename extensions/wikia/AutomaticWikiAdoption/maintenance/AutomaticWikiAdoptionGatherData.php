<?php
/**
 * AutomaticWikiAdoptionGatherData
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script for gathering data - mark wikis available for adoption
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

class AutomaticWikiAdoptionGatherData {
	private $factory, $dataMapper;
	//entry point
	function run($commandLineOptions) {
		$recentAdminEdit = $this->getDataMapper()->getData();
		$wikisToAdopt = 0;
		$time14days = strtotime('-14 days');
		$time27days = strtotime('-27 days');
		$time30days = strtotime('-30 days');

		foreach ($recentAdminEdit as $wikiId => $wikiData) {
			$jobName = '';
			$jobOptions = array('dataMapper' => $this->getDataMapper());
			if ($wikiData['recentEdit'] < $time30days) {
				$jobName = 'SetAdoptionFlag';
				$wikisToAdopt++;
			} elseif ($wikiData['recentEdit'] < $time27days) {
				$jobName = 'SendMail';
				$jobOptions['mailType'] = 'second';
			} else /*if ($wikiData['recentEdit'] < $time14days)*/ {
				$jobName = 'SendMail';
				$jobOptions['mailType'] = 'first';
			}
			$jobClass = 'AutomaticWikiAdoptionJob' . $jobName;
			$job = $this->getJobFactory()->produce($jobClass);
			if ($job) {
				$job->execute($commandLineOptions, $jobOptions, $wikiId, $wikiData);
			}
		}

		if (!isset($commandLineOptions['quiet'])) {
			echo "Set $wikisToAdopt wikis as adoptable.\n";
		}
	}

	function setDataMapper($dataMapper) {
		$this->dataMapper = $dataMapper;
	}

	function getDataMapper() {
		if ($this->dataMapper === null) {
			$this->dataMapper = new AutomaticWikiAdoptionDataMapper();
		}

		return $this->dataMapper;
	}

	function setJobFactory($factory) {
		$this->factory = $factory;
	}

	function getJobFactory() {
		if ($this->factory === null) {
			$this->factory = new AutomaticWikiAdoptionJobFactory();
		}
		return $this->factory;
	}
}