<?php
//Override variables when forced by $wgForceConsulDatacenter
$wgMemCachedServers = [
	0 => $wgWikiaEnvironment . '.twemproxy.service.' . $wgWikiaDatacenter . '.consul:21000',
	1 => $wgWikiaEnvironment . '.twemproxy.service.' . $wgWikiaDatacenter . '.consul:31000',
];

$wgSessionMemCachedServers = [
	0 => $wgWikiaEnvironment . '.twemproxy.service.' . $wgWikiaDatacenter . '.consul:31001',
	1 => $wgWikiaEnvironment . '.twemproxy.service.' . $wgWikiaDatacenter . '.consul:21001',
];

$wgPoolCounterServers = [ $wgWikiaEnvironment . '.kubernetes-lb-l4.service.' . $wgWikiaDatacenter . '.consul' ];

$wgRabbitHost = $wgWikiaEnvironment . '.rabbit.service.' . $wgWikiaDatacenter . '.consul';

$wgSMTP['host'] = $wgWikiaEnvironment . '.smtp.service.' . $wgWikiaDatacenter . '.consul';


