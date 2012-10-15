<?php
/***************************************************************************
*                             gwbbcode.inc.php
*                            -------------------
*   begin                : Tuesday, Apr 21, 2005
*   copyright            : (C) 2006-2007 Pierre 'pikiou' Scelles
*   email                : liu.pi.vipi@gmail.com
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
*   All images, skill names and descriptions are (C) ArenaNet.
***************************************************************************/

require_once (GWBBCODE_ROOT . '/config.php');

// Load the gwbbcode template
global $gwbbcode_tpl;
global $art_titel;
if (!isset($gwbbcode_tpl))
    $gwbbcode_tpl = load_gwbbcode_template();

//Transforms gwBBCode text to HTML
//Better suited function name than gwbbcodize :/
function parse_gwbbcode($t, $n)
{
    global $art_titel;
    $art_titel = $n;
    return gwbbcodize($t);
}

//Converts a gwBBCode text to HTML
function gwbbcodize($t)
{
    $start = microtime_float();

    // Replace all '['s inside [pre]..[/pre] by '&#91;'
    if (!defined('SMF'))
    {//SMF uses the [pre] tag already
        $t = preg_replace_callback('#\[pre\](.*?)\[\/pre\]#isS', 'pre_replace', $t);
    }
    $t = preg_replace_callback('#\[nobb\](.*?)\[\/nobb\]#isS', 'pre_replace', $t);

    // [rand seed=465468 players=2]
    $t = preg_replace_callback('#\[rand([^\]]*)\]#isS', 'rand_replace', $t);

    // Manage [build=...]
    $t = preg_replace_callback('#\[build=([^\]]*)\]\]?(\[/build\])?\r?\n?#isS',
        'build_id_replace', $t);

    // Manage [build_name;template_code]
    $t = preg_replace_callback('#\[(([^]\r\n]+);([^];\r\n]+))\]\r?\n?#isS',
        'build_id_replace', $t);

    // Replace all [skill_name] by [skill]skill_name[/skill] if skill_name is a valid skill name
    $t = preg_replace_callback('#\[(.*?)\]#isS', 'skill_name_replace', $t);

    // Manage [build]...[/build]
    $t = preg_replace_callback('#\[build ([^\]]*)\](.*?)\[/build\]\r?\n?#isS',
        'build_replace', $t);

    // Manage [skill]...[/skill]
    $t = preg_replace_callback('#\[skill([^\]]*)\](.*?)\[/skill\][ ]?#isS',
        'skill_replace', $t);

    // [pickup="arheu"]
    $t = preg_replace_callback('#\[pickup([^\]]*)\]#isS', 'pickup_replace', $t);

    //[gwbbcode runtime]
    if (preg_match('@\[gwbbcode runtime\]@i', $t) !== false)
        $t = preg_replace('@\[gwbbcode runtime\]@i', round(microtime_float() - $start, 3),
            $t);//Precise enough

    //Trick to use in MyBB against <p> elements screwing up first skill div, and some ending <br /> being removed
    if (defined('IN_MYBB'))
    {
        $t = '</p>' . $t;
        $t = str_replace("</div>\n", "</div><br>", $t);
    }

    return $t;
}


//Changes any '[' by '&#91;', hence disabling bbcode
function pre_replace($reg)
{
    list($all, $content) = $reg;
    return str_replace('[', '&#91;', $content);
}


//Processes the [pickup...] element
function pickup_replace($reg)
{
    global $gwbbcode_tpl;
    global $userdata;
    list($all, $att) = $reg;
    $att = html_safe_decode($att);

    //Get all pickup users
    $pickup = @load(PICKUP_PATH);
    if ($pickup === false)
        return $all;

    if (preg_match('|^=\\"(.+)\\"|', $att, $reg) && $pickup !== false)
    {
        $id = preg_replace('|[\'"!]|', '', $reg[1]);
        $username = $userdata['username'];

        //Add or Remove links? (default=Add)
        $action = 'add';
        if (isset($pickup[$id]) && in_array($username, $pickup[$id]))
            $action = 'remove';

        $userlist = pickup_users($pickup, $username, $id, '');

        $gwbbcode_root_path = GWBBCODE_ROOT;
        return preg_replace("#\{(.*?)\}#ise", "isset($\\1)?$\\1:'\\0'", $gwbbcode_tpl['pickup']);
    }
    else
        return "<script>alert('No id found for [pickup]; Please give one as in [pickup=\"75578\"]')</script>";
}




// Process [rand seed=465468 players=2]
function rand_replace($reg)
{
    list($all, $att) = $reg;
    $att = html_safe_decode($att);

    //Get the seed
    if (preg_match('|seed=([0-9]+)|', $att, $reg))
    {
        $seed = intval($reg[1]);
    }
    else
    {
        $seed = rand(1000, 100000);
    }
    srand($seed);

    //Get the number of players
    if (preg_match('|players=([0-9]+)|', $att, $reg))
    {
        $players = intval($reg[1]);
    }
    else
    {
        $players = 1;
    }

    //Generate random skills
    $skills = array();
    $elite = 0;
    $max_elite = ($players + 1) * 3;
    $normal = 0;
    $max_normal = ($players + 1) * 14;
    $total = 0;
    $max_total = $max_elite + $max_normal;
    while ($total < $max_total)
    {
        $id = rand(0, 2000);
        if ($skill = gws_details($id))
        {
            //Skill exists!
            if ($skill['elite'] == 1 && $elite < $max_elite)
            {
                $elite++;
                $total++;
                $skills[] = $skill;
            }
            else
                if ($skill['elite'] == 0 && $normal < $max_normal)
                {
                    $normal++;
                    $total++;
                    $skills[] = $skill;
                }
        }
    }

    //Sort and output the list of skills
    uasort($skills, "skill_sort_cmp");
    $skill_list = '';
    foreach ($skills as $skill)
    {
        $skill_list .= '[' . $skill['name'] . ']';
    }

    return "Random skill set (seed=$seed):\n$skill_list";
}


//Returns a list of pickup users, highlighting one specified username.
function pickup_users($pickup, $username, $id, $nobody_msg)
{
    //Output our pickup's users
    if (empty($id) || !isset($pickup[$id]))
        $userlist = '';
    else
    {
        //Prepare list of users
        $list = $pickup[$id];
        sort($list);
        foreach ($list as $key => $name)
            if ($name === $username)
                $list[$key] = "<span style=\"color: #40B030\">$name</span>";
        $userlist = implode(', ', $list);
        if (!empty($userlist))
            $userlist .= '. ';

    }

    return empty($userlist) ? $nobody_msg:$userlist;
}

