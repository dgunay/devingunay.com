<?php

/**
 * Repopulates the database with champions for later querying.
 * 
 * @author Devin Gunay <devingunay@gmail.com>
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../config.php';

use BestBans\BanRanker;
use BestBans\ChampionGG;
use BestBans\RiotChampions;
use BestBans\ChampionsDatabaseRefresher;


$db = new ChampionsDatabaseRefresher(
	new \PDO('sqlite:' . __DIR__ . '/champions.db'),
	new ChampionGG($GLOBALS['champion.gg_key']),
	new RiotChampions(json_decode(file_get_contents(__DIR__ . '/riot.json'), true))
);

$db->refresh();

$ban_ranker = new BanRanker($db->pdo());

$best_bans = $ban_ranker->best_bans();