import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

const DEV_URL = 'http://192.168.0.103:8000';
const PROD_URL = 'http://10.0.2.2:8000';

const api = axios.create({
  baseURL: __DEV__ ? DEV_URL : PROD_URL,
  timeout: 10000,
  headers: { 'Content-Type': 'application/json' },
});

api.interceptors.request.use(async (config) => {
  const token = await AsyncStorage.getItem('token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

api.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      await AsyncStorage.removeItem('token');
      await AsyncStorage.removeItem('usuario');
    }
    return Promise.reject(error);
  }
);

export default api;