//Convert [Potential Skill Name] tags to [skill]Potential Skill Name[/skill]
function skill_name_replace($reg)
{
    global $gwbbcode_tpl;
    list($all, $name) = $reg;
    $name = html_safe_decode($name);

    $all = preg_replace('@ressurection@i',
        '<span style="text-decoration: blink; color: black" onMouseOver="stm([\'\', \'<table width=\\\'400\\\' style=\\\'color: white\\\' id=\\\'translucent\\\'><tr><td>Re<b><u>s</u></b>u<b><u>rr</u></b>ection, one \\\'s\\\', two \\\'r\\\'s for Christ sake!</td></tr></table>\'],Style[0])" onMouseOut="htm()">Ressurection</span>',
        $all);

    $all = preg_replace('@\[gwbbcode version\]@i', GWBBCODE_VERSION, $all);

    //'[[Skill Name]' => no icon
    if ($name{0} == '[')
    {
        $noicon = true;
        $name = substr($name, 1);
    }
    else
        $noicon = false;

    //"name@attr_value" -> $name and $attr_val
    $attr = '';
    if (preg_match('|([^@\]]+)@([^\]]+)|', $name, $reg))
    {
        $name = $reg[1];
        $attr_val = preg_replace('@[^0-9+-]@', '', $reg[2]);
    }

    if (($id = gws_skill_id($name)) !== false)
    {
        //Handle [shock@8]
        if (isset($attr_val))
        {
            $skill = gws_details($id);
            $attr = gws_attribute_name($skill['attribute']);
            $attr = " $attr=$attr_val";
        }
        //Handle the difference between [[shock] and [shock]
        if ($noicon)
            return "[skill noicon$attr]" . $name . '[/skill]';
        else
            return "[skill$attr]" . $name . '[/skill]';
    }
    else
        return $all;
}




//Process the [build=id] element
function build_id_replace($reg)
{
    list($all, $id) = $reg;
    $new_code = template_to_gwbbcode($id);
    return (strpos($new_code, '[') === 0) ? $new_code:$all;
}


