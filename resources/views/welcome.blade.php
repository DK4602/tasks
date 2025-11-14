<x-app-layout>
    @push('css')
        <style>
            @keyframes fadeOut {
                0% { opacity: 1; }
                80% { opacity: 1; }
                100% { opacity: 0; visibility: hidden; }
            }

            .animate-fade-out {
                animation: fadeOut 3s ease-in-out forwards;
            }
        </style>
    @endpush
    @if ($errors->any())
        <div 
            class="mx-5 mb-5 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700 animate-fade-out"
        >
            <h3 class="font-semibold text-lg mb-2">Please fix the following errors:</h3>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @can('is-admin')
        <div class="flex items-center justify-end mx-4 my-5">
            <a href="{{Route('projects.create')}}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow-md transition-all duration-300 ease-in-out hover:scale-105">
                + Add Project
            </button>
            </a>
        </div>    
    @endcan        
    {{-- @dd($data) --}}
    <div class="overflow-hidden rounded-xl m-5 border border-gray-300 shadow-lg bg-white">   
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr class="text-left text-gray-800 font-semibold">
                    <th class="py-3 px-5">Project Name</th>
                    <th class="py-3 px-5">Description</th>
                    <th class="py-3 px-5">Start Date</th>
                    <th class="py-3 px-5">End Date</th>
                    <th class="py-3 px-5">Task Status</th>
                    @canany(['is-admin','is-client'])
                        <th class="py-3 px-5">Employee</th>
                    @endcanany
                    @canany(['is-admin','is-employee'])
                    <th class="py-3 px-5">Client</th>
                    @endcanany
                    @can('is-admin')
                        <th colspan="2" class="py-3 px-5 text-center">Action</th>
                    @endcan
                    
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                
                @foreach ($data as $project)
                    @php
                        $pending = $project->tasks->where('status', 'pending')->count();
                        $completed = $project->tasks->where('status', 'completed')->count();
                        $in_progress = $project->tasks->where('status', 'in_progress')->count();
                    @endphp

                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="py-3 px-5 font-medium text-blue-600">
                            <a href="{{ Route('projects.show', $project->id) }}" class="hover:underline">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="py-3 px-5 truncate max-w-sm">{{ $project->project_description }}</td>
                        <td class="py-3 px-5">{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</td>
                        <td class="py-3 px-5">{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</td>
                        <td class="py-3 px-5">
                            <div class="flex flex-col space-y-1">
                                <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">Pending: {{ $pending }}</span>
                                <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">In Progress: {{ $in_progress }}</span>
                                <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">Completed: {{ $completed }}</span>
                            </div>
                        </td>
                        @canany(['is-admin', 'is-client'])
                            <td class="py-3 px-5">  <ul class="list-disc list-inside">
                                @foreach ($project->employees as $emp)
                                    <li>{{ $emp->name }}</li>
                                @endforeach
                            </ul></td>
                        @endcanany
                        @canany(['is-admin','is-employee'])
                            <td class="py-3 px-5">{{ $project->client->name }}</td>
                        @endcanany
                        @can('is-admin')
                            <td class="py-3 px-5 text-center">
                                <a href="{{Route('projects.edit',$project->id)}}"
                            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-full">
                                Edit
                            </button>
                        </td>
                            <td class="py-3 px-5 text-center">
                            <form action="{{ Route('projects.destroy', $project->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-full">
                                Delete
                            </button>
                            </form>
                        </td>
                        @endcan  
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-6 flex items-center justify-between bg-gray-50 px-5 py-3 border-t border-gray-200 text-gray-600 text-sm">
            <div>
                Showing
                <span class="font-semibold">{{ $data->firstItem() }}</span>
                to
                <span class="font-semibold">{{ $data->lastItem() }}</span>
                of
                <span class="font-semibold">{{ $data->total() }}</span>
                results
            </div>

            <div class="text-gray-700">
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
