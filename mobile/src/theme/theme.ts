import { Platform } from 'react-native';

// ─── CORES ───────────────────────────────────────────────────────────────────

export const colors = {
  // Primárias (navbar, botões, links)
  primary: {
    900: '#1e3a8a',
    800: '#1e40af',
    700: '#2563eb',
    600: '#3b82f6',
    500: '#60a5fa',
    100: '#dbeafe',
    50:  '#eff6ff',
  },

  // Sucesso
  success: {
    700: '#059669',
    600: '#10b981',
    500: '#34d399',
    100: '#d1fae5',
    50:  '#ecfdf5',
  },

  // Perigo
  danger: {
    700: '#dc2626',
    600: '#ef4444',
    500: '#f87171',
    100: '#fee2e2',
    50:  '#fef2f2',
  },

  // Alerta
  warning: {
    700: '#d97706',
    600: '#f59e0b',
    500: '#fbbf24',
    100: '#fef3c7',
    50:  '#fffbeb',
  },

  // Neutros
  slate: {
    900: '#0f172a',
    800: '#1e293b',
    700: '#334155',
    500: '#64748b',
    400: '#94a3b8',
    300: '#cbd5e1',
    200: '#e2e8f0',
    100: '#f1f5f9',
    50:  '#f8fafc',
  },

  // Fundos
  background: '#f0f4f8',
  white: '#ffffff',

  // Ícones KPI redondos
  kpiGreen:  { bg: '#d1fae5', icon: '#059669' },
  kpiBlue:   { bg: '#dbeafe', icon: '#2563eb' },
  kpiCyan:   { bg: '#cffafe', icon: '#0891b2' },
  kpiAmber:  { bg: '#fef3c7', icon: '#d97706' },
  kpiRed:    { bg: '#fee2e2', icon: '#dc2626' },
  kpiPurple: { bg: '#ede9fe', icon: '#7c3aed' },
};

// ─── TIPOGRAFIA ──────────────────────────────────────────────────────────────

export const typography = {
  fontFamily: {
    regular:   Platform.select({ ios: 'System', android: 'Roboto' }) as string,
    medium:    Platform.select({ ios: 'System', android: 'Roboto' }) as string,
    semiBold:  Platform.select({ ios: 'System', android: 'Roboto' }) as string,
    bold:      Platform.select({ ios: 'System', android: 'Roboto' }) as string,
    extraBold: Platform.select({ ios: 'System', android: 'Roboto' }) as string,
    // Quando Inter estiver instalada, troque para:
    // regular:   'Inter-Regular',
    // medium:    'Inter-Medium',
    // semiBold:  'Inter-SemiBold',
    // bold:      'Inter-Bold',
    // extraBold: 'Inter-ExtraBold',
  },
  sizes: {
    xs:    11,
    sm:    13,
    base:  15,
    lg:    17,
    xl:    20,
    '2xl': 24,
    '3xl': 30,
    '4xl': 36,
  },
};

// ─── ESPAÇAMENTOS ────────────────────────────────────────────────────────────

export const spacing = {
  xs:    4,
  sm:    8,
  md:    12,
  lg:    16,
  xl:    20,
  '2xl': 24,
  '3xl': 32,
  '4xl': 40,
};

// ─── BORDER RADIUS ────────────────────────────────────────────────────────────

export const borderRadius = {
  sm:   8,
  md:   12,
  lg:   16,
  xl:   20,
  full: 9999,
};

// ─── SOMBRAS ─────────────────────────────────────────────────────────────────

export const shadows = {
  card: {
    shadowColor:   '#000',
    shadowOffset:  { width: 0, height: 1 },
    shadowOpacity: 0.06,
    shadowRadius:  3,
    elevation:     2,
  },
  cardHover: {
    shadowColor:   '#000',
    shadowOffset:  { width: 0, height: 4 },
    shadowOpacity: 0.1,
    shadowRadius:  12,
    elevation:     4,
  },
  button: {
    shadowColor:   '#1e3a8a',
    shadowOffset:  { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius:  8,
    elevation:     3,
  },
};

// ─── GRADIENTES (para LinearGradient) ────────────────────────────────────────

export const gradients = {
  primary:  [colors.primary[900], colors.primary[700]] as string[],
  success:  [colors.success[700], colors.success[600]] as string[],
  danger:   [colors.danger[700],  colors.danger[600]]  as string[],
  loginBg:  [colors.primary[900], colors.primary[600]] as string[],
  navBar:   [colors.primary[900], colors.primary[800], colors.primary[900]] as string[],
};

const theme = { colors, typography, spacing, borderRadius, shadows, gradients };
export default theme;
