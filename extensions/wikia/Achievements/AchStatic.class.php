<?php
/**
 * @author: Inez Korczyński (korczynski@gmail.com)
 */

class AchStatic {

	public static $mLevelNames = array(
		BADGE_LEVEL_BRONZE => 'bronze',
		BADGE_LEVEL_SILVER => 'silver',
		BADGE_LEVEL_GOLD => 'gold',
		BADGE_LEVEL_PLATINUM => 'platinum',
	);

	public static $mBadgeNames = array(
		BADGE_WELCOME => 'welcome',
		BADGE_INTRODUCTION => 'introduction',
		BADGE_SAYHI => 'sayhi',
		BADGE_CREATOR => 'creator',
		BADGE_POUNCE => 'pounce',
		BADGE_CAFFEINATED => 'caffeinated',
		BADGE_LUCKYEDIT => 'luckyedit',
		BADGE_EDIT => 'edit',
		BADGE_PICTURE => 'picture',
		BADGE_CATEGORY => 'category',
		BADGE_BLOGPOST => 'blogpost',
		BADGE_BLOGCOMMENT => 'blogcomment',
		BADGE_LOVE => 'love',
	);

	public static $mInTrackConfig = array(
		BADGE_EDIT => array(
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 250),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 500),
		),
		BADGE_PICTURE => array(
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 250),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 500),
		),
		BADGE_CATEGORY => array(
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 5),
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 10),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 100),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 250),
		),
		BADGE_BLOGPOST => array(
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 1),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 5),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 10),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 25),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 50),
		),
		BADGE_BLOGCOMMENT => array(
			array('level' => BADGE_LEVEL_BRONZE, 'events' => 3),
			array('level' => BADGE_LEVEL_SILVER, 'events' => 10),
		),
		BADGE_LOVE => array(
			array('level' => BADGE_LEVEL_SILVER, 'events' => 5),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 14),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 30),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 60),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 100),
			array('level' => BADGE_LEVEL_GOLD, 'events' => 200),
			array('level' => BADGE_LEVEL_PLATINUM, 'events' => 365),
		),
	);

	public static $mNotInTrackConfig = array(
		BADGE_WELCOME => BADGE_LEVEL_BRONZE,
		BADGE_INTRODUCTION => BADGE_LEVEL_BRONZE,
		BADGE_SAYHI => BADGE_LEVEL_BRONZE,
		BADGE_CREATOR => BADGE_LEVEL_GOLD,
		BADGE_POUNCE => BADGE_LEVEL_SILVER,
		BADGE_CAFFEINATED => BADGE_LEVEL_SILVER,
		BADGE_LUCKYEDIT => BADGE_LEVEL_GOLD
	);

	public static $mLevelsConfig = array(
		BADGE_LEVEL_BRONZE => 10,
		BADGE_LEVEL_SILVER => 50,
		BADGE_LEVEL_GOLD => 100,
		BADGE_LEVEL_PLATINUM => 250,
	);

}