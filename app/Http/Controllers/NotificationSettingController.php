<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingController extends Controller
{
    /**
     * Toggle the notification setting for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the field and value.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success.
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();

        $field = $request->input('field');

        // Properly cast boolean from JS
        $value = filter_var($request->input('value'), FILTER_VALIDATE_BOOLEAN);

        $user->notificationSettings()->updateOrCreate(
            ['user_id' => $user->id],
            [$field => $value ? 1 : 0]
        );

        return response()->json(['success' => true]);
    }
}
