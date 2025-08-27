# Integrating Next.js Frontend with Laravel Backend

This document outlines the steps to integrate a Next.js frontend with your existing Laravel ProPangkat application.

## Architecture Overview

```
┌────────────────┐     HTTP/API     ┌────────────────┐
│                │   Requests       │                │
│    Next.js     │ ───────────────> │    Laravel     │
│    Frontend    │ <───────────────┐│    Backend     │
│                │     JSON Data    │                │
└────────────────┘                  └────────────────┘
```

## Setup Instructions

### 1. Prepare Laravel as an API Backend

1. Create API routes in Laravel:

```php
// routes/api.php
Route::prefix('api')->group(function () {
    // Authentication endpoints
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User data
        Route::get('/user', [UserController::class, 'current']);
        
        // Resources based on roles
        Route::apiResource('/pangkat-applications', PangkatApplicationController::class);
        // Other API endpoints
    });
});
```

2. Install and configure Laravel Sanctum for API authentication:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

3. Configure CORS in `config/cors.php`:

```php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000', 'https://your-frontend-domain.com'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

4. Update your User model:

```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // Rest of your model code
}
```

### 2. Create Next.js Frontend Project

1. Create a new Next.js app in a separate directory:

```bash
npx create-next-app propangkat-frontend
cd propangkat-frontend
```

2. Install necessary dependencies:

```bash
npm install axios @tanstack/react-query tailwindcss postcss autoprefixer lucide-react
npm install -D prettier eslint-config-prettier
```

3. Set up Tailwind CSS:

```bash
npx tailwindcss init -p
```

### 3. Configure Next.js to Communicate with Laravel

1. Create API client in Next.js:

```js
// src/lib/api.js
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  withCredentials: true
});

export default api;
```

2. Create authentication hooks:

```js
// src/hooks/useAuth.js
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import api from '@/lib/api';
import { useRouter } from 'next/router';

export function useAuth() {
  const queryClient = useQueryClient();
  const router = useRouter();
  
  const user = useQuery({
    queryKey: ['user'],
    queryFn: async () => {
      try {
        const { data } = await api.get('/user');
        return data;
      } catch (error) {
        return null;
      }
    }
  });
  
  const login = useMutation({
    mutationFn: async (credentials) => {
      await api.get('/sanctum/csrf-cookie');
      return api.post('/login', credentials);
    },
    onSuccess: () => {
      queryClient.invalidateQueries(['user']);
      router.push('/dashboard');
    }
  });
  
  const logout = useMutation({
    mutationFn: async () => {
      return api.post('/logout');
    },
    onSuccess: () => {
      queryClient.setQueryData(['user'], null);
      router.push('/login');
    }
  });
  
  return {
    user: user.data,
    isLoading: user.isLoading,
    login,
    logout,
  };
}
```

### 4. Create Login Page in Next.js

```jsx
// src/pages/login.js
import { useState } from 'react';
import { useAuth } from '@/hooks/useAuth';
import { Shield, User, Settings, Users } from 'lucide-react';

