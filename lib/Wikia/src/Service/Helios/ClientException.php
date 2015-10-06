<?php

namespace Wikia\Service\Helios;


class ClientException extends Exception
{
	protected function logMe() {
		$this->error( 'HELIOS_CLIENT client_exception' );
	}
}
