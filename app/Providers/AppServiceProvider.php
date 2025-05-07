<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Partager l'utilisateur connecté avec toutes les vues
        View::composer('*', function ($view) {
            // Partager l'utilisateur connecté
            $view->with('authUser', Auth::user());
        });
    }
}