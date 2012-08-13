<?php

/**
 * Interface of Hubs V2 module
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

interface WikiaHubsV2Module {
	public function setLang($lang);
	public function getLang();
	public function setDate($date);
	public function getDate();
	public function setVertical($vertical);
	public function getVertical();

	public function getData();
}