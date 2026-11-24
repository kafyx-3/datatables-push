<?php

namespace Kafyx3\DataTablesExport\View\Components;

use Illuminate\View\Component;

class Scripts extends Component
{
    /** Tema yang aktif ('default', 'bootstrap5', 'bootstrap4'). */
    public string $theme;

    /** URL-URL CDN yang sudah di-resolve dari config. */
    public array $urls;

    public function __construct(?string $theme = null)
    {
        $cfg = config('datatables-export');

        $v  = $cfg['datatables_version'];
        $bv = $cfg['buttons_version'];
        $jv = $cfg['jszip_version'];
        $pv = $cfg['pdfmake_version'];

        $resolve = function (?string $template) use ($v, $bv, $jv, $pv): ?string {
            if ($template === null) {
                return null;
            }

            return str_replace(
                ['{version}', '{buttons_version}', '{jszip_version}', '{pdfmake_version}'],
                [$v,           $bv,                 $jv,               $pv],
                $template
            );
        };

        $this->theme = $theme ?? ($cfg['theme'] ?? 'default');

        $cdn      = $cfg['cdn'];
        $themeCdn = $cfg['themes'][$this->theme] ?? null;

        $this->urls = [
            'datatables_css'      => $resolve($themeCdn['datatables_css'] ?? $cdn['datatables_css']),
            'buttons_css'         => $resolve($themeCdn['buttons_css'] ?? $cdn['buttons_css']),
            'jquery_js'           => $cdn['jquery_js'],
            'datatables_js'       => $resolve($cdn['datatables_js']),
            'datatables_theme_js' => $resolve($themeCdn['datatables_theme_js'] ?? null),
            'jszip_js'            => $resolve($cdn['jszip_js']),
            'pdfmake_js'          => $resolve($cdn['pdfmake_js']),
            'vfs_fonts_js'        => $resolve($cdn['vfs_fonts_js']),
            'buttons_js'          => $resolve($cdn['buttons_js']),
            'buttons_theme_js'    => $resolve($themeCdn['buttons_theme_js'] ?? null),
            'buttons_html5_js'    => $resolve($cdn['buttons_html5_js']),
            'buttons_print_js'    => $resolve($cdn['buttons_print_js']),
        ];
    }

    public function render()
    {
        return view('datatables-export::components.scripts');
    }
}
