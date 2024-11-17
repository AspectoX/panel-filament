<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Pages\Concerns\HasHeadingIcon;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    use HasHeadingIcon;

    protected static ?string $navigationIcon = 'icon-database-backup';

    public function getHeading(): string
    {
        return $this->getHeadingWithIcon(
            heading: 'Backups',
            icon: 'icon-database-backup',
        );
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }
}
