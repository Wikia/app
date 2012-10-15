<?php

class ArticleServiceTest extends WikiaBaseTest {
	const TEST_CITY_ID = 79860;

	public function setUp() {
		parent::setUp();
	}

	protected function setUpMock($cacheParams = null) {
		// mock cache
		$memcParams = array(
			'set' => null,
			'get' => null,
		);
		if (is_array($cacheParams)) {
			$memcParams = $memcParams + $cacheParams;
		}
		$this->setUpMockObject('stdClass', $memcParams, false, 'wgMemc');
		$this->mockGlobalVariable('wgCityId', self::TEST_CITY_ID);
		$this->mockGlobalVariable('wgParser', F::build('Parser'));
		$this->mockApp();
	}

	protected function setUpMockObject($objectName, $objectParams = null, $needSetInstance = false, $globalVarName = null, $callOriginalConstructor = true, $globalFunc = array()) {
		$mockObject = $objectParams;
		if (is_array($objectParams)) {
			// extract params from methods
			$objectValues = array(); // $objectValues is stored in $objectParams[params]
			$methodParams = array();
			foreach ($objectParams as $key => $value) {
				if ($key == 'params' && !empty($value)) {
					$objectValues = array($value);
				} else {
					$methodParams[$key] = $value;
				}
			}
			$methods = array_keys($methodParams);

			// call original contructor or not
			if ($callOriginalConstructor) {
				$mockObject = $this->getMock($objectName, $methods, $objectValues);
			} else {
				$mockObject = $this->getMock($objectName, $methods, $objectValues, '', false);
			}

			foreach ($methodParams as $method => $value) {
				if ($value === null) {
					$mockObject->expects($this->any())
						->method($method);
				} else {
					if (is_array($value) && array_key_exists('mockExpTimes', $value) && array_key_exists('mockExpValues', $value)) {
						if ($value['mockExpValues'] == null) {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method);
						} else {
							$mockObject->expects($this->exactly($value['mockExpTimes']))
								->method($method)
								->will($this->returnValue($value['mockExpValues']));

						}
					} else {
						$mockObject->expects($this->any())
							->method($method)
							->will($this->returnValue($value));
					}
				}
			}
		}

		// mock global variable
		if (!empty($globalVarName)) {
			$this->mockGlobalVariable($globalVarName, $mockObject);
		}

		// mock global function
		if (!empty($globalFunc)) {
			$this->mockGlobalFunction($globalFunc['name'], $mockObject, $globalFunc['time']);
		}

