<?php

namespace App\Http\Controllers;

use App\Http\Resources\DictionaryCollection;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

final class DictionaryController extends Controller
{
    private int $limit = 1000;

    public function __invoke(Request $request)
    {
        return new DictionaryCollection(
            Theme::with(['words' => fn(HasMany $query) => $query->orderBy('language')])
                ->limit($this->limit)
                ->offset($request->get('offset', 0))
                ->get()
        );
    }
}
