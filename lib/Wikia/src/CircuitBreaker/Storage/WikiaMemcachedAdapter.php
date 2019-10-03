<?php
namespace Wikia\CircuitBreaker\Storage;

use Ackintosh\Ganesha;
use Ackintosh\Ganesha\Configuration;
use Ackintosh\Ganesha\Exception\StorageException;
use Ackintosh\Ganesha\Storage;
use Ackintosh\Ganesha\Storage\Adapter\TumblingTimeWindowInterface;
use Ackintosh\Ganesha\Storage\AdapterInterface;

class WikiaMemcachedAdapter implements AdapterInterface, TumblingTimeWindowInterface
{
    /**
     * @var \Memcached
     */
    private $memcached;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * Memcached constructor.
     * @param \Memcached $memcached
     */
    public function __construct(\Memcached $memcached)
    {
        $this->memcached = $memcached;
    }

    /**
     * @param Configuration $configuration
     * @return void
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $service
     * @return int
     * @throws StorageException
     */
    public function load($service)
    {
        $r = (int)$this->memcached->get($service);
        $this->throwExceptionIfErrorOccurred();
        return $r;
    }

    /**
     * @param string $service
     * @param int $count
     * @return void
     * @throws StorageException
     */
    public function save($service, $count)
    {
        if (!$this->memcached->set($service, $count)) {
            throw new StorageException('failed to set the value : ' . $this->memcached->getResultMessage());
        }
    }

    /**
     * @param string $service
     * @return void
     * @throws StorageException
     */
    public function increment($service)
    {
    	if ($this->memcached->get($service) === false) {
    		if ($this->memcached->set($service, 1) === false) {
				throw new StorageException('failed to increment failure count : ' . $this->memcached->getResultMessage());
			}
		} else if ($this->memcached->increment($service, 1) === false) {
            throw new StorageException('failed to increment failure count : ' . $this->memcached->getResultMessage());
        }
    }

    /**
     * @param string $service
     * @return void
     * @throws StorageException
     */
    public function decrement($service)
    {
		if ($this->memcached->get($service) === false) {
			if ($this->memcached->set($service, 0) === false) {
				throw new StorageException('failed to increment failure count : ' . $this->memcached->getResultMessage());
			}
		} else if ($this->memcached->decrement($service, 1) === false) {
            throw new StorageException('failed to decrement failure count : ' . $this->memcached->getResultMessage());
        }
    }

    /**
     * @param string $service
     * @param int    $lastFailureTime
     * @throws StorageException
     */
    public function saveLastFailureTime($service, $lastFailureTime)
    {
        if (!$this->memcached->set($service, $lastFailureTime)) {
            throw new StorageException('failed to set the last failure time : ' . $this->memcached->getResultMessage());
        }
    }

    /**
     * @param  string $service
     * @return int
     * @throws StorageException
     */
    public function loadLastFailureTime($service)
    {
        $r = $this->memcached->get($service);
        $this->throwExceptionIfErrorOccurred();
        return $r;
    }

    /**
     * @param string $service
     * @param int    $status
     * @throws StorageException
     */
    public function saveStatus($service, $status)
    {
        if (!$this->memcached->set($service, $status)) {
            throw new StorageException('failed to set the status : ' . $this->memcached->getResultMessage());
        }
    }

    /**
     * @param  string $service
     * @return int
     * @throws StorageException
     */
    public function loadStatus($service)
    {
        $status = $this->memcached->get($service);
        $this->throwExceptionIfErrorOccurred();
        if ($status === false && $this->memcached->getResultCode() === \Memcached::RES_NOTFOUND) {
            $this->saveStatus($service, Ganesha::STATUS_CALMED_DOWN);
            return Ganesha::STATUS_CALMED_DOWN;
        }

        return $status;
    }

    public function reset()
    {
        if (!$this->memcached->getStats()) {
            throw new \RuntimeException('Couldn\'t connect to memcached.');
        }

        $keys = $this->memcached->getAllKeys();
        if (!$keys) {
            $resultCode = $this->memcached->getResultCode();
            if ($resultCode === 0) {
                // no keys
                return;
            }
            $message = sprintf(
                'failed to get memcached keys. resultCode: %d, resultMessage: %s',
                $resultCode,
                $this->memcached->getResultMessage()
            );
            throw new \RuntimeException($message);
        }

        foreach ($keys as $k) {
            if ($this->isGaneshaData($k)) {
                $this->memcached->delete($k);
            }
        }
    }

    public function isGaneshaData($key)
    {
        $regex = sprintf(
            '#\A%s.+(%s|%s|%s|%s|%s)\z#',
            Storage::KEY_PREFIX,
            Storage::KEY_SUFFIX_SUCCESS,
            Storage::KEY_SUFFIX_FAILURE,
            Storage::KEY_SUFFIX_REJECTION,
            Storage::KEY_SUFFIX_LAST_FAILURE_TIME,
            Storage::KEY_SUFFIX_STATUS
        );

        return preg_match($regex, $key) === 1;
    }

    /**
     * Throws an exception if some error occurs in memcached.
     *
     * @return void
     * @throws StorageException
     */
    private function throwExceptionIfErrorOccurred()
    {
        $errorResultCodes = [
            \Memcached::RES_FAILURE,
            \Memcached::RES_SERVER_TEMPORARILY_DISABLED,
            \Memcached::RES_SERVER_MEMORY_ALLOCATION_FAILURE,
        ];

        if (in_array($this->memcached->getResultCode(), $errorResultCodes, true)) {
            throw new StorageException($this->memcached->getResultMessage());
        }
    }
}
