<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        \Log::info('ContactController::submit called', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

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
            $contactEmail = env('CONTACT_EMAIL');
            \Log::info('Contact email: ' . $contactEmail);

            Mail::raw($data['message'], function ($message) use ($data, $contactEmail) {
                $message->to($contactEmail)
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
