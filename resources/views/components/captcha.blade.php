@props(['id' => 'captcha'])

<div x-data="captchaComponent()" 
     class="captcha-component">
    
    <!-- Captcha Label -->
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        <i data-lucide="shield" class="w-4 h-4 inline-block mr-1 opacity-70"></i>
        Kode Verifikasi
    </label>
    
    <!-- Simple Captcha -->
    <div class="space-y-2">
        <!-- Captcha Display -->
        <div class="flex items-center">
            <div class="relative flex-1">
                <div class="select-none text-center py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="captcha-text tracking-wide font-mono flex items-center justify-center" x-ref="captchaDisplay"></div>
                </div>
            </div>
            
            <!-- Refresh Button -->
            <button 
                type="button" 
                @click="refreshCaptcha"
                class="ml-2 p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                title="Refresh Captcha">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
            </button>
        </div>
        
        <!-- Captcha Input -->
        <div class="relative">
            <input 
                type="text" 
                id="{{ $id }}" 
                name="captcha"
                x-model="userInput"
                @input="validateCaptcha"
                class="block w-full rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 text-center tracking-wide font-mono"
                :class="{'border-green-300': validation.valid && validation.status, 'border-red-300': !validation.valid && validation.status}"
                placeholder="Masukkan kode di atas"
                autocomplete="off"
                maxlength="6"
                required
            >
        </div>
        
        <!-- Status Message -->
        <div 
            x-show="validation.status" 
            x-text="validation.message"
            :class="{'text-green-600 dark:text-green-400': validation.valid, 'text-red-600 dark:text-red-400': !validation.valid}"
            class="text-xs font-medium text-center"
        ></div>
        
        <input type="hidden" name="captchaCode" x-model="captchaCode">
    </div>
</div>

@push('scripts')
<script>
function captchaComponent() {
    return {
        captchaCode: '',
        userInput: '',
        validation: {
            status: false,
            message: '',
            valid: false
        },
        
        init() {
            this.generateCaptcha();
            this.$nextTick(() => {
                this.applyCaptchaStyling();
            });
        },
        
        generateCaptcha() {
            // Mix of uppercase, lowercase letters and numbers (simplified for readability)
            // Exclude confusing characters like 0, O, I, l, 1
            const uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
            const lowercase = 'abcdefghijkmnpqrstuvwxyz';
            const numbers = '23456789';
            
            // Ensure at least one character from each set
            let result = '';
            result += uppercase.charAt(Math.floor(Math.random() * uppercase.length));
            result += lowercase.charAt(Math.floor(Math.random() * lowercase.length));
            result += numbers.charAt(Math.floor(Math.random() * numbers.length));
            
            // Add three more random characters from all sets
            const allChars = uppercase + lowercase + numbers;
            for (let i = 0; i < 3; i++) {
                result += allChars.charAt(Math.floor(Math.random() * allChars.length));
            }
            
            // Shuffle the result
            result = result.split('').sort(() => 0.5 - Math.random()).join('');
            
            this.captchaCode = result;
            this.$nextTick(() => {
                this.applyCaptchaStyling();
            });
        },
        
        applyCaptchaStyling() {
            const text = this.$refs.captchaDisplay;
            if (!text) return;
            
            // Clear existing styling
            text.innerHTML = '';
            
            // Create a single element with fixed styling for better readability
            text.style.fontSize = '20px';
            text.style.fontWeight = '600';
            text.style.letterSpacing = '3px';
            text.style.fontFamily = 'monospace';
            text.innerText = this.captchaCode;
            
            // Add simple background styling
            text.parentElement.style.background = 'linear-gradient(to right, #f0f9ff, #e0f2fe)';
            text.parentElement.classList.add('dark:bg-gray-800');
            text.parentElement.classList.add('dark:border-gray-700');
        },
        
        refreshCaptcha() {
            this.generateCaptcha();
            this.userInput = '';
            this.validation.status = false;
        },
        
        validateCaptcha() {
            if (this.userInput.length > 0) {
                this.validation.status = true;
                if (this.userInput === this.captchaCode) {
                    this.validation.valid = true;
                    this.validation.message = 'Kode verifikasi valid';
                } else {
                    this.validation.valid = false;
                    this.validation.message = 'Kode verifikasi tidak valid';
                }
            } else {
                this.validation.status = false;
            }
        }
    }
}
</script>
@endpush
