<?php

namespace Kafyx3\DataTablesExport\View\Components;

use Illuminate\View\Component;

class Scripts extends Component
{
    /** URL-URL CDN yang sudah di-resolve dari config. */
    public array $urls;

    public function __construct()
    {
        $cfg = config('datatables-export');

        $v  = $cfg['datatables_version'];
        $bv = $cfg['buttons_version'];
        $jv = $cfg['jszip_version'];
        $pv = $cfg['pdfmake_version'];

        $resolve = function (string $template) use ($v, $bv, $jv, $pv): string {
            return str_replace(
                ['{version}', '{buttons_version}', '{jszip_version}', '{pdfmake_version}'],
                [$v,           $bv,                 $jv,               $pv],
                $template
            );
        };

        $cdn = $cfg['cdn'];

        $this->urls = [
            'datatables_css'   => $resolve($cdn['datatables_css']),
            'buttons_css'      => $resolve($cdn['buttons_css']),
            'datatables_js'    => $resolve($cdn['datatables_js']),
            'jszip_js'         => $resolve($cdn['jszip_js']),
            'pdfmake_js'       => $resolve($cdn['pdfmake_js']),
            'vfs_fonts_js'     => $resolve($cdn['vfs_fonts_js']),
            'buttons_js'       => $resolve($cdn['buttons_js']),
            'buttons_html5_js' => $resolve($cdn['buttons_html5_js']),
            'buttons_print_js' => $resolve($cdn['buttons_print_js']),
        ];
    }

    public function render()
    {
        return view('datatables-export::components.scripts');
    }
}
