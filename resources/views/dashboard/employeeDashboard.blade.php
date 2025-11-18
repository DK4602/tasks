<x-app-layout>

    <!-- Welcome Header -->
    <div
        class="py-6 px-8 mt-5 ml-5 rounded-2xl 
                shadow-xl text-gray-800 max-w-xl">
        <p class="text-3xl font-semibold">
            👋 Welcome, <span class="font-bold text-yellow-300">{{ Auth::user()->name }}</span>
        </p>
    </div>

    <!-- Outer Container -->
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 
                py-12 px-10 m-10 rounded-3xl shadow-inner ">

        <div class="mx-auto sm:px-6 lg:px-8">

            <!-- Stats Section -->
            <div class="flex flex-wrap justify-center gap-10 mb-16">

                <!-- Projects Card -->
                <a href="{{ route('projects.index') }}"
                    class="group transform hover:-translate-y-2 transition duration-300">
                    <div
                        class="glass-card w-72 p-8 rounded-3xl shadow-xl border border-white/40 
                                bg-white/60 backdrop-blur-lg">
                        <div class="flex items-center gap-5 mb-4">
                            <div class="bg-purple-100 p-4 rounded-2xl shadow">
                                <x-heroicon-o-chart-bar class="w-12 h-12 text-purple-600" />
                            </div>
                            <span class="text-5xl font-bold text-gray-800">
                                {{ $data->projectsByEmployee->count() }}
                            </span>
                        </div>
                        <p class="text-xl text-gray-700 text-center font-semibold">Projects</p>
                    </div>
                </a>

                <!-- Tasks Card -->
                <a href="{{ route('tasks.index') }}"
                    class="group transform hover:-translate-y-2 transition duration-300">
                    <div
                        class="glass-card w-72 p-8 rounded-3xl shadow-xl border border-white/40 
                                bg-white/60 backdrop-blur-lg">
                        <div class="flex items-center gap-5 mb-4">
                            <div class="bg-orange-100 p-4 rounded-2xl shadow">
                                <x-heroicon-o-numbered-list class="w-12 h-12 text-orange-600" />
                            </div>
                            <span class="text-5xl font-bold text-gray-800">
                                {{ $task->tasksByEmployee->count() }}
                            </span>
                        </div>
                        <p class="text-xl text-gray-700 text-center font-semibold">Tasks</p>
                    </div>
                </a>

                <!-- Completed Percentage -->
                <div class="group transform hover:-translate-y-2 transition duration-300">
                    <div
                        class="glass-card w-72 p-8 rounded-3xl shadow-xl border border-white/40 
                                bg-white/60 backdrop-blur-lg">
                        <div class="flex items-center gap-5 mb-4">
                            <div class="bg-green-100 p-4 rounded-2xl shadow">
                                <x-heroicon-o-check-circle class="w-12 h-12 text-green-600" />
                            </div>
                            <span class="text-5xl font-bold text-gray-800">
                                {{ round($complete_percent) }}%
                            </span>
                        </div>
                        <p class="text-xl text-gray-700 text-center font-semibold">Task Completion</p>
                    </div>
                </div>

            </div>

            <!-- Chart Section -->
            <div class="flex justify-center mt-12">
                <div
                    class="bg-white rounded-3xl p-8 w-[500px] shadow-2xl border border-gray-100 hover:shadow-3xl 
                            transition duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b text-center">
                        Task Chart
                    </h2>
                    {!! $chartTask->container() !!}
                </div>
            </div>

            @push('scripts')
                {!! $chartTask->script() !!}
            @endpush

        </div>
    </div>

</x-app-layout>

<style>
    .glass-card {
        backdrop-filter: blur(14px);
    }
</style>
