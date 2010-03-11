<?php

if( empty( $wgSessionsInMemcached ) && !empty( $wgSessionsInTokyoTyrant ) ) {
	session_set_save_handler(
		array('TokyoTyrantSession','__open'),
		array('TokyoTyrantSession','__close'),
		array('TokyoTyrantSession','__read'),
		array('TokyoTyrantSession','__write'),
		array('TokyoTyrantSession','__destroy'),
		array('TokyoTyrantSession','__gc')
	);
}
