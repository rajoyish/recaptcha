<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('recaptcha', function (string $action) {
            return new HtmlString('
                x-data
                x-on:submit.prevent="
                    grecaptcha.ready(() => {
                        grecaptcha.execute(\''.config('recaptcha.key').'\', { action: '.$action.' }).then((token) => {
                            let input = document.createElement(\'input\')
                            input.setAttribute(\'type\', \'hidden\')
                            input.setAttribute(\'name\', \'recaptcha_token\')
                            input.setAttribute(\'value\', token)

                            $el.appendChild(input)

                            $nextTick(() => {
                                $el.submit()
                            })
                        })
                    })
                "
            ');
        });
    }
}
