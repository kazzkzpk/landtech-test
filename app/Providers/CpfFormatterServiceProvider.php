<?php

namespace App\Providers;

use App\Services\CpfFormatterServiceInterface;
use App\Services\CpfFormatterServiceFactory;
use Illuminate\Support\ServiceProvider;

/**
 * Class CpfFormatterServiceProvider
 * @author Gabriel Morgado <kazzxd1@gmail.com>
 */
class CpfFormatterServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            CpfFormatterServiceInterface::class,
            function () {
                return (new CpfFormatterServiceFactory())();
            }
        );
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}
