<?php

interface iLinkableMapElement {
	/**
	 * @param $link
	 */
	public function setLink( $link );

	/**
	 * @return mixed
	 */
	public function getLink();
}
