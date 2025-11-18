<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CpfFormatterServiceInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

/**
 * Class CpfFormatterController
 * @author Gabriel Morgado <kazzxd1@gmail.com>
 */
class CpfFormatterController extends Controller
{
    /**
     * Clean non numeric characters, force length to 11 characters and apply mask
     *
     * @param Request $request
     * @param CpfFormatterServiceInterface $cpfFormatterService
     * @return JsonResponse
     */
    public function cpfFormat(Request $request, CpfFormatterServiceInterface $cpfFormatterService): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "cpfs"    => "required|array|min:1",
            "cpfs.*"  => "required|string|min:1",
        ]);

        if ($validator->fails() === true) {
            throw new HttpResponseException(response()->json([
                'message' => 'Validation error.',
                'errors' => $validator->errors(),
            ], 422));
        }

        return response()->json([
            'data' => $cpfFormatterService->format($request->input('cpfs'))
        ]);
    }
}
