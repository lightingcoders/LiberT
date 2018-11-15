<?php

namespace App\Providers;

use App\Logic\Classes\BitcoinAdapter;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use JeroenG\Packager\PackagerServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $this->prepareDatabase();
        $this->loadBladeDirective();
        $this->forceURLScheme($url);
    }

    /**
     * Prepare database schema
     *
     * @return void
     */
    private function prepareDatabase()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Force https on url
     *
     * @param UrlGenerator $url
     * @return void
     */
    private function forceURLScheme(UrlGenerator $url)
    {
        if (env('APP_REDIRECT_HTTPS', false)) {
            $url->forceScheme('https');
        }
    }

    /**
     * Register blade directives
     *
     * @return void
     */
    private function loadBladeDirective()
    {
        Blade::directive('alloworcan', function ($arguments) {
            list($permission, $user) = explode(',', $arguments);

            return "<?php if(auth()->user()->can({$permission}) || {$user} == auth()->user()->id):?>";
        });

        Blade::directive('endalloworcan', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // For development purpose only...
        if ($this->app->environment() === 'local') {
            $this->app->register(PackagerServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
