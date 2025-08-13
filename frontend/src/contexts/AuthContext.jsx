import React, { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [token, setToken] = useState(localStorage.getItem('token'));
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Sprawdź czy token istnieje i jest ważny
    if (token) {
      validateToken();
    } else {
      setLoading(false);
    }
  }, []);

  const validateToken = async () => {
    try {
      // TODO: Implement token validation with backend
      // const response = await fetch('/api/validate-token', {
      //   headers: { 'Authorization': `Bearer ${token}` }
      // });
      // if (response.ok) {
      //   const userData = await response.json();
      //   setUser(userData);
      // } else {
      //   logout();
      // }
      setLoading(false);
    } catch (error) {
      console.error('Token validation error:', error);
      logout();
    }
  };

  const login = async (email, password) => {
    try {
      const response = await fetch('http://localhost/weddingassistant/backend/api/auth.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'login',
          email,
          password,
        }),
      });

      const data = await response.json();

      if (data.success) {
        setUser(data.user);
        setToken(data.token);
        localStorage.setItem('token', data.token);
        return { success: true };
      } else {
        return { success: false, error: data.error || 'Błąd logowania' };
      }
    } catch (error) {
      console.error('Login error:', error);
      return { success: false, error: 'Błąd połączenia z serwerem' };
    }
  };

  const register = async (email, password, firstName, lastName) => {
    try {
      const response = await fetch('http://localhost/weddingassistant/backend/api/auth.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'register',
          email,
          password,
          firstName,
          lastName,
        }),
      });

      const data = await response.json();

      if (data.success) {
        return { success: true };
      } else {
        return { success: false, error: data.error || 'Błąd rejestracji' };
      }
    } catch (error) {
      console.error('Register error:', error);
      return { success: false, error: 'Błąd połączenia z serwerem' };
    }
  };

  const logout = () => {
    setUser(null);
    setToken(null);
    localStorage.removeItem('token');
  };

  const value = {
    user,
    token,
    loading,
    login,
    register,
    logout,
    isAuthenticated: !!user,
  };

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
};
