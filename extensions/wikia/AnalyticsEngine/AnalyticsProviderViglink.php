<?php

class AnalyticsProviderViglink implements iAnalyticsProvider
{

	const CODE = 'f373de7611f9700b1292ee6e50853615';

	function getSetupHtml( $params = array() )
	{
		return null;
	}

	function trackEvent( $event, $eventDetails = array() )
	{

		$code = json_encode([
			'key' => self::CODE
		]);

		switch ( $event ) {
			case AnalyticsEngine::EVENT_PAGEVIEW:
				$script = <<<SCRIPT
<!-- Begin Viglink Tag -->
<script type="text/javascript">
  var vglnk = {$code};

  (function(d, t) {
    var s = d.createElement(t); s.type = 'text/javascript'; s.async = true;
    s.src = '//cdn.viglink.com/api/vglnk.js';
    var r = d.getElementsByTagName(t)[0]; r.parentNode.insertBefore(s, r);
  }(document, 'script'));
</script>
<!-- End Viglink Tag -->
SCRIPT;

				return $script;
			default:
				return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}

}
