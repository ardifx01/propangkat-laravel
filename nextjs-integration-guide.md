## Using Next.js with Laravel for ProPangkat

This guide will help you set up a Next.js frontend that works with your existing Laravel backend for the ProPangkat application.

### Step 1: Install Laravel Sanctum

First, we need to set up Laravel Sanctum to handle API authentication:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Step 2: Update User Model

Update the User model to use Sanctum tokens:

```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // Rest of your model
}
```

### Step 3: Create Next.js Frontend

Create a new Next.js project outside your Laravel folder:

```bash
# Navigate to a parent directory
cd ..
# Create a new Next.js project
npx create-next-app propangkat-frontend
cd propangkat-frontend
```

### Step 4: Install Required Dependencies

```bash
npm install axios @tanstack/react-query tailwindcss postcss autoprefixer
```

### Step 5: Set Up API Communication

Create an API client file in your Next.js project:

```jsx
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

### Step 6: Create Authentication Context

```jsx
// src/context/AuthContext.js
import React, { createContext, useState, useEffect, useContext } from 'react';
import api from '@/lib/api';
import { useRouter } from 'next/router';

const AuthContext = createContext();

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const router = useRouter();

  useEffect(() => {
    // Check if user is authenticated
    async function loadUserFromToken() {
      try {
        const token = localStorage.getItem('token');
        if (token) {
          api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          const { data } = await api.get('/user');
          setUser(data.data);
        }
      } catch (error) {
        localStorage.removeItem('token');
        api.defaults.headers.common['Authorization'] = '';
      } finally {
        setLoading(false);
      }
    }
    
    loadUserFromToken();
  }, []);

  const login = async (credentials) => {
    try {
      const response = await api.post('/login', credentials);
      const { token, user } = response.data;
      
      localStorage.setItem('token', token);
      api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      setUser(user);
      
      return { success: true };
    } catch (error) {
      return { 
        success: false, 
        message: error.response?.data?.message || 'Login failed'
      };
    }
  };

  const logout = async () => {
    try {
      await api.post('/logout');
    } finally {
      localStorage.removeItem('token');
      api.defaults.headers.common['Authorization'] = '';
      setUser(null);
      router.push('/login');
    }
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  return useContext(AuthContext);
}
```

### Step 7: Create Login Page

```jsx
// src/pages/login.js
import { useState } from 'react';
import { useAuth } from '@/context/AuthContext';
import { useRouter } from 'next/router';

export default function Login() {
  const router = useRouter();
  const { login } = useAuth();
  const [selectedRole, setSelectedRole] = useState(null);
  const [credentials, setCredentials] = useState({
    email: '',
    password: '',
    role: ''
  });
  const [error, setError] = useState('');
  
  const handleRoleSelect = (role) => {
    setSelectedRole(role);
    setCredentials(prev => ({ ...prev, role }));
  };
  
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    
    const result = await login(credentials);
    if (result.success) {
      router.push('/dashboard');
    } else {
      setError(result.message);
    }
  };
  
  return (
    // Login UI - Similar to what you have in Laravel views
  );
}
```

### Step 8: Create Protected Routes

```jsx
// src/components/ProtectedRoute.js
import { useAuth } from '@/context/AuthContext';
import { useRouter } from 'next/router';
import { useEffect } from 'react';

export default function ProtectedRoute({ children, allowedRoles = [] }) {
  const { user, loading } = useAuth();
  const router = useRouter();
  
  useEffect(() => {
    if (!loading && !user) {
      router.replace('/login');
    } else if (!loading && user && allowedRoles.length > 0) {
      if (!allowedRoles.includes(user.role)) {
        router.replace('/unauthorized');
      }
    }
  }, [user, loading, router, allowedRoles]);
  
  if (loading) {
    return <div>Loading...</div>;
  }
  
  if (!user) {
    return null;
  }
  
  if (allowedRoles.length > 0 && !allowedRoles.includes(user.role)) {
    return null;
  }
  
  return children;
}
```

### Step 9: Set Up Dashboard Page

```jsx
// src/pages/dashboard.js
import { useAuth } from '@/context/AuthContext';
import ProtectedRoute from '@/components/ProtectedRoute';
import AdminDashboard from '@/components/dashboards/AdminDashboard';
import OperatorDashboard from '@/components/dashboards/OperatorDashboard';
import PegawaiDashboard from '@/components/dashboards/PegawaiDashboard';

export default function Dashboard() {
  const { user } = useAuth();
  
  return (
    <ProtectedRoute>
      <div>
        {user?.role === 'admin' && <AdminDashboard />}
        {user?.role === 'operator' && <OperatorDashboard />}
        {user?.role === 'pegawai' && <PegawaiDashboard />}
      </div>
    </ProtectedRoute>
  );
}
```

### Step 10: Update CORS in Laravel

```php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

### Step 11: Build and Deploy

1. For development, run both servers:
   - Laravel: `php artisan serve`
   - Next.js: `npm run dev`

2. For production:
   - Build Next.js: `npm run build`
   - Deploy Laravel backend to your PHP server
   - Deploy Next.js frontend to Vercel, Netlify, or your hosting provider

### Seamless Integration Tips

1. Use environment variables to configure API URLs
2. Keep your API and frontend in sync with proper documentation
3. Consider using TypeScript for better type safety
4. Implement proper error handling on both sides
