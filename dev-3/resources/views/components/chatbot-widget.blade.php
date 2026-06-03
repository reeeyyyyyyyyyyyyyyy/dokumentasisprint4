<!-- ========================================================= -->
<!-- SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3] -->
<!-- ========================================================= -->

<div x-data="minGapChatbot()" class="relative">
    <!-- Tombol Melayang MinGAP -->
    <button @click="toggleChat()" 
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 bg-brand-500 hover:bg-brand-600 dark:bg-brand-600 dark:hover:bg-brand-500 rounded-full text-white shadow-lg hover:shadow-brand-500/30 transition-all duration-300 transform hover:scale-105 active:scale-95 focus:outline-none animate-bounce"
        style="animation-duration: 2s;"
        aria-label="Tanya MinGAP">
        <!-- Icon Chat (Jika Tertutup) -->
        <span x-show="!terbuka" x-transition.duration.200ms>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </span>
        <!-- Icon Close (Jika Terbuka) -->
        <span x-show="terbuka" x-transition.duration.200ms style="display: none;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </span>
        <!-- Badge Status Aktif -->
        <span class="absolute top-0 right-0 block h-3.5 w-3.5 rounded-full ring-2 ring-white dark:ring-slate-900 bg-emerald-400"></span>
    </button>

    <!-- Jendela Chatbot -->
    <div x-show="terbuka" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="fixed bottom-24 right-6 w-96 h-[520px] max-w-[calc(100vw-3rem)] z-50 rounded-2xl shadow-2xl border border-stone-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur flex flex-col overflow-hidden transition-all duration-300"
        style="display: none;">
        
        <!-- Header -->
        <div class="bg-brand-500 dark:bg-slate-900 px-4 py-3.5 flex items-center justify-between text-white border-b border-brand-600 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-2.5">
                <div class="relative">
                    <div class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-brand-500 dark:ring-slate-900 bg-emerald-400 animate-pulse"></span>
                </div>
                <div>
                    <div class="text-xs font-bold tracking-wide">MinGAP (Admin AI)</div>
                    <div class="text-[10px] text-white/70 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Melayani Bandung
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-1">
                <!-- Bersihkan Riwayat Chat -->
                <button @click="bersihkanRiwayat()" 
                    class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg text-white/80 hover:text-white transition"
                    title="Reset Obrolan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <!-- Tutup -->
                <button @click="toggleChat()" 
                    class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg text-white/80 hover:text-white transition"
                    title="Tutup Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat History Area -->
        <div id="minGapMessageContainer" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
            <template x-for="(chat, index) in riwayat" :key="index">
                <div :class="chat.role === 'user' ? 'flex justify-end' : 'flex justify-start gap-2'">
                    <!-- Avatar MinGAP -->
                    <template x-if="chat.role !== 'user'">
                        <div class="w-7 h-7 bg-brand-50 dark:bg-slate-850 rounded-full flex items-center justify-center border border-brand-100 dark:border-slate-800 flex-shrink-0">
                            <svg class="w-4 h-4 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Bubble Chat -->
                    <div :class="chat.role === 'user' 
                        ? 'bg-brand-500 text-white rounded-2xl rounded-tr-none px-3.5 py-2 text-xs max-w-[80%] shadow-sm' 
                        : 'bg-stone-100 dark:bg-slate-850 text-stone-800 dark:text-slate-100 rounded-2xl rounded-tl-none px-3.5 py-2.5 text-xs max-w-[80%] shadow-sm leading-relaxed border border-stone-200/50 dark:border-slate-800/60'">
                        <div x-html="formatPesan(chat.content)"></div>
                    </div>
                </div>
            </template>

            <!-- Bouncing Typing Indicator -->
            <div x-show="sedangMemuat" class="flex justify-start gap-2" style="display: none;">
                <div class="w-7 h-7 bg-brand-50 dark:bg-slate-850 rounded-full flex items-center justify-center border border-brand-100 dark:border-slate-800 flex-shrink-0">
                    <svg class="w-4 h-4 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="bg-stone-100 dark:bg-slate-850 px-4 py-3 rounded-2xl rounded-tl-none border border-stone-200/50 dark:border-slate-800/60 flex items-center gap-1 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce" style="animation-delay: 0.1s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce" style="animation-delay: 0.2s;"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce" style="animation-delay: 0.3s;"></span>
                </div>
            </div>
        </div>

        <!-- Quick Action Bubble Template -->
        <div class="px-4 py-2 border-t border-stone-100 dark:border-slate-800 flex gap-1.5 overflow-x-auto whitespace-nowrap bg-stone-50/50 dark:bg-slate-900/50 scrollbar-none select-none">
            <button @click="kirimTemplate('Bagaimana cara membuat laporan di SIGAP BDG? 📝')" 
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-350 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Cara Melapor 📝
            </button>
            <button @click="kirimTemplate('Saya mau melacak status laporan saya 🔍')" 
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-350 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Lacak Laporan 🔍
            </button>
            <button @click="kirimTemplate('Apa nomor darurat Kota Bandung? 🚨')" 
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-350 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Darurat 112 🚨
            </button>
            <button @click="kirimTemplate('Siapa kamu? Jelaskan tentang MinGAP! 🤖')" 
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-350 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Tentang MinGAP 🤖
            </button>
        </div>

        <!-- Footer Input Area -->
        <form @submit.prevent="kirimPesan()" class="p-3 border-t border-stone-100 dark:border-slate-800 flex items-center gap-2 bg-stone-50/50 dark:bg-slate-900/50">
            <input type="text" 
                x-model="pesanBaru" 
                placeholder="Tulis pesan ke MinGAP..." 
                class="flex-1 text-xs px-3.5 py-2.5 rounded-full border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-stone-800 dark:text-white placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-brand-500 dark:focus:ring-brand-600 transition"
                :disabled="sedangMemuat">
            <button type="submit" 
                class="flex items-center justify-center w-8 h-8 bg-brand-500 hover:bg-brand-600 text-white rounded-full transition shadow-md shadow-brand-500/10 active:scale-95 flex-shrink-0"
                :disabled="sedangMemuat || !pesanBaru.trim()">
                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function minGapChatbot() {
        return {
            terbuka: false,
            pesanBaru: '',
            sedangMemuat: false,
            riwayat: [],
            csrf: '{{ csrf_token() }}',
            defaultWelcome: 'Halo Warga Bandung! 🤖\n\nSaya **MinGAP**, asisten AI SIGAP BDG. Ada yang bisa MinGAP bantu hari ini?\n\nAnda bisa bertanya seputar alur laporan, melacak status laporan (ketik nomor Tracking ID Anda seperti `SIGAP-XXXXXX` atau `SOS-KJH-XXXX`), atau menanyakan info penting lainnya!',

            init() {
                // Ambil riwayat chat saat inisialisasi awal
                fetch('{{ route("chatbot.riwayat") }}')
                    .then(res => res.json())
                    .then(data => {
                        if (data.riwayat && data.riwayat.length > 0) {
                            this.riwayat = data.riwayat;
                        } else {
                            this.riwayat = [
                                { role: 'assistant', content: this.defaultWelcome }
                            ];
                        }
                        this.scrollToBottom();
                    })
                    .catch(() => {
                        this.riwayat = [
                            { role: 'assistant', content: this.defaultWelcome }
                        ];
                    });
            },

            toggleChat() {
                this.terbuka = !this.terbuka;
                if (this.terbuka) {
                    this.scrollToBottom();
                }
            },

            kirimTemplate(teks) {
                this.pesanBaru = teks;
                this.kirimPesan();
            },

            kirimPesan() {
                const pesan = this.pesanBaru.trim();
                if (!pesan || this.sedangMemuat) return;

                // Push pesan user ke riwayat lokal terlebih dahulu
                this.riwayat.push({ role: 'user', content: pesan });
                this.pesanBaru = '';
                this.sedangMemuat = true;
                this.scrollToBottom();

                fetch('{{ route("chatbot.kirim") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({ pesan: pesan })
                })
                .then(res => {
                    if (!res.ok) throw new Error('API Error');
                    return res.json();
                })
                .then(data => {
                    this.riwayat = data.riwayat;
                    this.sedangMemuat = false;
                    this.scrollToBottom();
                })
                .catch(() => {
                    this.riwayat.push({
                        role: 'assistant',
                        content: 'Waduh, sepertinya jaringan MinGAP sedang terganggu. Mari coba bicara beberapa saat lagi ya, Warga Bandung!'
                    });
                    this.sedangMemuat = false;
                    this.scrollToBottom();
                });
            },

            bersihkanRiwayat() {
                if (confirm('Apakah Anda ingin mereset obrolan dengan MinGAP?')) {
                    fetch('{{ route("chatbot.reset") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrf
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.sukses) {
                            this.riwayat = [
                                { role: 'assistant', content: this.defaultWelcome }
                            ];
                            this.scrollToBottom();
                        }
                    });
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('minGapMessageContainer');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);
            },

            formatPesan(content) {
                if (!content) return '';
                let html = content;
                
                // Escape HTML chars
                html = html.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                
                // Parse markdown-like tags
                // **bold**
                html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                // *italic*
                html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
                
                // Format line breaks
                html = html.replace(/\n/g, '<br>');
                
                return html;
            }
        }
    }
</script>

<style>
    /* Styling scrollbar tipis untuk container chat */
    #minGapMessageContainer::-webkit-scrollbar {
        width: 4px;
    }
    #minGapMessageContainer::-webkit-scrollbar-track {
        background: transparent;
    }
    #minGapMessageContainer::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.3);
        border-radius: 9999px;
    }
    #minGapMessageContainer::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.5);
    }
    
    /* Utility class hide scrollbar */
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<!-- ========================================================= -->
