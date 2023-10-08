<?php

namespace App\Providers\Filament;

use App\Filament\Resources\DataPmiResource;
use App\Filament\Resources\PendaftaranResource;
use App\Filament\Widgets\DasboardWidgets1;
use App\Filament\Widgets\DasboardWidgets2;
use App\Filament\Widgets\KendalChart;
use App\Filament\Widgets\OverwiewChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Awcodes\FilamentVersions\FilamentVersions\VersionsPlugin;
use Awcodes\FilamentVersions\FilamentVersions\VersionsWidget;
use Awcodes\FilamentVersions\VersionsPlugin as FilamentVersionsVersionsPlugin;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Awcodes\FilamentVersions\VersionsWidget as FilamentVersionsVersionsWidget;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\LightSwitch\Enums\Alignment;



class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarFullyCollapsibleOnDesktop()
            // ->topNavigation()
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // DasboardWidgets1::class,
                // DasboardWidgets2::class,
                // OverwiewChart::class,
                // KendalChart::class,
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                // FilamentVersionsVersionsWidget::class,
            ])
            ->databaseNotifications()
            ->middleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ])
            ->favicon(asset('images/favicon.svg'))
            ->viteTheme('resources/css/filament/admin/theme.css')

            ->plugins([
                LightSwitchPlugin::make()
                    ->position(Alignment::TopCenter),
                SpotlightPlugin::make(),
                \Hasnayeen\Themes\ThemesPlugin::make(),
                FilamentProgressbarPlugin::make()->color('#ffa500'),
                BreezyCore::make()
                    ->myProfile(

                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        hasAvatars: false, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->avatarUploadComponent(fn ($fileUpload) => $fileUpload->disableLabel()),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                FilamentVersionsVersionsPlugin::make(),
                QuickCreatePlugin::make()
                    ->includes([
                        PendaftaranResource::class,
                        DataPmiResource::class,
                    ]),
            ])
            ->collapsibleNavigationGroups(true)
            ->navigationItems([
                NavigationItem::make('Lihat Website')
                    ->group('WEBSITE')
                    ->url('https://nahelindopratama.com', shouldOpenInNewTab: true)
                    ->sort(-3)
                    ->icon('heroicon-o-viewfinder-circle'),
                NavigationItem::make('Admin Website')
                    ->group('WEBSITE')
                    ->url('https://nahelindopratama.com/wp-admin', shouldOpenInNewTab: true)
                    ->sort(-3)
                    ->icon('heroicon-o-wrench-screwdriver'),
            ])
            ->navigationGroups([
                NavigationGroup::make('WEBSITE')
                    ->label('WEBSITE')
                    ->collapsible(true),
                // NavigationGroup::make('CPMI')
                //     ->label('CPMI')
                //     ->icon('heroicon-m-check-badge'),
                // NavigationGroup::make('PENGATURAN')
                //     ->label('PENGATURAN')
                //     ->icon('heroicon-o-pencil')
                //     ->collapsible(true),
                // NavigationGroup::make('MODUL')
                //     ->label('MODUL')
                //     ->icon('heroicon-o-pencil')
                //     ->collapsible(true),


            ]);
    }
}
