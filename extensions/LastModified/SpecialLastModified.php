<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author		Katie Horn <khorn@wikimedia.org>, Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "LastModified extension\n";
	exit( 1 );
}

/**
 * Show LastModified options 
 */
class SpecialLastModified extends UnlistedSpecialPage {
	
	public function __construct() {
		// Register special page
		parent::__construct( 'LastModified' );
	}
	
	public function execute( $sub ) {
		
		global $wgLastModifiedRange;
		
		$this->setHeaders();
		$this->outputHeader();
		
		$out = $this->getOutput();

		$out->addHTML( Xml::openElement( 'h2' ) );
		$out->addHTML( wfMsg( 'lastmodified-options' ) );
		$out->addHTML( Xml::closeElement( 'h2' ) );

		$out->addHTML( Xml::openElement( 'p' ) );
		$out->addHTML( wfMsg( 'lastmodified-display-range-value' ) . ' ' . $wgLastModifiedRange );
		$out->addHTML( Xml::closeElement( 'p' ) );

		$rangeMessage  = wfMsg( 'lastmodified-display' ) . ' ';
		$rangeMessageDatetime = '';
		
		$displayRange = array(
			0 => 'years',
			1 => 'months',
			2 => 'days',
			3 => 'hours',
			4 => 'minutes',
			5 => 'seconds',
		);
		
		// Display seconds
		foreach ( $displayRange as $key => $value ) {

			// Check to see which values to display.
			if ( $wgLastModifiedRange == 0 || $key >= $wgLastModifiedRange ) {
				
				// append a comma if necessary
				$rangeMessageDatetime .= empty($rangeMessageDatetime) ? '' : ', ';

				// append message
				$rangeMessageDatetime .= wfMsg( 'lastmodified-label-' . $value );
			}
		}
		
		$rangeMessage .= $rangeMessageDatetime;
		
		$out->addHTML( Xml::openElement( 'p' ) );
		$out->addHTML( $rangeMessage );
		$out->addHTML( Xml::closeElement( 'p' ) );
	}
}
