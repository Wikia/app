<?php

/**
 * @method getSourceId
 * @method getCityId
 * @method getUserId
 * @method getEmail
 * @method getFeedback
 * @method setSourceId
 * @method setCityId
 * @method setUserId
 * @method setEmail
 * @method setFeedback
 * @method setBeaconId
 */
class EmailsStorageEntry {

	private $app;

	/* @var EmailsStorage */
	private $storage;

	private $data = array(
		'source_id' => null,
		'page_id' => null,
		'city_id' => null,
		'email' => null,
		'user_id' => null,
		'beacon_id' => null,
		'feedback' => null,
	);

	/**
	 * Setup instance of EmailsStorageEntry
	 *
	 * @param int $sourceId type of source (see EmailsStorage class for constants with sources definition)
	 */
	public function __construct(WikiaApp $app, $sourceId) {
		$this->app = $app;
		$this->setSourceId($sourceId);

		// set default values
		$this->setCityId($this->app->wg->CityId);
		$this->setUserId($this->app->wg->User->getId());
		$this->setBeaconId(wfGetBeaconId());
	}

	/**
	 * Sets the instance of emails storage to be used to save current entry in database
	 *
	 * @param EmailsStorage $storage instance of emails storage
	 */
	public function setStorage(EmailsStorage $storage) {
		$this->storage = $storage;
	}

	/**
	 * Stores given entry in database
	 *
	 * @return int ID of added entry
	 */
	public function store() {
		$id = $this->storage->store($this);

		Wikia::log(__METHOD__, false,
			sprintf('address <%s> from source #%d stored as #%d',  $this->getEmail(),$this->getSourceId(), $id));

		return $id;
	}

	/**
	 * Use __call magic PHP function to provide setters / getters interface
	 *
	 * Example:
	 *  $this->setEmail('foo@bar.net');
	 *  $foo = $this->getUserId();
	 */
	public function __call($name, $args) {
		$method = substr($name, 0, 3);

		// translate "PageId" to "page_id"
		$key = strtolower(str_replace('Id', '_id', substr($name, 3)));

		switch($method) {
			case 'get':
				if (array_key_exists($key, $this->data)) {
					return $this->data[$key];
				}
				break;

			case 'set':
				if (array_key_exists($key, $this->data)) {
					$this->data[$key] = $args[0];
				}
				break;
		}
	}
}
