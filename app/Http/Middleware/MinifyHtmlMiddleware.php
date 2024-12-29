<?php

namespace App\Http\Middleware;

use Closure;

class MinifyHtmlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Process only HTML responses
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();

            // Minify HTML and inline JavaScript
            $minified = $this->minifyHtmlAndJs($content);

            // Set the minified content back to the response
            $response->setContent($minified);
        }

        return $response;
    }

    /**
     * Minify HTML and inline JavaScript.
     *
     * @param string $html
     * @return string
     */
    protected function minifyHtmlAndJs($html)
    {
        // Minify inline JavaScript using regex
        $html = preg_replace_callback(
            '/<script\b[^>]*>(.*?)<\/script>/is',
            function ($matches) {
                // Minify only non-empty script tags
                if (trim($matches[1])) {
                    return '<script>' . $this->minifyJs($matches[1]) . '</script>';
                }
                return $matches[0];
            },
            $html
        );

        // Remove HTML comments except for conditional comments
        $html = preg_replace('/<!--(?!\[if).*?-->/s', '', $html);

        // Remove whitespace between tags
        $html = preg_replace('/>\s+</', '><', $html);

        // Remove unnecessary spaces and line breaks
        $html = preg_replace('/\s+/', ' ', $html);

        return $html;
    }

    /**
     * Minify JavaScript content.
     *
     * @param string $js
     * @return string
     */
    protected function minifyJs($js)
    {
        // Remove comments, unnecessary spaces, and line breaks
        $js = preg_replace('/\/\*.*?\*\/|\/\/.*(?=[\n\r])/', '', $js); // Remove comments
        $js = preg_replace('/\s+/', ' ', $js); // Collapse spaces
        $js = preg_replace('/\s*([{};,:])\s*/', '$1', $js); // Remove spaces around symbols
        $js = preg_replace('/;}/', '}', $js); // Remove unnecessary semicolons
        return trim($js);
    }
}
