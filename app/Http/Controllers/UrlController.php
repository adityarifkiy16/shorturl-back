<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    private $infouser;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->infouser = $request->user('api');
            return $next($request);
        });
    }
    public function show(Request $request)
    {
        $user = $request->user();
        $urls = Url::whereHas('user', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->get();

        return response()->json([
            'code' => 200,
            'data' => [
                'url' => $urls
            ]
        ], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'url' => 'required|string',
        ];
        $message = [
            'required' => 'The :attribute field is required.'
        ];
        $request->validate($rules, $message);
        $data = $request->all();
        @$data['user_id'] = $this->infouser->id;
        $data['unid'] = Str::uuid()->toString();
        $data['shorturl'] = Str::random(5);
        $url = Url::create($data);
        if ($url) {
            return response()->json([
                'code' => 200,
                'message' => 'Get Data Success',
                'data' => ['url' => $url]
            ], 200);
        }
        return response()->json([
            'code' => 409,
            'message' => 'Failed to create url'
        ], 409);
    }

    public function redirectUrl($shorturl)
    {
        $url = Url::whereRaw('BINARY shorturl = ?', $shorturl)->first();
        if ($url) {
            return response()->json([
                'code' => 200,
                'messages' => 'Get Data Success',
                'data' => ['original_url' => $url->url]
            ], 200);
        }
        return response()->json([
            'code' => 404,
            'message' => 'Url Not Found'
        ], 404);
    }
}
