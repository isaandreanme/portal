<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use App\Filament\Resources\DataPmiResource;
use App\Models\DataPmi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Split;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction; // Aliaskan tipe Action dari Filament\Notifications\Actions
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class DataPmiRelationManager extends RelationManager
{
    protected static string $relationship = 'DataPmi';
    protected function getCreatedNotification(): ?Notification
    {
        $data = $this->record;

        // Buat tombol "View" dengan tipe yang benar
        $viewButton = NotificationAction::make('Lihat')
            ->url(DataPmiResource::getUrl('view', ['record' => $data]));

        $recipients = User::all();

        foreach ($recipients as $recipient) {
            // Buat notifikasi dengan tombol "View"
            $notification = Notification::make()
                ->title('DATA PMI')
                // ->body('Data CPMI Berhasil Diubah')
                ->body("{$data->pendaftaran->nama} Berhasil Dibuat - {$data->user->name}")
                ->actions([$viewButton]) // Tambahkan tombol "View" ke notifikasi
                // ->send()
                ->persistent()
                ->success()
                ->duration(1000)
                ->sendToDatabase($recipient);
        }

        return $notification;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(1)
                    ->schema([
                        // AlertBox::make()
                        //     ->label(label: 'PERHATIAN.!!!')
                        //     ->helperText(text: 'Untuk Update, Silahkan Di DATA PMI')
                        //     ->resolveIconUsing(name: 'heroicon-o-exclamation')
                        //     ->warning(),
                    ]),
                Section::make('INPUT DATA')
                    ->description('Input Proses Data PMI')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('status_id',)
                                            ->relationship('Status', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Status CPMI')
                                            ->label('Status CPMI')
                                            ->default('1'),
                                        Select::make('kantor_id',)
                                            ->relationship('Kantor', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Kantor Cabang')
                                            ->label('Kantor Cabang'),
                                        Select::make('tujuan_id',)
                                            ->relationship('Tujuan', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Negara Tujuan')
                                            ->label('Negara Tujuan'),
                                        Select::make('pengalaman_id',)
                                            ->relationship('Pengalaman', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Pengalaman')
                                            ->label('Pengalaman CPMI'),
                                        Select::make('marketing_id',)
                                            ->relationship('Marketing', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Marketing')
                                            ->label('Markerting'),
                                        Select::make('sponsor_id',)
                                            ->relationship('Sponsor', 'nama')
                                            ->placeholder('Pilih SPONSOR PL')
                                            ->required()
                                            ->searchable()
                                            ->optionsLimit(10)
                                            ->label('SPONSOR PL')
                                            ->default('2')
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('nama')->unique()
                                            ]),
                                    ])
                            ]),
                        Fieldset::make('')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        Select::make('agency_id',)
                                            ->relationship('Agency', 'nama')
                                            ->required()
                                            ->placeholder('Pilih Agency')
                                            ->label('Agency')
                                            // ->disabled()
                                            ->default('22'),
                                    ])
                            ])
                    ])->columns(2),

                // ----------------------------------------------------------------BATAS
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([9, 25, 50, 100, 'all'])
            ->recordUrl(
                null
            )
            ->columns([
                ImageColumn::make('Pendaftaran.fotopmi')
                    ->label('FOTO')
                    ->circular()
                    ->size(60)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->defaultImageUrl(url('/images/user.svg')),
                TextColumn::make('Pendaftaran.nama')->label('CPMI')->weight('bold')->searchable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),

                TextColumn::make('Tujuan.nama')->label('NEGARA')->color('primary')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('kantor.nama')->label('KANTOR')->color('warning')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('Pendaftaran.regency.name')->label('KOTA ASAL')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),
                SelectColumn::make('status_id')->label('STATUS')
                    ->options([
                        '1' => 'BARU',
                        '2' => 'ON PROSES',
                        '3' => 'TERBANG',
                        '4' => 'FINISH',
                        '5' => 'PENDING',
                        '6' => 'UNFIT',
                        '7' => 'MD',
                    ])->disabled(),
                TextColumn::make('tanggal_terbang')->label('TERBANG')
                    ->date()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('medical_check')
                    ->options([
                        '1' => 'YA',
                        '0' => 'TIDAK',
                    ])
                    ->label('PRA MEDICAL')->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('job')
                    ->options([
                        '1' => 'SUDAH',
                        '0' => 'BELUM',
                    ])
                    ->label('STATUS JOB')->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('siapkerja')
                    ->options([
                        '1' => 'YA',
                        '0' => 'TIDAK',
                    ])
                    ->label('SIAP KERJA')->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('verpp')
                    ->options([
                        '1' => 'YA',
                        '0' => 'TIDAK',
                    ])
                    ->label('ID SIAPKERJA')->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('Sponsor.nama')->label('SPONSOR PL'),
                // TextColumn::make('tanggal_pra_medical')->label('PRA MEDICAL'),
                // TextColumn::make('pendaftaran_id')->searchable()->alignment('left')->label('ID PENDAFTARAN'),
                // TextColumn::make('pra_medical')->label('HASIL')->sortable()->limit(7),
                // TextColumn::make('tanggal_ujk')->sortable()->alignment('left')->label('UJK'),
                // TextColumn::make('tanggal_job')->label('TGL JOB'),
                // TextColumn::make('no_id_pmi')->label('ID PMI')->prefix('ID PMI : ')->weight('bold'),
                // TextColumn::make('tanggal_validasi_paspor')->label('PASPOR')->prefix('TANGGAL VAL-PASPOR : '),
                // TextColumn::make('tanggal_pra_bpjs')->label('PRA BPJS')->prefix('TANGGAL PRA BPJS : '),
                // TextColumn::make('tanggal_medical_full')->label('MEDICAL FULL')->prefix('TANGGAL MEDICAL FULL : '),
                // TextColumn::make('tanggal_ec')->label('EC')->prefix('TANGGAL EC : '),
                // TextColumn::make('tanggal_visa')->label('VISA')->prefix('TANGGAL VISA : '),
                // TextColumn::make('tanggal_bpjs_purna')->label('BPJS PURNA')->prefix('TANGGAL BPJS PURNA : '),
                // TextColumn::make('tanggal_ktkln')->label('KTKLN')->prefix('TANGGAL KTKLN : '),
                // TextColumn::make('tanggal_terbang')->label('PENERBANGAN')->prefix('TANGGAL PENERBANGAN : '),
                // TextColumn::make('tanggal_invoice_toyo')->label('INV TOYO')->prefix('TANGGAL INV TOYO : '),
                // TextColumn::make('tanggal_invoice_agency')->label('INV AGENCY')->prefix('TANGGAL INV AGENCY : '),
                // TextColumn::make('id')->searchable()->alignment('left')->label('NOMOR DATA PMI')->prefix('NOMOR DATA PMI : '),
            ])->defaultSort('created_at', 'desc')

            ->filters([
                SelectFilter::make('Status')->relationship('Status', 'nama')->label('STATUS'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-clipboard-document-list')
                    ->label('BUAT DATA PMI'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // Tables\Actions\EditAction::make()
                    //     ->label('Update')
                    //     ->color('primary'),
                    // Tables\Actions\ViewAction::make()->label('View Detail')->icon('heroicon-o-identification')->color('success')->openUrlInNewTab(),
                    // Action::make('Download Pdf')
                    //     ->label('Cetak')
                    //     ->icon('heroicon-o-printer')
                    //     ->url(fn (DataPmi $record) => route('datapmi.pdf.download', $record))
                    //     ->openUrlInNewTab(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }
}
