<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
      \View::composer('*', function($view){
        if(\Auth::user() != null && \Auth::user() != ''){
          $view->with('currentUser', \Auth::user());
          $view->with('pruebaglobal', 'prueba variable global');

          $perfil= [];
          $cantidad = \DB::table('roles')->count();

          for ($i=1; $i <= $cantidad+1 ; $i++) {
            $perfil[$i] = false;
          }

          //$roles = \App\Rol::rolesUser();
          //$val_user = User::where('IdPersonal',intval(\Auth::user()->IdPersonal))->first();
          $roles = \DB::table('Rol_User')->where('IdUser', intval(\Auth::user()->IdPersonal))->get();

          //dd($roles);

          foreach ($roles as $rol) {
            $perfil[$rol->IdRol] = true;
          }
          
          //dd($roles);
          $view->with('gl_perfil', $perfil);
          $view->with('gbPerfil', $roles);
        }

     });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
