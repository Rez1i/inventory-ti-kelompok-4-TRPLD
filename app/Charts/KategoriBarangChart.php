<?php

namespace App\Charts;

use App\Models\JenisBarang;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class KategoriBarangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        // Mengambil data jenis barang berdasarkan kategori
        $jenisBarangs = JenisBarang::select('jenisbarangs.nama_jenisbarang', 'jenisbarangs.jumlahbarang', 'kategoribarangs.nama_kategoribarang as kategori_name')
            ->join('kategoribarangs', 'jenisbarangs.kategoribarang_id', '=', 'kategoribarangs.id')
            ->get();

        // Mengelompokkan data jenis barang berdasarkan kategori
        $dataSeries = [];
        $allJenisNames = [];
        $categories = [];

        foreach ($jenisBarangs as $jenisBarang) {
            if ($jenisBarang->jumlahbarang > 0) {
                $kategoriName = $jenisBarang->kategori_name;
                $jenisName = $jenisBarang->nama_jenisbarang;

                if (!isset($dataSeries[$kategoriName])) {
                    $dataSeries[$kategoriName] = [];
                }

                $dataSeries[$kategoriName][$jenisName] = $jenisBarang->jumlahbarang;
                $allJenisNames[$jenisName] = true;

                if (!in_array($kategoriName, $categories)) {
                    $categories[] = $kategoriName;
                }
            }
        }

        // Daftar warna untuk setiap jenis barang
        $colors = ['#FFC107', '#D32F2F', '#1976D2', '#388E3C', '#FBC02D', '#7B1FA2', '#E64A19'];

        // Membuat chart
        $chart = $this->chart->horizontalBarChart()
            ->setTitle('Jumlah Barang per Jenis Barang dan Kategori')
            ->setSubtitle('Data berdasarkan jenis barang dan kategori');

        // Menambahkan data untuk setiap jenis barang berdasarkan kategori
        $colorIndex = 0;
        $jenisColors = []; // Untuk menyimpan warna untuk setiap jenis barang

        foreach ($dataSeries as $kategoriName => $jenisBarangs) {
            $kategoriData = [];
            foreach ($allJenisNames as $jenisName => $_) {
                $kategoriData[] = $jenisBarangs[$jenisName] ?? 0; // Mengisi 0 jika tidak ada data
            }

            // Menambahkan data ke chart dengan nama kategori
            $chart->addData($kategoriName, $kategoriData);

            // Set warna untuk setiap jenis barang jika belum ditetapkan
            foreach ($jenisBarangs as $jenisName => $jumlahBarang) {
                if (!isset($jenisColors[$jenisName])) {
                    $jenisColors[$jenisName] = $colors[$colorIndex % count($colors)];
                    $colorIndex++;
                }
            }
        }

        // Set warna pada chart
        $chart->setColors(array_values($jenisColors));

        // Set xAxis dan kembalikan chart
        return $chart->setXAxis(array_keys($allJenisNames));
    }
}
