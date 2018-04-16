<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    /**
     * param array|string $data
     */
    protected function json($data)
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }
        return response()->json(array_merge(
            ['code' => 0, 'message' => 'success'], $data));
    }
}
