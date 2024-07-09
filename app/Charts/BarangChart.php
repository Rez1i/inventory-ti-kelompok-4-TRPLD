<?php

namespace App\Charts;

use App\Models\barang;
use App\Models\baranghp;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $barang = barang::all()->count();
        $baranghp = baranghp::all()->count();

        return $this->chart->pieChart()
            ->setTitle('Kategori Barang Inventaris')
            ->setSubtitle(date('Y'))
            ->addData([$barang, $baranghp])
            ->setLabels(['Barang Non Habis Pakai', 'Barang Habis Pakai']);
    }
}
