<?php

/**
 * Data Model for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

class WikiaBarDataFailsafeModel extends WikiaBarModelBase {

	/**
	 * @var array
	 * Structure should look like:
	 * [
	 *        language =>
	 *             [
	 *                 varticalid => message,
	 *                 varticalid => message
	 *            ],
	 *        language =>
	 *             [
	 *                 varticalid => message,
	 *                 varticalid => message
	 *            ]
	 * ]
	 */
	protected $data = array(
		'en' => array(
			WikiFactoryHub::CATEGORY_ID_GAMING =>
			'button-1-class=cup
button-1-text=Summer Olympics
button-1-href=http://www.wikia.com
button-2-class=travel
button-2-text=Travel
button-2-href=http://www.wikia.com
button-3-class=beauty
button-3-text=Beauty
button-3-href=http://www.wikia.com
button-4-class=social
button-4-text=@WikiaLifestyle
button-4-href=http://www.wikia.com
line-1-text=Line one text / Gaming
line-1-href=http://www.wikia.com
line-2-text=Line two text / Gaming
line-2-href=http://www.wikia.com
line-3-text=Line three text / Gaming
line-3-href=http://www.wikia.com
line-4-text=Line four text / Gaming
line-4-href=http://www.wikia.com
line-5-text=Line five text / Gaming
line-5-href=http://www.wikia.com
',
			WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT =>
			'button-1-class=cup
button-1-text=Movie Trailers
button-1-href=http://movies.wikia.com/wiki/Moviepedia
button-2-class=travel
button-2-text=Fall TV
button-2-href=http://www.wikia.com/Entertainment/TV_Schedule
button-3-class=beauty
button-3-text=New In Entertainment
button-3-href=http://www.wikia.com/Entertainment
button-4-class=social
button-4-text=@WikiaEnt
button-4-href=https://twitter.com/wikiaent
line-1-text=Go behind the scenes for the 23rd Bond film.
line-1-href=http://jamesbond.wikia.com/wiki/Skyfall
line-2-text=Learn about the mysterious blackout in J.J. Abrams\' Revolution.
line-2-href=http://revolution.wikia.com/wiki/Revolution_Wiki
line-3-text=Explore the final adaptation of Twilight: Breaking Dawn
line-3-href=http://twilightsaga.wikia.com/wiki/Breaking_Dawn
line-4-text=Look up the Lyrics of your favorite song now!
line-4-href=http://lyrics.wikia.com/Lyrics_Wiki
line-5-text=Follow the development process of the new Hobbit trilogy.
line-5-href=http://lotr.wikia.com/wiki/The_Hobbit_%28films%29
',
			WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'button-1-class=cup
button-1-text=Summer Olympics
button-1-href=http://www.wikia.com
button-2-class=travel
button-2-text=Travel
button-2-href=http://www.wikia.com
button-3-class=beauty
button-3-text=Beauty
button-3-href=http://www.wikia.com
button-4-class=social
button-4-text=@WikiaLifestyle
button-4-href=http://www.wikia.com
line-1-text=Line one text / Lifestyle
line-1-href=http://www.wikia.com
line-2-text=Line two text / Lifestyle
line-2-href=http://www.wikia.com
line-3-text=Line three text / Lifestyle
line-3-href=http://www.wikia.com
line-4-text=Line four text / Lifestyle
line-4-href=http://www.wikia.com
line-5-text=Line five text / Lifestyle
line-5-href=http://www.wikia.com
'
		)
	);

	public function getData() {
		if (
			!empty($this->data[$this->getLang()])
			&& !empty($this->data[$this->getLang()][$this->getVertical()])
		) {
			$message = trim($this->data[$this->getLang()][$this->getVertical()]);
			return $message;
		}
	}
}

