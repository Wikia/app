<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeData extends Node {
	const SPAN_ATTR_NAME = 'span';
	const SPAN_DEFAULT_VALUE = 1;

	const LAYOUT_ATTR_NAME = 'layout';
	const LAYOUT_DEFAULT_VALUE = 'default';

	public function getData() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'label' => $this->getInnerValue( $this->xmlNode->{self::LABEL_TAG_NAME} ),
				'value' => $this->getValueWithDefault( $this->xmlNode ),
				'span' => $this->getSpan(),
				'layout' => $this->getLayout()
			];
		}

		return $this->data;
	}

	protected function getSpan() {
		$span = $this->getXmlAttribute( $this->xmlNode, self::SPAN_ATTR_NAME );

		return ( isset( $span ) && ctype_digit( $span ) ) ? intval( $span ) : self::SPAN_DEFAULT_VALUE;
	}

	protected function getLayout() {
		$layout = $this->getXmlAttribute( $this->xmlNode, self::LAYOUT_ATTR_NAME );

		return ( isset( $layout ) && $layout == self::LAYOUT_DEFAULT_VALUE ) ? $layout : null;
	}
}
