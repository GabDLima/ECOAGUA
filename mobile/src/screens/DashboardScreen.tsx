import React, { useState, useCallback } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import {
  View, Text, ScrollView, StyleSheet,
  TouchableOpacity, RefreshControl, Alert
} from 'react-native';
import { useAuth } from '../contexts/AuthContext';
import api from '../api/api';
import theme from '../theme/theme';
import Loading from '../components/Loading';
import { LineChart } from 'react-native-gifted-charts';

interface DashboardData {
  consumo_hoje: number;
  total_mes_atual: number;
  variacao_percent: number;
  projecao_mensal: number;
  ultima_fatura: { valor: number } | null;
  progresso_meta: { percentual: number; meta_litros: number; alerta: boolean } | null;
  alerta: boolean;
  ultimos_7_dias?: { data_consumo: string; quantidade: number }[];
}

const DashboardScreen: React.FC = () => {
  const { usuario, logout } = useAuth();
  const [data, setData] = useState<DashboardData | null>(null);
  const [refreshing, setRefreshing] = useState(false);
  const [loadingData, setLoadingData] = useState(true);

  const fetchDashboard = useCallback(async () => {
    try {
      const response = await api.get('/api/dashboard');
      setData(response.data);
    } catch {
      Alert.alert('Erro', 'Não foi possível carregar os dados.');
    } finally {
      setLoadingData(false);
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchDashboard(); }, [fetchDashboard]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchDashboard();
    setRefreshing(false);
  }, [fetchDashboard]);

  if (loadingData) return <Loading />;

  return (
    <ScrollView
      style={styles.container}
      refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[theme.colors.primary]} />}
    >
      <View style={styles.header}>
        <Text style={styles.greeting}>Olá, {usuario?.nome?.split(' ')[0]} 👋</Text>
        <TouchableOpacity onPress={logout}>
          <Text style={styles.logout}>Sair</Text>
        </TouchableOpacity>
      </View>

      {data?.alerta && (
        <View style={styles.alertBox}>
          <Text style={styles.alertText}>⚠️ Atenção! Seu consumo está elevado este mês.</Text>
        </View>
      )}

      <View style={styles.cardsRow}>
        <View style={styles.card}>
          <Text style={styles.cardLabel}>Hoje</Text>
          <Text style={styles.cardValue}>{Number(data?.consumo_hoje || 0).toFixed(0)}L</Text>
        </View>
        <View style={styles.card}>
          <Text style={styles.cardLabel}>Este mês</Text>
          <Text style={styles.cardValue}>{Number(data?.total_mes_atual || 0).toFixed(0)}L</Text>
        </View>
      </View>

      <View style={styles.cardsRow}>
        <View style={styles.card}>
          <Text style={styles.cardLabel}>Projeção</Text>
          <Text style={styles.cardValue}>{Number(data?.projecao_mensal || 0).toFixed(0)}L</Text>
        </View>
        <View style={styles.card}>
          <Text style={styles.cardLabel}>Última fatura</Text>
          <Text style={styles.cardValue}>R$ {Number(data?.ultima_fatura?.valor || 0).toFixed(2)}</Text>
        </View>
      </View>

      {data?.progresso_meta && (
        <View style={styles.metaBox}>
          <Text style={styles.metaTitle}>Meta mensal</Text>
          <View style={styles.progressBar}>
            <View style={[styles.progressFill, {
              width: `${Math.min(data.progresso_meta.percentual, 100)}%` as any,
              backgroundColor: data.progresso_meta.alerta ? theme.colors.danger : theme.colors.success,
            }]} />
          </View>
          <Text style={styles.metaText}>
            {data.progresso_meta.percentual}% de {data.progresso_meta.meta_litros}L
          </Text>
        </View>
      )}

      <View style={styles.variacao}>
        <Text style={styles.variacaoLabel}>Variação vs. mês anterior</Text>
        <Text style={[styles.variacaoValue, {
          color: (data?.variacao_percent || 0) > 0 ? theme.colors.danger : theme.colors.success,
        }]}>
          {(data?.variacao_percent || 0) > 0 ? '+' : ''}{data?.variacao_percent || 0}%
        </Text>
      </View>
      {data?.ultimos_7_dias && data.ultimos_7_dias.length > 0 && (
        <View style={styles.chartBox}>
          <Text style={styles.chartTitle}>Consumo — últimos 7 dias</Text>
          <LineChart
            data={data.ultimos_7_dias.map((item) => ({
              value: Number(item.quantidade) || 0,
              label: item.data_consumo?.slice(5) || '',
            })).reverse()}
            width={280}
            height={160}
            color={theme.colors.primary}
            thickness={2}
            dataPointsColor={theme.colors.primary}
            startFillColor={theme.colors.primaryPale}
            endFillColor={theme.colors.surface}
            areaChart
            curved
            hideRules
            xAxisColor={theme.colors.border}
            yAxisColor={theme.colors.border}
            yAxisTextStyle={{ color: theme.colors.textMuted, fontSize: 10 }}
            xAxisLabelTextStyle={{ color: theme.colors.textMuted, fontSize: 9 }}
            noOfSections={4}
            maxValue={Math.max(...data.ultimos_7_dias.map((i) => Number(i.quantidade) || 0)) * 1.2 || 100}
          />
        </View>
      )}
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.background },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: theme.spacing.xl,
    paddingTop: theme.spacing.xl3,
    backgroundColor: theme.colors.primary,
  },
  greeting: {
    fontSize: theme.typography.fontSize.xl2,
    fontWeight: theme.typography.fontWeight.semibold as '600',
    color: theme.colors.textWhite,
  },
  logout: { color: 'rgba(255,255,255,0.8)', fontSize: theme.typography.fontSize.sm },
  alertBox: {
    margin: theme.spacing.base,
    padding: theme.spacing.md,
    backgroundColor: theme.colors.dangerFaint,
    borderRadius: theme.borderRadius.md,
    borderLeftWidth: 4,
    borderLeftColor: theme.colors.danger,
  },
  alertText: { color: theme.colors.dangerTextDark, fontSize: theme.typography.fontSize.sm },
  cardsRow: {
    flexDirection: 'row',
    paddingHorizontal: theme.spacing.base,
    gap: theme.spacing.md,
    marginBottom: theme.spacing.md,
    marginTop: theme.spacing.base,
  },
  card: {
    flex: 1,
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
    alignItems: 'center',
  },
  cardLabel: {
    fontSize: theme.typography.fontSize.xs,
    color: theme.colors.textMuted,
    marginBottom: theme.spacing.sm,
    fontWeight: theme.typography.fontWeight.medium as '500',
  },
  cardValue: {
    fontSize: theme.typography.fontSize.xl3,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.textPrimary,
  },
  metaBox: {
    margin: theme.spacing.base,
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  metaTitle: {
    fontSize: theme.typography.fontSize.sm,
    color: theme.colors.textMuted,
    marginBottom: theme.spacing.sm,
    fontWeight: theme.typography.fontWeight.medium as '500',
  },
  progressBar: {
    height: theme.spacing.progressHeight,
    backgroundColor: theme.colors.border,
    borderRadius: theme.borderRadius.full,
    overflow: 'hidden',
  },
  progressFill: { height: '100%', borderRadius: theme.borderRadius.full },
  metaText: {
    fontSize: theme.typography.fontSize.xs,
    color: theme.colors.textMuted,
    marginTop: theme.spacing.xs,
  },
  variacao: {
    margin: theme.spacing.base,
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  variacaoLabel: { fontSize: theme.typography.fontSize.sm, color: theme.colors.textMuted },
  variacaoValue: { fontSize: theme.typography.fontSize.xl, fontWeight: theme.typography.fontWeight.bold as 'bold' },
  chartBox: {
    margin: theme.spacing.base,
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  chartTitle: {
    fontSize: theme.typography.fontSize.sm,
    fontWeight: theme.typography.fontWeight.semibold as '600',
    color: theme.colors.primary,
    marginBottom: theme.spacing.md,
  },
});

export default DashboardScreen;
