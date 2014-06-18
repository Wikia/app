<?php

class PromoXWikiImage extends BaseXWikiImage {
	protected function getContainerDirectory() {
		return "/images/p/promote/images";
	}

	protected function getSwiftContainer() {
		return "promote";
	}

	protected function getSwiftPathPrefix() {
		return "/images";
	}
}
