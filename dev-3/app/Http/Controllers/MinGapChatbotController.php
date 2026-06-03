<?php

// =========================================================
// SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3]
// =========================================================

namespace App\Http\Controllers;

use App\Services\MinGapAiService;
use Illuminate\Http\Request;

class MinGapChatbotController extends Controller
{
    protected $aiService;

    public function __construct(MinGapAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function ambilRiwayat()
    {
        $riwayat = session()->get('mingap_chat_history', []);
        return response()->json(['riwayat' => $riwayat]);
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'pesan' => ['required', 'string', 'max:1000']
        ]);

        $pesan = trim($request->input('pesan'));
        $riwayat = session()->get('mingap_chat_history', []);

        $jawaban = $this->aiService->tanyaAi($pesan, $riwayat);

        $riwayat[] = ['role' => 'user', 'content' => $pesan];
        $riwayat[] = ['role' => 'assistant', 'content' => $jawaban];

        // Batasi riwayat percakapan maksimal 20 pesan untuk efisiensi session
        if (count($riwayat) > 20) {
            $riwayat = array_slice($riwayat, -20);
        }

        session()->put('mingap_chat_history', $riwayat);

        return response()->json([
            'jawaban' => $jawaban,
            'riwayat' => $riwayat
        ]);
    }

    public function bersihkanRiwayat()
    {
        session()->forget('mingap_chat_history');
        return response()->json(['sukses' => true]);
    }
}

// =========================================================
