@props(['id' => 'captcha', 'class' => ''])

<div x-data="captchaComponent()" {{ $attributes->merge(['class' => $class]) }}>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
            <i data-lucide="shield-check" class="w-5 h-5"></i>
        </div>
        <input 
            type="text" 
            id="{{ $id }}" 
            name="captcha" 
            class="block w-full pl-10 bg-white/10 dark:bg-gray-700/20 border-white/20 dark:border-gray-600/30 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50 rounded-lg shadow-sm"
            placeholder="Masukkan kode captcha"
            required
            x-model="userInput"
            @input="validateCaptcha"
        />
        <button 
            type="button" 
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-white/70 hover:text-white"
            @click="refreshCaptcha"
        >
            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
        </button>
    </div>
    
    <div class="mt-2">
        <div class="flex items-center justify-center">
            <div class="bg-white/20 dark:bg-gray-700/20 border border-white/30 dark:border-gray-600/30 rounded-md p-3 flex items-center justify-center w-full">
                <div class="select-none tracking-[.25em] captcha-text text-white font-bold text-xl" x-text="captchaCode" x-ref="captchaDisplay"></div>
            </div>
        </div>
        <div 
            x-show="validation.status" 
            x-text="validation.message"
            :class="{'text-green-300': validation.valid, 'text-red-300': !validation.valid}"
            class="text-sm mt-1"
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
            const characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            let result = '';
            const length = 6;
            
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            
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
            
            // Apply distortion to each character
            Array.from(this.captchaCode).forEach(char => {
                const span = document.createElement('span');
                span.textContent = char;
                span.style.display = 'inline-block';
                span.style.transform = `rotate(${Math.random() * 20 - 10}deg) translateY(${Math.random() * 6 - 3}px)`;
                span.style.opacity = Math.random() * 0.5 + 0.5;
                span.style.textShadow = `0 0 ${Math.random() * 5}px rgba(255,255,255,0.7)`;
                text.appendChild(span);
            });
            
            // Add some noise
            for (let i = 0; i < 10; i++) {
                const dot = document.createElement('span');
                dot.textContent = '.';
                dot.style.position = 'absolute';
                dot.style.color = 'rgba(255,255,255,0.4)';
                dot.style.top = `${Math.random() * 100}%`;
                dot.style.left = `${Math.random() * 100}%`;
                text.appendChild(dot);
            }
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
                    this.validation.message = 'Captcha valid';
                } else {
                    this.validation.valid = false;
                    this.validation.message = 'Captcha tidak valid';
                }
            } else {
                this.validation.status = false;
            }
        }
    }
}
</script>
@endpush
