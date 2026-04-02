<?php

class ThemeManager {
    public static function getThemes() {
        return [
            'messor' => [
                'name' => 'Messor (Noche Profunda)',
                'description' => 'El clásico modo oscuro, sobrio y elegante.',
                'colors' => [
                    'background' => '#09090b',
                    'foreground' => '#fafafa',
                    'primary'    => '#3b82f6', // Blue
                    'card'       => 'rgba(24, 24, 27, 0.7)',
                    'border'     => '#27272a',
                    'accent'     => '#8b5cf6', // Purple
                    'text_main'  => '#ffffff',
                    'text_muted' => '#a1a1aa',
                ]
            ],
            'lasius' => [
                'name' => 'Lasius (Jardín Húmedo)',
                'description' => 'Tonos verdosos que evocan el frescor del jardín.',
                'colors' => [
                    'background' => '#020617',
                    'foreground' => '#f0fdf4',
                    'primary'    => '#22c55e', // Green
                    'card'       => 'rgba(5, 46, 22, 0.7)',
                    'border'     => '#064e3b',
                    'accent'     => '#10b981',
                    'text_main'  => '#f0fdf4',
                    'text_muted' => '#86efac',
                ]
            ],
            'camponotus' => [
                'name' => 'Camponotus (Madera Imperial)',
                'description' => 'Un toque de distinción con tonos tierra y dorados.',
                'colors' => [
                    'background' => '#0c0a09',
                    'foreground' => '#fffaf3',
                    'primary'    => '#d97706', // Amber
                    'card'       => 'rgba(41, 37, 36, 0.7)',
                    'border'     => '#44403c',
                    'accent'     => '#f59e0b',
                    'text_main'  => '#fffaf3',
                    'text_muted' => '#d6d3d1',
                ]
            ],
            'solenopsis' => [
                'name' => 'Solenopsis (Alerta Fuego)',
                'description' => 'Energía y contraste con acentos rojos intensos.',
                'colors' => [
                    'background' => '#020617',
                    'foreground' => '#fef2f2',
                    'primary'    => '#ef4444', // Red
                    'card'       => 'rgba(69, 10, 10, 0.7)',
                    'border'     => '#7f1d1d',
                    'accent'     => '#f87171',
                    'text_main'  => '#fef2f2',
                    'text_muted' => '#fca5a5',
                ]
            ],
            'myrmecia' => [
                'name' => 'Myrmecia (Desierto Australiano)',
                'description' => 'Tonos anaranjados y cálidos para una lectura suave.',
                'colors' => [
                    'background' => '#020617',
                    'foreground' => '#fff7ed',
                    'primary'    => '#f97316', // Orange
                    'card'       => 'rgba(124, 45, 18, 0.7)',
                    'border'     => '#9a3412',
                    'accent'     => '#fb923c',
                    'text_main'  => '#fff7ed',
                    'text_muted' => '#fdba74',
                ]
            ],
            'alba' => [
                'name' => 'Alba (Modo Claro)',
                'description' => 'Interfaz limpia con máxima luminosidad.',
                'colors' => [
                    'background' => '#f4f4f5',
                    'foreground' => '#09090b',
                    'primary'    => '#2563eb', // Blue
                    'card'       => 'rgba(255, 255, 255, 0.8)',
                    'border'     => '#e4e4e7',
                    'accent'     => '#4f46e5',
                    'text_main'  => '#18181b',
                    'text_muted' => '#71717a',
                ]
            ]
        ];
    }

    public static function getTheme($key) {
        $themes = self::getThemes();
        return $themes[$key] ?? $themes['messor'];
    }

    public static function injectVariables($themeKey, $isHighContrast = false) {
        $theme = self::getTheme($themeKey);
        $colors = $theme['colors'];

        // Ajustes para alto contraste si aplica
        if ($isHighContrast) {
            $colors['background'] = ($themeKey === 'alba') ? '#ffffff' : '#000000';
            $colors['foreground'] = ($themeKey === 'alba') ? '#000000' : '#ffffff';
            $colors['border'] = '#ffffff';
        }

        $css = ":root {\n";
        foreach ($colors as $name => $value) {
            $css .= "  --theme-$name: $value;\n";
        }
        $css .= "}";
        return $css;
    }
}
