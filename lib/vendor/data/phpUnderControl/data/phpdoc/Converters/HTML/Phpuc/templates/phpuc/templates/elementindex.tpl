{include file="header.tpl" noleftindex=true}
<a name="top"></a>
<h2>Index of All Elements</h2>
<h3>Package Indexes</h3>
<ul>
{section name=p loop=$packageindex}
	<li><a href="elementindex_{$packageindex[p].title}.html">{$packageindex[p].title}</a></li>
{/section}
</ul>
<br />
{include file="basicindex.tpl" indexname="elementindex"}
{include file="footer.tpl"}
