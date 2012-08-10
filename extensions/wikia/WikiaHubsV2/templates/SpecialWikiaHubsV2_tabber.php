<?php

/**
 * This needs to be generated in the template, as we have to avoid
 * assigning html output of gallery in the controller in order
 * to prevent displaying it in raw/JSON output formats
 *
 */

$app = F::app();


/*

<html>
<span class="title">
</html>
{{{1|Wikia's Picks}}}
<html>
</span>
</html>
[[File:{{{sponsoredimage}}}|right]]
<html>
</div>
</html>
{{#tag:tabber|
{{{tab-one-title}}}=<div style="padding:5px;">
[[File:{{{tab-one-image}}}|200px|right|link={{{tab-one-image-link}}}]]
{{{tab-one-content}}}
</div>
{{!}}-{{!}}
{{{tab-two-title}}}=<div style="padding:5px;">
[[File:{{{tab-two-image}}}|200px|right|link={{{tab-two-image-link}}}]]
{{{tab-two-content}}}
</div>
{{!}}-{{!}}
{{{tab-three-title}}}=<div style="padding:5px;">
[[File:{{{tab-three-image}}}|200px|right|link={{{tab-three-image-link}}}]]
{{{tab-three-content}}}
</div>
}}



$galleryText = '<gallery type="slider" orientation="mosaic">';
foreach($images as $image) {
	$galleryText .= "\n" . implode('|',array(
			$image['image'],
			$image['headline'],
			'link=' . $image['anchor'],
			'linktext=' . $image['description'],
			'shorttext=' . $image['title']
		)
	);
}
$galleryText .= "\n</gallery>";

echo $app->wg->parser->parse( $galleryText, $app->wg->title, $app->wg->out->parserOptions(),true )->getText();

*/
?>

