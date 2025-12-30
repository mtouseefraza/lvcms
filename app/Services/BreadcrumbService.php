<?php
// app/Services/BreadcrumbService.php
namespace App\Services;
use Illuminate\Support\Facades\Route;

class BreadcrumbService
{
    public function generateBreadcrumbs()
    {
        $breadcrumbs = [];

        // Get the current route name
        $routeName = Route::currentRouteName();
        $urlSegments = explode('.', $routeName); // Split route name to handle nested routes
        
        // Add the homepage breadcrumb
        $breadcrumbs[] = [
            'title' => 'Home',
            'url' => route('home'),
        ];

        if (isset($urlSegments[0]) && Route::has($urlSegments[0].'.index') && !empty($urlSegments[0])) {
            $breadcrumbs[] = [
                'title' => ucfirst(str_replace('-', ' ', $urlSegments[0])),
                'url' => route($urlSegments[0].'.index')
            ];
        }

        if (isset($routeName) && Route::has($routeName) && !empty($urlSegments[1])) {
            $breadcrumbs[] = [
                'title' => ucfirst(str_replace('-', ' ', $urlSegments[1])),
                'url' => '#'
            ];
        }

        return $breadcrumbs;
    }
}
