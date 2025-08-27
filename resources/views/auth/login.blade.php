<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <h2 class="text-2xl font-bold text-white text-center mb-6">Masuk Akun</h2>
    
    <div x-data="loginPage()">
        <!-- Role Selection Section -->
        <div class="mb-6">
            <h3 class="text-base font-medium text-white/90 mb-3">Pilih Jenis Pengguna:</h3>
            <div class="grid grid-cols-2 gap-4">
                <!-- Admin Card -->
                <div class="cursor-pointer transition-all duration-300 hover:scale-105" 
                     :class="{'ring-2 ring-white': selectedRole === 'admin'}"
                     @click="selectRole('admin')">
                    <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                        <div class="w-12 h-12 rounded-lg bg-purple-600/20 flex items-center justify-center mb-3">
                            <i data-lucide="settings" class="w-6 h-6 text-purple-400"></i>
                        </div>
                        <h4 class="font-medium text-white">Admin</h4>
                        <p class="text-xs text-white/70 text-center mt-1">Admin Sistem</p>
                    </div>
                </div>
                
                <!-- Operator Card -->
                <div class="cursor-pointer transition-all duration-300 hover:scale-105" 
                     :class="{'ring-2 ring-white': selectedRole === 'operator'}"
                     @click="selectRole('operator')">
                    <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                        <div class="w-12 h-12 rounded-lg bg-emerald-600/20 flex items-center justify-center mb-3">
                            <i data-lucide="laptop" class="w-6 h-6 text-emerald-400"></i>
                        </div>
                        <h4 class="font-medium text-white">Operator</h4>
                        <p class="text-xs text-white/70 text-center mt-1">Verifikator KP</p>
                    </div>
                </div>
                
                <!-- Operator Sekolah Card -->
                <div class="cursor-pointer transition-all duration-300 hover:scale-105" 
                     :class="{'ring-2 ring-white': selectedRole === 'operator-sekolah'}"
                     @click="selectRole('operator-sekolah')">
                    <div class="h-full p-4 rounded-xl bg-white/10 dark:bg-gray-700/20 border border-white/20 dark:border-gray-600/30 backdrop-blur-md flex flex-col items-center justify-center transition-all hover:bg-white/20 dark:hover:bg-gray-600/30">
                        <div class="w-12 h-12 rounded-lg bg-blue-600/20 flex items-center justify-center mb-3">
                            <i data-lucide="school" class="w-6 h-6 text-blue-400"></i>
                        </div>
                        <h4 class="font-medium text-white">Operator Sekolah</h4>
                        <p class="text-xs text-white/70 text-center mt-1">Operator Sekolah</p>
                    </div>
                </div>
                
                <!-- Pegawai Card -->
                <div class="cursor-pointer transition-all duration-300 hover:scale-105" 
                     :class="{'ring-2 ring-white': selectedRole === 'pegawai'}"
                     @click="selectRole('pegawai')">
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

        <form method="POST" action="{{ route('login') }}" class="mt-6" id="loginForm" @submit="validateForm">
            @csrf
            
            <!-- Selected Role (Hidden Input) -->
            <input type="hidden" name="role" x-model="selectedRole">
            
            <!-- NIP Field -->
            <div>
                <x-input-label for="nip" :value="__('NIP')" class="text-white" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i data-lucide="id-card" class="w-5 h-5"></i>
                    </span>
                    <x-text-input 
                        id="nip" 
                        class="block w-full pl-10 bg-white/10 dark:bg-gray-700/20 border-white/20 dark:border-gray-600/30 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50" 
                        type="text"
                        name="nip" 
                        :value="old('nip')" 
                        x-model="nip"
                        placeholder="Masukkan NIP (18 digit)"
                        required 
                        autocomplete="username"
                    />
                </div>
                <div x-show="nipError" class="mt-1 text-red-300 text-sm" x-text="nipError"></div>
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
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
                        x-bind:type="passwordVisible ? 'text' : 'password'"
                        name="password"
                        placeholder="Masukkan Password" 
                        required 
                        autocomplete="current-password" 
                    />
                    <button type="button" @click="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-white/70 hover:text-white">
                        <i data-lucide="eye" class="w-5 h-5" x-show="!passwordVisible"></i>
                        <i data-lucide="eye-off" class="w-5 h-5" x-show="passwordVisible"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Captcha -->
            <div class="mt-4">
                <x-input-label for="captcha" :value="__('Captcha')" class="text-white" />
                <div class="mt-1">
                    <x-captcha id="captcha" />
                </div>
                <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded bg-white/10 dark:bg-gray-700/20 border-white/30 dark:border-gray-600/30 text-sky-500 focus:ring-sky-500/50 dark:focus:ring-sky-500/50" name="remember">
                    <span class="ms-2 text-sm text-white/80">{{ __('Ingat saya') }}</span>
                </label>
                
                <button type="button" 
                        class="text-sm text-white/70 hover:text-white underline-offset-2 hover:underline"
                        @click="openForgotPassword">
                    {{ __('Lupa password?') }}
                </button>
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="w-full py-3 px-4 flex justify-center items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-[1.02]"
                        :class="{'opacity-50 cursor-not-allowed hover:scale-100': !isFormValid}"
                        :disabled="!isFormValid">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>
        
        <!-- Forgot Password Modal -->
        <x-forgot-password-modal />
    </div>
    
    <script>
        function loginPage() {
            return {
                selectedRole: '',
                nip: '',
                nipError: '',
                passwordVisible: false,
                isFormValid: false,
                
                init() {
                    this.$nextTick(() => {
                        // Initialize Lucide icons after Alpine renders
                        lucide.createIcons();
                    });
                },
                
                selectRole(role) {
                    this.selectedRole = role;
                    this.validateForm();
                    
                    // Show toast notification
                    const roleNames = {
                        'admin': 'Administrator',
                        'operator': 'Operator',
                        'operator-sekolah': 'Operator Sekolah',
                        'pegawai': 'Pegawai'
                    };
                    showToast(`Anda memilih login sebagai ${roleNames[role] || role}`);
                },
                
                togglePassword() {
                    this.passwordVisible = !this.passwordVisible;
                    this.$nextTick(() => {
                        // Re-initialize icons after DOM update
                        lucide.createIcons();
                    });
                },
                
                validateNip() {
                    const nipPattern = /^\d{18}$/;
                    
                    if (!this.nip) {
                        this.nipError = 'NIP wajib diisi';
                        return false;
                    }
                    
                    if (!nipPattern.test(this.nip)) {
                        this.nipError = 'NIP harus terdiri dari 18 digit angka';
                        return false;
                    }
                    
                    this.nipError = '';
                    return true;
                },
                
                validateForm(e) {
                    // Check if role is selected
                    const isRoleValid = !!this.selectedRole;
                    const isNipValid = this.validateNip();
                    
                    // Get captcha validation status
                    let isCaptchaValid = false;
                    if (typeof Alpine !== 'undefined' && document.querySelector('[x-data="captchaComponent()"]')) {
                        const captchaComponent = Alpine.$data(document.querySelector('[x-data="captchaComponent()"]'));
                        isCaptchaValid = captchaComponent.validation.valid;
                    }
                    
                    // Form is valid if role, NIP and captcha are valid
                    this.isFormValid = isRoleValid && isNipValid && isCaptchaValid;
                    
                    // If form is not valid and user tried to submit, prevent submission
                    if (!this.isFormValid && e) {
                        e.preventDefault();
                    }
                },
                
                openForgotPassword() {
                    // Get reference to the forgot password modal Alpine component
                    const modalComponent = Alpine.$data(document.getElementById('forgotPasswordModal'));
                    modalComponent.open();
                    
                    // If NIP is filled, pre-populate the forgot password form
                    if (this.nip && this.validateNip()) {
                        modalComponent.formData.email_or_nip = this.nip;
                    }
                }
            };
        }
    </script>
</x-guest-layout>
