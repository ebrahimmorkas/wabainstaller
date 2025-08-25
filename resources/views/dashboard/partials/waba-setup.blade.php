@php
  $steps = [
    ['key'=>'connection','label'=>'Connection','sub'=>'Enter IDs & Token'],
    ['key'=>'webhook','label'=>'Webhook','sub'=>'Verify webhook'],
    ['key'=>'numbers','label'=>'Numbers','sub'=>'Link numbers'],
    ['key'=>'finish','label'=>'Test & Finish','sub'=>'Send test'],
  ];
  $idx = collect($steps)->search(fn($s) => $s['key'] === $stage);
  $baseUrl = rtrim(config('app.url') ?? url('/'), '/');
  $webhookUrl = $baseUrl . '/webhook/waba';
  $verifyToken = config('services.meta_webhook.verify_token', env('META_WEBHOOK_VERIFY_TOKEN','verify_token'));
  $challenge   = \Illuminate\Support\Facades\Cache::get('waba_webhook_challenge');
@endphp

<div class="space-y-6">
  {{-- Stepper --}}
  <div class="bg-white rounded-xl border shadow">
    <div class="px-6 pt-5 pb-2">
      <h2 class="text-xl font-semibold">Quick Setup Wizard</h2>
      <p class="text-sm text-gray-500">Get your WhatsApp Business API configured in 4 simple steps</p>
    </div>
    <div class="px-6 pb-5">
      <div class="grid md:grid-cols-4 gap-3">
        @foreach ($steps as $i => $s)
          @php
            $done = $i < $idx;
            $active = $i === $idx;
          @endphp
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center
                        {{ $done ? 'bg-emerald-600 text-white' : ($active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700') }}">
              {{ $i+1 }}
            </div>
            <div>
              <div class="text-sm font-semibold {{ $active ? 'text-emerald-700' : 'text-gray-800' }}">{{ $s['label'] }}</div>
              <div class="text-xs text-gray-500">{{ $s['sub'] }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Panels --}}
  @if ($stage === 'connection')
    <div class="bg-white rounded-xl border shadow p-6">
      <div class="mb-4">
        <div class="font-semibold text-lg">Connection Setup</div>
        <p class="text-sm text-gray-500">Enter your Meta Developer credentials to connect your WhatsApp Business API</p>
      </div>

      <div class="mb-4">
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-3 py-2 rounded">
          Not connected yet — <span class="font-medium">Add credentials to continue</span>
        </div>
      </div>

      <form method="POST" action="{{ route('onboarding.connect.store') }}">
        @csrf
        <div class="md:col-span-2">
          <label class="text-sm font-medium text-gray-700">WABA ID</label>
          <input name="waba_id" value="{{ old('waba_id', $waba->waba_id ?? '') }}" placeholder="123456789012345"
                 class="w-full border rounded-lg px-3 py-2 mt-1" required>
        </div>

        <div class="md:col-span-2">
          <label class="text-sm font-medium text-gray-700">Access Token</label>
          <input type="password" name="access_token" value="{{ old('access_token', $waba->access_token ?? '') }}" placeholder="EAAG..."
                 class="w-full border rounded-lg px-3 py-2 mt-1" required>
          <p class="text-xs text-gray-500 mt-1">Use a permanent token from Meta Developer Dashboard.</p>
        </div>

        <div class="md:col-span-2 flex items-center gap-3">
          <button formaction="{{ route('onboarding.connect.store') }}"
                  class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
            Validate Connection
          </button>
        </div>
      </form>
    </div>
  @endif

  @if ($stage === 'webhook')
    <div class="bg-white rounded-xl border shadow p-6">
      <div class="mb-4">
        <div class="font-semibold text-lg">Webhook Setup</div>
        <p class="text-sm text-gray-500">Configure webhook endpoint for receiving messages and events</p>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <div class="text-sm font-semibold mb-2">Instructions</div>
          <label class="text-xs text-gray-600">Webhook URL</label>
          <div class="flex items-center gap-2 mt-1">
            <input readonly class="w-full border rounded-lg px-3 py-2" value="{{ $webhookUrl }}">
          </div>
          <ol class="mt-3 text-sm text-gray-600 space-y-1 list-decimal pl-5">
            <li>Add this URL in <b>Meta Developer → Webhooks</b> settings.</li>
            <li>Meta will send a <b>CHALLENGE</b> request to confirm ownership.</li>
            <li>Once verified, you'll see a success status below.</li>
          </ol>
        </div>

        <div>
          <div class="text-sm font-semibold mb-2">Configuration</div>

          <label class="text-xs text-gray-600">Verify Token</label>
          <input readonly class="w-full border rounded-lg px-3 py-2 mb-3" value="{{ $verifyToken }}">

          <label class="text-xs text-gray-600">Challenge Response</label>
          <input readonly class="w-full border rounded-lg px-3 py-2 mb-3" value="{{ $challenge ? $challenge : 'Auto-populated once Meta calls webhook' }}">

          <div class="flex items-center justify-between">
            <div class="text-sm">
              Webhook Status:
              @if (cache('waba_webhook_verified'))
                <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 text-xs">Verified</span>
              @else
                <span class="px-2 py-1 rounded bg-amber-100 text-amber-700 text-xs">Not Verified</span>
              @endif
            </div>
            <form method="POST" action="{{ route('onboarding.webhook.test') }}">
              @csrf
              <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                Trigger Challenge Test
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <a href="{{ route('onboarding.numbers', $waba->id) }}"
           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">
          Save & Continue →
        </a>
      </div>
    </div>
  @endif

  @if ($stage === 'numbers')
    <div class="bg-white rounded-xl border shadow p-6">
      <div class="mb-4">
        <div class="font-semibold text-lg">Link Numbers</div>
        <p class="text-sm text-gray-500">Sync your WABA phone numbers and activate at least one.</p>
      </div>

      <div class="flex items-center justify-between mb-3">
        <div class="text-sm text-gray-600">Account: <b>{{ $waba->name }}</b> · WABA ID: <span class="text-gray-500">{{ $waba->waba_id }}</span></div>
        <form method="POST" action="{{ route('onboarding.numbers.sync', $waba->id) }}">
          @csrf
          <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Sync Numbers</button>
        </form>
      </div>

      @if (($numbers ?? collect())->isEmpty())
        <div class="text-gray-600">No numbers yet. Click “Sync Numbers”.</div>
      @else
        <div class="overflow-x-auto rounded border">
          <table class="w-full text-sm">
            <thead class="bg-gray-50">
              <tr class="text-left">
                <th class="py-2 px-3">Display</th>
                <th class="px-3">Verified Name</th>
                <th class="px-3">Quality</th>
                <th class="px-3">Tier</th>
                <th class="px-3">Official</th>
                <th class="px-3">Status</th>
                <th class="px-3 text-right"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($numbers as $n)
                <tr class="border-t">
                  <td class="py-2 px-3 font-medium">{{ $n->display_phone_number }}</td>
                  <td class="px-3">{{ $n->verified_name }}</td>
                  <td class="px-3">{{ $n->quality_rating }}</td>
                  <td class="px-3">{{ $n->messaging_limit_tier }}</td>
                  <td class="px-3">{{ $n->is_official_business_account ? 'Yes' : 'No' }}</td>
                  <td class="px-3">
                    <span class="px-2 py-1 rounded text-xs {{ $n->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                      {{ ucfirst($n->status) }}
                    </span>
                  </td>
                  <td class="px-3 text-right">
                    <form method="POST" action="{{ route('onboarding.numbers.toggle', $n->phone_number_id) }}">
                      @csrf
                      <button class="px-3 py-1 border rounded-lg hover:bg-gray-50">
                        {{ $n->status === 'active' ? 'Deactivate' : 'Activate' }}
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-4 text-right">
          <a href="{{ route('onboarding.finish', $waba->id) }}"
             class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Continue →</a>
        </div>
      @endif
    </div>
  @endif

  @if ($stage === 'finish')
    <div class="bg-white rounded-xl border shadow p-6">
      <div class="font-semibold text-lg mb-2">All Set!</div>
      <p class="text-sm text-gray-600 mb-4">Your connection, webhook, and numbers look good. You can start using the panel.</p>
      <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Go to Dashboard</a>
    </div>
  @endif
</div>
