<?php

namespace App\Charts;

use App\Models\transaksi;
use Illuminate\Support\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarangBelumDikembalikanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        // Mengambil data transaksi berdasarkan status 'Sedang Dipinjam'
        $barangTidakDikembalikan = transaksi::where('status', 'Sedang Dipinjam')
            ->selectRaw('MONTH(waktupinjam) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Menyiapkan label untuk 12 bulan
        $labels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        })->toArray();

        // Menyiapkan data untuk chart
        $data = array_fill(0, 12, 0);
        foreach ($barangTidakDikembalikan as $item) {
            $data[$item->month - 1] = $item->total;
        }

        return $this->chart->horizontalBarChart()
            ->setTitle('Jumlah Barang Tidak Dikembalikan')
            ->setSubtitle('Berdasarkan Bulan Waktu Pinjam')
            ->addData('Barang Tidak Dikembalikan', $data)
            ->setXAxis($labels);
    }
}