//Process the [build] element
function build_replace($reg)
{
    global $gwbbcode_tpl;
    global $userdata;
    global $art_titel;
    $art_name = $art_titel;

    $gwbbcode_root_path = GWBBCODE_ROOT;
    list($all, $att, $skills) = $reg;
    $att = str_replace("\n", "<br/>\n", html_safe_decode($att));
    $load = rand();
    $build = $gwbbcode_tpl['build'];

    //Build name
    $build_name = gws_build_name($att);
    $build_name = str_replace('{br}', '<br/>', str_replace('{br/}', '<br/>',
        str_replace('{BR}', '<br/>', str_replace('{BR/}', '<br/>', $build_name))));

    //Professions
    $prof = gws_build_profession($att);
    $prof_imgs = '';
    $cursor = 'help';
    if ($prof !== false)
    {
        $prof_img = '<img class="build_icon" src="http://images.pvxbuilds.com/img_interface/{profession}.gif?r=1" style="cursor: {cursor};" onmouseover="return overlib(div(\'load' .
            $load . '\').innerHTML);" onmouseout="return nd();"/>';

        $primary = gws_prof_name($prof['primary']);
        $secondary = gws_prof_name($prof['secondary']);

        $showimg = '';
        $prof_imgs .= str_replace('{profession}', $primary, $prof_img);
        if ($secondary != 'No profession' && $secondary != $primary)
            $prof_imgs .= str_replace('{profession}', $secondary, $prof_img);
    }
    else
    {
        $showimg = ' ;display: none';
        $primary = '?';
        $secondary = '?';
    }


    //Attributes
    $attributes = '';
    foreach (explode(' ', gws_attributes_clean($att)) as $value)
    {
        $value = explode('=', $value);
        if ($att_name = gws_attr_name($value[0]))
        {
            $attributes .= str_replace('{attribute_name}', $att_name, $gwbbcode_tpl['attribute']);
            $value[1] = str_replace('+', ' + ', $value[1]);
            $attributes = str_replace('{attribute_value}', $value[1], $attributes);
        }
    }
    $skills = str_replace('[skill', '[skill ' . $att, $skills);

    //Build description
    $desc = preg_match('|desc=\\"([^"]+)\\"|', $att, $reg) ? $reg[1]:'';
    $desc = empty($desc) ? '':($desc . '<br/>');
    $desc = str_replace('{br}', '<br/>', str_replace('{br/}', '<br/>', str_replace('{BR}',
        '<br/>', str_replace('{BR/}', '<br/>', $desc))));


    //Pickup status
    $pickup_id = preg_match('|pickup=\\"([^"]+)\\"|', $att, $reg) ? $reg[1]:'';
    //Get all pickup users
    $pickup = load(PICKUP_PATH);
    if (!empty($pickup_id) && $pickup !== false)
    {

        //Output status
        $cursor = 'pointer';
        $pickup = "Can play it: <span id=\"pickup_$pickup_id\">" . pickup_users($pickup,
            $userdata['username'], $pickup_id, 'No one can!') . '</span>';
        $pickup_link = " onclick=\"pickup('switch', '$pickup_id')\"";
    }
    else
    {
        $pickup = '';
        $pickup_link = '';
    }
    $prof_imgs = str_replace('{cursor}', $cursor, $prof_imgs);

    //Template: professions
    $invalid_template = false;
    static $prof_ids = array('No profession', 'Warrior', 'Ranger', 'Monk',
        'Necromancer', 'Mesmer', 'Elementalist', 'Assassin', 'Ritualist', 'Paragon',
        'Dervish');
    $template = '0111000000';
    $template .= int2bin(array_search($primary, $prof_ids), 4);
    $template .= int2bin(array_search($secondary, $prof_ids), 4);

    //Template: attributes
    static $attr_ids = array('fas', 'ill', 'dom', 'ins', 'blo', 'dea', 'sou',
        'cur', 'air', 'ear', 'fir', 'wat', 'ene', 'hea', 'smi', 'pro', 'div', 'str',
        'axe', 'ham', 'swo', 'tac', 'bea', 'exp', 'wil', 'mar', 29 => 'dag', 'dead',
        'sha', 'com', 'res', 'cha', 'cri', 'spa', 'spe', 'comma', 'mot', 'lea', 'scy',
        'win', 'earthp', 'mys');
    static $prof_attr_list = array('Air Magic' => 'Elementalist', 'Earth Magic' =>
        'Elementalist', 'Energy Storage' => 'Elementalist', 'Fire Magic' =>
        'Elementalist', 'Water Magic' => 'Elementalist', 'Domination Magic' => 'Mesmer',
        'Fast Casting' => 'Mesmer', 'Illusion Magic' => 'Mesmer', 'Inspiration Magic' =>
        'Mesmer', 'Divine Favor' => 'Monk', 'Healing Prayers' => 'Monk',
        'Protection Prayers' => 'Monk', 'Smiting Prayers' => 'Monk', 'Blood Magic' =>
        'Necromancer', 'Curses' => 'Necromancer', 'Death Magic' => 'Necromancer',
        'Soul Reaping' => 'Necromancer', 'Beast Mastery' => 'Ranger', 'Expertise' =>
        'Ranger', 'Marksmanship' => 'Ranger', 'Wilderness Survival' => 'Ranger',
        'Axe Mastery' => 'Warrior', 'Hammer Mastery' => 'Warrior', 'Strength' =>
        'Warrior', 'Swordsmanship' => 'Warrior', 'Tactics' => 'Warrior',
        'Critical Strikes' => 'Assassin', 'Dagger Mastery' => 'Assassin', 'Deadly Arts' =>
        'Assassin', 'Shadow Arts' => 'Assassin', 'Spawning Power' => 'Ritualist',
        'Channeling Magic' => 'Ritualist', 'Communing' => 'Ritualist',
        'Restoration Magic' => 'Ritualist', 'Spear Mastery' => 'Paragon', 'Command' =>
        'Paragon', 'Motivation' => 'Paragon', 'Leadership' => 'Paragon',
        'Scythe Mastery' => 'Dervish', 'Wind Prayers' => 'Dervish', 'Earth Prayers' =>
        'Dervish', 'Mysticism' => 'Dervish');
    $attr_list = attribute_list_raw($att);
    arsort($attr_list);//=> First attribute is attribute of highest level


    //Prepare a base attribute level and rune bonus list for primary and secondary attributes
    $attr_primary = array();
    $attr_secondary = array();
    $attr_runes = array();
    $available_helmet = true;
    foreach ($attr_list as $attr => $raw_level)
    {
        //Separate base level and bonus
        preg_match('@^([0-9]+)(\\+[+0-9]+)?@', $raw_level, $reg);
        $base_level = $reg[1];
        $bonus = isset($reg[2]) ? $reg[2]:'0';

        //Primary attributes
        if ($prof_attr_list[$attr] == $primary)
        {
            $bonus_level = @eval('return ' . $bonus . ';');
            //Invalid attribute level bonus
            if ($bonus_level > 4 || $bonus_level < 0 || ($bonus_level == 4 && !$available_helmet))
            {
                $invalid_template = true;
            }
            //Does attribute level bonus include a helmet?
            else
                if ($available_helmet && ($bonus_level == 4 || (substr_count($bonus, '+') > 1 &&
                    strpos($bonus, '+1') !== false)))
                {
                    $available_helmet = false;
                    $attr_primary[$attr] = $base_level;
                    $attr_runes[$attr] = $bonus_level - 1;
                }
            //No helmet, but runes maybe
                else
                {
                    $attr_primary[$attr] = $base_level;
                    $attr_runes[$attr] = $bonus_level;
                }
        }

        //Secondary attributes
        else
            if ($prof_attr_list[$attr] == $secondary)
            {
                $attr_secondary[$attr] = $base_level;
            }
    }

    //Manage primary attribute levels
    $points_secondary = attr_points($attr_secondary);
    if (!empty($attr_primary))
    {
        //Set helmet if needed
        if ($available_helmet && (max($attr_primary) > 12 || (attr_points($attr_primary) +
            $points_secondary > 200)))
        {
            reset($attr_primary);
            $attr_primary[key($attr_primary)]--;//First attribute is attribute of highest level, the one needing a helmet the most
        }
        //Assign runes
        while ((max($attr_primary) > 12 || (attr_points($attr_primary) + $points_secondary >
            200)) && min($attr_runes) < 3)
        {
            arsort($attr_primary);
            foreach ($attr_runes as $attr => $rune)
            {
                if ($rune < 3)
                {
                    $attr_primary[$attr]--;
                    $attr_runes[$attr]++;
                    break;
                }
            }
        }
    }
    $attr_list = array_merge($attr_primary, $attr_secondary);
    $template .= int2bin(count($attr_list), 4);
    if (!empty($attr_list) && (max($attr_list) > 12 || min($attr_list) < 0 ||
        attr_points($attr_list) > 200))
    {
        $invalid_template = true;
    }
    $attr_bit_size = 5;
    $template_attrs = array();
    foreach ($attr_list as $attr => $level)
    {
        $id = array_search(gws_attribute_name($attr), $attr_ids);
        $template_attrs[$id] = $level;
        if ($id >= 32)
        {
            $attr_bit_size = 6;
        }
    }
    $template .= int2bin($attr_bit_size - 4, 4);
    ksort($template_attrs);
    foreach ($template_attrs as $id => $level)
    {
        $template .= int2bin($id, $attr_bit_size);
        $template .= int2bin($level, 4);
    }


    //Template: skills
    $skill_bit_size = 9;
    $template_skills = array();
    if (preg_match_all('#\[skill[^\]]*\](.*?)\[/skill\][ ]?#isS', $skills, $regs,
        PREG_PATTERN_ORDER))
    {
        foreach ($regs[1] as $skill_name)
        {
            if (($id = gws_skill_id($skill_name)) !== false)
            {
                $template_skills[] = $id;
                if ($id > 512)
                {
                    $skill_bit_size = 11;
                }
            }
        }
    }
    $template .= int2bin($skill_bit_size - 8, 4);
    if (count($template_skills) > 8)
    {
        $invalid_template = true;
    }
    else
    {
        foreach ($template_skills as $id)
        {
            $template .= int2bin($id, $skill_bit_size);
        }
        //Complete with 0s
        $template .= str_repeat(str_repeat('0', $skill_bit_size), 8 - count($template_skills));
    }

    //Manage template save icons
    if (strstr($att, 'nosave') !== false)
    {
        $template_download = '';
    }
    else
    {
        if (!$invalid_template)
        {
            //Prepare template bbcode
            $template_code = bin_to_template($template);
            $template_name = preg_replace('@[];]@', '', preg_replace('@<br/>.*@', '', $build_name));
            if (empty($template_name))
            {
                $template_name = gws_profession_abbr($primary);
                if ($secondary != 'No profession' && $secondary != $primary)
                {
                    $template_name .= '/' . gws_profession_abbr($secondary);
                }
            }
            $p_abbr = gws_profession_abbr($primary);
            $s_abbr = gws_profession_abbr($secondary);

			// if our build has its own name, lets use it
			if (strlen($build_name) != 0) $art_name = $p_abbr . "/" . $s_abbr . " " . $build_name;
            $template_bbcode = "[$art_name;$template_code]";
            $template_code = urlencode($template_code);
            $template_size = strlen($template_bbcode);
            $template_download = "<a href=\"\" onclick=\"return switch_template('$load');\"><img class=\"no_link\" src=\"http://images.pvxbuilds.com/img_interface/download.gif\" title=\"Copy $template_bbcode\" style=\"vertical-align: top;\"/></a>";
        }
        else
        {
            $template_download = "<img class=\"no_link\" src=\"http://images.pvxbuilds.com/img_interface/download_no.gif\" title=\"Incorrect build\" style=\"vertical-align: top;\"/>";
        }
    }

    //Show a box around skills if "box" is in the build attribute list
    if (strstr(strtolower($att), 'box') !== false)
    {
        $buildbox_left = 'class="buildbox_left"';
        $buildbox_center = 'class="buildbox_center"';
        $buildbox_right = 'class="buildbox_right"';
    }
    else
    {
        $buildbox_left = '';
        $buildbox_center = '';
        $buildbox_right = '';
    }

    return preg_replace("#\{(.*?)\}#ise", "isset($\\1)?$\\1:'\\0'", $build);
}

