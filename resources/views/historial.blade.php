<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div x-data="{ open: false, selected: null }" class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('dashboard.historial') }}" class="mb-6 flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300">Desde</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300">Hasta</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            
                <div>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                        Filtrar
                    </button>
                    <a href="{{route("dashboard.historial")}}" class="inline-flex items-center px-6 py-2 ml-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700">
                        Limpiar Filtros
                    </a>
                </div>
            </form>            

            {{-- Tabla --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-4 dark:text-white">Historial de mediciones</h2>
        
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @if ($historial->isEmpty())
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No hay registros disponibles.
                                    </td>
                                </tr>
                            @endif 
                            @foreach ($historial as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button
                                            @click="selected = {{ json_encode($item) }}; open = true"
                                            class="text-indigo-500 hover:text-indigo-700"
                                        >
                                            Ver detalles
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $historial->links() }}
                    </div>
                </div>
            </div>
        
            {{-- Modal --}}
            <div
                x-show="open"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-cloak
            >
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Detalle de Medición</h3>
                    <ul class="space-y-2 text-gray-800 dark:text-gray-200">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M14 14.76V5a2 2 0 10-4 0v9.76A5 5 0 1014 14.76z" />
                            </svg>
                            <strong>Temperatura:</strong> <span x-text="selected.temperatura + ' °C'"></span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 3C12 3 7 8 7 13a5 5 0 0010 0c0-5-5-10-5-10z" />
                            </svg>
                            <strong>Humedad:</strong> <span x-text="selected.humedad + ' %'"></span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 3v1M12 20v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1M20 12h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <strong>Radiación UV:</strong> <span x-text="selected.uv"></span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                            <strong>Fecha:</strong> <span x-text="new Date(selected.created_at).toLocaleString()"></span>
                        </li>
                    </ul>
                    <div class="mt-6 text-right">
                        <button @click="open = false" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</x-app-layout>