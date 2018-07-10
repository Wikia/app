<?php

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/westworld/images/9/95/Man_In_Black.jpg/revision/latest?cb=20161005154601',
				'title' => 'Westworld Wiki',
				'url' => 'https://westworld.wikia.com/wiki/Westworld_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/arresteddevelopment/images/3/3d/Wikia-Visualization-Add-7.png/revision/latest?cb=20130409235616',
				'title' => 'Arrested Development Wiki',
				'url' => 'https://arresteddevelopment.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/babylon5/images/6/6b/Bester.jpg/revision/latest?cb=20071130075846',
				'title' => 'Babylon 5 Wiki',
				'url' => 'https://babylon5.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/naruto/images/e/ed/Ephemeral2.PNG/revision/latest?cb=20160113184538',
				'title' => 'Naruto Wiki',
				'url' => 'https://naruto.wikia.com/wiki/Narutopedia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tokyoghoul/images/e/e7/Wp1_1920x1080.jpg/revision/latest?cb=20141215103156',
				'title' => 'Tokyo Ghoul:RE Wiki',
				'url' => 'https://tokyoghoul.wikia.com/wiki/Tokyo_Ghoul_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bokunoheroacademia/images/a/a8/Izuku_Meets_All_Might.png/revision/latest?cb=20170630050603',
				'title' => 'My Hero Academia Wiki',
				'url' => 'https://bokunoheroacademia.wikia.com/wiki/My_Hero_Academia_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hypotheticalhurricanes/images/2/2e/Beryl_image_2024.png/revision/latest?cb=20180429043818',
				'title' => 'Hypothetical Hurricanes Wiki',
				'url' => 'https://hypotheticalhurricanes.wikia.com/wiki/Hypothetical_Hurricanes_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/yuyuyu/images/a/a7/Sample.png/revision/latest?cb=20180625205834',
				'title' => 'Yuki Yuna is a Hero Wiki',
				'url' => 'https://yuyuyu.wikia.com/wiki/Yuki_Yuna_is_a_Hero_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/glitchtale/images/c/c2/Glitchtale_Wallpaper.png/revision/latest?cb=20180626082439',
				'title' => 'Glitchtale Wiki',
				'url' => 'https://glitchtale.wikia.com/wiki/Glitchtale_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/cswikia/images/1/1b/Csgo_poster_spotlight.png/revision/latest?cb=20180626061249',
				'title' => 'Counter-Strike Wiki',
				'url' => 'https://counterstrike.wikia.com/wiki/Counter-Strike_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/arianagrande/images/4/48/ArianaSPL.png/revision/latest?cb=20180620063000',
				'title' => 'Ariana Grande Wiki',
				'url' => 'https://arianagrande.wikia.com/wiki/Ariana_Grande_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/a/ac/FR-TheLastOfUs-Spotlight.jpg/revision/latest?cb=20180625132146&path-prefix=fr',
				'title' => 'Wiki The Last of Us',
				'url' => 'http://fr.thelastofus.wikia.com/wiki/Wiki_The_Last_of_Us'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/5/5b/FR-AmourSucre-Spotlight.jpg/revision/latest?cb=20180625132147&path-prefix=fr',
				'title' => 'Wiki Amour Sucré',
				'url' => 'http://fr.amour-sucre.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/1/19/FR-HollowKnight-Spotlight.jpg/revision/latest?cb=20180625132148&path-prefix=fr',
				'title' => 'Wiki Hollow Knight',
				'url' => 'http://fr.hollowknight.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/8/86/FR-DetroitBecomeHuman-Spotlight.jpg/revision/latest?cb=20180625132147&path-prefix=fr',
				'title' => 'Wiki Detroit: Become Human',
				'url' => 'http://fr.detroit-become-human.wikia.com/wiki/Wiki_Detroit:_Become_Human'
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/0/09/Spotlight-Luke-Cage.png/revision/latest?cb=20180627093124&path-prefix=de',
				'title' => 'Defenders Wiki',
				'url' => 'http://de.the-defenders.wikia.com/wiki/The_Defenders_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/13/Spotlight-This-Is-Us.jpg/revision/latest?cb=20180627093930&path-prefix=de',
				'title' => 'This Is Us Wiki',
				'url' => 'http://de.this-is-us.wikia.com/wiki/This_Is_Us_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/8/81/Spotlight-Preacher.png/revision/latest?cb=20180627094243&path-prefix=de',
				'title' => 'Preacher Wiki',
				'url' => 'http://de.preacher.wikia.com/wiki/Preacher_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/cd/Spotlight-Ant-Man-Wasp.png/revision/latest?cb=20180627092923&path-prefix=de',
				'title' => 'Marvel-Filme Wiki',
				'url' => 'http://de.marvel-filme.wikia.com/wiki/Marvel-Filme'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/3c/Tsubasa_Wiki.jpg/revision/latest?cb=20180427091239&path-prefix=de',
				'title' => 'Tsubasa Wiki',
				'url' => 'http://de.tsubasa.wikia.com/wiki/Captain_Tsubasa_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/21/Videospiele_Wiki.jpg/revision/latest?cb=20180228143312&path-prefix=de',
				'title' => 'Videospiele Wiki',
				'url' => 'http://videospiele.wikia.com/wiki/Videospiele_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/f/fc/Vampyr_Spotlight.png/revision/latest?cb=20180525135811&path-prefix=de',
				'title' => 'Vampyr Wiki',
				'url' => 'http://de.vampyr.wikia.com/wiki/Vampyr-Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/db/BattleTech_Spotlight.png/revision/latest?cb=20180525094916&path-prefix=de',
				'title' => 'BattleTech Wiki',
				'url' => 'http://de.battletech.wikia.com/wiki/BattleTech_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/d6/Spotlight-Crash-Bandicoot.png/revision/latest?cb=20180627095911&path-prefix=de',
				'title' => 'Crash Bandicoot Wiki',
				'url' => 'http://de.crash-bandicoot.wikia.com/wiki/Crash_Bandicoot_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/92/Spotlight-Prey-Mooncrash.png/revision/latest?cb=20180627100718&path-prefix=de',
				'title' => 'Prey Wiki',
				'url' => 'http://de.prey.wikia.com/wiki/Prey_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/life-is-strange/images/9/94/Captain-Spirit-Screenshot-02.jpg/revision/latest?cb=20180627105350&path-prefix=de',
				'title' => 'Life Is Strange Wiki',
				'url' => 'http://de.life-is-strange.wikia.com/wiki/Life_Is_Strange_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/4/4c/Spotlight-Elder-Scrolls-Summerset.png/revision/latest?cb=20180627121300&path-prefix=de',
				'title' => 'Elder Scrolls Wiki',
				'url' => 'http://de.elderscrolls.wikia.com/wiki/Elder_Scrolls_Wiki'
			],
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepunchman/images/a/a7/Tatsumaki.png/revision/latest?cb=20171101151651&path-prefix=it',
				'title' => 'One-Punch Man Wiki',
				'url' => 'https://goo.gl/QrXG3a'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/monsterhunter/images/c/c9/MHW-Rathalos_Artwork_002.jpg/revision/latest?cb=20170613095127',
				'title' => 'Monster Hunter Wiki',
				'url' => 'https://goo.gl/B8GDED'
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'https://goo.gl/8q571K'
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/2/2a/Wikia-Visualization-Main%2Citstarwars.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142316&path-prefix=it',
				'title' => 'Jawapedia',
				'url' => 'https://goo.gl/MF5jEG'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kingdomhearts/images/b/b1/Wikia-Visualization-Main%2Ckingdomhearts.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102141406',
				'title' => 'Kingdom Hearts Wiki',
				'url' => 'https://goo.gl/4VQrt1'
			],
		],
		'ja' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/farcry5/images/5/5f/%E3%83%91%E3%83%83%E3%82%B1%E3%83%BC%E3%82%B8%E3%83%87%E3%82%B6%E3%82%A4%E3%83%B3_Farcry5.jpg/revision/latest?cb=20180116060949&path-prefix=ja',
				'title' => 'ファークライ5 Wiki',
				'url' => 'http://ja.farcry5.wikia.com'
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
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/4/4c/TI6Q6jX.jpg/revision/latest?cb=20171201175705&path-prefix=pl',
				'title' => 'Xenopedia',
				'url' => 'http://pl.alien.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/lowcy-trolli/images/c/c1/Jim_sezon2.jpg/revision/latest?cb=20171217213110&path-prefix=pl',
				'title' => 'Łowcy Trolli Wiki',
				'url' => 'http://pl.lowcy-trolli.wikia.com/wiki/%C5%81owcy_Trolli_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/f/f3/Dziedzictwo_Wiki_01-2018.jpg/revision/latest?cb=20180102224021&path-prefix=pl',
				'title' => 'Dziedzictwo Wiki',
				'url' => 'http://dziedzictwo.wikia.com/wiki/Strona_g%C5%82%C3%B3wna'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/8/8d/Star_Butterfly_kontra_si%C5%82y_z%C5%82a_Wiki_01_2018.png/revision/latest?cb=20180102224140&path-prefix=pl',
				'title' => 'Star Butterfly kontra Siły Zła Wiki',
				'url' => 'http://pl.star-butterfly-kontra-sily-zla.wikia.com/wiki/Star_Butterfly_kontra_si%C5%82y_z%C5%82a_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/vuh/images/e/ed/TG_Spotlight.png/revision/latest?cb=20180202194503&path-prefix=pl',
				'title' => 'Tokyo Ghoul Wiki',
				'url' => 'http://pl.tokyo-ghoul.wikia.com/wiki/Tokyo_Ghoul_Wiki'
			]
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a3/TES_Summerset.jpg/revision/latest?cb=20180424104907',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6d/Dark_Souls_remastered.jpg/revision/latest?cb=20180424104904',
				'title' => 'Dark Souls вики',
				'url' => 'http://bit.ly/ru-spotlight-darksouls-april'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/5/58/Ru-spotlight-fallout76-july.jpg/revision/latest?cb=20180626120615',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kel/images/d/df/%D0%A1%D0%B8%D1%8F%D1%8E%D1%89%D0%B5%D0%B5_%D0%BE%D0%BA%D0%BE.png/revision/latest?cb=20180314110857&path-prefix=ru',
				'title' => 'Kelconf вики',
				'url' => 'http://bit.ly/ru-spotlight-kelconf'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/angrybirds/images/8/85/Piggy_Tales_4th_Street_png.png/revision/latest?cb=20180427154359&path-prefix=ru',
				'title' => 'Angry Birds Wiki',
				'url' => 'http://bit.ly/ru-spotlight-angrybirds'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kirby/images/a/a4/KirbyBanner.jpg/revision/latest?cb=20180512060811&path-prefix=ru',
				'title' => 'Кирби вики',
				'url' => 'http://bit.ly/ru-spotlight-kirby'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/brickipedia/images/0/04/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_06-07.2018.jpg/revision/latest?cb=20180520141544&path-prefix=ru',
				'title' => 'Legopedia',
				'url' => 'http://bit.ly/ru-spotlight-lego'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plantsvs-zombies/images/d/d3/BWBbanner1.png/revision/latest?cb=20180520175450&path-prefix=ru',
				'title' => 'Plants vs. Zombies Wiki',
				'url' => 'http://bit.ly/ru-spotlight-plantsvszombies'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/jurassicpark/images/c/c6/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.png/revision/latest?cb=20180605174841&path-prefix=ru',
				'title' => 'Парк Юрского Периода Вики',
				'url' => 'http://ru.jurassicpark.wikia.com/wiki/%D0%9F%D0%B0%D1%80%D0%BA_%D0%AE%D1%80%D1%81%D0%BA%D0%BE%D0%B3%D0%BE_%D0%9F%D0%B5%D1%80%D0%B8%D0%BE%D0%B4%D0%B0_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/2/2d/Pillars_of_eternity_2.jpg/revision/latest?cb=20180523132638',
				'title' => 'Pillars of Eternity 2',
				'url' => 'http://bit.ly/ru-spotlight-pillarsofeternity'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6b/Conan_Exiles.jpg/revision/latest?cb=20180523132637',
				'title' => 'Conan Exiles',
				'url' => 'http://bit.ly/ru-spotlight-conanexiles'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/a/a3/Shaman_King.jpg/revision/latest?cb=20180523132639',
				'title' => 'Shaman King Вики',
				'url' => 'http://bit.ly/ru-spotlight-shamanking'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/doctorwho/images/f/f6/DWBanner.jpg/revision/latest?cb=20180531141140&path-prefix=ru',
				'title' => 'Вики Доктор Кто',
				'url' => 'http://ru.tardis.wikia.com/wiki/Doctor_Who_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/besit/images/2/29/FCX_2018.jpeg/revision/latest?cb=20180602003630&path-prefix=ru',
				'title' => 'Фёдор Комикс Вики',
				'url' => 'http://ru.besit.wikia.com/wiki/%D0%A4%D1%91%D0%B4%D0%BE%D1%80_%D0%9A%D0%BE%D0%BC%D0%B8%D0%BA%D1%81_%D0%92%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/warhammer-40-000/images/7/7d/%D0%90%D1%80%D0%BC%D0%B8%D1%8F_%D1%85%D0%BE%D1%80%D1%83%D1%81%D0%B0.jpeg/revision/latest?cb=20180603150714&path-prefix=ru',
				'title' => 'Викиариум WarHammer 40k',
				'url' => 'http://ru.warhammer-40-000.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%B0%D1%80%D0%B8%D1%83%D0%BC_WarHammer_40k'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/warriors-cats/images/4/47/%D0%91%D0%B0%D0%B1%D0%BE%D1%87%D0%BA%D0%B0_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180604151726&path-prefix=ru',
				'title' => 'Коты-воители вики',
				'url' => 'http://ru.warriors-cats.wikia.com/wiki/%D0%9A%D0%BE%D1%82%D1%8B-%D0%B2%D0%BE%D0%B8%D1%82%D0%B5%D0%BB%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/guardiansofgahoole/images/a/a9/%D0%A1%D1%82%D0%B0%D1%8F_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180604152234&path-prefix=ru',
				'title' => 'Ночные Стражи Вики',
				'url' => 'http://ru.guardiansofgahoole.wikia.com/wiki/Guardians_of_Ga%27Hoole_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/americangods/images/2/2f/%D0%A1%D1%80%D0%B5%D0%B4%D0%B0_%D0%B1%D0%B0%D0%BD%D0%BD%D0%B5%D1%80.jpg/revision/latest?cb=20180604152412&path-prefix=ru',
				'title' => 'Американские боги вики',
				'url' => 'http://ru.americangods.wikia.com/wiki/%D0%90%D0%BC%D0%B5%D1%80%D0%B8%D0%BA%D0%B0%D0%BD%D1%81%D0%BA%D0%B8%D0%B5_%D0%B1%D0%BE%D0%B3%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/48/Ru-spotlight-ant-man-and-the-wasp.jpg/revision/latest?cb=20180626120613',
				'title' => 'Человек-муравей и Оса',
				'url' => 'http://ru.marvel.wikia.com/wiki/%D0%A7%D0%B5%D0%BB%D0%BE%D0%B2%D0%B5%D0%BA-%D0%BC%D1%83%D1%80%D0%B0%D0%B2%D0%B5%D0%B9_%D0%B8_%D0%9E%D1%81%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/e/e7/Ru-spotlight-detroit-game.jpg/revision/latest?cb=20180626120614',
				'title' => 'Detroit: Become Human вики',
				'url' => 'http://ru.detroit-become-human.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/d/dc/Ru-spotlight-cars-pixar.jpg/revision/latest?cb=20180626120615',
				'title' => 'Тачки вики',
				'url' => 'http://ru.carspixar.wikia.com/wiki/%D0%A2%D0%B0%D1%87%D0%BA%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/1/12/Ru-spotlight-attack-on-titan-season-3.jpg/revision/latest?cb=20180626120614',
				'title' => 'Атака Титанов вики',
				'url' => 'http://ru.attackontitan.wikia.com/wiki/%D0%90%D1%82%D0%B0%D0%BA%D0%B0_%D0%A2%D0%B8%D1%82%D0%B0%D0%BD%D0%BE%D0%B2'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/0/08/Ru-spotlight-ninjago.jpg/revision/latest?cb=20180626120616',
				'title' => 'Ninjago Wiki',
				'url' => 'http://ru.ninjago.wikia.com/wiki/Ninjago_Wiki'
			]
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/9/97/TLH_-_Spot3.jpg/revision/latest?cb=20180601061112',
				'title' => 'The Loud House Wiki',
				'url' => 'http://bit.ly/2iA9Hno'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/9/9a/SpotlightDBFW2k18.jpg/revision/latest?cb=20180606160139',
				'title' => 'Dragon Ball Fanon Wiki',
				'url' => 'http://bit.ly/2MydRKJ'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/66/SpotlightLigaMX4.jpg/revision/latest?cb=20180608192516',
				'title' => 'Liga MX Wiki',
				'url' => 'http://bit.ly/2KpfoFB'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/a/ab/SpotlightLMB2.jpg/revision/latest?cb=20180608192729',
				'title' => 'LMB Wiki',
				'url' => 'http://bit.ly/1LJcWlo'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/6/6d/Las_leyendas_spotlight.png/revision/latest?cb=20180615054513',
				'title' => 'Las Leyendas',
				'url' => 'http://bit.ly/2lIca1T'
			],
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
				'url' => 'http://zh.hunterxhunter.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlegirl/images/8/87/Banner.png/revision/latest?cb=20170725105753&path-prefix=zh',
				'title' => '戰鬥女子學園Wiki',
				'url' => 'http://zh.battlegirl.wikia.com/wiki/%E6%88%B0%E9%AC%A5%E5%A5%B3%E5%AD%90%E5%AD%B8%E5%9C%92_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/kings-raid/images/e/e6/KINGRAID.jpg/revision/latest?cb=20180422060120&path-prefix=zh-tw',
				'title' => '王之逆襲維基',
				'url' => 'http://zh-tw.kings-raid.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/tenka-hyakken/images/a/a6/Header.png/revision/latest?cb=20170429000748&path-prefix=zh',
				'title' => '天華百劍-斬 Wiki',
				'url' => 'http://zh.tenka-hyakken.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/d2-megaten-l/images/b/b8/%EF%BC%A4%C3%97%EF%BC%92_%E7%9C%9F%E3%83%BB%E5%A5%B3%E7%A5%9E%E8%BD%89%E7%94%9F.JPG/revision/latest?cb=20180128004321&path-prefix=zh',
				'title' => 'Ｄ×２ 真・女神轉生 Liberation Wiki',
				'url' => 'http://zh.d2megaten.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/marvel/images/4/4f/%E5%BE%A9%E4%BB%87%E8%80%853.jpg/revision/latest?cb=20180417130828&path-prefix=zh',
				'title' => 'Marvel維基',
				'url' => 'http://zh.marvel.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/legendofzelda/images/7/7c/BotW_Tile.png/revision/latest?cb=20171128141246&path-prefix=zh-tw',
				'title' => '薩爾達傳說Wiki',
				'url' => 'http://zh-tw.legendofzelda.wikia.com/'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/lobotomycorp/images/d/d5/Wikibanner.png/revision/latest?cb=20171212043320&path-prefix=zh',
				'title' => '脑叶公司维基',
				'url' => 'http://zh.lobotomycorp.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/pacificrim/images/b/b5/20180326-112617_U3792_M395231_5850.jpg/revision/latest?cb=20180401105122&path-prefix=zh',
				'title' => '環太平洋Wiki',
				'url' => 'http://zh.pacificrim.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/jinyong/images/c/c3/%E9%87%91%E5%BA%B8.jpg/revision/latest?cb=20180621054746&format=original&path-prefix=zh',
				'title' => '金庸Wiki',
				'url' => 'http://zh.jinyong.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/disney/images/f/fe/%E8%B6%85%E4%BA%BA%E7%89%B9%E6%94%BB%E9%9A%8A2.jpg/revision/latest?cb=20180618041103&format=original&path-prefix=zh',
				'title' => '迪士尼Wiki',
				'url' => 'http://zh.disney.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/detectiveconan/images/8/84/20160828180210895_new.jpg/revision/latest?cb=20180621115020&format=original&path-prefix=zh',
				'title' => '名偵探柯南Wiki',
				'url' => 'http://zh.detectiveconan.wikia.com'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/shingekinokyojin/images/0/05/J1376017787645.jpg/revision/latest?cb=20180628091500&path-prefix=zh',
				'title' => '進擊的巨人Wiki',
				'url' => 'http://zh.shingekinokyojin.wikia.com'
			],
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

		if ( $wgWikiaEnvironment === WIKIA_ENV_DEV ) {
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
