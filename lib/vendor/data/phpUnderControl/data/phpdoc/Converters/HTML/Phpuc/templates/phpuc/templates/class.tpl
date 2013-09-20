{include file="header.tpl" eltype="class" hasel=true contents=$classcontents}

<a name="sec-description"></a>
<h2>{if $is_interface}Interface{else}Class{/if} {$class_name}</h2>

{include file="docblock.tpl" type="class" sdesc=$sdesc desc=$desc}
		
{if $implements}
  <h2>Implements interfaces:</h2>
  <ul>
    {foreach item="int" from=$implements}<li>{$int}</li>{/foreach}
  </ul>
{/if}

{if $tutorial}
  <hr class="separator" />
  <div class="notes">Tutorial: <span class="tutorial">{$tutorial}</div>
{/if}

{if is_array($class_tree.classes) && count($class_tree.classes)}
<pre>{section name=tree loop=$class_tree.classes}{$class_tree.classes[tree]}{$class_tree.distance[tree]}{/section}</pre>
{/if}

{if $conflicts.conflict_type}
  <hr class="separator" />
  <div>
    <span class="warning">Conflicts with classes:</span>
    <br />
    {section name=me loop=$conflicts.conflicts}      {$conflicts.conflicts[me]}<br />
    {/section}  </div>
{/if}

{if count($tags) > 0}
  <strong>Author(s):</strong>
  <ul>
    {section name=tag loop=$tags}
      {if $tags[tag].keyword eq "author"}
        <li>{$tags[tag].data}</li>
      {/if}
    {/section}
  </ul>
{/if}

{include file="classtags.tpl" tags=$tags}

{* ====== Descendant classes ====== *}
{if $children}
  <a name="sec-descendants"></a>
  <h2>Descendants</h2>
  <table class="detail">
    <thead>
      <tr>
        <th>Child Class</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      {section name=kids loop=$children}
        <tr>
          <td>{$children[kids].link}</td>          <td>
            {if $children[kids].sdesc}
              {$children[kids].sdesc}
            {else}
              {$children[kids].desc}
            {/if}
          </td>
        </tr>
      {/section}
    </tbody>
  </table>
{/if}

{* ====== Class Constants ====== *}
{if $consts}
  <a name="sec-const-summary"></a>
  <h2>Constants</h2>
  <table class="summary">
    {section name=consts loop=$consts}
      <tr>
        <td class="right">
          <a name="const-{$consts[consts].const_name}" id="{$const[consts].const_name}"></a>
          <code>
            <a href="#const-{$consts[consts].const_name}" title="details" class="const-name-summary">{$consts[consts].const_name}</a>
             = {$consts[consts].const_value|replace:"\n":"<br />"}
          </code>
        </td>
        <td>
          {if $consts[consts].sdesc}{$consts[consts].sdesc}{/if}
          {if $consts[consts].desc}{$consts[consts].desc}{/if}
        </td>
      </tr>
    {/section}
  </table>
{/if}

{* ====== Class Inherited Constants ====== *}
{if $iconsts}
  <a name="sec-inherited-consts"></a>
  <h2>Inherited Constants</h2>
  <table class="summary">
    {section name=iconsts loop=$iconsts}
      {if $iconsts[iconsts] && is_array( $iconsts[iconsts] ) && count( $iconsts[iconsts] )}
        <thead>
          <tr>
            <th colspan="2">
              From <span class="classname">{$iconsts[iconsts].parent_class}</span>:
            </th>
          </tr>
        </thead>
        <tbody>
          {section name=iconsts2 loop=$iconsts[iconsts].iconsts}
            <tr>
              <td class="right">
                <code>{$iconsts[iconsts].iconsts[iconsts2].link}</code>
              </td>
              <td>
                {if $iconsts[iconsts].iconsts[iconsts2].sdesc}&nbsp;&nbsp;&nbsp;{$iconsts[iconsts].iconsts[iconsts2].sdesc}{/if}
              </td>
            </tr>
          {/section}
        </tbody>
      {/if}
    {/section}
  </table>
{/if}

