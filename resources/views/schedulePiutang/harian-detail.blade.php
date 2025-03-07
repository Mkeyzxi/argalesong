@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden lg:mt-20 mt-10">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">Halaman Detail Harian</h1>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Piutang</label>
                <div class="w-full border-gray-300 font-bold rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                    {{ $data->kodepiutang }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                        {{ $data->customer_name }}
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                        {{ $data->tgl_jatuh_tempo }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Piutang</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                        Rp{{ number_format($data->total_piutang, 2, ',', '.') }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Pembayaran</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                        Rp{{ number_format($data->total_pembayaran, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Saldo Piutang</label>
                    <div class="w-full border-gray-300 rounded-md shadow-sm sm:text-sm text-lg p-2 bg-gray-100">
                        Rp{{ number_format($data->saldo_piutang, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="window.location.href='{{ route('sp-harian') }}'"
                    class="active:scale-[.95] flex flex-row items-center group justify-center gap-1 py-1 hover:bg-white hover:text-[#161616] transition-all text-white font-medium border-2 border-[#161616] rounded-md shadow-sm px-4 bg-[#161616]">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path fill="white" class="group-hover:fill-[#161616] transition-colors" d="m4 10l9 9l1.4-1.5L7 10l7.4-7.5L13 1z"/>
                        </svg>
                    </div>
                    <span>Kembali</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/test.js') 
@endpush
