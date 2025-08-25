<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMail;
use App\Mail\ContactFormMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        try {

            Mail::send(new ContactFormMail($data));

        } catch (Exception $error) {
            \Log::error(
                'ContactController failed to send ContactFormMail: ' . $error->getMessage()
            );
            return response()->json([
                'error' => 'Failed to send email'
            ], 500);
        }

        try {

            Mail::send(new ConfirmationMail($data));

        } catch (Exception $error) {
            \Log::error(
                'ContactController failed to send ConfirmationMail: ' . $error->getMessage()
            );
        }

        return response()->json([
            'message' => 'Email sent successfully'
        ], 200);
    }
}
