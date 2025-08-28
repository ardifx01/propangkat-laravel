@extends('layouts.modern-welcome')

@section('content')
    <!-- Login Section -->
    <div class="min-h-screen bg-gradient-to-br from-sky-100 to-white dark:from-gray-950 dark:to-gray-900 flex items-center justify-center p-4 relative transition-colors duration-300">
        
        <!-- Theme Toggle -->
        <div class="absolute top-4 right-4 z-20">
            <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                <i data-lucide="sun" class="w-5 h-5 text-amber-500 dark:hidden"></i>
                <i data-lucide="moon" class="w-5 h-5 text-blue-400 hidden dark:block"></i>
            </button>
        </div>

        <!-- Back to Home Button -->
        <div class="absolute top-4 left-4 z-20">
            <a href="{{ url('/') }}" 
               class="flex items-center p-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white bg-white dark:bg-gray-800 rounded-full shadow-sm border border-gray-100 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
                <span class="hidden sm:inline text-sm font-medium">Kembali</span>
            </a>
        </div>

        <!-- Background Pattern (subtle) -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
        </div>

        <!-- Main Content -->
        <div x-data="modernLoginPage()" 
             class="relative z-10 w-full max-w-md mx-auto">
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-3 bg-green-50 dark:bg-green-900/30 border border-green-100 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Container -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-800 w-full overflow-hidden">
                
                <!-- Header -->
                <div class="text-center px-6 pt-8 pb-4">
                    <div class="flex items-center justify-center mb-3">
                        <img src="{{ asset('favicon.ico') }}" alt="ProPangkat Logo" class="h-8 w-8 mr-3">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">ProPangkat</h1>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Sistem Kenaikan Pangkat Terintegrasi</p>
                </div>

                <div class="px-6 pb-8">
                    <!-- Role Selection Section -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Jenis Pengguna</label>
                        <div class="grid grid-cols-2 gap-3">
                            
                            <!-- Admin Card -->
                            <div class="cursor-pointer rounded-lg border" 
                                 :class="{'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20': selectedRole === 'admin', 
                                         'border-gray-200 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800': selectedRole !== 'admin'}"
                                 @click="selectRole('admin')">
                                <div class="p-3 text-center">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="settings" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100">Admin</h4>
                                </div>
                            </div>
                            
                            <!-- Operator Card -->
                            <div class="cursor-pointer rounded-lg border" 
                                 :class="{'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20': selectedRole === 'operator', 
                                         'border-gray-200 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800': selectedRole !== 'operator'}"
                                 @click="selectRole('operator')">
                                <div class="p-3 text-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 dark:text-emerald-400"></i>
                                    </div>
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100">Operator</h4>
                                </div>
                            </div>
                            
                            <!-- Operator Sekolah Card -->
                            <div class="cursor-pointer rounded-lg border" 
                                 :class="{'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20': selectedRole === 'operator-sekolah', 
                                         'border-gray-200 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800': selectedRole !== 'operator-sekolah'}"
                                 @click="selectRole('operator-sekolah')">
                                <div class="p-3 text-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="school" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100">Op. Sekolah</h4>
                                </div>
                            </div>
                            
                            <!-- Pegawai Card -->
                            <div class="cursor-pointer rounded-lg border" 
                                 :class="{'border-blue-500 dark:border-blue-400 bg-blue-50 dark:bg-blue-900/20': selectedRole === 'pegawai', 
                                         'border-gray-200 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-800': selectedRole !== 'pegawai'}"
                                 @click="selectRole('pegawai')">
                                <div class="p-3 text-center">
                                    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="user" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100">Pegawai</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" @submit="validateForm" class="space-y-4">
                        @csrf
                        
                        <!-- Selected Role (Hidden Input) -->
                        <input type="hidden" name="role" x-model="selectedRole">
                        
                        <!-- NIP Field -->
                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                NIP
                            </label>
                            <div class="relative">
                                <input 
                                    id="nip" 
                                    type="text"
                                    name="nip" 
                                    x-model="nip"
                                    @input="validateNip"
                                    class="w-full px-3 py-2 pl-9 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                    placeholder="Masukkan NIP 18 digit"
                                    required 
                                    autocomplete="username"
                                    maxlength="18"
                                />
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i data-lucide="id-card" class="w-4 h-4"></i>
                                </span>
                            </div>
                            <div x-show="nipError" class="mt-1 text-red-500 text-xs">
                                <span x-text="nipError"></span>
                            </div>
                            @error('nip')
                                <div class="mt-1 text-red-500 text-xs">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    x-bind:type="passwordVisible ? 'text' : 'password'"
                                    name="password"
                                    class="w-full px-3 py-2 pl-9 pr-9 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                    placeholder="Masukkan password" 
                                    required 
                                    autocomplete="current-password"
                                />
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </span>
                                <button type="button" @click="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i data-lucide="eye" class="w-4 h-4" x-show="!passwordVisible"></i>
                                    <i data-lucide="eye-off" class="w-4 h-4" x-show="passwordVisible"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="mt-1 text-red-500 text-xs">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Captcha Field -->
                        <div>
                            <x-captcha id="captcha" class="w-full" />
                            @error('captcha')
                                <div class="mt-1 text-red-500 text-xs">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-blue-500 focus:ring-blue-500" name="remember">
                                <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">Ingat saya</span>
                            </label>
                            
                            <button type="button" 
                                    class="text-xs text-blue-600 dark:text-blue-400 hover:underline"
                                    @click="openForgotPassword">
                                Lupa password?
                            </button>
                        </div>

                        <!-- Login Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center"
                                    :class="{'opacity-50 cursor-not-allowed': !isFormValid}"
                                    :disabled="!isFormValid">
                                <span x-show="!isSubmitting">Masuk</span>
                                <div x-show="isSubmitting" class="animate-spin mr-2">
                                    <i data-lucide="loader-2" class="w-4 h-4"></i>
                                </div>
                                <span x-show="isSubmitting">Memproses...</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Footer Info -->
                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            © {{ date('Y') }} Dinas Pendidikan dan Kebudayaan Prov. Kaltim
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Forgot Password Modal -->
            <x-forgot-password-modal />
        </div>
    </div>

