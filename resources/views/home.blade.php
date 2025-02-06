<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app2')


@section('content')
    <div class="flex md:justify-evenly items-center bg-gray-300 shadow rounded-lg flex-col md:flex-row max-w-full md:h-full gap-6">
        <!-- Bagian Kiri: Informasi Perusahaan dan Pengguna -->
        <div class="text-center  flex items-center justify-center flex-col gap-2 ">
            <h1 class="md:text-xl lg:text-2xl font-bold">PT SINAR GALESONG PRATAMA</h1>
            <h2 class="md:text-md lg:text-xl font-bold">Departemen <i>Accounting</i></h2>
            <div class="w-24  md:h-[163px] md:w-[153px] lg:h-[213px] lg:w-[203px] overflow-hidden flex items-center justify-center rounded-md">
                <img src="assets/logo/galesong.png" class="w-full h-full object-contain" alt="Foto Profile">
            </div>
            
            {{-- <p class="italic text-gray-500">Departemen <span class="not-italic font-bold">{{ $user->departemen }}</span></p>
            <!-- Gambar Profil -->
            <div class="mt-4">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Picture"
                    class="w-32 h-32 rounded-full mx-auto">
            </div>
            <p class="mt-4">Hai, <span class="text-blue-500">{{ $user->name }}</span>!</p> --}}
            <h2 class="text-md font-bold lg:text-xl">Hai <i>Username!</i></h2>
        </div>

        <!-- Bagian Kanan: Tanggal dan Tabel Umur Piutang -->
        <div class="text-right">
            <!-- Tanggal -->
            <p class="text-gray-600">{{ $currentDate }}</p>

            <!-- Tabel Umur Piutang -->
            <div class="">
                <h2 class="text-lg font-bold mb-2">Umur Piutang</h2>
                <table class=" bg-gray-500 border border-gray-200">
                    <thead class="">
                        <tr>
                            <th class="border border-gray-200 px-4 py-2 text-white">No</th>
                            <th class="border border-gray-200 px-4 py-2 text-white">Aging</th>
                            <th class="border border-gray-200 px-4 py-2 text-white">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summaryData as $row)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2 text-center">{{ $row['no'] }}</td>
                                <td class="border border-gray-200 px-4 py-2 text-center">{{ $row['aging'] }}</td>
                                <td class="border border-gray-200 px-4 py-2 text-center">
                                    {{ 'Rp' . number_format($row['total'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <button class="active:scale-[.95] hover:bg-white hover:text-[#] transition-all text-white border-2 bg-red-700 hover:text-red-700 border-red-700 font-bold py-1 px-4 rounded-md shadow-sm mt-4">
                    Konfirmasi
                </button>

            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')

@vite('resources/js/test.js')
@endpush --}}
