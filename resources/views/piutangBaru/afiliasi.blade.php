@extends('layouts.app')

@section('content')
{{-- bagus versi --}}
{{-- <div class="container mx-auto p-4">
{{-- bagus versi --}}
{{-- <div class="container mx-auto p-4">

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 max-w-screen-lg mx-auto">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">PIUTANG BARU</h1>
        </div>

        <form action="{{ route('piutang-types.create') }}" method="GET">
            @csrf
            <div class="mb-4">
                <h2 class="text-lg font-bold mb-2">Pilih Perusahaan</h2>
                <label for="perusahaan" class="block text-sm font-medium text-gray-700">Perusahaan</label>
                <select id="perusahaan" name="perusahaan"
                    class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach ($masterPerusahaan as $type)
                        <option value="{{ $type->company_id }}"
                            {{ $selectedPerusahaan == $type->company_id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <h2 class="text-lg font-bold mb-2">Pilih Jenis Piutang</h2>
                <label for="jenis_form" class="block text-sm font-medium text-gray-700">Jenis Piutang</label>
                <select id="jenis_form" name="jenis_form"
                    class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"
                    onchange="this.form.submit()">
                    <option value="">-- Pilih Jenis Piutang --</option>
                    @foreach ($piutangTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ $selectedType && $selectedType->id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if ($selectedType)
            <h2 class="text-lg font-bold mb-4 text-center">PIUTANG BARU {{ $selectedType->name }}</h2>

            <form action="{{ route('piutang-types.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_form" value="{{ $selectedType->kodePiutang }}">
                <input type="hidden" name="perusahaan" value="{{ $selectedPerusahaan }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal
                            Transaksi</label>
                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                            class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="jatuh_tempo" class="block text-sm font-medium text-gray-700">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" id="jatuh_tempo"
                            class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>


                <div class="mt-4 flex flex-row justify-center min-w-full items-center gap-4">
                    <div class="w-full ">
                        <label for="jarak_hari" class="block text-sm font-medium text-gray-700">Jatuh Tempo</label>
                        <div class="flex justify-start items-center gap-2">
                            <input type="text" name="jarak_hari" id="jarak_hari"
                                class="mt-1 block w-full text-right border-gray-300 bg-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                            <span for="jarak_hari" class="block text-sm font-medium text-gray-700">Hari</span>
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="denda" class="block text-sm font-medium text-gray-700">Denda</label>
                        <select id="denda" name="denda"
                            class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Denda</option>
                            <option value="">Tidak Denda</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row gap-4">
                    <!-- Tipe Pelanggan -->
                    <div class="w-full md:w-1/2">
                        <label for="tipePelanggan" class="block text-sm font-medium text-gray-700">Tipe Pelanggan</label>
                        <select id="tipePelanggan" name="tipePelanggan"
                            class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($tipePelanggan as $type)
                                <option value="{{ $type->kodeType }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Pilih Pelanggan -->
                    <div class="w-full md:w-1/2 flex flex-col">
                        <label for="idcompany" class="text-gray-700 font-medium">Pilih Pelanggan:</label>
                        <div id="customerDropdownContainer" class="relative w-full">
                            <!-- Input untuk menampilkan nama pelanggan -->
                            <input list="groupList" name="nama_pelanggan" id="nama_pelanggan"
                                class="border border-gray-300 p-2 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Pilih Pelanggan..." oninput="syncCustomerId(this)">
                
                            <!-- Datalist untuk menampilkan opsi -->
                            <datalist id="groupList">
                                @if (!empty($customers))
                                    @foreach ($customers as $pelanggan)
                                        <option data-id="{{ $pelanggan->id_Pelanggan }}" value="{{ $pelanggan->name }}">
                                            {{ $pelanggan->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </datalist>
                
                            <!-- Input tersembunyi untuk menyimpan id_Pelanggan -->
                            <input type="hidden" name="id_Pelanggan" id="id_Pelanggan">
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <!-- Jenis Tagihan -->
                    <div class="w-full">
                        <label for="jenis_tagihan" class="block text-gray-700 font-medium">Jenis Tagihan</label>
                        <select id="jenis_tagihan" name="jenis_tagihan"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Jenis Tagihan --</option>
                            <option value="berulang" {{ old('jenis_tagihan') == 'berulang' ? 'selected' : '' }}>
                                Berulang
                            </option>
                        </select>
                    </div>
                
                    <!-- Berapa Kali Tagihan (Ditampilkan jika berulang) -->
                    <div id="jumlah_kali_container" class="w-full sm:w-1/3 hidden">
                        <label for="jumlah_kali" class="block text-gray-700 font-medium">Berapa Kali Tagihan</label>
                        <input type="number" id="jumlah_kali" name="jumlah_kali" min="1"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('jumlah_kali') }}">
                    </div>
                </div>
                
                <div class="w-full flex flex-col gap-2">
                    <label class="text-gray-700 font-medium">Pajak</label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                        <!-- PPN -->
                        <div class="flex flex-row items-center gap-2">
                            <label for="ppn_type" class="whitespace-nowrap text-sm font-medium text-gray-700">PPN:</label>
                            <select name="ppnType" id="ppn_type"
                                class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2">
                                <option value="Tidak Ada">Tidak Ada</option>
                                @foreach ($ppnTypes as $pajakType)
                                    <option value="{{ $pajakType->nilai }}">
                                        {{ $pajakType->nilai }}%</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- PPh -->
                        <div class="flex flex-row items-center gap-2">
                            <label for="pajak_type" class="whitespace-nowrap text-sm font-medium text-gray-700">PPh:</label>
                            <select name="pajak_type" id="pajak_type" onchange="fetchPajakRates(this.value)"
                                class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2">
                                <option value="Tidak Ada">Tidak Ada</option>
                                @foreach ($pajakTypes as $pajakType)
                                    <option value="{{ $pajakType }}">{{ $pajakType }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Tarif -->
                        <div class="flex flex-row items-center gap-2">
                            <label for="tarif" class="whitespace-nowrap text-sm font-medium text-gray-700">Tarif:</label>
                            <select name="tarif" id="tarif"
                                class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2">
                                <option value="">-- Pilih Tarif --</option>
                            </select>
                        </div>
                    </div>
                </div>
                

                <div class="mt-4">
                    <label for="dpp" class="block text-sm font-medium text-gray-700">DPP</label>
                    <input type="number" name="dpp" id="dpp"
                        class="mt-1 block w-full text-right p-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="0">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="ppn_value" class="block text-sm font-medium text-gray-700">PPN</label>
                        <input type="number" name="ppn_value" id="ppn_value"
                            class="mt-1 block w-full text-right border-gray-300 bg-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            readonly>
                    </div>
                    <div>
                        <label for="pph_value" class="block text-sm font-medium text-gray-700">PPh</label>
                        <input type="number" name="pph_value" id="pph_value"
                            class="mt-1 block w-full text-right border-gray-300 bg-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            readonly>
                    </div>
                    <div>
                        <label for="total_piutang" class="block text-sm font-medium text-gray-700">Total Piutang</label>
                        <input type="text" name="total_piutang" id="total_piutang"
                            class="mt-1 block w-full text-right border-gray-300 bg-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            readonly>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan"
                        class="mt-1 block w-full p-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        rows="3" placeholder="Tambahkan keterangan..."></textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="reset"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 w-full md:w-auto">Batal</button>
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 w-full md:w-auto">Posting</button>
                </div>
            </form>
        @endif
    </div>
</div> --}}
    <div class="container mx-auto mt-10">


        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 ">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-white shadow-md rounded-lg px-2 py-10 md:px-5 min-w-full">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">PIUTANG BARU</h1>
            </div>


            <form action="{{ route('piutang-types.create') }}" method="GET" class="">
                @csrf
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-4">Pilih Perusahaan</h2>
                    <label for="perusahaan" class="block text-sm font-medium text-gray-700">Perusahaan</label>
                    <select id="perusahaan" name="perusahaan" onchange="updateCustomerDropdown()"
                        class="mt-1 block w-full mb-4 bg-white border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($masterPerusahaan as $type)
                            <option value="{{ $type->company_id }}"
                                {{ $selectedPerusahaan == $type->company_id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <h2 class="text-lg font-bold mb-4">Pilih Jenis Piutang :</h2>
                    <label for="jenis_form" class="block text-sm font-medium text-gray-700">Jenis Piutang</label>
                    <select id="jenis_form" name="jenis_form"
                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                        onchange="this.form.submit()">
                        <option value="">-- Pilih Jenis Piutang --</option>
                        @foreach ($piutangTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ $selectedType && $selectedType->id == $type->id ? 'selected' : '' }}>

                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if ($selectedType)
                <h2 class="text-lg font-bold mb-4 ">PIUTANG BARU {{ $selectedType->name }}: </h2>

                <form action="{{ route('piutang-types.store') }}" method="POST" class="">
                    @csrf
                    <input type="hidden" name="jenis_form" value="{{ $selectedType->kodePiutang }}">
                    <input type="hidden" name="perusahaan" value="{{ $selectedPerusahaan }}">

                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal
                                Transaksi</label>
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"  onchange="initializeDateCalculations()"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="jatuh_tempo" class="block text-sm font-medium text-gray-700">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo" id="jatuh_tempo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                , onchange="initializeDateCalculations()">
                        </div>
                    </div>
                    <label for="jarak_hari" class="block text-sm font-medium text-gray-700 w-1/3">Jatuh Tempo</label>
                    <div class="mb-4 flex items-center gap-2">

                        <input type="text" id="jarak_hari" name="jarak_hari"
                            class="mt-1 block w-20 border-gray-300 font-bold shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <p class="mt-1 font-bold ">Hari</p>
                    </div>
                    <div class="mb-4">
                        <label for="denda" class="block text-sm font-medium text-gray-700">Denda</label>
                        <select id="denda" name="denda"
                            class="mt-1 block m-full bg-white border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Denda</option>
                            <option value="">Tidak Denda</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tipePelanggan" class="block text-sm font-medium text-gray-700">Tipe Pelanggan</label>
                        <select id="tipePelanggan" name="tipePelanggan" onchange="updateCustomerDropdown()"
                            class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($tipePelanggan as $type)
                                <option value="{{ $type->kodeType }}">
                                    {{ $selectedTipePelanggan == $type->kodeType ? 'selected' : '' }}
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <label for="idcompany" class="mr-2 text-gray-700 font-medium ">Pilih Pelanggan:</label>
                    {{-- datalist digantikan karena tidak kompatibel dengan browser kebanyakan --}}
                    {{-- <div id="customerDropdownContainer" class="mb-4">
                    
                        <input list="groupList" name="nama_pelanggan" id="nama_pelanggan"
                            class="border border-gray-300 p-2 rounded-md w-80" placeholder="Pilih Pelanggan..."
                            oninput="syncCustomerId(this)">

                    
                        <datalist id="groupList">
                            @if (!empty($customers))
                                @foreach ($customers as $pelanggan)
                                    <option data-id="{{ $pelanggan->id_Pelanggan }}" value="{{ $pelanggan->name }}">
                                        {{ $pelanggan->name }}
                                    </option>
                                @endforeach
                            @endif
                        </datalist>

                        <input type="hidden" name="id_Pelanggan" id="id_Pelanggan">
                    </div> --}}

                    <div id="customerDropdownContainer" class="mb-4">
                      
                        <select name="nama_pelanggan" id="nama_pelanggan" class="border border-gray-300 p-2 rounded-md w-80"
                            onchange="syncCustomerId(this)">
                            <option value="" selected disabled>Pilih Pelanggan...</option>
                            @if (!empty($customers))
                                @foreach ($customers as $pelanggan)
                                    <option data-id="{{ $pelanggan->id_Pelanggan }}" value="{{ $pelanggan->name }}">
                                        {{ $pelanggan->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    
                        <!-- Input tersembunyi untuk menyimpan id_Pelanggan -->
                        <input type="hidden" name="id_Pelanggan" id="id_Pelanggan">
                    </div>
                    

                    <div class="flex">
                        <div class="mb-4">
                            <label for="jenis_tagihan" class="block text-sm font-medium text-gray-700">Jenis Tagihan</label>
                            <select id="jenis_tagihan" name="jenis_tagihan"
                                class="mt-1 block w-52 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                                <option value="">-- Pilih Jenis Tagihan --</option>
                                <option value="berulang" {{ old('jenis_tagihan') == 'berulang' ? 'selected' : '' }}>
                                    Berulang
                                </option>
                            </select>
                        </div>
                        <div id="jumlah_kali_container" class="mb-4" style="display: none;">
                            <label for="jumlah_kali" class="block ml-4 text-sm font-medium text-gray-700">Berapa Kali
                                Tagihan</label>
                            <input type="number" id="jumlah_kali" name="jumlah_kali" min="1"
                                class="mt-1 block w-32 ml-4 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                                value="{{ old('jumlah_kali') }}">
                        </div>
                    </div>

                    <div class="mb-4 ">
                        <label class="block text-sm font-medium text-gray-700">Pajak</label>
                        <div class="mt-2 flex  gap-4  flex-col md:flex-row justify-start">
                            <div class="flex  flex-col justify-start">
                                <label for="" class="mr-2">PPN:</label>
                                <select name="ppnType" id="ppn_type"
                                    class="mt-1 block w-52 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    @foreach ($ppnTypes as $pajakType)
                                        <option value="{{ $pajakType->nilai }}">
                                            {{ $pajakType->nilai }}%</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-center items-start flex-col">
                                <label for="pajak_type" class="mr-2">PPh:</label>
                                <select name="pajak_type" id="pajak_type" onchange="fetchPajakRates(this.value)"
                                    class="mt-1 block w-52 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    @foreach ($pajakTypes as $pajakType)
                                        <option value="{{ $pajakType }}">{{ $pajakType }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-center items-start flex-col">
                                <label for="tarif" class="mr-2">tarif:</label>
                                <select name="tarif" id="tarif"
                                    class="bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2">
                                    <option value="">-- Pilih Tarif --</option>
                                </select>
                            </div>
                        </div>
                    </div>




                    <div class="grid grid-cols-2 gap-4 mb-4 items-start">
                        <div>
                            <label for="dpp" class="block text-sm font-medium text-gray-700">DPP</label>
                            <input type="text" name="dpp" id="dpp"
                                class="mt-1 block w-full text-right p-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                oninput="formatDPP(this)" value="0">
                        </div>

                        <div>
                            <label for="ppn_value" class="block text-sm font-medium text-gray-700">PPN</label>
                            <input type="text" name="ppn_value" id="ppn_value"
                                class="mt-1 block w-full text-right border-gray-300 bg-slate-400 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                readonly>
                        </div>
                        <div>
                            <label for="pph_value" class="block text-sm font-medium text-gray-700">PPh</label>
                            <input type="text" name="pph_value" id="pph_value"
                                class="mt-1 block w-full text-right border-gray-300 rounded-md shadow-sm bg-slate-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                readonly>
                        </div>



                    </div>
                    <div>
                        <label for="total_piutang" class="block text-sm font-medium text-gray-700">Total
                            Piutang</label>
                        <input type="text" name="total_piutang" id="total_piutang"
                            class="mt-1 block w-80 text-right border-gray-300 rounded-md bg-slate-400 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            readonly>
                    </div>
                    <div class="mb-4">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" id="keterangan"
                            class="mt-1 block w-full p-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            rows="3" placeholder="Tambahkan keterangan..."></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Posting</button>
                        <button type="reset"
                            class="ml-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var customers = @json($customers);
      
        function updateCustomerDropdown() {
            const perusahaan = document.getElementById('perusahaan').value; // Ambil perusahaan yang dipilih
            const tipePelanggan = document.getElementById('tipePelanggan').value; // Tipe pelanggan yang dipilih
            const datalist = document.getElementById('groupList'); // Referensi elemen datalist
            
            // Kosongkan elemen datalist
            datalist.innerHTML = '';

            // Filter pelanggan berdasarkan perusahaan dan tipe pelanggan (jika ada)
            const filteredCustomers = customers.filter(customer => {
                return (!perusahaan || customer.idcompany === perusahaan) &&
                    (!tipePelanggan || customer.idtypepelanggan === tipePelanggan);
            });

            // Tambahkan opsi ke datalist
            filteredCustomers.forEach(customer => {
                const option = document.createElement('option');
                option.value = customer.id_Pelanggan; // Value tetap id_Pelanggan
                option.textContent = `${customer.name}`; // Nama pelanggan yang tampil
                datalist.appendChild(option);
            });

            // Jika tidak ada pelanggan yang cocok, tambahkan opsi kosong
            if (filteredCustomers.length === 0) {
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = '-- Tidak Ada Pelanggan --';
                datalist.appendChild(emptyOption);
            }
        }

        // Event listener untuk memperbarui pelanggan saat perusahaan atau tipe pelanggan berubah
        document.getElementById('perusahaan').addEventListener('change', updateCustomerDropdown);
        document.getElementById('tipePelanggan').addEventListener('change', updateCustomerDropdown);

        // Panggil fungsi ini saat halaman dimuat untuk inisialisasi awal
        document.addEventListener('DOMContentLoaded', updateCustomerDropdown);

        function formatRupiah(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function formatDPP(input) {
            let value = input.value.replace(/\./g, ''); // Remove existing dots for reformatting
            if (!isNaN(value) && value !== "") {
                input.value = formatRupiah(value); // Apply Rupiah format
            } else {
                input.value = ""; // Clear if not a valid number
            }
            calculatePiutang(); // Recalculate totals
        }

        function calculatePiutang() {
            const dppInput = parseFloat(document.getElementById('dpp').value.replace(/\./g, '')) || 0;
            const ppnRate = parseFloat(document.getElementById('ppn_type').value) || 0; // Get PPN rate percentage
            const pphRate = parseFloat(document.getElementById('tarif').value) || 0; // Get PPh rate percentage

            // Calculate PPN and PPh values
            const ppnValue = (dppInput * ppnRate) / 100;
            const pphValue = (dppInput * pphRate) / 100;

            // Set formatted values for PPN and PPh
            document.getElementById('ppn_value').value = formatRupiah(ppnValue.toFixed(0));
            document.getElementById('pph_value').value = formatRupiah(pphValue.toFixed(0));

            // Calculate total piutang
            const totalPiutang = dppInput + ppnValue - pphValue;
            document.getElementById('total_piutang').value = formatRupiah(totalPiutang.toFixed(0));
        }


        // Event listeners to trigger calculation when PPN or PPh types change
        document.getElementById('ppn_type').addEventListener('change', calculatePiutang);
        document.getElementById('tarif').addEventListener('change', calculatePiutang);
        // Show or hide 'jumlah_kali' input based on 'jenis_tagihan' selection
        document.getElementById('jenis_tagihan').addEventListener('change', function() {
            const jumlahKaliContainer = document.getElementById('jumlah_kali_container');
            jumlahKaliContainer.style.display = this.value === 'berulang' ? 'block' : 'none';
        });

        function syncCustomerId(input) {
            const datalist = document.getElementById('groupList'); // Referensi elemen datalist
            const hiddenInput = document.getElementById('id_Pelanggan'); // Input tersembunyi untuk id_Pelanggan
            const selectedOption = Array.from(datalist.options).find(option => option.textContent.trim() === input.value.trim());

            // Jika nama pelanggan ditemukan di datalist, sinkronkan id_Pelanggan
            if (selectedOption) {
                hiddenInput.value = selectedOption.getAttribute('data-id'); // Ambil id_Pelanggan dari atribut data-id
                input.value = selectedOption.textContent.trim(); // Set input value ke nama pelanggan
            } else {
                hiddenInput.value = ''; // Reset jika input tidak cocok
            }
        }
        // fungsi dari app yang dimasukkan kembali ketempatnya
        // Fungsi-fungsi inisialisasi
function initializeDateCalculations() {
    const tanggalTransaksiInput = document.getElementById('tanggal_transaksi');
    const jatuhTempoInput = document.getElementById('jatuh_tempo');
    const jarakHariInput = document.getElementById('jarak_hari');

    function updateJarakHari() {
        const tanggalTransaksi = new Date(tanggalTransaksiInput.value);
        const jatuhTempo = new Date(jatuhTempoInput.value);

        if (tanggalTransaksi && jatuhTempo) {
            const diffTime = Math.abs(jatuhTempo - tanggalTransaksi);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            jarakHariInput.value = diffDays;
        }
    }

    function updateJatuhTempo() {
        const tanggalTransaksi = new Date(tanggalTransaksiInput.value);
        const jarakHari = parseInt(jarakHariInput.value, 10);

        if (tanggalTransaksi && !isNaN(jarakHari)) {
            const jatuhTempo = new Date(tanggalTransaksi);
            jatuhTempo.setDate(jatuhTempo.getDate() + jarakHari);
            jatuhTempoInput.value = jatuhTempo.toISOString().split('T')[0];
        }
    }

    tanggalTransaksiInput.addEventListener('change', updateJarakHari);
    jatuhTempoInput.addEventListener('change', updateJarakHari);
    jarakHariInput.addEventListener('input', updateJatuhTempo);
}
window.fetchPajakRates = function(type) {
    const tarifSelect = document.getElementById('tarif');
    tarifSelect.innerHTML = '<option value="">-- Pilih Tarif --</option>';

    if (type === 'Tidak Ada') {
        return; // Exit if the selected type is 'Tidak Ada'
    }

    // Fetch tax rates from the server
    fetch(`/api/pajak/${type}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success' && data.rates) {
                data.rates.forEach(rate => {
                    const option = document.createElement('option');
                    option.value = rate.nilai; // Set value to the rate's value
                    option.textContent = `${rate.nilai}%`; // Set display text
                    tarifSelect.appendChild(option); // Append option to select
                });
            }
        })
        .catch(error => {
            console.error('Error fetching tax rates:', error); // Log any errors
        });
}
        
    </script>
@endpush