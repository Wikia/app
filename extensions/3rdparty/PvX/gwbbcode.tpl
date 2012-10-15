<!-- BEGIN build -->
<table class="bbcode_tbl" border="1" cellpadding="2" cellspacing="1" width="586">
    <tr>
        <th align="left" width="369"><a href="http://wiki.guildwars.com/wiki/{primary}" class="image" title="{primary}"><img src="http://images.pvxbuilds.com/{primary}-icon.png" alt="{primary}" width="38" height="38" longdesc="http://wiki.guildwars.com/wiki/{primary}" /></a><a href="http://wiki.guildwars.com/wiki/{secondary}" class="image" title="{secondary}"><img src="http://images.pvxbuilds.com/{secondary}-icon.png" alt="{secondary}" width="38" height="38" longdesc="http://wiki.guildwars.com/wiki/{secondary}" /></a><a href="http://gw.gamewikis.org/wiki/{primary}" class="extiw" title="gw:{primary}">&nbsp;{primary}</a> / <a href="http://gw.gamewikis.org/wiki/{secondary}" class="extiw" title="gw:{secondary}">{secondary}</a> </th>
        <th align="right" width="217"><a href="http://gw.gamewikis.org/wiki/Attribute" class="extiw" title="gw:Attribute">Attribute Rank</a> </th>
    </tr>
    {attributes}
</table>
<table style="border:0; text-align: center; border-collapse:collapse;" cellpadding="0" cellspacing="0" width="586">
	<tr>
	{skills}
    </tr>
</table>
<table class="bbcode_tbl" border="1" cellpadding="0" cellspacing="0" width="586">
    <tr>
        <th align="left" width="138" style="padding:4px;"><a href="http://gw.gamewikis.org/wiki/Skill_Template" class="extiw" >Skills Template</a></th>
        <th width="436" align="center" valign="middle">
            <input id="gws_template_input{load}" class="bbcode_input" type="text" value="{template_bbcode}" readonly="readonly" style="width:380px;" />&nbsp;<a href="/template.php?build={template_code}&name={art_name}"><img src="http://images.pvxbuilds.com/save.png" border="0" alt="save" style="display:inline; vertical-align: top; margin-top:1px;" /></a>
		</th>
    </tr>
</table>
<!-- END build -->

<!-- BEGIN icon -->
		<td valign="top" class="bbcode_tbl">
            <table style="border:0; margin:0px; padding:0px; width:68px;" cellpadding="1" cellspacing="0">
              <tr>
                <td>
                    <a href="http://gw.gamewikis.org/wiki/{name}">
	                    <img src="http://images.pvxbuilds.com/img_skills/{id}.jpg" onmouseover="return overlib(div('load{load}').innerHTML, WRAP, WIDTH, {block_size}, HAUTO);" onmouseout="return nd();" class="bbcode_sicon" />
                    </a>
                </td>
              </tr>
              <tr>
                <td style="border-top: 1px dotted #444;">
                    <p style="font-size:smaller;"><a href="http://gw.gamewikis.org/wiki/{name}" class="extiw" title="{name}">{name}</a></p>
                </td>
              </tr>
            </table>
        </td>
<!-- END icon -->

<!-- BEGIN blank_icon -->
<img src="http://images.pvxbuilds.com/img_skills/{id}.jpg" style="vertical-align: middle;" />
<!-- END blank_icon -->

<!-- BEGIN noicon -->
<a href="javascript:void()" onmouseover="return overlib(div('load{load}').innerHTML);" onmouseout="return nd();" style="text-decoration: none">{name}</a>
<!-- END noicon -->

<!-- BEGIN noicon_gwshack -->
<span class="skill_link" onmouseover="return overlib(div('load{load}').innerHTML);" onmouseout="return nd();" style="text-decoration: none">{name}</span>
<!-- END noicon -->

<!-- BEGIN skill -->
<div id="load{load}" style="display: none;">
        <div class="bbcode_start"><img src="http://images.pvxbuilds.com/start.png" alt="" border="0" />
            <div class="bbcode_skill"><img src="http://images.pvxbuilds.com/img_thmb/{id}.jpg" alt="" border="0" /></div>
        </div>
        <div class="bbcode_center">
            <div class="{elite_background}">{name}</div>
            <div class="bbcode_text" style="width:{block_size}px;"><b>{type}</b>. {desc}</div>
            <div class="bbcode_attr">
                {required}
            </div>
        </div>
        <div class="bbcode_logo">
        	<img src="{prof_img}" alt="" border="0" />
            <div class="bbcode_comp">{chapter}</div>
        </div>
</div>
<!-- END skill -->

<!-- BEGIN attribute -->
    	<tr>
            <td><a href="http://gw.gamewikis.org/wiki/{attribute_name}" class="extiw" title="gw:{attribute_name}">&nbsp;{attribute_name} </a></td>
            <td align="right">{attribute_value}</td>
	    </tr>
<!-- END attribute -->

<!-- BEGIN pickup -->
<span id="pickup_{id}">{userlist}</span>
<span onclick="pickup('add', '{id}')" class="postlink" id="add_{id}" style="text-decoration: underline; color: #DD6900; display: none; cursor: pointer;">Add me</span>
<span onclick="pickup('remove', '{id}')" class="postlink" id="remove_{id}" style="text-decoration: underline; color: #DD6900; display: none; cursor: pointer;">Remove me</span>
<script>div('{action}_{id}').style.display='';</script>
<!-- END pickup -->
