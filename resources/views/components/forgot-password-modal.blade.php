@props(['id' => 'forgotPasswordModal'])

<div id="{{ $id }}" 
     x-data="forgotPasswordModal()"
     x-show="isOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] flex items-center justify-center p-4"
     x-cloak>
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="close"></div>
    
    <!-- Modal Content -->
    <div x-transition:enter="transition ease-out duration-300 delay-150"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="w-full max-w-md relative bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 dark:border-gray-700/30 p-6">
        
        <!-- Close Button -->
        <button @click="close" 
                class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-all">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        
        <!-- Modal Header -->
        <div class="mb-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i data-lucide="mail" class="w-8 h-8 text-white"></i>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 text-center mb-2">Reset Password</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm text-center leading-relaxed">
                Masukkan NIP atau email Anda. Kami akan mengirimkan tautan untuk mereset password Anda.
            </p>
        </div>
        
        <!-- Form -->
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="email_or_nip" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    NIP / Email
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="email_or_nip" 
                        x-model="formData.email_or_nip"
                        class="w-full px-4 py-3 pl-12 bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200"
                        placeholder="Masukkan NIP atau email Anda"
                        required
                    >
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </span>
                </div>
            </div>
            
            <!-- Message Display -->
            <div x-show="message.text" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 :class="{'bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700': message.type === 'success', 
                          'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-700': message.type === 'error'}"
                 class="p-4 rounded-xl text-sm">
                <div class="flex items-start space-x-2">
                    <i :data-lucide="message.type === 'success' ? 'check-circle' : 'alert-circle'" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                    <p x-text="message.text" class="leading-relaxed"></p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-2">
                <button 
                    type="button" 
                    @click="close"
                    class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200">
                    Batal
                </button>
                <button 
                    type="submit"
                    :disabled="isSubmitting || !formData.email_or_nip"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold rounded-xl transition-all duration-200 disabled:cursor-not-allowed flex items-center space-x-2">
                    <span x-show="!isSubmitting">Kirim Link Reset</span>
                    <span x-show="isSubmitting" class="flex items-center space-x-2">
                        <div class="animate-spin">
                            <i data-lucide="loader-2" class="w-4 h-4"></i>
                        </div>
                        <span>Memproses...</span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function forgotPasswordModal() {
    return {
        isOpen: false,
        isSubmitting: false,
        formData: {
            email_or_nip: ''
        },
        message: {
            text: '',
            type: '' // success or error
        },
        
        open() {
            this.isOpen = true;
            this.resetForm();
            document.body.classList.add('overflow-hidden');
            this.$nextTick(() => {
                // Focus on input and initialize icons
                document.getElementById('email_or_nip')?.focus();
                lucide.createIcons();
            });
        },
        
        close() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
        },
        
        resetForm() {
            this.formData = {
                email_or_nip: ''
            };
            this.message = {
                text: '',
                type: ''
            };
            this.isSubmitting = false;
        },
        
        submitForm() {
            if (!this.formData.email_or_nip) {
                this.showMessage('Silakan masukkan NIP atau email Anda', 'error');
                return;
            }
            
            this.isSubmitting = true;
            this.message.text = '';
            
            // Simulate API call to send password reset link
            setTimeout(() => {
                const email_or_nip = this.formData.email_or_nip;
                
                // Validate format
                const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email_or_nip);
                const isNIP = /^\d{18}$/.test(email_or_nip);
                
                if (!isEmail && !isNIP) {
                    this.isSubmitting = false;
                    this.showMessage('Format tidak valid. Masukkan email yang valid atau NIP 18 digit.', 'error');
                    return;
                }
                
                // For demo purposes, we'll show success message
                this.isSubmitting = false;
                this.showMessage(
                    `Link reset password telah dikirim ke ${isEmail ? 'alamat email' : 'email yang terkait dengan NIP'} ${email_or_nip}. Silahkan periksa kotak masuk email Anda.`, 
                    'success'
                );
                
                // Close modal after 3 seconds
                setTimeout(() => {
                    this.close();
                }, 3000);
                
                /* 
                In a real implementation, you would make an AJAX call like this:
                
                fetch('/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email_or_nip: this.formData.email_or_nip
                    })
                })
                .then(response => response.json())
                .then(data => {
                    this.isSubmitting = false;
                    if (data.status === 'success') {
                        this.showMessage(data.message, 'success');
                        setTimeout(() => this.close(), 3000);
                    } else {
                        this.showMessage(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    this.isSubmitting = false;
                    this.showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    console.error('Error:', error);
                });
                */
            }, 1500);
        },
        
        showMessage(text, type) {
            this.message = { text, type };
            this.$nextTick(() => {
                lucide.createIcons();
            });
        }
    }
}
</script>
