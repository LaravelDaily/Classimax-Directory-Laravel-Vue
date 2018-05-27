Simple Vue.js+Laravel adminpanel to manage directory of companies and their categories/cities.
It is a __Vue version__ of the project that we had done before in Laravel-only way: [directory based on Classimax Bootstrap theme](https://github.com/LaravelDaily/Laravel-Classimax-Directory).

It is a demo project for demonstrating what can be generated with [Vue.js QuickAdminPanel](https://vue.quickadminpanel.com) tool.

![Vue Classimax screenshot 01](http://webcoderpro.com/vue-classimax-demo01.png)

![Vue Classimax screenshot 02](http://webcoderpro.com/vue-classimax-demo02.png)

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- Run __php artisan passport:install__ (for API authentication)
- Run __npm install__
- Run __npm run dev__
- That's it: launch the main URL and login with default credentials __admin@admin.com__ - __password__

## License

Basically, feel free to use and re-use any way you want.
