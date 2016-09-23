<?php

class LocalSitemapPageArticle extends Article {
	public function view() {
		$page = new LocalSitemapSpecialPage();
		$page->execute( null );
	}
}
