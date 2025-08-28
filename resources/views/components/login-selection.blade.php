@props(['class' => ''])

<div x-data="loginSelection()" {{ $attributes->merge(['class' => 'bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-[30px] p-8 shadow-2xl border border-white/20 dark:border-gray-700/20 w-full max-w-4xl mx-auto ' . $class]) }}>
    <!-- Header -->
    <div class="text-center mb-8">
        <div x-show="true" 
             x-transition:enter="transition ease-out duration-500 delay-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="flex items-center justify-center mb-4">
            <i data-lucide="shield-check" class="h-8 w-8 text-sky-500 dark:text-sky-400 mr-3"></i>
            <span class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Selamat Datang di</span>
        </div>

        <h1 x-show="true"
            x-transition:enter="transition ease-out duration-500 delay-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="text-5xl font-extrabold bg-gradient-to-r from-sky-500 to-teal-500 dark:from-sky-400 dark:to-teal-400 bg-clip-text text-transparent mb-4">
            ProPangkat
        </h1>

        <div x-show="true"
             x-transition:enter="transition ease-out duration-500 delay-400"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="space-y-2">
            <p class="text-xl font-semibold text-gray-800 dark:text-gray-200">Proses Kenaikan Pangkat Terintegrasi</p>
            <p class="text-gray-500 dark:text-gray-400">Dinas Pendidikan dan Kebudayaan Prov. Kaltim Kalimantan Timur</p>
        </div>
    </div>

    <!-- User Type Selection -->
    <div class="space-y-6">
        <!-- Baris pertama: Pegawai dan Operator -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Pegawai Card -->
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-500 delay-500"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 @mouseenter="$el.style.transform = 'scale(1.02)'"
                 @mouseleave="$el.style.transform = 'scale(1)'"
                 class="transition-all duration-300 hover:shadow-xl">
                <x-ui.card class="h-full border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                    <x-ui.card-header class="text-center pb-4">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                            <i data-lucide="user" class="h-10 w-10 text-white"></i>
                        </div>
                        <x-ui.card-title class="text-xl font-bold text-gray-900 dark:text-gray-100">Pegawai</x-ui.card-title>
                        <x-ui.card-description class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed px-2">
                            Login untuk pegawai yang akan mengajukan kenaikan pangkat
                        </x-ui.card-description>
                    </x-ui.card-header>
                    <x-ui.card-content class="pt-0">
                        <a href="{{ route('login', ['role' => 'pegawai']) }}">
                            <x-ui.button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:opacity-90 text-white font-semibold py-3 rounded-full transition-all duration-300">
                                Masuk sebagai Pegawai
                            </x-ui.button>
                        </a>
                    </x-ui.card-content>
                </x-ui.card>
            </div>

            <!-- Operator Card -->
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-500 delay-600"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 @mouseenter="$el.style.transform = 'scale(1.02)'"
                 @mouseleave="$el.style.transform = 'scale(1)'"
                 class="transition-all duration-300 hover:shadow-xl">
                <x-ui.card class="h-full border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                    <x-ui.card-header class="text-center pb-4">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                            <i data-lucide="check-circle" class="h-10 w-10 text-white"></i>
                        </div>
                        <x-ui.card-title class="text-xl font-bold text-gray-900 dark:text-gray-100">Operator</x-ui.card-title>
                        <x-ui.card-description class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed px-2">
                            Login untuk operator yang memverifikasi usulan kenaikan pangkat
                        </x-ui.card-description>
                    </x-ui.card-header>
                    <x-ui.card-content class="pt-0">
                        <a href="{{ route('login', ['role' => 'operator']) }}">
                            <x-ui.button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:opacity-90 text-white font-semibold py-3 rounded-full transition-all duration-300">
                                Masuk sebagai Operator
                            </x-ui.button>
                        </a>
                    </x-ui.card-content>
                </x-ui.card>
            </div>
        </div>

        <!-- Baris kedua: Operator Sekolah dan Admin -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Operator Sekolah Card -->
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-500 delay-700"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 @mouseenter="$el.style.transform = 'scale(1.02)'"
                 @mouseleave="$el.style.transform = 'scale(1)'"
                 class="transition-all duration-300 hover:shadow-xl">
                <x-ui.card class="h-full border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                    <x-ui.card-header class="text-center pb-4">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center">
                            <i data-lucide="school" class="h-10 w-10 text-white"></i>
                        </div>
                        <x-ui.card-title class="text-xl font-bold text-gray-900 dark:text-gray-100">Operator Sekolah</x-ui.card-title>
                        <x-ui.card-description class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed px-2">
                            Login untuk operator sekolah yang mengelola usulan di unit kerja
                        </x-ui.card-description>
                    </x-ui.card-header>
                    <x-ui.card-content class="pt-0">
                        <a href="{{ route('login', ['role' => 'operator-sekolah']) }}">
                            <x-ui.button class="w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:opacity-90 text-white font-semibold py-3 rounded-full transition-all duration-300">
                                Masuk sebagai Operator Sekolah
                            </x-ui.button>
                        </a>
                    </x-ui.card-content>
                </x-ui.card>
            </div>

            <!-- Admin Card -->
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-500 delay-800"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 @mouseenter="$el.style.transform = 'scale(1.02)'"
                 @mouseleave="$el.style.transform = 'scale(1)'"
                 class="transition-all duration-300 hover:shadow-xl">
                <x-ui.card class="h-full border-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
                    <x-ui.card-header class="text-center pb-4">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center">
                            <i data-lucide="settings" class="h-10 w-10 text-white"></i>
                        </div>
                        <x-ui.card-title class="text-xl font-bold text-gray-900 dark:text-gray-100">Admin</x-ui.card-title>
                        <x-ui.card-description class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed px-2">
                            Login untuk admin yang mengelola sistem secara keseluruhan
                        </x-ui.card-description>
                    </x-ui.card-header>
                    <x-ui.card-content class="pt-0">
                        <a href="{{ route('login', ['role' => 'admin']) }}">
                            <x-ui.button class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:opacity-90 text-white font-semibold py-3 rounded-full transition-all duration-300">
                                Masuk sebagai Admin
                            </x-ui.button>
                        </a>
                    </x-ui.card-content>
                </x-ui.card>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div x-show="true"
         x-transition:enter="transition ease-out duration-500 delay-800"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="mt-8 p-4 bg-sky-50 dark:bg-gray-800 rounded-xl border border-sky-200 dark:border-gray-700">
        <p class="text-sm text-sky-700 dark:text-sky-300 text-center">
            <strong>Informasi:</strong> Gunakan NIP 18 digit dan password yang telah diberikan untuk login. Jika mengalami kesulitan, hubungi administrator sistem.
        </p>
    </div>
</div>

<script>
function loginSelection() {
    return {
        // You can add any component state here
    }
}
</script>
