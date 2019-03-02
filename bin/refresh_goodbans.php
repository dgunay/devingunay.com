<?php

// TODO: make a Console script that calls a controller method instead of using this script

require __DIR__ . '/../vendor/autoload.php';

use GoodBans\ChampionsDatabase;
use GoodBans\RiotChampions;
use GoodBans\Lolalytics;

$db = new ChampionsDatabase(
	new \PDO('sqlite:'.__DIR__.'/../var/db/goodbans.sqlite'),
	//new OpGG(),
	new Lolalytics(),
	new RiotChampions()
);

$db->refresh();
