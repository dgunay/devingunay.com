<?php

require 'src/BestBans.php';
require 'config.php';

$bb = new BestBans(
	$GLOBALS['champion.gg_key']
);

// get champs for all elos
$elos = [
	'bronze' => [],
	'silver' => [],
	'gold' => [],
	'platinum' => [],
	'diamond' => [],
	'master' => [],
	'challenger' => [],
];

foreach (array_keys($elos) as $elo) {
	echo "getting $elo..." . PHP_EOL;
	$champions = $bb->get_champions($elo);
	$elos[$elo] = $champions;
}

$pdo = new PDO('sqlite:' . __DIR__ . '/champions.db');

foreach ($elos as $elo => $champion) {
	$pdo->prepare("INSERT INTO champions (
		id, winRate, playRate, name, elo
	)
	VALUES (
		:id, :winRate, :playRate, :name, :elo
	)");
}