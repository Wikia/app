<?php
/**
 * Class definition for \Wikia\Search\ResultSet\DependencyContainer
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\Config, \Solarium_Result_Select, \Wikia\Search\MediaWikiService, \Wikia\Search\Traits, \Wikia\Search\Match\Wiki;
/**
 * This allows us to encapsulate all dependencies and send a single object to Wikia\Search\ResultSet\Factory
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class DependencyContainer
{
	use Traits\ArrayConfigurableTrait;
	
	/**
	 * Search Config
	 * @var Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * Solarium Result
	 * @var Solarium_Result_Select
	 */
	protected $result;
	
	/**
	 * MediaWikiService
	 * @var MediaWikiService
	 */
	protected $service;

	/**
	 * Constructor class. Basically allows us to pre-populate the $service property and configure by array rather than separate invocations.
	 * @param array $dependencies optional method of prepopulating the dependencies. Can also call mutators.
	 */
	public function __construct( array $dependencies = array() ) {
		$this->setService( (new \Wikia\Search\ProfiledClassFactory)->get( 'Wikia\Search\MediaWikiService' ) )
		     ->configureByArray( $dependencies );
	}
	
	/**
	 * Accessor method for config.
	 * @return Wikia\Search\Config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * Accessor method for result.
	 * @return Solarium_Result_Select
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Accessor method for interface.
	 * @return \Wikia\Search\MediaWikiService
	 */
	public function getService() {
		return $this->service;
	}

	/**
	 * Mutator for config.
	 * @param Config $config
	 * @return DependencyContainer
	 */
	public function setConfig( Config $config ) {
		$this->config = $config;
		return $this;
	}

	/**
	 * Mutator for result.
	 * @param Solarium_Result_Select $result
	 * @return DependencyContainer
	 */
	public function setResult( Solarium_Result_Select $result ) {
		$this->result = $result;
		return $this;
	}

	/**
	 * Mutator for interface.
	 * @param MediaWikiService $service
	 * @return DependencyContainer
	 */
	public function setService( MediaWikiService $service ) {
		$this->service = $service;
		return $this;
	}
}