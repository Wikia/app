<?PHP
if (! defined ('MEDIAWIKI'))
{
    echo ('THIS IS NOT VALID ENTRY POINT.'); exit (1);
}
else
{
    if (true)
        $wgExtensionFunctions [] = 'InitializePopularArticles';

    $wgHooks ['MonoBookTemplatePopularArticles'] [] = 'PopularArticlesPrintContent';

    function InitializePopularArticles ()
    {
        global $wgWhitelistRead;
        $wgWhitelistRead [] = 'Special:PopularArticles';

        global $PopularArticlesURL;
        global $wgExtensionFunctions;

        if (! isset ($PopularArticlesURL))
            $PopularArticlesURL = Title::NewFromText ('PopularArticles', NS_SPECIAL)->GetFullURL () . '?q=';

        SpecialPage::AddPage (new SpecialPage ('PopularArticles', '', false, 'wfSpecialPopularArticles', false));
    }

    function wfSpecialPopularArticles ()
    {
	    if ((int) $_REQUEST ['q'] > 0)
	        exit (PopularArticlesGetContent (-1));
	    if ((int) $_REQUEST ['q'] < 0)
	        exit (PopularArticlesGetContent (+1));
    }
}

	function PopularArticlesSaveIndex ($i)
	{
    	    global $wgCookiePrefix;
	    setcookie ($wgCookiePrefix . '_PopularArticlesIndex', $i);
	}
	function PopularArticlesLoadIndex ()
	{
	    global $wgCookiePrefix;
	    return (int) (isset ($_COOKIE [$wgCookiePrefix . '_PopularArticlesIndex']) ? $_COOKIE [$wgCookiePrefix . '_PopularArticlesIndex'] : 0);
	}

    function PopularArticlesGetContent ($i = 0)
    {
        $baseTitle = Title::NewFromText ('PopularArticles', NS_TEMPLATE);

        if (! $baseTitle->Exists ())
            return false;

        $baseArticle = new Article ($baseTitle);

        $linesList = explode ("\n\n", $baseArticle->GetContent ());

        if (! count ($linesList))
            return false;

        global $wgCookiePrefix;

        $baseLineIndex = PopularArticlesLoadIndex () + $i;

        if ($baseLineIndex > count ($linesList) - 1)
            $baseLineIndex = $baseLineIndex % count ($linesList);
        if ($baseLineIndex < 0)
            $baseLineIndex = count ($linesList) + $baseLineIndex;

        PopularArticlesSaveIndex ($baseLineIndex);

        global $wgOut;

        for ($k = 0; $k < 3; $k ++, $baseLineIndex ++)
        {
	        if ($baseLineIndex > count ($linesList) - 1)
	            $baseLineIndex = $baseLineIndex % count ($linesList);
	        if ($baseLineIndex < 0)
	            $baseLineIndex = count ($linesList) + $baseLineIndex;

	        $v .= $wgOut->Parse ($linesList [$baseLineIndex]);
        }

        return $v;
    }

    function PopularArticlesPrintContent ($foo)
    {
        if (($v = PopularArticlesGetContent ()) === false)
            return false;

        #$URL = Title::NewFromText ('PopularArticles', NS_SPECIAL)->GetFullURL () . '?q=';
        global $PopularArticlesURL;
        
        echo '
		<script type="text/javascript">
	        function GetPopularArticles (i)
			{
				var o = (window.ActiveXObject) ? new ActiveXObject ("Microsoft.XMLHTTP") : new XMLHttpRequest ();
				if (o)
				{
					o.onreadystatechange = function ()
					{
						if (o.readyState == 4 && o.status == 200 && o.responseText != "")
						{
							document.getElementById ("p-popular-articles-b").innerHTML = o.responseText;
						}
					}
					o.open ("GET", "' . $PopularArticlesURL . '" + i);
					o.send (null);
				}
				return false;
			}
			setInterval ("GetPopularArticles (\'-1\')", 10000);
		</script>
		<div class="portlet" id="p-popular-articles">
	        <h5>' . wfMsgHtml ('popular-articles') . '</h5>
	                <div class="pBody">
	                        <div id="p-popular-articles-b">' . $v . '</div>
<!--
	                        <hr />
	                        <div style="float:left;font-size: 95%;"><a href="#" onClick="return GetPopularArticules (\'+1\');">' . wfMsgHtml ('allpagesprev') . '</a></div>
	                        <div style="float:right;font-size: 95%;"><a href="#" onClick="return GetPopularArticules (\'-1\');">' . wfMsgHtml ('allpagesnext') . '</a></div>
	                        <br style="clear:both"/>
 -->
	                </div>
	        </div>'
        ;
    }

?>
