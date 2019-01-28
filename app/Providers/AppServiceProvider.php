<?php

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Phonebook API",
 *     description="API documentation for phonebook web service",
 *     @OA\Contact(name="Nikita Boldasov", email="renom@list.ru"),
 * )
 *
 * @OA\Schema(schema="id", type="integer", format="int32", minimum=0)
 * @OA\Schema(schema="fullname", type="string", maxLength=135)
 * @OA\Schema(schema="surname", type="string", maxLength=45)
 * @OA\Schema(schema="name", type="string", maxLength=45)
 * @OA\Schema(schema="patronymic", type="string", maxLength=45)
 * @OA\Schema(schema="number", type="string", maxLength=45)
 * @OA\Schema(schema="created_at", type="string", format="date-time")
 * @OA\Schema(schema="updated_at", type="string", format="date-time")
 * @OA\Schema(schema="page", type="integer", format="int32", minimum=0)
 * @OA\Parameter(name="page", in="query", description="Page (The default value is 1)", @OA\Schema(ref="#/components/schemas/page"))
 * @OA\Parameter(name="contactId", in="path", required=true, description="A contact identifier", @OA\Schema(ref="#/components/schemas/id"))
 * @OA\Parameter(name="phoneId", in="path", required=true, description="A phone identifier", @OA\Schema(ref="#/components/schemas/id"))
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
