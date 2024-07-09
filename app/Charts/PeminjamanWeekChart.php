<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\transaksi;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PeminjamanWeekChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data transaksi berdasarkan status dalam satu minggu
        $transaksi = transaksi::whereIn('status', ['Selesai', 'Selesai Terlambat'])
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('l'); // Mengelompokkan berdasarkan hari
            });

        // Menghitung jumlah peminjaman per hari dalam seminggu
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $dates = [];
        $peminjamanPerHari = [];
        foreach ($days as $day) {
            $dayDate = Carbon::now()->startOfWeek()->modify($day)->format('l - d, M');
            $dates[] = $dayDate;
            $peminjamanPerHari[] = isset($transaksi[$day]) ? $transaksi[$day]->count() : 0;
        }

        return $this->chart->barChart()
            //->setTitle('Jumlah Peminjaman per Hari')
            ->setSubtitle('Data Peminjaman per Hari dalam Minggu Ini')
            ->addData('Peminjaman', $peminjamanPerHari)
            ->setXAxis($dates);
    }
}
