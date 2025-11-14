<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-lg rounded-xl p-10 text-center border border-gray-200">
            <h1 class="text-4xl font-bold text-red-600 mb-4">403 - Unauthorized</h1>
            <p class="text-gray-700 text-lg mb-6">
                Sorry, you don’t have permission to access this page.
            </p>

            <div class="flex gap-4">
                <a href="{{ url()->previous() }}"
                   class="px-5 py-2 rounded-full bg-gray-600 hover:bg-gray-700 text-white font-semibold transition">
                    ← Go Back
                </a>
                <a href="{{ route('dashboard') }}"
                   class="px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
