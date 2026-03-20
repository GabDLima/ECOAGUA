import React, { useState, useCallback } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import {
  View, Text, StyleSheet, ScrollView, TextInput,
  TouchableOpacity, Alert, RefreshControl,
  KeyboardAvoidingView, Platform
} from 'react-native';
import api from '../api/api';
import theme from '../theme/theme';

const TIPOS = ['Banho', 'Cozinha', 'Lavanderia', 'Jardim', 'Outros'];
const UNIDADES = ['L', 'mL', 'm³'];

const ConsumoScreen: React.FC = () => {
  const [quantidade, setQuantidade] = useState('');
  const [unidade, setUnidade] = useState('L');
  const [tipo, setTipo] = useState('Banho');
  const [historico, setHistorico] = useState<any[]>([]);
  const [refreshing, setRefreshing] = useState(false);
  const [saving, setSaving] = useState(false);

  const fetchHistorico = useCallback(async () => {
    try {
      const res = await api.get('/api/consumo');
      setHistorico(res.data.ultimos_7_dias || []);
    } catch {
      Alert.alert('Erro', 'Não foi possível carregar o histórico.');
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchHistorico(); }, [fetchHistorico]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchHistorico();
    setRefreshing(false);
  }, [fetchHistorico]);

  async function handleSalvar() {
    const qtd = parseFloat(quantidade);
    if (!quantidade || isNaN(qtd) || qtd <= 0) {
      Alert.alert('Atenção', 'Informe uma quantidade válida maior que zero.');
      return;
    }
    setSaving(true);
    try {
      await api.post('/api/consumo', {
        data_consumo: new Date().toISOString().split('T')[0],
        quantidade: qtd,
        unidade,
        tipo,
      });
      Alert.alert('Sucesso', 'Consumo registrado!');
      setQuantidade('');
      fetchHistorico();
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar.');
    } finally {
      setSaving(false);
    }
  }

  return (
    <KeyboardAvoidingView
      style={{ flex: 1 }}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
    <ScrollView
      style={styles.container}
      keyboardShouldPersistTaps="handled"
      refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[theme.colors.primary]} />}
    >
      <View style={styles.form}>
        <Text style={styles.title}>Registrar consumo</Text>
        <Text style={styles.label}>Quantidade</Text>
        <View style={styles.row}>
          <TextInput
            style={[styles.input, { flex: 1 }]}
            placeholder="0"
            placeholderTextColor={theme.colors.textLight}
            value={quantidade}
            onChangeText={setQuantidade}
            keyboardType="numeric"
          />
          <View style={styles.unidades}>
            {UNIDADES.map(u => (
              <TouchableOpacity
                key={u}
                style={[styles.chip, unidade === u && styles.chipActive]}
                onPress={() => setUnidade(u)}
              >
                <Text style={[styles.chipText, unidade === u && styles.chipTextActive]}>{u}</Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>
        <Text style={styles.label}>Tipo</Text>
        <View style={styles.tipos}>
          {TIPOS.map(t => (
            <TouchableOpacity
              key={t}
              style={[styles.chip, tipo === t && styles.chipActive]}
              onPress={() => setTipo(t)}
            >
              <Text style={[styles.chipText, tipo === t && styles.chipTextActive]}>{t}</Text>
            </TouchableOpacity>
          ))}
        </View>
        <TouchableOpacity
          style={[styles.button, saving && styles.buttonDisabled]}
          onPress={handleSalvar}
          disabled={saving}
        >
          <Text style={styles.buttonText}>{saving ? 'Salvando...' : 'Registrar'}</Text>
        </TouchableOpacity>
      </View>

      <View style={styles.historico}>
        <Text style={styles.title}>Últimos 7 dias</Text>
        {historico.length === 0 && <Text style={styles.empty}>Nenhum registro encontrado.</Text>}
        {historico.map((item, i) => (
          <View key={i} style={styles.item}>
            <Text style={styles.itemData}>{item.data_consumo}</Text>
            <Text style={styles.itemTipo}>{item.tipo}</Text>
            <Text style={styles.itemQtd}>{item.quantidade} {item.unidade}</Text>
          </View>
        ))}
      </View>
    </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.background },
  form: {
    backgroundColor: theme.colors.surface,
    margin: theme.spacing.base,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  title: {
    fontSize: theme.typography.fontSize.xl2,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.primary,
    marginBottom: theme.spacing.base,
  },
  label: {
    fontSize: theme.typography.fontSize.sm,
    color: theme.colors.textSecondary,
    fontWeight: theme.typography.fontWeight.medium as '500',
    marginBottom: theme.spacing.xs,
    marginTop: theme.spacing.md,
  },
  row: { flexDirection: 'row', alignItems: 'center', gap: theme.spacing.sm },
  input: {
    borderWidth: 2,
    borderColor: theme.colors.border,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    fontSize: theme.typography.fontSize.base,
    color: theme.colors.textSecondary,
  },
  unidades: { flexDirection: 'row', gap: theme.spacing.xs },
  tipos: { flexDirection: 'row', flexWrap: 'wrap', gap: theme.spacing.sm, marginTop: theme.spacing.xs },
  chip: {
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.xs + 2,
    borderRadius: theme.borderRadius.full,
    borderWidth: 1,
    borderColor: theme.colors.border,
    backgroundColor: theme.colors.backgroundAlt,
  },
  chipActive: { backgroundColor: theme.colors.primary, borderColor: theme.colors.primary },
  chipText: { fontSize: theme.typography.fontSize.sm, color: theme.colors.textMuted },
  chipTextActive: {
    color: theme.colors.textWhite,
    fontWeight: theme.typography.fontWeight.medium as '500',
  },
  button: {
    backgroundColor: theme.colors.primary,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    alignItems: 'center',
    marginTop: theme.spacing.xl,
    ...theme.shadows.btnPrimary,
  },
  buttonDisabled: { backgroundColor: theme.colors.textLight },
  buttonText: {
    color: theme.colors.textWhite,
    fontWeight: theme.typography.fontWeight.medium as '500',
    fontSize: theme.typography.fontSize.base,
  },
  historico: {
    margin: theme.spacing.base,
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  empty: { color: theme.colors.textLight, textAlign: 'center', marginTop: theme.spacing.sm },
  item: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: theme.spacing.sm + 2,
    borderBottomWidth: 1,
    borderBottomColor: theme.colors.borderLight,
  },
  itemData: { fontSize: theme.typography.fontSize.xs, color: theme.colors.textMuted, flex: 1 },
  itemTipo: {
    fontSize: theme.typography.fontSize.sm,
    color: theme.colors.textSecondary,
    flex: 1,
    textAlign: 'center',
  },
  itemQtd: {
    fontSize: theme.typography.fontSize.sm,
    fontWeight: theme.typography.fontWeight.semibold as '600',
    color: theme.colors.success,
    flex: 1,
    textAlign: 'right',
  },
});

export default ConsumoScreen;
