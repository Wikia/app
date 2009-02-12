<?php
if (!defined('MEDIAWIKI'))
    die();
/**
 * A Special Page sample that can be included on a wikipage like
 * {{Special:Inc}} as well as being accessed on [[Special:Inc]]
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfPvXConvert';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PvX Converter',
	'url' => 'http://www.gcardinal.com/',
    'description' => 'Convert from old style GuildWiki Attributes and Skills template to PvXcode. by-nc-nd/3.0.', 
	'author' => 'gcardinal');

function wfPvXConvert()
{
    global $IP, $wgMessageCache;

    $wgMessageCache->addMessage('pvxconvert', 'PvXConvert');

    require_once "$IP/includes/SpecialPage.php";
    class SpecialPvXConvert extends SpecialPage
    {
        /**
         * Constructor
         */
        function SpecialPvXConvert()
        {
            SpecialPage::SpecialPage('PvXConvert');
            $this->includable(true);
        }

        /**
         * main()
         */
        function execute($par = null)
        {
            global $wgOut;
            global $wgRequest;
            global $wgScript;
            $name = $wgRequest->getText('wpName');
            $build = $wgRequest->getText('wpBuild');
            if ($this->including())
			{
                $out = "I'm being included... :(";
			} else {
                if ($build)
                {
					$rout = formatBuild($build, $name);
					$wgOut->addWikiText("== Preview ==");
					$wgOut->addWikiText($rout);
					$wgOut->addHtml("<br>");
					$wgOut->addWikiText("== PvXcode ==");
					$out = "<p><textarea cols='80' rows='10' wrap='virtual'>" . $rout . "</textarea></p>";
                }
                else
                {
                    $out = '<p>
							This converter can process single template (attribute & skill) as well as a whole wiki page. It will replace old style template with new pvxcode. <br>
							However manual control is required. Sample input:<br><code>
							{{attributes&nbsp;|&nbsp;Ranger&nbsp;|&nbsp;Mesmer<br>
							&nbsp;&nbsp;|&nbsp;Wilderness&nbsp;Survival&nbsp;|&nbsp;12&nbsp;+&nbsp;1&nbsp;+&nbsp;3<br>
							&nbsp;&nbsp;|&nbsp;Expertise&nbsp;|&nbsp;12&nbsp;+&nbsp;1<br>
							}}<br>
							{{skill bar|Echo|Dust Trap|Barbed Trap|Flame Trap|Trappers Speed|Troll Unguent|Whirling Defense|Resurrection Signet}}</code>
							<p>Enter old style GuildWiki &quot;Attributes and Skills&quot; template:</p>
							<form action="' . $_SERVER["PHP_SELF"] . '" method="get">
							<input name="title" type="hidden" value="Special:PvXconvert" />
							<p><textarea name="wpBuild" cols="80" rows="10" wrap="virtual"></textarea></p>
							<p>Give new build template a name (optional):</p>
							<p><input name="wpName" type="text" size="80" maxlength="60" /></p>
							<p><input name="Go" type="submit" /></p>
							</form>';
                }
                $this->setHeaders();
            }
            $wgOut->addHtml($out);
        }
    }

    SpecialPage::addPage(new SpecialPvXConvert);
}

function formatBuild($build, $name)
{
	$build = split("skill", $build);
	$att = $build[0];
	$skl = $build[1];
	return (cnv_attributes($att,$name) . cnv_skils($skl));
}

function cnv_skils($skl)
{
    $var = preg_replace("/\r\n|\n|\r/", "", $skl);
    $var = str_replace("'", "", $var);
    $var = str_replace("\"", "", $var);
    $var = str_replace("!", "", $var);
    $var = str_replace("{{", "", $var);
    $var = str_replace("}}", "", $var);
    $skills = split("\|", $var);
    $out = array();
    $i = 0;
    while ($i <= count($out))
    {
        if (isset($skills[$i + 1]))
        {
            $out[$i] = "[" . $skills[$i + 1] . "]";
        }
        $i++;
    }
    $skills = strtolower(implode("", $out)) . "[/build]\n</pvxbig>";
    return $skills;
}

function cnv_attributes($att,$name)
{
    $var = preg_replace("/\r\n|\n|\r/", "", $att);
    $var = str_replace(" ", "", $var);
    $var = str_replace("{{", "", $var);
    $var = str_replace("}}", "", $var);
    $attributes = split("\|", $var);
    $out = array();
    if ($name)
    {
        $out[0] = '<pvxbig>
[build name="' . $name . '" prof=' . substr($attributes[1], 0, 5) . '/' . substr($attributes[2], 0, 5);
    }
    else
    {
	    $out[0] = "<pvxbig>
[build prof=" . substr($attributes[1], 0, 5) . "/" . substr($attributes[2], 0, 5);
    }
    $i = 3;
    $y = 1;
    while ($i <= count($attributes))
    {
        if ($attributes[$i + 1])
        {
            $out[$y] = substr($attributes[$i], 0, 6) . "=" . substr($attributes[$i + 1], 0, 12);
        }
        $y++;
        $i = $i + 2;
    }
    $attributes = strtolower(implode(" ", $out) . "]");
    return $attributes;
}

?>
