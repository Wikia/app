<?php
/**
 * @author ADi
 */
class ImageObjectRenderer extends SDElementRenderer {

	public function render() {
		return '<img src="' . $this->object->getProperty('schema:thumbnailUrl') . '" />';
	}
}
