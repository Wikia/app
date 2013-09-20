<a name='method_detail'></a>
{section name=methods loop=$methods}
  {if $methods[methods].static}
    <a name="method{$methods[methods].function_name}" id="{$methods[methods].function_name}"><!-- --></a>

    <h3>{$methods[methods].function_name}</h3>

    <div class="method-signature">
      static {$methods[methods].function_return}
      {if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}(
      {if count($methods[methods].ifunction_call.params)}
        {section name=params loop=$methods[methods].ifunction_call.params}
          {if $smarty.section.params.iteration != 1}, {/if}
          {if $methods[methods].ifunction_call.params[params].hasdefault}[{/if}{$methods[methods].ifunction_call.params[params].type}
          {$methods[methods].ifunction_call.params[params].name}
          {if $methods[methods].ifunction_call.params[params].hasdefault} = {$methods[methods].ifunction_call.params[params].default}]{/if}
        {/section}
      {/if})
    </div>

      {include file="docblock.tpl" sdesc=$methods[methods].sdesc desc=$methods[methods].desc}
      
      {if $methods[methods].params}
        <h4>Parameters:</h4>
        <table class="detail">
          <thead>
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th class="desc">Description</th>
            </tr>
          </thead>
          <tbody>
            {section name=params loop=$methods[methods].params}
              <tr>
                <td><code>{$methods[methods].params[params].var}</code></td>
                <td><em>{$methods[methods].params[params].datatype}</em></td>
                <td>
                  {if $methods[methods].params[params].data}
                    {$methods[methods].params[params].data}
                  {/if}
                </td>
              </tr>
            {/section}
          </tbody>
        </table>
      {/if}

      {if $methods[methods].exceptions}
        <h4>Exceptions:</h4>
        <table class="detail">
          <thead>
            <tr>
              <th>Type</th>
              <th class="desc">Description</th>
            </tr>
          </thead>
          <tbody>
            {section name=exception loop=$methods[methods].exceptions}
              <tr>
                <td><code>{$methods[methods].exceptions[exception].type}</code></td>
                <td>
                  {if $methods[methods].exceptions[exception].data}
                    {$methods[methods].exceptions[exception].data}
                  {/if}
                </td>
              </tr>
            {/section}
          </tbody>
        </table>
      {/if}

      {if $methods[methods].method_overrides}
        <h4>Redefinition of:</h4>
        <table class="detail">
          <thead>
            <tr>
              <th>Method</th>
              <th class="desc">Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><code>{$methods[methods].method_overrides.link}</code></td>
              <td>
                {if $methods[methods].method_overrides.sdesc}
                  {$methods[methods].method_overrides.sdesc}
                {/if}
              </td>
            </tr>
          </tbody>
        </table>
      {/if}

      {if $methods[methods].method_implements}
        <h4>Implementation of:</h4>
        <table class="detail">
          <thead>
            <tr>
              <th>Method</th>
              <th class="desc">Description</th>
            </tr>
          </thead>
          <tbody>
            {section name=imp loop=$methods[methods].method_implements}
              <tr>
                <td><code>{$methods[methods].method_implements[imp].link}</code></td>
                <td>
                  {if $methods[methods].method_implements[imp].sdesc}
                    {$methods[methods].method_implements[imp].sdesc}
                  {/if}
                </td>
              </tr>
            {/section}
          </tbody>
        </table>
      {/if}

      {if $methods[methods].descmethod}
        <h4>Redefined in descendants as:</h4>
        <table class="detail">
          <thead>
            <tr>
              <th>Method</th>
              <th class="desc">Description</th>
            </tr>
          </thead>
          <tbody>
            {section name=dm loop=$methods[methods].descmethod}
              <tr>
                <td><code>{$methods[methods].descmethod[dm].link}</code></td>
                <td>
                  {if $methods[methods].descmethod[dm].sdesc}{$methods[methods].descmethod[dm].sdesc}{/if}&nbsp;
                </td>
              </tr>
            {/section}
          </tbody>
        </table>
      {/if}

  {/if}
{/section}

