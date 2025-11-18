{{-- @dd($task) --}}
<x-app-layout>
<div class="max-w-6xl mx-auto my-16 bg-white text-gray-800 rounded-2xl shadow-xl p-10 border border-gray-200 font-sans">
    <a href = "{{Route('projects.index')}}">
                <x-heroicon-o-arrow-left class="w-5 h-5" />Back to Projects
            </a>
    {{-- Header --}}
    <div class="text-center border-b border-gray-300 pb-6 mb-8">
        <h1 class="text-3xl font-extrabold tracking-wide text-gray-900">Project Overview</h1>
        <p class="text-gray-500 mt-2">Detailed information about the project and its related tasks</p>
    </div>

    {{-- Project Details --}}
    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-2xl font-semibold mb-4 border-b border-gray-300 pb-2 text-blue-700">Project Details</h2>
            <p class="mb-2"><span class="font-semibold">Name:</span> {{ $data->project_name }}</p>
            <p class="mb-2"><span class="font-semibold">Description:</span> {{ $data->project_description }}</p>
            <div class="flex justify-between">
            <p class="mb-2"><span class="font-semibold">Start Date:</span> {{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</p>
            <p class="mb-2"><span class="font-semibold">End Date:</span> {{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-2xl font-semibold mb-4 border-b border-gray-300 pb-2 text-blue-700">People</h2>
            <p class="mb-2"><span class="font-semibold">Employees:</span> 
                @forelse($data->employees as $employee)
                    {{ Str::ucfirst($employee->name) }}@if(!$loop->last) | @endif
                @empty
                    No Employees Found
                @endforelse
            </p>
            <p class="mb-2"><span class="font-semibold">Client:</span> {{ $data->client->name ?? "Client Not Found" }}</p>
        </div>
    </div>

    {{-- Task Section --}}
    <div class="mt-12 border-t border-gray-300 pt-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-700">Tasks</h2>

            @canany(['is-admin','is-employee'])
            <div class="flex items-center gap-3">
                <!-- Import Excel Button -->
                <form action="{{ route('tasks.import', $data->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    id="importForm">
                    @csrf
                    <input type="file" name="file" id="excelFile" 
                        accept=".xlsx,.xls,.csv" 
                        class="hidden" 
                        onchange="document.getElementById('importForm').submit()">
                    
                    <label for="excelFile" 
                        class="cursor-pointer bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full shadow-md transition-all duration-300 ease-in-out hover:scale-105">
                        📥 Import Tasks
                    </label>
                </form>

                <!-- Add Task Button -->
                <button command="show-modal" commandfor="dialog"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow-md transition-all duration-300 ease-in-out hover:scale-105">
                    + Add Task
                </button>
            </div>
            @endcanany
        </div>
        
        {{-- Task List --}}
        @forelse ($tasks as $task)
    
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-6 hover:border-blue-400 transition-all shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-xl font-semibold">{{ $task->task_name }}</h3>
                <span class="text-sm text-gray-500">Start Date: {{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}</span>
                <span class="text-sm text-gray-500">Due: {{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}</span>
            </div>

            <p class="text-gray-600 mb-4 text-sm">{{ $task->task_description }}</p>
                
                    <p class="text-gray-600 mb-4 text-sm font-medium">Assigned To: {{ Str::ucfirst($task->user?->name) }}</p>
                
            <div class="flex justify-between items-center">
                {{-- Status --}}
                <div>
                    @if ($task->status == 'completed')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-400">Completed</span>
                    @elseif($task->status == 'in_progress')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-400">In Progress</span>
                    @elseif($task->status == 'pending')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-400">Pending</span>
                    @endif
                </div>
                
                <div class="grid md:grid-cols-2 gap-5">
                {{-- Edit Button --}}
                    
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-md transition-all hover:scale-105">
                            Delete Task
                        </button>
                    </form>
                   
                    <button command="show-modal" commandfor="dialog({{$task->id}})"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-md transition-all hover:scale-105">
                        Edit Task
                    </button>
                  
                </div>
                
            </div>
        </div>

        {{-- Edit Modal --}}
        <el-dialog>
            <dialog id="dialog({{$task->id}})" aria-labelledby="dialog-title"
                class="fixed inset-0 overflow-y-auto bg-transparent backdrop:bg-transparent">
                <el-dialog-backdrop
                    class="fixed inset-0 bg-gray-900/60 transition-opacity data-closed:opacity-0"></el-dialog-backdrop>
                <div class="flex items-center justify-center min-h-full p-6">
                    <el-dialog-panel
                        class="bg-white rounded-2xl shadow-2xl border border-gray-300 max-w-2xl w-full transform transition-all">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-bold text-gray-800">Edit Task</h2>
                            <button type="button" command="close" commandfor="dialog({{$task->id}})"
                                class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('tasks.update', ['task' => $task->id]) }}" method="POST"
                            class="p-6 space-y-5">
                            @csrf
                            @method('PATCH') 
                            <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                            <div>
                                <label class="block text-gray-700 mb-1 font-medium">Task Name</label>
                                <input type="text" name="task_name" value="{{ $task->task_name }}"
                                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-gray-700 mb-1 font-medium">Description</label>
                                <textarea name="task_description" rows="4"
                                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $task->task_description }}</textarea>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-gray-700 mb-1 font-medium">Start Date</label>
                                    <input type="date" name="start_date" value="{{ $task->start_date }}"
                                        class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-1 font-medium">End Date</label>
                                    <input type="date" name="end_date" value="{{ $task->end_date }}"
                                        class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </div>
                            </div>
                                <div>
                                    <label class="block text-gray-700 mb-1 font-medium">Assign Employee</label>
                                    <select name="employee_id"
                                        class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        @foreach ($data->employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-1 font-medium">Status</label>
                                    <select name="status"
                                        class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status=='in_progress'?'selected':'' }}>In Progress</option>
                                        <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
                                    </select>
                                </div>
                            

                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button" command="close" commandfor="dialog({{$task->id}})"
                                    class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition-all">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
        @empty
            <p class="text-gray-500 italic">No tasks added yet.</p>
        @endforelse
    </div>
    <el-dialog>
        <dialog id="dialog" aria-labelledby="dialog-title"
            class="fixed inset-0 overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-900/60 transition-opacity data-closed:opacity-0"></el-dialog-backdrop>
            <div class="flex items-center justify-center min-h-full p-6">
                <el-dialog-panel
                    class="bg-white rounded-2xl shadow-2xl border border-gray-300 max-w-2xl w-full transform transition-all">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Edit Task</h2>
                        <button type="button" command="close" commandfor="dialog"
                            class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('tasks.store')}}" method="POST"
                        class="p-6 space-y-5">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="project_id" value="{{$data->id}}">
                        <div>
                            <label class="block text-gray-700 mb-1 font-medium">Task Name</label>
                            <input type="text" name="task_name"
                                class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1 font-medium">Description</label>
                            <textarea name="task_description" rows="4"
                                class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-gray-700 mb-1 font-medium">Start Date</label>
                                <input type="date" name="start_date"
                                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1 font-medium">End Date</label>
                                <input type="date" name="end_date"
                                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1 font-medium">Assign Employee</label>
                            <select name="employee_id"
                                class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                @foreach ($data->employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>              
                            <div>
                                <label class="block text-gray-700 mb-1 font-medium">Status</label>
                                <select name="status"
                                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        

                        <div class="flex justify-end mt-6 space-x-3">
                            <button type="button" command="close" commandfor="dialog"
                                class="px-4 py-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
</div>
</x-app-layout>
