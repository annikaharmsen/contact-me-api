<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
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
            $contactEmail = config('mail.contact_email');

            if (!$contactEmail) {
                \Log::error('CONTACT_EMAIL not configured');
                return response()->json(['error' => 'Server configuration error'], 500);
            }

            ini_set('max_execution_time', 30);

            Mail::to($contactEmail)->send(new ContactFormMail($data));

            return response()->json([
                'message' => 'Email sent successfully'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Exception in contact controller: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to send email'
            ], 500);
        }
    }
}