{* ====== Class Properties ====== *}
{if $prop_tags}
  <a name="sec-prop-summary"></a>
  <h2>Properties</h2>
  <table class="summary">
    {section name=props loop=$prop_tags}
      <tr>
        <td class="right">
          <a name="prop{$prop_tags[props].prop_name}" id="{$prop_tags[props].prop_name}"></a>
          <a name="prop-{$prop_tags[props].prop_name}" id="{$prop_tags[props].prop_name}"></a>
          {if $prop_tags[props].prop_type}<em>{$prop_tags[props].prop_type}</em>{/if}
        </td>
        <td class="right">
          <em>{$prop_tags[props].access}</em>
        </td>
        <td>
          <code>
            <a href="#prop-{$prop_tags[props].prop_name}" title="details" class="var-name-summary">{$prop_tags[props].prop_name}</a>
            {if $prop_tags[props].def_value}&nbsp;=&nbsp;{$prop_tags[props].def_value}{/if}
          </code>
          {if $prop_tags[props].sdesc}<br /><div style="margin-left: 20px">{$prop_tags[props].sdesc}</div>{/if}
        </td>
      </tr>
    {/section}
  </table>
{/if}

{* ====== Class Members ====== *}
{if $vars}
  <a name="sec-var-summary"></a>
  <h2>Member Variables</h2>
  <table class="summary">
    {section name=vars loop=$vars}
      {if $vars[vars].static}
        <tr>
          <td class="right">
            {if $vars[vars].access}<em>{$vars[vars].access}</em>{/if}
            static
            {if $vars[vars].var_type}<em>{$vars[vars].var_type}</em>{/if}
          </td>
          <td>
            <code>
              {$vars[vars].var_name}
              {if $vars[vars].var_default} = <span class="var-default">{$vars[vars].var_default|replace:"\n":"<br />"}</span>{/if}
            </code>
            {if $vars[vars].sdesc}<br /><div style="margin-left: 20px">{$vars[vars].sdesc}</div>{/if}
            {if $vars[vars].desc}<br /><div style="margin-left: 20px">{$vars[vars].desc}</div>{/if}
          </td>
        </tr>
      {/if}
    {/section}
    {section name=vars loop=$vars}
      {if !$vars[vars].static}
        <tr>
          <td class="right">
            {if $vars[vars].access}<em>{$vars[vars].access}</em>{/if}
            {if $vars[vars].var_type}<em>{$vars[vars].var_type}</em>{/if}
          </td>
          <td>
            <code>
              {$vars[vars].var_name}
              {if $vars[vars].var_default} = <span class="var-default">{$vars[vars].var_default|replace:"\n":"<br />"}</span>{/if}
            </code>
            {if $vars[vars].sdesc}<br /><div style="margin-left: 20px">{$vars[vars].sdesc}</div>{/if}
            {if $vars[vars].desc}<br /><div style="margin-left: 20px">{$vars[vars].desc}</div>{/if}
          </td>
        </tr>
      {/if}
    {/section}
  </table>
{/if}

{* ====== Class Inherited Members ====== *}
{if $ivars}
  <h2>Inherited Member Variables</h2>
  <table class="summary">
    {section name=ivars loop=$ivars}
      <thead>
        <tr>
          <th colspan="2">
	        From <span class="classname">{$ivars[ivars].parent_class}</span>         
          </th>
        </tr>
      </thead>
      <tbody>
        {section name=ivars2 loop=$ivars[ivars].ivars}
          <tr>
            <td class="right">
              {if $ivars[ivars].ivars[ivars2].access}<em>{$ivars[ivars].ivars[ivars2].access}</em>{/if}
              {if $ivars[ivars].ivars[ivars2].var_type}<em>{$ivars[ivars].ivars[ivars2].var_type}</em>{/if}
            </td>
            <td>
              <code>{$ivars[ivars].ivars[ivars2].link}</code>
              {$ivars[ivars].ivars[ivars2].ivars_sdesc}
            </td>
          </tr>
        {/section}
      </tbody>
    {/section}
  </table>
{/if}

