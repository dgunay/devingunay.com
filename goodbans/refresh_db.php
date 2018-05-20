<?php

/**
 * Repopulates the database with champions for later querying.
 * 
 * @author Devin Gunay <devingunay@gmail.com>
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../config.php';

use GoodBans\BanRanker;
use GoodBans\ChampionGG;
use GoodBans\RiotChampions;
use GoodBans\ChampionsDatabaseRefresher;


$db = new ChampionsDatabaseRefresher(
	new \PDO('sqlite:' . __DIR__ . '/champions.db'),
	new ChampionGG($GLOBALS['champion.gg_key']),
	new RiotChampions(json_decode(file_get_contents(__DIR__ . '/riot.json'), true))
);

$db->refresh();