<?php declare(strict_types=1);

// TODO: use an API to get win% pick% per-elo
class BestBans
{
	protected $key = '';

	protected $champions = array();

	protected $db;

	public function __construct(string $key, PDO $db = null) {
		$this->key = $key;
		$this->db = $db;
	}

	public function get_champions(string $elo = null) {
		$params = [
			'limit'     => 1000, 
			'champData' => 'elo,playRate,winRate', // all we care about
			'api_key'   => $this->key
		];

		if ($elo) {
			$params['elo'] = strtoupper($elo);
		}
		
		$response = $this->get("champions", $params);
		
		$this->champions = json_decode($response, true);
		return $this->champions;
	}

	public function get_champion(string $id) {
		return json_decode($this->get("champions/$id?"), true);
	}

	private function get(string $endpoint, array $args = []) {
		$args['api_key'] = $this->key;
		print_r($args);
		return file_get_contents(
			'http://api.champion.gg/v2/' . $endpoint . '?' . http_build_query($args)
		);
	}

	public function dump() {
		return json_encode($this->champions);
	}

	public function best_bans(string $elo = null, int $limit = 5) {
		if ($this->db === null) {
			throw new Exception('Database cannot be null.');
		}

		$elos = ['BRONZE','SILVER','GOLD','PLATINUM'];

		// optionally filter by one elo
		if ($elo) {
			$elos = array_filter($elos, function ($a) use ($elo) {
				return strcasecmp($a, $elo) === 0;
			});
		}

		print_r($elos); exit;
		
		$top_bans = [];
		foreach ($elos as $elo) {
			// select the top N 
			$statement = $this->db->query(
				"SELECT * 
				FROM champions
				WHERE elo = '{$elo}'
				ORDER BY banValue DESC
				LIMIT {$limit}
				"
			);

			$top_bans[$elo] = $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		return $top_bans;
	}
}