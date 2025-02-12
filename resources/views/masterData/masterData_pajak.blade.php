<!-- resources/views/masterData/masterData_pajak.blade.php -->
@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 ml-9">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mx-auto mt-5 ml-9">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">MASTER DATA PAJAK</h1>
                <div class="text-sm">{{ \Carbon\Carbon::now()->format('l, d/m/Y \a\t H:i:s') }}</div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Existing Tax Entries Display -->
            <div class="mt-4">
                <div id="taxEntries">
                    @foreach ($data as $item)
                        <div class="grid grid-cols-6 gap-2 mb-4">
                            <p class="text-xl font-bold text-center">{{ $item->name }}</p>
                            <input type="text" class="border bg-slate-400 text-center w-28 p-2"
                                value="{{ intval($item->nilai) }}%" readonly>
                            <p class="text-lg font-bold text-center">Berlaku Sejak</p>
                            <p>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                            <div>
                                <form id="formfarm" action="{{ route('masterDataPajak.destroy', $item->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg class="h-5 w-5 fill-red-600 text-red-500 hover:scale-110 active:scale-90" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add New Tax Entry Form -->
                <form action="{{ route('masterDataPajak.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-4 gap-4 mb-4">
                        <input type="text" name="new_tax_name" class="border rounded p-2" placeholder="tambahkan baru"
                            required>
                        <input type="text" name="new_tax_value" class="border rounded p-2" placeholder="nilai (%)"
                            required>
                        <input type="date" name="new_tax_date" class="border rounded p-2" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center gap-5">
                        <button type="submit" class="active:scale-[.95] hover:bg-white hover:text-[#0F8114] transition-all text-white font-medium border-2 border-[#0F8114] rounded-md shadow-sm px-4 py-1 bg-[#0F8114]">Simpan</button>
                        <a href="{{ route('masterDataPajak.index') }}"
                            class="active:scale-[.95] hover:bg-white hover:text-[#] transition-all text-white border-2 bg-red-700 hover:text-red-700 border-red-700 py-1 px-4 rounded-md shadow-sm font-medium">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection