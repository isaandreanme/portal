<?php

namespace App\Filament\Resources\DataPmiResource\Pages;

use App\Filament\Resources\DataPmiResource;
use App\Filament\Resources\PendaftaranResource\Widgets\PendaftaranOverview;
use App\Models\DataPmi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListDataPmis extends ListRecords
{
    protected static string $resource = DataPmiResource::class;
    protected ?string $heading = 'DATA PMI';
    protected ?string $subheading = 'List Proses CPMI';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            // PendaftaranOverview::class,

        ];
    }
    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }

    public function getTabs(): array
    {
        return [
            'ALL' => Tab::make('SEMUA')
                ->icon('heroicon-m-user-group')
                ->badge(DataPmi::query()->count()),
            'BARU' => Tab::make('BARU')
                ->badge(DataPmi::query()->where('status_id', '1')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', '1')),
            'ON PROSES' => Tab::make('PROSES')
                ->badge(DataPmi::query()->where('status_id', '2')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', '2')),
            'TERBANG' => Tab::make('TERBANG')
                ->badge(DataPmi::query()->where('status_id', '3')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', '3')),
            'FINISH' => Tab::make('FINISH')
                ->badge(DataPmi::query()->where('status_id', '4')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', '4')),
        ];
    }
}
