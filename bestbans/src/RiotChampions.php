<?php

namespace BestBans;

class RiotChampions
{
	protected $champions;

	public function __construct(array $champions) {
		$this->champions = $champions;
	}

	public function getChampNameMap() {
		// Map champion ID to name
		$champ_names = [];
		foreach ($this->champions['data'] as $champ) {
			$champ_names[$champ['id']] = $champ['name'];
		}
		
		return $champ_names;
	}
}