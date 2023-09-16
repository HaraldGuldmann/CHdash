<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Earning Runs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="float-right">
                <a
                    href="{{ route('earningruns.create') }}"
                    class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                    Create Earning Run
                </a>
            </div>
            <br><br>

            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Month/Year') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Locked') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created At') }}
                        </x-table-head>
                        <x-table-head>

                        </x-table-head>
                    </tr>
                </x-slot>

                @foreach($earningRuns as $earningRun)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $earningRun->month }}/{{ $earningRun->year }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $earningRun->locked ? 'green' : 'gray' }}-100 text-{{ $earningRun->locked ? 'green' : 'gray' }}-800">
                  {{ $earningRun->locked ? 'Locked' : 'Unlocked' }}
                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $earningRun->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="{{ route('earningruns.edit', $earningRun->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <a href="{{ route('earningruns.delete', $earningRun->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 mr-2">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
            {{ $earningRuns->render() }}
        </div>
    </div>
</x-app-layout>
