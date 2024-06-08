<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $urls = Url::whereHas('user', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->get();

        return response()->json([
            'success' => true,
            'url' => $urls
        ], 200);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'url' => 'required|string|max:255',
        ];
        $message = [
            'required' => 'The :attribute field is required.'
        ];
        $request->validate($rules, $message);
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['unid'] = Str::uuid()->toString();
        $data['shorturl'] = Str::random(5);
        $url = Url::create($data);

        if ($url) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'url' => $url
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    public function redirectUrl($shorturl)
    {
        $url = Url::whereRaw('BINARY shorturl = ?', $shorturl)->first();
        if ($url) {
            return response()->json([
                'success' => true,
                'original_url' => $url->url
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'url not found'
        ], 404);
    }
}
