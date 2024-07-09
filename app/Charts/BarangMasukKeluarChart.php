<?php

namespace App\Charts;

use App\Models\barangmasuk;
use App\Models\barangkeluar;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarangMasukKeluarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $barangmasuk = barangmasuk::all()->count();
        $barangkeluar = barangkeluar::all()->count();

        return $this->chart->barChart()
            ->setTitle('Jumlah Barang Masuk & Barang Keluar')
            ->setSubtitle(date('Y'))
            ->addData('Jumlah', [$barangmasuk, $barangkeluar])
            ->setLabels(['Barang Masuk', 'Barang Keluar']);
    }
}
