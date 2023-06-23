<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class ComingSoon extends Component
{
    public $comingSoon = [];
    public $token = null;

    public function loadComingSoon(){
        if($this->token == null) {
            $this->authenticate();
        }

        $headers = [
            'Accept' => 'application/json',
            'Client-ID' => env('IGDB_CLIENT'),
            'Authorization' => 'Bearer '.$this->token['access_token'],
        ];

        $current = Carbon::now()->timestamp;

        $this->comingSoon = Http::withHeaders($headers)
            ->withBody("
                fields 
                    name,
                    cover.url,
                    summary,
                    first_release_date,
                    platforms.abbreviation,
                    rating,
                    rating_count;
                where first_release_date > {$current};
                sort first_release_date asc;
                limit 4;
            ")
            ->post('https://api.igdb.com/v4/games')->json();
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }

    private function authenticate() {
        $token = Http::withUrlParameters([
            'endpoint' => env('IGDB_OAUTH'),
            'client_id' => env('IGDB_CLIENT'),
            'client_secret' => env('IGDB_SECRET'),
            'grant_type' => 'client_credentials',
        ])->post(
            '{+endpoint}?client_id={client_id}&client_secret={client_secret}&grant_type={grant_type}'
            )->json();

        $this->token = $token;
    }
}
