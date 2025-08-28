@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/kaltim-logo.svg') }}" alt="Kalimantan Timur Logo" width="48" height="48" class="rounded-lg">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">ProPangkat</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sistem Kenaikan Pangkat</p>
                </div>
            </div>

            <!-- User Profile & Actions -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode" 
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <i data-lucide="sun" x-show="!darkMode" class="w-5 h-5 text-yellow-500"></i>
                    <i data-lucide="moon" x-show="darkMode" class="w-5 h-5 text-blue-400"></i>
                </button>

                <!-- User Info -->
                <div class="flex items-center space-x-3 bg-gray-50 dark:bg-gray-700 rounded-full px-4 py-2">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->username ?? 'NIP tidak tersedia' }} • {{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <x-ui.button type="submit" variant="outline" size="sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </x-ui.button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-6">
        <!-- Welcome Section -->
        <div class="mb-6 animate-fade-in-up">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Dashboard Kenaikan Pangkat periode {{ date('F Y') }}
            </p>

            <!-- Success Alert -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800 dark:text-green-200 font-medium">
                            Selamat! Anda dapat mengajukan Kenaikan Pangkat periode {{ date('F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-ui.card class="stat-card overflow-hidden">
                <div class="bg-blue-500 h-32 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">156</div>
                        <div class="text-sm opacity-90">Total Usulan</div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="stat-card overflow-hidden">
                <div class="bg-green-500 h-32 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">89</div>
                        <div class="text-sm opacity-90">Disetujui</div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="stat-card overflow-hidden">
                <div class="bg-yellow-500 h-32 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">45</div>
                        <div class="text-sm opacity-90">Pending</div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card class="stat-card overflow-hidden">
                <div class="bg-red-500 h-32 flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">22</div>
                        <div class="text-sm opacity-90">Ditolak</div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Content Areas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activities -->
            <x-ui.card>
                <x-ui.card-header>
                    <x-ui.card-title>Aktivitas Terbaru</x-ui.card-title>
                </x-ui.card-header>
                <x-ui.card-content>
                    <div class="space-y-4">
                        @for ($i = 1; $i <= 5; $i++)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">{{ chr(64 + $i) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Aktivitas {{ $i }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    Deskripsi aktivitas yang telah dilakukan
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    {{ $i }} jam yang lalu
                                </p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </x-ui.card-content>
            </x-ui.card>

            <!-- Notifications -->
            <x-ui.card>
                <x-ui.card-header>
                    <x-ui.card-title>Jadwal & Notifikasi</x-ui.card-title>
                </x-ui.card-header>
                <x-ui.card-content>
                    <div class="space-y-4">
                        @for ($i = 1; $i <= 3; $i++)
                        <div class="relative pl-6 pb-4 border-l border-gray-300 dark:border-gray-600">
                            <div class="absolute -left-1.5 mt-1.5 h-3 w-3 rounded-full border border-background bg-gray-400 dark:bg-gray-500"></div>
                            <h4 class="text-sm font-semibold">Jadwal {{ $i }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                Deskripsi jadwal atau notifikasi penting
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ date('d M Y', strtotime("+{$i} days")) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                    Penting
                                </span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </x-ui.card-content>
            </x-ui.card>
        </div>

        <!-- Bottom Content Area -->
        <div class="mt-6">
            <x-ui.card>
                <x-ui.card-content class="p-6 h-64 flex items-center justify-center">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <div class="text-lg font-medium mb-2">Area Konten Tambahan</div>
                        <p class="text-sm">Area untuk menampilkan informasi dan fitur tambahan</p>
                        <div class="mt-4">
                            <x-ui.button href="{{ route('dashboard') }}" variant="outline">
                                Lihat Selengkapnya
                            </x-ui.button>
                        </div>
                    </div>
                </x-ui.card-content>
            </x-ui.card>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh notification example
    function showNotification(message, type = 'info') {
        window.dispatchEvent(new CustomEvent('notify', {
            detail: { message, type }
        }));
    }

    // Example: Show welcome notification
    setTimeout(() => {
        showNotification('Selamat datang di ProPangkat! 🎉', 'success');
    }, 1000);
</script>
@endpush