@push('scripts')
<script>
    function modernLoginPage() {
        return {
            selectedRole: 'pegawai',  // Set default role to pegawai
            nip: '',
            nipError: '',
            passwordVisible: false,
            isFormValid: false,
            isSubmitting: false,
            
            init() {
                this.$nextTick(() => {
                    // Initialize Lucide icons after Alpine renders
                    lucide.createIcons();
                });
                
                // Auto-validate form whenever inputs change
                this.$watch('selectedRole', () => this.validateForm());
                this.$watch('nip', () => this.validateForm());
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
                
                // Create toast notification
                this.showToast(`Anda memilih login sebagai ${roleNames[role] || role}`, 'success');
                
                // Focus on NIP input after role selection
                setTimeout(() => {
                    document.getElementById('nip')?.focus();
                }, 200);
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
                
                if (!/^\d+$/.test(this.nip)) {
                    this.nipError = 'NIP hanya boleh berisi angka';
                    return false;
                }
                
                if (this.nip.length !== 18) {
                    this.nipError = `NIP harus tepat 18 digit (saat ini: ${this.nip.length} digit)`;
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
                const captchaElements = document.querySelectorAll('[x-data*="captchaComponent"]');
                if (captchaElements.length > 0) {
                    const captchaData = Alpine.$data(captchaElements[0]);
                    isCaptchaValid = captchaData?.validation?.valid || false;
                }
                
                // Get password value
                const passwordInput = document.getElementById('password');
                const isPasswordValid = passwordInput?.value?.length >= 1;
                
                // Form is valid if all fields are valid
                this.isFormValid = isRoleValid && isNipValid && isPasswordValid;
                
                // If form is not valid and user tried to submit, prevent submission
                if (e) {
                    if (!this.isFormValid) {
                        e.preventDefault();
                        
                        if (!isRoleValid) {
                            this.showToast('Silakan pilih jenis pengguna terlebih dahulu', 'error');
                        } else if (!isNipValid) {
                            this.showToast('Silakan masukkan NIP yang valid', 'error');
                        } else if (!isPasswordValid) {
                            this.showToast('Silakan masukkan password', 'error');
                        }
                    } else if (!isCaptchaValid) {
                        e.preventDefault();
                        this.showToast('Silakan masukkan kode verifikasi yang benar', 'error');
                    } else {
                        this.isSubmitting = true;
                    }
                }
            },
            
            openForgotPassword() {
                // Get reference to the forgot password modal Alpine component
                const modalElement = document.getElementById('forgotPasswordModal');
                if (modalElement) {
                    const modalComponent = Alpine.$data(modalElement);
                    modalComponent.open();
                    
                    // If NIP is filled and valid, pre-populate the forgot password form
                    if (this.nip && this.validateNip()) {
                        modalComponent.formData.email_or_nip = this.nip;
                    }
                }
            },
            
            showToast(message, type = 'info') {
                // Create toast element
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 p-3 rounded-lg shadow-md transform transition-all duration-300 translate-x-full max-w-sm`;
                
                // Set toast styling based on type
                if (type === 'success') {
                    toast.className += ' bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-200 border border-green-100 dark:border-green-800';
                } else if (type === 'error') {
                    toast.className += ' bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-200 border border-red-100 dark:border-red-800';
                } else {
                    toast.className += ' bg-blue-50 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 border border-blue-100 dark:border-blue-800';
                }
                
                toast.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'alert-circle' : 'info'}" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm">${message}</span>
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                // Initialize lucide icons in the toast
                lucide.createIcons();
                
                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 300);
                }, 3000);
            }
        };
    }
</script>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(14, 165, 233, 0.4);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(14, 165, 233, 0.6);
}
</style>
@endsection
