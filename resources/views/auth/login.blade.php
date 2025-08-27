<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <h2 class="text-2xl font-bold text-white text-center mb-6">Masuk Akun</h2>
    
    <!-- Role Selection Section -->
    <div class="mb-6">
        <h3 class="text-base font-medium text-white/90 mb-3">Pilih Jenis Pengguna:</h3>
        <div class="grid grid-cols-2 gap-4" id="roleSelector">
            <!-- Admin Card -->
            <div class="role-card cursor-pointer transition-all duration-300 hover:scale-105" data-role="admin">
                <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                    <div class="w-12 h-12 rounded-lg bg-purple-600/20 flex items-center justify-center mb-3">
                        <i data-lucide="settings" class="w-6 h-6 text-purple-400"></i>
                    </div>
                    <h4 class="font-medium text-white">Administrator</h4>
                    <p class="text-xs text-white/70 text-center mt-1">Admin Sistem</p>
                </div>
            </div>
            
            <!-- Verifikator Card -->
            <div class="role-card cursor-pointer transition-all duration-300 hover:scale-105" data-role="verifikator">
                <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                    <div class="w-12 h-12 rounded-lg bg-blue-600/20 flex items-center justify-center mb-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-blue-400"></i>
                    </div>
                    <h4 class="font-medium text-white">Verifikator</h4>
                    <p class="text-xs text-white/70 text-center mt-1">Tim Verifikasi</p>
                </div>
            </div>
            
            <!-- Operator Card -->
            <div class="role-card cursor-pointer transition-all duration-300 hover:scale-105" data-role="operator">
                <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                    <div class="w-12 h-12 rounded-lg bg-emerald-600/20 flex items-center justify-center mb-3">
                        <i data-lucide="laptop" class="w-6 h-6 text-emerald-400"></i>
                    </div>
                    <h4 class="font-medium text-white">Operator</h4>
                    <p class="text-xs text-white/70 text-center mt-1">Petugas Input Data</p>
                </div>
            </div>
            
            <!-- Pegawai Card -->
            <div class="role-card cursor-pointer transition-all duration-300 hover:scale-105" data-role="pegawai">
                <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                    <div class="w-12 h-12 rounded-lg bg-amber-600/20 flex items-center justify-center mb-3">
                        <i data-lucide="user" class="w-6 h-6 text-amber-400"></i>
                    </div>
                    <h4 class="font-medium text-white">Pegawai</h4>
                    <p class="text-xs text-white/70 text-center mt-1">Pegawai Negeri</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-6" id="loginForm">
        @csrf
        
        <!-- Selected Role (Hidden Input) -->
        <input type="hidden" name="role" id="selectedRole" value="">
        
        <!-- NIP/Username Field -->
        <div>
            <x-input-label for="email" :value="__('NIP/Username')" class="text-white" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </span>
                <x-text-input 
                    id="email" 
                    class="block w-full pl-10 bg-white/10 dark:bg-gray-700/20 border-white/20 dark:border-gray-600/30 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="Masukkan NIP/Username"
                    required 
                    autocomplete="username" 
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </span>
                <x-text-input 
                    id="password" 
                    class="block w-full pl-10 bg-white/10 dark:bg-gray-700/20 border-white/20 dark:border-gray-600/30 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50" 
                    type="password"
                    name="password"
                    placeholder="Masukkan Password" 
                    required 
                    autocomplete="current-password" 
                />
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-white/70 hover:text-white">
                    <i data-lucide="eye" class="w-5 h-5 toggle-show"></i>
                    <i data-lucide="eye-off" class="w-5 h-5 toggle-hide hidden"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white/10 dark:bg-gray-700/20 border-white/30 dark:border-gray-600/30 text-sky-500 focus:ring-sky-500/50 dark:focus:ring-sky-500/50" name="remember">
                <span class="ms-2 text-sm text-white/80">{{ __('Ingat saya') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-white/70 hover:text-white underline-offset-2 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" id="loginButton" class="w-full py-3 px-4 flex justify-center items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100" disabled>
                <i data-lucide="log-in" class="w-5 h-5"></i>
                {{ __('Masuk') }}
            </button>
        </div>
    </form>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleCards = document.querySelectorAll('.role-card');
            const selectedRoleInput = document.getElementById('selectedRole');
            const loginButton = document.getElementById('loginButton');
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const toggleShow = document.querySelector('.toggle-show');
            const toggleHide = document.querySelector('.toggle-hide');
            
            // Role selection
            roleCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    roleCards.forEach(c => {
                        c.querySelector('div').classList.remove('ring-2', 'ring-white');
                    });
                    
                    // Add active class to selected card
                    this.querySelector('div').classList.add('ring-2', 'ring-white');
                    
                    // Set selected role value
                    const role = this.getAttribute('data-role');
                    selectedRoleInput.value = role;
                    
                    // Enable login button when role is selected
                    loginButton.removeAttribute('disabled');
                    
                    // Show toast notification
                    showToast(`Anda memilih login sebagai ${getRoleName(role)}`);
                });
            });
            
            // Password visibility toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle visibility icons
                toggleShow.classList.toggle('hidden');
                toggleHide.classList.toggle('hidden');
            });
            
            // Helper function to get role name for display
            function getRoleName(role) {
                const roles = {
                    'admin': 'Administrator',
                    'verifikator': 'Verifikator',
                    'operator': 'Operator',
                    'pegawai': 'Pegawai'
                };
                return roles[role] || role;
            }
        });
    </script>
</x-guest-layout>
