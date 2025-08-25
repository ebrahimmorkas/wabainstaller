<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class WabaWebhookController extends Controller
{
    /**
     * Meta Webhook verification.
     * GET /webhook/waba?hub.mode=subscribe&hub.challenge=xyz&hub.verify_token=YOUR_TOKEN
     */
    public function verify(Request $request)
    {
        $verifyToken = config('services.meta_webhook.verify_token', env('META_WEBHOOK_VERIFY_TOKEN'));

        if ($request->get('hub_mode') === 'subscribe' || $request->get('hub.mode') === 'subscribe') {
            if ($request->get('hub_verify_token') === $verifyToken || $request->get('hub.verify_token') === $verifyToken) {
                return response($request->get('hub_challenge') ?? $request->get('hub.challenge'), 200);
            }
        }

        return response('Invalid verify token', 403);
    }

    /**
     * Receive events from Meta.
     */
    public function receive(Request $request)
    {
        // Log raw payload for now; later parse messages/statuses etc.
        Log::info('[WABA webhook] payload', $request->all());

        // TODO: Dispatch jobs to handle messages, statuses, template updates, etc.

        return response()->json(['status' => 'ok']);
    }
}
