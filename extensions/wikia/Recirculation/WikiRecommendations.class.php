<?php

use Wikia\Search\TopWikiArticles;

class WikiRecommendations {

	const THUMBNAIL_WIDTH = 100;
	const THUMBNAIL_RATIO = 16 / 9;
	const WIKI_RECOMMENDATIONS_LIMIT = 3;

	const RECOMMENDATIONS = [
		'en' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/charmed/images/a/a9/Season-5-group-06.jpg/revision/latest?cb=20111014232133',
				'title' => 'Charmed Wiki',
				'url' => 'https://charmed.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/stephenking/images/6/61/The_Losers_Club.png/revision/latest?cb=20170807021615',
				'title' => 'Stephen King Wiki',
				'url' => 'https://stephenking.wikia.com/wiki/Main_Page'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/supernatural/images/1/1d/601.jpg/revision/latest?cb=20100831195032',
				'title' => 'Supernatural Wiki',
				'url' => 'https://supernatural.wikia.com/wiki/Supernatural_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/the-darkest-minds/images/c/c9/The_Darkest_Minds_Still_6.jpg/revision/latest?cb=20180525215419',
				'title' => 'The Darkest Minds Wiki',
				'url' => 'https://the-darkest-minds.wikia.com/wiki/The_Darkest_Minds_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/themagicians/images/4/48/CastleBlackspireGang.jpg/revision/latest?cb=20180408180237',
				'title' => 'The Magicians Wiki',
				'url' => 'https://themagicians.wikia.com/wiki/The_Magicians_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/orange-is-the-new-black/images/b/ba/Blackgirlsoitnb.jpg/revision/latest?cb=20160522025304',
				'title' => 'Orange is the New Black Wiki',
				'url' => 'https://orange-is-the-new-black.wikia.com/wiki/Orange_Is_the_New_Black_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/scrooge-mcduck/images/7/75/585af131f4147c5ae1a7071b36701392--dagobert-duck-scrooge-mcduck.jpg/revision/latest?cb=20180725134511',
				'title' => 'Scrooge McDuck Wiki',
				'url' => 'https://scrooge-mcduck.wikia.com/wiki/Scrooge_McDuck_Wikia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/central/images/2/21/O-BIG-NATE-ADVENTURE-THEATRE-facebook.jpg/revision/latest?cb=20180719205131',
				'title' => 'Big Nate Wiki',
				'url' => 'https://bignate.wikia.com/wiki/Big_Nate_Wiki'
			]
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/c3/FR-AttackOnTitan-Spotlight.jpg/revision/latest?cb=20180801091900&path-prefix=fr',
				'title' => 'Wiki L\'Attaque des Titans',
				'url' => 'http://fr.attaque-des-titans.wikia.com/wiki/Wiki_Shingeki_No_Kyojin'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/38/Battle_for_Azeroth_Spotlight.png/revision/latest?cb=20180731164459&path-prefix=de',
				'title' => 'Wiki Warcraft',
				'url' => 'http://fr.wowwiki.wikia.com/wiki/Accueil'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/f/ff/FR-OITNB-Spotlight.jpg/revision/latest?cb=20180801091829&path-prefix=fr',
				'title' => 'Wiki Orange Is the New Black',
				'url' => 'http://fr.orange-is-the-new-black.wikia.com/wiki/Wiki_Orange_is_the_New_Black'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/25/Dragon_Quest_XI_Spotlight.png/revision/latest?cb=20180731165605&path-prefix=de',
				'title' => 'Wiki Dragon Quest',
				'url' => 'http://fr.dragonquest.wikia.com/wiki/Wiki_Dragon_Quest'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/2/20/FR-Disenchantment-Spotlight.jpg/revision/latest?cb=20180801091755&path-prefix=fr',
				'title' => 'Wiki Désenchantée',
				'url' => 'http://fr.disenchantment.wikia.com/wiki/Wiki_Disenchantment'
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/5/59/Orange_is_the_New_Black_Spotlight.jpg/revision/latest?cb=20180731162237&path-prefix=de',
				'title' => 'Orange is the New Black Wiki',
				'url' => 'http://de.orange-is-the-new-black.wikia.com/wiki/Orange_is_the_New_Black_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/7/70/Bibi_Blocksberg_Sportlights_August_18.jpg/revision/latest?cb=20180731162444&path-prefix=de',
				'title' => 'Bibi Blocksberg Wiki',
				'url' => 'http://de.bibi-blocksberg.wikia.com/wiki/Bibi_Blocksberg_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/f/f1/Handmaids_tale_spotlight_august.jpg/revision/latest?cb=20180731162525&path-prefix=de',
				'title' => 'The Handmaid\'s Tale Wiki',
				'url' => 'http://de.the-handmaids-tale.wikia.com/wiki/The_Handmaid%27s_Tale_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/3b/Detektiv_Conan_Spotlight.jpg/revision/latest?cb=20180731163020&path-prefix=de',
				'title' => 'Detektiv Conan Wiki',
				'url' => 'https://detektivconan.wikia.com/wiki/Detektiv_Conan_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/21/Videospiele_Wiki.jpg/revision/latest?cb=20180228143312&path-prefix=de',
				'title' => 'Videospiele Wiki',
				'url' => 'http://videospiele.wikia.com/wiki/Videospiele_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/d/d9/No_Man%27s_Sky_Spotlight.png/revision/latest?cb=20180731163641&path-prefix=de',
				'title' => 'No Man\'s Sky Wiki',
				'url' => 'http://de.no-mans-sky.wikia.com/wiki/Startseite'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/3/38/Battle_for_Azeroth_Spotlight.png/revision/latest?cb=20180731164459&path-prefix=de',
				'title' => 'World of Warcraft Wiki',
				'url' => 'http://de.wow.wikia.com/wiki/WoWWiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/1/12/Telltale%27s_The_Walking_Dead_-_Final_Season.png/revision/latest?cb=20180731165000&path-prefix=de',
				'title' => 'The Walking Dead Wiki',
				'url' => 'http://de.thewalkingdeadtv.wikia.com/wiki/The_Walking_Dead_(TV)_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/2/25/Dragon_Quest_XI_Spotlight.png/revision/latest?cb=20180731165605&path-prefix=de',
				'title' => 'Dragon Quest Wiki',
				'url' => 'http://de.dragonquest.wikia.com/wiki/Dragon_Quest_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/9/9a/Shadow_of_the_Tomb_Raider_Spotlight.png/revision/latest?cb=20180731170422&path-prefix=de',
				'title' => 'Tomb Raider Wiki',
				'url' => 'http://de.tombraider.wikia.com/wiki/Tomb_Raider_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/c/c7/Destiny_2_Forsaken_Spotlight.jpg/revision/latest?cb=20180731171630&path-prefix=de',
				'title' => 'Destiny Wiki',
				'url' => 'http://de.destiny.wikia.com/wiki/Destiny_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/bossosbastelbude/images/f/f5/Ninjago_Spotlight.png/revision/latest?cb=20180806131407&path-prefix=de',
				'title' => 'Ninjago Wiki',
				'url' => 'http://de.lego-ninjago.wikia.com/wiki/Lego_Ninjago_Wiki'
			],
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepunchman/images/a/a7/Tatsumaki.png/revision/latest?cb=20171101151651&path-prefix=it',
				'title' => 'One-Punch Man Wiki',
				'url' => 'https://goo.gl/QrXG3a'
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/shingekinokyojin/images/4/42/Wikia-Visualization-Main%2Citshingekinokyojin.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102171435&path-prefix=it',
				'title' => 'Shingeki no Kyojin Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itshingekinokyojin'
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
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/dragonball/images/0/0f/Wikia-Visualization-Main%2Citdragonball.png/revision/latest?cb=20161102150926&path-prefix=it',
				'title' => 'Dragon Ball Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itdragonball'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/onepiece/images/3/36/Promo_wiki.png/revision/latest?cb=20161129202134&path-prefix=it',
				'title' => 'One Piece Wiki Italia',
				'url' => 'http://bit.ly/fandom-it-footer-itonepiece'
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/naruto/images/5/50/Wikia-Visualization-Main%2Cplnaruto.png/revision/latest?cb=20161102143013',
				'title' => 'Narutopedia',
				'url' => 'http://bit.ly/fandom-it-footer-itnaruto'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/9/96/Fanonpedia.png/revision/latest?cb=20180407215628',
				'title' => 'Star Wars Fanonpedia',
				'url' => 'https://gwfanon.wikia.com/wiki/Star_Wars_Fanonpedia'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/c/c1/BnHA_Slider.jpg/revision/latest?cb=20180530125401',
				'title' => 'Boku no Hero Academia Wiki',
				'url' => 'http://pl.bokunoheroacademia.wikia.com/wiki/Boku_no_Hero_Academia_Wiki'
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
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/plwikia/images/3/33/PVZWiki_Spotlight2018.png/revision/latest?cb=20180606172907',
				'title' => 'Plants vs. Zombies Wiki',
				'url' => 'http://pl.plantsvszombies.wikia.com/wiki/Plants_vs._Zombies_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hearthstonepedia/images/7/78/HW_Slider.jpg/revision/latest?cb=20180709111854&path-prefix=pl',
				'title' => 'Hearthstone Wiki',
				'url' => 'http://pl.hearthstone.wikia.com/wiki/Hearthstone_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/polskapersopedia/images/7/76/New_Canvas.jpg/revision/latest?cb=20180712074537&path-prefix=pl',
				'title' => 'Riordanopedia',
				'url' => 'https://polskapersopedia.wikia.com/wiki/Percy_Jackson_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/europa-song-contest/images/3/32/Spotlight.png/revision/latest?cb=20180713210019&path-prefix=pl',
				'title' => 'Europa Song Contest Wiki',
				'url' => 'http://pl.europa-song-contest.wikia.com/wiki/Europa_Song_Contest_Wiki'
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
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/luntik/images/2/26/X480-jJR.jpg/revision/latest?cb=20180325145607&path-prefix=ru',
				'title' => 'Лунтик Wiki',
				'url' => 'http://ru.luntik.wikia.com/wiki/%D0%9B%D1%83%D0%BD%D1%82%D0%B8%D0%BA_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/crysis/images/2/2b/Crysis_Banner1.png/revision/latest?cb=20180630212633&path-prefix=ru',
				'title' => 'Crysis Wiki',
				'url' => 'http://ru.crysis.wikia.com/wiki/Crysis_Wiki'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/future/images/9/98/%D0%91%D0%B0%D0%BD%D0%BD%D0%B5%D1%80_%D0%9D%D0%B0%D0%B7%D0%B0%D0%B4_%D0%B2_%D0%91%D1%83%D0%B4%D1%83%D1%89%D0%B5%D0%B5.jpg/revision/latest?cb=20180706183019&path-prefix=ru',
				'title' => 'Будущее Вики',
				'url' => 'http://ru.future.wikia.com/wiki/%D0%91%D1%83%D0%B4%D1%83%D1%89%D0%B5%D0%B5_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/magicmagicinandaroundus/images/7/7b/WhatsApp_Image_2018-07-20_at_00.25.35.jpeg/revision/latest?cb=20180720021014&path-prefix=ru',
				'title' => 'Магия в нас и вокруг нас вики',
				'url' => 'http://ru.magicmagicinandaroundus.wikia.com/wiki/%D0%9C%D0%B0%D0%B3%D0%B8%D1%8F_%D0%B2_%D0%BD%D0%B0%D1%81_%D0%B8_%D0%B2%D0%BE%D0%BA%D1%80%D1%83%D0%B3_%D0%BD%D0%B0%D1%81_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/b/b7/Teen_titans_Go_spotlight_August18.jpg/revision/latest?cb=20180726091722',
				'title' => 'Юные Титаны Вперёд! вики',
				'url' => 'http://ru.teen-titans-go.wikia.com/wiki/%D0%AE%D0%BD%D1%8B%D0%B5_%D0%A2%D0%B8%D1%82%D0%B0%D0%BD%D1%8B_%D0%92%D0%BF%D0%B5%D1%80%D1%91%D0%B4!_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/6/6a/Castle_Rock_spotlight_August18.jpg/revision/latest?cb=20180726091720',
				'title' => 'Касл-Рок',
				'url' => 'http://ru.stephenking.wikia.com/wiki/%D0%9A%D0%B0%D1%81%D0%BB-%D0%A0%D0%BE%D0%BA'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/3/38/Walking_Dead_game_spotlight_August18.jpg/revision/latest?cb=20180726091723',
				'title' => 'Ходячие мертвецы - финал истории Клементины',
				'url' => 'http://ru.walkingdead.wikia.com/wiki/%D0%A5%D0%BE%D0%B4%D1%8F%D1%87%D0%B8%D0%B5_%D0%BC%D0%B5%D1%80%D1%82%D0%B2%D0%B5%D1%86%D1%8B_(%D0%B2%D0%B8%D0%B4%D0%B5%D0%BE%D0%B8%D0%B3%D1%80%D0%B0):_%D0%A7%D0%B5%D1%82%D0%B2%D1%91%D1%80%D1%82%D1%8B%D0%B9_%D1%81%D0%B5%D0%B7%D0%BE%D0%BD'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/4/42/Vampyr_game_spotlight_August18.jpg/revision/latest?cb=20180726091722',
				'title' => 'Vampyr вики',
				'url' => 'http://ru.vampyr.wikia.com/wiki/Vampyr_%D0%B2%D0%B8%D0%BA%D0%B8'
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/spotlightsimagestemporary/images/9/98/Soul_Knight_game_spotlight_August18.jpg/revision/latest?cb=20180726091721',
				'title' => 'Soul Knight вики',
				'url' => 'http://ru.soul-knight.wikia.com/wiki/Soul_Knight_%D0%B2%D0%B8%D0%BA%D0%B8'
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
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/eswikia/images/7/73/WYouTubePedia.png/revision/latest/scale-to-width-down/255?cb=20180714184201',
				'title' => 'Wiki Youtube Pedia',
				'url' => 'http://bit.ly/2vhIexU'
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
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/along-with-the-gods/images/6/6b/Fun-facts-along-with-the-gods-the-two-worlds-2-teaser.jpg/revision/latest?cb=20180708153024&path-prefix=zh',
				'title' => '與神同行Wiki',
				'url' => 'http://zh.along-with-the-gods.wikia.com'
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

	public static function getPopularArticles() {
		global $wgCityId;

		$topWikiArticles = TopWikiArticles::getArticlesWithCache( $wgCityId, false );
		// do not show itself
		$topWikiArticles = array_filter( $topWikiArticles, function ( $item ) {
			return $item['id'] !== RequestContext::getMain()->getTitle()->getArticleID();
		} );
		// show max 3 elements
		$topWikiArticles = array_slice( $topWikiArticles, 0, 3 );
		// add index to items to render it by mustache template
		$index = 1;
		foreach ( $topWikiArticles as &$wikiArticle ) {
			$wikiArticle['index'] = $index;
			$index ++;
		}

		return $topWikiArticles;
	}
}
