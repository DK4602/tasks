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

   
        <div class="flex items-center justify-end mx-4 my-5">
            <button command='show-modal' commandfor='dialog'
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow-md transition-all duration-300 ease-in-out hover:scale-105">
                + Add Task
            </button>
        </div>    
          
    <div class="overflow-hidden rounded-xl m-5 border border-gray-300 shadow-lg bg-white">
        
    <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-gray-100 border-b border-gray-300">
            <tr class="text-left text-gray-800 font-semibold">
                <th class="py-3 px-5">Task Name</th>
                <th class="py-3 px-5">Description</th>
                <th class="py-3 px-5">Project Name</th>
                <th class="py-3 px-5">Start Date</th>
                <th class="py-3 px-5">End Date</th>
                <th class="py-3 px-5">Task Status</th>
                <th colspan="2" class="py-3 px-5 text-center">Action</th>
               
                
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($data as $task)

                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="py-3 px-5 font-medium text-blue-600">
                        {{ $task->task_name }}
                    </td>
                    <td class="py-3 px-5 truncate max-w-sm">{{ $task->task_description }}</td>
                    <td class="py-3 px-5 truncate max-w-sm">{{ $task->project->project_name }}</td>
                    <td class="py-3 px-5">{{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}</td>
                    <td class="py-3 px-5">{{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}</td>
                    <td class="py-3 px-5">
                        @if ($task->status == 'completed')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-400">Completed</span>
                    @elseif($task->status == 'in_progress')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-400">In Progress</span>
                    @elseif($task->status == 'pending')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-400">Pending</span>
                    @endif  
                    </td>
                        <td class="py-3 px-5 text-center">
                        <button command="show-modal" commandfor="dialog({{ $task->id }})" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-full">
                            Edit
                        </button>
                    </td>
                        <td class="py-3 px-5 text-center">
                        <form action="{{ Route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-full">
                            Delete
                        </button>
                        </form>
                    </td>
                    
                </tr>
                 <el-dialog>
                    <dialog id="dialog({{ $task->id }})" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                        <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                        <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                        <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="flex justify-between items-center border-b border-gray-700 px-6 py-4 mb-4">
                            <h2 id="dialog-title" class="text-xl font-semibold text-white">Edit Task</h2>
                            <button type="button" command="close" commandfor="dialog({{ $task->id }})" id="closeDialog" class="text-gray-400 hover:text-white text-2xl">&times;</button>
                        </div>
                       
                            <form action="{{ route('tasks.update', ['task' => $task->id]) }}" method="post" id="editForm" class="flex flex-col space-y-4 px-6" >
                                @csrf
                                @method('PATCH')
                                <!-- Task Name -->
                                <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                                <div class="flex flex-col">
                                    <label for="task_name" class="text-white text-lg mb-2">Task Name :</label>
                                    <input 
                                        type="text" 
                                        name="task_name" 
                                        id="task_name" 
                                        class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        placeholder="Enter Task name"
                                        value="{{ $task->task_name }}"
                                    >
                                </div>

                                <!-- Task Description -->
                                <div class="flex flex-col">
                                    <label for="task_description" class="text-white text-lg mb-2">Task Description :</label>
                                    <textarea 
                                        name="task_description" 
                                        id="task_description" 
                                        rows="3"
                                        placeholder="Enter Task description"
                                        class="bg-gray-700 text-white rounded-lg w-full min-h-8 p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    >{{$task->task_description}}</textarea>
                                </div>
                                <div class="flex flex-col">
                                    <label for="deadline" class="text-white text-lg mb-2">Start Date :</label>
                                    <input 
                                        type="date" 
                                        name="start_date" 
                                        id="start_date" 
                                        rows="3"
                                        placeholder="Enter Task description"
                                        class="bg-gray-700 text-white rounded-lg min-h-8 w-full p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        value="{{ $task->start_date }}"
                                    ></input>
                                </div>
                                <div class="flex flex-col">
                                    <label for="deadline" class="text-white text-lg mb-2">End Date :</label>
                                    <input 
                                        type="date" 
                                        name="end_date" 
                                        id="end_date" 
                                        rows="3"
                                        placeholder="Enter Task description"
                                        class="bg-gray-700 text-white rounded-lg min-h-8 w-full p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        value="{{ $task->end_date }}"
                                    ></input>
                                </div>
                                <div class="flex flex-col">
                                    <label for="employee_id" class="text-white text-lg mb-2">Project :</label>
                                    <select 
                                    name="status" 
                                        id="employee_id" 
                                        class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                        focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            <option value="" >Selete Status</option>
                                            <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
                                            <option value="in_progress" {{ $task->status=='in_progress'?'selected':'' }}>In Progress</option>
                                            <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
                                        </select>
                                </div>
                                
                                <div class="flex flex-col">
                                    <button type="submit" class="py-3 px-6 mt-8 text-lg rounded-full font-bold hover:bg-blue-500 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-green-300 active:scale-95 transition duration-200 ease-in-out bg-green-500 text-gray-200 border border-gray-600">Edit Task</button>
                                </div>
                            </form>
                                <div class="flex justify-end mt-10 pt-5 border-t border-gray-600">
                                <button command="close" commandfor="dialog({{ $task->id }})" class="py-3 px-6 text-lg rounded-full bg-gray-600 hover:bg-gray-700 text-gray-200 border border-gray-600">CLOSE</button>
                                </div> 
                            </div>
                        </div>
                        </el-dialog-panel>
                    </dialog>
                </el-dialog>
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
     <el-dialog>
        <dialog id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center border-b border-gray-700 px-6 py-4 mb-4">
                <h2 id="dialog-title" class="text-xl font-semibold text-white">Add Task</h2>
                <button type="button" command="close" commandfor="dialog" id="closeDialog" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            
                <form action="{{ route('tasks.store') }}" method="post" id="editForm" class="flex flex-col space-y-4 px-6" >
                    @csrf
                    @method('POST')
                    <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">
                    <!-- Task Name -->
                    <div class="flex flex-col">
                        <label for="task_name" class="text-white text-lg mb-2">Task Name :</label>
                        <input 
                            type="text" 
                            name="task_name" 
                            id="task_name" 
                            class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter Task name"
                        >
                    </div>

                    <!-- Task Description -->
                    <div class="flex flex-col">
                        <label for="task_description" class="text-white text-lg mb-2">Task Description :</label>
                        <textarea 
                            name="task_description" 
                            id="task_description" 
                            rows="3"
                            placeholder="Enter Task description"
                            class="bg-gray-700 text-white rounded-lg w-full min-h-8 p-2 border border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        ></textarea>
                    </div>
                    <div class="flex flex-col">
                        <label for="employee_id" class="text-white text-lg mb-2">Project :</label>
                        <select 
                        name="project_id" 
                            id="employee_id" 
                            class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                            focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="" >Selete Project</option>
                                @foreach ($project as $project)
                                <option value="{{$project->id}}" >{{$project->project_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="deadline" class="text-white text-lg mb-2">Start Date :</label>
                        <input 
                        type="date" 
                        name="start_date" 
                        id="start_date" 
                            rows="3"
                            placeholder="Enter Task description"
                            class="bg-gray-700 text-white rounded-lg min-h-8 w-full p-2 border border-gray-600 
                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            
                            ></input>
                            <div class="flex flex-col">
                        <label for="deadline" class="text-white text-lg mb-2">End Date :</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            rows="3"
                            placeholder="Enter Task description"
                            class="bg-gray-700 text-white rounded-lg min-h-8 w-full p-2 border border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:outline-none"></input>
                    </div>
            
                        <div class="flex flex-col">
                            <label for="employee_id" class="text-white text-lg mb-2">Project :</label>
                            <select 
                                name="status" 
                                id="employee_id" 
                                class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                    focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <option value="" >Selete Status</option>
                                    <option value="pending" >Pending</option>
                                    <option value="in_progress" >In Progress</option>
                                    <option value="completed" >Completed</option>
                            </select>
                        </div>
                        
                        <div class="flex flex-col">
                            <button type="submit" class="py-3 px-6 mt-8 text-lg rounded-full font-bold hover:bg-blue-500 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-green-300 active:scale-95 transition duration-200 ease-in-out bg-green-500 text-gray-200 border border-gray-600">Add Task</button>
                        </div>
                    </form>
                    <div class="flex justify-end mt-10 pt-5 border-t border-gray-600">
                        <button command="close" commandfor="dialog" class="py-3 px-6 text-lg rounded-full bg-gray-600 hover:bg-gray-700 text-gray-200 border border-gray-600">CLOSE</button>
                    </div> 
                </div>
            </div>
            </el-dialog-panel>
        </dialog>
    </el-dialog>
</x-app-layout>
