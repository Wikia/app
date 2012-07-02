<?php

/**
 * This class extends QuickTemplate, adding two things:
 * 1) A constructor that takes a data array as an argument (rather than requiring it to be set later)
 * 2) Adds a method for displaying an array of error strings, given a target field.
 *
 * @author bharris
 */
abstract class TradeTrackScreen extends QuickTemplate {

  public function __contruct( array $data ) {
  	$this->data = $data;
  }

  /**
   * This displays a list of error messages for a single field.
   *
   * @param $target The target field for the errors.
   */
  public function showErrors( $target ) {
    $errors = $this->data['errors'];
    if ( ( isset( $errors ) ) && ( isset( $errors[$target] ) ) ) {
      $eList = $errors[$target];
      $theHTML = '<ul class="tradetrack-errors">';
      foreach ( $eList as $e ) {
		$theHTML .= '<li>' . $e . '</li>';
	  }
      $theHTML .= '</ul>';
      echo $theHTML;
    }
    return;
  }
  /**
   * Tests whether or not a specified target has an error.
   *
   * @param $target The target field
   * @return boolean true or false, depending.
   */
  public function hasError ( $target ) {
    $errors = $this->data['errors'];
    if ( ( isset( $errors ) ) && ( isset( $errors[$target] ) ) ) {
        return true;
    }
    return false;
  }

}