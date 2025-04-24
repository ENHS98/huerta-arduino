<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <a href="{{ route('dashboard.solicitar') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Solicitar valores actuales
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card: Humedad --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 flex items-center space-x-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M12 3C12 3 7 8 7 13a5 5 0 0010 0c0-5-5-10-5-10z" />
                </svg>
                <div>
                    <div class="text-lg dark:text-gray-200 font-semibold">Humedad</div>
                    <div class="text-2xl text-gray-800 dark:text-gray-200">{{ $humedad }}%</div>
                </div>
            </div>

            {{-- Card: Radiación UV --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 flex items-center space-x-4">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path
                        d="M12 3v1M12 20v1M4.22 4.22l.7.7M18.36 18.36l.7.7M1 12h1M20 12h1M4.22 19.78l.7-.7M18.36 5.64l.7-.7M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>
                <div>
                    <div class="text-lg dark:text-gray-200 font-semibold">Radiación UV</div>
                    <div class="text-2xl text-gray-800 dark:text-gray-200">{{ $uv }}</div>
                </div>
            </div>

            {{-- Card: Temperatura --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 flex items-center space-x-4">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path
                        d="M14 14.76V5a2 2 0 10-4 0v9.76A5 5 0 1014 14.76z" />
                </svg>
                <div>
                    <div class="text-lg dark:text-gray-200 font-semibold">Temperatura</div>
                    <div class="text-2xl text-gray-800 dark:text-gray-200">{{ $temperatura }}°C</div>
                </div>
            </div>

            {{-- Card: Fecha --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 flex items-center space-x-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path
                        d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
                <div>
                    <div class="text-lg dark:text-gray-200 font-semibold">Fecha</div>
                    <div class="text-2xl text-gray-800 dark:text-gray-200">{{ $date->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Cambios del día</h3>
                <canvas id="graficoDia" class="w-full h-auto"></canvas>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch("{{ route('dashboard.datos') }}")
                .then(res => res.json())
                .then(data => {
                    const labels = data.map(d => new Date(d.created_at).toLocaleTimeString());
                    const temperatura = data.map(d => d.temperatura);
                    const humedad = data.map(d => d.humedad);
                    const uv = data.map(d => d.uv);

                    const ctx = document.getElementById('graficoDia').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Humedad (%)',
                                    data: humedad,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    fill: false
                                },
                                {
                                    label: 'Radiación UV',
                                    data: uv,
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    fill: false
                                },
                                {
                                    label: 'Temperatura (°C)',
                                    data: temperatura,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    fill: false
                                },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });

        @if(session()->has('success'))
            setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                location.reload();
            });
            }, 3000);
        @endif
    </script>

</x-app-layout>
