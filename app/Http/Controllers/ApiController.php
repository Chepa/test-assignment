<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchResource;
use App\Services\OxfordDictionaries\TranslateService;
use Illuminate\Http\Request;
use Throwable;

final class ApiController extends Controller
{
    public function __construct(
        private readonly TranslateService $translateService
    ) {
    }

    public function search(Request $request)
    {
        try {
            return [
                'status' => 'success',
                'result' => new SearchResource($this->translateService->search($request->get('q', '')))
            ];
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => __($exception->getMessage())
            ]);
        }
    }

    public function translate(Request $request)
    {
        try {
            $request->validate(['word' => ['required', 'string', 'min:3']]);
            return [
                'status' => 'success',
                'result' => $this->translateService->translate($request->get('word', ''))
            ];
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => __($exception->getMessage())
            ]);
        }
    }
}
