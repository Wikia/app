<!-- BEGIN build -->
<table><tr><td>
<div class="main">
    <div class="type"><a href="http://wiki.guildwars.com/wiki/{primary}"><img src="http://images.wikia.com/pvx/img_skin/{primary}.gif" border="0" /></a><a href="http://wiki.guildwars.com/wiki/{secondary}"><img src="http://images.wikia.com/pvx/img_skin/{secondary}.gif" border="0" /></a><span><a href="http://wiki.guildwars.com/wiki/{primary}"><b>{primary}</b></a> / <a href="http://wiki.guildwars.com/wiki/{secondary}"><b>{secondary}</b></a></span></div>
    <div class="profession">
        {attributes}
    </div>
    {skills}
       <div class="template">
        <div class="template_name">Template code</div><div class="template_input"><input id="gws_template_input" type="text" value="{template_code}" readonly="readonly" />&nbsp;<a href="/template.php?build={template_code}&name={build_name}"><img src="http://images.wikia.com/pvx/img_skin/save.png" border="0" alt="save" /></a></div>
    </div>
</div>
</td></tr></table>
<!-- END build -->

<!-- BEGIN prof_icon -->

<!-- END prof_icon -->

<!-- BEGIN icon -->
<div class="skill_box"><div class="skill_icon" onmouseover="return overlib(div('load{load}').innerHTML);" onmouseout="return nd(200);"><div class="pvx_icon-{elite_or_normal}"><div class="pvx-type-{ty}"></div></div><a href="http://wiki.guildwars.com/wiki/{name_link}"><img src="http://images.wikia.com/pvx/img_skills/{id}.jpg" border="0" /></a></div><a href="http://wiki.guildwars.com/wiki/{name_link}">{name}</a></div>
<!-- END icon -->

<!-- BEGIN blank_icon -->
<img src="http://images.wikia.com/pvx/img_skills/{id}.jpg" style="vertical-align: middle;" />
<!-- END blank_icon -->

<!-- BEGIN noicon -->
<a href="javascript:void()" onmouseover="return overlib(div('load{load}').innerHTML);" onmouseout="return nd();" style="text-decoration: none">{name}</a>
<!-- END noicon -->

<!-- BEGIN noicon_gwshack -->
<span class="skill_link" onmouseover="return overlib(div('load{load}').innerHTML);" onmouseout="return nd();" style="text-decoration: none">{name}</span>
<!-- END noicon -->

<!-- BEGIN skill -->
<div id="load{load}" style="display: none;">
    <div class="pvx_overlib" style="width:{desc_len}px;">
        <div class="pvx_campaign">{chapter}</div>
        <div class="pvx_mastery">{profession}. {attr_html}</div>
        <div class="pvx_description" style="background-image:url('http://images.wikia.com/pvx.com/img_skin/{profession}.jpg');">
            <div class="pvx_{elite_or_normal}">{name}</div>
            <div class="pvx_type">{type}</div>
            <div class="pvx_skill_info">{{tpl_desc}}{extra_desc}</div>
        </div> 
        <div class="pvx_attrib_list">
            <div class="pvx_attrib_bg">
                <img src="http://images.wikia.com/pvx/img_thmb/{id}.jpg" height="40" width="40" border="0"><div id="pvx_attributes">{required}</div>
            </div>
        </div>
    </div> 
</div>
<!-- END skill -->

<!-- BEGIN attribute -->
        <div class="attribute_rank">{attribute_value}</div><div class="attribute_name"><a href="http://wiki.guildwars.com/wiki/{attribute_name}">{attribute_name}</a></div>
<!-- END attribute -->

<!-- BEGIN requirement -->
<div id="pvx_{type}">{value}</div>
<!-- END requirement -->

<!-- BEGIN modified_requirement_value -->
<span class="expert">{modified_value}</span>
<!-- END modified_requirement_value -->

<!-- BEGIN tpl_desc -->
{desc}
<!-- END tpl_desc -->

<!-- BEGIN tpl_extra_desc -->
<br/><span class="expert">{extra_desc}</span>
<!-- END tpl_extra_desc -->

<!-- BEGIN tpl_skill_attr -->
{attribute} {attr_value}
<!-- END tpl_skill_attr -->

<!-- BEGIN tpl_skill_no_attr -->
Unlinked
<!-- END tpl_skill_no_attr -->

<!-- BEGIN pickup -->
<span id="pickup_{id}">{userlist}</span>
<span onclick="pickup('add', '{id}')" class="postlink" id="add_{id}" style="text-decoration: underline; color: #DD6900; display: none; cursor: pointer;">Add me</span>
<span onclick="pickup('remove', '{id}')" class="postlink" id="remove_{id}" style="text-decoration: underline; color: #DD6900; display: none; cursor: pointer;">Remove me</span>
<script>div('{action}_{id}').style.display='';</script>
<!-- END pickup -->
