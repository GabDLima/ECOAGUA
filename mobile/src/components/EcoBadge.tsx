import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { colors, typography } from '../theme/theme';

type BadgeType = 'success' | 'info' | 'warning' | 'danger';

interface EcoBadgeProps {
  text: string;
  type: BadgeType;
}

const badgeConfig: Record<BadgeType, { bg: string; text: string }> = {
  success: { bg: colors.success[100], text: colors.success[700] },
  info:    { bg: colors.primary[100], text: colors.primary[900] },
  warning: { bg: colors.warning[100], text: colors.warning[700] },
  danger:  { bg: colors.danger[100],  text: colors.danger[700]  },
};

export default function EcoBadge({ text, type }: EcoBadgeProps) {
  const c = badgeConfig[type];
  return (
    <View style={[styles.badge, { backgroundColor: c.bg }]}>
      <Text style={[styles.text, { color: c.text }]}>{text}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  badge: {
    paddingHorizontal: 10,
    paddingVertical:   4,
    borderRadius:      20,
    alignSelf:         'flex-start',
  },
  text: {
    fontSize:   typography.sizes.xs,
    fontWeight: '600',
  },
});
