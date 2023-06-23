<div wire:init="loadRecentlyReviewed" class="recently-reviewed-container space-y-12 mt-8">
                @forelse($recentlyReviewed as $game)
                    <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                        <div class="relative flex-none">
                            <a href="#">
                                @if(isset($game['cover']))
                                    <img src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
                                @endif
                            </a>
                            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-900 rounded-full" style="right:-20px; bottom: -20px">
                                <div class="font-semibold text-xs flex justify-center items-center h-full">
                                    @if(isset($game['rating']))    
                                        {{ round($game['rating']).'%' }}
                                    @else
                                        N/A 
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ml-12">
                            <a href="#" class="block text-lg font-semibold leading-tight hover:text-gray-400 mt-4">
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
                            <p class="mt-6 text-gray-400">
                                {{ $game['summary'] }}
                            </p>
                        </div>
                    </div>
                @empty
                    Loading...
                @endforelse
            </div>