{section name=methods loop=$methods}
  {if !$methods[methods].static}
    <a name="method{$methods[methods].function_name}" id="{$methods[methods].function_name}"><!-- --></a>

    <h3>{$methods[methods].function_name}</h3>

    <div class="method-signature">
      {$methods[methods].function_return}
      {if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}(
      {if count($methods[methods].ifunction_call.params)}
        {section name=params loop=$methods[methods].ifunction_call.params}
          {if $smarty.section.params.iteration != 1}, {/if}
          {if $methods[methods].ifunction_call.params[params].hasdefault}[{/if}{$methods[methods].ifunction_call.params[params].type}
          {$methods[methods].ifunction_call.params[params].name}
          {if $methods[methods].ifunction_call.params[params].hasdefault} = {$methods[methods].ifunction_call.params[params].default}]{/if}
        {/section}
      {/if})
    </div>

    {include file="docblock.tpl" sdesc=$methods[methods].sdesc desc=$methods[methods].desc}

    {if $methods[methods].params}
      <h4>Parameters:</h4>
      <table class="detail">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th class="desc">Description</th>
          </tr>
        </thead>
        <tbody>
          {section name=params loop=$methods[methods].params}
            <tr>
              <td><code>{$methods[methods].params[params].var}</code></td>
              <td><em>{$methods[methods].params[params].datatype}</em></td>
              <td>
                {if $methods[methods].params[params].data}
                  {$methods[methods].params[params].data}
                {/if}
              </td>
            </tr>
          {/section}
        </tbody>
      </table>
    {/if}

    {if $methods[methods].exceptions}
      <h4>Exceptions:</h4>
      <table class="detail">
        <thead>
          <tr>
            <th>Type</th>
            <th class="desc">Description</th>
          </tr>
        </thead>
        <tbody>
          {section name=exception loop=$methods[methods].exceptions}
            <tr>
              <td><code>{$methods[methods].exceptions[exception].type}</code></td>
              <td>
                {if $methods[methods].exceptions[exception].data}
                  {$methods[methods].exceptions[exception].data}
                {/if}
              </td>
            </tr>
          {/section}
        </tbody>
      </table>
    {/if}
    

    {if $methods[methods].method_overrides}
      <h4>Redefinition of:</h4>
      <table class="detail">
        <thead>
          <tr>
            <th>Method</th>
            <th class="desc">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>{$methods[methods].method_overrides.link}</code></td>
            <td>
              {if $methods[methods].method_overrides.sdesc}
                {$methods[methods].method_overrides.sdesc}
              {/if}
            </td>
          </tr>
        </tbody>
      </table>
    {/if}

    {if $methods[methods].method_implements}
      <h4>Implementation of:</h4>
      <table class="detail">
        <thead>
          <tr>
            <th>Method</th>
            <th class="desc">Description</th>
          </tr>
        </thead>
        <tbody>
          {section name=imp loop=$methods[methods].method_implements}
            <tr>
              <td><code>{$methods[methods].method_implements[imp].link}</code></td>
              <td>
                {if $methods[methods].method_implements[imp].sdesc}
                  {$methods[methods].method_implements[imp].sdesc}
                {/if}
              </td>
            </tr>
          {/section}
        </tbody>
      </table>
    {/if}

    {if $methods[methods].descmethod}
      <h4>Redefined in descendants as:</h4>
      <table class="detail">
        <thead>
          <tr>
            <th>Method</th>
            <th class="desc">Description</th>
          </tr>
        </thead>
        <tbody>
          {section name=dm loop=$methods[methods].descmethod}
            <tr>
              <td><code>{$methods[methods].descmethod[dm].link}</code></td>
              <td>
                {if $methods[methods].descmethod[dm].sdesc}{$methods[methods].descmethod[dm].sdesc}{/if}&nbsp;
              </td>
            </tr>
          {/section}
        </tbody>
      </table>
    {/if}

  {/if}
{/section}
