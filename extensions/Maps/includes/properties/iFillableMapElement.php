<?php

interface iFillableMapElement {
	/**
	 * @return
	 */
	public function getFillOpacity();

	/**
	 * @param  $fillOpacity
	 */
	public function setFillOpacity( $fillOpacity );

	/**
	 * @return
	 */
	public function getFillColor();

	/**
	 * @param  $fillColor
	 */
	public function setFillColor( $fillColor );

}