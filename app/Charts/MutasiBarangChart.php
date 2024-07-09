<?php

namespace App\Charts;

use App\Models\mutasibarang;
use Illuminate\Support\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MutasiBarangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data mutasi barang berdasarkan bulan dan tahun dari kolom created_at
        $mutasiBarang = MutasiBarang::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(banyakbarang) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        // Menyiapkan label untuk 12 bulan
        $labels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        })->toArray();

        // Menyiapkan data untuk chart
        $data = array_fill(0, 12, 0);
        foreach ($mutasiBarang as $mutasi) {
            $data[$mutasi->month - 1] = $mutasi->total;
        }

        return $this->chart->barChart()
            ->setTitle('Jumlah Mutasi Barang')
            ->setSubtitle(date('Y'))
            ->addData('Banyak Barang', $data)
            ->setLabels($labels);
    }
}
