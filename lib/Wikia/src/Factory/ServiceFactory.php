<?php
namespace Wikia\Factory;

class ServiceFactory {
	/** @var ServiceFactory $instance */
	private static $instance;

	/** @var HeliosFactory $heliosFactory */
	private $heliosFactory;

	/** @var ProviderFactory $providerFactory */
	private $providerFactory;

	/** @var AttributesFactory $attributesFactory */
	private $attributesFactory;

	/** @var ExternalAuthFactory $externalAuthFactory */
	private $externalAuthFactory;

	/** @var PreferencesFactory $preferencesFactory */
	private $preferencesFactory;

	/** @var PermissionsFactory $permissionsFactory */
	private $permissionsFactory;

	/** @var PurgerFactory $purgerFactory */
	private $purgerFactory;
	
	/** @var RabbitFactory $rabbitFactory */
	private $rabbitFactory;

	public function heliosFactory(): HeliosFactory {
		if ( $this->heliosFactory === null ) {
			$this->heliosFactory = new HeliosFactory( $this );
		}

		return $this->heliosFactory;
	}

	public function providerFactory(): ProviderFactory {
		if ( $this->providerFactory === null ) {
			$this->providerFactory = new ProviderFactory();
		}

		return $this->providerFactory;
	}

	public function attributesFactory(): AttributesFactory {
		if ( $this->attributesFactory === null ) {
			$this->attributesFactory = new AttributesFactory( $this );
		}

		return $this->attributesFactory;
	}

	public function externalAuthFactory(): ExternalAuthFactory {
		if ( $this->externalAuthFactory === null ) {
			$this->externalAuthFactory = new ExternalAuthFactory( $this );
		}

		return $this->externalAuthFactory;
	}

	public function preferencesFactory(): PreferencesFactory {
		if ( $this->preferencesFactory === null ) {
			$this->preferencesFactory = new PreferencesFactory( $this );
		}

		return $this->preferencesFactory;
	}

	public function permissionsFactory(): PermissionsFactory {
		if ( $this->permissionsFactory === null ) {
			$this->permissionsFactory = new PermissionsFactory( $this );
		}

		return $this->permissionsFactory;
	}

	public function purgerFactory(): PurgerFactory {
		if ( $this->purgerFactory === null ) {
			$this->purgerFactory = new PurgerFactory( $this );
		}

		return $this->purgerFactory;
	}
	
	public function rabbitFactory(): RabbitFactory {
		if ( $this->rabbitFactory === null ) {
			$this->rabbitFactory = new RabbitFactory( $this );
		}

		return $this->rabbitFactory;
	}

	public static function clearState() {
		static::$instance = null;
	}

	public static function instance(): ServiceFactory {
		if ( static::$instance === null ) {
			static::$instance = new self();
		}

		return static::$instance;
	}
}
