const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// layout
mix.styles('resources/assets/css/components-md.css', 'public/build/css/components-md.css');
mix.styles('resources/assets/css/plugins-md.css', 'public/build/css/plugins-md.css');
mix.styles('resources/assets/css/layout.min.css', 'public/build/css/layout.min.css');
mix.styles('resources/assets/css/darkblue.min.css', 'public/build/css/darkblue.min.css');
mix.styles('resources/assets/css/custom.css', 'public/build/css/custom.css');
mix.styles('resources/assets/css/user.css', 'public/build/css/user.css');
mix.styles('resources/assets/css/style.css', 'public/build/css/style.css');
mix.styles('resources/assets/css/chatbox.css', 'public/build/css/chatbox.css');
mix.styles('resources/assets/css/contacts.css', 'public/build/css/contacts.css');
mix.styles('resources/assets/css/partners.css', 'public/build/css/partners.css');
mix.styles('resources/assets/css/social-post.css', 'public/build/css/social-post.css');
mix.styles('resources/assets/css/list-unit.css', 'public/build/css/list-unit.css');

mix.copy('resources/assets/js/app.min.js', 'public/build/js/app.min.js');
mix.js('resources/assets/js/layout.min.js', 'public/build/js/layout.min.js');
mix.js('resources/assets/js/demo.min.js', 'public/build/js/demo.min.js');
mix.js('resources/assets/js/quick-sidebar.min.js', 'public/build/js/quick-sidebar.min.js');
mix.js('resources/assets/js/chatbox.js', 'public/build/js/chatbox.js');
mix.js('resources/assets/js/duplicate-classroom.js', 'public/build/js/duplicate-classroom.js');



// email log
mix.styles('resources/assets/css/email-log.css', 'public/build/css/email-log.css');


mix.js('resources/assets/js/email-log.js', 'public/build/js/email-log.js');
mix.js('resources/assets/js/backup-database.js', 'public/build/js/backup-database.js');
mix.js('resources/assets/js/log.js', 'public/build/js/log.js');
mix.js('resources/assets/js/permission.js', 'public/build/js/permission.js');
mix.js('resources/assets/js/role.js', 'public/build/js/role.js');
mix.js('resources/assets/js/partners.js', 'public/build/js/partners.js');
mix.js('resources/assets/js/social-post.js', 'public/build/js/social-post.js');
mix.js('resources/assets/js/contacts.js', 'public/build/js/contacts.js');
mix.js('resources/assets/js/global.js', 'public/build/js/global.js');
mix.js('resources/assets/js/activity-log.js', 'public/build/js/activity-log.js');
mix.js('resources/assets/js/change-learn-time.js', 'public/build/js/change-learn-time.js');

if (mix.inProduction()) {
    mix.version();
}
