<?php

/**
 * Base class for API classes of extension. Contains common methods.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

use Wikia\Logger\Loggable;

abstract class FlagsApiBaseController extends \WikiaApiController {
	use Loggable;

	const FLAGS_API_RESPONSE_STATUS = 'status';
	const FLAGS_API_RESPONSE_DATA = 'data';

	private $cache;
	protected $params;

	/**
	 * Returns new object of flags cache class
	 * @return mixed
	 */
	abstract protected function getNewCacheInstance();

	/**
	 * Returns a singleton instance of FlagsCache
	 * @return FlagsCache
	 */
	protected function getCache() {
		if ( !isset( $this->cache ) ) {
			$this->cache = $this->getNewCacheInstance();
		}
		return $this->cache;
	}

	/**
	 * Private methods
	 */

	/**
	 * Assigns a request's parameters to the object's property
	 * and sets a wiki_id if it hasn't been specified as one
	 * of the parameters.
	 */
	protected function getRequestParams() {
		$this->params = $this->request->getParams();
		if ( !isset( $this->params['wiki_id'] ) ) {
			$this->params['wiki_id'] = $this->wg->CityId;
		}
	}

	protected function makeSuccessResponse( $data ) {
		$this->response->setValues( [
			self::FLAGS_API_RESPONSE_STATUS => !empty( $data ),
			self::FLAGS_API_RESPONSE_DATA => $data,
		] );
	}

	/**
	 * Logging methods
	 */
	protected function logResponseException( \Exception $e, \WikiaRequest $request ) {
		$this->error(
			'FlagsLog Exception',
			[
				'exception' => $e,
				'prms' => $request->getParams(),
			]
		);
	}

}
