<x-app-layout>
    <div class="flex justify-end mt-5 mx-8">
        <button command="show-modal" commandfor="dialog" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-full text-xl">
            Add Client
        </button>
    </div>


    <div class="py-8 px-8 flex justify-center">
        <div class="overflow-hidden rounded-xl border border-black shadow-md min-w-full">
            <table class=" min-w-full text-sm text-gray-700">
        <thead class="bg-gray-100 border-b border-gray-300">
            <tr class="text-left text-gray-800 font-semibold">
                <th class="py-3 px-5">Client Name</th>
                <th class="py-3 px-5">Client Email</th>
                <th class="py-3 px-5">Client Projects</th>
                <th class="py-3 px-5">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($data as $client)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="py-3 px-5 font-medium text-blue-600">
                        <a href="{{ Route('projects.show', $client->id) }}" class="hover:underline">
                            {{ $client->name }}
                        </a>
                    </td>
                    <td class="py-3 px-5 truncate max-w-xs">{{ $client->email }}</td>
                    <td class=" py-3 px-5 truncate max-w-xs">{{ count($client->projectsByClient) }}</td>
                    <td class="py-3 px-5 text-center">
                        <button command="show-modal" commandfor="dialog({{ $client->id }})" class="bg-blue-500 hover:bg-blue-600 flex justify-center text-white text-sm font-semibold py-2 px-4 rounded-full">
                            Edit
                        </button>
                    </td>
                </tr>
                <el-dialog>
                    <dialog id="dialog({{ $client->id }})" aria-labelledby="dialog-title"
                        class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                        <el-dialog-backdrop
                            class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                        <div tabindex="0"
                            class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                            <el-dialog-panel
                                class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div
                                        class="flex justify-between items-center border-b border-gray-700 px-6 py-4 mb-4">
                                        <h2 id="dialog-title" class="text-xl font-semibold text-white">Edit Client
                                        </h2>
                                        <button type="button" command="close"
                                            commandfor="dialog({{ $client->id }})" id="closeDialog"
                                            class="text-gray-400 hover:text-white text-2xl">&times;</button>
                                    </div>
                                    <form action="{{ route('clients.update', $client->id) }}" method="post"
                                        id="editForm" class="flex flex-col space-y-4 px-6">
                                        @csrf
                                        @method('PATCH')
                                        <!-- employee Name -->
                                        <div class="flex flex-col">
                                            <label for="employee_name" class="text-white text-lg mb-2">Client Name
                                                :</label>
                                            <input type="text" name="name" id="employee_name"
                                                class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                                placeholder="Enter Client name" value="{{ $client->name }}">
                                        </div>

                                        <!-- employee Description -->
                                        <div class="flex flex-col">
                                            <label for="employee_name" class="text-white text-lg mb-2">Client Email
                                                :</label>
                                            <input type="text" name="email" id="employee_name"
                                                class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                            focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                                placeholder="Enter Client name" value="{{ $client->email }}">
                                        </div>

                                        <div class="flex flex-col">
                                            <button type="submit"
                                                class="py-3 px-6 mt-8 text-lg rounded-full font-bold hover:bg-blue-500 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-green-300 active:scale-95 transition duration-200 ease-in-out bg-green-500 text-gray-200 border border-gray-600">Edit
                                                Client</button>
                                        </div>
                                    </form>
                                    <div class="flex justify-end mt-10 pt-5 border-t border-gray-600">
                                        <button command="close" commandfor="dialog({{ $client->id }})"
                                            class="py-3 px-6 text-lg rounded-full bg-gray-600 hover:bg-gray-700 text-gray-200 border border-gray-600">CLOSE</button>
                                    </div>
                                </div>
                        </div>
                        </el-dialog-panel>
                    </dialog>
                </el-dialog>
            @endforeach
        </tbody>
    </table>
    <el-dialog>
        <dialog id="dialog" aria-labelledby="dialog-title"
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop
                class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0"
                class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel
                    class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div
                            class="flex justify-between items-center border-b border-gray-700 px-6 py-4 mb-4">
                            <h2 id="dialog-title" class="text-xl font-semibold text-white">Add Client
                            </h2>
                            <button type="button" command="close"
                                commandfor="dialog" id="closeDialog"
                                class="text-gray-400 hover:text-white text-2xl">&times;</button>
                        </div>
                        <form action="{{ route('register') }}" method="post"
                            id="editForm" class="flex flex-col space-y-4 px-6">
                            @csrf
                            @method('POST')
                            <!-- employee Name -->
                            <input type="hidden" name="role" value="client">
                            <div class="flex flex-col">
                                <label for="employee_name" class="text-white text-lg mb-2">Client Name
                                    :</label>
                                <input type="text" name="name" id="employee_name"
                                    class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter Client name" >
                            </div>

                            <!-- employee Description -->
                            <div class="flex flex-col">
                                <label for="employee_name" class="text-white text-lg mb-2">Client Email
                                    :</label>
                                <input type="text" name="email" id="employee_name"
                                    class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter Client email" >
                            </div>
                            <div class="flex flex-col">
                                <label for="password" class="text-white text-lg mb-2">Password
                                    :</label>
                                <input type="password" name="password" id="employee_name"
                                    class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter Password" required autocomplete="new-password" >
                            </div>
                            <div class="flex flex-col">
                                <label for="password" class="text-white text-lg mb-2">Confirm Password
                                    :</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="bg-gray-700 text-white rounded-lg w-full p-2 border border-gray-600 
                                    focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter Password" required autocomplete="new-password" >
                            </div>

                            <div class="flex flex-col">
                                <button type="submit"
                                    class="py-3 px-6 mt-8 text-lg rounded-full font-bold hover:bg-blue-500 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-green-300 active:scale-95 transition duration-200 ease-in-out bg-green-500 text-gray-200 border border-gray-600">Add
                                    Client</button>
                            </div>
                        </form>
                        <div class="flex justify-end mt-10 pt-5 border-t border-gray-600">
                            <button command="close" commandfor="dialog"
                                class="py-3 px-6 text-lg rounded-full bg-gray-600 hover:bg-gray-700 text-gray-200 border border-gray-600">CLOSE</button>
                        </div>
                    </div>
            </div>
            </el-dialog-panel>
        </dialog>
    </el-dialog>
        </div>
      
</x-app-layout>