{* ====== Class Methods ====== *}
{if $methods}
  <a name="sec-method-summary"></a>
  <h2>Method Summary</h2>
  <table class="summary">
    {section name=methods loop=$methods}
      {if $methods[methods].static}
        <tr>
          <td class="right">
            {if $methods[methods].access}<em>{$methods[methods].access}</em>{/if}
            static
            {if $methods[methods].abstract}abstract{/if}
            {if $methods[methods].function_return}<em>{$methods[methods].function_return}</em>{/if}
          </td>
          <td>
            <code>
              <a href="#{$methods[methods].function_name}"><b>{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</b></a>(
              {if count($methods[methods].ifunction_call.params)}
                {section name=params loop=$methods[methods].ifunction_call.params}
                  {if $smarty.section.params.iteration != 1}, {/if}
                  {if $methods[methods].ifunction_call.params[params].default != ''}[{/if}
                  {$methods[methods].ifunction_call.params[params].name}
                  {if $methods[methods].ifunction_call.params[params].default != ''} = {$methods[methods].ifunction_call.params[params].default}]{/if}
                {/section}
              {/if} )
            </code>
            {if $methods[methods].sdesc}<br /><div style="margin-left: 20px">{$methods[methods].sdesc}</div>{/if}
          </td>
        </tr>
      {/if}
    {/section}
    {section name=methods loop=$methods}
      {if !$methods[methods].static}
        <tr>
          <td class="right">
            {if $methods[methods].access}<em>{$methods[methods].access}</em>{/if}
            {if $methods[methods].abstract}abstract{/if}
            {if $methods[methods].function_return}<em>{$methods[methods].function_return}</em>{/if}
          </td>
          <td>
            <code>
              <a href="#{$methods[methods].function_name}"><b>{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</b></a>(
              {if count($methods[methods].ifunction_call.params)}
                {section name=params loop=$methods[methods].ifunction_call.params}
                  {if $smarty.section.params.iteration != 1}, {/if}
                  {if $methods[methods].ifunction_call.params[params].default != ''}[{/if}
                  {$methods[methods].ifunction_call.params[params].name}
                  {if $methods[methods].ifunction_call.params[params].default != ''} = {$methods[methods].ifunction_call.params[params].default}]{/if}
                {/section}
              {/if} )
            </code>
            {if $methods[methods].sdesc}<br /><div style="margin-left: 20px">{$methods[methods].sdesc}</div>{/if}
          </td>
        </tr>
      {/if}
    {/section}
  </table>
{/if}

{* ====== Inherited Methods ====== *}
{if $imethods}
  <h2>Inherited Methods</h2>
  <table class="summary">
    {section name=imethods loop=$imethods}
      <thead>
        <tr>
          <th colspan="2">
            From <span class="classname">{$imethods[imethods].parent_class}</span>
          </th>
        </tr>
      </thead>
      <tbody>
        {section name=imethods2 loop=$imethods[imethods].imethods}
          <tr>
            <td class="right">
              {if $imethods[imethods].imethods[imethods2].access}<em>{$imethods[imethods].imethods[imethods2].access}</em>{/if}
              {if $imethods[imethods].imethods[imethods2].abstract}abstract{/if}
              {if $imethods[imethods].imethods[imethods2].static}static{/if}
              {if $imethods[imethods].imethods[imethods2].function_return}<em>{$imethods[imethods].imethods[imethods2].function_return}</em>{/if}
            </td>
            <td>
              <code><b>{$imethods[imethods].imethods[imethods2].link}</b></code>
              {if $imethods[imethods].imethods[imethods2].sdesc}<br /><div style="margin-left: 20px">{$imethods[imethods].imethods[imethods2].sdesc}</div>{/if}
              {if $imethods[imethods].imethods[im2].sdesc}<br /><div style="margin-left: 20px">{$imethods[imethods].imethods[im2].sdesc}</div>{/if}
            </td>
          </tr>
        {/section}
      </tbody>
    {/section}
  </table>
{/if}

{if $methods}
  <a name="sec-methods"></a>
  <h2>Methods</h2>
  {include file="method.tpl"}
{/if}

<p class="notes">
  Located in <a class="field" href="{$page_link}">{$source_location}</a> 
  [<span class="field">line {if $class_slink}{$class_slink}{else}{$line_number}{/if}</span>]
</p>

{include file="footer.tpl"}