//Process the [skill] elements
function skill_replace($reg)
{
    global $gwbbcode_tpl;
    $gwbbcode_root_path = GWBBCODE_ROOT;

    list($all, $att, $name) = $reg;
    $att = html_safe_decode($att);
    $name = html_safe_decode($name);

    //Exit if skill doesn't exist
    if (($id = gws_skill_id($name)) === false)
    {
        return $all;
    }
    
    //else
    $details = gws_details($id);
    if ($details === false)
        die("Missing skill $id.");
    extract($details, EXTR_OVERWRITE);
    $load = rand();

    //Blank skill slot
    if ($name == 'No Skill')
    {
        $skill = $gwbbcode_tpl['blank_icon'];
    }

    //Skill slot
    else
    {
        //Skill name or image on which to move cursor
        if (gws_noicon($att))
        {
            if (GWSHACK)
            {
                $skill = $gwbbcode_tpl['noicon_gwshack'];
            }
            else
            {
                $skill = $gwbbcode_tpl['noicon'];
            }
        }
        else
        {
    		$name = str_replace("\"","&quot;", $name);
        	$skill = $gwbbcode_tpl['icon'];
        }
        $skill .= $gwbbcode_tpl['skill'];

        //What adrenaline/energy/energyregen is required?
        $required = array();
        $img_html = '<div class="bbcode_att_box"><span class="bbcode_att_span">%s</span><img src="http://images.pvxbuilds.com/att_%s.png" /></div>';
        if ($recharge != 0)
            $required[] = sprintf($img_html, $recharge, 'rech');

        //Format casting time
        if ($casting != 0)
        {
            $fastcast = calc_fastcasting($att, $type, $casting);
            switch ($casting)
            {
                case 0.25:
                    $casting_frac = '&frac14;';
                    break;
                case 0.50:
                    $casting_frac = '&frac12;';
                    break;
                case 0.75:
                    $casting_frac = '&frac34;';
                    break;
                default:
                    $casting_frac = $casting;
            }
            if ($fastcast && $fastcast != $casting)
                $casting_frac .= '<span class="bbcode_expert">[' . sprintf('%.2f', $fastcast) .
                    ']</span>';
            $casting = $casting_frac;
            $required[] = sprintf($img_html, $casting, 'cast');
        }

        //Format energy, adrenaline and upkeep
        if ($adrenaline != 0)
            $required[] = sprintf($img_html, $adrenaline, 'adre');
        else
            if ($energy != 0)
            {
                $ex_energy = calc_expertise($att, $type, $energy, $profession, $desc);
                if ($ex_energy && $ex_energy != $energy)
                    $energy .= '<span class="bbcode_expert">[' . $ex_energy . ']</span>';
                $required[] = sprintf($img_html, $energy, 'ener');
            }
        if ($eregen != 0)
            $required[] = sprintf($img_html, -$eregen, 'eregen');
        $required = implode(array_reverse($required));

        //Have a nice golden background if skill is elite
        if (isset($elite) && $elite)
        {
            $elite_background = 'bbcode_name_elite';
            $type = 'Elite ' . $type;
        }
        else
        {
            $elite_background = 'bbcode_name_normal';
            $yellow_elite = '';
        }

        //Campaign names
        switch ($chapter)
        {
        case 0:
            $chapter = "Core";
            break;
        case 1:
            $chapter = "Prophecies";
            break;
        case 2:
            $chapter = "Factions";
            break;
        case 3:
            $chapter = "Nightfall";
            break;
        }


        //Descriptions variables -> green and adapted to their attribute. (1..16 -> green 8)
        $desc = gws_adapt_description($name, $attribute, $att, $desc);
        $block_size = strlen($desc) * 1.33;
        if ($block_size < 280)
            $block_size = 295;

        //Profession icon
        if ($prof == '?')
            $prof_img = "http://images.pvxbuilds.com/img_interface/No-Profession.png";
        else
            $prof_img = "http://images.pvxbuilds.com/img_interface/$profession.png";
        //TODO: No profession img
    }

    $skill = preg_replace("#\{(.*?)\}#ise", "isset($\\1)?$\\1:'\\0'", $skill);

    //Adds a space entity if the skill tag is followed by a space
    //Necessary cause IE doesn't show spaces following divs
    if ($all[strlen($all) - 1] === ' ')
    {
        $skill .= '&nbsp;';
    }
	
    return $skill;
}







//Returns either the id of a $skill_name, or false
//Also works if $skill_name is an abbreviation
function gws_skill_id($skill_name)
{
    //Handle abbreviations
    static $abbr_db = array();
    $skill_name = strtolower($skill_name);
    if (empty($abbr_db))
    {
        if (($abbr_db = @load(SKILLABBRS_PATH)) === false)
        {
            die("Missing abbreviation database.");
        }
    }
    if (isset($abbr_db[$skill_name]))
    {
        $skill_name = $abbr_db[$skill_name];
    }

    //Retreive the id
    if (!GWBBCODE_SQL)
    {
        //File DB
        //Load the name to id listing from a file (only once)
        static $list = array();
        if (empty($list))
        {
            if (($list = @load(SKILLNAMES_PATH)) === false)
            {
                die("Missing skillname database.");
            }
        }
        $name_id = preg_replace('|[\'"!]|', '', strtolower($skill_name));
        $ret = isset($list[$name_id]) ? $list[$name_id]:false;
    }
    else
    {
        //SQL DB
        $name_id = mysql_real_escape_string(preg_replace('@["\'!]@', '', strtolower($skill_name)));
        $result = mysql_query("SELECT id FROM `skills` WHERE name_id='$name_id'") or die('Query failed: ' .
            mysql_error());
        $ret = mysql_fetch_assoc($result);
        mysql_free_result($result);
        $ret = $ret ? $ret['id']:false;//Directly return the id, not an array
    }
    return $ret;
}


