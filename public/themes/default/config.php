<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
            $theme->setTitle('Copyright ©  2013 - Laravel.in.th');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{!! $crumb["label"] !!}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{!! $crumb["label"] !!}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {


            $theme->asset()->usePath()->add('jquery.min.js', 'js/jquery.min.js');
            $theme->asset()->usePath()->add('jquery.js', 'js/jquery.js');
            $theme->asset()->usePath()->add('bootstrap.min.js', 'js/bootstrap.min.js');
            $theme->asset()->usePath()->add('bootstrap.min.css', 'css/bootstrap.min.css');
            //validate
            $theme->asset()->usePath()->add('jquery.validate.min.js', 'js/jquery.validate.min.js');



            $theme->asset()->usePath()->add('font-awesome.min.css', 'css/font-awesome.min.css');

            //sweetalert
            $theme->asset()->usePath()->add('sweetalert2.min.css', 'css/sweetalert2.min.css');
            $theme->asset()->usePath()->add('sweetalert2.min.css', 'js/sweetalert2.min.js');


            // You may use this event to set up your assets.
            // $theme->asset()->usePath()->add('core', 'core.js');
            // $theme->asset()->add('jquery', 'vendor/jquery/jquery.min.js');
            // $theme->asset()->add('jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', array('jquery'));

            // Partial composer.
            // $theme->partialComposer('header', function($view)
            // {
            //     $view->with('auth', Auth::user());
            // });
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => array(

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
                $theme->asset()->usePath()->add('style.css', 'home/style.css');
                $theme->asset()->usePath()->add('custom.js', 'home/custom.js');
                $theme->asset()->usePath()->add('easing.min.js', 'home/easing.min.js');
                $theme->asset()->usePath()->add('morphext.min.js', 'home/morphext.min.js');
                $theme->asset()->usePath()->add('animate.min.css', 'home/animate.min.css');
                $theme->asset()->usePath()->add('hoverIntent.js', 'home/hoverIntent.js');
                $theme->asset()->usePath()->add('sticky.js', 'home/sticky.js');
                $theme->asset()->usePath()->add('superfish.min.js', 'home/superfish.min.js');
                $theme->asset()->usePath()->add('wow.min.js', 'home/wow.min.js');
                $theme->asset()->usePath()->add('jquery.min.js', 'js/jquery.min.js');


            },
            'defaultadmin' => function($theme){

                $theme->asset()->usePath()->add('mcoat.css', 'css/mcoat.css');

                $theme->asset()->usePath()->add('metisMenu.min.css', 'css/metisMenu.min.css');
                $theme->asset()->usePath()->add('metisMenu.min.js', 'js/metisMenu.min.js');

                $theme->asset()->usePath()->add('sb-admin-2.min.css', 'sbadmin/css/sb-admin-2.min.css');
                $theme->asset()->usePath()->add('sb-admin-2.min.js', 'sbadmin/js/sb-admin-2.min.js');



                //datatable
                $theme->asset()->usePath()->add('dataTables.bootstrap4.min.css', 'css/dataTables.bootstrap4.min.css');
                $theme->asset()->usePath()->add('responsive.bootstrap4.min.css', 'css/responsive.bootstrap4.min.css');

                $theme->asset()->usePath()->add('jquery.dataTables.min.js', 'js/dataTable/jquery.dataTables.min.js');
                $theme->asset()->usePath()->add('dataTables.bootstrap4.min.js', 'js/dataTable/dataTables.bootstrap4.min.js');
                $theme->asset()->usePath()->add('dataTables.responsive.min.js', 'js/dataTable/dataTables.responsive.min.js');
                $theme->asset()->usePath()->add('responsive.bootstrap4.min.js', 'js/dataTable/responsive.bootstrap4.min.js');


                //morris-chart

                $theme->asset()->usePath()->add('morris.css', 'css/morris.css');
                $theme->asset()->usePath()->add('raphael.min.js', 'js/raphael.min.js');
                $theme->asset()->usePath()->add('morris.min.js', 'js/morris.min.js');
                $theme->asset()->usePath()->add('morris-data.js', 'js/morris-data.js');


            }



        )

    )

);