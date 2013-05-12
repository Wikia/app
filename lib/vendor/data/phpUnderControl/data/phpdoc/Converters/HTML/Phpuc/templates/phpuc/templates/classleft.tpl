{foreach key=subpackage item=files from=$classleftindex}
  <ul>
	{if $subpackage != ""}<li>{$subpackage}{/if}
	{section name=files loop=$files}
    {if $subpackage != ""}<ul>{/if}
		{if $files[files].link != ''}<li><a href="{$files[files].link}">{/if}{$files[files].title}{if $files[files].link != ''}</a></li>{/if}
    {if $subpackage != ""}</ul></li>{/if}
	{/section}
  </ul>
{/foreach}
