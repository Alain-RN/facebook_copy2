<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function search(Request $request)
    {
        // Récupérer la valeur de la recherche
        $query = $request->input('query');

        // Effectuer une recherche dans la base de données
        $friends = User::where('name', 'like', '%' . $query . '%')->get();

        return response()->json(view('partials.search_results', compact('friends'))->render());
    }
}