<?php

namespace Wikia\HTTP;

interface Response {
	public function setcookie($name, $value, $ttl, $prefix=null, $domain=null);
}
