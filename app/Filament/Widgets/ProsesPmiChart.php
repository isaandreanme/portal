<?php

namespace App\Filament\Widgets;

use App\Models\DataPmi;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProsesPmiChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'prosesPmiChart';
    // protected static ?string $footer = '**Data yang ditampilkan adalah hasil input dan update Stageholder tiap Kantor Cabang';


    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'PROSES PMI';
    protected static ?string $subheading = 'ALL KANTOR CABANG';

    protected static ?int $sort = -3;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected int | string | array $columnSpan = 'full';
    protected function getOptions(): array
    {

        $DATAPMI = DataPmi::all()->where('status_id','2')->count();
        $MEDICAL = DataPmi::where('medical_check','1')->where('status_id','2')->count();
        
        $NONJOB = DataPmi::where('job','0')->where('status_id','2')->count();
        $JOB = DataPmi::where('job','1')->where('status_id','2')->count();
        
        $PMIFINISH = DataPmi::where('status_id','4')->count();
        $PMIMD = DataPmi::where('status_id','6')->count();
        $PMIPENDING = DataPmi::where('status_id','5')->count();
        $FIT = DataPmi::where('fit','1')->where('status_id','2')->count();
        $UNFIT = DataPmi::where('fit','0')->where('status_id','2')->count();
        $TERBANG = DataPmi::where('status_id','3')->count();
        
        $TERDAFTARSIAPKERJA = DataPmi::where('siapkerja','1')->where('status_id','2')->count();
        $VERDATA = DataPmi::where('verdata','1')->where('status_id','2')->count();
        $VERPP = DataPmi::where('verpp','1')->where('status_id','2')->count();

        //----------------------------------------------------------------

        $jumlahDataPmi = DataPmi::all()->count();
        $PMIFinish = DataPmi::where('status_id','4')->count();
        $PMIMD = DataPmi::where('status_id','6')->count();
        $PMIPending = DataPmi::where('status_id','5')->count();
        $TERBANG = DataPmi::where('status_id','3')->count();
        $UNFIT = DataPmi::where('fit','0')->count();

        $MARKET = DataPmi::all()->where('status_id','2')->where('agency_id','1')->count();
        $NONMARKET = DataPmi::all()->where('status_id','2')->where('agency_id','22')->count();

        

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
                'height' => 290,
            ],
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => [
                        $TOTALJOB, 
                        $TOTALNONJOB,
                        $MARKET,
                        $NONMARKET,
                        $TERDAFTARSIAPKERJA,
                        $VERPP,
                    ],
                ],
            ],
            'xaxis' => [
                'categories' => ['GET JOB','NON JOB','ON MARKET','UNMARKET','SIAPKERJA','ID CPMI'],
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