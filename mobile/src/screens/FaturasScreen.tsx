import React, { useState, useCallback } from 'react';
import {
  View, Text, StyleSheet, ScrollView, Alert, RefreshControl,
  KeyboardAvoidingView, Platform, StatusBar,
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';
import api from '../api/api';
import Loading from '../components/Loading';
import EcoCard from '../components/EcoCard';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import EcoBadge from '../components/EcoBadge';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';
import { formatReais } from '../utils/formatNumber';

interface Fatura {
  mes_da_fatura:  string;
  mes_formatado?: string;
  valor:          number;
}

export default function FaturasScreen() {
  const [faturas,  setFaturas]  = useState<Fatura[]>([]);
  const [totalAno, setTotalAno] = useState(0);
  const [media,    setMedia]    = useState(0);
  const [mes,      setMes]      = useState('');
  const [valor,    setValor]    = useState('');
  const [saving,   setSaving]   = useState(false);
  const [loadingData, setLoadingData] = useState(true);
  const [refreshing, setRefreshing]   = useState(false);

  const fetchFaturas = useCallback(async () => {
    try {
      // GET /api/faturas
      const res = await api.get('/api/faturas');
      setFaturas(res.data.faturas ?? []);
      setTotalAno(res.data.total_ano   ?? 0);
      setMedia(res.data.media_mensal   ?? 0);
    } catch {
      Alert.alert('Erro', 'Não foi possível carregar as faturas.');
    } finally {
      setLoadingData(false);
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchFaturas(); }, [fetchFaturas]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchFaturas();
    setRefreshing(false);
  }, [fetchFaturas]);

  async function handleSalvar() {
    if (!mes || !valor) { Alert.alert('Atenção', 'Preencha o mês e o valor.'); return; }
    const valorNum = parseFloat(valor.replace(',', '.'));
    if (isNaN(valorNum) || valorNum <= 0) { Alert.alert('Atenção', 'Informe um valor válido.'); return; }
    setSaving(true);
    try {
      // POST /api/faturas
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

  if (loadingData) return <Loading />;

  return (
    <KeyboardAvoidingView style={{ flex: 1 }} behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
      <ScrollView
        style={styles.container}
        keyboardShouldPersistTaps="handled"
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[colors.primary[900]]} />
        }
      >
        <StatusBar barStyle="light-content" backgroundColor={colors.primary[900]} />

        {/* ── Cabeçalho ── */}
        <LinearGradient colors={gradients.loginBg} style={styles.header}>
          <Text style={styles.headerTitle}>Faturas</Text>
          <Text style={styles.headerSub}>Histórico de cobranças mensais</Text>
        </LinearGradient>

        <View style={styles.body}>

          {/* ── Resumo ── */}
          <View style={styles.resumoRow}>
            <EcoCard style={styles.resumoCard}>
              <View style={[styles.resumoIcon, { backgroundColor: colors.kpiGreen.bg }]}>
                <Text style={styles.resumoEmoji}>📋</Text>
              </View>
              <Text style={styles.resumoLabel}>Total {new Date().getFullYear()}</Text>
              <Text style={[styles.resumoValue, { color: colors.primary[900] }]}>
                R$ {formatReais(Number(totalAno))}
              </Text>
            </EcoCard>
            <EcoCard style={styles.resumoCard}>
              <View style={[styles.resumoIcon, { backgroundColor: colors.kpiAmber.bg }]}>
                <Text style={styles.resumoEmoji}>📊</Text>
              </View>
              <Text style={styles.resumoLabel}>Média Mensal</Text>
              <Text style={[styles.resumoValue, { color: colors.warning[700] }]}>
                R$ {formatReais(Number(media))}
              </Text>
            </EcoCard>
          </View>

          {/* ── Formulário ── */}
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Registrar Fatura</Text>
            <EcoInput
              label="Mês de referência"
              icon="calendar-month-outline"
              placeholder="YYYY-MM (ex: 2026-03)"
              value={mes}
              onChangeText={setMes}
              keyboardType="numbers-and-punctuation"
            />
            <EcoInput
              label="Valor (R$)"
              icon="currency-brl"
              placeholder="0,00"
              value={valor}
              onChangeText={setValor}
              keyboardType="decimal-pad"
            />
            <EcoButton
              title="Registrar Fatura"
              icon="check"
              variant="success"
              onPress={handleSalvar}
              loading={saving}
              fullWidth
            />
          </EcoCard>

          {/* ── Histórico ── */}
          <EcoCard style={[styles.section, styles.lastSection]}>
            <Text style={styles.sectionTitle}>Histórico de Faturas</Text>

            {/* Cabeçalho tabela */}
            <View style={styles.tableHeader}>
              <Text style={[styles.tableHeaderCell, { flex: 2 }]}>MÊS</Text>
              <Text style={[styles.tableHeaderCell, { flex: 1 }]}>STATUS</Text>
              <Text style={[styles.tableHeaderCell, { flex: 1, textAlign: 'right' }]}>VALOR</Text>
            </View>

            {faturas.length === 0 ? (
              <Text style={styles.emptyText}>Nenhuma fatura registrada.</Text>
            ) : (
              faturas.map((item, i) => (
                <View key={i} style={styles.tableRow}>
                  <Text style={[styles.tableCell, { flex: 2 }]}>
                    {item.mes_formatado ?? item.mes_da_fatura}
                  </Text>
                  <View style={{ flex: 1 }}>
                    <EcoBadge text="Paga" type="success" />
                  </View>
                  <Text style={[styles.tableCell, styles.tableCellRight, { flex: 1 }]}>
                    R$ {formatReais(Number(item.valor))}
                  </Text>
                </View>
              ))
            )}
          </EcoCard>

        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: colors.background },

  header: {
    paddingTop:        52,
    paddingBottom:     spacing['2xl'],
    paddingHorizontal: spacing['2xl'],
  },
  headerTitle: { fontSize: typography.sizes['2xl'], fontWeight: '700', color: colors.white },
  headerSub:   { fontSize: typography.sizes.sm, color: 'rgba(255,255,255,0.75)', marginTop: spacing.xs },

  body: { padding: spacing.lg },

  // Resumo
  resumoRow: { flexDirection: 'row', gap: spacing.md, marginBottom: spacing.lg },
  resumoCard: {
    flex:      1,
    padding:   spacing.lg,
    alignItems: 'center',
  },
  resumoIcon: {
    width:          44,
    height:         44,
    borderRadius:   22,
    justifyContent: 'center',
    alignItems:     'center',
    marginBottom:   spacing.sm,
  },
  resumoEmoji: { fontSize: 22 },
  resumoLabel: {
    fontSize:     typography.sizes.xs,
    color:        colors.slate[400],
    fontWeight:   '600',
    marginBottom: spacing.xs,
    textAlign:    'center',
  },
  resumoValue: {
    fontSize:   typography.sizes.xl,
    fontWeight: '700',
    textAlign:  'center',
  },

  section:      { marginBottom: spacing.lg, padding: spacing['2xl'] },
  lastSection:  { marginBottom: spacing['4xl'] },
  sectionTitle: {
    fontSize:     typography.sizes.lg,
    fontWeight:   '700',
    color:        colors.slate[800],
    marginBottom: spacing.lg,
  },

  // Tabela
  tableHeader: {
    flexDirection:     'row',
    paddingVertical:   spacing.sm,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[200],
    marginBottom:      spacing.sm,
  },
  tableHeaderCell: {
    fontSize:      typography.sizes.xs,
    fontWeight:    '600',
    color:         colors.slate[400],
    letterSpacing: 0.5,
  },
  tableRow: {
    flexDirection:     'row',
    alignItems:        'center',
    paddingVertical:   spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[100],
  },
  tableCell:      { fontSize: typography.sizes.sm, color: colors.slate[700] },
  tableCellRight: { textAlign: 'right', fontWeight: '600', color: colors.primary[900] },
  emptyText: {
    textAlign:       'center',
    color:           colors.slate[400],
    fontSize:        typography.sizes.sm,
    paddingVertical: spacing.xl,
  },
});
