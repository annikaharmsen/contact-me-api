<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
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
            Mail::raw($data['message'], function ($message) use ($data) {
                $message->to(env('CONTACT_EMAIL'))
                        ->subject($data['name'] . ': ' . ($data['subject'] ?? 'Contact Form'))
                        ->cc($data['email'])
                        ->replyTo($data['email'], $data['name']);
            });

            return response()->json([
                'message' => 'Email sent successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to send email'
            ], 500);
        }
    }
}
