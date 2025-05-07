namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('register'); // Redirige vers la page d'inscription
        }

        return $next($request); // Continue vers la route demandée
    }
}
