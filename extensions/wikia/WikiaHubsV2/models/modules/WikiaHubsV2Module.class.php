<?php

/**
 * Base class for Hubs V2 modules
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

abstract class WikiaHubsV2Module extends WikiaModel {
	protected $lang;
	protected $date;
	protected $vertical;

	/**
	 * @var WikiaHubsV2ModuleDataProvider
	 */
	protected $provider;

	const HUBS_V2_MODEL_MEMC_VERSION = '0.02';

	public function setLang($lang) {
		$this->lang = $lang;
	}

	public function getLang() {
		return $this->lang;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function getDate() {
		return $this->date;
	}

	public function setVertical($vertical) {
		$this->vertical = $vertical;
	}

	public function getVertical() {
		return $this->vertical;
	}

	public function setProvider($provider) {
		$this->provider = $provider;
	}

	public function getProvider() {
		return $this->provider;
	}

	protected function memcGet() {
		$memcKey = $this->wf->memcKey(__CLASS__, self::HUBS_V2_MODEL_MEMC_VERSION, $this->wg->cityID, $this->wg->contLang->getCode());
		return $this->wg->Memc->get($memcKey);
	}

	protected function memcSet($value) {
		$memcKey = $this->wf->memcKey(__CLASS__, self::HUBS_V2_MODEL_MEMC_VERSION, $this->wg->cityID, $this->wg->contLang->getCode());
		$this->wg->Memc->set($memcKey,$value);
	}

	public function loadData() {
		$this->wf->profileIn(__METHOD__);

		$data = $this->memcGet();
		if(!is_array($data)) {
			$data = $this->getDataFromProvider();
		}

		$this->wf->profileOut(__METHOD__);
		return $data;
	}

	public function saveData($data) {
		$this->wf->profileIn(__METHOD__);

		$this->memcSet($data);

		$this->wf->profileOut(__METHOD__);
	}

	protected function getDataFromProvider() {
		return $this->provider->getData();
	}

	public function purgeCache() {
		$this->wf->profileIn(__METHOD__);
		$this->memcSet(null);
		$this->wf->profileOut(__METHOD__);
	}
}