<div wire:init="loadComingSoon" class="coming-soon-container space-y-10 mt-8">
        @forelse($comingSoon as $game)
            <div class="game flex">
                <a href="#">
                    @if(isset($game['cover']))
                        <img src="{{ Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) }}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150">
                    @endif
                </a>
                <div class="ml-4">
                    <a href="#" class="hover:text-gray-300">
                        {{ $game['name'] }}
                    </a>
                    <div class="text-gray-400 text-sm mt-1">
                        {{ Carbon\Carbon::parse($game['first_release_date'])->format('M d Y') }}
                    </div>
                </div>
            </div>
        @empty
        <div class="border border-blue-300 shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex space-x-4">
                <div class="rounded-full bg-slate-700 h-10 w-10"></div>
                <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-slate-700 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-700 rounded"></div>
                </div>
                </div>
            </div>
        </div>

        @endforelse
</div>