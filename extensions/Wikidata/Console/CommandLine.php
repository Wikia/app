<?php

/** 
 * Class CommandLineOption can be used to configure a command line option that
 * can be used with function parseCommandLine. One can configure the name of the
 * option, whether the option is required to be specified by the user and possibly
 * with values are possible for the option. By specifying null for $possibleValues
 * no check will be performed on possible values.
 */

class CommandLineOption {
	protected $name;
	protected $isRequired;
	protected $possibleValues;
	
	public function __construct($name, $isRequired, $possibleValues = null) {
		$this->name = $name;
		$this->isRequired = $isRequired;
		$this->possibleValues = $possibleValues;
	}
	
	public static function getOptionWithName(array &$options, $option) {
		$result = null;
		$i = 0;
		
		while ($result == null && i < count($options))
			if ($options[$i]->name == $option)
				$result = $options[$i];
			else
				$i++;
				
		return $result;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function isRequired() {
		return $this->isRequired;
	}
	
	public function getPossibleValues() {
		return $this->possibleValues;
	}
	
	public function valueIsValid($value) {
		return $this->possibleValues == null || in_array($value, $this->possibleValues); 
	}
}

/**
 * Parses the command line using the array of CommandLineOptions. The result of this function
 * is an array mapping option names to the specified values. If no option is specified on the
 * command line it will not be included in the resulting map. If an  * an illegal option is 
 * encountered or a required option is not specified, an error message will be displayed and
 * the application stops.
 */

function parseCommandLine(array $options) {
	global
		$argv;
	
	$result = array();
	$allValid = true;
	
	foreach ($argv as $arg) {
		if (substr($arg, 0, 2) == '--') {
			$arg = substr($arg, 2);
			$equalsPosition = strpos($arg, "=");
			
			if ($equalsPosition !== false) {
				$option = substr($arg, 0, $equalsPosition);
				$value = substr($arg, $equalsPosition + 1);
				
				$commandLineOption = CommandLineOption::getOptionWithName($options, $option);
				
				if ($commandLineOption != null) {
					$result[$option] = $value;
					
					if (!$commandLineOption->valueIsValid($value)) {
						$allValid = false;					
						echo "Invalid value for option \"" . $option . "\": " . $value . "\n";
					}
				}
				else {
					$allValid = false;
					echo "Invalid option: " . $option . "\n";
				}
			}
			else
				$result[$arg] = null;
		}
	}
	
	foreach ($options as $option)
		if ($option->isRequired() && !array_key_exists($option->getName(), $result)) {
			$allValid = false;
			echo "Missing option: " . $option->getName() . "\n";
		}
	
	if (!$allValid)
		die();
	
	return $result;
}

?>
