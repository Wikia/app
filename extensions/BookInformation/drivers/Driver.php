<?php
/**
 * Book information driver interface
 *
 * A book information driver is a class which handles the work
 * of obtaining information about a given ISBN; see
 * docs/driver-info.htm for more details
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

interface BookInformationDriver {

	/**
	 * Submit a request to the information source and
	 * return the result
	 *
	 * @param string $isbn ISBN to obtain information for
	 * @return BookInformationResult
	 */
	public function submitRequest( $isbn );

}
