<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class Index extends Component
{
    public $token = null;

    public function render()
    {
        if($this->token == null) {
            $this->authenticate();
        }

        $headers = [
            'Accept' => 'application/json',
            'Client-ID' => env('IGDB_CLIENT'),
            'Authorization' => 'Bearer '.$this->token['access_token'],
        ];

        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;
        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;

        $popularGames = Http::withHeaders($headers)
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
            ->post('https://api.igdb.com/v4/games')->json();

        $recentlyReviewed = Http::withHeaders($headers)
            ->withBody('
                fields 
                    name,
                    cover.url,
                    summary,
                    first_release_date,
                    platforms.abbreviation,
                    rating;
                where rating_count > 5;
                sort rating desc;
                limit 3;
            ')
            ->post('https://api.igdb.com/v4/games')->json();

        $mostAnticipated = Http::withHeaders($headers)
            ->withBody("
                fields 
                    name,
                    cover.url,
                    summary,
                    first_release_date,
                    platforms.abbreviation,
                    rating,
                    rating_count;
                where first_release_date > {$current}
                & first_release_date < {$afterFourMonths};
                sort rating desc;
                limit 4;
            ")
            ->post('https://api.igdb.com/v4/games')->json();

        $comingSoon = Http::withHeaders($headers)
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

        return view('livewire.index', [ 
            'popularGames' => $popularGames,
            'recentlyReviewed' => $recentlyReviewed,
            'mostAnticipated' => $mostAnticipated,
            'comingSoon' => $comingSoon,
        ]);
    }

    function authenticate() {
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
