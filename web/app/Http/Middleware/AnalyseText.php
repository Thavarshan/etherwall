<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Services\TextAnalyser\Client;

class AnalyseText
{
    public const ACCEPTABLE = '0';
    public const OFFENSIVE = '1';

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        $decision = $this->client->evaluate($request->input('body') ?? '');

        if ($decision === static::OFFENSIVE) {
            return back()->dangerBanner('Your submission contains offensive or hateful language.');
        }

        return $next($request);
    }
}