//Returns either the skill information array of a $skill_id, or false
function gws_details($skill_id)
{
    if (!GWBBCODE_SQL)
    {
        //File DB
        //(Re)load skill list
        static $skill_list = array();
        if (empty($skill_list))
        {
            if (!file_exists(SKILLS_PATH_1) || !file_exists(SKILLS_PATH_2))
                return false;
            else
                $skill_list = load(SKILLS_PATH_1);//Can't use array_merge here otherwise keys get lost
            $add_list = load(SKILLS_PATH_2);
            foreach ($add_list as $key => $val)
            {
                $skill_list[$key] = $val;
            }
        }
        $ret = isset($skill_list[$skill_id]) ? $skill_list[$skill_id]:false;
    }
    else
    {
        //SQL DB
        preg_match('@^[0-9]+$@', $skill_id) or die('Unsafe skill id');
        $result = mysql_query("SELECT * FROM `skills` WHERE id=$skill_id") or die('Query failed: ' .
            mysql_error());
        $ret = mysql_fetch_assoc($result);
        mysql_free_result($result);
    }
    return $ret;
}


//Returns values of the prof attribute of an attribute list (string $att), or false
//gws_build_profession(' prof=W/E tactics=16 desc="fdsfsdf"')  ===  Array('primary' => 'W', 'secondary' => 'E', 'professions => 'W/E')
function gws_build_profession($att)
{
    if (preg_match('|prof=(([^/ ]+)/([^ ]+))|', $att, $reg))
        return array('primary' => $reg[2], 'secondary' => $reg[3], 'professions' => $reg[1]);
    else
        if (preg_match('|prof=([^/ ]+)|', $att, $reg))
            return array('primary' => $reg[1], 'secondary' => '?', 'professions' => $reg[1]);
        else
            return false;
}

//Returns value of the name attribute of an attribute list (string $att), or ''
//gws_build_name(' prof=W/E name="Shock Warrior"')  ===  'Shock Warrior'
function gws_build_name($att)
{
    return preg_match('|name=\\"([^\"]+)\\"|', $att, $reg) ? $reg[1]:'';
}

//Returns the full profession name of a partial one. Returns 'No profession' if no match is found
function gws_prof_name($profession)
{
    //Look for a profession name corresponding to $profession
    static $p = array('E' => 'Elementalist', 'Me' => 'Mesmer', 'Mo' => 'Monk', 'N' =>
        'Necromancer', 'R' => 'Ranger', 'W' => 'Warrior', 'A' => 'Assassin', 'Rt' =>
        'Ritualist', 'D' => 'Dervish', 'P' => 'Paragon', '?' => 'No profession');
    $profession = strtolower($profession);

    //Ritualist exception
    if ($profession == 'rt')
        return $p['Rt'];

    foreach ($p as $prof)
        if (strpos(strtolower($prof), $profession) === 0)
            return $prof;

    //No corresponding profession was found
    return 'No profession';
}


//Returns the profession abbreviation of a partial one. Returns '?' if no match is found
function gws_profession_abbr($profession)
{
    static $p = array('E' => 'Elementalist', 'Me' => 'Mesmer', 'Mo' => 'Monk', 'N' =>
        'Necromancer', 'R' => 'Ranger', 'W' => 'Warrior', 'A' => 'Assassin', 'Rt' =>
        'Ritualist', 'D' => 'Dervish', 'P' => 'Paragon', '?' => 'No profession');
    return array_search(gws_prof_name($profession), $p);
}


//Returns the full attribute name of a partial or full one. Returns false if no match is found
function gws_attr_name($attr)
{
    static $attribute_list = array('airmagic' => 'Air Magic', 'earthmagic' =>
        'Earth Magic', 'energystorage' => 'Energy Storage', 'firemagic' => 'Fire Magic',
        'watermagic' => 'Water Magic', 'dominationmagic' => 'Domination Magic',
        'fastcasting' => 'Fast Casting', 'illusionmagic' => 'Illusion Magic',
        'inspirationmagic' => 'Inspiration Magic', 'divinefavor' => 'Divine Favor',
        'healingprayers' => 'Healing Prayers', 'protectionprayers' =>
        'Protection Prayers', 'smitingprayers' => 'Smiting Prayers', 'bloodmagic' =>
        'Blood Magic', 'curses' => 'Curses', 'deathmagic' => 'Death Magic',
        'soulreaping' => 'Soul Reaping', 'beastmastery' => 'Beast Mastery', 'expertise' =>
        'Expertise', 'marksmanship' => 'Marksmanship', 'wildernesssurvival' =>
        'Wilderness Survival', 'axemastery' => 'Axe Mastery', 'hammermastery' =>
        'Hammer Mastery', 'strength' => 'Strength', 'swordsmanship' => 'Swordsmanship',
        'tactics' => 'Tactics', 'criticalstrikes' => 'Critical Strikes', 'daggermastery' =>
        'Dagger Mastery', 'deadlyarts' => 'Deadly Arts', 'shadowarts' => 'Shadow Arts',
        'spawningpower' => 'Spawning Power', 'channelingmagic' => 'Channeling Magic',
        'communing' => 'Communing', 'restorationmagic' => 'Restoration Magic',
        'spearmastery' => 'Spear Mastery', 'command' => 'Command', 'motivation' =>
        'Motivation', 'leadership' => 'Leadership', 'scythemastery' => 'Scythe Mastery',
        'windprayers' => 'Wind Prayers', 'earthprayers' => 'Earth Prayers', 'mysticism' =>
        'Mysticism');

    $attr = strtolower(str_replace('_', '', $attr));
    if (empty($attr))
    {
        return false;
    }

    foreach ($attribute_list as $long_attr => $attribute)
    {
        if (strpos($long_attr, $attr) === 0)
        {
            return $attribute;
        }
    }
    //else
    return false;
}

