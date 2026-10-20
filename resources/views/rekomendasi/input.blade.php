@extends('layouts.app')

@section('content')

@include('rekomendasi.guide-modal')

<div class="container mx-auto px-6 py-6">

    <form method="POST" action="{{ route('rekomendasi.ahp') }}">
        @csrf

        @php
        $kriteria = [
        'C1' => 'Kesesuaian Kompetensi',
        'C2' => 'Kesesuaian Bidang Minat',
        'C3' => 'Jarak Lokasi',
        'C4' => 'Estimasi Biaya Hidup'
        ];

        $pairs = [
        ['C1', 'C2'],
        ['C1', 'C3'],
        ['C1', 'C4'],
        ['C2', 'C3'],
        ['C2', 'C4'],
        ['C3', 'C4'],
        ];
        @endphp

        <div class="bg-white shadow-lg rounded-2xl p-8">

            <h2 class="text-2xl font-bold text-center mb-2">
                Preferensi Tempat Magang
            </h2>

            <p class="text-gray-500 text-center mb-6">
                Pilih faktor yang menurut Anda lebih penting saat menentukan tempat magang.
            </p>
            <!-- Tips Hover -->
            <div class="flex justify-center mb-6">

                <button type="button" @click="guideModalOpen()" class="inline-flex items-center gap-2
               px-4 py-2.5
               rounded-xl
               bg-blue-50
               border border-blue-200
               text-blue-700
               font-semibold
               hover:bg-blue-100
               transition">

                    <span class="text-lg">📖</span>

                    <span>Lihat Panduan Pengisian</span>

                </button>

            </div>


            <!-- Progress -->
            <div class="mb-6">
                <div class="flex justify-between mb-2 text-sm">

                    <span id="stepText">Pertanyaan 1 dari {{ count($pairs) }}</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                        style="width: 10%">
                    </div>
                </div>

            </div>

            <!-- Card Pertanyaan -->
            <div id="questionPanel" class="border rounded-2xl p-8 bg-gray-50 text-center">


                <h3 class="text-xl font-bold mb-3">

                    Dalam memilih tempat magang,

                </h3>

                <p class="text-gray-500 mb-8">

                    Faktor mana yang lebih Anda prioritaskan?

                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h4 id="leftTitle" class="text-xl font-bold text-blue-700">
                        </h4>
                    </div>

                    <div class="bg-pink-50 border border-pink-200 rounded-xl p-6">
                        <h4 id="rightTitle" class="text-xl font-bold text-pink-700">
                        </h4>
                    </div>

                </div>
                <!-- Pilihan -->
                <div class="mt-10">

                    <!-- Label arah -->
                    <div class="flex justify-between items-center mb-4">

                        <span id="leftLabel" class="font-semibold text-blue-600 text-lg">
                        </span>

                        <span class="text-gray-400 font-semibold">
                            VS
                        </span>

                        <span id="rightLabel" class="font-semibold text-pink-600 text-lg">
                        </span>

                    </div>

                    <!-- Skala -->
                    <div class="grid grid-cols-5 gap-3">

                        <button id="btn1" type="button" onclick="selectAnswer(5)" class="answer-btn choice-left">

                            Lebih
                        </button>

                        <button id="btn2" type="button" onclick="selectAnswer(3)" class="answer-btn choice-left">

                            Sedikit
                        </button>

                        <button id="btn3" type="button" onclick="selectAnswer(1)" class="answer-btn choice-center">

                            Sama
                        </button>

                        <button id="btn4" type="button" onclick="selectAnswer(0.333)" class="answer-btn choice-right">

                            Sedikit
                        </button>

                        <button id="btn5" type="button" onclick="selectAnswer(0.2)" class="answer-btn choice-right">

                            Lebih
                        </button>

                    </div>

                    <!-- Feedback -->
                    <div id="selectedInfo" class="hidden mt-6
        bg-blue-50
        border
        border-blue-200
        rounded-xl
        p-4
        text-blue-700
        text-center
        font-medium">

                    </div>

                </div>

            </div>

            <!-- PANEL REVIEW -->
            <div id="reviewPanel" class="hidden border rounded-2xl p-8 bg-gray-50">

            </div>

            <!-- Hidden Inputs -->
            <div id="hiddenInputs"></div>

            <!-- Navigation -->
            <div class="flex justify-between mt-8">

                <button type="button" id="prevBtn" onclick="prevQuestion()" class="hidden items-center gap-2
           px-5 py-3
           bg-white border border-gray-300
           rounded-xl
           text-gray-700 font-semibold
           shadow-sm
           hover:bg-gray-200
           hover:shadow-md
           hover:-translate-y-0.5
           transition duration-200">

                    Sebelumnya
                </button>

                <button type="submit" id="submitBtn" class="hidden items-center gap-2
           px-6 py-3
           bg-blue-600 text-white
           rounded-xl
           font-semibold
           shadow-md
           hover:bg-blue-700
           hover:shadow-lg
           hover:-translate-y-0.5
           transition duration-200">

                    Lihat Hasil Rekomendasi →
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

