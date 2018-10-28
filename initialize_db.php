<?php

require __DIR__ . '/vendor/autoload.php';
use GoodBans\ChampionsDatabase;
use GoodBans\OpGG;
use GoodBans\RiotChampions;
use GoodBans\Lolalytics;

$db = new ChampionsDatabase(
	new \PDO('sqlite:'.__DIR__.'/champions.db'),
	// new OpGG(),
	new Lolalytics(),
	new RiotChampions()
);

$db->refresh();