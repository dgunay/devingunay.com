<?php

/**
 * Populates the database with champions for later querying.
 * 
 * @author Devin Gunay <devingunay@gmail.com>
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use BestBans\BanRanker;
$pdo = new \PDO('sqlite:' . __DIR__ . '/champions.db');
$bb = new BanRanker(
	$GLOBALS['champion.gg_key'], $pdo
);

// get champs for all elos
$elos = [
	'bronze'     => [],
	'silver'     => [],
	'gold'       => [],
	'platinum'   => [],
	'diamond'    => [],
	'master'     => [],
	'challenger' => [],
];

foreach (array_keys($elos) as $elo) {
	echo "getting $elo..." . PHP_EOL;
	$champions = $bb->get_champions($elo);
	$elos[$elo] = $champions;
}

// TODO: grab champions dynamically from the static data site
$static_champions = json_decode(file_get_contents(__DIR__ . '/riot.json'), true);
$champ_names = [];
foreach ($static_champions['data'] as $champ) {
	$champ_names[$champ['id']] = $champ['name'];
}

// spin up our DB and insert our champions, one row per elo
foreach ($elos as $elo => $champions) {
	foreach ($champions as $champion) {
		$statement = $pdo->prepare("INSERT INTO champions (
			id, winRate, playRate, name, elo, banValue, adjustedPickRate
		)
		VALUES (
			:id, :winRate, :playRate, :name, :elo, :banValue, :adjustedPickRate
		)");

		$adjusted_pick_rate = (100 * $champion['playRate']) / (100 - $champion['banRate']);
		$statement->execute([
			':id'               => $champion['championId'],
			':winRate'          => $champion['winRate'],
			':playRate'         => $champion['playRate'],
			':name'             => $champ_names[$champion['championId']],
			':elo'              => $champion['elo'],
			':adjustedPickRate' => $adjusted_pick_rate,
			':banValue'         => ($champion['winRate'] - 0.5) * $adjusted_pick_rate
		]);
	}
}
