<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;


class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    /**
     * @OA\Get(
     *      path="/messages",
     *      operationId="getAllmessages",
     *      tags={"Messages"},
     *      summary="Get list of messages",
     *      description="Returns list of messages",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Message")
     *       ),
     *      security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     *     )
     */
    public function fetchMessages()
    {
       $message = Message::with('user')->get();
       return response()->json($message);
    }

    /**


     * @OA\Post(
     *      path="/messages",
     *      operationId="Insert messages",
     *      tags={"Messages"},
     *      summary="Insert new messages",
     *      description="Returns messages data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Message")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Message")
     *       ),
     *   security={
     *         {
     *             "api_key": {},
     *         }
     *     },
     * )
     */
public function sendMessage(Request $request)
{
  $user = Auth::user();

  $message = $user->messages()->create([
    'message' => $request->input('message')
  ]);

  return ['status' => 'Message Sent!'];
}
}
