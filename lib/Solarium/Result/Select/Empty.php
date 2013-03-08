<?php 
/**
 * An empty result class used when a search fails
 * @author relwell
 *
 */
class Solarium_Result_Select_Empty extends Solarium_Result_Select
{
	// Default values
	protected $_documents		= array();
	protected $_numfound		= 0;
	protected $_queryTime		= 0;
	protected $_status			= 200;
	protected $_components		= array();
	
	// Used to overwrite required params
	public function __construct()
	{
		
	}
	
	// Used to overwrite response parsing
	protected function _parseResponse()
	{
		
	}
	
	public function getData()
	{
		return array();
	}
	
}