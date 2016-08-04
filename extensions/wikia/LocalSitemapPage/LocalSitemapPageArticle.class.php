<?php

class LocalSitemapPageArticle extends Article {
	public function view() {
		$sap = new LocalSitemapSpecialPage();
		$sap->execute( null );
	}
}
