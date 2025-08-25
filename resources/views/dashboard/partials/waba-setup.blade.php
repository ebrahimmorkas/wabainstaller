@php
  // Setup steps
  $steps = [
    ['key' => 'create',    'label' => 'Create Account'],
    ['key' => 'connect',   'label' => 'Connect WABA'],
    ['key' => 'numbers',   'label' => 'Phone Numbers'],
    ['key' => 'templates', 'label' => 'Templates'],
    ['key' => 'finish',    'label' => 'Finish'],
  ];

  $currentIndex = collect($steps)->search(
    fn($s) => $s['key'] === (($stage ?? '') === 'ready' ? 'finish' : ($stage ?? ''))
  );
@endphp

<style>
  .sw-step { transition: all .2s ease; }
  .sw-step.active { background: linear-gradient(135deg,#10b981,#059669); color:#fff; box-shadow: 0 6px 18px rgba(16,185,129,.25); }
  .sw-step.done   { background:#10b981; color:#fff; }
  .sw-step.todo   { background:#f3f4f6; color:#374151; }
  .sw-field:focus-within { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16,185,129,.15); }
</style>

<div class="p-4 md:p-6">
  <div class="bg-white rounded-2xl shadow border">

    {{-- Header --}}
    <div class="px-6 py-5 border-b flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold">Quick Setup Wizard</h2>
        <p class="text-sm text-gray-500">Complete these steps to start using WhatsApp Business.</p>
      </div>
      <span class="text-xs text-gray-400">{{ $stage ?? '' }}</span>
    </div>

    {{-- Stepper --}}
    <div class="px-6 pt-6">
      <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
        @foreach ($steps as $i => $s)
          @php
            $state = $i < $currentIndex ? 'done' : ($i === $currentIndex ? 'active' : 'todo');
          @endphp
          <div class="sw-step {{ $state }} rounded-xl px-3 py-2 text-sm flex items-center gap-2">
            <div class="w-6 h-6 rounded-full flex items-center justify-center
              {{ $state === 'done' ? 'bg-white text-green-600' : ($state === 'active' ? 'bg-white text-green-600' : 'bg-gray-300 text-gray-700') }}">
              {{ $i+1 }}
            </div>
            <div class="font-medium">{{ $s['label'] }}</div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Body --}}
    <div class="px-6 pb-6 pt-4">
      {{-- Needs migration --}}
      @if (($stage ?? '') === 'needs_migration')
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4">
          <div class="font-semibold mb-2">Database not initialized</div>
          <p class="text-sm">Run the following, then reload:</p>
          <pre class="bg-white p-3 rounded mt-2 text-xs overflow-x-auto">php artisan migrate</pre>
        </div>
      @endif

      {{-- Step: Create --}}
      @if (($stage ?? '') === 'create')
        <form method="POST" action="{{ route('onboarding.create.store') }}" class="space-y-4">
          @csrf
          <div class="sw-field">
            <label class="block text-sm text-gray-700 mb-1">Business / WABA Name</label>
            <input name="name" class="w-full border rounded-lg px-3 py-2" placeholder="Your Business Name" required>
          </div>
          <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Save & Continue</button>
          </div>
        </form>
      @endif

      {{-- Step: Connect --}}
      @if (($stage ?? '') === 'connect')
        <div class="mb-3 text-sm text-gray-600">Account: <b>{{ $waba?->name }}</b></div>
        <form method="POST" action="{{ route('onboarding.connect.store', $waba?->id) }}" class="grid md:grid-cols-2 gap-4">
          @csrf
          <div class="sw-field">
            <label class="block text-sm text-gray-700 mb-1">WABA ID</label>
            <input name="waba_id" value="{{ old('waba_id', $waba?->waba_id) }}" class="w-full border rounded-lg px-3 py-2" required>
          </div>
          <div class="sw-field">
            <label class="block text-sm text-gray-700 mb-1">Access Token</label>
            <input type="password" name="access_token" value="{{ old('access_token', $waba?->access_token) }}" class="w-full border rounded-lg px-3 py-2" required>
            <p class="text-xs text-gray-500 mt-1">Use a long-lived token; only admins can change it.</p>
          </div>
          <div class="md:col-span-2 flex gap-3">
            <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Save & Continue</button>
          </div>
        </form>
      @endif

      {{-- Step: Numbers --}}
      @if (($stage ?? '') === 'numbers')
        <div class="flex items-center justify-between mb-3">
          <div>
            <div class="text-sm text-gray-600">Account: <b>{{ $waba?->name }}</b></div>
            <div class="text-xs text-gray-500">WABA ID: {{ $waba?->waba_id }}</div>
          </div>
          <form method="POST" action="{{ route('onboarding.numbers.sync', $waba?->id) }}">
            @csrf
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Sync Phone Numbers</button>
          </form>
        </div>

        @if (($numbers ?? collect())->isEmpty())
          <div class="text-gray-600">No numbers yet. Click “Sync Phone Numbers”.</div>
        @else
          <div class="overflow-x-auto rounded-xl border">
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

          <div class="mt-3 flex gap-2">
            <form method="POST" action="{{ route('onboarding.verification.sync', $waba?->id) }}">
              @csrf
              <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">Sync Verification</button>
            </form>
            <form method="POST" action="{{ route('onboarding.profiles.sync', $waba?->id) }}">
              @csrf
              <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">Sync Profiles</button>
            </form>
            <form method="POST" action="{{ route('onboarding.templates.sync', $waba?->id) }}" class="ml-auto">
              @csrf
              <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Sync Templates</button>
            </form>
          </div>
        @endif
      @endif

      {{-- Step: Templates --}}
      @if (($stage ?? '') === 'templates')
        <div class="flex items-center justify-between mb-3">
          <div>
            <h3 class="text-lg font-semibold">Message Templates</h3>
            <p class="text-sm text-gray-500">No templates found yet. Sync to continue.</p>
          </div>
          <form method="POST" action="{{ route('onboarding.templates.sync', $waba?->id) }}">
            @csrf
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Sync Templates</button>
          </form>
        </div>
      @endif
    </div>
  </div>
</div>