//Returns the attribute name abbreviation of a partial one. Returns false if no match is found
function gws_attribute_name($attribute)
{
    static $attribute_list = array('air' => 'airmagic', 'ear' => 'earthmagic', 'ene' =>
        'energystorage', 'fir' => 'firemagic', 'wat' => 'watermagic', 'dom' =>
        'dominationmagic', 'fas' => 'fastcasting', 'ill' => 'illusionmagic', 'ins' =>
        'inspirationmagic', 'div' => 'divinefavor', 'hea' => 'healingprayers', 'pro' =>
        'protectionprayers', 'smi' => 'smitingprayers', 'blo' => 'bloodmagic', 'cur' =>
        'curses', 'dea' => 'deathmagic', 'sou' => 'soulreaping', 'bea' => 'beastmastery',
        'exp' => 'expertise', 'mar' => 'marksmanship', 'wil' => 'wildernesssurvival',
        'axe' => 'axemastery', 'ham' => 'hammermastery', 'str' => 'strength', 'swo' =>
        'swordsmanship', 'tac' => 'tactics', 'cri' => 'criticalstrikes', 'dag' =>
        'daggermastery', 'dead' => 'deadlyarts', 'sha' => 'shadowarts', 'spa' =>
        'spawningpower', 'cha' => 'channelingmagic', 'com' => 'communing', 'res' =>
        'restorationmagic', 'spe' => 'spearmastery', 'comma' => 'command', 'mot' =>
        'motivation', 'lea' => 'leadership', 'scy' => 'scythemastery', 'win' =>
        'windprayers', 'earthp' => 'earthprayers', 'mys' => 'mysticism');

    $attribute = strtolower(str_replace(' ', '', $attribute));
    foreach ($attribute_list as $attr => $long_attr)
    {
        if (strpos($long_attr, $attribute) === 0)
        {
            return $attr;
        }
    }
    //else
    return false;
}

//Returns an attribute list (string) cleaned of the prof, name, desc and pickup attributes
function gws_attributes_clean($att)
{
    $att = preg_replace('|prof=[^ \]]*|', '', $att);
    $att = preg_replace('|name=\\"[^"]+\\"|', '', $att);
    $att = preg_replace('|desc=\\"[^"]+\\"|', '', $att);
    $att = preg_replace('|pickup=\\"[^"]+\\"|', '', $att);
    return trim($att);
}

//Returns a list of attributes and their string values (e.g "12+1+3")
function attribute_list_raw($att)
{
    $list = array();
    $clean_attr = explode(' ', gws_attributes_clean($att));
    foreach ($clean_attr as $value)
    {
        $value = explode('=', $value);
        //Only one '='?
        if (count($value) == 2)
        {
            $attr_name = gws_attr_name($value[0]);
            //Valid attribute name?
            if ($attr_name !== false)
            {
                $attr_value = preg_replace('@[^0-9+-]@', '', $value[1]);
                //Valid attribute value?
                if (isset($attr_value) && $attr_value !== false)
                {
                    //Alright record it
                    $list[$attr_name] = $attr_value;
                }
            }
        }
    }
    return $list;
}

//Returns a list of attributes and their numeric values (e.g "12+1+3" will return 16)
function attribute_list($att)
{
    $list = attribute_list_raw($att);
    foreach ($list as $attr_name => $attr_lvl)
    {
        $list[$attr_name] = @eval('return ' . $attr_lvl . ';');
    }
    return $list;
}

//Return the number of necessary attribute points for given attribute levels
//or false
function attr_points($attr_list)
{
    static $point_list = array(0, 1, 2, 3, 4, 5, 6, 7, 9, 11, 13, 16, 20);
    $points = 0;
    foreach ($attr_list as $level)
    {
        if (!isset($point_list[$level]))
        {
            return false;
        }
        $points += $point_list[$level];
    }
    return $points;
}

//Returns a description after adapting it's variables to an attribute value
function gws_adapt_description($name, $attribute, $att, $description)
{
    //Take into account Divine Favor
    $description = add_divine_favor($att, $name, $description);

    //Add {Attrib: attr_name)
    if ($attribute != 'No Attribute')
        $description .= " (Attrib: $attribute)";

    //Put some green around the fork
    $description = preg_replace_callback('|([0-9]+\.\.[0-9]+)|', 'fork_replace', $description);

    //Adapt the fork to the build's attribute level..
    $attr_list = attribute_list($att);
    if (isset($attr_list[$attribute]))
    {
        $attr_lvl = $attr_list[$attribute];
        $description = str_replace("(Attrib: $attribute)", "(Attrib: <b>$attr_lvl</b> $attribute)",
            $description);
        if (preg_match_all('|([0-9]+)\.\.([0-9]+)|', $description, $regs, PREG_SET_ORDER))
        {
            foreach ($regs as $fork)
            {
                list($all, $val_0, $val_15) = $fork;
                $description = str_replace($all, fork_val($val_0, $val_15, $attr_lvl), $description);
            }
        }
    }
    //.. or show its 0..12..16 values
    else
    {
        $description = preg_replace_callback('|([0-9]+)\.\.([0-9]+)|', 'desc_replace', $description);
    }

    //Specify a Spirit health and armor
    $description = add_spirit_health($att, $description);

    return $description;
}

//Replace a 0..15 fork by a 0..12..16 one
function desc_replace($reg)
{
    list($all, $val_0, $val_15) = $reg;
    return $val_0 . '..' . fork_val($val_0, $val_15, 12) . '..' . fork_val($val_0, $val_15,
        16);
}

//Return value at a given attribute level
function fork_val($val_0, $val_15, $attr_lvl)
{
    return $val_0 + round(($val_15 - $val_0) * $attr_lvl / 15);
}
//Put some green around the fork
function fork_replace($reg)
{
    list($all, $fork) = $reg;
    return "<span class=\"variable\">$fork</span>";//Make sure to adapt add_spirit_health() if you change this
}


//Returns true if $att specifies that the skill should be rendered as text
function gws_noicon($att)
{
    return strstr($att, 'noicon') !== false;
}



//Returns current time in seconds with a 2 decimal digits precision
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return (float)$usec + (float)($sec % 100);
}


//Restores html entities to characters, except for '<'
function html_safe_decode($text)
{
    return str_replace('<', '&lt;', html_entity_decode($text));
}


/*Loads gwbbcode templates from the gwbbcode.tpl file.
Creates an array, keys are bbcode names like "b_open" or "url", values
are the associated template.
Probably pukes all over the place if there's something really screwed
with the gwbbcode.tpl file.
Modification of Nathan Codding's load_bbcode_template.*/
function load_gwbbcode_template()
{
    $tpl_array = file(TEMPLATE_PATH);

    //Trim each line
    $tpl = '';
    foreach ($tpl_array as $line)
        $tpl .= trim($line);


    //Replace \ with \\ and then ' with \'.
    $tpl = str_replace('\\', '\\\\', $tpl);
    $tpl = str_replace('\'', '\\\'', $tpl);

    //Strip newlines.
    $tpl = str_replace("\n", '', $tpl);

    //Turn template blocks into PHP assignment statements for the values of $gwbbcode_tpls..
    $tpl = preg_replace('#<!-- BEGIN (.*?) -->(.*?)<!-- END (.*?) -->#', "\n" .
        '$gwbbcode_tpls[\'\\1\'] = clean_tpl(\'\\2\');', $tpl);

    $gwbbcode_tpls = array();

    eval($tpl);

    return $gwbbcode_tpls;
}


