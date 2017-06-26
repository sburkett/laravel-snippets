<?php

/**
 *
 * Domain Whitelist Middleware Component
 *
 * Not perfect, or terribly secure, but does what it can...
 *
 */

namespace App\Http\Middleware;

use Closure;

class DomainWhitelist
{
    /**
     * The URIs that should be excluded from domain whitelisting
     *
     * @var array
     */
   protected $except = [
       'some-URI/path*',
    ];

	// List of approved domains. Can also come from a datasource if so you wish to modify the code to do so...

	protected $approvedDomains = [
		'somedomain.com',
		'anotherdomain.com',
	];

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }


	public function handle($request, closure $next)
	{
		// Handle protected URIs
		if($this->inExceptArray($request))
			return $next($request);

		// Verify request
		$referer = $request->headers->get('referer');
		$origin = $request->headers->get('origin');

		if(!isset($referer) && !isset($origin))
			return response()->json([ 'error' => 'Invalid token request' ], 403);

		// We can only do this if we have both the headers - duh!
		if(isset($referer) && isset($origin))
		{
			$urlPartsReferer = parse_url($referer);
			$urlPartsOrigin = parse_url($origin);

			$remoteDomainReferer = $urlPartsReferer['host'];
			$remoteDomainOrigin = $urlPartsOrigin['host'];
			
			if($remoteDomainReferer != $remoteDomainOrigin)
			{
				return response()->json([ 'error' => 'Invalid token request' ], 403);
			}

			$domainArray = explode("\r\n", $settings->approved_domains);

			// Trim the whitespace from all of the elements
			$domainArray = array_map('trim', $domainArray);

			// Final check!
			if(!in_array($remoteDomainOrigin, $domainArray))
			{
				return response()->json([ 'error' => 'Invalid token request' ], 403);
			}
		}

		return $next($request);
	}
}
