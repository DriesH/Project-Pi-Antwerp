var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'admin-panel.css',
        'app-uitleg-box.css',
        'bootstrap-btn-colors.css',
        'bootstrap-datepicker3.standalone.min.css',
        'bootstrap.min.css',
        'dashboard-user.css',
        'fases.css',
        'font-awesome.min.css',
        'grid-layout.css',
        'master.css',
        'nav-bar.css',
        'project-box.css',
        'project-page.css',
        'vertical-timeline-css.css'
    ], 'public/css/master.css');
});
