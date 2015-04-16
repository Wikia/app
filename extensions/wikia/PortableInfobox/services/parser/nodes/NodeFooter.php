<?php
namespace Wikia\PortableInfobox\Parser\Nodes;

class NodeFooter extends Node {
	const LINKS_TAG_NAME = 'links';

	public function getData() {
		$data = [];
		$data['links'] = (string) $this->xmlNode->{self::LINKS_TAG_NAME};
		return $data;
	}
}
