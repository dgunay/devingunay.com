<?php declare(strict_types=1);

namespace BestBans;

// TODO: use an API to get win% pick% per-elo
class BanRanker
{
	protected $key = '';

	protected $champions = array();

	protected $db;

	public $patch;

	public function __construct(string $key, \PDO $db = null) {
		$this->key = $key;
		$this->db = $db;
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
			throw new \Exception('Database cannot be null.');
		}

		$elos = ['BRONZE','SILVER','GOLD','PLATINUM'];

		// optionally filter by one elo
		if ($elo) {
			$elos = array_filter($elos, function ($a) use ($elo) {
				return strcasecmp($a, $elo) === 0;
			});
		}
		
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

			$top_bans[$elo] = $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		// TODO: make dynamic
		$patch = '8.10';

		return [
			'patch'    => $patch,
			'top_bans' => $top_bans
		];
	}
}