<section class="grid-3 alpha wikiahubs-newstabs">
	<div class="title-wrapper">
		<span class="title">Wikia's Picks</span>
		<div class="floatright">
			<a href="http://images3.wikia.nocookie.net/__cb57088/wikiaglobal/images/5/5e/5x5transparent.png" class="image" data-image-name="5x5transparent.png"><img alt="5x5transparent.png" src="http://images3.wikia.nocookie.net/__cb20120306180629/wikiaglobal/images/5/5e/5x5transparent.png" width="5" height="5" /></a>
		</div>
	</div>
	<link rel="stylesheet" href="http://slot2.images.wikia.nocookie.net/__cb57086/common/extensions/3rdparty/tabber/tabber.css?57086" TYPE="text/css" MEDIA="screen">
	<script>JSSnippetsStack.push({dependencies:["/extensions/3rdparty/tabber/tabber.js"],getLoaders:function(){return [$.loadJQueryUI]}})</script>
	<div class="tabber">
		<div class="tabbertab" title="New Announcements">
			<div style="padding:5px;">
				<div class="floatright">
					<a href="http://masseffect.wikia.com/wiki/User_blog:James12708/Crazy_battle_Mass_Effect_vs_Halo_vs_Darksiders_Army_of_Heaven">
						<img alt="Halo-4-trailer.jpg" src="http://images4.wikia.nocookie.net/__cb20120710163050/wikiaglobal/images/thumb/c/c9/Halo-4-trailer.jpg/200px-Halo-4-trailer.jpg" width="200" height="111" />
					</a>
				</div>
				<p>
					<b>Mass Effect vs. Halo vs Darksiders?</b><br />Wikian <a  class="text" href="http://masseffect.wikia.com/wiki/User:James12708">James12708</a> posits a fictional battle between three different gaming universes. Who would win? And why? <a  class="text" href="http://masseffect.wikia.com/wiki/User_blog:James12708/Crazy_battle_Mass_Effect_vs_Halo_vs_Darksiders_Army_of_Heaven">Read about it now</a>, and join the conversation.<br /><br />
					<b>This week, in The Hole</b><br />
					This week’s prize fight on Nukapedia is a special Cybernetic Securitron battle between Yes Man and Victor. <a  class="text" href="http://fallout.wikia.com/wiki/User_blog:Agent_c/The_Hole_-_Cybernetic_Division_Heat_3_-_Securitron_Battle.">Vote now!</a><br /><br />And, speaking of Fallout, did you know that September 30 marks the 15th anniversary of the first game? We're rounding up ideas for celebrating. Head on over to <a  class="text" href="http://fallout.wikia.com/wiki/Fallout_Wiki">Nukapedia</a> to chime in.<br /><br />
					<b>DeadPool: The Game</b><br />
					We'll be honest - Activision's announcement of the <a  class="text" href="http://marvel.wikia.com/User_blog:Nassirdada/Deadpool_game_announced">Deadpool video game</a> for console systems surprised us. And the wiki could use some work. <a  class="text" href="http://deadpool.wikia.com/wiki/Deadpool_Wiki">Join the effort</a>, and let's whip this thing into shape!<br /><br /><b>Rusty Hearts: Reborn</b><br />The first major expansion pack just hit and the franchise is being reborn in more ways than one. Look for new character select screen, four new dungeons, and new <a  class="text" href="http://rustyhearts.wikia.com/wiki/Rusty_Hearts:_Reborn">immersive quests</a>. <br /><br />
				</p>
			</div>
		</div>
		<div class="tabbertab" title="Screenshots &amp; Media">
			<div style="padding:5px;">
				<div class="floatright">
					<a href="http://gaming.wikia.com/wiki/User_blog:JAlbor/Natural_Selection_2_Preview">
						<img alt="002e47.jpg" src="http://images3.wikia.nocookie.net/__cb20120606170945/wikiaglobal/images/thumb/8/8b/002e47.jpg/200px-002e47.jpg" width="200" height="118" />
					</a>
				</div>
				<p>
					Some pretty cool new trailers dropped on Thursday. Bethesda released an interactive trailer for Dishonored- choose one of three daring <a  class="text" href="http://dishonored.wikia.com/wiki/Dishonored_Wiki">escapes</a>. Another interactive trailer was released for the fifth installment in the Crysis series- giving you the option to control <a  class="text" href="http://crysis.wikia.com/wiki/Crysis_3">modes</a>.
					And you can get your beta on with the new Planetside 2 <a  class="text" href="http://planetside.wikia.com/wiki/Planetside_2_Wiki">trailer</a>.
				</p>
			</div>
		</div>
		<div class="tabbertab" title="Other Great Games">
			<div style="padding:5px;">
				<div class="floatright">
					<a href="http://gaming.wikia.com/wiki/Top_10_list:Favorite_Mass_Effect_Love_Interest">
						<img alt="Splinter cell blacklist action.jpg" src="http://images3.wikia.nocookie.net/__cb20120604182839/wikiaglobal/images/thumb/2/2c/Splinter_cell_blacklist_action.jpg/200px-Splinter_cell_blacklist_action.jpg" width="200" height="113" />
					</a>
				</div>
				<p>
					<a  class="text" href="http://southpark.wikia.com/wiki/South_Park:_The_Stick_of_Truth">South Park: The Stick of Truth</a> <br />
					<a  class="text" href="http://assassinscreed.wikia.com/wiki/Assassin's_Creed_III">Assassin's Creed III</a> <br />
					<a  class="text" href="http://laracroft.wikia.com/wiki/Tomb_Raider_(2013)">Tomb Raider</a> <br />
					<a  class="text" href="http://callofduty.wikia.com/wiki/Portal:Call_of_Duty:_Black_Ops_II">Call of Duty: Black Ops II</a> <br />
					<a  class="text" href="http://halo.wikia.com/wiki/Halo_4">Halo 4</a><br />
					<a  class="text" href="http://splintercell.wikia.com/wiki/Tom_Clancy%27s_Splinter_Cell:_Black_List">Splinter Cell: Black List</a><br />
					<a  class="text" href="http://borderlands.wikia.com/wiki/Borderlands_Wiki">Borderlands 2</a><br />
					<a  class="text" href="http://simcity.wikia.com/wiki/Simcity_(2013_game)">SimCity 2013</a><br />
					<a  class="text" href="http://lostplanet.wikia.com/wiki/Lost_Planet_3">Lost Planet 3</a><br />
					<a  class="text" href="http://warhammeronline.wikia.com/wiki/Warhammer_Online:_Wrath_of_Heroes">Warhammer Online: Wrath of Heroes</a> <br />
				</p>
			</div>
		</div>
	</div>
</section>