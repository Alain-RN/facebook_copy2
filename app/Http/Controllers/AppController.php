<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query'); // Récupère le terme de recherche
        $authUserId = Auth::id(); // ID de l'utilisateur connecté

        // Récupère les IDs des amis existants
        $friendIds = Auth::user()->friends()->pluck('id')->toArray();

        // Recherche des utilisateurs qui ne sont pas amis
        $users = User::where('id', '!=', $authUserId) // Exclut l'utilisateur connecté
                     ->whereNotIn('id', $friendIds) // Exclut les amis existants
                     ->where(function ($queryBuilder) use ($query) {
                         $queryBuilder->where('name', 'LIKE', "%{$query}%")
                                      ->orWhere('email', 'LIKE', "%{$query}%");
                     })
                     ->take(10) // Limite à 10 résultats
                     ->get();

        return response()->json($users); // Retourne les résultats en JSON
    }
}