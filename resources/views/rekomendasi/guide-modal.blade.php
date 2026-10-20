<div x-data="guideModal()" x-init="init()" x-show="open" x-cloak x-transition.opacity.duration.250ms
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/20 backdrop-blur-sm p-5">
    <div x-show="open" x-cloak x-transition.opacity.duration.250ms
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/30 backdrop-blur-sm p-5">

        <div x-show="open" x-transition.scale.duration.250ms
            class="w-full max-w-[720px] bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            <!-- HEADER -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white">

                <div class="flex justify-between items-start">

                    <div>

                        <h2 class="text-xl font-bold" x-text="slides[current].title">
                        </h2>

                        <p class="text-sm text-blue-100 mt-1" x-text="slides[current].subtitle">
                        </p>

                    </div>

                    <div class="flex items-start gap-5">

                        <div class="text-right py-3">

                            <h2 class="text-2xl font-bold">

                                <span x-text="current+1"></span>

                                /

                                <span x-text="slides.length"></span>

                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            <!-- BODY -->
            <div class="flex-1 px-8 py-7">

                <div x-show="current==0">

                    @include('rekomendasi.guide.step-1')

                </div>

                <div x-show="current==1">

                    @include('rekomendasi.guide.step-2')

                </div>

                <div x-show="current==2">

                    @include('rekomendasi.guide.step-3')

                </div>

                <div x-show="current==3">

                    @include('rekomendasi.guide.step-4')

                </div>

                <div x-show="current==4">

                    @include('rekomendasi.guide.step-5')

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t bg-gray-50 px-5 py-3">

                <!-- Progress -->

                <div class="flex justify-center gap-2 mb-5">

                    <template x-for="(slide,index) in slides">

                        <div class="transition-all duration-300 rounded-full" :class="current==index
                ? 'bg-blue-600 w-8 h-2'
                : 'bg-gray-300 w-2 h-2'">

                        </div>

                    </template>

                </div>

                <div class="flex justify-between items-center">

                    <button x-show="current>0" @click="prev()"
                        class="px-4 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100">

                        ← Sebelumnya

                    </button>

                    <div x-show="current==0"></div>

                    <button x-show="current<slides.length-1" @click="next()"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                        Selanjutnya →

                    </button>

                    <button x-show="current==slides.length-1" @click="finish()"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                        Mulai

                    </button>

                </div>

            </div>

        </div>

    </div>
</div>
<script>
function guideModalOpen() {

    window.dispatchEvent(new Event('open-guide'));

}

function guideModal() {
    return {

        open: false,

        current: 0,

        slides: [

            {
                title: 'Panduan Penggunaan',
                subtitle: 'Bagaimana cara kerja SIREMA'
            },

            {
                title: 'Cara Memilih',
                subtitle: 'Memahami Perbandingan'
            },

            {
                title: 'Tingkat Prioritas',
                subtitle: 'Lebih • Sedikit • Sama'
            },

            {
                title: 'Tips Menjaga Konsistensi',
                subtitle: 'Hasil yang Lebih Akurat'
            },

            {
                title: 'Siap Memulai',
                subtitle: 'Mulai Mengisi Preferensi'
            }

        ],

        init() {

            if (localStorage.getItem('guide_hide') !== 'true') {
                this.open = true;
            }
            window.addEventListener('open-guide', () => {

                this.current = 0;
                this.open = true;

            });

        },

        next() {

            if (this.current < this.slides.length - 1) {
                this.current++;
            }
        },
        prev() {
            if (this.current > 0) {
                this.current--;
            }

        },

        finish() {

            if (document.getElementById('guideHide')?.checked) {
                localStorage.setItem('guide_hide', 'true');
            }

            this.open = false;

        },

        resetGuide() {

            localStorage.removeItem('guide_hide');
            this.current = 0;
            this.open = true;

        }

    }
}
</script>