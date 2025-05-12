<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }

        if (is_string($input)) {
            // Remove any HTML tags
            $input = strip_tags($input);
            
            // Convert special characters to HTML entities
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            
            // Remove any potential SQL injection patterns
            $input = str_replace(
                ['SELECT', 'INSERT', 'UPDATE', 'DELETE', 'DROP', 'UNION', '--', ';'],
                '',
                strtoupper($input)
            );
        }

        return $input;
    }

    protected function validateAndSanitize($request, $rules)
    {
        $validated = $request->validate($rules);
        return $this->sanitizeInput($validated);
    }
} 