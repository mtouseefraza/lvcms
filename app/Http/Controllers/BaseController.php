<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Services\BreadcrumbService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    protected $AuthUser;

    public function __construct(BreadcrumbService $breadcrumbService)
    {
        $this->middleware(function ($request, $next) use ($breadcrumbService) {
            // Access session data after middleware is initialized
            View::share('menu', Session::get('menu'));
            View::share('breadcrumbService', $breadcrumbService->generateBreadcrumbs());
            
            $this->AuthUser = Auth::user();

            return $next($request);
        });
    }
}
