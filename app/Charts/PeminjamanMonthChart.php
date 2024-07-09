<?php

namespace App\Charts;

use App\Models\transaksi;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PeminjamanMonthChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data transaksi berdasarkan status
        $transaksi = transaksi::whereIn('status', ['Selesai', 'Selesai Terlambat'])
            ->get()
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('m');
            });

        // Menghitung jumlah peminjaman per bulan
        $peminjamanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Menambahkan leading zero untuk format bulan
            $peminjamanPerBulan[] = isset($transaksi[$month]) ? $transaksi[$month]->count() : 0;
        }

        return $this->chart->barChart()
            //->setTitle('Jumlah Peminjaman per Bulan')
            ->setSubtitle('Data Peminjaman per Bulan')
            ->addData('Peminjaman', $peminjamanPerBulan)
            ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
    }
}
