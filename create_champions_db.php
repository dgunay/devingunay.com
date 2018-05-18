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

// TODO: grab champions dynamically from the static data site
$static_champions = json_decode(file_get_contents(__DIR__ . '/riot.json'), true);
$champ_names = [];
foreach ($static_champions['data'] as $champ) {
	$champ_names[$champ['id']] = $champ['name'];
}

// spin up our DB
$pdo = new PDO('sqlite:' . __DIR__ . '/champions.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
foreach ($elos as $elo => $champions) {
	foreach ($champions as $champion) {
		$statement = $pdo->prepare("INSERT INTO champions (
			id, winRate, playRate, name, elo
		)
		VALUES (
			:id, :winRate, :playRate, :name, :elo
		)");
	
		$statement->execute([
			':id'       => $champion['championId'],
			':winRate'  => $champion['winRate'],
			':playRate' => $champion['playRate'],
			':name'     => $champ_names[$champion['championId']],
			':elo'      => $champion['elo'],
		]);
	}
}