--TEST--
Mail2_RFC822::parseAddressList does not accept RFC-valid group syntax
--FILE--
<?php
require "Mail2/RFC822.php";
$rfc = new Mail2_RFC822();
var_dump($rfc->parseAddressList("empty-group:;","invalid",false,false)); 

--EXPECT--
array(0) {
} 
