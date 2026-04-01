import React, { createContext, useContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { colors } from './theme';

interface ThemeContextValue {
  isDark: boolean;
  setDarkMode: (val: boolean) => Promise<void>;
  bg: string;
  cardBg: string;
  textPrimary: string;
  textSecondary: string;
  borderColor: string;
}

const ThemeContext = createContext<ThemeContextValue>({
  isDark: false,
  setDarkMode: async () => {},
  bg: colors.background,
  cardBg: colors.white,
  textPrimary: colors.slate[800],
  textSecondary: colors.slate[500],
  borderColor: colors.slate[200],
});

export function ThemeProvider({ children }: { children: React.ReactNode }) {
  const [isDark, setIsDark] = useState(false);

  useEffect(() => {
    AsyncStorage.getItem('@ecoagua:dark_mode').then(val => {
      if (val === '1') setIsDark(true);
    });
  }, []);

  const setDarkMode = async (val: boolean) => {
    setIsDark(val);
    await AsyncStorage.setItem('@ecoagua:dark_mode', val ? '1' : '0');
  };

  return (
    <ThemeContext.Provider
      value={{
        isDark,
        setDarkMode,
        bg:            isDark ? '#0f172a' : colors.background,
        cardBg:        isDark ? '#1e293b' : colors.white,
        textPrimary:   isDark ? '#f8fafc' : colors.slate[800],
        textSecondary: isDark ? '#94a3b8' : colors.slate[500],
        borderColor:   isDark ? '#334155' : colors.slate[200],
      }}
    >
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme() {
  return useContext(ThemeContext);
}
