<?php

namespace REDQ_RnB\Traits;

use Carbon\Carbon;


trait Assets_Trait
{
    /**
     * Get front scripts
     *
     * @return array
     */
    public function get_front_scripts()
    {
        $geneal = 'general';
        $rfq = 'rfq';

        return [
            'chosen.jquery' => [
                'src'     => RNB_ASSETS . '/js/chosen.jquery.js',
                'version' => filemtime(RNB_PATH . '/assets/js/chosen.jquery.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'clone' => [
                'src'     => RNB_ASSETS . '/js/clone.js',
                'version' => filemtime(RNB_PATH . '/assets/js/clone.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'jquery.steps' => [
                'src'     => RNB_ASSETS . '/js/jquery.steps.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery.steps.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'jquery.magnific-popup.min' => [
                'src'     => RNB_ASSETS . '/js/jquery.magnific-popup.min.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery.magnific-popup.min.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal, $rfq]
            ],
            'jquery.datetimepicker.full' => [
                'src'     => RNB_ASSETS . '/js/jquery.datetimepicker.full.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery.datetimepicker.full.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'rnb-calendar' => [
                'src'     => RNB_ASSETS . '/js/rnb-calendar.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-calendar.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'rnb-template' => [
                'src'     => RNB_ASSETS . '/js/rnb-template.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-template.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'rnb-init' => [
                'src'     => RNB_ASSETS . '/js/rnb-init.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-init.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'rnb-quote' => [
                'src'     => RNB_ASSETS . '/js/rnb-quote.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-quote.js'),
                'deps'    => ['jquery'],
                'scope' => [$geneal, $rfq]
            ],
            'front-end-scripts' => [
                'src'     => RNB_ASSETS . '/js/main-script.js',
                'version' => filemtime(RNB_PATH . '/assets/js/main-script.js'),
                'deps'    => ['jquery', 'underscore', 'chosen.jquery', 'rnb-calendar', 'rnb-template', 'rnb-init'],
                'scope' => [$geneal]
            ],
            'rnb-validation' => [
                'src'     => RNB_ASSETS . '/js/rnb-validation.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-validation.js'),
                'deps'    => ['jquery'],
                'scope'   => [$geneal]
            ],
            'rnb-rfq' => [
                'src'     => RNB_ASSETS . '/js/rnb-rfq.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-rfq.js'),
                'deps'    => ['jquery', 'underscore', 'chosen.jquery', 'rnb-calendar', 'rnb-template', 'rnb-init'],
                'scope' => [$geneal, $rfq]
            ],
        ];
    }

    /**
     * Get Styles
     *
     * @return array
     */
    public function get_front_styles()
    {
        $geneal = 'general';
        $rfq = 'rfq';

        return [
            'chosen' => [
                'src'     => RNB_ASSETS . '/css/chosen.css',
                'version' => filemtime(RNB_PATH . '/assets/css/chosen.css'),
                'scope' => [$geneal]
            ],
            'jquery.steps' => [
                'src'     => RNB_ASSETS . '/css/jquery.steps.css',
                'version' => filemtime(RNB_PATH . '/assets/css/jquery.steps.css'),
                'scope' => [$geneal]
            ],
            'magnific-popup' => [
                'src'     => RNB_ASSETS . '/css/magnific-popup.css',
                'version' => filemtime(RNB_PATH . '/assets/css/magnific-popup.css'),
                'scope' => [$geneal, $rfq]
            ],
            'fontawesome.min' => [
                'src'     => RNB_ASSETS . '/css/fontawesome.min.css',
                'version' => filemtime(RNB_PATH . '/assets/css/fontawesome.min.css'),
                'scope' => [$geneal]
            ],
            'jquery.datetimepicker' => [
                'src'     => RNB_ASSETS . '/css/jquery.datetimepicker.css',
                'version' => filemtime(RNB_PATH . '/assets/css/jquery.datetimepicker.css'),
                'scope' => [$geneal]
            ],
            'rental-global' => [
                'src'     => RNB_ASSETS . '/css/rental-global.css',
                'version' => filemtime(RNB_PATH . '/assets/css/rental-global.css'),
                'scope' => [$geneal]
            ],
            'quote-front' => [
                'src'     => RNB_ASSETS . '/css/quote-front.css',
                'version' => filemtime(RNB_PATH . '/assets/css/quote-front.css'),
                'scope' => [$rfq]
            ],
            'rental-style' => [
                'src'     => RNB_ASSETS . '/css/rental-style.css',
                'version' => filemtime(RNB_PATH . '/assets/css/rental-style.css'),
                'scope' => [$geneal]
            ],
        ];
    }

    /**
     * Get admin scripts
     *
     * @return array
     */
    public function get_admin_scripts()
    {
        return [
            'jquery-ui' => [
                'src'     => RNB_ASSETS . '/js/jquery-ui.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery-ui.js'),
                'deps'    => ['jquery'],
            ],
            'select2.min' => [
                'src'     => RNB_ASSETS . '/js/select2.min.js',
                'version' => filemtime(RNB_PATH . '/assets/js/select2.min.js'),
                'deps'    => ['jquery']
            ],
            'jquery.datetimepicker.full' => [
                'src'     => RNB_ASSETS . '/js/jquery.datetimepicker.full.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery.datetimepicker.full.js'),
                'deps'    => ['jquery']
            ],
            'icon-picker' => [
                'src'     => RNB_ASSETS . '/js/icon-picker.js',
                'version' => filemtime(RNB_PATH . '/assets/js/icon-picker.js'),
                'deps'    => ['jquery']
            ],
            'rnb-admin' => [
                'src'     => RNB_ASSETS . '/js/rnb-admin.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-admin.js'),
                'deps'    => ['jquery', 'jquery-ui-tabs', 'jquery-ui-datepicker']
            ],
            'rnb-order' => [
                'src'     => RNB_ASSETS . '/js/rnb-order.js',
                'version' => filemtime(RNB_PATH . '/assets/js/rnb-order.js'),
                'deps'    => ['jquery', 'jquery-ui-tabs', 'jquery-ui-datepicker']
            ]
        ];
    }

    /**
     * Get admin Styles
     *
     * @return array
     */
    public function get_admin_styles()
    {
        return [
            'fontawesome.min' => [
                'src'     => RNB_ASSETS . '/css/fontawesome.min.css',
                'version' => filemtime(RNB_PATH . '/assets/css/fontawesome.min.css'),
            ],
            'jquery-ui' => [
                'src'     => RNB_ASSETS . '/css/jquery-ui.css',
                'version' => filemtime(RNB_PATH . '/assets/css/jquery-ui.css'),
            ],
            'jquery.datetimepicker' => [
                'src'     => RNB_ASSETS . '/css/jquery.datetimepicker.css',
                'version' => filemtime(RNB_PATH . '/assets/css/jquery.datetimepicker.css'),
            ],
            'rnb-quote' => [
                'src'     => RNB_ASSETS . '/css/rnb-quote.css',
                'version' => filemtime(RNB_PATH . '/assets/css/rnb-quote.css'),
            ],
            'rnb-admin' => [
                'src'     => RNB_ASSETS . '/css/rnb-admin.css',
                'version' => filemtime(RNB_PATH . '/assets/css/rnb-admin.css'),
            ],
        ];
    }

    /**
     * Full calendar scripts
     */
    public function get_full_calendar_scripts()
    {
        return [
            'main.min' => [
                'src'     => RNB_ASSETS . '/js/full-calendar/main.min.js',
                'version' => filemtime(RNB_PATH . '/assets/js/full-calendar/main.min.js'),
                'deps'    => ['jquery'],
            ],
            'daygrid' => [
                'src'     => RNB_ASSETS . '/js/full-calendar/daygrid.js',
                'version' => filemtime(RNB_PATH . '/assets/js/full-calendar/daygrid.js'),
                'deps'    => ['jquery'],
            ],
            'timegrid' => [
                'src'     => RNB_ASSETS . '/js/full-calendar/timegrid.js',
                'version' => filemtime(RNB_PATH . '/assets/js/full-calendar/timegrid.js'),
                'deps'    => ['jquery'],
            ],
            'listgrid' => [
                'src'     => RNB_ASSETS . '/js/full-calendar/listgrid.js',
                'version' => filemtime(RNB_PATH . '/assets/js/full-calendar/listgrid.js'),
                'deps'    => ['jquery'],
            ],
            'jquery.magnific-popup.min' => [
                'src'     => RNB_ASSETS . '/js/jquery.magnific-popup.min.js',
                'version' => filemtime(RNB_PATH . '/assets/js/jquery.magnific-popup.min.js'),
                'deps'    => ['jquery'],
            ],
        ];
    }

    /**
     * Get full calendar Styles
     *
     * @return array
     */
    public function get_full_calendar_styles()
    {
        return [
            'main.min' => [
                'src'     => RNB_ASSETS . '/css/full-calendar/main.min.css',
                'version' => filemtime(RNB_PATH . '/assets/css/full-calendar/main.min.css'),
            ],
            'daygrid' => [
                'src'     => RNB_ASSETS . '/css/full-calendar/daygrid.css',
                'version' => filemtime(RNB_PATH . '/assets/css/full-calendar/daygrid.css'),
            ],
            'timegrid' => [
                'src'     => RNB_ASSETS . '/css/full-calendar/timegrid.css',
                'version' => filemtime(RNB_PATH . '/assets/css/full-calendar/timegrid.css'),
            ],
            'magnific-popup' => [
                'src'     => RNB_ASSETS . '/css/magnific-popup.css',
                'version' => filemtime(RNB_PATH . '/assets/css/magnific-popup.css'),
            ],
        ];
    }
}
