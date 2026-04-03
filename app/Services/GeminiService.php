<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = env('GEMINI_API_KEY', '');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent';
    }

    /**
     * Analyze a schedule file (Image or PDF) and return structured JSON data.
     *
     * @param string $path     Absolute path to the uploaded file.
     * @param string $mimeType MIME type of the file (e.g. image/jpeg, application/pdf).
     * @return array|null      Structured array with student info, courses, conflicts, recommendations.
     */
    public function analyzeSchedule(string $path, string $mimeType): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is not configured.');
            return ['error' => 'API Key missing'];
        }

        try {
            $fileData = base64_encode(file_get_contents($path));

            $prompt = <<<'PROMPT'
Kamu adalah asisten penjadwalan universitas yang ahli. Analisis dokumen yang diberikan berupa jadwal kuliah mahasiswa (jadwal perkuliahan universitas).

Ekstrak SEMUA informasi dan kembalikan HANYA objek JSON yang valid (tanpa markdown, tanpa code fence, tanpa teks tambahan apapun) dengan struktur PERSIS seperti ini:

{
  "student": {
    "name": "nama lengkap mahasiswa",
    "nim": "nomor induk mahasiswa",
    "program": "nama program studi",
    "semester": "label semester contoh: 2025-2026 / Genap",
    "advisor": "nama dosen wali",
    "period": "periode jadwal contoh: 02 Maret 2026 – 13 Juni 2026"
  },
  "courses": [
    {
      "day": "hari dalam bahasa Indonesia dengan huruf kapital: SENIN, SELASA, RABU, KAMIS, JUMAT, atau SABTU",
      "name": "nama mata kuliah",
      "code": "kode mata kuliah",
      "credits": 3,
      "class": "kelas contoh: A2",
      "lecturer": "nama dosen pengampu",
      "time_start": "HH:MM",
      "time_end": "HH:MM",
      "room": "kode ruangan"
    }
  ],
  "conflicts": [
    {
      "day": "hari terjadinya konflik",
      "description": "deskripsi jelas mengenai tumpang tindih jadwal dalam Bahasa Indonesia",
      "courses_involved": ["Nama Mata Kuliah A", "Nama Mata Kuliah B"]
    }
  ],
  "recommendations": [
    "Rekomendasi pertama dalam Bahasa Indonesia yang jelas dan actionable.",
    "Rekomendasi kedua dalam Bahasa Indonesia."
  ],
  "total_credits": 20,
  "conflict_count": 0
}

Aturan wajib:
- Semua rekomendasi HARUS ditulis dalam Bahasa Indonesia yang baik dan benar.
- Semua deskripsi konflik HARUS dalam Bahasa Indonesia.
- Jika tidak ada konflik, kembalikan "conflicts" sebagai array kosong [] dan "conflict_count" sebagai 0.
- Waktu harus dalam format HH:MM 24 jam.
- Ekstrak setiap baris mata kuliah yang terlihat dalam dokumen.
- Kembalikan HANYA objek JSON mentah, tidak ada hal lain.
PROMPT;

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data'      => $fileData,
                                ]
                            ],
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'      => 0.1,
                    'responseMimeType' => 'application/json',
                ],
            ];

            $response = Http::timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$this->baseUrl}?key={$this->apiKey}", $payload);

            if ($response->successful()) {
                $result  = $response->json();
                $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Strip any accidental markdown fences
                $rawText = preg_replace('/^```(?:json)?\s*/i', '', trim($rawText));
                $rawText = preg_replace('/\s*```$/', '', $rawText);

                $parsed = json_decode($rawText, true);

                if (json_last_error() !== JSON_ERROR_NONE || !isset($parsed['courses'])) {
                    Log::warning('Gemini returned non-JSON or unexpected structure. Raw: ' . $rawText);
                    return [
                        'success'  => false,
                        'raw_text' => $rawText,
                        'error'    => 'Tidak dapat memproses respons terstruktur dari AI.',
                    ];
                }

                return [
                    'success' => true,
                    'data'    => $parsed,
                ];

            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return [
                    'success' => false,
                    'error'   => $response->json('error.message', 'Terjadi kesalahan yang tidak diketahui.'),
                ];
            }

        } catch (\Exception $e) {
            Log::error('Gemini Analysis Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
