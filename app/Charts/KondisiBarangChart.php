<?php

namespace App\Charts;

use App\Models\barang; // Adjust this based on your actual namespace
use ArielMejiaDev\LarapexCharts\LarapexChart;

class KondisiBarangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // Retrieve data from the model
        $barang = Barang::all(); // Make sure to use correct model name and adjust namespace if necessary

        // Calculate counts based on kondisibarang field
        $barangRusak = $barang->where('kondisi', 'Rusak')->count();
        $barangAman = $barang->where('kondisi', 'Baik')->count();

        // Build the pie chart
        return $this->chart->pieChart()
            ->setTitle('Kondisi Barang Inventaris ')
            ->setSubtitle(date('Y'))
            ->addData([$barangRusak, $barangAman]) // Pass the counts as an array
            ->setLabels(['Barang Rusak', 'Barang Aman']); // Set labels for the pie chart sections
    }
}
