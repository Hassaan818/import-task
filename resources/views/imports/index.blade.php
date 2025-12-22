<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Records
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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



            <!-- Records Table -->
            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2">ID</th>
                            <th class="px-2 py-2">User</th>
                            <th class="px-2 py-2">Source</th>
                            <th class="px-2 py-2">File Id</th>
                            <th class="px-2 py-2">Sheet Id</th>
                            <th class="px-2 py-2">Total Rows</th>
                            <th class="px-2 py-2">Processed Rows</th>
                            <th class="px-2 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $import)
                        <tr>
                            <td class="px-2 py-2">{{ $import->id }}</td>
                            <td class="px-2 py-2">{{ $import->user->name }}</td>
                            <td class="px-2 py-2">{{ $import->source }}</td>
                            <td class="px-2 py-2">{{ $import->file_id }}</td>
                            <td class="px-2 py-2">{{ $import->sheet_id }}</td>
                            <td class="px-2 py-2">{{ $import->total_rows }}</td>
                            <td class="px-2 py-2">{{ $import->processed_rows }}</td>
                            <td class="px-2 py-2">{{ $import->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>