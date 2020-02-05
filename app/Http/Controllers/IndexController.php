<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    /**
     * Search words
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function searchWords(Request $request)
    {
        $this->validate(
            $request,
            [
                'textPattern' => 'bail|string|nullable',
                'page' => 'bail|required|integer'
            ]
        );

        $textPattern = $request->input('textPattern');

        $search = Word::when(
            $textPattern,
            function ($query, $textPattern) {
                return $query->where('text', 'like', "%{$textPattern}%");
            }
        )->orderBy('id', 'desc')->paginate(10);

        return response()->json(
            [
                'wordsList' => $search->items(),
                'pagination' => [
                    'currentPage' => $search->currentPage(),
                    'lastPage' => $search->lastPage()
                ]
            ]
        );
    }

    /**
     * Find word
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function findWord(Request $request)
    {
        $this->validate(
            $request,
            [
                'wordId' => 'bail|required|integer',
            ]
        );

        $word = Word::findOrFail($request->wordId);

        return response()->json($word->load('translations'));
    }

    /**
     * Add word
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function addWord(Request $request)
    {
        $this->validate(
            $request,
            [
                'text' => 'bail|required|string',
                'transcription' => 'bail|required|string',
                'translation' => 'bail|required|string',
                'example' => 'bail|required|string',
            ]
        );

        $word = Word::create(
            $request->only(
                [
                    'text',
                    'transcription'
                ]
            )
        );

        $word->translations()->create(
            [
                'text' => $request->translation,
                'example' => $request->example
            ]
        );

        return response()->json($word);
    }

    /**
     * Edit word
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function editWord(Request $request)
    {
        $this->validate(
            $request,
            [
                'wordId' => 'bail|required|integer',
                'text' => 'bail|required|string',
                'transcription' => 'bail|required|string',
            ]
        );

        $word = Word::findOrFail($request->wordId);

        $word->text = $request->text;
        $word->transcription = $request->transcription;
        $word->save();

        return response()->json($word->load('translations'));
    }

    /**
     * Add translation
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function addTranslation(Request $request)
    {
        $this->validate(
            $request,
            [
                'wordId' => 'bail|required|integer',
                'text' => 'bail|required|string',
                'example' => 'bail|required|string',
            ]
        );

        $word = Word::find($request->wordId);

        if (!$word) {
            abort(500, 'Word does not exist.');
        }

        $translation = $word->translations()->create(
            $request->only(
                [
                    'text',
                    'example'
                ]
            )
        );

        return response()->json(
            $translation
        );
    }

    /**
     * Remove translation
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function removeTranslation(Request $request)
    {
        $this->validate(
            $request,
            [
                'translationId' => 'bail|required|integer'
            ]
        );

        $translation = Translation::find($request->translationId);

        if (!$translation) {
            abort(500, 'Translation does not exist.');
        }

        $translation->delete();

        return response()->json(
            []
        );
    }

    /**
     * Get random word
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function getRandomWord(Request $request)
    {

        $translations = Translation::all();

        if ($translations->count() === 0) {
            abort(500, 'Dictionary is empty');
        }

        $translation = $translations->random()->load('word');

        return response()->json(
            [
                'word' => $translation->word->text,
                'transcription' => $translation->word->transcription,
                'translation' => $translation->text,
                'example' => $translation->example
            ]
        );
    }

}
