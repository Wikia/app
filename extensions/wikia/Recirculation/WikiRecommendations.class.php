<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/younger/images/5/5b/Younger_season_4_slider_%21.jpg/revision/latest?cb=20171220165416',
				'title' => 'Younger Wiki',
				'url' => 'http://younger.wikia.com/wiki/Younger_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/mindhunter/images/e/e3/30.jpg/revision/latest?cb=20171128160730',
				'title' => 'Mindhunter Wiki',
				'url' => 'http://mindhunter.wikia.com/wiki/Mindhunter_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/themarvelousmrsmaisel/images/f/f5/Marvelous_Mrs._Maisel_Slider.jpg/revision/latest?cb=20171213195427',
				'title' => 'The Marvelous Mrs. Maisel Wiki',
				'url' => 'http://themarvelousmrsmaisel.wikia.com/wiki/The_Marvelous_Mrs._Maisel_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/americancrimestory/images/c/c8/Versace_Slider.jpg/revision/latest?cb=20171219175036',
				'title' => 'American Crime Story Wiki',
				'url' => 'http://americancrimestory.wikia.com/wiki/American_Crime_Story_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tomclancy/images/4/45/Tom_clancy_jack_ryan_poster.jpg/revision/latest?cb=20171215211605',
				'title' => 'Tom Clancy Wiki',
				'url' => 'http://tomclancy.wikia.com/wiki/Tom_Clancy_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/peterrabbittvseries/images/b/bf/Nick-peter-rabbit.jpg/revision/latest?cb=20171212173921',
				'title' => 'Peter Rabbit Wiki',
				'url' => 'http://peterrabbittvseries.wikia.com/wiki/Peter_Rabbit_(TV_series)_Wiki_2013'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/3/3f/MinecraftPocketEditionSpotlight.jpg/revision/latest?cb=20171031035034',
				'title' => 'Minecraft Pocket Edition Wiki',
				'url' => 'http://minecraftpocketedition.wikia.com/wiki/Minecraft_Pocket_Edition_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/southpark/images/3/33/South-park-4.png/revision/latest?cb=20171219081431',
				'title' => 'South Park Archives',
				'url' => 'http://southpark.wikia.com/wiki/South_Park_Archives'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kcundercover/images/8/8f/KC_Undercover_season_2.png/revision/latest?cb=20160420205711',
				'title' => 'K. C. Undercover Wiki',
				'url' => 'http://kcundercover.wikia.com/wiki/K.C._Undercover_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/3/38/AvatarRP.jpg/revision/latest?cb=20171212041348',
				'title' => 'Avatar Roleplay Wiki',
				'url' => 'http://avatarrp.wikia.com/wiki/Avatar_Roleplay_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hikago/images/a/ab/Wikia-Visualization-Main%2Chikago.png/revision/20161102150806',
				'title' => 'Hikaru no Go Wiki',
				'url' => 'http://hikago.wikia.com/wiki/Hikaru_no_Go_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/theedgechronicles/images/3/3b/Descenderscropped.jpg/revision/latest?cb=20171221184206',
				'title' => 'The Edge Chronicles Wiki',
				'url' => 'http://theedgechronicles.wikia.com/wiki/Main_Page'
			]
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/babylon-berlin/images/9/9f/Header_Charlotte.png/revision/latest/scale-to-width-down/670?cb=20171129204224&path-prefix=de',
				'title' => 'Babylon Berlin Wiki',
				'url' => 'http://de.babylon-berlin.wikia.com/wiki/Babylon_Berlin_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/7/71/Big-bang-theory-spotlight.jpg/revision/latest?cb=20171221154548&path-prefix=de',
				'title' => 'Big Bang Theory Wiki',
				'url' => 'http://de.bigbangtheory.wikia.com/wiki/Big_Bang_Theory_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/bc/Greys-Anatomy-spotlight.jpg/revision/latest?cb=20171221155513&path-prefix=de',
				'title' => 'Grey\'s Antomy Wiki',
				'url' => 'http://de.greysanatomy.wikia.com/wiki/Grey%27s_Anatomy_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/scorpion/images/e/e5/Scorpion_Gang.jpg/revision/latest/scale-to-width-down/670?cb=20170706155318&path-prefix=de',
				'title' => 'Sorpion Wiki',
				'url' => 'http://de.scorpion.wikia.com/wiki/Scorpion_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-expanse/images/0/02/The_Expanse_Slider_Episoden.jpg/revision/latest/scale-to-width-down/670?cb=20171201150530&path-prefix=de',
				'title' => 'The Expanse Wiki',
				'url' => 'http://de.the-expanse.wikia.com/wiki/The_Expanse_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/5e/Akte-X-Spotlight.jpg/revision/latest?cb=20171221160355&path-prefix=de',
				'title' => 'Akte-X Wiki',
				'url' => 'http://de.akte-x.wikia.com/wiki/Akte-X_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/ba/SteamWorld-Heist-Crew-Running.png/revision/latest?cb=20180101224731&path-prefix=de',
				'title' => 'SteamWorld Wiki',
				'url' => 'http://de.steamworld.wikia.com/wiki/SteamWorld_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spellforce/images/4/4c/SpellForce_3_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20171122111342&path-prefix=de',
				'title' => 'SpellForce Wiki',
				'url' => 'http://de.spellforce.wikia.com/wiki/SpellForce_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunternews/images/0/00/Monster_Hunter_World_-_Slider.jpg/revision/latest/scale-to-width-down/670?cb=20170825122405&path-prefix=de',
				'title' => 'Monster Hunter Wiki',
				'url' => 'http://de.monsterhunter.wikia.com/wiki/Monster_Hunter_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/1/11/FR-Dark-Spotlight.jpg/revision/latest?cb=20171220105611&path-prefix=fr',
				'title' => 'Wiki Dark',
				'url' => 'http://fr.dark.wikia.com/wiki/Dark'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/2/2d/FR-MonsterHunter-Spotlight.jpg/revision/latest?cb=20171220110206&path-prefix=fr',
				'title' => 'Mogapédia',
				'url' => 'http://fr.mogapedia.wikia.com/wiki/Monster_Hunter_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/1/1e/FR-X-Files-Spotlight.jpg/revision/latest?cb=20171220105612&path-prefix=fr',
				'title' => 'Wiki X-Files',
				'url' => 'http://fr.x-files.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/ca/FR-DragonBall-Spotlight.jpg/revision/latest?cb=20171220105613&path-prefix=fr',
				'title' => 'Wiki Dragon Ball',
				'url' => 'http://fr.dragonball.wikia.com/wiki/Dragon_Ball_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/b/b7/FR-GoT-Spotlight.jpg/revision/latest?cb=20171220105612&path-prefix=fr',
				'title' => 'Wiki Game of Thrones',
				'url' => 'http://fr.gameofthrones.wikia.com/wiki/Wiki_Game_of_Thrones'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/6a/Yu-Gi-Oh%21_Spotlight_2018.png/revision/latest?cb=20171210133246',
				'title' => 'Yu-Gi-Oh! Decks',
				'url' => 'http://bit.ly/1QQOnbY'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/e/e1/Spotkindie.png/revision/latest?cb=20171211191627',
				'title' => 'KIndie',
				'url' => 'http://bit.ly/2c14ftk'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/f/f5/GamesFanonSpotlight.png/revision/latest?cb=20171223225433',
				'title' => 'Wikia Games Fanon',
				'url' => 'http://bit.ly/2lyoqBv'
			],
		],
		'pt-br' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/6/62/16569930111_2397ecbdf3_o.jpg/revision/latest?cb=20171128042327&path-prefix=pt-br',
				'title' => 'RuneScape Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-runescape'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/dccomics/images/c/c9/DC_Rebirth.png/revision/latest?cb=20161205133034&path-prefix=pt',
				'title' => 'Wiki DC Comics',
				'url' => 'http://bit.ly/fandom-ptbr-footer-dc'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/marvel/images/3/30/Universo_Marvel.png/revision/latest?cb=20170804153745&path-prefix=pt-br',
				'title' => 'Marvel Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-marvel'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/f/f9/Crisis-on-earth-x-90.jpg/revision/latest?cb=20171128043022&path-prefix=pt-br',
				'title' => 'Arrowverso Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-arrowverse'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/9/97/814586-paradise_falls.jpg/revision/latest?cb=20171128043807&path-prefix=pt-br',
				'title' => 'Fallout Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-fallout'
			]
		],
		'ru' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/8/80/Elder_Scrolls_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b5/Dark_Souls_January_17.jpg/revision/latest?cb=20171221092333',
				'title' => 'Dark Souls вики',
				'url' => 'http://ru.darksouls.wikia.com/wiki/Dark_Souls_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gravityfallsrp/images/a/a0/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%93%D0%A4%D0%A4.jpg/revision/latest?cb=20170913063608&path-prefix=ru',
				'title' => 'Гравити Фолз Фанон Вики',
				'url' => 'http://ru.gravityfallsrp.wikia.com/wiki/%D0%93%D1%80%D0%B0%D0%B2%D0%B8%D1%82%D0%B8_%D0%A4%D0%BE%D0%BB%D0%B7_%D0%A4%D0%B0%D0%BD%D0%BE%D0%BD_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/platform/images/e/e8/Logo-CSE.PNG/revision/latest?cb=20171117120531&path-prefix=uk',
				'title' => 'Енциклопедія громадянського суспільства в Україні',
				'url' => 'http://uk.prostir.wikia.com/wiki/%D0%93%D0%BE%D0%BB%D0%BE%D0%B2%D0%BD%D0%B0_%D1%81%D1%82%D0%BE%D1%80%D1%96%D0%BD%D0%BA%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elderscrollsukr/images/f/f8/%D0%94%D0%BB%D1%8F_%D0%B1%D0%B0%D0%BD%D0%B5%D1%80%D1%83.jpg/revision/latest?cb=20171123174601&path-prefix=ru',
				'title' => 'Стародавні Сувої українською',
				'url' => 'http://uk.elderscrolls.wikia.com/wiki/The_Elder_Scrolls_%D0%B2%D1%96%D0%BA%D1%96'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wikia/images/e/e1/%D0%A1%D1%83%D0%BF%D0%B5%D1%80%D0%B3%D1%91%D1%80%D0%BB._%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20171123200226&path-prefix=ru',
				'title' => 'Супергёрл Вики',
				'url' => 'http://ru.supergirl.wikia.com/wiki/%D0%A1%D1%83%D0%BF%D0%B5%D1%80%D0%B3%D1%91%D1%80%D0%BB_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/ce/Star_Wars_Ladt_Jedi.jpg/revision/latest?cb=20171125111901',
				'title' => 'Звёздные войны: Последние джедаи',
				'url' => 'http://ru.starwars.wikia.com/wiki/%D0%97%D0%B2%D1%91%D0%B7%D0%B4%D0%BD%D1%8B%D0%B5_%D0%B2%D0%BE%D0%B9%D0%BD%D1%8B._%D0%AD%D0%BF%D0%B8%D0%B7%D0%BE%D0%B4_VIII:_%D0%9F%D0%BE%D1%81%D0%BB%D0%B5%D0%B4%D0%BD%D0%B8%D0%B5_%D0%B4%D0%B6%D0%B5%D0%B4%D0%B0%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/bf/Vikings_Season_5.jpg/revision/latest?cb=20171125111902',
				'title' => 'Викинги Вики',
				'url' => 'http://ru.vikings.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%BD%D0%B3%D0%B8_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/f/fc/RE7_Not_a_Hero.jpg/revision/latest?cb=20171125111901',
				'title' => 'Resident Evil 7: Not a Hero',
				'url' => 'http://ru.residentevil.wikia.com/wiki/Resident_Evil_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/70/Riverdale_S2.jpg/revision/latest?cb=20171125111901',
				'title' => 'Riverdale вики',
				'url' => 'http://ru.riverdale.wikia.com/wiki/Riverdale_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a9/Gamboll.jpg/revision/latest?cb=20171125111900',
				'title' => 'Удивительный Мир Гамбола Вики',
				'url' => 'http://ru.theamazingworldofgumball.wikia.com/wiki/%D0%A3%D0%B4%D0%B8%D0%B2%D0%B8%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%9C%D0%B8%D1%80_%D0%93%D0%B0%D0%BC%D0%B1%D0%BE%D0%BB%D0%B0_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/9/98/Rainbow_Six.JPG/revision/latest?cb=20171125111900',
				'title' => 'Rainbow Six Вики',
				'url' => 'http://ru.rainbowsix.wikia.com/wiki/Rainbow_Six_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/16/The-lion-guard.jpg/revision/latest?cb=20171125111902',
				'title' => 'Король Лев вики',
				'url' => 'http://ru.thelionking.wikia.com/wiki/%D0%9A%D0%BE%D1%80%D0%BE%D0%BB%D1%8C_%D0%9B%D0%B5%D0%B2_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/sporerolevetion1/images/4/4b/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%802.png/revision/latest?cb=20171208171026&path-prefix=ru',
				'title' => 'Ролевые игры Spore Вики',
				'url' => 'http://ru.sporeroleplay.wikia.com/wiki/%D0%A0%D0%BE%D0%BB%D0%B5%D0%B2%D1%8B%D0%B5_%D0%B8%D0%B3%D1%80%D1%8B_Spore_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/igromania/images/4/4c/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_01-02_2018.png/revision/latest?cb=20171216183041&path-prefix=ru',
				'title' => 'ИгроВики',
				'url' => 'http://ru.igrowiki.wikia.com/wiki/%D0%98%D0%B3%D1%80%D0%BE%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/e/e5/Heroes-of-might-and-magic.jpg/revision/latest?cb=20171221093021',
				'title' => 'Меч и Магия вики',
				'url' => 'http://ru.mightandmagic.wikia.com/wiki/%D0%9C%D0%B5%D1%87_%D0%B8_%D0%9C%D0%B0%D0%B3%D0%B8%D1%8F_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/d9/Clash-of-Clans.jpg/revision/latest?cb=20171221093359',
				'title' => 'Clash of Clans Wiki',
				'url' => 'http://ru.clashofclans.wikia.com/wiki/Clash_of_Clans_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2f/Zlodei.jpg/revision/latest?cb=20171221093852',
				'title' => 'Злодеи вики',
				'url' => 'http://ru.zlodei.wikia.com/wiki/%D0%97%D0%BB%D0%BE%D0%B4%D0%B5%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b9/Heroes.jpg/revision/latest?cb=20171221094216',
				'title' => 'Герои вики',
				'url' => 'http://ru.protagonist.wikia.com/wiki/%D0%93%D0%B5%D1%80%D0%BE%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/17/Dying_light.jpg/revision/latest?cb=20171221094606',
				'title' => 'Dying Light вики',
				'url' => 'http://ru.dyinglight.wikia.com/wiki/Dying_Light:_Good_Night,_Good_Luck!_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/15/Soul_Hunters.jpg/revision/latest?cb=20171221094852',
				'title' => 'Soul Hunters Вики',
				'url' => 'http://ru.soul-hunters.wikia.com/wiki/Soul_Hunters_%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F_%D0%92%D0%B8%D0%BA%D0%B8'
			]
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepunchman/images/a/a7/Tatsumaki.png/revision/latest?cb=20171101151651&path-prefix=it',
				'title' => 'One-Punch Man Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itonepunchman'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunter/images/c/c9/MHW-Rathalos_Artwork_002.jpg/revision/latest?cb=20170613095127',
				'title' => 'Monster Hunter Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itmonsterhunter'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itmario'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/2/2a/Wikia-Visualization-Main%2Citstarwars.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142316&path-prefix=it',
				'title' => 'Jawapedia',
				'url' => 'http://bit.ly/fandom-it-footer-itstarwars'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kingdomhearts/images/b/b1/Wikia-Visualization-Main%2Ckingdomhearts.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102141406',
				'title' => 'Kingdom Hearts Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itkhwita'
			]
		],
		'pl' => [
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/a/a2/League_of_Legends_Wiki.jpg/revision/latest?cb=20170901024914&path-prefix=pl',
				'title' => 'League of Legends Wiki',
				'url' => 'http://pl.leagueoflegends.wikia.com/wiki/League_of_Legends_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/e/e1/Rayman_Wiki.jpg/revision/latest?cb=20170825174755&path-prefix=pl',
				'title' => 'Rayman Wiki',
				'url' => 'http://pl.rayman.wikia.com/wiki/Rayman_Wiki:Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/60/DC_Wiki.jpg/revision/latest?cb=20170825173855&path-prefix=pl',
				'title' => 'DC Wiki',
				'url' => 'http://pl.dc.wikia.com/wiki/DC_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/7/7f/The_Elder_Scrolls_Wiki.jpg/revision/latest?cb=20170901024627&path-prefix=pl',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://pl.elderscrolls.wikia.com/wiki/The_Elder_Scrolls_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/8/81/Slider-Z%C5%82oczy%C5%84cy_Wiki.jpg/revision/latest?cb=20170929175616',
				'title' => 'Złoczyńcy Wiki',
				'url' => 'http://pl.villains.wikia.com/wiki/Z%C5%82oczy%C5%84cy_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/3/35/Wied%C5%BAmin_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Wiedźmin Wiki',
				'url' => 'http://wiedzmin.wikia.com/wiki/Wied%C5%BAmin_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/2/2b/Warframe_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Warframe Wiki',
				'url' => 'http://pl.warframe.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/b/b3/My_Little_Pony_Wiki.jpg/revision/latest?cb=20170901030633&path-prefix=pl',
				'title' => 'My Little Pony Wiki',
				'url' => 'http://pl.mlp.wikia.com/wiki/My_Little_Pony_Przyja%C5%BA%C5%84_to_magia_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/f/fa/Naruto_Wiki.jpg/revision/latest?cb=20170901032034&path-prefix=pl',
				'title' => 'Naruto Wiki',
				'url' => 'http://pl.naruto.wikia.com/wiki/Naruto_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/ba/Gwint_Wiki.jpg/revision/latest?cb=20170901031049&path-prefix=pl',
				'title' => 'Gwint Wiki',
				'url' => 'http://gwint.wikia.com/wiki/Gwint_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/5d/Gra_o_Tron_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Gra o Tron Wiki',
				'url' => 'http://graotron.wikia.com/wiki/Gra_o_tron_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/0/0f/Pokemon_Wiki.jpg/revision/latest?cb=20170901033359&path-prefix=pl',
				'title' => 'Pokemon Wiki',
				'url' => 'http://pl.pokemon.wikia.com/wiki/Pok%C3%A9mon_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/f/fe/Need_for_Speed_Wiki.jpg/revision/latest?cb=20170901033401&path-prefix=pl',
				'title' => 'Need for Speed Wiki',
				'url' => 'http://pl.nfs.wikia.com/wiki/Need_for_Speed_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/59/Overwatch_Wiki.jpg/revision/latest?cb=20170901030239&path-prefix=pl',
				'title' => 'Overwatch Wiki',
				'url' => 'http://pl.overwatch.wikia.com/wiki/Overwatch_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/d/d7/Death_Note.jpg/revision/latest?cb=20170901032713&path-prefix=pl',
				'title' => 'Death Note Wiki',
				'url' => 'http://pl.deathnote.wikia.com/wiki/Death_Note_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/5/5e/Battlefield_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Battlefield Wiki',
				'url' => 'http://pl.battlefield.wikia.com/wiki/Battlefield_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/b1/Auta_Wiki.png/revision/latest?cb=20170901025628&path-prefix=pl',
				'title' => 'Auta Wiki',
				'url' => 'http://pl.auta.wikia.com/wiki/Auta_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/6e/Life_is_Strange_Wiki.jpg/revision/latest?cb=20170901032033&path-prefix=pl',
				'title' => 'Life is Strange Wiki',
				'url' => 'http://pl.lifeisstrange.wikia.com/wiki/Life_Is_Strange_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/unturned-polska/images/b/b6/Spotlight.jpg/revision/latest?cb=20170929203539&path-prefix=pl',
				'title' => 'Unturned Wiki',
				'url' => 'http://pl.unturned.wikia.com/wiki/Unturned_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/6/66/Spotlight_Arrowwersum_%28pa%C5%BAdziernik_2017_nowa_wersja%29.png/revision/latest?cb=20170923195223',
				'title' => 'Arrowwersum',
				'url' => 'http://arrowwersum.wikia.com/wiki/Arrowwersum'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/3/30/Fanonpedia_spotlight_listopad_2017.png/revision/latest?cb=20171008170243',
				'title' => 'Star Wars Fanonpedia',
				'url' => 'http://gwfanon.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/7/7b/ELEX_Wiki.png/revision/latest?cb=20171105202319&path-prefix=pl',
				'title' => 'ELEX Wiki',
				'url' => 'http://pl.elex.wikia.com/wiki/ELEX_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/2/27/YouTube_Wiki.jpg/revision/latest?cb=20171105210441',
				'title' => 'YouTube Wiki',
				'url' => 'http://pl.youtube.wikia.com/wiki/YouTube_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/7/74/UTfRdUj.jpg/revision/latest?cb=20171201175632&path-prefix=pl',
				'title' => 'Phoenotopia Wiki',
				'url' => 'http://pl.phoenotopia.wikia.com/wiki/Phoenotopia_Wikia'
			]
		],
		'zh' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/shironekoproject/images/5/50/Wiki-background/revision/latest?cb=20150130211808&path-prefix=zh',
				'title' => '白貓計劃Wiki',
				'url' => 'http://zh.shironekoproject.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fate-go/images/2/2f/Mainvisual.png/revision/latest?cb=20160105185037&path-prefix=zh',
				'title' => 'Fate/Grand Order Wiki',
				'url' => 'http://zh.fate-go.wikia.com/wiki/Fate/Grand_Order_%E4%B8%AD%E6%96%87_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/asoiaf/images/3/32/17966414_10154688723507734_1247624339901587946_o.jpg/revision/latest?cb=20170420224445&path-prefix=zh',
				'title' => '冰与火之歌中文维基',
				'url' => 'http://zh.asoiaf.wikia.com/wiki/%E5%86%B0%E4%B8%8E%E7%81%AB%E4%B9%8B%E6%AD%8C%E4%B8%AD%E6%96%87%E7%BB%B4%E5%9F%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/nekowiz/images/5/50/Wiki-background/revision/latest?cb=20150130231207&path-prefix=zh',
				'title' => '問答RPG 魔法使與黑貓維茲 維基',
				'url' => 'http://zh.nekowiz.wikia.com/wiki/%E5%95%8F%E7%AD%94RPG_%E9%AD%94%E6%B3%95%E4%BD%BF%E8%88%87%E9%BB%91%E8%B2%93%E7%B6%AD%E8%8C%B2_%E7%B6%AD%E5%9F%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ffexvius/images/5/50/Wiki-background/revision/latest?cb=20160912171651&path-prefix=zh',
				'title' => 'FINAL FANTASY BRAVE EXVIUS中文 Wiki',
				'url' => 'http://zh.ffexvius.wikia.com/wiki/FINAL_FANTASY_BRAVE_EXVIUS%E4%B8%AD%E6%96%87_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/4/42/Header_bf2.png/revision/latest?cb=20170824065801&path-prefix=zh-hk',
				'title' => '星戰維基',
				'url' => 'http://zh.starwars.wikia.com/wiki/%E6%98%9F%E7%90%83%E5%A4%A7%E6%88%B0%E7%99%BE%E7%A7%91%E5%85%A8%E6%9B%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hongkongbus/images/f/f2/KMB_GB9206_263.JPG/revision/latest?cb=20090802113442&path-prefix=zh',
				'title' => '香港巴士大典',
				'url' => 'http://hkbus.wikia.com/wiki/%E9%A6%96%E9%A0%81'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hunterxhunter/images/4/48/Hunterxhunter.jpg/revision/latest?cb=20170904145736&path-prefix=zh',
				'title' => '獵人Wiki',
				'url' => 'http://zh.hunterxhunter.wikia.com/wiki/%E7%8D%B5%E4%BA%BA_wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlegirl/images/8/87/Banner.png/revision/latest?cb=20170725105753&path-prefix=zh',
				'title' => '戰鬥女子學園Wiki',
				'url' => 'http://zh.battlegirl.wikia.com/wiki/%E6%88%B0%E9%AC%A5%E5%A5%B3%E5%AD%90%E5%AD%B8%E5%9C%92_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fireemblem/images/1/14/20170120044344.jpg/revision/latest?cb=20171225154833&path-prefix=zh',
				'title' => '聖火降魔錄Wiki',
				'url' => 'http://zh.fireemblem.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kirara-fantasia/images/5/5e/Header.jpg/revision/latest?cb=20171218002428&path-prefix=zh',
				'title' => 'KIRARA FANTASIA 中文Wiki',
				'url' => 'http://zh.kirara-fantasia.wikia.com/'
			],
		],
		'ja' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlefront/images/3/3b/BF2_IMG.jpg/revision/latest?cb=20170905023120&path-prefix=ja',
				'title' => 'Battlefront Wiki',
				'url' => 'http://ja.battlefront.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gameofthrones/images/7/75/GOTS7-E5-25.jpg/revision/latest/scale-to-width-down/640?cb=20170822083703&path-prefix=ja',
				'title' => 'ゲームオブスローンズ Wiki',
				'url' => 'http://ja.gameofthrones.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/6/65/Battle_of_Endor.png/revision/latest?cb=20150129051829&path-prefix=ja',
				'title' => 'ウーキーペディア',
				'url' => 'http://ja.starwars.wikia.com'
			],
		],
	];

	const STAGING_RECOMMENDATIONS = [
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/muppet/images/4/4b/Image001.png/revision/latest?cb=20170911141514',
			'title' => 'Selenium',
			'url' => 'http://selenium.wikia-staging.com',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/selenium/images/e/e2/Image009.jpg/revision/latest?cb=20170911141722',
			'title' => 'Halloween',
			'url' => 'http://halloween.wikia-staging.com',
		],
		[
			'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/selenium/images/2/2e/WallPaperHD_138.jpg/revision/latest?cb=20170911141722',
			'title' => 'Sktest123',
			'url' => 'http://sktest123.wikia-staging.com',
		]
	];

	const DEV_RECOMMENDATIONS = [
		'us' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.us/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			]
		],
		'pl' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia-dev.pl/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			]
		]
	];

	public static function getRecommendations( $contentLanguage ) {
		global $wgWikiaDatacenter, $wgWikiaEnvironment;

		if ( $wgWikiaEnvironment === WIKIA_ENV_STAGING ) {
			$recommendations = self::STAGING_RECOMMENDATIONS;
		} elseif ( $wgWikiaEnvironment === WIKIA_ENV_DEV ) {
			if ( $wgWikiaDatacenter === WIKIA_DC_POZ ) {
				$recommendations = self::DEV_RECOMMENDATIONS['pl'];
			} else {
				$recommendations = self::DEV_RECOMMENDATIONS['us'];
			}
		} else {
			$recommendations = self::RECOMMENDATIONS['en'];
			$fallbackedContentLanguage = self::fallbackToSupportedLanguages( $contentLanguage );

			if ( array_key_exists( $fallbackedContentLanguage, self::RECOMMENDATIONS ) ) {
				$recommendations = self::RECOMMENDATIONS[$fallbackedContentLanguage];
			}
			shuffle( $recommendations );
		}

		$recommendations = array_slice( $recommendations, 0, self::WIKI_RECOMMENDATIONS_LIMIT );

		$index = 1;
		foreach ( $recommendations as &$recommendation ) {
			$recommendation['thumbnailUrl'] = self::getThumbnailUrl( $recommendation['thumbnailUrl'] );
			$recommendation['index'] = $index;
			$index++;
		}

		return $recommendations;
	}

	private static function fallbackToSupportedLanguages( $language ) {
		switch ( $language ) {
			case 'pt':
				return 'pt-br';
			case 'zh-tw':
			case 'zh-hk':
				return 'zh';
			case 'be':
			case 'kk':
			case 'uk':
				return 'ru';
			default:
				return $language;
		}
	}

	private static function getThumbnailUrl( $url ) {
		try {
			return VignetteRequest::fromUrl( $url )->zoomCrop()->width( self::THUMBNAIL_WIDTH )->height(
				floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO )
			)->url();
		} catch ( Exception $exception ) {
			\Wikia\Logger\WikiaLogger::instance()->warning(
				"Invalid thumbnail url provided for explore-wikis module inside mixed content footer",
				[
					'thumbnailUrl' => $url,
					'message' => $exception->getMessage(),
				]
			);

			return '';
		}
	}
}
