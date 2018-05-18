<?php declare(strict_types=1);

namespace BestBans;

class BestBansView
{
	protected $bans;
	protected $patch;

	public function __construct(array $bans) {
		$this->bans  = $bans['top_bans'];	
		$this->patch = $bans['patch'];
	}

	public function render() {
		$text = '';
		// patch number
		$text .= '<div class="row justify-content-md-left align-items-center">
			<div class="col-md-6">
				<h2 class="display-4">
					Patch ' . $this->patch . ' Top Bans
				</h2>
			</div>
		</div>';

		foreach ($this->bans as $elo => $top_bans) {
			// elo row
			$text .= '<div class="row justify-content-md-left align-items-center" style="margin-top:20px">
				<h4 class="">
					' . ucwords(strtolower($elo)) . '
				</h4>
			</div>';

			// the champions
			$text .= '<div class="row justify-content-md-left">';
			foreach ($top_bans as $index => $champion) {
				$text .= '<div class="col-md-2">
					' . ($index + 1) . ': ' . $champion['name'] . '
				</div>';
			}
			$text .= '</div>';
		}

		return $text;
	}
}