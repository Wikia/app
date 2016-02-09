<?php

namespace Wikia\ExactTarget;

interface ExactTargetApiProvider {

	public function getApiDataExtension();
	public function getApiSubscriber();

}
