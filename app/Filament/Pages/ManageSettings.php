<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Cache;
use UnitEnum;

class ManageSettings extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'Configuración & SEO';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Ajustes Globales';

    protected static ?string $title = 'Configuración General del Sitio';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.manage-settings';

    // Branding
    public string $site_name = '';
    public string $site_tagline = '';
    public string $primary_color = '#0F4C81';
    public string $secondary_color = '#F58220';
    public string $accent_color = '#2ECC71';
    public string $company_phone = '';
    public string $company_whatsapp = '';
    public string $company_email = '';
    public string $company_address = '';

    // Data Tracking
    public string $gtm_id = '';
    public string $meta_pixel_id = '';
    public string $tiktok_pixel_id = '';
    public string $clarity_id = '';
    public string $custom_head_scripts = '';
    public string $custom_body_scripts = '';

    // SEO Global
    public string $meta_title_default = '';
    public string $meta_description_default = '';
    public string $schema_type = 'Supermarket';

    public string $activeTab = 'branding';

    public function mount(): void
    {
        $this->site_name = (string) Setting::get('site_name', 'Marcsol');
        $this->site_tagline = (string) Setting::get('site_tagline', 'Supermercado Corporativo');
        $this->primary_color = (string) Setting::get('primary_color', '#0F4C81');
        $this->secondary_color = (string) Setting::get('secondary_color', '#F58220');
        $this->accent_color = (string) Setting::get('accent_color', '#2ECC71');
        $this->company_phone = (string) Setting::get('company_phone', '+593 5 275 9000');
        $this->company_whatsapp = (string) Setting::get('company_whatsapp', '+593 99 765 4321');
        $this->company_email = (string) Setting::get('company_email', 'contacto@marcsol.com.ec');
        $this->company_address = (string) Setting::get('company_address', 'Av. 7 de Octubre, Quevedo');

        $this->gtm_id = (string) Setting::get('gtm_id', '');
        $this->meta_pixel_id = (string) Setting::get('meta_pixel_id', '');
        $this->tiktok_pixel_id = (string) Setting::get('tiktok_pixel_id', '');
        $this->clarity_id = (string) Setting::get('clarity_id', '');
        $this->custom_head_scripts = (string) Setting::get('custom_head_scripts', '');
        $this->custom_body_scripts = (string) Setting::get('custom_body_scripts', '');

        $this->meta_title_default = (string) Setting::get('meta_title_default', 'Marcsol | Supermercado Corporativo');
        $this->meta_description_default = (string) Setting::get('meta_description_default', 'Supermercado lÃ­der en Quevedo');
        $this->schema_type = (string) Setting::get('schema_type', 'Supermarket');
    }

    public static function canAccess(): bool
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user && ($user->hasRole('SuperAdmin') || $user->hasRole('Administrador'));
    }

    public function save(): void
    {
        // Sanitizar y guardar Branding
        Setting::set('site_name', trim($this->site_name), 'branding');
        Setting::set('site_tagline', trim($this->site_tagline), 'branding');
        Setting::set('primary_color', trim($this->primary_color), 'branding');
        Setting::set('secondary_color', trim($this->secondary_color), 'branding');
        Setting::set('accent_color', trim($this->accent_color), 'branding');
        Setting::set('company_phone', trim($this->company_phone), 'branding');
        Setting::set('company_whatsapp', trim($this->company_whatsapp), 'branding');
        Setting::set('company_email', trim($this->company_email), 'branding');
        Setting::set('company_address', trim($this->company_address), 'branding');

        // Sanitizar y guardar Tracking
        Setting::set('gtm_id', strip_tags(trim($this->gtm_id)), 'tracking');
        Setting::set('meta_pixel_id', strip_tags(trim($this->meta_pixel_id)), 'tracking');
        Setting::set('tiktok_pixel_id', strip_tags(trim($this->tiktok_pixel_id)), 'tracking');
        Setting::set('clarity_id', strip_tags(trim($this->clarity_id)), 'tracking');
        Setting::set('custom_head_scripts', $this->custom_head_scripts, 'tracking');
        Setting::set('custom_body_scripts', $this->custom_body_scripts, 'tracking');

        // Sanitizar y guardar SEO
        Setting::set('meta_title_default', trim($this->meta_title_default), 'seo_global');
        Setting::set('meta_description_default', trim($this->meta_description_default), 'seo_global');
        Setting::set('schema_type', trim($this->schema_type), 'seo_global');

        Cache::forget('site_settings');

        Notification::make()
            ->title('ConfiguraciÃ³n guardada con Ã©xito')
            ->body('Los ajustes globales de Branding, Tracking y SEO han sido actualizados.')
            ->success()
            ->send();
    }
}
