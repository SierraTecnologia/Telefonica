<?php

namespace Telefonica;

use App;
use Config;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;
use Muleta\Traits\Providers\ConsoleTools;

use Route;

use Telefonica\Facades\Telefonica as TelefonicaFacade;
use Telefonica\Services\TelefonicaService;

class TelefonicaProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'telefonica';
    const pathVendor = 'sierratecnologia/telefonica';

    public static $aliasProviders = [
        'Telefonica' => \Telefonica\Facades\Telefonica::class,
    ];

    public static $providers = [

        \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text' => 'Telefonica',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'section' => "master",
            'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Telefonica' => [
            [
                'text'        => 'Procurar',
                'icon'        => 'fas fa-fw fa-search',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "master",
                'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            'Procurar' => [
                [
                    'text'        => 'Projetos',
                    'route'       => 'telefonica.projetos.index',
                    'icon'        => 'fas fa-fw fa-ship',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'section' => "master",
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \Porteiro\Models\Role::$ADMIN
                ],
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

        $this->loadLogger();
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }
        /**
         * Transmissor; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec'.DIRECTORY_SEPARATOR.'telefonica.php'), 'sitec.telefonica');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations');

        $this->app->singleton(
            'telefonica', function () {
                return new Telefonica();
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Telefonica;
         */
        $this->app->singleton(
            TelefonicaService::class, function ($app) {
                Log::channel('sitec-telefonica')->info('Singleton Telefonica;');
                return new TelefonicaService(\Illuminate\Support\Facades\Config::get('sitec.telefonica'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/telefonica/src/Console/Commands') => '\Telefonica\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('telefonica_asset')) {
        //     function telefonica_asset($path, $secure = null)
        //     {
        //         return route('rica.telefonica.assets').'?path='.urlencode($path);
        //     }
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'telefonica',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec') => config_path('sitec'),
            ], ['config',  'sitec', 'sitec-config']
        );

        // // Publish telefonica css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('telefonica') => public_path('assets/telefonica')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'telefonica');
        $this->publishes(
            [
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'telefonica'),
            ], ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'telefonica')
            ], ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'telefonica');
    }


    /**
     *
     */
    private function loadLogger()
    {
        Config::set(
            'logging.channels.sitec-telefonica', [
            'driver' => 'single',
            'path' => storage_path('logs'.DIRECTORY_SEPARATOR.'sitec-telefonica.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
