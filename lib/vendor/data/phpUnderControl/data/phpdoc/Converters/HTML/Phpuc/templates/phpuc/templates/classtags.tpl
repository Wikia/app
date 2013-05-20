{if count($info_tags) > 0}
  <table>
    {section name=tag loop=$info_tags}
	  {if $info_tags[tag].keyword ne "author"}
		<tr>
		  <td>
		    <strong>{$info_tags[tag].keyword|capitalize}:</strong>&nbsp;&nbsp;
		  </td>
		  <td>{$info_tags[tag].data}</td>
		</tr>
	  {/if}
    {/section}
  </table>
{/if}