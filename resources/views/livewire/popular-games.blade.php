<div wire:init="loadPopularGames" class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @forelse ($popularGames as $game)
        <div class="game mt-8">
            <div class="relative inline-block">
                <a href="#">
                    @if(isset($game['cover']))
                        <img src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
                    @endif
                </a>
                <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right:-20px; bottom: -20px">
                    <div class="font-semibold text-xs flex justify-center items-center h-full">
                        @if(isset($game['rating']))    
                            {{ round($game['rating']).'%' }}
                        @else
                            N/A 
                        @endif
                    </div>

                </div>
            </div>
            <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">
                {{ $game['name'] }}
            </a>
            <div class="text-gray-400 mt-1">
                @if(isset($game['platforms']))
                    @foreach($game['platforms'] as $platform)
                        @if(isset($platform['abbreviation']))
                            @if (!$loop->last)
                                {{ $platform['abbreviation'] }},
                            @else
                                {{ $platform['abbreviation'] }}  
                            @endif
                        @else
                            N/A
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    @empty
        @foreach(range(1,12) as $game)
            <div class="game mt-8 animate-pulse">
                <div class="relative inline-block">
                    <div class="bg-slate-800 w-44 h-56"></div>
                </div>
                <div class="block text-transparent text-lg bg-slate-700 rounded leading-tight mt-4">
                    Title goes here
                </div>
                <div class="text-transparent bg-slate-700 rounded inline-block mt-3">PS4, PC, XBOX</div>
            </div>
        @endforeach
    @endforelse
</div><!-- end popular-games -->