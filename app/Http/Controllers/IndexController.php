<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Find word
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findWord(Request $request)
    {
        $this->validate(
            $request,
            [
                'searchWord' => 'bail|required|string'
            ]
        );

        $word = Word::where('text', $request->searchWord)->with('translations')->first();

        return response()->json(
            [
                'word' => $word
            ]
        );
    }

    /**
     * Add word
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addWord(Request $request)
    {
        $this->validate(
            $request,
            [
                'text' => 'bail|required|string',
                'transcription' => 'bail|required|string'
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

        return response()->json(
            $word->load('translations')
        );
    }

    /**
     * Add translation
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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

    /**
     * Words list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWords()
    {

        return response()->json(
            [
                'words' => Word::all()
            ]
        );
    }

}
