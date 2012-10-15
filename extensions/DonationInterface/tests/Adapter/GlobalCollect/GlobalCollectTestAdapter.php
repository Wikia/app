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
 *
 * @since		r100942
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * GlobalCollectTestAdapter
 */
class GlobalCollectTestAdapter extends GlobalCollectAdapter {
	
	/**
	 * This allows buildRequestXML() to be called for unit testing.
	 *
	 * @see GatewayAdapter::buildRequestXML()
	 */
	public function executeBuildRequestXML() {

		return $this->buildRequestXML();
	}
}

