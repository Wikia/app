<?php
$cseform = <<<END
<form id="searchbox" action="%s" method="GET">
  <input type="hidden" name="cx" value="%s" />
  <input name="q" type="text" size="40"/>
  <input type="submit" name="sa" value="%s" title="%s"/>
  <input type="hidden" name="cof" value="FORID:9" />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="http://images.wikia.com/central/images/7/7c/Beta2.png" />
</form>
<script type="text/javascript" src="http://google.com/coop/cse/brand?form=searchbox_008008978358591396332%%3Awxqn922vg8i"></script>
END;

$luceneform = <<<END
<form id="searchbox" action="%s" method="GET">
  <input type="hidden" name="tab" value="%s" />
  <input name="search" type="text" size="40" value="%s"/>
  <input type="submit" value="%s" title="%s" />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <img src="http://images.wikia.com/central/images/7/7c/Beta2.png" />
</form>
END;

$cseresultsbox = <<<END
<div id="results_008008978358591396332:wxqn922vg8i"></div>
<script type="text/javascript">
  var googleSearchIframeName = "results_008008978358591396332:wxqn922vg8i";
  var googleSearchFormName = "searchbox";
  var googleSearchFrameWidth = 600;
  var googleSearchFrameborder = 0;
  var googleSearchDomain = "google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
END;

$luceneresulttemplate = <<<END
<div class="searchtitle"><a href="%s">%s</a></div>
<div class="searchfragment">%s<br clear="all" /></div>
<span class="searchfooter"><a href="%s">%s</a> - %s - %s</span>
END;

$tabstemplate = <<<END
<br />
<div class="box_search_tabs_parent">
	<ul class="box_search_tabs">
		%s
	</ul>
</div>
END;

$activetabtemplate = <<<END
<li class="active_tab"><a title="%s">%s</a></li>
END;

$disabledtabtemplate = <<<END
<li class="disabled_tab"><a title="%s">%s</a></li>
END;

$tabtemplate = <<<END
<li><a href="%s" title="%s">%s</a></li>
END;

$resultsnum = <<<END
<div class="wikiasearch">
<div class="wikiasearch_left">%s</div>
<div class="wikiasearch_right">%s</div>
<br style="clear:both" />
</div>
END;
//<h2 class="wikiasearch">%s</h2>

$noresults = <<<END
<br />%s
END;

$searchpager = <<<END
<div class="wikiasearchpager">%s</div>
END;

$nextprevlink = <<<END
<a href="%s" title="%s">%s</a>
END;


?>
