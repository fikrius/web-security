<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *     title="API Documentations",
 *     version="1.0.0",
 *     description="
 *      SQL Injection Example : lesch.kacie@mail.org. The full query : SELECT * FROM users WHERE email = '' OR 1=1 --''"
 * )
 */
class SqlInjectionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/sqlInjection/userUnsecured/{email}",
     *     tags={"SQL Injection"},
     *     summary="Insecure endpoint vulnerable to SQL injection",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="The email of the user to fetch.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a user record if found.",
     *         @OA\JsonContent(type="object", @OA\Property(property="name", type="string"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     )
     * )
     */
    public function userUnsecured(Request $request)
    {
        $email = $request->input('email');

        $results = DB::select("SELECT * FROM users WHERE email = '$email'");

        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/sqlInjection/userSecured/{email}",
     *     tags={"SQL Injection"},
     *     summary="Secure endpoint using parameterized queries",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="The email of the user to fetch.",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a user record if found.",
     *         @OA\JsonContent(type="object", @OA\Property(property="name", type="string"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     )
     * )
     */
    public function userSecured(Request $request)
    {
        $email = $request->input('email');

        $results = DB::select('SELECT * FROM users WHERE email = :email', ['email' => $email]);

        return response()->json($results);
    }

    public function userUnsecuredSqlMapTest(Request $request)
    {
        $email = $request->query('email');

        $results = DB::select("SELECT * FROM users WHERE email = '$email'");

        return response()->json($results);
    }
}
