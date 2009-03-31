<?php
/*
 * TrustBase.php
 * Copied from ExtensionClass.php by Jean-Lou Dupont (http://www.bluecortex.com)
 * 
 * Provides a base singleton for the Trust extension to build on.
 */

class TrustBase
{
  static $gObj; // singleton instance

  var $className;
  
  var $paramPassingStyle;
  var $ext_mgwords;	
  
  // Parameter passing style.
  const mw_style = 1;
  const tk_style = 2;
  
  public static function &singleton( $mwlist=null ,$globalObjName=null, 
				     $passingStyle = self::mw_style, $depth = 1,
				     $initFirst = false ){
    // Let's first extract the callee's classname
    $trace = debug_backtrace();
    $cname = $trace[$depth]['class'];
    
    // If no globalObjName was given, create a unique one.
    if ($globalObjName === null)
      $globalObjName = substr(create_function('',''), 1 );
    
    // Since there can only be one extension with a given child class name,
    // Let's store the $globalObjName in a static array.
    if (!isset(self::$gObj[$cname]) )
      self::$gObj[$cname] = $globalObjName; 
    
    if ( !isset( $GLOBALS[self::$gObj[$cname]] ) )
      $GLOBALS[self::$gObj[$cname]] = new $cname( $mwlist, $passingStyle, $depth, $initFirst );
    
    return $GLOBALS[self::$gObj[$cname]];
  }
  
  public function TrustBase( $mgwords=null, $passingStyle = self::mw_style, 
			     $depth = 1, $initFirst = false, $replaceHookList = null )
  /*
   *  $mgwords: array of 'magic words' to subscribe to *if* required.
   */
  {
    global $wgHooks;
    
    if ($passingStyle == null) $passingStyle = self::mw_style; // prevention...
    $this->paramPassingStyle = $passingStyle;
    
    // Let's first extract the callee's classname
    $trace = debug_backtrace();
    $this->className= $cname = $trace[$depth]['class'];
    // And let's retrieve the global object's name
    $n = self::$gObj[$cname];
    
    global $wgExtensionFunctions;
   
    // v1.8 feature
    $initFnc = create_function('',"global $".$n."; $".$n."->setup();");
    if ($initFirst)
      array_unshift(	$wgExtensionFunctions, $initFnc );
    else $wgExtensionFunctions[] = $initFnc;
    
  }
  public function getParamPassingStyle() { return $this->passingStyle; }
  public function setup()
  {
    
  }
  
} // end class definition.
?>