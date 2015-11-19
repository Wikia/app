<?php

namespace Wikia\Service;

class Constants {
	/**
	 * Name of the header used to authenticate user requests to the Helios service.
     */
	const HELIOS_AUTH_HEADER = "X-Wikia-UserId";

	const HTTP_STATUS_NO_CONTENT = 204;

	const HTTP_STATUS_SERVER_ERROR = 500;

	const HTTP_STATUS_FORBIDDEN = 403;

	const HTTP_STATUS_OK = 200;
}
