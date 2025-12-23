<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import Records') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <!-- Success message -->
                @if(session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Import Form -->
                <form action="{{ route('records.import') }}" method="POST">
                    @csrf

                    <label class="block mb-2 font-medium">Select Source</label>
                    <select name="source" id="source" class="border p-2 mb-4 w-full">
                        <option value="sheet">Google Sheet</option>
                        <option value="drive">Google Drive File</option>
                    </select>

                    <input type="text" name="sheet_id" id="sheet_id" placeholder="Sheet ID" class="border p-2 mb-4 w-full">
                    <input type="text" name="file_id" id="file_id" placeholder="File ID" class="border p-2 mb-4 w-full">

                    <button type="submit" class="px-4 py-2 bg-black text-white border border-black rounded">Import CSV</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sourceSelect = document.getElementById('source');
            const sheetInput = document.getElementById('sheet_id');
            const fileInput = document.getElementById('file_id');

            function toggleInputs() {
                if (sourceSelect.value === 'sheet') {
                    sheetInput.style.display = 'block';
                    fileInput.style.display = 'none';
                } else {
                    sheetInput.style.display = 'none';
                    fileInput.style.display = 'block';
                }
            }

            sourceSelect.addEventListener('change', toggleInputs);
            toggleInputs(); // Initial toggle
        });
    </script>
</x-app-layout>