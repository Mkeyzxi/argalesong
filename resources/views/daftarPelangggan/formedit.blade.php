@extends('layouts.app')

@section('content')

    <div class="bg-gray-100 w-full p-5 mt-10">

        <!-- Bagian Pencarian dan Tombol Baru -->
        <div class="flex justify-between items-center mb-4 flex-wrap">
            
            <form id="filterForm" action="{{ route('customer.index') }}" method="GET" class="w-full max-w-sm flex space-x-4">
                <div class="">
                    <label for="idcompany" class="mr-2 text-xl text-gray-700 font-bold">Pilih Group:</label>
                    <input list="groupList" name="idcompany" id="idcompany"
                        class="border border-gray-300 py-2 px-4 rounded-md w-full sm:w-96" placeholder="Search group..."
                        value="{{ request('idcompany') }}">
                    <datalist id="groupList">
                        <option value="">-- Semua Group --</option>
                        @foreach ($perusahaan as $group)
                            <option value="{{ $group->company_id }}">
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </datalist>
                </div>
                
            </form>
            <form id="searchForm" action="{{ route('customer.index') }}" method="GET" class="w-full flex gap-2 mb-6">
                <input type="text" name="search" id="search" placeholder="Cari berdasarkan kode atau nama pelanggan"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2"
                    value="{{ request('search') }}">
                <button type="submit"
                    class="active:scale-[.95] hover:bg-white hover:text-[#3D5AD0] transition-all font-medium text-white border-2 border-[#3D5AD0] rounded-md shadow-sm px-4 py-1 bg-[#3D5AD0]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                    </svg>
                </button>
            </form>
            <div class="flex justify-end w-full items-end">
                <a href="{{ route('customer.create') }}"
                    class="bg-green-500 justify-items-end text-white font-bold py-2 px-5 lg:py-2 lg:px-7 rounded-md">
                    Baru
                </a>
            </div>

        </div>
        
        <div>
            <h1 class="text-2xl font-bold mb-4">DAFTAR PELANGGAN</h1>
        </div>
        @if (isset($customer))
            <div class="bg-white border border-gray-400 p-4 rounded-md">
                <div class="flex justify-between items-center border-b border-gray-400 gap-4">
                    <div class="flex flex-col items-start justify-center md:flex-row">
                        <h2 class="text-xl font-bold">{{ $customer->id_Pelanggan }}</h2>
                        <h2 class="text-xl font-bold bg-slate-900">{{ $customer->name }}</h2>
                    </div>
                    <div class="flex space-x-2 ml-auto z-1">
                        <a href="{{ route('customer.edit', $customer->id) }}"><button
                                class="bg-green-700 text-black font-bold py-1 px-3 rounded-md">Edit Data</button></a>
                        <button class="bg-red-600 text-black font-bold py-1 px-3 rounded-md">Hapus</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Tipe Pelanggan :</strong> {{ $tipePelangganName }}</p>
                        <p><strong>NPWP :</strong> {{ $customer->npwp }}</p>
                        <p><strong>Alamat :</strong> {{ $customer->alamat }}</p>
                        <p><strong>E-mail :</strong> {{ $customer->email }}</p>
                        <p><strong>Whatsapp :</strong> {{ $customer->whatsapp }}</p>
                        <p><strong>Telepon :</strong> {{ $customer->telepon }}</p>
                        <p><strong>Fax :</strong> {{ $customer->fax }}</p>
                    </div>
                    <div>
                        <p><strong>% Sharing :</strong> {{ $customer->sharing }}%</p>
                        <p><strong>Kota :</strong> {{ $customer->kota }}</p>
                        <p><strong>Kode Pos :</strong> {{ $customer->kode_pos }}</p>
                    </div>
                </div>
            </div>
        @else
            @foreach ($daftarPelanggan as $pelanggan)
                <div class="bg-white shadow-sm p-4 rounded-md mb-5">
                    <div class="flex justify-between items-center border-b border-gray-600 opacity-95 gap-1">
                        <div class="gap-2 flex flex-col items-start justify-center  md:flex-row">
                            <h2 class="text-xl font-bold md:m-5">{{ $pelanggan->id_Pelanggan }}</h2>
                            <h2 class="text-lg md:text-xl font-bold md:m-5">{{ $pelanggan->name }}</h2>
                        </div>
                        <hr class="">
                        <div class="flex space-x-2 ml-auto">
                            <a href="{{ route('customer.edit', $pelanggan->id) }}"
                                class="p-2 bg-green-700 h-full text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <rect width="24" height="24" fill="none" />
                                    <g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path
                                            d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.1 2.1 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621" />
                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
                                    </g>
                                </svg>
                            </a>
                            
                            {{-- <button class="p-2 bg-red-600 text-white rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button> --}}
                            {{-- <form action="{{ route('customer.destroy', $pelanggan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan {{ $pelanggan->company->name }} ini?');"> --}}
                            <form action="{{ route('customer.destroy', $pelanggan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('apakah anda ingin menghapus pelanggan {{ $pelanggan->name }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-600 text-white rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <div>
                            <p><strong>Perusahaan :</strong> {{ $pelanggan->company->name }}</p>
                            <p><strong>Tipe Pelanggan :</strong> {{ $pelanggan->tipePelanggan->name }}</p>
                            <p><strong>NPWP :</strong> {{ $pelanggan->npwp }}</p>
                            <p><strong>Alamat :</strong> {{ $pelanggan->alamat }}</p>
                            <p><strong>E-mail :</strong> {{ $pelanggan->email }}</p>
                            <p><strong>Whatsapp :</strong> {{ $pelanggan->whatsapp }}</p>
                            <p><strong>Telepon :</strong> {{ $pelanggan->telepon }}</p>
                            <p><strong>Fax :</strong> {{ $pelanggan->fax }}</p>
                        </div>
                        <div>
                            <p><strong>% Sharing :</strong> {{ $pelanggan->sharing }}%</p>
                            <p><strong>Kota :</strong> {{ $pelanggan->kota }}</p>
                            <p><strong>Kode Pos :</strong> {{ $pelanggan->kode_pos }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- Paginate  --}}
            {{-- <div>{{ $daftarPelanggan->links() }}</div>  --}}
        @endif
    </div>

@endsection

@push('scripts')
    @vite('resources/js/form-edit.js')
    
@endpush


@push('scripts')
    <script type="module">
        import {
            createIcons,
            icons
        } from 'lucide';
        createIcons({
            icons
        });
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
@endpush

