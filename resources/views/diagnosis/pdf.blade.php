<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Diagnosis Burnout</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; }
        
        .header { background: linear-gradient(135deg, #4f46e5, #1e40af); color: #fff; padding: 24px 30px; margin-bottom: 0; }
        .header h1 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .header p { font-size: 10px; opacity: 0.7; }
        
        .content { padding: 24px 30px; }
        
        .info-section { border: 1px solid #e2e8f0; border-radius: 12px; padding: 0; margin-bottom: 25px; overflow: hidden; }
        .info-header { background: #f8fafc; padding: 12px 20px; border-bottom: 1px solid #e2e8f0; }
        .info-header h3 { font-size: 11px; color: #4f46e5; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 800; }
        .info-body { padding: 15px 20px; }
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid td { padding: 6px 0; vertical-align: top; }
        .info-label { font-size: 9px; color: #64748b; font-weight: 600; width: 110px; }
        .info-value { font-size: 10px; color: #1e293b; font-weight: 700; }
        
        .result-box { padding: 16px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .result-rendah { background: #dcfce7; border: 2px solid #16a34a; }
        .result-sedang { background: #fef3c7; border: 2px solid #d97706; }
        .result-tinggi { background: #fee2e2; border: 2px solid #dc2626; }
        
        .result-score { font-size: 36px; font-weight: 800; margin-bottom: 4px; }
        .result-label { font-size: 14px; font-weight: 700; }
        
        .section-title { font-size: 12px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #4f46e5; padding-bottom: 6px; margin-bottom: 12px; }
        
        .dimension-row { display: flex; align-items: center; margin-bottom: 10px; }
        .dimension-name { width: 130px; font-size: 10px; font-weight: 600; color: #475569; }
        .dimension-bar-bg { flex: 1; height: 8px; background: #f1f5f9; border-radius: 4px; margin: 0 10px; }
        .dimension-bar { height: 100%; border-radius: 4px; }
        .dimension-score { width: 35px; text-align: right; font-size: 10px; font-weight: 700; color: #1e293b; }
        
        .var-table { width: 100%; border-collapse: collapse; font-size: 10px; }
        .var-table th { background: #f1f5f9; padding: 8px; text-align: left; font-weight: 700; color: #475569; border-bottom: 1px solid #e2e8f0; }
        .var-table td { padding: 7px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .var-table tr:last-child td { border-bottom: none; }
        
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: 700; }
        .badge-baik { background: #dcfce7; color: #16a34a; }
        .badge-cukup { background: #fef3c7; color: #d97706; }
        .badge-perlu { background: #fee2e2; color: #dc2626; }
        
        .rekomendasi-box { background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 14px; margin-bottom: 20px; }
        .rekomendasi-box p { line-height: 1.7; color: #374151; font-size: 10.5px; }
        
        .footer { background: #f8fafc; padding: 12px 30px; border-top: 1px solid #e2e8f0; font-size: 9px; color: #94a3b8; display: flex; justify-content: space-between; }
        
        .risiko-tinggi-box { background: #fff1f2; border: 1px solid #fecdd3; border-radius: 8px; padding: 12px; margin-top: 16px; }
        .risiko-tinggi-box h4 { font-size: 11px; color: #dc2626; margin-bottom: 6px; }
        .risiko-tinggi-box p { font-size: 10px; color: #6b7280; line-height: 1.6; }
    </style>
</head>
<body>

<div class="header">
    <table width="100%">
        <tr>
            <td>
                <h1>🧠 Laporan Diagnosis Burnout Mahasiswa</h1>
                <p>Sistem Pakar Berbasis Pengetahuan (SBP) &mdash; Certainty Factor Rule-Based System</p>
            </td>
            <td style="text-align:right;vertical-align:top">
                <p style="font-size:9px;opacity:0.7">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
                <p style="font-size:9px;opacity:0.7">ID: #{{ $session->id }}</p>
            </td>
        </tr>
    </table>
</div>

<div class="content">
    {{-- Informasi Mahasiswa --}}
    <div class="info-section">
        <div class="info-header">
            <h3>Identitas Mahasiswa</h3>
        </div>
        <div class="info-body">
            <table class="info-grid">
                <tr>
                    <td class="info-label">Nama Lengkap</td>
                    <td class="info-value">: {{ $session->user->name }}</td>
                    <td class="info-label">ID Diagnosis</td>
                    <td class="info-value">: #{{ $session->id }}</td>
                </tr>
                <tr>
                    <td class="info-label">Nomor Induk (NIM)</td>
                    <td class="info-value">: {{ $session->user->nim ?? '-' }}</td>
                    <td class="info-label">Tgl Diagnosis</td>
                    <td class="info-value">: {{ $session->created_at->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Program Studi</td>
                    <td class="info-value">: {{ $session->user->jurusan ?? '-' }}</td>
                    <td class="info-label">Waktu Selesai</td>
                    <td class="info-value">: {{ $session->created_at->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="info-label">Angkatan</td>
                    <td class="info-value">: {{ $session->user->angkatan ?? '-' }}</td>
                    <td class="info-label">Metode Analisis</td>
                    <td class="info-value">: Certainty Factor</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Hasil Utama --}}
    <div class="section-title">Hasil Diagnosis</div>
    <table width="100%">
        <tr>
            <td width="100%" style="text-align:center;padding-right:16px">
                <div class="result-box result-{{ strtolower($session->burnout_level ?? 'medium') }}">
                    @php $colors = ['Rendah'=>'#16a34a','Sedang'=>'#d97706','Tinggi'=>'#dc2626', 'Low'=>'#16a34a','Medium'=>'#d97706','High'=>'#dc2626']; @endphp
                    <div class="result-score" style="color:{{ $colors[$session->burnout_level ?? 'Medium'] }}">{{ number_format($session->cf_hasil * 100, 1) }}%</div>
                    <div style="font-size:10px;color:#64748b;margin-bottom:4px">Tingkat Kepastian (CF)</div>
                    <div class="result-label" style="color:{{ $colors[$session->burnout_level ?? 'Medium'] }}">
                        RISIKO {{ strtoupper($session->burnout_level ?? 'Medium') }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- Rekomendasi --}}
    <div class="section-title" style="margin-top:20px">Rekomendasi Pakar</div>
    <div class="rekomendasi-box">
        <p><strong>Saran Utama:</strong> {{ $session->rekomendasi }}</p>
    </div>

    {{-- Inference Trace --}}
    <div class="section-title">Logika Diagnosis (Inference Trace)</div>
    <div style="background:#f8fafc;padding:12px;border-radius:8px;margin-bottom:20px">
        <p style="font-size:9px;color:#64748b;margin-bottom:10px">Sistem mendeteksi kondisi Anda berdasarkan aturan pakar berikut:</p>
        @if($session->penjelasan && count($session->penjelasan) > 0)
            @foreach($session->penjelasan as $trace)
            <div style="margin-bottom:10px;border-bottom:1px dashed #cbd5e1;padding-bottom:6px">
                <div style="display:flex;justify-content:space-between">
                    <span style="font-weight:700;font-size:9px;color:#4f46e5">{{ $trace['code'] }}</span>
                    <span style="font-weight:700;font-size:9px;color:#059669">Probabilitas: {{ number_format($trace['cf'] * 100, 1) }}%</span>
                </div>
                <div style="font-size:9px;margin-top:2px"><strong>Logika:</strong> IF {{ $trace['kondisi'] }}</div>
                <div style="font-size:9px;margin-top:1px"><strong>Then:</strong> <strong>{{ $trace['hasil'] }}</strong></div>
            </div>
            @endforeach
        @else
            <p style="font-size:9px;color:#94a3b8;text-align:center;padding:10px">Diagnosis didasarkan pada akumulasi nilai rata-rata variabel (Metode Fallback).</p>
        @endif
    </div>

    {{-- Detail Variabel --}}
    <div class="section-title">Detail Jawaban & Skor Variabel</div>
    <table class="var-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Variabel</th>
                <th>Dimensi</th>
                <th>Nilai</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($detailSkor as $key => $detail)
            <tr>
                <td>{{ $no++ }}</td>
                <td style="font-weight:600">{{ $detail['label'] }}</td>
                <td style="color:#10b981">
                    INFO
                </td>
                <td style="font-weight:700;text-align:center">{{ is_numeric($detail['nilai']) ? round((float)$detail['nilai'], 2) : $detail['nilai'] }}</td>
                <td style="color:#64748b">{{ $detail['opsi_label'] }}</td>
                <td>
                    @if($detail['status']==='baik')
                        <span class="badge badge-baik">Baik</span>
                    @elseif($detail['status']==='cukup')
                        <span class="badge badge-cukup">Cukup</span>
                    @else
                        <span class="badge badge-perlu">Perlu Perhatian</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(in_array($session->burnout_level, ['High', 'Tinggi']))
    <div class="risiko-tinggi-box">
        <h4>⚠️ Peringatan: Risiko Burnout Tinggi</h4>
        <p>Hasil diagnosis menunjukkan Anda berada dalam kondisi burnout yang signifikan. 
        Sangat disarankan untuk segera berkonsultasi dengan <strong>konselor atau psikolog kampus</strong>.
        Jangan ragu untuk meminta bantuan — ini adalah tanda kekuatan, bukan kelemahan.</p>
    </div>
    @endif
</div>

<div class="footer">
    <span>BurnoutCheck &mdash; Sistem Pakar Burnout Mahasiswa</span>
    <span>Dokumen ini bersifat konfidensial. Dicetak otomatis oleh sistem.</span>
    <span>{{ now()->format('d/m/Y') }}</span>
</div>

</body>
</html>
