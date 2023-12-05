<div class="relative inline-block text-left">
    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
        <span>{{ $availableLocales[$currentLocale] }} ({{ $currentLocale }})</span>
        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 0 1 .7.29l3 3a1 1 0 0 1 0 1.42l-3 3a1 1 0 1 1-1.42-1.42L10.59 8H4a1 1 0 1 1 0-2h6.59l-1.3-1.29A1 1 0 0 1 10 3z"/>
        </svg>
    </button>

    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
            @foreach($availableLocales as $locale => $localeName)
                @if($locale !== $currentLocale)
                    <a href="{{ route('language', $locale) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-400">{{ $localeName }} ({{ $locale }})</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
