@php
$nilaiAHP = [
['label' => '5', 'value' => 5],
['label' => '3', 'value' => 3],
['label' => '1', 'value' => 1],
['label' => '1/3', 'value' => 1/3],
['label' => '1/5', 'value' => 1/5],
];
@endphp

<div class="space-y-6">

    @foreach($pairs as $index => $pair)

    <div class="slider-card border border-slate-200 rounded-2xl p-6 bg-white shadow-sm">

        {{-- Hidden Input --}}
        <input type="hidden" id="input-{{ $index }}" name="nilai[{{ $pair[0] }}][{{ $pair[1] }}]" value="">

        {{-- Nomor --}}
        <div class="flex items-center gap-3 mb-5">

            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">

                {{ $index + 1 }}

            </div>

            <span class="text-sm font-semibold text-slate-500">

                Perbandingan {{ $index + 1 }}

            </span>

        </div>

        {{-- Nama Kriteria --}}
        <div class="grid grid-cols-2 gap-4 mb-8">

            <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 text-center">

                <p class="text-xs text-slate-500 mb-1">

                    Kriteria A

                </p>

                <h4 class="font-semibold text-slate-800">

                    {{ $kriteria[$pair[0]] }}

                </h4>

            </div>

            <div class="rounded-xl bg-indigo-50 border border-indigo-200 p-4 text-center">

                <p class="text-xs text-slate-500 mb-1">

                    Kriteria B

                </p>

                <h4 class="font-semibold text-slate-800">

                    {{ $kriteria[$pair[1]] }}

                </h4>

            </div>

        </div>

        {{-- Slider akan kita isi pada tahap berikutnya --}}

    </div>

    @endforeach

</div>