<!-- MODAL -->
@include('components.modal-panduan-ahp')
@section('scripts')
<script>
const pairs = JSON.parse('{!! json_encode($pairs) !!}');
const kriteria = JSON.parse('{!! json_encode($kriteria) !!}');

let current = 0;
let answers = {};
// State Edit
let isEditing = false;
let editingIndex = null;

loadQuestion();

// =========================
// QUESTION
// =========================
function loadQuestion() {

    renderQuestion();

    resetButtons();

    restoreSelectedButton();

    renderProgress();

    renderNavigation();

}

function resetButtons() {

    for (let i = 1; i <= 5; i++) {

        const btn = document.getElementById(`btn${i}`);

        if (!btn) continue;

        btn.classList.remove(
            "bg-blue-600",
            "text-white",
            "scale-95"
        );

    }

}

function restoreSelectedButton() {

    const pair = pairs[current];

    const key = `${pair[0]}_${pair[1]}`;

    const selected = answers[key];

    if (selected === undefined) return;

    let buttonId = "";

    switch (selected) {

        case 5:
            buttonId = "btn1";
            break;

        case 3:
            buttonId = "btn2";
            break;

        case 1:
            buttonId = "btn3";
            break;

        case 0.333:
            buttonId = "btn4";
            break;

        case 0.2:
            buttonId = "btn5";
            break;

    }

    const btn = document.getElementById(buttonId);

    if (!btn) return;

    btn.classList.add(
        "bg-blue-600",
        "text-white",
        "scale-95"
    );

}

function renderQuestion() {

    const pair = pairs[current];

    document.getElementById("leftTitle").innerText =
        kriteria[pair[0]];

    document.getElementById("rightTitle").innerText =
        kriteria[pair[1]];

    document.getElementById("leftLabel").innerText =
        kriteria[pair[0]];

    document.getElementById("rightLabel").innerText =
        kriteria[pair[1]];

    const title = document.getElementById("pageTitle");

    if (title) {

        title.innerText =
            isEditing ?
            "Perbaiki Jawaban" :
            "Preferensi Tempat Magang";

    }

}

function renderProgress() {

    document.getElementById("stepText")
        .innerText =
        `${current + 1} / ${pairs.length}`;

    let percent =
        ((current + 1) / pairs.length) * 100;

    document.getElementById("progressBar")
        .style.width =
        percent + "%";

}

function renderNavigation() {

    const prevBtn =
        document.getElementById("prevBtn");

    if (current === 0) {

        prevBtn.classList.add("hidden");
        prevBtn.classList.remove("flex");

    } else {

        prevBtn.classList.remove("hidden");
        prevBtn.classList.add("flex");

    }

}

// =========================
// ACTION
// =========================
function selectAnswer(value) {

    const clickedBtn = event.currentTarget;
    const pair = pairs[current];

    let left = kriteria[pair[0]];
    let right = kriteria[pair[1]];

    let text = "";

    switch (value) {

        case 5:
            text =
                `${left} lebih diprioritaskan dibanding ${right}`;
            break;

        case 3:
            text =
                `${left} sedikit lebih diprioritaskan dibanding ${right}`;
            break;

        case 1:
            text =
                `${left} dan ${right} memiliki prioritas yang sama`;
            break;

        case 0.333:
            text =
                `${right} sedikit lebih diprioritaskan dibanding ${left}`;
            break;

        case 0.2:
            text =
                `${right} lebih diprioritaskan dibanding ${left}`;
            break;

    }

    let info =
        document.getElementById("selectedInfo");
    // Reset warna
    info.classList.remove(
        "bg-blue-50",
        "border-blue-200",
        "text-blue-700",
        "bg-pink-50",
        "border-pink-200",
        "text-pink-700",
        "bg-green-50",
        "border-green-200",
        "text-green-700"
    );

    // Tentukan warna sesuai pilihan
    if (value == 5 || value == 3) {

        // Pilih kriteria kiri
        info.classList.add(
            "bg-blue-50",
            "border-blue-200",
            "text-blue-700"
        );

    } else if (value == 0.333 || value == 0.2) {

        // Pilih kriteria kanan
        info.classList.add(
            "bg-pink-50",
            "border-pink-200",
            "text-pink-700"
        );

    } else {

        // Sama penting
        info.classList.add(
            "bg-green-50",
            "border-green-200",
            "text-green-700"
        );

    }

    info.innerHTML =
        `✔ ${text}`;

    info.classList.remove("hidden");

    clickedBtn.classList.add(
        'bg-blue-600',
        'text-white',
        'scale-95'
    );

    setTimeout(() => {

        // Simpan jawaban
        answers[`${pair[0]}_${pair[1]}`] = value;

        // =====================
        // MODE EDIT
        // =====================

        if (isEditing) {

            isEditing = false;
            editingIndex = null;

            showReview();

            return;
        }

        // =====================
        // MODE NORMAL
        // =====================

        if (current < pairs.length - 1) {

            current++;
            loadQuestion();

        } else {

            showReview();

        }

    }, 500);
}

