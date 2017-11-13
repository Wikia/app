<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
				'title' => 'Game of Thrones',
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/scandal/images/b/ba/2015-01-30-olivia.jpg/revision/latest?cb=20170920200526',
				'title' => 'Scandal Wiki',
				'url' => 'http://scandal.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/playerunknowns-battlegrounds/images/d/d4/Visual_main.jpg/revision/latest?cb=20170920200754',
				'title' => 'Playerunknown\'s Battlegrounds Wiki',
				'url' => 'http://pubg.wikia.com/wiki/Playerunknown%27s_Battlegrounds_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/orville/images/1/1b/Orville_group_build_ss12_hires2H2017.jpg/revision/latest?cb=20170920201142',
				'title' => 'The Orville Wiki',
				'url' => 'http://orville.wikia.com/wiki/The_Orville_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wolfenstein/images/0/0b/Wolfenstein_2_large.jpg/revision/latest?cb=20170922004722',
				'title' => 'Wolfenstein Wiki',
				'url' => 'http://wolfenstein.wikia.com/wiki/Wolfenstein_II:_The_New_Colossus'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bladerunner/images/7/78/Blaster.jpg/revision/latest?cb=20131113232731',
				'title' => 'Blade Runner Wiki',
				'url' => 'http://bladerunner.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/riverdalearchie/images/d/d0/Promotional_Image_Season_1_Episode_6_Faster%2C_Pussycats%21_Kill%21_Kill%21_1.jpg/revision/latest?cb=20170217212807',
				'title' => 'Riverdale Wiki',
				'url' => 'http://riverdale.wikia.com/wiki/Riverdale_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/shadowverse/images/e/ed/Arisa3.jpg/revision/latest?cb=20170103122026',
				'title' => 'Shadowverse Wiki',
				'url' => 'http://shadowverse.wikia.com/wiki/Shadowverse_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/future-man/images/b/bc/Future_Man_Pilot-20160403-BH_-405rt.jpg/revision/latest?cb=20171019032239',
				'title' => 'Future Man Wiki',
				'url' => 'http://future-man.wikia.com/wiki/Future_Man_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/playerunknowns-battlegrounds/images/d/d4/Visual_main.jpg/revision/latest?cb=20170920200754',
				'title' => 'Playerunknown\'s Battlegrounds Wiki',
				'url' => 'http://pubg.wikia.com/wiki/Playerunknown%27s_Battlegrounds_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/mario/images/0/09/Lake_Kingdom.jpeg/revision/latest?cb=20171014165601',
				'title' => 'Mario Wiki',
				'url' => 'http://mario.wikia.com/wiki/Super_Mario_Odyssey'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/disney/images/f/f7/Coco_Miguel_Hector_pose.jpg/revision/latest?cb=20170913033715',
				'title' => 'Disney Wiki',
				'url' => 'http://disney.wikia.com/wiki/The_Disney_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/nfs/images/8/8b/NFSPB_StreetLeague_Article.jpg/revision/latest?cb=20171019171520&path-prefix=en',
				'title' => 'Need for Speed Wiki',
				'url' => 'http://nfs.wikia.com/wiki/Need_for_Speed_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/merrystartest/images/1/10/SoulflySpotlight.jpg/revision/latest?cb=20171031021310',
				'title' => 'Soulfly Wiki',
				'url' => 'http://soulfly.wikia.com/wiki/Soulfly_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vsbattles/images/2/25/VS_Battles_Advertisement_Image.png/revision/latest?cb=20170419084545',
				'title' => 'VS Battles Wiki',
				'url' => 'http://vsbattles.wikia.com/wiki/VS_Battles_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ben10/images/6/6b/Ben_10_Reboot_showcard.png/revision/latest?cb=20170922030135',
				'title' => 'Ben 10 Fan Fiction Wiki',
				'url' => 'http://ben10fanfiction.wikia.com/wiki/Ben_10_Fan_Fiction'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/harry-styles8955/images/f/f3/Hs_shoot_3.jpg/revision/latest?cb=20170417115427',
				'title' => 'Harry Styles Wiki',
				'url' => 'http://harry-styles.wikia.com/wiki/Harry_Styles_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/community-plaza/images/a/a6/Nihon_Fanon_Spotlight_Banner.png/revision/latest?cb=20170401201906',
				'title' => 'Nihon Fanon Wiki',
				'url' => 'http://nihon-fanon.wikia.com/wiki/Nihon_Fanon_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/chicago-franchise/images/d/dd/OneChicago5.jpg/revision/latest?cb=20171030043116',
				'title' => 'Chicago Franchise Wiki',
				'url' => 'http://chicago-franchise.wikia.com/wiki/Chicago_Franchise_Wikia'
			]
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/38/Bleach_Spotlight_09_2017.jpg/revision/latest?cb=20170925170441&path-prefix=de',
				'title' => 'Bleach Wiki',
				'url' => 'http://de.bleach.wikia.com/wiki/BleachWiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/3f/Code_Geass_Spotlight.jpg/revision/latest?cb=20171027130828&path-prefix=de',
				'title' => 'Code Geass Wiki',
				'url' => 'http://de.codegeass.wikia.com/wiki/Code_Geass_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/4/49/Justice_League_Spotlight.jpg/revision/latest?cb=20171027132236&path-prefix=de',
				'title' => 'DC Extended Universe Wiki',
				'url' => 'http://de.dc-extended-universe.wikia.com/wiki/DC_Extended_Universe_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/9a/Thor_Ragnarok_Spotlight.jpg/revision/latest?cb=20171027132624&path-prefix=de',
				'title' => 'Marvel-Filme Wiki',
				'url' => 'http://de.marvel-filme.wikia.com/wiki/Marvel-Filme'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/84/In_aller_Freundschaft_Spotlight.jpg/revision/latest?cb=20171027132851&path-prefix=de',
				'title' => 'In aller Freundschaft Wiki',
				'url' => 'http://in-aller-freundschaft.wikia.com/wiki/In_aller_Freundschaft_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/83/Handmaid%27s_Tale_Spotlight.jpg/revision/latest?cb=20171027134245&path-prefix=de',
				'title' => 'The Handmaid\'s Tale Wiki',
				'url' => 'http://de.the-handmaids-tale.wikia.com/wiki/The_Handmaid%27s_Tale_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/55/The_Tick_Spotlight.png/revision/latest?cb=20171027140250&path-prefix=de',
				'title' => 'The Tick Wiki',
				'url' => 'http://de.the-tick.wikia.com/wiki/The_Tick_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/02/The_Walking_Dead_09_2017.jpg/revision/latest?cb=20170925164816&path-prefix=de',
				'title' => 'The Walking Dead Wiki',
				'url' => 'http://de.thewalkingdeadtv.wikia.com/wiki/The_Walking_Dead_(TV)_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/db/Subnautica_Spotlight.jpg/revision/latest?cb=20171023143728&path-prefix=de',
				'title' => 'Subnautica Wiki',
				'url' => 'http://de.subnautica.wikia.com/wiki/Subnautica_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b7/Call_of_Duty_WW2_Spotlight.jpg/revision/latest?cb=20171023144931&path-prefix=de',
				'title' => 'Call of Duty Wiki',
				'url' => 'http://de.call-of-duty.wikia.com/wiki/Call_of_Duty_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/04/SPFBW_Preview_9_screen_PR_08092017_1504860142.jpg/revision/latest?cb=20170926093440&path-prefix=de',
				'title' => 'South Park Wiki',
				'url' => 'http://de.southpark.wikia.com/wiki/South_Park_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/7/7f/Destiny_Spotlight.jpg/revision/latest?cb=20170831122028&path-prefix=de',
				'title' => 'Destinypedia',
				'url' => 'http://de.destiny.wikia.com/wiki/Destiny_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/a/a4/Assassins_Creed_Spotlight_10_2017.jpeg/revision/latest?cb=20170926085922&path-prefix=de',
				'title' => 'Assassin\'s Creed Wiki',
				'url' => 'http://de.assassinscreed.wikia.com/wiki/Assassin\'s_Creed_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/7/77/Spotlight_Sonic_Forces.jpg/revision/latest?cb=20171023145505&path-prefix=de',
				'title' => 'Sonic Wiki',
				'url' => 'http://de.sonic.wikia.com/wiki/SonicWiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/08/Super_Mario_Spotlight_10_2017.png/revision/latest?cb=20170926091035&path-prefix=de',
				'title' => 'Mario Wiki',
				'url' => 'http://de.mario.wikia.com/wiki/MarioWiki:Hauptseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/35/Horizon_Zero_Dawn_Frozen_Wilds_Spotlight.jpg/revision/latest?cb=20171027123012&path-prefix=de',
				'title' => 'Horizon Zero Dawn Wiki',
				'url' => 'http://de.horizonzerodawn.wikia.com/wiki/Horizon_Zero_Dawn_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/9a/LA_Noire_Spotlight.png/revision/latest?cb=20171027124508&path-prefix=de',
				'title' => 'L.A. Noire Wiki',
				'url' => 'http://de.lanoire.wikia.com/wiki/L.A._Noire_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/ca/Sims_4_Hunde_und_Katzen_Spotlight.jpg/revision/latest?cb=20171027125603&path-prefix=de',
				'title' => 'Die Sims Wiki',
				'url' => 'http://de.sims.wikia.com/wiki/Sims-Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/e/ec/Battlefront_II_Spotlight.jpg/revision/latest?cb=20171027125935&path-prefix=de',
				'title' => 'Battlefront Wiki',
				'url' => 'http://de.battlefront.wikia.com/wiki/Star_Wars_Battlefront_Wiki'
			],
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/9/9f/StrangerThings-Spotlight.jpg/revision/latest?cb=20171002100552&path-prefix=fr',
				'title' => 'Wiki Stranger Things',
				'url' => 'http://fr.strangerthings.wikia.com/wiki/Wiki_Stranger_Things'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/0/05/FR-Kirby-Spotlight.jpg/revision/latest?cb=20171026120608&path-prefix=fr',
				'title' => 'Wiki Kirby',
				'url' => 'http://fr.kirby.wikia.com/wiki/Kirby_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/c9/FR-Thor-Spotlight.jpg/revision/latest?cb=20171026120919&path-prefix=fr',
				'title' => 'Wiki Univers Cinématographique Marvel',
				'url' => 'http://fr.universcinematographiquemarvel.wikia.com/wiki/Wikia_Marvel_Studios'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/02/The_Walking_Dead_09_2017.jpg/revision/latest?cb=20170925164816&path-prefix=de',
				'title' => 'Wiki The Walking Dead',
				'url' => 'http://fr.thewalkingdead.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/b/b7/Call_of_Duty_WW2_Spotlight.jpg/revision/latest?cb=20171023144931&path-prefix=de',
				'title' => 'Wiki Call of Duty',
				'url' => 'http://fr.callofduty.wikia.com/wiki/Wiki_Call_of_Duty'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/7/71/FR-JusticeLeague-Spotlight.jpg/revision/latest?cb=20171026121549&path-prefix=fr',
				'title' => 'Wiki Univers Cinématographique DC',
				'url' => 'http://fr.lunivers-cinematique-dc.wikia.com/wiki/Wikia_L%27univers_cin%C3%A9matique_DC'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/5/52/FR-VictorDixen-Spotlight.jpg/revision/latest?cb=20171026122207&path-prefix=fr',
				'title' => 'Wiki Victor Dixen',
				'url' => 'http://fr.victor-dixen.wikia.com/wiki/Wiki_Victor_Dixen'
			],
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/2/2a/Stranger_Things_Spotlight.jpg/revision/latest?cb=20171001162326',
				'title' => 'Stranger Things',
				'url' => 'http://bit.ly/2zRcdgY'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/a/a0/Spotlight_%28Super_Mario%29.jpeg/revision/latest?cb=20171001050319',
				'title' => 'Super Mario Wiki',
				'url' => 'http://bit.ly/2A1CEBc'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/1/11/SonicWikiSpotlight5.png/revision/latest?cb=20171002042635',
				'title' => 'Sonic Wiki',
				'url' => 'http://bit.ly/2aAS6cH'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/0/05/YokaiWatchSpot.jpg/revision/latest?cb=20171024124505',
				'title' => 'Yo-kai Watch Wiki',
				'url' => 'http://bit.ly/2A1lfsF'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/4/4f/Disney_Wiki_spotlight.jpg/revision/latest?cb=20171022015756',
				'title' => 'Disney Wiki',
				'url' => 'http://bit.ly/2hrpi9W'
			]
		],
		'pt-br' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ben10/images/e/e3/UB10Banner2017.2.png/revision/latest?cb=20170603173907&path-prefix=pt',
				'title' => 'Universo Ben 10',
				'url' => 'http://bit.ly/fandom-ptbr-footer-ben10'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/stevenuniverso/images/f/f0/Bismuth_-_Vinheta_de_Intervalo_%2811%29.png/revision/latest?cb=20160829164105&path-prefix=pt-br',
				'title' => 'Steven Universo Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-stevenuniverse'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/c/cf/DarthVader-SWG4.png/revision/latest?cb=20161110020121',
				'title' => 'Star Wars Wiki em Português',
				'url' => 'http://bit.ly/fandom-ptbr-footer-starwars'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fusionfallheros/images/9/9c/FusionFall_wallpaper.png/revision/latest?cb=20160701002948&path-prefix=pt-br',
				'title' => 'FusionFall Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-fusionfall'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/1/16/CJ_Shadowhunter_Chronicles.jpg/revision/latest?cb=20170902053800&path-prefix=pt-br',
				'title' => 'Wikia Shadowhunters BR',
				'url' => 'http://bit.ly/fandom-ptbr-footer-shadowhunters'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepiece/images/0/0e/Community-header-background/revision/20170827045814?path-prefix=pt',
				'title' => 'One Piece Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-onepiece'
			]
		],
		'ru' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/8/80/Elder_Scrolls_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b1/Warframe_11_17.jpg/revision/latest?cb=20171029100936',
				'title' => 'Warframe вики',
				'url' => 'http://ru.warframe.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a6/Fallout_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/corpseparty/images/c/ce/BannerCP.jpg/revision/latest?cb=20170911163728&path-prefix=ru',
				'title' => 'Вечеринка мёртвых вики',
				'url' => 'http://ru.corpseparty.wikia.com/wiki/%D0%92%D0%B5%D1%87%D0%B5%D1%80%D0%B8%D0%BD%D0%BA%D0%B0_%D0%BC%D1%91%D1%80%D1%82%D0%B2%D1%8B%D1%85_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/character-power/images/9/9c/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20170911173525&path-prefix=ru',
				'title' => 'Characters Power',
				'url' => 'http://ru.characters-power.wikia.com/wiki/Characters_Power_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/swfanon/images/1/10/Banner_2.1.jpg/revision/latest?cb=20170912095652&path-prefix=ru',
				'title' => 'Star Wars Фанон',
				'url' => 'http://ru.swfanon.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bubbleverse/images/b/ba/New_banner.jpg/revision/latest?cb=20170913071840&path-prefix=ru',
				'title' => 'Бубвики',
				'url' => 'http://ru.bubbleverse.wikia.com/wiki/%D0%91%D1%83%D0%B1%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/mlp/images/0/01/Mane_6_Stained_glass_banner.png/revision/latest?cb=20170914164203&path-prefix=ru',
				'title' => 'Дружба – это Чудо Вики',
				'url' => 'http://ru.mlp.wikia.com/wiki/My_Little_Pony:_%D0%94%D1%80%D1%83%D0%B6%D0%B1%D0%B0_%E2%80%93_%D1%8D%D1%82%D0%BE_%D0%A7%D1%83%D0%B4%D0%BE_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pern/images/a/a8/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80-04.png/revision/latest?cb=20170915201358&path-prefix=ru',
				'title' => 'Перн Вики',
				'url' => 'http://ru.pern.wikia.com/wiki/Pern_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/wikies/images/f/f2/Banner_WiWiki.jpg/revision/latest?cb=20170916183244&path-prefix=ru',
				'title' => 'Викии Вики',
				'url' => 'http://ru.wikies.wikia.com/wiki/%D0%92%D0%B5%D1%81%D1%8C_%D0%A4%D0%AD%D0%9D%D0%94%D0%9E%D0%9C_%D0%B2_%D0%BE%D0%B4%D0%BD%D0%BE%D0%BC_%D1%84%D1%8D%D0%BD%D0%B4%D0%BE%D0%BC%D0%B5'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/warriors-cats/images/e/e1/%D0%A1%D0%B0%D0%BC%D0%B0%D1%8F_%D1%82%D1%91%D0%BC%D0%BD%D0%B0%D1%8F_%D0%BD%D0%BE%D1%87%D1%8C_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20170917195623&path-prefix=ru',
				'title' => 'Коты-воители вики',
				'url' => 'http://ru.warriors-cats.wikia.com/wiki/%D0%9A%D0%BE%D1%82%D1%8B-%D0%B2%D0%BE%D0%B8%D1%82%D0%B5%D0%BB%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/73/Once_upon_a_time_s7.jpg/revision/latest?cb=20170924101723',
				'title' => 'Once Upon a Time Wiki',
				'url' => 'http://ru.once-upon-a-time.wikia.com/wiki/Once_Upon_a_Time_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/4b/Arrow_s6.jpg/revision/latest?cb=20170924102412',
				'title' => 'Arrowverse',
				'url' => 'http://ru.arrowverse.wikia.com/wiki/Arrowverse_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/c0/Supernatural-season-13.jpg/revision/latest?cb=20170924102852',
				'title' => 'Сверхъестественное',
				'url' => 'http://ru.supernatural.wikia.com/wiki/%D0%A1%D0%B2%D0%B5%D1%80%D1%85%D1%8A%D0%B5%D1%81%D1%82%D0%B5%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/07/Walking-dead-season-8.jpg/revision/latest?cb=20170924103226',
				'title' => 'Ходячие мертвецы вики',
				'url' => 'http://ru.walkingdead.wikia.com/wiki/%D0%A5%D0%BE%D0%B4%D1%8F%D1%87%D0%B8%D0%B5_%D0%BC%D0%B5%D1%80%D1%82%D0%B2%D0%B5%D1%86%D1%8B_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6e/MiddleEarth_Shadowwar.jpg/revision/latest?cb=20170924103859',
				'title' => 'Средиземье: Тени войны',
				'url' => 'http://ru.shadowofmordor.wikia.com/wiki/%D0%A1%D1%80%D0%B5%D0%B4%D0%B8%D0%B7%D0%B5%D0%BC%D1%8C%D0%B5:_%D0%A2%D0%B5%D0%BD%D0%B8_%D0%B2%D0%BE%D0%B9%D0%BD%D1%8B'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/izumgorod/images/b/b5/Izumgorod_banner2.jpg/revision/latest?cb=20170921084949&path-prefix=ru',
				'title' => 'Изумрудный город вики',
				'url' => 'http://ru.izumgorod.wikia.com/wiki/%D0%98%D0%B7%D1%83%D0%BC%D1%80%D1%83%D0%B4%D0%BD%D1%8B%D0%B9_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/48/%D0%A2%D0%BE%D1%80_3_11_17.jpg/revision/latest?cb=20171029100935',
				'title' => 'Тор: Рагнарёк',
				'url' => 'http://ru.marvel.wikia.com/wiki/%D0%A2%D0%BE%D1%80:_%D0%A0%D0%B0%D0%B3%D0%BD%D0%B0%D1%80%D1%91%D0%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/7/7e/Shameless_11_17.jpg/revision/latest?cb=20171029100934',
				'title' => 'Shameless Wiki',
				'url' => 'http://ru.shameless.wikia.com/wiki/Shameless_US_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/af/Elex_11_17.jpg/revision/latest?cb=20171029100934',
				'title' => 'Elex wiki',
				'url' => 'http://ru.elex.wikia.com/wiki/Welcome'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/0f/Wolfenstain_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Wolfenstein Wiki',
				'url' => 'http://ru.wolfenstein.wikia.com/wiki/Wolfenstein_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/e/e5/Assassins_Creed_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Assassin\'s Creed: Истоки',
				'url' => 'http://ru.assassinscreed.wikia.com/wiki/Assassin%27s_Creed:_%D0%98%D1%81%D1%82%D0%BE%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/aa/Call_of_Duty_WW2_11_17.jpg/revision/latest?cb=20171029100933',
				'title' => 'Call of Duty: WWII',
				'url' => 'http://ru.callofduty.wikia.com/wiki/Call_of_Duty:_WWII'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/c/cd/Transformers_11_17.jpg/revision/latest?cb=20171029100932',
				'title' => 'Transformers вики',
				'url' => 'http://ru.transformers.wikia.com/wiki/Transformers_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/dd/Divinity_11_17.jpg/revision/latest?cb=20171029100932',
				'title' => 'Divinity вики',
				'url' => 'http://ru.divinity.wikia.com/wiki/Divinity_%D0%B2%D0%B8%D0%BA%D0%B8'
			]
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/zelda/images/b/b1/The_Legend_of_Zelda_WiiU_Artwork.png/revision/latest?cb=20170306075901',
				'title' => 'Zeldapedia',
				'url' => 'http://bit.ly/fandom-it-footer-itzelda'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/rickandmorty/images/b/bc/Slider_-_Personaggi.png/revision/latest/scale-to-width-down/670?cb=20170802162630&path-prefix=it',
				'title' => 'Rick and Morty Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itrickandmorty'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itmario'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/iltronodispade/images/6/60/Il_Trono_di_Spade3.png/revision/latest/thumbnail-down/width/660/height/660?cb=20111128211925&path-prefix=it',
				'title' => 'Il Trono di Spade Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itiltronodispade'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/assassinscreed/images/f/f9/Wikia-Visualization-Main%2Citassassinscreed.png/revision/latest?cb=20161102150231&path-prefix=it',
				'title' => 'Assassin\'s Creed Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itassassinscreed'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/jnsama/images/5/5e/Header.jpg/revision/latest?cb=20170919034721&path-prefix=zh',
				'title' => '請命令！提督SAMA Wiki',
				'url' => 'http://zh.jnsama.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ro-foreverlove/images/5/5e/Header.jpg/revision/latest?cb=20171018022448&path-prefix=zh',
				'title' => 'RO仙境傳說：守護永恒的愛',
				'url' => 'http://zh.ro-foreverlove.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/digimonlinkz/images/7/71/%E6%95%B8%E7%A2%BC%E5%AF%B6%E8%B2%9D_Linkz_Wikia_header.png/revision/latest?cb=20160413185637&path-prefix=zh',
				'title' => '數碼寶貝Linkz',
				'url' => 'http://zh.digimonlinkz.wikia.com'
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
				return 'ru';
			default:
				return $language;
		}
	}

	private static function getThumbnailUrl( $url ) {
		try {
			return VignetteRequest::fromUrl( $url )
				->zoomCrop()
				->width( self::THUMBNAIL_WIDTH )
				->height( floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO ) )
				->url();
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
