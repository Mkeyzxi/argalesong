@extends('layouts.app')

@section('content')
    <div class="min-w-full flex flex-col justify-center lg:ml-10 mt-14 lg:mt-20">
        <div class="bg-white rounded-xl px-2 py-5 !container ">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('riwayatPiutang') }}" class="mb-6" id="filterForm">
                <label for="idcompany" class="mr-2 text-gray-700 font-bold">Pilih Group:</label>
                <input list="groupList" name="idcompany" id="idcompany" class="border border-gray-300 p-2 rounded-md w-full sm:w-1/2 lg:w-1/3 focus:outline-blue-600"
                    placeholder="Search group..." value="{{ request('idcompany') }}">
                <datalist id="groupList">
                    <option value="">-- Semua Group --</option>
                    @foreach ($perusahaan as $group)
                        <option value="{{ $group->company_id }}">{{ $group->name }}</option>
                    @endforeach
                </datalist>
            </form>

            <!-- Tabel Data -->
            <div class="">
                <h2 class="p-2 text-left text-xl font-bold">Halaman Riwayat Pengajuan Piutang</h2>

                <!-- Desktop View (Full Table) -->
                <div class="overflow-hidden md:overflow-x-auto hidden md:block">
                    <table class="min-w-full table-fixed border-collapse border border-gray-400 text-[10px] sm:text-xs md:text-[15px]">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-400 px-1 py-2">ID</th>
                                <th class="border border-gray-400 px-1 py-2">Jenis Piutang</th>
                                <th class="border border-gray-400 px-1 py-2">Tanggal Transaksi</th>
                                <th class="border border-gray-400 px-1 py-2">Jatuh Tempo</th>
                                <th class="border border-gray-400 px-1 py-2">Tipe Pelanggan</th>
                                <th class="border border-gray-400 px-1 py-2">Nama Pelanggan</th>
                                <th class="border border-gray-400 px-1 py-2">Jenis Tagihan</th>
                                <th class="border border-gray-400 px-1 py-2">DPP</th>
                                <th class="border border-gray-400 px-1 py-2">PPN</th>
                                <th class="border border-gray-400 px-1 py-2">PPH</th>
                                <th class="border border-gray-400 px-1 py-2">Total Piutang</th>
                                <th class="border border-gray-400 px-1 py-2">Dibuat Oleh</th>
                                <th class="border border-gray-400 px-1 py-2">Sisa</th>
                                <th class="border border-gray-400 px-1 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($piutang as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-400 px-1 py-3 md:py-2 truncate">
                                        <a href="{{ route('printriwayatPiutang', ['nomor_invoice' => $item->no_invoice]) }}">
                                            {{ $item->no_invoice }}
                                        </a>
                                    </td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2 truncate">{{ $item->tipepiutang }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2 truncate">{{ $item->tgltra }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ $item->tgl_jatuh_tempo }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ $item->tipe_pelanggan }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ $item->customer_name }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ $item->jenistagihan }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ number_format($item->dpp, 2) }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ number_format($item->ppn, 2) }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ number_format($item->pph, 2) }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ number_format($item->nominal, 2) }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ $item->created_by ?? 'GL' }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2">{{ number_format($item->tagihan, 2) }}</td>
                                    <td class="border border-gray-400 px-1 py-3 md:py-2 
                                        @if ($item->statusPembayaran == 'LUNAS') bg-green-500 text-white
                                        @elseif($item->statusPembayaran == 'SEBAGIAN') bg-yellow-500 text-white
                                        @else bg-red-500 text-white @endif">
                                        {{ $item->statusPembayaran }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="border border-gray-400 p-2 text-center text-gray-500">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View (Simplified Table) -->
                <div class="block md:hidden">
                    <div class="space-y-4 mb-10">
                        @forelse ($piutang as $item)
                        {{-- <a href="{{ route('detailpiutang.detail', ['customer_name' => $item->customer_name]) }}" class="text-blue-500 hover:underline text-lg mt-2 block"> --}}
                            <div class="border-b border-gray-300 bg-blue-100 pb-4 p-4">
                                <a href="{{ route('detail-piutang', ['noInvoice' => $item->no_invoice]) }}">


                                    <div class="block text-2x1 font-bold text-gray-700 mt-4">
                                        {{ $item->no_invoice }}
                                    </div>
                                    <div class="text-lg font-bold text-gray-500">{{ $item->customer_name }}</div>
                                    <div class="text-lg text-black">{{ $item->tipepiutang }}</div>
                                    <div class="text-lg text-black">{{ $item->tgltra }}</div>
                                    <div class="text-lg font-semibold text-gray-900">Total Piutang: Rp{{ number_format($item->nominal, 2) }}</div>
                            {{-- </a> --}}
                                    <div class="text-lg text-gray-700 mt-4">Status: 
                                        <span class="inline-block 
                                            @if ($item->statusPembayaran == 'LUNAS') bg-green-500 text-white
                                            @elseif($item->statusPembayaran == 'SEBAGIAN') bg-yellow-500 text-white
                                            @else bg-red-500 text-white @endif 
                                            px-2 py-1 rounded">
                                            {{ $item->statusPembayaran }}
                                        </span>
                                    </div>
                                </a>
                                
                            </div>
                        @empty
                            <div class="text-center text-gray-500">Data tidak ditemukan.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $piutang->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@vite('resources/js/riwayat-piutang.js') 
@endpush
