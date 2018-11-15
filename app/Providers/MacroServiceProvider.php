<?php

namespace App\Providers;

use Collective\Html\HtmlServiceProvider;

/**
 * Class MacroServiceProvider.
 */
class MacroServiceProvider extends HtmlServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        // Load HTML Macros
        require base_path('/app/Logic/Macros/HtmlMacros.php');
    }
}
