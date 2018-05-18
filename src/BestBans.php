<?php declare(strict_types=1);

// TODO: use an API to get win% pick% per-elo
class BestBans
{
	protected $key = '';

	protected $champions = array();

	public function __construct(string $key) {
		$this->key = $key;
	}

	public function get_champions(string $elo = null) {
		$params = [
			'limit'     => 1000, 
			'champData' => 'elo,playRate,winRate,name', // all we care about
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

	public function best_bans(string $elo = null) {
		// 
	}
}