<div style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-family: sans-serif;">
        
        <thead style="background-color: #111827; color: white;">
            <tr>
                <th style="padding: 12px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; width: 5%;">No</th>
                <th style="padding: 12px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Kode Gejala</th>
                <th style="padding: 12px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Nama Gejala</th> <th style="padding: 12px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 20%;">Jawaban</th>
                <th style="padding: 12px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; text-align: right; width: 10%;">Nilai CF</th>
            </tr>
        </thead>

        <tbody>
            @if($getRecord()->pemeriksaan && $getRecord()->pemeriksaan->jawaban)
                @foreach ($getRecord()->pemeriksaan->jawaban as $index => $item)
                    
                    @php
                        // Logic Warna
                        $bg = '#f3f4f6'; $text = '#374151'; $border = '#d1d5db'; $iconColor = '#9ca3af';

                        if($item->jawaban_text == 'Selalu') {
                            $bg = '#fef2f2'; $text = '#b91c1c'; $border = '#fecaca'; $iconColor = '#ef4444';
                        } elseif($item->jawaban_text == 'Cukup Sering') {
                            $bg = '#fff7ed'; $text = '#c2410c'; $border = '#fed7aa'; $iconColor = '#f97316';
                        } elseif($item->jawaban_text == 'Kadang-kadang') {
                            $bg = '#eff6ff'; $text = '#1d4ed8'; $border = '#bfdbfe'; $iconColor = '#3b82f6';
                        } elseif($item->jawaban_text == 'Tidak Pernah') {
                            $bg = '#f0fdf4'; $text = '#15803d'; $border = '#bbf7d0'; $iconColor = '#22c55e';
                        }

                        // LOGIC KODE GEJALA (G00, G01, ...)
                        // Prioritas 1: Ambil dari kolom 'kode_gejala' di database (jika ada relasi)
                        // Prioritas 2: Generate manual (ID - 1)
                        $kodeGejala = $item->gejala->kode_gejala ?? 'G' . str_pad($item->id_gejala - 1, 2, '0', STR_PAD_LEFT);
                    @endphp

                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px 16px; color: #6b7280; font-size: 14px;">
                            {{ $index + 1 }}
                        </td>

                        {{-- KOLOM KODE GEJALA --}}
                        <td style="padding: 12px 16px;">
                            <span style="font-family: monospace; font-weight: bold; background-color: #e5e7eb; padding: 4px 8px; border-radius: 4px; color: #374151; font-size: 12px;">
                                {{ $kodeGejala }}
                            </span>
                        </td>

                        {{-- KOLOM NAMA GEJALA --}}
                        <td style="padding: 12px 16px; font-size: 14px; font-weight: 500; color: #111827;">
                            {{ $item->gejala->deskripsi ?? $item->gejala->nama_gejala ?? 'Gejala Tidak Ditemukan' }}
                        </td>

                        {{-- KOLOM JAWABAN USER --}}
                        <td style="padding: 12px 16px; text-align: center;">
                            <span style="
                                display: inline-flex; 
                                align-items: center; 
                                padding: 4px 10px; 
                                border-radius: 9999px; 
                                font-size: 11px; 
                                font-weight: bold; 
                                background-color: {{ $bg }}; 
                                color: {{ $text }}; 
                                border: 1px solid {{ $border }};
                            ">
                                <span style="
                                    display: inline-block; 
                                    width: 8px; 
                                    height: 8px; 
                                    border-radius: 50%; 
                                    background-color: {{ $iconColor }}; 
                                    margin-right: 6px;
                                "></span>
                                {{ strtoupper($item->jawaban_text) }}
                            </span>
                        </td>

                        <td style="padding: 12px 16px; text-align: right; font-family: monospace; font-weight: bold; font-size: 14px; color: #111827;">
                            {{ number_format($item->nilai_cf, 2) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #9ca3af;">
                        Tidak ada data jawaban ditemukan.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div style="background-color: #f9fafb; padding: 10px 16px; text-align: right; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb;">
        Total Gejala: {{ count($getRecord()->pemeriksaan->jawaban ?? []) }}
    </div>
</div>