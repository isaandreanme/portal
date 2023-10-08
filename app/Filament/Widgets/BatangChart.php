<?php

namespace App\Filament\Widgets;

use App\Models\DataPmi;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class BatangChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'batangChart';
    protected static ?int $sort = -1;


    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'KANTOR 2';
    protected static ?string $subheading = 'KANTOR CABANG';

    // protected static ?string $footer = '*Data yang ditampilkan adalah hasil input dan update Stageholder tiap Kantor Cabang';


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $DATAPMI = DataPmi::where('kantor_id', '2')->where('status_id', '2')->count();
        $MEDICAL = DataPmi::where('kantor_id', '2')->where('medical_check', '1')->where('status_id', '2')->count();

        $NONJOB = DataPmi::where('kantor_id', '2')->where('job', '0')->where('status_id', '2')->count();
        $JOB = DataPmi::where('kantor_id', '2')->where('job', '1')->where('status_id', '2')->count();

        $PMIFINISH = DataPmi::where('kantor_id', '2')->where('status_id', '4')->count();
        $PMIMD = DataPmi::where('kantor_id', '2')->where('status_id', '6')->count();
        $PMIPENDING = DataPmi::where('kantor_id', '2')->where('status_id', '5')->count();
        $FIT = DataPmi::where('kantor_id', '2')->where('fit', '1')->where('status_id', '2')->count();
        $UNFIT = DataPmi::where('kantor_id', '2')->where('fit', '0')->count();
        $TERBANG = DataPmi::where('kantor_id', '2')->where('status_id', '3')->count();

        $TERDAFTARSIAPKERJA = DataPmi::where('kantor_id', '2')->where('status_id', '2')->where('siapkerja', '1')->count();
        $VERDATA = DataPmi::where('kantor_id', '2')->where('verdata', '1')->count();
        $VERPP = DataPmi::where('kantor_id', '2')->where('verpp', '1')->where('status_id', '2')->count();
        $MARKET = DataPmi::where('kantor_id', '2')->where('status_id', '2')->where('agency_id', '1')->count();
        $NONMARKET = DataPmi::where('kantor_id', '2')->where('status_id', '2')->where('agency_id', '22')->count();

        $DIPROSES = $DATAPMI;
        $TOTALJOB = $JOB;
        $TOTALNONJOB = $NONJOB;

        $TOTALSIAPKERJA = $TERDAFTARSIAPKERJA;
        $TOTALVERDATA = $VERDATA;
        $TOTALVERPP = $VERPP;
        $TOTALMEDICAL = $MEDICAL;
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
            ],
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => [
                        $TOTALMEDICAL,
                        $DIPROSES,
                        $MARKET,
                        $NONMARKET,
                        $TOTALNONJOB,
                        $TOTALJOB,
                        $TOTALSIAPKERJA,
                        $TOTALVERPP,
                        $TERBANG,
                        $PMIFINISH,
                        $PMIMD,
                        $PMIPENDING,
                    ]
                ],
            ],
            'xaxis' => [
                'categories' => [
                    'TOTAL MEDICAL',
                    'DIPROSES',
                    'MARKET',
                    'UNMARKET',
                    'NON JOB',
                    'GET JOB',
                    'SIAPKERJA',
                    'ID-CPMI',
                    'TERBANG',
                    'FINISH',
                    'MD',
                    'PENDING',

                ],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#6366f1'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 0,
                    'horizontal' => true,
                ],
            ],
            'grid' => [
                'show' => true,
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
            'colors' => ['#facc15', '#38bdf8'],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'horizontal',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => ['#f43f5e'],
                    'inverseColors' => false,
                    'opacityFrom' => 1,
                    'opacityTo' => 1,
                    'stops' => [0, 100],
                ],
            ],
            // 'annotations' => [
            //     'xaxis' => [
            //         [
            //             'x' => 25,
            //             'x2' => 30,
            //             'fillColor' => '#f43f5e',
            //             'opacity' => 0.2,
            //         ],
            //     ],
            // ],
        ];
    }
}
