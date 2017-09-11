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
				'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
				'title' => 'Death Note',
				'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
				'title' => 'Midnight Texas',
				'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
			],
		],
		'de' => [
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/9/91/Ginga_Spotlight.jpg/revision/latest?cb=20170830151235&path-prefix=de',
				'title' => 'Ginga Wiki',
				'url' => 'http://de.ginga.wikia.com/wiki/Ginga_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/1/19/Defenders_Spotlight.jpg/revision/latest?cb=20170830154407&path-prefix=de',
				'title' => 'Defenders Wiki',
				'url' => 'http://de.the-defenders.wikia.com/wiki/The_Defenders_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/9/94/Doctor_Who_Spotlight.jpg/revision/latest?cb=20170830155834&path-prefix=de',
				'title' => 'Doctor Who Wiki',
				'url' => 'http://de.doctorwho.wikia.com/wiki/Doctor_Who_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/9/9c/Big_Bang_Theory_Spotlight.jpg/revision/latest?cb=20170831083118&path-prefix=de',
				'title' => 'The Big Bang Theory Wiki',
				'url' => 'http://de.bigbangtheory.wikia.com/wiki/Big_Bang_Theory_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/0/05/Law_and_Order_Spotlight.jpg/revision/latest?cb=20170831084150&path-prefix=de',
				'title' => 'Law and Order Wiki',
				'url' => 'http://de.lawandorder.wikia.com/wiki/Law_%26_Order_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/6/64/Transformers_Spotlight.png/revision/latest?cb=20170831090847&path-prefix=de',
				'title' => 'Transformers Wiki',
				'url' => 'http://de.transformers.wikia.com/wiki/Transformers_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/bossosbastelbude/images/2/2b/Dragon_Ball_Spotlight.jpg/revision/latest?cb=20170831091342&path-prefix=de',
				'title' => 'Gokupedia',
				'url' => 'http://de.dragonball.wikia.com/wiki/Gokupedia:Willkommen',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/4/4c/Inuyasha_Spotlight.jpg/revision/latest?cb=20170831092021&path-prefix=de',
				'title' => 'Inuyasha Wiki',
				'url' => 'http://de.inuyasha.wikia.com/wiki/InuYasha_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/2/26/Life_is_Strange_Spotlight.jpg/revision/latest?cb=20170831111524&path-prefix=de',
				'title' => 'Life is Strange Wiki',
				'url' => 'http://de.life-is-strange.wikia.com/wiki/Life_Is_Strange_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/b/b3/Sudden_Strike_Spotlight.jpg/revision/latest?cb=20170831111933&path-prefix=de',
				'title' => 'Sudden Strike Wiki',
				'url' => 'http://de.suddenstrike.wikia.com/wiki/Sudden_Strike_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/a/af/SteamWorld_Spotlight.jpg/revision/latest?cb=20170831114205&path-prefix=de',
				'title' => 'SteamWorld Wiki',
				'url' => 'http://de.steamworld.wikia.com/wiki/SteamWorld_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/bossosbastelbude/images/6/61/Sonic_Spotlight.jpg/revision/latest?cb=20170831114831&path-prefix=de',
				'title' => 'Sonic Wiki',
				'url' => 'http://de.sonic.wikia.com/wiki/SonicWiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/bossosbastelbude/images/f/f6/Marvel_vs_Capcom.jpg/revision/latest?cb=20170831120102&path-prefix=de',
				'title' => 'Marvel vs Capcom Wiki',
				'url' => 'http://de.marvelvscapcom.wikia.com/wiki/Marvel_vs_Capcom_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/f/fa/Uncharted_Spotlight.jpg/revision/latest?cb=20170831121053&path-prefix=de',
				'title' => 'Uncharted Wiki',
				'url' => 'http://de.uncharted.wikia.com/wiki/Uncharted_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/bossosbastelbude/images/7/7f/Destiny_Spotlight.jpg/revision/latest?cb=20170831122028&path-prefix=de',
				'title' => 'Destinypedia',
				'url' => 'http://de.destiny.wikia.com/wiki/Destiny_Wiki',
			],
		],
		'fr' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/elsas-test/images/c/cf/Picsou_Spotlight.jpg/revision/latest/scale-to-width-down/640?cb=20170831132857&path-prefix=fr',
				'title' => 'Picsou Wiki',
				'url' => 'http://fr.picsou.wikia.com/wiki/Picsou_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/elsas-test/images/4/4d/Stalker_Spotlight.jpg/revision/latest/scale-to-width-down/640?cb=20170831132858&path-prefix=fr',
				'title' => 'Wiki Stalker',
				'url' => 'http://fr.stalker.wikia.com/wiki/Wiki_S.T.A.L.K.E.R.',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/elsas-test/images/3/30/COC_Spotlight.jpg/revision/latest?cb=20170831132857&path-prefix=fr',
				'title' => 'Wiki Clash of Clans',
				'url' => 'http://fr.clashofclans.wikia.com/wiki/Wiki_Clash_of_Clans',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/elsas-test/images/c/cd/LIS_Spotlight.jpg/revision/latest?cb=20170831132858&path-prefix=fr',
				'title' => 'Wiki Life Is Strange',
				'url' => 'http://fr.life-is-strange.wikia.com/wiki/Wiki_Life_is_Strange',
			],
		],
		'es' => [
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/eswikia/images/f/f3/Total-war-warhammer-2-hub-gamesoul.jpg/revision/latest?cb=20170613113912',
				'title' => 'La Biblioteca del Viejo Mundo',
				'url' => 'http://bit.ly/1SRySOT',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/zeistantilles/images/b/b9/Conker_ouv.jpg/revision/latest?cb=20170818192141',
				'title' => 'Conker Wiki',
				'url' => 'http://bit.ly/2xm9ryR',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/eswikia/images/0/0a/TLH_-_Spot2.jpg/revision/latest?cb=20170710100028',
				'title' => 'The Loud House Wiki',
				'url' => 'http://bit.ly/2iA9Hno',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/zeistantilles/images/e/e0/Doctor-who-peter-capaldi-david-bradley-portrait-shot.jpg/revision/latest?cb=20170818193154',
				'title' => 'Doctor Who Wiki',
				'url' => 'http://bit.ly/1OK6n5w',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/eswikia/images/1/18/Penn-Zero-Part-Time-Hero-penn-zero-part-time-hero-38841900-1000-563.jpg/revision/latest?cb=20170806035326',
				'title' => 'Wiki Penn Zero: Casi Héroe',
				'url' => 'http://bit.ly/2wisNYW',
			],
		],
		'pt-br' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ben10/images/e/e3/UB10Banner2017.2.png/revision/latest?cb=20170603173907&path-prefix=pt',
				'title' => 'Universo Ben 10',
				'url' => 'http://bit.ly/fandom-ptbr-footer-ben10',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/batalhasanimais/images/0/00/BAoficial3.png/revision/latest?cb=20170706144049&path-prefix=pt-br',
				'title' => 'Wiki Batalhas Animais',
				'url' => 'http://bit.ly/fandom-ptbr-footer-batalhasanimais',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/c/cf/DarthVader-SWG4.png/revision/latest?cb=20161110020121',
				'title' => 'Star Wars Wiki em Português',
				'url' => 'http://bit.ly/fandom-ptbr-footer-starwars',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fusionfallheros/images/9/9c/FusionFall_wallpaper.png/revision/latest?cb=20160701002948&path-prefix=pt-br',
				'title' => 'FusionFall Wiki',
				'url' => 'http://bit.ly/fandom-ptbr-footer-fusionfall',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ultragustavo25/images/1/16/CJ_Shadowhunter_Chronicles.jpg/revision/latest?cb=20170902053800&path-prefix=pt-br',
				'title' => 'Wikia Shadowhunters BR',
				'url' => 'http://bit.ly/fandom-ptbr-footer-shadowhunters',
			],
		],
		'ru' => [
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/2/2d/TES_sep_2017.jpg/revision/latest?cb=20170823114439',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/teswiki',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/spotlightsimagestemporary/images/f/fb/GoT_sep_2017.jpg/revision/latest?cb=20170823114517',
				'title' => 'Игра Престолов Вики',
				'url' => 'http://ru.gameofthrones.wikia.com/wiki/%D0%98%D0%B3%D1%80%D0%B0_%D0%9F%D1%80%D0%B5%D1%81%D1%82%D0%BE%D0%BB%D0%BE%D0%B2_%D0%92%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/2/2e/Fallout_sep_2017.jpg/revision/latest?cb=20170823113701',
				'title' => 'Убежище',
				'url' => 'http://ru.fallout.wikia.com/wiki/Fallout_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/spotlightsimagestemporary/images/c/c7/Fabulos_Patrol_sep_2017.jpg/revision/latest?cb=20170823113700',
				'title' => 'Сказочный Патруль вики',
				'url' => 'http://ru.fabulous-patrol.wikia.com/wiki/%D0%A1%D0%BA%D0%B0%D0%B7%D0%BE%D1%87%D0%BD%D1%8B%D0%B9_%D0%9F%D0%B0%D1%82%D1%80%D1%83%D0%BB%D1%8C_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/spotlightsimagestemporary/images/0/0d/Pl_vs_Zombies_sep_2017.jpg/revision/latest?cb=20170823113700',
				'title' => 'Plants vs. Zombies Wiki',
				'url' => 'http://ru.plantsvs-zombies.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/spotlightsimagestemporary/images/0/0f/Books_sep_2017.jpg/revision/latest?cb=20170823114404',
				'title' => 'Книги вики',
				'url' => 'http://ru.knigi.wikia.com/wiki/%D0%9A%D0%BD%D0%B8%D0%B3%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/spotlightsimagestemporary/images/6/62/Star_vs_Force_of_evil_sep_2017.jpg/revision/latest?cb=20170823113659',
				'title' => 'Стар Против Сил Зла Вики',
				'url' => 'http://ru.starvstheforcesofevil.wikia.com/wiki/%D0%A1%D1%82%D0%B0%D1%80_%D0%BF%D1%80%D0%BE%D1%82%D0%B8%D0%B2_%D0%A1%D0%B8%D0%BB_%D0%97%D0%BB%D0%B0_%D0%92%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/2/27/Future_sep_2017.jpg/revision/latest?cb=20170823113658',
				'title' => 'Будущее Вики',
				'url' => 'http://ru.future.wikia.com/wiki/%D0%91%D1%83%D0%B4%D1%83%D1%89%D0%B5%D0%B5_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/c/c0/Hitman_sep_2017.jpg/revision/latest?cb=20170823113658',
				'title' => 'Hitman Wiki',
				'url' => 'http://ru.hitman.wikia.com/wiki/Hitman_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/2/20/Attack_on_titan_sep_2017.jpg/revision/latest?cb=20170823113657',
				'title' => 'Атака Титанов вики',
				'url' => 'http://ru.shingekinokyojin.wikia.com/wiki/%D0%90%D1%82%D0%B0%D0%BA%D0%B0_%D0%A2%D0%B8%D1%82%D0%B0%D0%BD%D0%BE%D0%B2',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/spotlightsimagestemporary/images/a/a5/Sonic_sep_2017.jpg/revision/latest?cb=20170823113657',
				'title' => 'Sonic And His Friends Wiki',
				'url' => 'http://ru.sonic-and-his-friends.wikia.com/wiki/Sonic_And_His_Friends_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/2/2b/Nuclear_Throne_sep_2017.jpg/revision/latest?cb=20170823113656',
				'title' => 'Nuclear Throne вики',
				'url' => 'http://ru.nuclear-throne.wikia.com/wiki/Nuclear_Throne_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/6/67/Lady_Bug_sep_2017.jpg/revision/latest?cb=20170823113655',
				'title' => 'Miraculous Ladybug Вики',
				'url' => 'http://ru.ladybug.wikia.com/wiki/Miraculous_LadyBug_%D0%92%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/c/cd/Mo_creatures_sep_2017.jpg/revision/latest?cb=20170823113655',
				'title' => 'Mo\' Creatures Wiki',
				'url' => 'http://ru.mocreatures.wikia.com/wiki/Mo%27Creatures_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/8/80/Stalker_sep_2017.jpg/revision/latest?cb=20170823113654',
				'title' => 'S.T.A.L.K.E.R. Wiki',
				'url' => 'http://ru.stalker.wikia.com/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/7/70/Wikipisalia_sep_2017.jpg/revision/latest?cb=20170823113654',
				'title' => 'Википисалия',
				'url' => 'http://ru.pisalius.wikia.com/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%BF%D0%B8%D1%81%D0%B0%D0%BB%D0%B8%D1%8F',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/b/b6/Amer_horror_story_sep_2017.jpg/revision/latest?cb=20170823113654',
				'title' => 'Американская История Ужасов вики',
				'url' => 'http://ru.americanhorrorstory.wikia.com/wiki/%D0%90%D0%BC%D0%B5%D1%80%D0%B8%D0%BA%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%98%D1%81%D1%82%D0%BE%D1%80%D0%B8%D1%8F_%D0%A3%D0%B6%D0%B0%D1%81%D0%BE%D0%B2_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/spotlightsimagestemporary/images/b/ba/Lego_ninjago_sep_2017.jpg/revision/latest?cb=20170823113653',
				'title' => 'Legopedia',
				'url' => 'http://ru.lego.wikia.com/wiki/Legopedia',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/spotlightsimagestemporary/images/5/53/Hello_Neighbor_sep_2017.jpg/revision/latest?cb=20170823113652',
				'title' => 'Hello Neighbor вики',
				'url' => 'http://ru.hello-neighbor-game.wikia.com/wiki/Hello_Neighbor_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/e/e1/Life_is_Strange_sep_2017.jpg/revision/latest?cb=20170823113652',
				'title' => 'Life is Strange вики ',
				'url' => 'http://ru.life-is-strange.wikia.com/wiki/Life_is_Strange_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/2/28/Destiny_2_sep_2017.jpg/revision/latest?cb=20170823113651',
				'title' => 'Destiny Вики',
				'url' => 'http://ru.destiny.wikia.com/wiki/Destiny_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/spotlightsimagestemporary/images/d/d2/Dishonored_2_sep_2017.jpg/revision/latest?cb=20170823113651',
				'title' => 'Dishonored вики',
				'url' => 'http://ru.dishonored.wikia.com/wiki/Dishonored_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/spotlightsimagestemporary/images/e/e7/Rick_and_Morty_sep_2017.jpg/revision/latest?cb=20170824100240',
				'title' => 'Рик и Морти вики',
				'url' => 'http://ru.rickandmorty.wikia.com/wiki/%D0%A0%D0%B8%D0%BA_%D0%B8_%D0%9C%D0%BE%D1%80%D1%82%D0%B8_%D0%B2%D0%B8%D0%BA%D0%B8',
			],
		],
		'it' => [
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/onepiece/images/3/36/Promo_wiki.png/revision/latest?cb=20161129202134',
				'title' => 'One Piece Wiki Italia',
				'url' => 'http://bit.ly/fandom-it-footer-itonepiece',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/naruto/images/5/50/Wikia-Visualization-Main%2Cplnaruto.png/revision/latest?cb=20161102143013',
				'title' => 'Narutopedia',
				'url' => 'http://bit.ly/fandom-it-footer-itnaruto',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/dragonball/images/0/0f/Wikia-Visualization-Main%2Citdragonball.png/revision/latest?cb=20161102150926&path-prefix=it',
				'title' => 'Dragon Ball Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itdragonball',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/harrypotter/images/a/a4/Wikia-Visualization-Main%2Citharrypotter.png/revision/latest?cb=20161102142436&path-prefix=it',
				'title' => 'Harry Potter Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itharrypotter',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/iltronodispade/images/6/60/Il_Trono_di_Spade3.png/revision/latest/thumbnail-down/width/660/height/660?cb=20111128211925&path-prefix=it',
				'title' => 'Il Trono di Spade Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itiltronodispade',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/creepypastaitalia/images/2/2f/Header_2.png/revision/latest/thumbnail-down/width/1600/height/1600?cb=20170106211156&path-prefix=it',
				'title' => 'Creepypasta Italia',
				'url' => 'http://bit.ly/fandom-it-footer-itcreepypasta',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/assassinscreed/images/f/f9/Wikia-Visualization-Main%2Citassassinscreed.png/revision/latest?cb=20161102150231&path-prefix=it',
				'title' => 'Assassin\'s Creed Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itassassinscreed',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/bravefrontierrpg/images/0/0d/Brave_Frontier_RPG_ITALIA.png/revision/latest/thumbnail-down/width/660/height/660?cb=20151107095731&path-prefix=it',
				'title' => 'Brave Frontier RPG Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itbravefrontierrpg',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/shingekinokyojin/images/4/42/Wikia-Visualization-Main%2Citshingekinokyojin.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102171435&path-prefix=it',
				'title' => 'Shingeki no Kyojin Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itshingekinokyojin',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/supermarioitalia/images/8/81/Wikia-Visualization-Main%2Citsupermarioitalia.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102154509&path-prefix=it',
				'title' => 'Super Mario Italia Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itmario',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/starwars/images/2/2a/Wikia-Visualization-Main%2Citstarwars.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102142316&path-prefix=it',
				'title' => 'Jawapedia',
				'url' => 'http://bit.ly/fandom-it-footer-itstarwars',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/elderscrolls/images/d/de/Wikia-Visualization-Main%2Citelderscrolls.png/revision/latest/thumbnail-down/width/660/height/660?cb=20161102153432&path-prefix=it',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://bit.ly/fandom-it-footer-itelderscrolls',
			],
		],
		'pl' => [
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/a/a2/League_of_Legends_Wiki.jpg/revision/latest?cb=20170901024914&path-prefix=pl',
				'title' => 'League of Legends Wiki',
				'url' => 'http://pl.leagueoflegends.wikia.com/wiki/League_of_Legends_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/e/e1/Rayman_Wiki.jpg/revision/latest?cb=20170825174755&path-prefix=pl',
				'title' => 'Rayman Wiki',
				'url' => 'http://pl.rayman.wikia.com/wiki/Rayman_Wiki:Strona_g%C5%82%C3%B3wna',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/5/50/Simpsons_Wiki.jpg/revision/latest?cb=20170901031745&path-prefix=pl',
				'title' => 'Simpsons Wiki',
				'url' => 'http://pl.simpsons.wikia.com/wiki/Simpsons_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/60/DC_Wiki.jpg/revision/latest?cb=20170825173855&path-prefix=pl',
				'title' => 'DC Wiki',
				'url' => 'http://pl.dc.wikia.com/wiki/DC_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/7/7f/The_Elder_Scrolls_Wiki.jpg/revision/latest?cb=20170901024627&path-prefix=pl',
				'title' => 'The Elder Scrolls Wiki',
				'url' => 'http://pl.elderscrolls.wikia.com/wiki/The_Elder_Scrolls_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/5/54/Z%C5%82oczy%C5%84cy_Wiki.jpg/revision/latest?cb=20170901030240&path-prefix=pl',
				'title' => 'Złoczyńcy Wiki',
				'url' => 'http://pl.villains.wikia.com/wiki/Z%C5%82oczy%C5%84cy_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/3/35/Wied%C5%BAmin_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Wiedźmin Wiki',
				'url' => 'http://wiedzmin.wikia.com/wiki/Wied%C5%BAmin_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/2/2b/Warframe_Wiki.jpg/revision/latest?cb=20170901031050&path-prefix=pl',
				'title' => 'Warframe Wiki',
				'url' => 'http://pl.warframe.wikia.com/wiki/Strona_g%C5%82%C3%B3wna',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/b/b3/My_Little_Pony_Wiki.jpg/revision/latest?cb=20170901030633&path-prefix=pl',
				'title' => 'My Little Pony Wiki',
				'url' => 'http://pl.mlp.wikia.com/wiki/My_Little_Pony_Przyja%C5%BA%C5%84_to_magia_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/52/Dragonball_Wiki.jpg/revision/latest?cb=20170901032034&path-prefix=pl',
				'title' => 'Dragon Ball Wiki',
				'url' => 'http://pl.dragonball.wikia.com/wiki/Strona_g%C5%82%C3%B3wna',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/f/fa/Naruto_Wiki.jpg/revision/latest?cb=20170901032034&path-prefix=pl',
				'title' => 'Naruto Wiki',
				'url' => 'http://pl.naruto.wikia.com/wiki/Naruto_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/ba/Gwint_Wiki.jpg/revision/latest?cb=20170901031049&path-prefix=pl',
				'title' => 'Gwint Wiki',
				'url' => 'http://gwint.wikia.com/wiki/Gwint_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/5d/Gra_o_Tron_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Gra o Tron Wiki',
				'url' => 'http://graotron.wikia.com/wiki/Gra_o_tron_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/0/0f/Pokemon_Wiki.jpg/revision/latest?cb=20170901033359&path-prefix=pl',
				'title' => 'Pokemon Wiki',
				'url' => 'http://pl.pokemon.wikia.com/wiki/Pok%C3%A9mon_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/c/ca/SAO_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Sword Art Online Wiki',
				'url' => 'http://pl.swordartonline.wikia.com/wiki/Sword_Art_Online_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/b/b9/Tokyo_Ghoul_Wiki.jpg/revision/latest?cb=20170901032644&path-prefix=pl',
				'title' => 'Tokyo Ghoul Wiki',
				'url' => 'http://pl.tokyo-ghoul.wikia.com/wiki/Tokyo_Ghoul_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/f/fe/Need_for_Speed_Wiki.jpg/revision/latest?cb=20170901033401&path-prefix=pl',
				'title' => 'Need for Speed Wiki',
				'url' => 'http://pl.nfs.wikia.com/wiki/Need_for_Speed_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/5/59/Overwatch_Wiki.jpg/revision/latest?cb=20170901030239&path-prefix=pl',
				'title' => 'Overwatch Wiki',
				'url' => 'http://pl.overwatch.wikia.com/wiki/Overwatch_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette4.wikia.nocookie.net/vuh/images/d/d7/Death_Note.jpg/revision/latest?cb=20170901032713&path-prefix=pl',
				'title' => 'Death Note Wiki',
				'url' => 'http://pl.deathnote.wikia.com/wiki/Death_Note_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/5/5e/Battlefield_Wiki.jpg/revision/latest?cb=20170901033400&path-prefix=pl',
				'title' => 'Battlefield Wiki',
				'url' => 'http://pl.battlefield.wikia.com/wiki/Battlefield_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/b/b1/Auta_Wiki.png/revision/latest?cb=20170901025628&path-prefix=pl',
				'title' => 'Auta Wiki',
				'url' => 'http://pl.auta.wikia.com/wiki/Auta_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/6/6e/Life_is_Strange_Wiki.jpg/revision/latest?cb=20170901032033&path-prefix=pl',
				'title' => 'Life is Strange Wiki',
				'url' => 'http://pl.lifeisstrange.wikia.com/wiki/Life_Is_Strange_Wikia',
			],
			[
				'thumbnailUrl' => 'https://vignette2.wikia.nocookie.net/vuh/images/8/88/Star_Wars_Fanonpedia.jpg/revision/latest?cb=20170901034537&path-prefix=pl',
				'title' => 'Star Wars Fanonpedia',
				'url' => 'http://gwfanon.wikia.com/wiki/Strona_g%C5%82%C3%B3wna',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/c/c0/Europa_Song_Contest_Wiki.jpg/revision/latest?cb=20170901030238&path-prefix=pl',
				'title' => 'Europa Song Contest Wiki',
				'url' => 'http://pl.europa-song-contest.wikia.com/wiki/Europa_Song_Contest_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/c/c6/Shannara_Wiki.jpg/revision/latest?cb=20170901030240&path-prefix=pl',
				'title' => 'Shannara Wiki',
				'url' => 'http://pl.shannara.wikia.com/wiki/Shannara_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/3/38/Lego_Ninjago_Wiki.jpg/revision/latest?cb=20170901030239&path-prefix=pl',
				'title' => 'LEGO Ninjago Wiki',
				'url' => 'http://pl.ninjago.wikia.com/wiki/LEGO_Ninjago_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette1.wikia.nocookie.net/vuh/images/5/57/Unturned_Wiki.jpg/revision/latest?cb=20170901025637&path-prefix=pl',
				'title' => 'Unturned Wiki',
				'url' => 'http://pl.unturned.wikia.com/wiki/Unturned_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/2/22/Star_Darlings_Wiki.jpg/revision/latest?cb=20170901025525&path-prefix=pl',
				'title' => 'Star Darlings Wikia',
				'url' => 'http://pl.stardarlings.wikia.com/wiki/Star_Darlings_Wikia',
			],
			[
				'thumbnailUrl' => 'https://vignette3.wikia.nocookie.net/vuh/images/d/dd/Wonderland_Wikia.jpg/revision/latest?cb=20170901025507&path-prefix=pl',
				'title' => 'Wonderland Wikia',
				'url' => 'http://pl.wonderland.wikia.com/wiki/Wonderland_Wikia',
			],
		],
		'zh' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/shironekoproject/images/5/50/Wiki-background/revision/latest?cb=20150130211808&path-prefix=zh',
				'title' => '白貓計劃Wiki',
				'url' => 'http://zh.shironekoproject.wikia.com',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/destiny/images/5/50/Wiki-background/revision/latest?cb=20140528060728&path-prefix=zh',
				'title' => 'Destiny 維基',
				'url' => 'http://zh.destiny.wikia.com/wiki/Destiny_%E7%BB%B4%E5%9F%BA',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/fate-go/images/2/2f/Mainvisual.png/revision/latest?cb=20160105185037&path-prefix=zh',
				'title' => 'Fate/Grand Order Wiki',
				'url' => 'http://zh.fate-go.wikia.com/wiki/Fate/Grand_Order_%E4%B8%AD%E6%96%87_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/asoiaf/images/3/32/17966414_10154688723507734_1247624339901587946_o.jpg/revision/latest?cb=20170420224445&path-prefix=zh',
				'title' => '冰与火之歌中文维基',
				'url' => 'http://zh.asoiaf.wikia.com/wiki/%E5%86%B0%E4%B8%8E%E7%81%AB%E4%B9%8B%E6%AD%8C%E4%B8%AD%E6%96%87%E7%BB%B4%E5%9F%BA',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/nekowiz/images/5/50/Wiki-background/revision/latest?cb=20150130231207&path-prefix=zh',
				'title' => '問答RPG 魔法使與黑貓維茲 維基',
				'url' => 'http://zh.nekowiz.wikia.com/wiki/%E5%95%8F%E7%AD%94RPG_%E9%AD%94%E6%B3%95%E4%BD%BF%E8%88%87%E9%BB%91%E8%B2%93%E7%B6%AD%E8%8C%B2_%E7%B6%AD%E5%9F%BA',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/ffexvius/images/5/50/Wiki-background/revision/latest?cb=20160912171651&path-prefix=zh',
				'title' => 'FINAL FANTASY BRAVE EXVIUS中文 Wiki',
				'url' => 'http://zh.ffexvius.wikia.com/wiki/FINAL_FANTASY_BRAVE_EXVIUS%E4%B8%AD%E6%96%87_Wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/4/42/Header_bf2.png/revision/latest?cb=20170824065801&path-prefix=zh-hk',
				'title' => '星戰維基',
				'url' => 'http://zh.starwars.wikia.com/wiki/%E6%98%9F%E7%90%83%E5%A4%A7%E6%88%B0%E7%99%BE%E7%A7%91%E5%85%A8%E6%9B%B8',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hongkongbus/images/f/f2/KMB_GB9206_263.JPG/revision/latest?cb=20090802113442&path-prefix=zh',
				'title' => '香港巴士大典',
				'url' => 'http://hkbus.wikia.com/wiki/%E9%A6%96%E9%A0%81',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/hunterxhunter/images/4/48/Hunterxhunter.jpg/revision/latest?cb=20170904145736&path-prefix=zh',
				'title' => '獵人Wiki',
				'url' => 'http://zh.hunterxhunter.wikia.com/wiki/%E7%8D%B5%E4%BA%BA_wiki',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlegirl/images/8/87/Banner.png/revision/latest?cb=20170725105753&path-prefix=zh',
				'title' => '戰鬥女子學園Wiki',
				'url' => 'http://zh.battlegirl.wikia.com/wiki/%E6%88%B0%E9%AC%A5%E5%A5%B3%E5%AD%90%E5%AD%B8%E5%9C%92_Wiki',
			],
		],
		'ja' => [
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/battlefront/images/3/3b/BF2_IMG.jpg/revision/latest?cb=20170905023120&path-prefix=ja',
				'title' => 'Battlefront Wiki',
				'url' => 'http://ja.battlefront.wikia.com',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/gameofthrones/images/7/75/GOTS7-E5-25.jpg/revision/latest?cb=20170822083703&path-prefix=ja',
				'title' => 'ゲームオブスローンズ Wiki',
				'url' => 'http://ja.gameofthrones.wikia.com',
			],
			[
				'thumbnailUrl' => 'https://vignette.wikia.nocookie.net/starwars/images/6/65/Battle_of_Endor.png/revision/latest?cb=20150129051829&path-prefix=ja',
				'title' => 'ウーキーペディア',
				'url' => 'http://ja.starwars.wikia.com',
			],
		],
	];

    const STAGING_RECOMMENDATIONS = [
        [
            'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/gameofthrones/images/3/3a/WhiteWalker_%28Hardhome%29.jpg/revision/latest?cb=20150601151110',
            'title' => 'Game of Thrones',
            'url' => 'http://gameofthrones.wikia.com/wiki/Game_of_Thrones_Wiki',
        ],
        [
            'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/deathnote/images/1/1d/Light_Holding_Death_Note.png/revision/latest?cb=20120525180447',
            'title' => 'Death Note',
            'url' => 'http://deathnote.wikia.com/wiki/Main_Page',
        ],
        [
            'thumbnailUrl' => 'https://vignette.wikia-staging.nocookie.net/midnight-texas/images/b/b0/Blinded_by_the_Light_106-01-Rev-Sheehan-Davy-Deputy.jpg/revision/latest?cb=20170820185915',
            'title' => 'Midnight Texas',
            'url' => 'http://midnight-texas.wikia.com/wiki/Midnight,_Texas_Wikia',
        ]
    ];

	const DEV_RECOMMENDATIONS = [
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
	];
	
	public static function getRecommendations( $contentLanguage ) {
		global $wgDevelEnvironment, $wgWikiaEnvironment;

		if ( empty( $wgDevelEnvironment ) ) {
			$recommendations = self::RECOMMENDATIONS['en'];

			if ( array_key_exists( $contentLanguage, self::RECOMMENDATIONS ) ) {
				$recommendations = self::RECOMMENDATIONS[$contentLanguage];
			}
			shuffle( $recommendations );
		} elseif ($wgWikiaEnvironment == WIKIA_ENV_STAGING){
            $recommendations = self::STAGING_RECOMMENDATIONS;
        } else {
			$recommendations = self::DEV_RECOMMENDATIONS;
		}

		$recommendations = array_slice( $recommendations, 0, self::WIKI_RECOMMENDATIONS_LIMIT );

		$index = 1;
		foreach($recommendations as &$recommendation) {
			$recommendation['thumbnailUrl'] = self::getThumbnailUrl( $recommendation['thumbnailUrl'] );
			$recommendation['index'] = $index;
			$index++;
		}

		return $recommendations;
	}

	private static function getThumbnailUrl( $url ) {

		return VignetteRequest::fromUrl( $url )->zoomCrop()->width( self::THUMBNAIL_WIDTH )->height(
			floor( self::THUMBNAIL_WIDTH / self::THUMBNAIL_RATIO )
		)->url();
	}
}
