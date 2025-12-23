<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Records
        </h2>
        <div class="text-end mb-4">
            <form action="{{ route('records.export') }}" method="POST" class="inline-block">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required
                    class="px-2 py-1 border rounded mr-2">
                <button type="submit" class="px-4 py-2 bg-black text-white rounded">
                    Export All Records
                </button>
            </form>
        </div>
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
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Product ID</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Vendor</th>
                            <th class="px-4 py-2">Barcode</th>
                            <th class="px-4 py-2">Status</th>
                            <!-- add more fields as needed -->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($records as $record)
                        <tr>
                            <td class="px-4 py-2">{{ $record->id }}</td>
                            <td class="px-4 py-2">{{ $record->product_id }}</td>
                            <td class="px-4 py-2">{{ $record->title }}</td>
                            <td class="px-4 py-2">{{ $record->vendor }}</td>
                            <td class="px-4 py-2">{{ $record->barcode }}</td>
                            <td class="px-4 py-2">{{ $record->status }}</td>
                            <!-- add more fields as needed -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $records->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>