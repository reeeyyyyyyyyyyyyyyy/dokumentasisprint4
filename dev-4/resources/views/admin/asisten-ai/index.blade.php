@extends('admin.layout')

@section('judulHalaman', 'Asisten Keputusan AI')
@section('subjudulHalaman', 'Analisis kelayakan anggaran pengajuan dan rekomendasi prioritas perbaikan infrastruktur')

@section('konten')
<!-- ========================================================= -->
<!-- SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4] -->
<!-- ========================================================= -->
<div class="h-[calc(100vh-12rem)] flex flex-col md:flex-row gap-5" x-data="adminChatbot()">
    <!-- Panel Kiri: Informasi Petunjuk Penggunaan -->
    <div class="w-full md:w-80 flex-shrink-0 flex flex-col gap-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-sm font-bold text-slate-850 dark:text-white">Panduan Asisten</div>
            </div>
            
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-3">
                Asisten AI ini membantu Anda mempermudah audit anggaran pengajuan perbaikan yang diajukan oleh Admin Daerah.
            </p>
            <ul class="text-[11px] text-slate-500 dark:text-slate-400 space-y-2.5 list-disc pl-4 leading-relaxed">
                <li>
                    <strong class="text-slate-700 dark:text-slate-300">Deteksi Selisih:</strong> Menghitung kewajaran nominal pengajuan dibanding estimasi otomatis AI.
                </li>
                <li>
                    <strong class="text-slate-700 dark:text-slate-300">Rekomendasi Urgensi:</strong> Mengelompokkan urgensi pengerjaan menjadi Tinggi, Sedang, atau Rendah.
                </li>
                <li>
                    <strong class="text-slate-700 dark:text-slate-300">Pemicu Halaman Detail:</strong> Buka salah satu detail laporan, lalu klik tombol analisis untuk memicu resume otomatis di sini.
                </li>
            </ul>
        </div>

        <div class="bg-indigo-50/50 dark:bg-slate-900 border border-indigo-100/50 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2.5 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <div class="text-xs font-bold text-indigo-950 dark:text-indigo-350">Status Integrasi Sistem</div>
            </div>
            <div class="text-[11px] text-indigo-900/70 dark:text-slate-400 leading-relaxed space-y-1">
                <div>Model: <span class="font-mono font-semibold">gpt-4o-mini</span></div>
                <div>Status API: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Aktif</span></div>
                <div>Koneksi Database: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Terhubung</span></div>
            </div>
        </div>
    </div>

    <!-- Panel Kanan: Area Chatbot Utama -->
    <div class="flex-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col h-full">
        <!-- Header Chat -->
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white border border-indigo-700 shadow-sm shadow-indigo-600/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-slate-850 dark:text-white">Pusat Keputusan SIGAP AI</div>
                    <div class="text-[10px] text-slate-400 mt-0.5 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Penasihat Finansial & Prioritas Kota
                    </div>
                </div>
            </div>
            
            <button @click="bersihkanRiwayat()" 
                class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-slate-400 hover:text-red-500 transition-colors duration-200"
                title="Reset Obrolan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>

        <!-- Chat Area -->
        <div id="adminChatContainer" class="flex-1 overflow-y-auto p-5 space-y-4">
            <template x-for="(chat, index) in riwayat" :key="index">
                <div :class="chat.role === 'user' ? 'flex justify-end' : 'flex justify-start gap-3'">
                    <!-- Avatar AI -->
                    <template x-if="chat.role !== 'user'">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-slate-800 border border-indigo-100/50 dark:border-slate-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Bubble Chat -->
                    <div :class="chat.role === 'user' 
                        ? 'bg-brand-600 text-white rounded-2xl rounded-tr-none px-4 py-2.5 text-xs max-w-[75%] shadow-sm' 
                        : 'bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80 text-slate-850 dark:text-slate-100 rounded-2xl rounded-tl-none px-4 py-3 text-xs max-w-[75%] shadow-sm leading-relaxed'">
                        <div x-html="formatPesan(chat.content)" class="space-y-2"></div>
                    </div>
                </div>
            </template>

            <!-- Loading Spinner -->
            <div x-show="sedangMemuat" class="flex justify-start gap-3" style="display: none;">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-slate-800 border border-indigo-100/50 dark:border-slate-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800/80 px-4 py-3 rounded-2xl rounded-tl-none flex items-center gap-1.5 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 animate-bounce" style="animation-duration: 0.8s; animation-delay: 0.1s;"></span>
                    <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 animate-bounce" style="animation-duration: 0.8s; animation-delay: 0.25s;"></span>
                    <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-500 animate-bounce" style="animation-duration: 0.8s; animation-delay: 0.4s;"></span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Group (No Emoticons, SVG icons only) -->
        <div class="px-5 py-2.5 border-t border-slate-100 dark:border-slate-800 flex gap-2 overflow-x-auto bg-slate-50/20 dark:bg-slate-900/20 scrollbar-none flex-shrink-0 select-none">
            <button @click="kirimTemplate('Berikan rekomendasi prioritas perbaikan infrastruktur Kota Bandung hari ini berdasarkan tingkat keparahan.')" 
                class="text-[11px] font-semibold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-600 hover:text-indigo-600 dark:hover:border-indigo-500 dark:hover:text-indigo-400 text-slate-650 dark:text-slate-300 rounded-full px-3.5 py-1.5 transition flex items-center gap-1.5 flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
                Rekomendasikan Prioritas Hari Ini
            </button>
            <button @click="kirimTemplate('Bagaimana cara mengevaluasi kewajaran pengajuan dana perbaikan dibandingkan estimasi AI?')" 
                class="text-[11px] font-semibold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-600 hover:text-indigo-600 dark:hover:border-indigo-500 dark:hover:text-indigo-400 text-slate-650 dark:text-slate-300 rounded-full px-3.5 py-1.5 transition flex items-center gap-1.5 flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Cara Mengevaluasi Pengajuan Dana
            </button>
            <button @click="kirimTemplate('Berikan contoh ringkasan analisis keuangan untuk dana perbaikan infrastruktur daerah.')" 
                class="text-[11px] font-semibold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-600 hover:text-indigo-600 dark:hover:border-indigo-500 dark:hover:text-indigo-400 text-slate-650 dark:text-slate-300 rounded-full px-3.5 py-1.5 transition flex items-center gap-1.5 flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Tampilkan Ringkasan Keuangan
            </button>
        </div>

        <!-- Form Input Chat -->
        <form @submit.prevent="kirimPesan()" class="p-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-3 bg-slate-50/30 dark:bg-slate-900/30 flex-shrink-0">
            <input type="text" 
                x-model="pesanBaru" 
                placeholder="Tulis pesan kepemimpinan ke asisten AI..." 
                class="flex-1 text-xs px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-850 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 transition"
                :disabled="sedangMemuat">
            <button type="submit" 
                class="flex items-center justify-center w-10 h-10 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl transition-all duration-200 shadow-md shadow-indigo-600/10 active:scale-95 flex-shrink-0 disabled:opacity-50"
                :disabled="sedangMemuat || !pesanBaru.trim()">
                <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function adminChatbot() {
        return {
            pesanBaru: '',
            sedangMemuat: false,
            riwayat: [],
            csrf: '{{ csrf_token() }}',
            defaultWelcome: 'Selamat datang di Pusat Asisten Keputusan SIGAP, Administrator!\n\nSaya adalah Asisten AI Keputusan Anda. Saya siap membantu Anda menganalisis laporan kerusakan, mengevaluasi kewajaran pengajuan dana perbaikan, dan merumuskan prioritas pengerjaan infrastruktur Kota Bandung.\n\nSilakan pilih tindakan cepat di bawah atau tuliskan pertanyaan Anda langsung pada kolom percakapan.',

            init() {
                // Tarik riwayat awal
                fetch('{{ route("admin.asisten-ai.riwayat") }}')
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

            kirimTemplate(teks) {
                this.pesanBaru = teks;
                this.kirimPesan();
            },

            kirimPesan() {
                const pesan = this.pesanBaru.trim();
                if (!pesan || this.sedangMemuat) return;

                this.riwayat.push({ role: 'user', content: pesan });
                this.pesanBaru = '';
                this.sedangMemuat = true;
                this.scrollToBottom();

                fetch('{{ route("admin.asisten-ai.kirim") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({ pesan: pesan })
                })
                .then(res => {
                    if (!res.ok) throw new Error('API Gagal');
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
                        content: 'Asisten AI sedang mengalami gangguan koneksi. Harap coba beberapa saat lagi.'
                    });
                    this.sedangMemuat = false;
                    this.scrollToBottom();
                });
            },

            bersihkanRiwayat() {
                if (confirm('Apakah Anda ingin mereset obrolan dengan asisten AI?')) {
                    fetch('{{ route("admin.asisten-ai.reset") }}', {
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
                    const container = document.getElementById('adminChatContainer');
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
                
                // Parse markdown bold
                html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                // Parse markdown italic
                html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
                
                // Parse list items
                html = html.replace(/^\s*[-*]\s+(.*)$/gm, '<li class="ml-4 list-disc">$1</li>');
                
                // Format line breaks
                html = html.replace(/\n/g, '<br>');
                
                return html;
            }
        }
    }
</script>

<style>
    #adminChatContainer::-webkit-scrollbar {
        width: 5px;
    }
    #adminChatContainer::-webkit-scrollbar-track {
        background: transparent;
    }
    #adminChatContainer::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.25);
        border-radius: 9999px;
    }
    #adminChatContainer::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.45);
    }
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<!-- ========================================================= -->
@endsection
