<?php

namespace Wikia\PortableInfobox\Helpers;

class PagePropsProxy {

	public function get( $id, $property ) {
		return \Wikia::getProps( $id, $property );
	}

	public function set( $id, $data ) {
		\Wikia::setProps( $id, $data );
	}

}
