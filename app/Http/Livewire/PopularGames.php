<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PopularGames extends Component
{
    public $popularGames = [];
    public $token = null;

    public function loadPopularGames() {
        if($this->token == null) {
            $this->authenticate();
        }

        $headers = [
            'Accept' => 'application/json',
            'Client-ID' => env('IGDB_CLIENT'),
            'Authorization' => 'Bearer '.$this->token['access_token'],
        ];

        $this->popularGames = Cache::remember('popular-games', 360, function () use($headers) {
            return Http::withHeaders($headers)
                ->withBody('
                    fields 
                        name,
                        cover.url,
                        first_release_date,
                        platforms.abbreviation,
                        rating;
                    where rating > 0;
                    sort rating desc;
                    limit 12;
                ')
                ->post('https://api.igdb.com/v4/games')
                ->json();
        });
    }

    public function render()
    {
        
        return view('livewire.popular-games');
    }

    private function authenticate() {
        $token = Http::withUrlParameters([
            'endpoint' => env('IGDB_OAUTH'),
            'client_id' => env('IGDB_CLIENT'),
            'client_secret' => env('IGDB_SECRET'),
            'grant_type' => 'client_credentials',
        ])
        ->post('{+endpoint}?client_id={client_id}&client_secret={client_secret}&grant_type={grant_type}')
        ->json();

        $this->token = $token;
    }
}
