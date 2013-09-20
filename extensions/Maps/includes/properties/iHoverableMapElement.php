<?php

interface iHoverableMapElement {
	/**
	 * @param $visible
	 */
	public function setOnlyVisibleOnHover( $visible );

	/**
	 * @return mixed
	 */
	public function isOnlyVisibleOnHover();
}