//Outputs a javascript alert
function alert($msg)
{
    $msg = addslashes($msg);
    echo "<script>alert('$msg')</script>";
    exit(0);
}

//Return a string after removing all its whitespaces at begining of lines, and its newlines
function clean_tpl($tpl)
{
    return preg_replace('@[\r\n][ ]*@', '', $tpl);
}


//Sets $var to false if it wasn't already set
function set_or_false(&$var)
{
    $var = isset($var) ? $var:false;
    return $var;
}

//Int to bin on $bit_size bits
function int2bin($int, $bit_size)
{
    $bin = strrev(base_convert($int, 10, 2));
    if ($bit_size < strlen($bin))
    {
        return false;
    }
    //else
    return $bin . str_repeat('0', $bit_size - strlen($bin));
}

//Save a var to a file
function save($filename, $var)
{
    if ($f = @fopen($filename, 'wb'))
    {
        $res = @fwrite($f, '<? return ' . var_export($var, true) . '; ?>');
        @fclose($f);
        return $res !== false;
    }
    return false;
}

//Load a var from a file
function load($filename)
{
    if (!file_exists($filename))
        return false;
    else
        return require ($filename);
}


//Return the real energy cost of a skill depending on its type and level of Expertise
function calc_expertise($attr, $type, $energy, $profession, $desc)
{
    $list = attribute_list($attr);
    if (isset($list['Expertise']) && $list['Expertise'] > 0 && ($profession ==
        'Ranger' || strpos($type, 'Attack') !== false || strpos($type, 'Ritual') !== false ||
        ($type == 'Skill' && preg_match('@touch@i', $desc))))
    {
        return round($energy * (1.0 - 0.04 * $list['Expertise']));
    }

    //else
    return false;
}

//Return the real cast time of a skill depending on its type and level of Fast Casting
function calc_fastcasting($attr, $type, $casting)
{
    $list = attribute_list($attr);
    if (strpos($type, 'Spell') !== false && isset($list['Fast Casting']) && $list['Fast Casting'] >
        0)
    {
        return $casting * pow(2.0, (($list['Fast Casting'] * -1.0) / 15.0));
    }

    //else
    return false;
}


//Return a description of the real effect of a skill taking into account Divine Favor
function add_divine_favor($attr, $name, $desc)
{
    $list = attribute_list($attr);
    if (isset($list['Divine Favor']) && $list['Divine Favor'] > 0)
    {
        $div_heal = round(3.2 * $list['Divine Favor']);

        //{div}
        if ($name === 'Healing Touch')
            $desc = str_replace('{div}', '<span class="expert">(+' . (2 * $div_heal) .
                '&#041;</span>', $desc);
        else
            $desc = str_replace('{div}', '<span class="expert">(+' . $div_heal .
                '&#041;</span>', $desc);

        //{target} and {self}
        $desc = str_replace('{target}',
            '<span class="expert"> Target ally gets healed for ' . $div_heal .
            ' Health.</span>', $desc);
        $desc = str_replace('{self}', '<span class="expert"> You get healed for ' . $div_heal .
            ' Health.</span>', $desc);
    }

    //Remove remaining unused tags
    else
    {
        $desc = str_replace('{div}', '', $desc);
        $desc = str_replace('{target}', '', $desc);
        $desc = str_replace('{self}', '', $desc);
    }

    return $desc;
}


//Return a description specifying how much health and armor does a Spirit have
function add_spirit_health($attr, $desc)
{
    $list = attribute_list($attr);

    //Get Spirit's level
    if (preg_match('@Create a level <span class="variable">([0-9]+)</span> Spirit@',
        $desc, $reg))
    {
        $spirit_level = $reg[1];

        //Get Binding Ritual level
        $spawning_level = isset($list['Spawning Power']) ? $list['Spawning Power']:0;

        //Compute the Spirit's Health and armor
        $spirit_health = 50 + ($spirit_level * 20);//Thanks to GuildWiki.org for this equation
        $spawning_bonus = '';
        if ($spawning_level > 0)
        {
            $spawning_health = round($spirit_health * ($spawning_level * 0.04));
            $spawning_bonus = ' (+' . $spawning_health . '&#041;';
        }
        $spirit_armor = round((88 / 15 * $spirit_level) + 3);

        //Add Spirit's health to description
        $desc = preg_replace('@Create a level <span class="variable">[0-9]+</span> Spirit@',
            '${0} <span class="expert"> with ' . $spirit_health . $spawning_bonus .
            ' Health and ' . $spirit_armor . ' armor</span>', $desc);
    }

    return $desc;
}





//Template conversion
/////////////////////

//Return a binary string based on the $text template_id
function template_to_bin($text)
{
    static $conv_table = array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' =>
        5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' =>
        13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20,
        'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25, 'a' => 26, 'b' => 27, 'c' =>
        28, 'd' => 29, 'e' => 30, 'f' => 31, 'g' => 32, 'h' => 33, 'i' => 34, 'j' => 35,
        'k' => 36, 'l' => 37, 'm' => 38, 'n' => 39, 'o' => 40, 'p' => 41, 'q' => 42, 'r' =>
        43, 's' => 44, 't' => 45, 'u' => 46, 'v' => 47, 'w' => 48, 'x' => 49, 'y' => 50,
        'z' => 51, '0' => 52, '1' => 53, '2' => 54, '3' => 55, '4' => 56, '5' => 57, '6' =>
        58, '7' => 59, '8' => 60, '9' => 61, '+' => 62, '/' => 63);
    $ret = '';
    foreach (preg_split('//', trim($text), -1, PREG_SPLIT_NO_EMPTY) as $char)
    {
        $bin = strrev(base_convert($conv_table[$char], 10, 2));
        $ret .= $bin . str_repeat('0', 6 - strlen($bin));
    }
    return $ret;
}

//Return a template string based on the $bin binary string
function bin_to_template($bin)
{
    static $conv_table = array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' =>
        5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' =>
        13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20,
        'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25, 'a' => 26, 'b' => 27, 'c' =>
        28, 'd' => 29, 'e' => 30, 'f' => 31, 'g' => 32, 'h' => 33, 'i' => 34, 'j' => 35,
        'k' => 36, 'l' => 37, 'm' => 38, 'n' => 39, 'o' => 40, 'p' => 41, 'q' => 42, 'r' =>
        43, 's' => 44, 't' => 45, 'u' => 46, 'v' => 47, 'w' => 48, 'x' => 49, 'y' => 50,
        'z' => 51, '0' => 52, '1' => 53, '2' => 54, '3' => 55, '4' => 56, '5' => 57, '6' =>
        58, '7' => 59, '8' => 60, '9' => 61, '+' => 62, '/' => 63);
    $ret = '';
    $bin .= str_repeat('0', 6 - (strlen($bin) % 6));
    while (!empty($bin))
    {
        $digit = substr($bin, 0, 6);
        $bin = substr($bin, 6);
        $ret .= array_search(base_convert(strrev($digit), 2, 10), $conv_table);
    }
    return $ret;
}



