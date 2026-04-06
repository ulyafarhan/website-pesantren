<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Pengaturan')
                    ->tabs([
                        Tab::make('Informasi Umum')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nama Website / Pesantren')
                                    ->required()
                                    ->maxLength(255),
                                
                                Textarea::make('site_description')
                                    ->label('Deskripsi Singkat (SEO)')
                                    ->rows(3)
                                    ->maxLength(500),
                                
                                FileUpload::make('logo_url')
                                    ->label('Logo Utama')
                                    ->image()
                                    ->directory('settings/logo'),
                                
                                FileUpload::make('favicon_url')
                                    ->label('Ikon Browser (Favicon)')
                                    ->image()
                                    ->directory('settings/favicon'),
                            ]),

                        Tab::make('Kontak & Alamat')
                            ->icon('heroicon-m-phone')
                            ->schema([
                                TextInput::make('email')
                                    ->label('Alamat Email Resmi')
                                    ->email()
                                    ->maxLength(255),
                                
                                TextInput::make('phone')
                                    ->label('Nomor Telepon / WhatsApp')
                                    ->tel()
                                    ->maxLength(50),
                                
                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->rows(3),
                                
                                TextInput::make('google_maps_url')
                                    ->label('Link Google Maps')
                                    ->url()
                                    ->maxLength(255),
                            ]),

                        Tab::make('Media Sosial')
                            ->icon('heroicon-m-share')
                            ->schema([
                                TextInput::make('facebook_url')
                                    ->label('URL Facebook')
                                    ->url()
                                    ->maxLength(255),
                                
                                TextInput::make('instagram_url')
                                    ->label('URL Instagram')
                                    ->url()
                                    ->maxLength(255),
                                
                                TextInput::make('youtube_url')
                                    ->label('URL YouTube')
                                    ->url()
                                    ->maxLength(255),
                            ]),

                        Tab::make('Sistem')
                            ->icon('heroicon-m-cpu-chip')
                            ->schema([
                                Toggle::make('is_maintenance')
                                    ->label('Aktifkan Mode Perbaikan (Maintenance)')
                                    ->default(false),
                                
                                Textarea::make('maintenance_message')
                                    ->label('Pesan Mode Perbaikan')
                                    ->rows(2)
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}