export default function Login() {
  const { login } = useAuth();
  const [selectedRole, setSelectedRole] = useState(null);
  const [credentials, setCredentials] = useState({
    email: '',
    password: '',
    role: ''
  });
  
  const handleRoleSelect = (role) => {
    setSelectedRole(role);
    setCredentials(prev => ({ ...prev, role }));
  };
  
  const handleSubmit = (e) => {
    e.preventDefault();
    login.mutate(credentials);
  };
  
  return (
    <div className="min-h-screen bg-[#0f172a] flex flex-col justify-center items-center p-4">
      <div className="w-full max-w-4xl">
        <div className="backdrop-blur-md bg-slate-800/80 border border-white/10 rounded-2xl p-8 shadow-xl">
          {/* Header */}
          <div className="text-center mb-8">
            <div className="inline-flex items-center justify-center mb-2">
              <Shield className="w-10 h-10 text-sky-400" />
            </div>
            <h2 className="text-2xl font-bold text-white mb-1">Selamat Datang di ProPangkat</h2>
            <p className="text-white/80">Proses Kenaikan Pangkat Terintegrasi</p>
            <p className="text-sm text-white/70 mt-1">Badan Kepegawaian Daerah Kalimantan Timur</p>
          </div>
          
          {!selectedRole ? (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
              {/* Pegawai Card */}
              <div 
                onClick={() => handleRoleSelect('pegawai')}
                className="p-6 rounded-xl bg-[#1e293b]/80 border border-white/10 cursor-pointer backdrop-blur-sm flex flex-col items-center justify-center transition-all hover:bg-[#1e293b] hover:border-sky-500/30 hover:shadow-lg hover:shadow-sky-500/10"
              >
                <div className="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center mb-4">
                  <User className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-medium text-white mb-2">Pegawai</h3>
                <p className="text-sm text-white/70 text-center">Login untuk pegawai yang akan mengajukan kenaikan pangkat</p>
                
                <button className="mt-4 w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all">
                  Masuk sebagai Pegawai
                </button>
              </div>
              
              {/* Operator Card */}
              <div 
                onClick={() => handleRoleSelect('operator')}
                className="p-6 rounded-xl bg-[#1e293b]/80 border border-white/10 cursor-pointer backdrop-blur-sm flex flex-col items-center justify-center transition-all hover:bg-[#1e293b] hover:border-green-500/30 hover:shadow-lg hover:shadow-green-500/10"
              >
                <div className="w-16 h-16 rounded-full bg-green-600 flex items-center justify-center mb-4">
                  <Users className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-medium text-white mb-2">Operator</h3>
                <p className="text-sm text-white/70 text-center">Login untuk operator yang memverifikasi usulan kenaikan pangkat</p>
                
                <button className="mt-4 w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all">
                  Masuk sebagai Operator
                </button>
              </div>
              
              {/* Admin Card */}
              <div 
                onClick={() => handleRoleSelect('admin')}
                className="p-6 rounded-xl bg-[#1e293b]/80 border border-white/10 cursor-pointer backdrop-blur-sm flex flex-col items-center justify-center transition-all hover:bg-[#1e293b] hover:border-purple-500/30 hover:shadow-lg hover:shadow-purple-500/10"
              >
                <div className="w-16 h-16 rounded-full bg-purple-600 flex items-center justify-center mb-4">
                  <Settings className="w-8 h-8 text-white" />
                </div>
                <h3 className="text-xl font-medium text-white mb-2">Admin</h3>
                <p className="text-sm text-white/70 text-center">Login untuk admin yang mengelola sistem secara keseluruhan</p>
                
                <button className="mt-4 w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-all">
                  Masuk sebagai Admin
                </button>
              </div>
            </div>
          ) : (
            <div>
              <div className="mb-4 flex items-center">
                <button 
                  type="button" 
                  onClick={() => setSelectedRole(null)} 
                  className="mr-2 p-1 rounded-full bg-white/10 hover:bg-white/20"
                >
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="m15 18-6-6 6-6" />
                  </svg>
                </button>
                <h3 className="text-lg font-medium text-white">
                  Login sebagai {selectedRole === 'admin' ? 'Admin' : selectedRole === 'operator' ? 'Operator' : 'Pegawai'}
                </h3>
              </div>
              
              <form onSubmit={handleSubmit}>
                <div className="mb-4">
                  <div className="relative">
                    <span className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/50">
                      <User className="w-5 h-5" />
                    </span>
                    <input
                      type="text"
                      value={credentials.email}
                      onChange={(e) => setCredentials({...credentials, email: e.target.value})}
                      className="block w-full pl-10 py-3 bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50 rounded-lg"
                      placeholder="Masukkan NIP/Username"
                      required
                    />
                  </div>
                </div>
                
                <div className="mb-6">
                  <div className="relative">
                    <span className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/50">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                      </svg>
                    </span>
                    <input
                      type="password"
                      value={credentials.password}
                      onChange={(e) => setCredentials({...credentials, password: e.target.value})}
                      className="block w-full pl-10 py-3 bg-white/10 border-white/20 text-white placeholder-white/50 focus:border-white/50 focus:ring-white/50 rounded-lg"
                      placeholder="Masukkan Password"
                      required
                    />
                  </div>
                </div>
                
                <button 
                  type="submit"
                  className={`w-full py-3 px-4 flex justify-center items-center gap-2 text-white font-medium rounded-lg transition-all duration-200 
                    ${selectedRole === 'admin' ? 'bg-purple-600 hover:bg-purple-700' : 
                      selectedRole === 'operator' ? 'bg-green-600 hover:bg-green-700' : 
                      'bg-blue-600 hover:bg-blue-700'}`}
                >
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"></path>
                  </svg>
                  Masuk
                </button>
              </form>
            </div>
          )}
          
          <div className="mt-6 bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
            <p className="text-white text-center text-sm">
              <span className="font-semibold">Informasi:</span> Gunakan NIP 18 digit dan password yang telah diberikan untuk login. Jika mengalami kesulitan, hubungi administrator sistem.
            </p>
          </div>
        </div>
      </div>
      
      <footer className="mt-4 w-full text-center">
        <p className="text-gray-400 text-xs font-medium">
          © 2025 Badan Kepegawaian Daerah Kalimantan Timur
        </p>
      </footer>
    </div>
  );
}
```

### 5. Create Dashboard Layout

Create reusable dashboard layout components that change based on user role, similar to what you have in your Laravel views.

### 6. Deployment Options

1. **Separate Deployments**:
   - Laravel backend on a PHP server (shared hosting, VPS, etc.)
   - Next.js frontend on Vercel, Netlify, or similar platform

2. **Combined Deployment**:
   - You can also build the Next.js app and have Laravel serve the static files
   - For this approach, you'd need to build the Next.js app and copy the output to Laravel's public directory

## Benefits of This Architecture

1. **Better Developer Experience**:
   - Use modern JavaScript tools and frameworks
   - TypeScript support for better type safety
   - Component-based UI development

2. **Performance**:
   - Server-side rendering (SSR) or static site generation (SSG) with Next.js
   - Faster page loads with automatic code splitting
   - API-driven approach reduces server load

3. **User Experience**:
   - SPA (Single Page Application) experience
   - No full page reloads
   - Smoother transitions between pages

4. **Maintainability**:
   - Clear separation of concerns
   - Backend focused on business logic and data
   - Frontend focused on presentation and UI/UX
