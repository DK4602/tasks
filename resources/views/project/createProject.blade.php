<x-app-layout>
    <div
        class="max-w-6xl mx-auto my-16 bg-white text-gray-800 rounded-2xl shadow-xl p-10 border border-gray-200 font-sans">
            <a href = "{{Route('projects.index')}}">
                <x-heroicon-o-arrow-left class="w-5 h-5" />Back to Projects
            </a>
        

        <div class="text-center border-b border-gray-300 pb-6 mb-8">
            <h1 class="text-3xl font-extrabold tracking-wide text-gray-900">Edit Project</h1>
        </div>
        <form action="{{ route('projects.store')}}" method="post" id="editForm"
            class="flex flex-col space-y-4 px-6">
            @csrf
            @method('POST')
            <div>
                <label class="block text-gray-700 text-lg mb-1 font-medium">Project Name</label>
                <input type="text" name="project_name"
                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('project_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-lg mb-1 font-medium">Project Description</label>
                <textarea name="project_description"
                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                    @error('project_description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-lg mb-1 font-medium">Start Date</label>
                <input type="date" name="start_date" 
                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-lg mb-1 font-medium">End Date</label>
                <input type="date" name="end_date" 
                    class="w-full bg-gray-100 text-gray-900 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                     @error('end_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div class="flex flex-col">
                <label class="block text-gray-700 text-lg mb-1 font-medium">Client: </label>
                <select name="client_id" id="employee_id"
                    class="bg-gray-100 text-gray-900 rounded-lg w-full p-2 border border-gray-600 
                        focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select Client</option>
                    @foreach ($client as $clients)
                        <option value="{{ $clients->id }}">
                            {{ $clients->name }}
                        </option>
                    @endforeach
                </select>
                 @error('client_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>
            
            <div>
                <label class="block text-gray-700 text-lg font-semibold mb-3">Assign Employees</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($employees as $emp)
                        <label
                            class="flex items-center space-x-2 bg-gray-50 border border-gray-300 rounded-lg p-2 cursor-pointer hover:bg-gray-100">
                            <input type="checkbox" name="employee_ids[]" value="{{ $emp->id }}"
                                class="text-blue-600 focus:ring-blue-500 rounded">
                            <span class="text-gray-800 text-sm font-medium">{{ $emp->name }}</span>
                        </label>
                    @endforeach
                </div>
                 @error('employee_ids')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add Project</button>
            </div>
        </form>
</x-app-layout>
