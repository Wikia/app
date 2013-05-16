<?php

interface iStrokableMapElement {
	/**
	 * @param  $strokeColor
	 */
	public function setStrokeColor( $strokeColor );

	/**
	 * @return
	 */
	public function getStrokeColor();

	/**
	 * @param  $strokeOpacity
	 */
	public function setStrokeOpacity( $strokeOpacity );

	/**
	 * @return
	 */
	public function getStrokeOpacity();

	/**
	 * @param  $strokeWeight
	 */
	public function setStrokeWeight( $strokeWeight );

	/**
	 * @return
	 */
	public function getStrokeWeight();
}