//Return gwbbcode based on the $text template id
function template_to_gwbbcode($text)
{
    static $prof_ids = array('?', 'W', 'R', 'Mo', 'N', 'Me', 'E', 'A', 'Rt', 'P',
        'D');
    static $attr_ids = array('fas', 'ill', 'dom', 'ins', 'blo', 'dea', 'sou',
        'cur', 'air', 'ear', 'fir', 'wat', 'ene', 'hea', 'smi', 'pro', 'div', 'str',
        'axe', 'ham', 'swo', 'tac', 'bea', 'exp', 'wil', 'mar', 29 => 'dag', 'dead',
        'sha', 'com', 'res', 'cha', 'cri', 'spa', 'spe', 'comma', 'mot', 'lea', 'scy',
        'win', 'earthp', 'mys');

    //Handle the [build name;build code] syntaxe
    $build_name = '';
    if (preg_match('@([^][]+);([^];]+)@', $text, $reg))
    {
        $build_name = $reg[1];
        $text = $reg[2];
    }

    $bin = template_to_bin($text);
    //Handle the new format (i.e leading '0111')
    if (preg_match('@^0111@', $bin))
    {
        $bin = substr($bin, 4);
    }

    $ret = '';
    if (!preg_match('@^([01]{6})([01]{4})([01]{4})([01]{4})([01]{4})@', $bin, $reg))
    {
        return 'Couldn\'t read professions nor attribute count and size';
    }
    $bin = preg_replace('@^([01]{6})([01]{4})([01]{4})([01]{4})([01]{4})@', '', $bin);

    //Make sure template begins with '000000'
    if ($reg[1] != '000000')
    {
        return 'First 6 bits are invalid';
    }

    //Primary profession
    $primary_id = binval($reg[2]);
    if (!isset($prof_ids[$primary_id]))
    {
        return 'Invalid primary profession';
    }
    $primary = $prof_ids[$primary_id];

    //Secondary profession
    $secondary_id = binval($reg[3]);
    if (!isset($prof_ids[$secondary_id]))
    {
        return 'Invalid secondary profession';
    }
    $secondary = $prof_ids[$secondary_id];

    //Create prof=?/?
    $ret .= "[build prof=$primary/$secondary";

    //Add build name if any
    if (!empty($build_name))
    {
        $ret .= ' name="' . str_replace('"', "''", $build_name) . '"';
    }

    //Manage attributes
    $attr_count = binval($reg[4]);
    $attr_size = 4 + binval($reg[5]);
    for ($i = 0; $i < $attr_count; $i++)
    {
        if (!preg_match('@^([01]{' . $attr_size . '})([01]{4})@', $bin, $reg2))
        {
            return 'Couldn\'t read attribute id and value';
        }
        $bin = preg_replace('@^([01]{' . $attr_size . '})([01]{4})@', '', $bin);

        //Attribute name
        $attr_id = binval($reg2[1]);
        if (!isset($attr_ids[$attr_id]))
        {
            return "Invalid attribute id: $attr_id";
        }
        $attr_name = $attr_ids[$attr_id];

        //Attribute value
        $attr_value = binval($reg2[2]);
        if ($attr_value > 12)
        {
            return 'An attribute value can\'t be higher than 12';
        }

        //Create attr=10
        $ret .= " $attr_name=$attr_value";
    }
    $ret .= ']';

    //Skills
    if (!preg_match('@^([01]{4})@', $bin, $reg2))
    {
        return 'Couldn\'t get skill id size';
    }
    $bin = preg_replace('@^([01]{4})@', '', $bin);

    //Skill size
    $skill_size = 8 + binval($reg2[1]);
    for ($i = 0; $i < 8; $i++)
    {
        if (!preg_match('@^([01]{' . $skill_size . '})@', $bin, $reg2))
        {
            return 'Couldn\'t read attribute id and value';
        }
        $bin = preg_replace('@^([01]{' . $skill_size . '})@', '', $bin);

        //Skill name
        $skill_id = binval($reg2[1]);
        $skill = gws_details($skill_id);
        $skill_name = $skill['name'];
        if ($skill === false)
        {
            $ret .= "[Unknown skill id $skill_id]";
        }
        else
        {
            $ret .= '[' . $skill['name'] . ']';
        }
    }

    return $ret . '[/build]';
}




function binval($bin)
{
    return intval(base_convert(strrev($bin), 2, 10));
    ;
}



//Organize skill by elite, profession, attribute and name
function skill_sort_cmp($a, $b)
{
    static $prof_ids = array('Warrior', 'Ranger', 'Monk', 'Necromancer', 'Mesmer',
        'Elementalist', 'Assassin', 'Ritualist', 'Paragon', 'Dervish', 'No profession');
    if ($a['elite'] == $b['elite'])
    {
        $a['prof_id'] = array_search($a['profession'], $prof_ids);
        $b['prof_id'] = array_search($b['profession'], $prof_ids);
        if ($a['prof_id'] == $b['prof_id'])
        {
            if ($a['attribute'] == 'No Attribute')
            {
                $a['attribute'] = 'ZZZ';
            }
            if ($b['attribute'] == 'No Attribute')
            {
                $b['attribute'] = 'ZZZ';
            }

            //Special case: Dervish
            $d_attributes = array('Earth Prayers', 'Wind Prayers', 'Mysticism',
                'Scythe Mastery', 'ZZZ');
            if ($a['prof'] == 'D')
            {
                $a['attribute'] = array_search($a['attribute'], $d_attributes);
                $b['attribute'] = array_search($b['attribute'], $d_attributes);
            }

            if (preg_replace('|[\'! ]|', '', strtolower($a['attribute'])) == preg_replace('|[\'! ]|',
                '', strtolower($b['attribute'])))
            {
                if (preg_replace('|[\'!]|', '', strtolower($a['name'])) == preg_replace('|[\'!]|',
                    '', strtolower($b['name'])))
                {
                    return 0;
                }
                return (preg_replace('|[\'!]|', '', strtolower($a['name'])) < preg_replace('|[\'!]|',
                    '', strtolower($b['name']))) ? -1:1;
            }
            return (preg_replace('|[\'! ]|', '', strtolower($a['attribute'])) < preg_replace
                ('|[\'! ]|', '', strtolower($b['attribute']))) ? -1:1;
        }
        return ($a['prof_id'] < $b['prof_id']) ? -1:1;
    }
    return ($a['elite'] > $b['elite']) ? -1:1;
}

?>