import React from 'react';
import {
  TouchableOpacity, Text, StyleSheet, ActivityIndicator, View, ViewStyle,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import { colors, typography, spacing, borderRadius, shadows, gradients } from '../theme/theme';

type Variant = 'primary' | 'secondary' | 'danger' | 'success';

interface EcoButtonProps {
  title: string;
  icon?: string;
  variant?: Variant;
  onPress: () => void;
  loading?: boolean;
  disabled?: boolean;
  fullWidth?: boolean;
  style?: ViewStyle;
}

const variantGradients: Record<Exclude<Variant, 'secondary'>, string[]> = {
  primary: gradients.primary,
  danger:  gradients.danger,
  success: gradients.success,
};

export default function EcoButton({
  title, icon, variant = 'primary', onPress, loading, disabled, fullWidth, style,
}: EcoButtonProps) {
  const isSecondary = variant === 'secondary';
  const iconColor   = isSecondary ? colors.primary[900] : colors.white;

  const innerContent = loading ? (
    <ActivityIndicator color={iconColor} size="small" />
  ) : (
    <View style={styles.inner}>
      {icon ? <MaterialCommunityIcons name={icon} size={18} color={iconColor} /> : null}
      <Text style={[styles.text, isSecondary && styles.textSecondary]}>{title}</Text>
    </View>
  );

  const outerStyle = [
    styles.container,
    fullWidth && styles.fullWidth,
    (disabled || loading) && styles.disabled,
    style,
  ];

  if (isSecondary) {
    return (
      <TouchableOpacity
        style={[outerStyle, styles.secondary]}
        onPress={onPress}
        disabled={disabled || loading}
        activeOpacity={0.8}
      >
        {innerContent}
      </TouchableOpacity>
    );
  }

  return (
    <TouchableOpacity
      style={outerStyle}
      onPress={onPress}
      disabled={disabled || loading}
      activeOpacity={0.85}
    >
      <LinearGradient
        colors={variantGradients[variant as Exclude<Variant, 'secondary'>]}
        start={{ x: 0, y: 0 }}
        end={{ x: 1, y: 0 }}
        style={styles.gradient}
      >
        {innerContent}
      </LinearGradient>
    </TouchableOpacity>
  );
}

const styles = StyleSheet.create({
  container: {
    borderRadius: borderRadius.md,
    overflow:     'hidden',
    ...shadows.button,
  },
  gradient: {
    alignItems:        'center',
    justifyContent:    'center',
    paddingVertical:   14,
    paddingHorizontal: spacing['2xl'],
  },
  secondary: {
    alignItems:        'center',
    justifyContent:    'center',
    paddingVertical:   14,
    paddingHorizontal: spacing['2xl'],
    backgroundColor:   colors.white,
    borderWidth:       1.5,
    borderColor:       colors.primary[900],
  },
  inner: {
    flexDirection: 'row',
    alignItems:    'center',
    gap:           spacing.sm,
  },
  text: {
    color:      colors.white,
    fontSize:   typography.sizes.base,
    fontWeight: '600',
  },
  textSecondary: {
    color: colors.primary[900],
  },
  fullWidth: { alignSelf: 'stretch' },
  disabled:  { opacity: 0.5 },
});
