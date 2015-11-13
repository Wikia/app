<?php

class AdRecoveryEngine {

	static public function getInlineCode($providerName) {
		$provider = self::getProvider($providerName);

		return $provider->getInlineCode();
	}

	static private function getProvider($providerName) {
		switch ($providerName) {
			case 'GCS':
				return new GCSRecoveryProvider();
		}
	}

}
