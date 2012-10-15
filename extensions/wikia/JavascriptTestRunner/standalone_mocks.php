<?php

	class SpecialPage {
		
		public function __construct() {}
		public function setHeaders() {}
	}
	
	class Wikia {
		public function json_encode( $what ) {
			return json_encode($what);
		}
		public function json_decode( $what, $assoc = false ) {
			return json_decode($what,$assoc);
		}
	}
	
	class AssetsManager {
		/** @return AssetsManager */
		static public function getInstance() { 
			return new AssetsManager(); 
		}
		public function getGroupLocalURL( $group ) {
			global $wgAssetsManagerQuery, $wgCacheBuster;
			return sprintf($wgAssetsManagerQuery,
				/* 1 */ "group",
				/* 2 */ $group,
				/* 3 */ urlencode(http_build_query(array())),
				/* 4 */ $wgCacheBuster);
		}
	}
	
	class WebRequest {
		
		public function getVal( $var, $default = null ) {
			if (isset($_REQUEST[$var]))
				return $_REQUEST[$var];
			else
				return $default;
		}
	}
	
	class OutputPage {
		
		protected $scripts = "";
		protected $styles = "";
		protected $html = "";
		
		public function addScript( $script ) {
			$this->scripts .= $script . "\n";
		}
		public function addStyle( $style ) {
			$this->styles .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".htmlspecialchars($style)."\" />\n";
		}
		public function addInlineScript( $script ) {
			$this->scripts .= "<script type=\"text/javascript\">/*<![CDATA[*/{$script}/*]]>*/</script>\n";
		}
		public function addHtml( $html ) {
			$this->html .= $html;
		}
		
		public function flush() {
			echo "<html><head>\n<title>Javascript Test Runner</title>\n{$this->styles}\n{$this->scripts}\n</head>\n"
				."<body>\n<div id=\"WikiaArticle\">\n{$this->html}\n</div>\n</body></html>";
		}
		
	}
	
	class User {
		
		public function isAllowed() {
			return true;
		}
		
	}
	
	
	$wgRequest = new WebRequest();
	$wgOut = new OutputPage();
	$wgUser = new User();
	
	$wgServer = sprintf("%s://%s",
		isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https" : "http",
		isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']
		);
	$wgScriptPath = "/";
	
	$wgAssetsManagerQuery = '/index.php?action=ajax&rs=AssetsManagerEntryPoint&__am&type=%1$s&cb=%4$d&params=%3$s&oid=%2$s';
	
	