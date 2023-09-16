
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="float-right">
                <a
                    href="{{ route('teams.create') }}"
                    class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                    Create Team
                </a>
            </div>
            <br><br>

            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Name') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created At') }}
                        </x-table-head>
                    </tr>
                </x-slot>

                @foreach($teams as $team)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $team->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $team->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</x-app-layout>
