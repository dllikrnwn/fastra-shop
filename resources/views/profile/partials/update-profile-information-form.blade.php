<section>
    <header>
        <h2 class="font-display font-semibold text-lg text-gray-900 dark:text-white">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update informasi akun dan foto profil kamu.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Avatar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Foto Profil</label>
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-full bg-accent/10 flex items-center justify-center shrink-0 overflow-hidden border-2 border-accent/20">
                    @if($user->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div id="avatar-placeholder" class="text-3xl font-display font-bold text-accent">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                </div>
                <div>
                    <input type="file" name="avatar" id="avatar-input" accept="image/*" class="nb-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-[2px] file:border-black file:text-sm file:font-bold file:cursor-pointer py-2 max-w-xs">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
                    @error('avatar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="nb-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" name="email" type="email" class="nb-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">No. WhatsApp</label>
            <input id="phone" name="phone" type="tel" class="nb-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="nb-btn-primary">Simpan</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" x-transition class="text-sm text-emerald-600">Tersimpan!</p>
            @endif
        </div>
    </form>

    <script>
        document.getElementById('avatar-input')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = document.getElementById('avatar-preview') || document.createElement('img');
                    img.id = 'avatar-preview';
                    img.src = ev.target.result;
                    img.className = 'w-full h-full object-cover';
                    const container = document.querySelector('#avatar-placeholder')?.parentElement || document.querySelector('.w-20.h-20');
                    if (container) {
                        container.innerHTML = '';
                        container.appendChild(img);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</section>
