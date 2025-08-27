@props(['id' => 'forgotPasswordModal'])

<div id="{{ $id }}" 
     x-data="forgotPasswordModal()"
     x-show="isOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-90"
     class="fixed inset-0 z-50 flex items-center justify-center"
     x-cloak>
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="close"></div>
    
    <!-- Modal Content -->
    <div class="w-full max-w-md relative bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-2xl border border-white/30 dark:border-gray-700/30 p-6 mx-4">
        <!-- Close Button -->
        <button @click="close" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        
        <!-- Modal Header -->
        <div class="mb-6">
            <div class="flex items-center justify-center mb-3">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <i data-lucide="mail" class="w-6 h-6 text-blue-500 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 text-center">Reset Password</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm text-center mt-1">
                Masukkan NIP atau email Anda untuk menerima tautan reset password
            </p>
        </div>
        
        <!-- Form -->
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="email_or_nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIP / Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </span>
                    <input 
                        type="text" 
                        id="email_or_nip" 
                        x-model="formData.email_or_nip"
                        class="block w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan NIP atau email Anda"
                        required
                    >
                </div>
            </div>
            
            <div x-show="message.text" 
                 :class="{'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200': message.type === 'success', 
                          'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200': message.type === 'error'}"
                 class="p-3 rounded-lg mb-4 text-sm">
                <p x-text="message.text"></p>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    @click="close"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Batal
                </button>
                <button 
                    type="submit"
                    :disabled="isSubmitting"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50">
                    <span x-show="!isSubmitting">Kirim Link Reset</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
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
            setTimeout(() => {
                document.getElementById('email_or_nip')?.focus();
            }, 100);
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
            this.isSubmitting = true;
            this.message.text = '';
            
            // Simulate API call to send password reset link
            setTimeout(() => {
                // This would be replaced with an actual fetch/axios call to your backend
                const email_or_nip = this.formData.email_or_nip;
                
                // For demo purposes, we'll just show success message
                this.isSubmitting = false;
                this.message = {
                    text: `Link reset password telah dikirim ke alamat email yang terkait dengan ${email_or_nip}. Silahkan periksa kotak masuk email Anda.`,
                    type: 'success'
                };
                
                // In a real app, you'd make an AJAX call:
                /*
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
                        this.message = {
                            text: data.message,
                            type: 'success'
                        };
                    } else {
                        this.message = {
                            text: data.message || 'An error occurred',
                            type: 'error'
                        };
                    }
                })
                .catch(error => {
                    this.isSubmitting = false;
                    this.message = {
                        text: 'An error occurred. Please try again.',
                        type: 'error'
                    };
                    console.error('Error:', error);
                });
                */
            }, 1500);
        }
    }
}
</script>
