<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 :text-gray-100 text-center">
                    <p class="mb-4">{{ __("タスク管理ツールへようこそ！") }}</p>
                    
                    <a href="/tasks" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                        ➔ タスク管理を開く
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
