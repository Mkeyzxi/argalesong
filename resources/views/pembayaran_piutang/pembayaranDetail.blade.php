@extends('layouts.app')
@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden lg:mt-20 mt-10 ">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error!</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="p-6 ">
            <h1 class="text-2xl font-bold mb-6 ">PEMBAYARAN PIUTANG</h1>
            <form method="POST" action="{{ route('pembayaran-piutang.proses') }}" id="paymentForm"
                data-store-url="{{ route('pembayaran-piutang.store') }}">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-6">
                  <label for="nominal_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                  <input type="text" id="nominalDibayarDisplay"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                      placeholder="Nama">
                  <input type="number" name="nominal_dibayar" id="nominalDibayar" class="hidden"
                      value="">
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="mb-6">
                  <label for="nominal_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
                  <input type="text" id="tanggal transaksi"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                      placeholder="yy/dd/xx">
                  <input type="number" name="tanggaltransaksi" id="tanggaltransaksi" class="hidden"
                      value="">
                </div>
                <div class="mb-6">
                  <label for="nominal_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                  <input type="text" id="perusahaan"
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                      placeholder="perusahaan">
                  <input type="number" name="perusahaan" id="perusahaan" class="hidden"
                      value="">
                </div>
              </div>


                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nomor Invoice</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jatuh Tempo</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Piutang</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                    Diskon</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                    Denda</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                                    Total Piutang</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="invoice-container">
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>

                <!-- Fields for Total Piutang and Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="total_piutang" class="block text-sm font-medium text-gray-700 mb-1">Metode Bayar</label>
                        <input type="text" id="metodebayar"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                            placeholder="metode bayar" readonly>
                        <input type="number" name="total_piutang" class="hidden" value="#">
                    </div>

                    <div>
                        <label for="total_piutang" class="block text-sm font-medium text-gray-700 mb-1">Total Semua
                            Piutang</label>
                        <input type="text" id="total-piutang"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                            placeholder="Total Piutang" readonly>
                        <input type="number" name="total_piutang" class="hidden" value="{{ old('total_piutang') }}">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="nominal_dibayar" class="text-2xl font-bold mb-4">Nominal yang
                        Dibayar</label>
                    <input type="text" id="nominalDibayarDisplay"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                        placeholder="Nominal yang Dibayar">
                    <input type="number" name="nominal_dibayar" id="nominalDibayar" class="hidden"
                        value="#">
                </div>

                <div class="flex justify-end space-x-2">

                    <button type="button" onclick="submitForm('store')"
                        class="active:scale-[.95] hover:bg-white hover:text-[#0F8114] transition-all text-white font-medium border-2 border-[#0F8114] rounded-md shadow-sm px-4 py-1 bg-[#810f0f]">Kembali</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
@vite('resources/js/pembayaran.js')
@endpush