function prevQuestion() {
    if (current > 0) {
        current--;
        loadQuestion();
    }
}

function showReview() {

    let html = `
    <div>

        <h2 class="text-2xl font-bold text-center mb-3">

            Review Preferensi Anda

        </h2>

        <p class="text-gray-500 text-center mb-8">

            Periksa kembali jawaban sebelum menghitung bobot AHP.

        </p>

    `;

    html += `<div class="space-y-4">`;

    let index = 0;

    for (const key in answers) {

        let pair = key.split("_");

        let text = "";

        switch (answers[key]) {

            case 5:

                text = `${kriteria[pair[0]]} lebih diprioritaskan`;

                break;

            case 3:

                text = `${kriteria[pair[0]]} sedikit lebih diprioritaskan`;

                break;

            case 1:

                text = `Keduanya sama penting`;

                break;

            case 0.333:

                text = `${kriteria[pair[1]]} sedikit lebih diprioritaskan`;

                break;

            case 0.2:

                text = `${kriteria[pair[1]]} lebih diprioritaskan`;

                break;

        }

        html += `

        <div class="border rounded-xl p-4">
            <div class="flex justify-between items-center">

                <div>

                    <b>${kriteria[pair[0]]}</b>

                    vs

                    <b>${kriteria[pair[1]]}</b>

                </div>

                <div class="text-right">

                <div class="text-blue-600 font-semibold">

                    ✔ ${text}

                </div>

                <button

                    type="button"

                    onclick="editQuestion(${index})"

                    class="inline-flex items-center
px-3 py-1
rounded-full
bg-yellow-50
text-yellow-700
hover:bg-yellow-100
text-sm font-medium">

                    Ubah

                </button>

            </div>
            </div>
        </div>

        `;

        index++;

    }

    html += `</div>`;

    html += `</div>`;

    html += `

<div class="flex justify-between mt-8">

    <button
        type="button"
        onclick="editAnswers()"
        class="px-6 py-3
        bg-white
        border
        border-gray-300
        rounded-xl
        font-semibold
        hover:bg-gray-100">

        ← Perbaiki Jawaban

    </button>

    <button
        type="button"
        onclick="submitReview()"
        class="px-6 py-3
        bg-blue-600
        text-white
        rounded-xl
        font-semibold
        hover:bg-blue-700">

        Hitung Bobot →

    </button>

</div>

`;

    document.getElementById("questionPanel")
        .classList.add("hidden");

    const review =
        document.getElementById("reviewPanel");

    review.innerHTML = html;

    review.classList.remove("hidden");

}

function editAnswers() {

    current = 0;

    loadQuestion();

}


function editQuestion(index) {

    // Masuk ke mode edit
    isEditing = true;
    editingIndex = index;
    current = index;

    // Tampilkan panel pertanyaan
    document.getElementById("reviewPanel")
        .classList.add("hidden");

    document.getElementById("questionPanel")
        .classList.remove("hidden");

    loadQuestion();

}

function submitReview() {

    generateHiddenInputs();

    document.querySelector("form").submit();

}

function generateHiddenInputs() {

    let container =
        document.getElementById('hiddenInputs');

    container.innerHTML = '';

    for (const key in answers) {

        let [c1, c2] = key.split('_');

        container.innerHTML += `
                <input type="hidden"
                    name="nilai[${c1}][${c2}]"
                    value="${answers[key]}">
            `;
    }


}

function openModal() {
    console.log("modal dibuka"); // DEBUG
    document.getElementById("modalPanduan").style.display = "flex";
}

function closeModal() {
    document.getElementById("modalPanduan").style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("modalPanduan");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
        let value = parseFloat(this.value);
        let targetId = this.dataset.target;

        if (!targetId) return;

        let targetInput = document.getElementById(targetId);

        if (value > 0) {
            let reciprocal = (1 / value).toFixed(3);
            targetInput.value = reciprocal;
        } else {
            targetInput.value = '';
        }
    });
});
</script>
@endsection