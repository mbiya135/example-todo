<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveredWebHookController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data = $request->json()->all();
//to do add validation
        $email = Email::byMessageId($data['MessageID']);
        $email->saveDelivered($data['DeliveredAt']);
        return response()->json(['success' => true]);
    }
}
