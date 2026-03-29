import React from 'react';
import { View, Text, StyleSheet, ViewStyle } from 'react-native';
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import { colors, typography, spacing, borderRadius } from '../theme/theme';

type AlertType = 'warning' | 'danger' | 'info' | 'success';

interface EcoAlertProps {
  type: AlertType;
  icon?: string;
  title?: string;
  message: string;
  style?: ViewStyle;
}

const alertConfig: Record<AlertType, { bg: string; border: string; text: string; icon: string }> = {
  warning: { bg: colors.warning[50], border: colors.warning[600], text: colors.warning[700], icon: 'alert' },
  danger:  { bg: colors.danger[50],  border: colors.danger[600],  text: colors.danger[700],  icon: 'alert-circle' },
  info:    { bg: colors.primary[50], border: colors.primary[600], text: colors.primary[900], icon: 'information' },
  success: { bg: colors.success[50], border: colors.success[600], text: colors.success[700], icon: 'check-circle' },
};

export default function EcoAlert({ type, icon, title, message, style }: EcoAlertProps) {
  const c = alertConfig[type];
  const iconName = icon ?? c.icon;

  return (
    <View style={[styles.container, { backgroundColor: c.bg, borderLeftColor: c.border }, style]}>
      <MaterialCommunityIcons name={iconName} size={20} color={c.border} style={styles.icon} />
      <View style={styles.content}>
        {title ? <Text style={[styles.title, { color: c.text }]}>{title}</Text> : null}
        <Text style={[styles.message, { color: c.text }]}>{message}</Text>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flexDirection:  'row',
    alignItems:     'flex-start',
    padding:        spacing.lg,
    borderRadius:   borderRadius.md,
    borderLeftWidth: 4,
  },
  icon:    { marginTop: 1 },
  content: { flex: 1, marginLeft: spacing.md },
  title:   { fontSize: typography.sizes.sm, fontWeight: '600', marginBottom: spacing.xs },
  message: { fontSize: typography.sizes.sm, lineHeight: 20 },
});
