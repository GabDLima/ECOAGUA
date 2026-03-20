import React, { useState, useCallback } from 'react';
import {
  View, Text, StyleSheet, ScrollView, TextInput,
  TouchableOpacity, Alert, RefreshControl,
  KeyboardAvoidingView, Platform
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import api from '../api/api';
import theme from '../theme/theme';

const FaturasScreen: React.FC = () => {
  const [faturas, setFaturas] = useState<any[]>([]);
  const [ultimaFatura, setUltimaFatura] = useState<any>(null);
  const [totalAno, setTotalAno] = useState(0);
  const [media, setMedia] = useState(0);
  const [mes, setMes] = useState('');
  const [valor, setValor] = useState('');
  const [saving, setSaving] = useState(false);
  const [refreshing, setRefreshing] = useState(false);
  const [loading, setLoading] = useState(true);

  const fetchFaturas = useCallback(async () => {
    try {
      const res = await api.get('/api/faturas');
      setFaturas(res.data.faturas || []);
      setUltimaFatura(res.data.ultima_fatura);
      setTotalAno(res.data.total_ano || 0);
      setMedia(res.data.media_mensal || 0);
    } catch {
      Alert.alert('Erro', 'Não foi possível carregar as faturas.');
    } finally {
      setLoading(false);
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchFaturas(); }, [fetchFaturas]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchFaturas();
    setRefreshing(false);
  }, [fetchFaturas]);

  async function handleSalvar() {
    if (!mes || !valor) {
      Alert.alert('Atenção', 'Preencha o mês e o valor.');
      return;
    }
    const valorNum = parseFloat(valor.replace(',', '.'));
    if (isNaN(valorNum) || valorNum <= 0) {
      Alert.alert('Atenção', 'Informe um valor válido.');
      return;
    }
    setSaving(true);
    try {
      await api.post('/api/faturas', { mes_da_fatura: mes, valor: valorNum });
      Alert.alert('Sucesso', 'Fatura registrada!');
      setMes(''); setValor('');
      fetchFaturas();
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar.');
    } finally {
      setSaving(false);
    }
  }

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={{ color: theme.colors.textMuted }}>Carregando...</Text>
      </View>
    );
  }

  return (
    <KeyboardAvoidingView style={{ flex: 1 }} behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
      <ScrollView
        style={styles.container}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[theme.colors.primary]} />}
        keyboardShouldPersistTaps="handled"
      >
        <View style={styles.resumoRow}>
          <View style={styles.resumoCard}>
            <Text style={styles.resumoLabel}>Total {new Date().getFullYear()}</Text>
            <Text style={styles.resumoValue}>R$ {Number(totalAno).toFixed(2)}</Text>
          </View>
          <View style={styles.resumoCard}>
            <Text style={styles.resumoLabel}>Média mensal</Text>
            <Text style={styles.resumoValue}>R$ {Number(media).toFixed(2)}</Text>
          </View>
        </View>

        <View style={styles.card}>
          <Text style={styles.title}>Registrar fatura</Text>
          <Text style={styles.label}>Mês de referência</Text>
          <TextInput
            style={styles.input}
            value={mes}
            onChangeText={setMes}
            placeholder="YYYY-MM (ex: 2026-03)"
            placeholderTextColor={theme.colors.textLight}
            keyboardType="numbers-and-punctuation"
          />
          <Text style={styles.label}>Valor (R$)</Text>
          <TextInput
            style={styles.input}
            value={valor}
            onChangeText={setValor}
            placeholder="0,00"
            placeholderTextColor={theme.colors.textLight}
            keyboardType="decimal-pad"
          />
          <TouchableOpacity
            style={[styles.button, saving && styles.buttonDisabled]}
            onPress={handleSalvar}
            disabled={saving}
          >
            <Text style={styles.buttonText}>{saving ? 'Salvando...' : 'Registrar fatura'}</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.card}>
          <Text style={styles.title}>Histórico</Text>
          {faturas.length === 0 && (
            <Text style={styles.empty}>Nenhuma fatura registrada.</Text>
          )}
          {faturas.map((item, i) => (
            <View key={i} style={styles.item}>
              <Text style={styles.itemMes}>{item.mes_formatado || item.mes_da_fatura}</Text>
              <Text style={styles.itemValor}>R$ {Number(item.valor).toFixed(2)}</Text>
            </View>
          ))}
        </View>

      </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.background },
  loadingContainer: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: theme.colors.background },
  resumoRow: { flexDirection: 'row', padding: theme.spacing.base, gap: theme.spacing.md },
  resumoCard: {
    flex: 1, backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    alignItems: 'center',
    ...theme.shadows.card,
  },
  resumoLabel: { fontSize: theme.typography.fontSize.xs, color: theme.colors.textMuted, marginBottom: theme.spacing.xs },
  resumoValue: { fontSize: theme.typography.fontSize.xl2, fontWeight: theme.typography.fontWeight.bold as 'bold', color: theme.colors.primary },
  card: {
    backgroundColor: theme.colors.surface,
    margin: theme.spacing.base,
    marginTop: 0,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  title: { fontSize: theme.typography.fontSize.xl2, fontWeight: theme.typography.fontWeight.bold as 'bold', color: theme.colors.primary, marginBottom: theme.spacing.base },
  label: { fontSize: theme.typography.fontSize.sm, fontWeight: theme.typography.fontWeight.medium as '500', color: theme.colors.textSecondary, marginBottom: theme.spacing.xs, marginTop: theme.spacing.md },
  input: { borderWidth: 2, borderColor: theme.colors.border, borderRadius: theme.borderRadius.md, padding: theme.spacing.md, fontSize: theme.typography.fontSize.base, color: theme.colors.textSecondary },
  button: { backgroundColor: theme.colors.primary, borderRadius: theme.borderRadius.md, padding: theme.spacing.md, alignItems: 'center', marginTop: theme.spacing.xl, ...theme.shadows.btnPrimary },
  buttonDisabled: { backgroundColor: theme.colors.textLight },
  buttonText: { color: theme.colors.textWhite, fontWeight: theme.typography.fontWeight.medium as '500', fontSize: theme.typography.fontSize.base },
  empty: { color: theme.colors.textLight, textAlign: 'center', marginTop: theme.spacing.sm },
  item: { flexDirection: 'row', justifyContent: 'space-between', paddingVertical: theme.spacing.sm + 2, borderBottomWidth: 1, borderBottomColor: theme.colors.borderLight },
  itemMes: { fontSize: theme.typography.fontSize.sm, color: theme.colors.textSecondary },
  itemValor: { fontSize: theme.typography.fontSize.sm, fontWeight: theme.typography.fontWeight.semibold as '600', color: theme.colors.success },
});

export default FaturasScreen;
