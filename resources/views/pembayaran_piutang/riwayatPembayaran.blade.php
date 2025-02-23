@extends('layouts.app')

@section('content')
    <div class="container mx-auto bg-white rounded-lg shadow-md m-10 mt-14 lg:mt-20">
        <div class="md:py-10 px-2 md:px-6">
            <!-- Form Filter -->
            <form method="GET" id="filterForm" action="{{ route('riwayatPembayaran') }}"
                class="mb-6 flex gap-2 flex-col lg:flex-row w-full justify-center items-end">
                <div class="w-full">
                    <label for="idcompany" class="mr-2 text-gray-700 font-bold">Pilih Perusahaan:</label>
                    <input list="groupList" name="idcompany" id="idcompany"
                        class="border border-gray-300 p-2 rounded-md w-full " 
                        {{-- placeholder="Search group..." value="{{ request('idcompany') }}" onChange="submitChange(e)"> --}}
                        placeholder="Search group..." value="{{ request('idcompany') }}" onChange="form.submit();" >
                    <datalist id="groupList">
                        <option value="">-- Semua Group --</option>
                        @foreach ($perusahaan as $group)
                            <option value="{{ $group->company_id }}">{{ $group->name }}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="flex flex-row items-center justify-center gap-3 w-full">
                    <input type="text" name="search" id="search-riwayat-pembayaran"
                        placeholder="Cari berdasarkan nama pelanggan"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2"
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="active:scale-[.95] hover:bg-white hover:text-[#3D5AD0] transition-all font-medium text-white border-2 border-[#3D5AD0] rounded-md shadow-sm px-4 py-1 bg-[#3D5AD0]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" />
                        </svg>
                    </button>
                </div>
            </form>
            <!-- Judul Halaman -->
            <h1 class="text-xl font-bold mb-4">Halaman Riwayat Pembayaran Piutang</h1>

            <!-- Tabel Data (Desktop) -->
            <div class="hidden md:block">
                <div class="w-full md:overflow-x-auto">
                    <table
                        class="min-w-full table-fixed text-[10px] sm:text-xs md:text-md lg:!text-lg bg-white border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-1 py-3 md:px-4 border border-gray-300">ID Pembayaran</th>
                                <th class="px-1 py-3 md:px-4 border border-gray-300 w-48">Nama Pelanggan</th>
                                <th class="px-1 py-3 hidden sm:table-cell md:px-4 border border-gray-300">Mode Pembayaran
                                </th>
                                <th class="px-1 py-3 md:px-4 border border-gray-300 w-48">Total Semua Piutang</th>
                                <th class="px-1 py-3 hidden sm:table-cell md:px-4 border border-gray-300 w-48">Nominal yang
                                    Dibayar</th>
                                <th class="px-1 py-3 hidden sm:table-cell md:px-4 border border-gray-300 w-48">Sisa</th>
                                <th class="sm:hidden px-1 py-2 md:px-4 md:py-2 border border-gray-300 w-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPembayaran as $riwayat)
                                <tr class="hover:bg-gray-100 cursor-pointer"
                                    onclick="window.location='{{ route('riwayatPembayaran.detail', $riwayat->IDPembayaran) }}'">
                                    <td class="px-1 py-3 md:px-4 border border-gray-300 font-semibold truncate">
                                        {{ $riwayat->IDPembayaran }}</td>
                                    <td
                                        class="px-1 py-3 text-[8px] sm:text-xs md:text-md md:px-4 lg:text-lg border border-gray-300 truncate">
                                        {{ $riwayat->NamaPelanggan }}</td>
                                    <td class="px-1 py-3 hidden sm:table-cell md:px-4 border border-gray-300 truncate">
                                        {{ $riwayat->ModePembayaran }}</td>
                                    <td
                                        class="px-1 py-3 text-[8px] sm:text-xs md:text-md md:px-4 lg:text-lg border border-gray-300 text-right truncate">
                                        Rp{{ number_format($riwayat->TotalSemuaPiutang, 0, ',', '.') }}</td>
                                    <td
                                        class="px-1 py-3 md:px-4 hidden sm:table-cell border border-gray-300 text-right truncate">
                                        Rp{{ number_format($riwayat->NominalyangDibayar, 0, ',', '.') }}</td>
                                    <td
                                        class="px-1 py-3 hidden sm:table-cell md:px-4 border border-gray-300 text-right truncate">
                                        Rp{{ number_format($riwayat->Sisa, 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="sm:hidden px-1 py-2 md:px-4 md:py-2 border border-gray-300 text-blue-500 hover:underline truncate">
                                        <a href="#">
                                            <div class="sm:hidden w-3 mx-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                                    <path fill="#2196f3"
                                                        d="M17.1 5L14 8.1L29.9 24L14 39.9l3.1 3.1L36 24z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-1 py-2 md:px-4 md:py-2 border border-gray-300 text-center text-gray-500">
                                        Tidak ada data riwayat pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Data (Mobile) -->
            <div class="block md:hidden">
                <div class="space-y-4 pb-6">
                    @forelse ($riwayatPembayaran as $riwayat)
                        <a href="{{ route('riwayatPembayaran.detail', $riwayat->IDPembayaran) }}"
                            class="text-blue-500 hover:underline text-lg mt-2 block">
                            <div class="border-b border-gray-300 pb-4">
                                <div class="text-lg font-bold text-gray-700">{{ $riwayat->IDPembayaran }}</div>
                                <div class="text-sm text-gray-500">{{ $riwayat->NamaPelanggan }}</div>
                                <div class="text-sm text-gray-500">{{ $riwayat->ModePembayaran }}</div>
                                <div class="text-lg font-semibold text-gray-900">Total Piutang:
                                    Rp{{ number_format($riwayat->TotalSemuaPiutang, 0, ',', '.') }}</div>
                                <div class="text-lg text-gray-700">Nominal Dibayar:
                                    Rp{{ number_format($riwayat->NominalyangDibayar, 0, ',', '.') }}</div>
                                <div class="text-lg text-gray-700">Sisa: Rp{{ number_format($riwayat->Sisa, 0, ',', '.') }}
                                </div>
                        </a>
                </div>
            @empty
                <div class="text-center text-gray-500">Tidak ada data riwayat pembayaran.</div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        {{-- <div class="mt-4">
                {{ $riwayatPembayaran->appends(request()->query())->links() }}
            </div> --}}
    </div>
    </div>
@endsection

@push('script')
    @vite('resources/js/riwayat-pembayaran.js')
    {{-- @vite('resources/js/riwayat-riwayat-pembayaran.js') --}}
@endpush
