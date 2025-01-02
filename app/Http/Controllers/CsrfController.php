<?php

namespace App\Http\Controllers;

use App\Models\EnvironmentVariable;
use GuzzleHttp\Middleware;
use Illuminate\Foundation\Configuration\Middleware as ConfigurationMiddleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CsrfController extends Controller
{
    
    public function toggleEnableCsrfToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|boolean',
        ]);

        $variable = EnvironmentVariable::where('name', $request->name)->first();

        if ($variable) {
            $variable->value = $request->value;
            $variable->save();

            return response()->json(['success' => true, 'value' => $variable->value]);
        }

        return response()->json(['success' => false, 'message' => 'Variable not found']);
    }
    
    /**
     * @OA\Post(
     *     path="/csrf/transfer",
     *     summary="Transfer funds",
     *     description="Endpoint for transferring funds by providing account number and amount",
     *     tags={"Funds Transfer"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"account_number", "amount"},
     *                 @OA\Property(
     *                     property="account_number",
     *                     type="number",
     *                     description="The account number to transfer funds to"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="number",
     *                     format="float",
     *                     description="The amount to transfer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funds transferred successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function transfer(Request $request)
    {   
        if ($request->source == 'form') {
            return redirect()->back()->with('success', 'Transfer successfully!');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully',
                'data' => $request->all(),
            ]);
        }
    }
}
