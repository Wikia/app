<?php

interface iBubbleMapElement {

	/**
	 * @param \text $text
	 */
	public function setText( $text );

	/**
	 * @return \text
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
