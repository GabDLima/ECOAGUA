import React, { useEffect } from 'react';
import { AuthProvider } from './src/contexts/AuthContext';
import { ThemeProvider } from './src/theme/ThemeContext';
import AppNavigator from './src/navigation/AppNavigator';
import { setupNotifications } from './src/services/NotificationService';

export default function App() {
  useEffect(() => {
    setupNotifications();
  }, []);

  return (
    <AuthProvider>
      <ThemeProvider>
        <AppNavigator />
      </ThemeProvider>
    </AuthProvider>
  );
}
