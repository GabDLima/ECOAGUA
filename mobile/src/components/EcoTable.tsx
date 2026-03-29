import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import EcoBadge from './EcoBadge';
import { colors, typography, spacing } from '../theme/theme';

type BadgeType = 'success' | 'info' | 'warning' | 'danger';

interface Column {
  key:    string;
  label:  string;
  flex?:  number;
  align?: 'left' | 'center' | 'right';
}

interface EcoTableProps {
  data:          any[];
  columns:       Column[];
  keyExtractor:  (item: any, index: number) => string;
  badgeKey?:     string;
  badgeTypeMap?: Record<string, BadgeType>;
  emptyText?:    string;
}

export default function EcoTable({
  data, columns, keyExtractor, badgeKey, badgeTypeMap, emptyText = 'Nenhum dado encontrado.',
}: EcoTableProps) {
  return (
    <View>
      {/* Cabeçalho */}
      <View style={styles.header}>
        {columns.map((col) => (
          <Text
            key={col.key}
            style={[
              styles.headerText,
              { flex: col.flex ?? 1, textAlign: col.align ?? 'left' },
            ]}
          >
            {col.label.toUpperCase()}
          </Text>
        ))}
      </View>

      {/* Linhas */}
      {data.length === 0 ? (
        <Text style={styles.emptyText}>{emptyText}</Text>
      ) : (
        data.map((item, index) => (
          <View key={keyExtractor(item, index)} style={styles.row}>
            {columns.map((col) => {
              const val = item[col.key];
              if (badgeKey && col.key === badgeKey && badgeTypeMap) {
                return (
                  <View
                    key={col.key}
                    style={{ flex: col.flex ?? 1, alignItems: col.align === 'right' ? 'flex-end' : 'flex-start' }}
                  >
                    <EcoBadge text={String(val ?? '—')} type={badgeTypeMap[val] ?? 'info'} />
                  </View>
                );
              }
              return (
                <Text
                  key={col.key}
                  style={[
                    styles.cell,
                    { flex: col.flex ?? 1, textAlign: col.align ?? 'left' },
                  ]}
                >
                  {val !== undefined && val !== null ? String(val) : '—'}
                </Text>
              );
            })}
          </View>
        ))
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  header: {
    flexDirection:   'row',
    paddingVertical: spacing.sm,
    paddingHorizontal: spacing.sm,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[200],
    marginBottom:    spacing.xs,
  },
  headerText: {
    fontSize:      typography.sizes.xs,
    fontWeight:    '600',
    color:         colors.slate[400],
    letterSpacing: 0.5,
  },
  row: {
    flexDirection:   'row',
    alignItems:      'center',
    paddingVertical: spacing.md,
    paddingHorizontal: spacing.sm,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[100],
  },
  cell: {
    fontSize: typography.sizes.sm,
    color:    colors.slate[700],
  },
  emptyText: {
    textAlign:     'center',
    color:         colors.slate[400],
    fontSize:      typography.sizes.sm,
    paddingVertical: spacing.xl,
  },
});
