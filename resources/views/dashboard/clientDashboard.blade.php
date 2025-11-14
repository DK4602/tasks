<x-app-layout>

   <div class="py-6 px-8 mt-3 rounded-xl shadow-lg flex items-center justify-between max-w-lg">
    <p class="text-2xl font-semibold tracking-wide">
        👋 Welcome, <span class="font-bold text-yellow-300">{{ Auth::user()->name }}</span>
    </p>
</div>

     <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
           
            
            <div class="min-h-screen bg-gradient-to-br from-gray-50 via-slate-100 to-gray-200 py-12 px-8">

                    <!-- Top Stats Section -->
                <div class="flex flex-wrap justify-around gap-5 mb-12">

                    <!-- Projects -->
                    <a href="{{ route('projects.index') }}" 
                    class="group transform hover:-translate-y-2 transition duration-300 ease-in-out">
                        <div class="bg-white border border-gray-200 shadow-md hover:shadow-xl rounded-2xl py-8 px-14 flex flex-col items-center justify-center text-center w-72">
                            <div class="flex items-center justify-center gap-5 mb-3">
                                <div class="bg-purple-100 p-3 rounded-xl">
                                    <x-heroicon-o-chart-bar class="w-12 h-12 text-purple-600" />
                                </div>
                                <span class="text-4xl font-bold text-gray-800">{{$data->projectsByClient->count()}}</span>
                            </div>
                            <div class="text-lg font-medium text-gray-600">Projects</div>
                        </div>
                    </a>

                    <!-- Tasks -->
                    <div class="group transform hover:-translate-y-2 transition duration-300 ease-in-out">
                        <div class="bg-white border border-gray-200 shadow-md hover:shadow-xl rounded-2xl py-8 px-14 flex flex-col items-center justify-center text-center w-72">
                            <div class="flex items-center justify-center gap-5 mb-3">
                                <div class="bg-orange-100 p-3 rounded-xl">
                                    <x-heroicon-o-numbered-list class="w-12 h-12 text-orange-600" />
                                </div>
                                <span class="text-4xl font-bold text-gray-800">{{$task->tasksByClient->count()}}</span>
                            </div>
                            <div class="text-lg font-medium text-gray-600">Tasks</div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="flex flex-wrap justify-center gap-10 shadow-md border border-gray-200 rounded-3xl py-10 bg-white">

                    <!-- User Chart -->
                    <div class="bg-gradient-to-br from-gray-50 via-white to-slate-50 rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition duration-300 p-6 flex flex-col items-center w-[450px]">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center border-b pb-3 w-full">Task Chart</h2>
                        {!! $chartTask->container() !!}
                    </div>

                </div>
               @push('scripts')
                 
                    {!! $chartTask->script() !!}
                @endpush
            </div>
        </div>
    </div>
</x-app-layout>
