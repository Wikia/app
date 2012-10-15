{include file="header.tpl" eltype="Procedural file" class_name=$name hasel=true contents=$pagecontents}

<a name="sec-description"></a>
<h2>Page Details</h2>
<div class="docblock">
{include file="docblock.tpl" type="page" desc=$desc sdesc=$sdesc}
</div>
{include file="filetags.tpl" tags=$tags}

{if $tutorial}
  <hr class="separator" />
  <div class="notes">Tutorial: <span class="tutorial">{$tutorial}</div>
{/if}

{if $classes}
  <a name="sec-classes"></a>
  <h2>Classes</h2>
  <table class="detail">
    <thead>
      <tr>
        <th>Class</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      {section name=classes loop=$classes}
        <tr>
          <td>{$classes[classes].link}</td>
          <td>
            {if $classes[classes].sdesc}
              {$classes[classes].sdesc}
            {else}
              {$classes[classes].desc}
            {/if}
          </td>
        </tr>
      {/section}
    </tbody>
  </table>
{/if}

{if $includes}
  <a name="sec-includes"></a>
  <h2>Includes</h2>
  {include file="include.tpl"}
{/if}

{if $defines}
  <a name="sec-constants"></a>
  <h2>Constants</h2>
  {include file="define.tpl"}
{/if}

{if $globals}
  <a name="sec-variables"></a>
  <h2>Globals</h2>
  {include file="global.tpl"}
{/if}

{if $functions}
  <a name="sec-functions"></a>
  <h2>Functions</h2>
  {include file="function.tpl"}
{/if}

{include file="footer.tpl" top3=true}
