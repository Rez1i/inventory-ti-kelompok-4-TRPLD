<?php

namespace App\Charts;

use App\Models\transaksi;
use Illuminate\Support\Carbon;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PeminjamanYearChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data transaksi berdasarkan status dalam beberapa tahun terakhir
        $transaksi = transaksi::whereIn('status', ['Selesai', 'Selesai Terlambat'])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y');
            });

        // Menghitung jumlah peminjaman per tahun
        $years = $transaksi->keys();
        $peminjamanPerTahun = [];
        foreach ($years as $year) {
            $peminjamanPerTahun[] = isset($transaksi[$year]) ? $transaksi[$year]->count() : 0;
        }

        return $this->chart->barChart()
            // ->setTitle('Jumlah Peminjaman per Tahun')
            ->setSubtitle('Data Peminjaman per Tahun')
            ->addData('Peminjaman', $peminjamanPerTahun)
            ->setXAxis($years->toArray());
    }
}