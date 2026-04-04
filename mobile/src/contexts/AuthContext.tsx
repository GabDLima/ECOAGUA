import React, { createContext, useContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import api, { setUnauthorizedCallback } from '../api/api';

interface Usuario {
  id: number;
  nome: string;
  email: string;
}

interface AuthContextData {
  usuario: Usuario | null;
  token: string | null;
  loading: boolean;
  login: (email: string, senha: string) => Promise<void>;
  logout: () => Promise<void>;
}

const AuthContext = createContext<AuthContextData>({} as AuthContextData);

export const AuthProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [usuario, setUsuario] = useState<Usuario | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setUnauthorizedCallback(() => {
      setToken(null);
      setUsuario(null);
    });

    async function loadStorage() {
      try {
        const storedToken = await AsyncStorage.getItem('token');
        const storedUsuario = await AsyncStorage.getItem('usuario');
        if (storedToken && storedUsuario) {
          setToken(storedToken);
          setUsuario(JSON.parse(storedUsuario));
        }
      } catch {
        await AsyncStorage.removeItem('token');
        await AsyncStorage.removeItem('usuario');
      } finally {
        setLoading(false);
      }
    }
    loadStorage();
  }, []);

  async function login(email: string, senha: string) {
    const response = await api.post('/api/auth/login', { email, senha });
    if (!response.data.success) {
      throw new Error(response.data.message || 'Credenciais inválidas.');
    }
    const { token: newToken, usuario: newUsuario } = response.data;
    await AsyncStorage.setItem('token', newToken);
    await AsyncStorage.setItem('usuario', JSON.stringify(newUsuario));
    setToken(newToken);
    setUsuario(newUsuario);
  }

  async function logout() {
    await AsyncStorage.removeItem('token');
    await AsyncStorage.removeItem('usuario');
    setToken(null);
    setUsuario(null);
  }

  return (
    <AuthContext.Provider value={{ usuario, token, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
