<?php

namespace App\Filament\Pages\Concerns;

use Illuminate\Support\HtmlString;
use Filament\Support\Enums\IconSize;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Enums\IconPosition;
use Illuminate\Contracts\Support\Htmlable;

trait HasHeadingIcon
{
    public function getHeadingWithIcon(
        ?string $heading = null,
        ?string $icon = null,
        string $iconColor = 'primary',
        IconPosition $iconPosition = IconPosition::Before,
        IconSize $iconSize = IconSize::Medium,
    ): string | Htmlable
    {
        $color = "--c-600: var(--{$iconColor}-600);";

        $margin = ($iconPosition === IconPosition::Before)
            ? 'margin-inline-end: .5rem;'
            : 'margin-inline-start: .5rem;';

        $size = match($iconSize) {
            IconSize::Small => '1.4rem',
            IconSize::Medium => '1.75rem',
            IconSize::Large => '2.5rem',
        };

        $dimensions = "width: {$size}; height: {$size};";

        $iconStyle = "{$color} {$margin} {$dimensions}";

        $iconComponent = filled($icon)
            ? '<x-'. $icon .' style="'. $iconStyle .'" class="inline ax-heading-icon" />'
            : null;

        $headingText = $heading ?? $this->heading ?? $this->getTitle();

        if (blank($iconComponent)) {
            return $headingText;
        }

        $iconBefore = ($iconPosition === IconPosition::Before)
            ? $iconComponent
            : null;

        $iconAfter = ($iconPosition === IconPosition::After)
            ? $iconComponent
            : null;

        return new HtmlString(
            Blade::render('<div class="flex items-center"> '. $iconBefore .' '. $headingText .' '. $iconAfter .' </div>')
        );
    }
}