		// set instance
		if ($needSetInstance) {
			$this->mockClass($objectName, $mockObject);
		}
	}


	/**
	 * @dataProvider getTextSnippetDataProvider
	 * @param $snippetLength maximum length of text snippet to be pulled
	 * @param $rawArticleText raw text of article to be snippeted
	 * @param $expSnippetText expected output text snippet
	 */
	public function testGetTextSnippetTest($snippetLength, $articleText, $expSnippetText) {
		$title = F::build('Title');
		$this->setUpMockObject('Article', array(
			'getContent' => $articleText,
			'getTitle' => $title,
			'getID' => sha1($articleText),
			'params' => $title
		), true, null, true);
		$this->setUpMock();

		// test
		$articleService = F::build('ArticleService');
		$snippetText = $articleService->getTextSnippet($snippetLength);
		$this->assertEquals($expSnippetText, $snippetText);
	}

	public function getTextSnippetDataProvider() {
		/**
		 * @todo: add more test sets
		 */
		return array(
			array( // article is empty
				100,
				'',
				''
			),
			array( // article is plain text
				100,
				'This is the test line',
				'This is the test line',
			),
			array( // article is very long
				100,
				'This is the test line that is very long and should be cut off at some point to avoid generating too long snippets',
				'This is the test line that is very long and should be cut off at some point to avoid generating...',
			),
			array( // example real article 1 - firemakers quest (runescape)
				100,
				'{{Quick guide}}
{{Safe quest}}
<div style="float:right; width:310px; display:table; margin-top:5px">
{| class="wikitable infobox"
|+ \'\'\'{{#if:|{{{name}}}|{{PAGENAME}} }}\'\'\' {{#if:180|<span style="font-size: 80%;">(#180)</span>}}
			{{#if:[[File:The Firemaker\'s Curse.jpg]]|
				{{!}}-
{{!}}colspan="2" align="center" {{!}} [[File:The Firemaker\'s Curse.jpg]]}}
{{#if:|
{{!}}-
!width="1%" nowrap="nowrap"{{!}}Also called?
{{!}} {{{aka}}}}}
|-
!valign="top" width="1%" nowrap="nowrap" | Release date
| {{#if:[[11 January]] [[2012]]|[[11 January]] [[2012]] {{#ifeq:[[11 January]] [[2012]]|RuneScape Classic||{{#if:The Firemaker\'s Curse|([[Update:The Firemaker\'s Curse|Update]])|(Update unknown) }}}}|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>{{Mainonly|[[Category:Needs quest release date added ]]}}}}
|-
!valign="top" nowrap="nowrap" | [[Pay-to-play|Members only]]?
| {{#if:Yes|Yes|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>}}
|-
!valign="top" nowrap="nowrap" | [[Quest series]]
| {{#if:Return of Zaros|Return of Zaros| Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>}}
|-
!valign="top" nowrap="nowrap" | Official difficulty
| {{#switch:{{lc:Master}}
|novice|intermediate|experienced|master|grandmaster|special={{ucfirst:Master}}[[Category:{{ucfirst:Master}} quests]]|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>{{Mainonly|[[Category:Needs official difficulty added]]}}}} <!-- Please do not change the difficulty level, it has been officially changed to master. !-->
|-
!valign="top" nowrap="nowrap" | Official length
| {{#if:Long|Long|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>{{Mainonly|[[Category:Needs official length added]]}}}}
|-
!valign="top" nowrap="nowrap" | Developer
| {{#if:Ana S|Ana S|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>{{Mainonly|[[Category:Needs head developer added]]}}}}
|}<span style="margin-top:-6px; font-size:xx-small; clear:right; float:right;">[[Template:Infobox Quest|[view]]] &bull; [{{fullurl:Template:Infobox Quest|action=edit}} [edit]] &bull; [[Template talk:Infobox Quest|[talk]]]</span></div>{{mainonly|[[Category:Quests|{{BASEPAGENAME}}]]}}

\'\'\'The Firemaker\'s Curse\'\'\' is a members only [[quest]] developed by Mod Ana and was the first quest to be released in [[2012]]. It is based in lore, providing new information about the downfall of [[Zaros]] and the rise of [[Zamorak]].

==Official description==
{{cquote2|Join the firemakers on their journey through a cave system, searching for The Firemakerâs Guide: a great book of secrets written by the most powerful firemaker in recorded history. Finding the book is one problem; getting out alive is another.}}

==Walkthrough==
{| align="center" class="toccolours questdetails" style="" cellspacing=3
|-
|style="width:15%; vertical-align:top" class="questdetails-header"|\'\'\'Start point:\'\'\'
|style="width:85%" class="questdetails-info"|[[File:Quest.png|17px|South of [[Eagles\' Peak (mountain)|Eagles\' Peak]] and west of the [[Tree Gnome Stronghold]].]] {{#if:South of [[Eagles\' Peak (mountain)|Eagles\' Peak]] and west of the [[Tree Gnome Stronghold]].|South of [[Eagles\' Peak (mountain)|Eagles\' Peak]] and west of the [[Tree Gnome Stronghold]].|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>}}
|-
|class="questdetails-header-alternate"|\'\'\'Members only:\'\'\'
|class="questdetails-info"|{{#if:Yes|Yes|Unknown <small>[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit]</small>}}
|-
|class="questdetails-header"|\'\'\'Official difficulty:\'\'\'
|class="questdetails-info"|{{#ifeq:Master|none|None|}}{{#ifeq:Master|Tutorial|[[File:Novice.svg|7px|Tutorial|link=]] Tutorial|}}{{#ifeq:Master|Novice|[[File:Novice.svg|7px|Novice|link=]] Novice|}}{{#ifeq:Master|Intermediate|[[File:Intermediate.svg|7px|Intermediate|link=]] Intermediate|}}{{#ifeq:Master|Experienced|[[File:Experienced.svg|7px|Experienced|link=]] Experienced}}{{#ifeq:Master|Master|[[File:Master.svg|7px|Master|link=]] Master|}}{{#ifeq:Master|Grandmaster|[[File:Grandmaster.svg|7px|Grandmaster|link=]] Grandmaster}}{{#ifeq:Master|Special|[[File:Special.svg|7px|Special|link=]] Special|}} <!-- Please do not change the difficulty level, it has been officially changed to master. !-->
|-
|class="questdetails-header-alternate"|\'\'\'Length:\'\'\'
|class="questdetails-info"|Long
|-
|style="vertical-align:top" class="questdetails-header"|\'\'\'Requirements:\'\'\'
|class="questdetails-info"|{{#if:{{Skillreq|Firemaking|74}}
{{Skillreq|Constitution|76}}
{{Skillreq|Agility|64}}
Since the skill requirements are needed to start the quest they can \'\'\'not\'\'\' be boosted.|{{Skillreq|Firemaking|74}}
{{Skillreq|Constitution|76}}
{{Skillreq|Agility|64}}
Since the skill requirements are needed to start the quest they can \'\'\'not\'\'\' be boosted.|None}}
|-
|style="vertical-align:top" class="questdetails-header-alternate"|\'\'\'Items required:\'\'\'
|class="questdetails-info"|{{#if:\'\'\'Optional:\'\'\'
*Healing method
*Weight-reducing clothing
*[[Attack speed|Fast]] Ranged weapon (such as [[Darts]] or [[Throwing knives]])|\'\'\'Optional:\'\'\'
*Healing method
*Weight-reducing clothing
*[[Attack speed|Fast]] Ranged weapon (such as [[Darts]] or [[Throwing knives]])|None}}
{{#switch:{{lc:}}|none|no|=|#default=
	{{!}}-
{{!}}style="vertical-align:top" class="questdetails-header-alternate"|\'\'\'Items recommended:\'\'\'
	|class="questdetails-info"|{{{recommended}}}}}
|-
|style="vertical-align:top" class="questdetails-header"|\'\'\'Enemies to defeat:\'\'\'
|class="questdetails-info"|{{#if:[[Char]] (level 501)|[[Char]] (level 501)|None}}
|}

=== Preparing And Gearing Up For The Quest ===
	Armour has no effect in the quest, so leave it behind to save weight and instead wear weight-reducing gear like a [[Spottier cape]] and [[Boots of lightness]]. Wearing at least one teleport-capable item is worthwhile, to allow teleporting to a bank to re-equip. An emergency teleport (one-click teleport) is not necessary as this is a safe quest.

	Have four empty slots in inventory, to hold items you get and need during the quest: for the pitch can, for the compiled journal (all individual journals found in the cave are merged into one, so only one slot is needed), and two for the fire powders (one puzzle provides three different powders, but only two are actually needed).

Use the remaining slots to hold items to help you in the quest. Although the quest is safe, the ability to heal is crucial in getting through the quest. You can take a lot of damage in several rooms, and you are always rescued when health reaches 0, instead of dying, but you still have to redo the room. Items with high healing abilities are best, such as an [[Enhanced Excalibur]], [[Saradomin brew]]s, [[Rocktail]]s. If taking Saradomin brews, [[restore potion]]s are not necessary.

	Healing familiars can also help in the final battle. Having a familiar out in the puzzle-solving rooms can make the puzzle harder to solve, as the familiar will often stand in a place where you want to move to (so that left clicking there causes you to interact with the familiar rather than moving, wasting valuable time). For most players, it is likely you will have to leave the cave several times to resupply, so one option is to bring the healing familiar only when you gear up for the final battle with Char.

A way to restore run energy may also be useful, since the final battle may require a lot of running.

For the final battle, you will also need a fast weapon. Fast ranged weapons like knives and darts are best, to be able to hit Char outside of her melee attack, although claws and the vine weapon are also possibilities for players who can take potentially a lot of damage from Char\'s melee attacks and then heal rapidly. The metal of the weapon does not matter, as damage you inflict depends instead on how many fires you have lit. One viable option is to use [[Karil\'s crossbow]], as it is almost as fast as knives but longer ranged, allowing the player to engage Char outside of her melee attack more easily.

One last preparation is to turn off [[Auto Retaliate]]. This prevents the player from automatically running near or up to Char when the player may not want to.

[[File:Phoenix chathead.png|left]]

=== Starting out ===
[[File:The_Firemakers.png|thumb|The firemakers.]]To start this quest one must travel to the starting location south of [[Eagles\' Peak (mountain)|Eagles\' Peak]], talking to [[Phoenix (The Firemaker\'s Curse)|Phoenix]].The fastest ways to achieve this would be by using the [[Spirit tree]] system at the Gnome Stronghold and running south then west to the starting location. Using the [[Gnome glider]] system and also running south and west, or using the [[Eagle transport system]] to Eagle\'s Peak and running south to the start location would also be quick. Using [[Ardougne Teleport (spell)|Ardougne Teleport]] would also be relatively quick, as a player would need to run north and west to reach the starting location. You could also use a Phoenix Lair teleport scroll. Another method would be to use the fairy ring teleport to [[Piscatoris Hunter area]] and run south.

[[File:Firemaking_Group.png|thumb|The Firemaking Group.]]
Once you arrive, talking to any of the Firemakers will begin the quest. A cutscene will ensue where you will be introduced to [[Emmett]], [[Flint (NPC)|Flint]], [[Isis]], [[Lina]], [[Phoenix (The Firemaker\'s Curse)|Phoenix]], [[Sera]], and [[Twig (NPC)|Twig]]. They will explain to you their belief of finding long lost [[Firemaking]] knowledge in the caves next to the entrance they are surrounding, that came to them in a dream. They will ask you to protect them as they go through the caves. You will agree and formally begin the quest.

Note that after starting the quest there are two identical looking cave entrances quite close to each other in the area. If you teleport out during the quest it is easy, depending on which way you come back, to go to the the wrong cave entrance and find you can not enter the cave. You need to go to the south most entrance which has the quest symbol next to it on the mini map.

=== Inside the Caves ===
[[File:TFC room 1 solution.png|thumb|First puzzle. (Room 1)]]
[[File:Cave_In!.png|thumb|Cave in!]]
Upon entering the caves you will enter a room with several red fires, [[Flint]] will give you a [[pitch can]] which allows you to create fires in front of you without logs, granting 2 experience points for each fire made. However, unlike regular fires you cannot stand on or walk over these fires. Your first order of business is to light fires so that you create an arrow out of fire pointing out of the cave, once this is done, a cutscene will occur where the characters will join you in the middle of the room, and the ground will begin to shake, and everyone will fall through the floor into the next room.

[[File:Char Chathead1.png|left]]
===Second room===
[[File:Firemakers.png|thumb|The Firemakers\' camp.]]
:\'\'Turning your lighting detail to \'low\' may help you better see the environment.\'\'
The second room will be dark, so you will have to light the logs next to you to illuminate everything. The Firemakers will lament being trapped, and scared of some monster attacking them. In the center of the room is Firemaking journal: Chapter 1, and after taking it you will have [[Firemaking journal compilation (1)]] in your inventory. After doing so, another cutscene will occur with a spirit, [[Char]], confronting you and the group and again turning off the lights, once you relight the fire you will see that [[Phoenix (The Firemaker\'s Curse)|Phoenix]] has been killed, as [[Emmett]] becomes possessed. The spirit says this is part of her game, and she will allow you to pass through to the next camp, but you must identify who she has possessed to prevent any more deaths. Now continue down the open tunnel.

===Third room===
[[File:TFC room 3 solution.png|thumb|Second puzzle view from east falling rock. (Room 3)]]
The third room contains yet more red fires, in another pattern that is in the journal. The journal contains guide images to complete the shapes as you advance through caves. Complete the pattern to trigger another event where [[Char]] will begin dropping large boulders around the room whilst dimming the lights, avoid the boulders as they fall or you will be hit for around +100 damage, and collect them and add them to the rock pile at the end of the room to create a pile you can climb on to the next exit. Char will be dimming the lights, so you have limited time to do this.

===Fourth room===
Now you will be in the fourth room and you need to light the fire to illuminate everything again. The Firemakers will rejoin you. You can grab the Firemaking journal: Chapter 2 in the middle of the room, which will turn your journal compilation into [[Firemaking journal compilation (2)]]. This will trigger another set of dialogue where you can get more information out of Char by going through various dialogue options. You can then pick a Firemaker who you think has been possessed, and tie them to a pillar. If you pick correctly, when Char next dims the lights no one will die. The first person to be possessed is \'\'\'[[Twig]]\'\'\', which he gives away by both his exhausted stance and not being cowardly anymore. Relight the fire and proceed to the next room. If you decide incorrectly Flint will be killed.

===Fifth room===
[[File:TFC room 5 solution.png|thumb|right|The solution for the third puzzle. (Room 5)]]
The fifth room contains two different coloured fires, red and yellow, arranged in the pattern of a fire, with the red on the outside layer and yellow on the inside, the room also contains [[Red powder]] and [[Yellow powder]] which will allow you to change your fire\'s colours. Start by lighting the yellow fires, and mind that the fire in the top left part needs to be lit from the square next to it to prevent getting trapped. Fill out the fire completely on both the inside and outside, the painting shown in the Firemaker\'s Journal isn\'t complete. In order to do the red fire that is very close to the wall you need to select the "light fire here" option on your fire making can.

Upon completing this puzzle, Char will summon a wall of fire. Run for the gaps in the wall so you do not take damage. After surviving two different walls of fire from \'\'\'random\'\'\' directions (could be two different directions), proceed to the next room.

===Sixth room===
(\'\'The lights dim after a short time, dealing 50-100 damage every few seconds. Lighting the fires postpones this effect.\'\')

If you come close to dying in this room, you will be rescued by the firemakers and restored to full health. If this happens, any activated pillars will remain activated, however all lit fires will be extinguished.

The sixth room is an agility-labyrinth puzzle. You need to push pillars and light fires to guide your way through. You must jump between pillars immediately after the small burst of lava has splashed or you will be hit for 50-200 damage.
# Go to the west, jumping as far as you can, light the patch there and push the pillar. It will show you that the pit to the far east can now be lit.
# Go to the east pit. Light it and push that pillar.
# Then, head towards the west pit again, but just before reaching the pit, go north and jump to the pillar that has appeared in the center. Push the pillar there.
# Go to the east to light that pit and push the pillar there.
# Go back towards the center pillar and continue to the pit to the west of that. Light it, and push the pillar. There are two large stones that come down from the ceiling if the player does not run fast enough under them.
# Push the pillar on the platform east of it. After that, you get access to the last line of fire pits. There are weak floors on some parts, so make sure you don\'t stand on any ledges that don\'t have ground below them.
# Go to the northwestern pit, light it and push the pillar, and then the way is free to go to the exit in the northeast corner of the room.

There are small cutscenes of what happens when pushing a pillar, which makes it quite clear what to do next, so following that usually helps out a lot. Note that you can be hit high amounts of damage, so be prepared to lose a lot of health.

===Seventh room===
[[File:Char Chathead2.png|left]]In the seventh room there is the Firemaking journal: chapter 3, which will turn your journal into [[Firemaking journal compilation (3)]]. After picking it up, you will have another conversation with Char, and you will again have to decide who is possessed. The second person possessed is \'\'\'[[Sera]]\'\'\' which is made clear by her failure to mention Ignatius Vulcan even once during the time in the room, and the fact that she says she has been a firemaker since she was a child, in addition to suddenly not being very irritable at all. Tie her up to the pillar, and move to the next room. If you decide incorrectly Isis will be killed.

===Eighth room===
[[File:TFC room 8 solution.png|thumb|Solution to the fourth puzzle room. (Room 8)]]
In room eight all you need is red and yellow, you just have to follow the colour and match them up, the tricky part being that on opposite sides there is the opposite colour. Here\'s what you need to do: on the red side if there is a yellow fire, lay a yellow fire next to it; the same goes for the yellow side with the red fire.

After finishing the pattern, you will be immediately accosted by a large, complete line of flame, due to Char\'s regaining strength. You must run to either side and stand against the walls in order to let the fires slip past while you hide in the small gap. Afterwards, the tunnel opens up again.

===Ninth room===
In the ninth room, you\'ll see a grid like the pattern puzzle shown to you. You must survive in the room until the bar at the top of the screen is filled. On the walls are nodes which will create temporary walls of flame that will help you survive, but prevent your own movement across them. Char will put you through a "tutorial" of sorts, demonstrating the various flames she will send at you, but since she\'s feeling a bit cruel, you can still take damage during this time.
*Red balls will drift slowly towards you and hit you for light damage if they get somewhat close
*White balls move a bit faster and will explode for moderate damage should they catch up to you.
*Orange balls can set any line they touch on fire, same as your own walls, but if you happen to be standing on the line, it\'ll hurt you when it goes up.
*Blue balls will lazily float about, creating a trail of flames that will constantly damage you if you stand on them.

All balls of flame eventually vanish if they haven\'t hit you directly, but orange and blue balls will leave behind the same type of fires that blue flames leave; orange balls leaving an "X" pattern that stretches across the entire board originating at the time they vanished, and blue balls leaving a 3x3 grid where they went out.

The balls will spawn in four waves, with each wave containing more of them at the same time than the previous one. Note that if you do die while getting past this obstacle, you will not lose your items. You will simply go back to the group of other firemakers.

The idea here is to use the flame walls you set to prevent the balls from reaching you. However, if you aren\'t fast enough, or are on the wrong side of a node when you light it up, you may accidentally trap the ball on the same side as you.

A few general tips are as follows: you should stay near the middle of the walls most of the time since the balls always spawn at four corners between the walls and the center of the room, and they will not hesitate to go off if you\'re on top of the spawn, and you do not want to be surrounded. Balls that are on top of a line when it is set off will become stuck in that wall, except for orange balls since they\'re usually the ones that set the wall down in the first place. Try to avoid the orange flame\'s walls, since they\'ll end up trapping you if you\'re at the short end of the room when they set fires, and always be aware of when the wave nears the end as the residual flames they drop when they leave spawn immediately. When you\'re hiding behind a wall, lure the balls over to one side, then create a wall perpendicular to the one you are using to block them so that when the first wall goes out, you\'ll still have something protecting you. Lastly, the balls that try to chase you will still hurt you even if they\'re behind a wall, if they get close enough.

A method of healing can be useful for this puzzle, allowing mistakes to be made without the risk of failing the puzzle and needing to restart.

If you play in fixed screen mode you will be unable to click the south walls which can make the game harder.

===Tenth room===
Room Ten is another party room where the rest of the Firemakers will rejoin you. Take the [[Firemaking journal compilation (4)]] and you will again have to decide who is possessed. The person possessed this time is \'\'\'Twig\'\'\' again.(He gives it away when he says that he was born with the name Twig but Twig is actually the nickname he gave himself which he mentions if you spoke to him before entering the cave for the first time.). If you decide incorrectly Lina will be killed.

===Eleventh room===
[[File:TFC room 11 solution.png|thumb|The solution to the fifth puzzle (11<sup>th</sup> room)]]
You may want to make your screen size smaller to make this next part easier if you are playing in full screen format.

This time, the pattern is in the shape of a torch. You won\'t need yellow at all, just complete the blue surrounding it and patch the red all around the pattern. But before you finish, take note of the fire pit nearby. Instead of throwing firewalls at you, Char dims the screen.

Immediately light the fire pit in order to avoid taking too much damage. Then take a [[burning log|torch]] from the pile, and proceed down the tunnel.

[[File:Deter_shadows.png|thumb|left|You must deter the shadows or you will take damage.]]You\'ll be forced to walk the entire way. During this time, dark tendrils will claw their way out of all sides of your screen. This is why smaller screen formats are recommended, since if you use widescreen, it will be near impossible to make out some of the tendrils against the pitch black of the area outside of the walls. You have to ward them off by left clicking them \'\'\'close to the edge of the screen\'\'\'. Failing to shake one of them off in time will result in moderate damage. Don\'t forget to keep walking while this is happening, and escape through the open door as soon as possible. Despite this option being safer, it is possible to simply walk the entire path taking hits. With a lot of food a player can survive the entire path.

===Twelfth Room===
[[File:Char Chathead.png|left]]After lighting the fire quickly, take the [[Firemaking journal compilation (5)|fifth journal.]]. The person possessed this time is \'\'\'Emmett\'\'\'. During the interviews, you\'ll notice that Emmett is suspiciously levelheaded when you talk to him, as opposed to earlier, when he lit himself on fire just by talking about flames, making it a dead giveaway. He also stops mentioning the fact that everybody keeps accusing him of being possessed. If you decide incorrectly Twig will be killed.

Char will warn you to prepare yourself, so don\'t be lazy. Head back to the surface to resupply on food, and to take a fast hitting weapon with you, like knives or claws. It doesn\'t matter what type of metal you use, since you will only require speed. Don\'t bother with armor, use weight reducing gear to conserve energy and bring a few energy potions just in case.

===Char===
[[File:Char (Monster) chathead.png|left]]
This is a \'\'\'safe\'\'\' battle, as you are expelled from the battle arena instead of dying, with Char taunting you. (If this happens, both your stats and Char\'s are restored to full, so you will have to start the fight over when you are ready.)

Take the last [[Firemaking journal compilation (6)|journal]]. In the last room you will meet [[Char (Monster)|Char]], she is standing in a somewhat lowered part in the cave. Now is the time to get some food, energy potions (about 2) and weight-reducing clothing. [[Summer pie]]s are possibly the most ideal choice in terms of food, as they heal 220 lp per pie and restore 50% run energy. Since no armour has any effect, it\'s best to be as light as possible, because the battle involves lots of running. Alternatively, the salt-water spring at [[Oo\'glog]] may be used to provide unlimited run energy for about 15-20 minutes. It is possible that the battle can take over 15 minutes.

[[File:Fighting_Char.png|thumb|300px|Fighting Char in her powered up form.]]
Your damage is calculated by how many fires have been lit using your [[Pitch can|pitch can]] multiplied by 101. For example, if you have 7 fires lit then you will hit 707 lp damage on Char. It works well to set up as many of the fires as you can in the northern end and keep her to the south in order to avoid char stamping them out, however be careful to move away before she reaches you. In addition all fires made before the fight starts will disappear once the fight has begun. Capturing a spark in one of your fires will improve accuracy but is not necessary.

When Char is at half health, fire walls, similar to those experienced in earlier chambers, will periodically appear and sweep across the room. A wall typically has 2 gaps where you can pass through to avoid damage from the the wall of fire. Also, going to the edge of the room will often avoid a wall of fire, even though it visually seems that the fire reaches to the room\'s edge. (It is not known if this is a bug, which may be removed at some time, or a deliberate feature.) If you get hit by a wall of fire, you will suffer in the region of 200-400 damage.

[[File:Char - rage_mode.png|thumb|Char in her "Rage mode"]]Occasionally, Char will glow white. During this time she will be invulnerable, and will cause heavy damage upon you should you be within melee range. You can lure her beneath the waterfalls when she is like this, although sometimes she will revert before you reach them. When she comes near the water, she will revert to her normal, vulnerable self. It is only worth luring her to the water if she begins glowing when near the water. Otherwise, it is recommended that you merely avoid trying to fight her at this point and run around the room lighting fires ready for when she becomes vulnerable again.

Ranged is one of the best methods to use in the fight, as Char will only attack with melee. Fast weapons like knives or darts are particularly good. [[Swift gloves]] can increase damage, giving a chance of throwing two knives/darts instead of one. Using long range style (especially with knives/darts) is helpful here, as it makes staying out of Char\'s melee range much easier.

Magic is not as effective as ranged, nor is Char affected by the bind effect of ancient Magic Ice spells or bind spells from the Normal Spellbook ([[Bind|bind]], [[Entangle|entangle]] or [[Snare|snare]]). The special attack of the vine whip can also be useful, as the vines it summons deal continous damage to her as long as you have fires lit.

An effective method of killing Char for those with at least level 92 [[Prayer]] is by lighting 9+ fires, luring her to the water, and using throwing knives (on rapid stance) in tandem with [[Soul Split]] to deal massive damage at a fast rate without having to worry about healing. This is notably effective at first, but requires constant attention, as Char can stamp out any fires within a certain distance of her.

Another extremely useful item to bring would be [[dragon claws]], which when used do four hits on Char which can reduce her health significantly if each hit is successful. Coupled with special restore potions it can be extremely useful throughout the fight, and since there is not really any other use for your special attack it\'s one of the best weapons to bring. A useful way to hit Char with them is to run straight at her and use the special attack and you may get off without being hit, but if you are the damage that you will do more then makes up for the little damage that you would recieve. Merely eat a shark or two after you use both special attacks and continue to run around and light fires.

You can not use your dwarf cannon for the last boss fight, as "the cave might cave in".

Summoning creatures can be used when fighting Char. A healing familiar such as a [[Unicorn stallion]] or [[Bunyip]] may be helpful, or a beast of burden such as a [[Terrorbird]] or [[War Tortoise]] to hold extra food. A Terrorbird can also replenish run energy with [[Tireless Run]] scrolls.

===Finishing===
[[File:Char_defeated.png|thumb|270px|The Firemaking group confront Char.]]

Once Char has been defeated, she laments her defeat. The firemakers, who somehow become freed, join the player, who can speak to Char again and gain some final information about Char and Zaros. Speaking to Char after this gains no more information, and the player should exit the room through the nearby tunnel. This brings the player and the firemakers to surface, at a cave entrance to the north of the one used to start the quest. Speak to any of the firemakers to end the quest and get the rewards.

==Rewards==
[[File:Firemakers_Curse_rewards.png|center]]
*2 [[Quest points]]
*80,000 Firemaking experience
*30,000 Agility experience
*76,000 Constitution experience
*[[The Book of Char]], when activated on the off-hand slot provided it is wielded, causes fiery orbs to spin around the player, simultaneously igniting any log the player walks/runs over.
*Access to two new events and a new [[Firemaker\'s costume]] in [[Balthazar Beauregard\'s Big Top Bonanza]].
*Access to [[Char\'s training cave]] that can be repeated weekly. Also, you can pick up one of the four [[fire creatures]]: [[Warming Flame]], [[Twisted Firestarter]], [[Glowing Ember]], and [[Searing Flame]] (with 91 Firemaking) flying in the room as a pet. (You can have all four pets if you walk all of them to the [[menagerie]] in your [[Player Owned House]]; \'\'This may bug any pets withdrawn, there are cases where pets withdrawn run away once dropped\'\'.)

==Music==
* [[The Firemakers\' Theme]]
* [[Charred Remains]]

==Gallery==
<gallery>
File:Firemaker\'s_curse_banner.jpg|The homepage banner.
</gallery>

==Trivia==
*A [[guaranteed content poll]] was held on the [[RuneScape forums]] to choose the personality of a female character involved in the quest. The winner was [[Sera]], a self-professed jealous rival of [[Ignatius Vulcan]], whose goal in life is to create a blaze that will trump those of Vulcan himself.
*The original Firemaking requirement for this quest was level 90, but this was lowered to 74 in the week before launch. This was announced by [[Mod Mark]] in a stickied thread in the Future Updates forum, and the January 2012 BTS was changed to reflect the new requirement. The requirement for additional rewards was raised to 91 Firemaking. Some players believe the Firemaking requirement was reduced because, at 90, only about 80,000 members (as of the quest release) would qualify for the quest, leaving the vast majority of members unable to do the quest.
*After completing the quest, the [[Adventurer\'s Log]] will say: \'I guided the firemakers through Char\'s caves and managed to recover her ancient Firemaking secrets.\'
*Examining the character Emmett yields the text "Great Scott!," which is a reference to Dr. Brown from the\'\' Back to the Future\'\' movie series, whose first name is also Emmett.
*On the \'\'RuneScape\'\' web page, the quest when released was featured with a tag line \'Can you make it out alive?\'. However, the player always makes it out alive - the quest cannot kill the player.
** In addition, Emmett and Sera will always survive, due to needing to run the new firemaking events in the circus
*Lina, one of the Firemakers, may be a reference to Lina Inverse, an anime sorceress who can manipulate fire spells.
*The Twisted Firestarter is probably a reference to lyrics of the song Firestarter by British Drum and Bass band The Prodigy., in which the lyrics are \'I am the firestarter, twisted firestarter.\'
*This quest was originally released as a Grandmaster, but was changed soon after to a Master.
*When descending the stairs of the fight against Char without a fire pitch, Flint will say that you must come and get one with a happy expression on his face, however when you\'ll talk to him, he will say to be careful with it while having an angry expression on his face.
[[Category:The Firemaker\'s Curse]]
[[Category:Wikia Game Guides quests]]',
				'The Firemaker\'s Curse is a members only quest developed by Mod Ana and was the first quest to be...',
			),
			array( // example real article 2 - Śluza grobelna - requires wgEnablePlacesExt = true
				100,
				'{{Brak zdjęć}}

<place lat="52.402013" lon="16.941776" width="300"/>

\'\'\'Śluza Grobelna\'\'\' (niem. \'\'Graben Schleuse\'\') - śluza powstała pod koniec lat 50-tych XIX wieku służąca do spiętrzania wód [[Struga Karmelitańska|Strugi Karmelitańskiej]] (do wypełniania wodą fosy) oraz odprowadzania nadmiaru wód z [[Rzeka Warta|Warty]] w boczne koryto zwane [[Zgniła Warta|Zgniłą Wartą]].

W wale głównym i przedwale znajdował się most na dwóch filarach. Grodze śluzy zabezpieczone były dwiema kaponierami.

==Linki==
*[http://www.mars.slupsk.pl/fort/tplr2.htm LEWOBRZEŻNY RDZEŃ]
[[Kategoria:Historia]]
[[Kategoria:XIX wiek]]
[[Kategoria:Fortyfikacja]]
[[Kategoria:Zabór Pruski]]
[[Kategoria:Twierdza Poznań]]
[[Kategoria:Śluzy]]
[[Kategoria:Grobla]]
[[Kategoria:Warta]]
[[Kategoria:Zgniła Warta]]',
				'Śluza Grobelna (niem. Graben Schleuse) - śluza powstała pod koniec lat 50-tych XIX wieku służąca...',
			),
			array( // example real article 3 - Flash Powder Factory
				100,
				'[[File:Flash Powder Factory.png|thumb|The interior of the Factory.]]
The \'\'\'Flash Powder Factory\'\'\', commonly abbreviated to \'\'FPF\'\', is a [[minigame]] that replaced [[Rogues\' Den (historical)|The Rogues\' Den]]. It was released on the [[13 December]] [[2011]].

After the [[Imperial Guard]] took notice of the old Rogues\' Den, [[Brian O\'Richard]] shut down his maze and opened the doors to his Flash Powder Factory instead. Inside players can operate the factory, while dodging obstacles and the sneaky fingers of other players.

[[Agility]], [[Thieving]] and [[Herblore]] [[experience]] can be gained from the Factory, and pieces of the old Rogues\' Den rewards can also be found lying around.

			All games at the factory take place on an [[instanced shard world]] - accessible from any server but actually taking place on another server.
==Location==
[[File:Roguesden.png|thumb|The location of the Rogue\'s Den]]
The Flash Powder Factory can be found inside the [[Rogues\' Den (location)|Rogues\' Den]], which is below the [[Toad and Chicken]] [[Bar (location)|bar]] in [[Burthorpe]].

Games are initiated by speaking to [[Brian O\'Richard]]. Players are teleported to an instanced shard world, similar to [[Clan Citadels]].

==Requirements==
*75 {{Skill clickpic|Thieving}}
*75 {{Skill clickpic|Agility}}
*50 {{Skill clickpic|Herblore}}
*Stat boosting items \'\'\'CANNOT\'\'\' be used to gain access to the factory.
*{{Skill clickpic|Summoning}} Players \'\'\'CANNOT\'\'\' enter the factory with a familiar or pet. {{Skill clickpic|Summoning}}
*[[File:Skull.PNG|left|A skull]] Players \'\'\'CANNOT\'\'\' enter the factory while skulled. [[File:Skull.PNG|A skull]]

==Playing the game==
[[File:Flash powder arena map.png|thumb|The arena map]]
[[File:Flash powder factory map with key.png|thumb|A guide to machine and obstacle locations, with key (click to enlarge).]]
The aim of the game is to make flash powder. The first step is to collect the two reagents known simply as "[[Full pressure flask (a)|A]]" and "[[Full pressure flask (b)|B]]". These can be obtained from the reagent machines A and B, marked with blue and orange arrows on the minimap, respectively. These can also be located by checking the map where the world map icon usually appears. Each game takes 15 minutes, wearing a [[Factory top]] or [[Rogue top]] will grant you an extra 2 minutes per game.

[[File:Flash powder factory - door and button.png|thumb|A blue call button that can be pressed to open the adjacent locked pressure door]]
To navigate the map, players must pass agility obstacles that separate each room. Some corridors, namely the diagonals and the ones coming from the centre room, also have \'pressure doors\' at each end of them, which are sometimes locked, making navigation more difficult. Doors will lock or unlock when catalyst is taken from a machine in a room that it is joined to. Some doors may be opened by operating the nearby \'\'call buttons\'\' when they are blue - if the button is red it cannot yet be opened. If a player is trapped in a corridor by two locked doors, they have a few seconds to step through one of the doors before they get teleported to a random corner of the arena.

			Once both the reagents have been obtained, they must be taken with [[catalytic powder]] to one of the four mixer machines, marked by the dark red arrows on the map, to make the flash powder and gain points. Players start with 6 catalytic powder, although more can be collected from the catalyst machine in the centre of the arena.

			You will gain a minimum of 100 points for each flash powder made. Additional points can be obtained when making powder by having a bonus, provided by certain factors:
*Charge - charge can be obtained through an active charge machine, marked with an electricity bolt on the map. The machine will give a 10% bonus for 100 seconds. As a result of two active machines the maximum bonus is 20%.
*Apparatus - determined by the number of [[refining apparatus]] in the inventory, a maximum of 6 can be held at one time for 15% bonus when making flash powder. Players will have three of these at the start of the game; more may be obtained by pickpocketing other players in the arena, but they may also be lost to other players who are pickpocketing. The number of apparatuses each player has will be displayed as a number of green bars above their head. It is not possible to pickpocket a player immediately after they have pickpocketed you, nor can you pickpocket one twice in a row. There is a slight delay in the ability to pickpocket if an attempt to do so fails. It is advised to click quickly to either escape pickpocketing or to pickpocket the other player before they can pickpocket you. A good way to get pickpocket victims is to click on a player immediately after they cross an obstacle. There is no period of immunity in the beginning of a game, so players can pickpocket or be pickpocketed immediately after spawning in the factory. Since pickpocketing only gives a small bonus, it is generally better to focus more on getting to the correct machines.
*Residue - increases by 1% for every flash powder made.
*[[Factory outfit]] - Wearing the full set gives an extra 10% bonus if the bonus by the above means is equivalent to a score of 120 or more when making the flash powder.<ref>http://www.webcitation.org/63wBosK2C Update FAQ</ref>
Note that the bonus stacks additively - the individual bonuses will be added together to form the actual bonus.

==Rubble==
[[File:Fallen rubble.png|thumb|Fallen rubble]]
While traversing through obstacles you may come across [[Fallen rubble]] (it is hard to see, looks like several little rocks on the ground). Searching these can yield pieces of [[Rogue armour]], [[catalytic powder]], [[Refining apparatus|sets of apparatus]] or flash powder (valued at 105 points for an \'\'average batch\'\'; 121 points for a \'\'very nice batch\'\'). It is also possible to find nothing at all. It is assumed receiving a piece of Rogue Armour is considerably rare.
*Players who already have full [[Rogue armour]] can still obtain extra Rogue equipment in the rubble.
*Rubble does not appear on the mini map
			*Rubble only appears around the Reagent (A) (blue arrow machines) and Mixers (red arrow machines)
*Other people can see the rubble, and it is possible for more than one person to search it if they are quick enough.
*"The helmet reduces the chance of finding nothing in rubble by 15%, spreading that 15% around the other outcomes" <ref>http://www.webcitation.org/63wBosK2C Update FAQ</ref>


==Strategy==
*The 20% charge bonus is worth more than one or two more apparatus, try and make sure you always have 20% when going to a mixer.
*Stick to the outside where possible, as you won\'t get stuck behind locked doors (there aren\'t any around the outside) and it will take you past the charge machines, and also past more rubble spots.
*Yellow arrows (Reagent machine (B)) are harder to get than the blue arrows (Reagent machine (A)) due to the doors, so if you are at a fork and the way to the yellow arrow is clear, take that one and come back around for the blue one.
*Pickpocketing can be a time waster, but if someone is standing still, or they are  charging, it can be very quick to pickpocket them as you go past. Also the faster you move, the harder you will be to catch in return.
*If you do go through the middle, you\'ll often find the direct route through is blocked. Rather than wait, use one of the side doors that will always be open, it\'ll only be one extra obstacle.
*There are always two open doors around the catalyst machine in the middle. The open doors cycle in a clockwise direction once every 21 seconds.
*The quickest way to leave is to abandon (drop) a piece of equipment.

==Experience Rates==
			On initial release, The Flash Powder Factory awarded very good agility experience per hour when played efficiently. Player could leave without penalty after collecting 500 Brianpoints, meaning games could be finished in as little as 5â6 minutes. This would yield 80k+ experience per hour in [[Agility]].

However, with the addition of penalties for leaving early on [[11 January]] [[2012]], the rate at which reward points could be obtained was reduced, meaning [[Agility]] experience possible was reduced to about 50k experience per hour.

==Rewards==
			Within the factory, the player will earn points referred to as Brianpoints. These are used to determine your score by counting points before 500 as .2 reward each, and points after as .05 reward each. The total score is rounded down. So, for example, 615 score turns into 500*.2 + 115*.05 = 105.75, rounded down to 105. This means, for maximum efficiency, you should leave when your score is about to reach 500. The rewards points seemed to be capped at 155, which corresponds to a score of 1200 Brianpoints. Players can earn more than 1200 Brianpoints in the factory, but they will not grant any more reward points.

If you take longer than 11 minutes to finish a round, you will get an extra 20 Brianpoints on completion. Normally this is when your time remaining says 4 minutes or less, but if you wear a [[Rogue top]] or [[Factory body]] and get the extra two minutes, a time of 6 minutes or less remaining will result in the extra points. A round can normally be completed in 6â7 minutes, so waiting for this bonus is not recommended.

			An update on [[11 January]] [[2012]] added a limitation that players would incur a penalty for leaving more than two minutes before the end of the game. This penalty is set at 50% for 9 minutes or more on the timer. This penalty was intended to be reduced as the time left approaches the 2 minute mark, but a bug means that it in fact increases.

			The following table shows reward points gained \'\'without\'\' points for time remaining:
{| class="wikitable"
!Game Score
!Reward Points (Brian Points)
|-
|100
|20
|-
|200
|40
|-
|300
|60
|-
|400
|80
|-
|500
|100
|-
|600
|
105
|-
|
800
|134
|-
|1200
|155
|}

These points can be used to buy rewards from [[Brian O\'Richard]]. The rewards that can be bought are as follows.
*Thieving experience - 120 xp per reward point (in 10, 100, 1k and 10k lots - there is no bonus for trading in the higher amounts)
*Agility experience - 95 xp per reward point (in 10, 100, 1k and 10k lots - there is no bonus for trading in the higher amounts)
*[[Factory outfit]].
**[[Factory mask]] - 2250 points - increases the chance of finding items in [[Fallen rubble]].
**[[Factory top]] - 3500 points - gives an extra 2 minutes in the game.
**[[Factory trousers]] - 2750 points - gives an extra 3 [[Catalytic powder]] on entering the game.
**[[Factory gloves]] - 1750 points - increase the chance of successfully pickpocketing by 10%.
**[[Factory boots]] - 1750 points - reduce the failure rate on obstacles.
*[[Multitool]] - 35 points
*Wearing 3 out of the 5 Factory set pieces gives a 1/10 chance to make 4 dose potions instead of 3. This effect even works with untradeable potions, such as Extreme potions. It does not, however, work with Overloads, Super Prayer, or Super Antifire potions.
*Wearing the full Factory set gives experience for making unfinished potions, equal to the amount of cleaning the herb used.

To check your Brianpoints you can use the Quick Chat shortcut:
<Enter>,<Enter>,np,<Page Down>,<Enter>
Once you\'ve said it once you can just use F11 to repeat. You cannot navigate to this via the Quick Chat menus, as there isn\'t an item for this mini-game yet.

==Trivia==
[[File:Flash powder factory connection lost.png|thumb|The messages given on logging in after losing connection while attempting to access the factory.]]
*On the day of release players received the message "The instance you tried to join is full. Please try back later." This was due to a bug limiting the number of instances and the huge volume of players trying to access the minigame. Players on foreign servers did not have this problem.
*Brian O\'Richard opened this factory, here is a quote of what he said: "Depressed. My wonderful Roguesâ Den is full of cooks rather than thieves, using the everlasting fire to burn lobsters. It is hardly the purpose I had in mind for my wonderous cavern." (From Runescape "Behind the Scenes December" News)
[[File:50 herblore.png|thumb]]
*When a player received 50 Herblore and looked at the flashing icon in Stats menu, it would say \'You now have the Agility level required to attempt the Flash Factory\'. This bug has since been fixed.

==Gallery==
<gallery>
	Machine - flash powder factory.jpg|Concept art of machines from the factory.
	Flash Powder Factory SI 1.jpg|Update hint for the factory.
	Flash Powder Factory twitter hint.jpg|Another update hint for the factory.
</gallery>

{{Reflist}}
{{Minigames}}
[[Category:Minigames]]',
				'The Flash Powder Factory, commonly abbreviated to FPF, is a minigame that replaced The Rogues\'...',
			)

		);
	}


}
