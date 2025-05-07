<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

    
        $users = User::whereRaw('LOWER(name) LIKE ?', ['%' . $query . '%'])->get();
    
        $output = '';
        foreach ($users as $user) {
            $output .= '
            <div class="flex items-center gap-3 p-3 hover:bg-gray-100 cursor-pointer" onclick="window.location.href=\''.url('profile', $user->id).'\';">
                <img src="' . asset($user->profile_photo ? 'storage/' . $user->profile_photo : 'images/user.png') . '" alt="Profil" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col">
                    <span class="font-semibold text-gray-800">' . $user->name . '</span>
                    ' . ($user->id == Auth::id() ? '<span class="text-sm text-gray-500">Vous</span>' : '') . '
                </div>
            </div>';        
        }
        return response($output);
    }
}