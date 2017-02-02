<?php

interface iBubbleMapElement {

	/**
	 * @param string $text
	 */
	public function setText( $text );

	/**
	 * @return string
	 */
	public function getText();

	/**
	 * @param \title $title
	 */
	public function setTitle( $title );

	/**
	 * @return \title
	 */
	public function getTitle();
}
