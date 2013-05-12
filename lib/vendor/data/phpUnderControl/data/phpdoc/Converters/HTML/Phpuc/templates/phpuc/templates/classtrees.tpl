{include file="header.tpl" noleftindex=true}
  <h2>{$title}</h2>
  {if $interfaces}
    {section name=classtrees loop=$interfaces}
      <hr />
      {$interfaces[classtrees].class_tree}
    {/section}
  {/if}
  {if $classtrees}
    {section name=classtrees loop=$classtrees}
      <hr />
      {$classtrees[classtrees].class_tree}
    {/section}
  {/if}
{include file="footer.tpl"}
