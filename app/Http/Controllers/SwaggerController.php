<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwaggerController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel OpenApi Demo Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     *
     * @OA\Tag(
     *     name="Users",
     *     description="API Endpoints of Users"
     * )
     * @OA\Tag(
     *     name="Auth",
     *     description="API Endpoints of Auth"
     * )
     * @OA\Tag(
     *     name="Categories",
     *     description="API Endpoints of Categories"
     * )
     * @OA\Tag(
     *     name="Items",
     *     description="API Endpoints of Items"
     * )
     * @OA\Tag(
     *     name="Messages",
     *     description="API Endpoints of Messages"
     * )
     * @OA\Tag(
     *     name="Providers",
     *     description="API Endpoints of Providers"
     * )
     * @OA\Tag(
     *     name="Replays",
     *     description="API Endpoints of Replays"
     * )
     * @OA\Tag(
     *     name="SocialIdentity",
     *     description="API Endpoints of SocialIdentity"
     * )
     */
     /**
      * @OA\SecurityScheme(
      *   securityScheme="api_key",
      *   type="apiKey",
      *   in="header",
      *   name="Authorization"
      * )
      */
}
