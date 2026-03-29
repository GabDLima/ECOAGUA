import React from 'react';
import { View, Text, StyleSheet, ViewStyle } from 'react-native';
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import EcoCard from './EcoCard';
import EcoBadge from './EcoBadge';
import { colors, typography, spacing } from '../theme/theme';

type BadgeType = 'success' | 'info' | 'warning' | 'danger';

interface KpiCardProps {
  icon:         string;
  iconBg:       string;
  iconColor:    string;
  statusText?:  string;
  statusType?:  BadgeType;
  label:        string;
  value:        string;
  subtitle?:    string;
  progress?:    number; // 0–100
  style?:       ViewStyle;
  onPress?:     () => void;
}

function progressColor(pct: number): string {
  if (pct >= 100) return colors.danger[600];
  if (pct >= 80)  return colors.warning[600];
  return colors.success[600];
}

export default function KpiCard({
  icon, iconBg, iconColor, statusText, statusType = 'info',
  label, value, subtitle, progress, style, onPress,
}: KpiCardProps) {
  return (
    <EcoCard style={style ? [styles.card, style] : styles.card} onPress={onPress}>
      {/* Topo: ícone + badge */}
      <View style={styles.top}>
        <View style={[styles.iconCircle, { backgroundColor: iconBg }]}>
          <MaterialCommunityIcons name={icon} size={22} color={iconColor} />
        </View>
        {statusText ? <EcoBadge text={statusText} type={statusType} /> : null}
      </View>

      {/* Label */}
      <Text style={styles.label}>{label.toUpperCase()}</Text>

      {/* Valor */}
      <Text style={styles.value} numberOfLines={1} adjustsFontSizeToFit>
        {value}
      </Text>

      {/* Subtítulo */}
      {subtitle ? <Text style={styles.subtitle}>{subtitle}</Text> : null}

      {/* Barra de progresso */}
      {progress !== undefined ? (
        <View style={styles.progressTrack}>
          <View
            style={[
              styles.progressFill,
              {
                width:           `${Math.min(progress, 100)}%`,
                backgroundColor: progressColor(progress),
              },
            ]}
          />
        </View>
      ) : null}
    </EcoCard>
  );
}

const styles = StyleSheet.create({
  card: {
    padding: spacing.lg,
    flex:    1,
  },
  top: {
    flexDirection:  'row',
    justifyContent: 'space-between',
    alignItems:     'center',
    marginBottom:   spacing.md,
  },
  iconCircle: {
    width:          44,
    height:         44,
    borderRadius:   22,
    justifyContent: 'center',
    alignItems:     'center',
  },
  label: {
    fontSize:      typography.sizes.xs,
    fontWeight:    '600',
    color:         colors.slate[400],
    letterSpacing: 0.5,
    marginBottom:  spacing.xs,
  },
  value: {
    fontSize:   typography.sizes['2xl'],
    fontWeight: '700',
    color:      colors.slate[800],
    lineHeight: 30,
  },
  subtitle: {
    fontSize:  typography.sizes.xs,
    color:     colors.slate[400],
    marginTop: spacing.xs,
  },
  progressTrack: {
    height:          4,
    backgroundColor: colors.slate[200],
    borderRadius:    2,
    overflow:        'hidden',
    marginTop:       spacing.md,
  },
  progressFill: {
    height:       '100%',
    borderRadius: 2,
  },
});
