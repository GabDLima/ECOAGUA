import React, { useState } from 'react';
import {
  View, Text, TextInput, StyleSheet, TextInputProps, ViewStyle,
} from 'react-native';
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import { colors, typography, spacing, borderRadius } from '../theme/theme';

interface EcoInputProps extends Omit<TextInputProps, 'style'> {
  label: string;
  icon?: string;
  error?: string;
  containerStyle?: ViewStyle;
}

export default function EcoInput({ label, icon, error, containerStyle, ...props }: EcoInputProps) {
  const [focused, setFocused] = useState(false);

  const isDisabled = props.editable === false;

  return (
    <View style={[styles.container, containerStyle]}>
      <View style={styles.labelRow}>
        {icon ? (
          <MaterialCommunityIcons name={icon} size={14} color={colors.primary[600]} />
        ) : null}
        <Text style={styles.label}>{label}</Text>
      </View>
      <TextInput
        style={[
          styles.input,
          focused    && styles.inputFocused,
          !!error    && styles.inputError,
          isDisabled && styles.inputDisabled,
        ]}
        placeholderTextColor={colors.slate[400]}
        onFocus={() => setFocused(true)}
        onBlur={() => setFocused(false)}
        {...props}
      />
      {error ? <Text style={styles.errorText}>{error}</Text> : null}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    marginBottom: spacing.lg,
  },
  labelRow: {
    flexDirection:  'row',
    alignItems:     'center',
    gap:            spacing.sm,
    marginBottom:   spacing.sm,
  },
  label: {
    fontSize:   typography.sizes.sm,
    fontWeight: '600',
    color:      colors.slate[700],
  },
  input: {
    backgroundColor:   colors.white,
    borderWidth:       1.5,
    borderColor:       colors.slate[300],
    borderRadius:      borderRadius.md,
    paddingHorizontal: spacing.lg,
    paddingVertical:   14,
    fontSize:          typography.sizes.base,
    color:             colors.slate[800],
  },
  inputFocused:  { borderColor: colors.primary[600] },
  inputError:    { borderColor: colors.danger[600] },
  inputDisabled: { backgroundColor: colors.slate[50], color: colors.slate[400] },
  errorText: {
    fontSize:   typography.sizes.xs,
    color:      colors.danger[600],
    marginTop:  spacing.xs,
  },
});
