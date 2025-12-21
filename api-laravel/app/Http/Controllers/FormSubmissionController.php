<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormSubmissionController extends Controller
{
    /**
     * Store a newly created form submission in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'agreeToTerms' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the form submission
            $submission = FormSubmission::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'phone' => $request->phone,
                'email' => $request->email,
                'agree_to_terms' => $request->agreeToTerms,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for registering! We will contact you soon.',
                'data' => [
                    'id' => $submission->id,
                    'email' => $submission->email,
                    'created_at' => $submission->created_at,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of form submissions.
     */
    public function index()
    {
        try {
            $submissions = FormSubmission::orderBy('created_at', 'desc')->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $submissions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching submissions.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
