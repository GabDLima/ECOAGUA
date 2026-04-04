import React, { useState, useCallback } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import {
  View, Text, StyleSheet, ScrollView, RefreshControl, Alert, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import { LineChart } from 'react-native-gifted-charts';
import { useAuth } from '../contexts/AuthContext';
import api from '../api/api';
import Loading from '../components/Loading';
import EcoCard from '../components/EcoCard';
import EcoButton from '../components/EcoButton';
import EcoAlert from '../components/EcoAlert';
import KpiCard from '../components/KpiCard';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';
import { notificarMetaAtingida, notificarMetaUltrapassada } from '../services/NotificationService';
import { formatLitros, formatPercent, formatReais } from '../utils/formatNumber';

interface DashboardData {
  consumo_hoje:     number;
  total_mes_atual:  number;
  variacao_percent: number;
  projecao_mensal:  number;
  ultima_fatura:    { valor: number } | null;
  progresso_meta:   {
    percentual:     number;
    meta_litros:    number;
    consumo_atual:  number;
    alerta:         boolean;
  } | null;
  alerta:           boolean;
  ultimos_7_dias?:  { data_consumo: string; quantidade: number }[];
}

const DICAS_FALLBACK = [
  'Feche a torneira ao escovar os dentes — economize até 12L por vez',
  'Banhos de até 5 min consomem 3× menos água',
  'Reutilize a água do ar-condicionado para regar plantas',
  'Conserte vazamentos: um cano pingando gasta 46L por dia',
];

function dataAtualPtBR(): string {
  return new Date().toLocaleDateString('pt-BR', {
    weekday: 'long', day: 'numeric', month: 'long',
  });
}

export default function DashboardScreen({ navigation }: any) {
  const { usuario } = useAuth();
  const [data,         setData]         = useState<DashboardData | null>(null);
  const [dicas,        setDicas]        = useState<string[]>(DICAS_FALLBACK);
  const [refreshing,   setRefreshing]   = useState(false);
  const [loadingData,  setLoadingData]  = useState(true);

  const fetchDashboard = useCallback(async () => {
    try {
      const [dashRes, dicasRes] = await Promise.allSettled([
        api.get('/api/dashboard'),
        api.get('/api/dicas'),
      ]);

      if (dashRes.status === 'fulfilled') {
        setData(dashRes.value.data);
        if (dashRes.value.data.progresso_meta) {
          const { percentual, meta_litros, consumo_atual } = dashRes.value.data.progresso_meta;
          if (percentual >= 100) {
            await notificarMetaUltrapassada(consumo_atual, meta_litros);
          } else if (percentual >= 90) {
            await notificarMetaAtingida(percentual, meta_litros);
          }
        }
      } else {
        Alert.alert('Erro', 'Não foi possível carregar os dados.');
      }

      if (dicasRes.status === 'fulfilled' && dicasRes.value.data?.dicas?.length > 0) {
        setDicas(dicasRes.value.data.dicas.map((d: any) => d.descricao));
      }
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

  const meta = data?.progresso_meta;
  const metaPct = meta?.percentual ?? 0;

  return (
    <ScrollView
      style={styles.container}
      refreshControl={
        <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[colors.primary[900]]} />
      }
    >
      <StatusBar barStyle="light-content" backgroundColor={colors.primary[900]} />

      {/* ── Cabeçalho ── */}
      <LinearGradient colors={gradients.loginBg} style={styles.header}>
        <View style={styles.headerTop}>
          <View>
            <Text style={styles.greeting}>
              Olá, {usuario?.nome?.split(' ')[0]} 👋
            </Text>
            <Text style={styles.dateText}>{dataAtualPtBR()}</Text>
          </View>
          <EcoButton
            title="Registrar"
            icon="plus"
            variant="secondary"
            onPress={() => navigation.navigate('Consumo')}
            style={styles.headerBtn}
          />
        </View>
      </LinearGradient>

      <View style={styles.body}>

        {/* ── Alerta de meta ── */}
        {meta && metaPct >= 90 ? (
          <EcoAlert
            type={metaPct >= 100 ? 'danger' : 'warning'}
            title={metaPct >= 100 ? 'Meta Ultrapassada!' : 'Atenção — Próximo ao Limite'}
            message={
              metaPct >= 100
                ? `Você consumiu ${formatLitros(meta.consumo_atual)}L de ${formatLitros(meta.meta_litros)}L da sua meta.`
                : `Você já usou ${formatPercent(metaPct)}% da meta mensal (${formatLitros(meta.meta_litros)}L).`
            }
            style={styles.alert}
          />
        ) : null}

        {/* ── KPIs 2×2 ── */}
        <View style={styles.kpiRow}>
          <KpiCard
            icon="water"
            iconBg={colors.kpiCyan.bg}
            iconColor={colors.kpiCyan.icon}
            statusText="Este mês"
            statusType="info"
            label="Consumo do Mês"
            value={`${formatLitros(Number(data?.total_mes_atual ?? 0))} L`}
            subtitle={`Hoje: ${formatLitros(Number(data?.consumo_hoje ?? 0))} L`}
          />
          <KpiCard
            icon="chart-line"
            iconBg={colors.kpiPurple.bg}
            iconColor={colors.kpiPurple.icon}
            statusText="Projeção"
            statusType="warning"
            label="Projeção do Mês"
            value={`${formatLitros(Number(data?.projecao_mensal ?? 0))} L`}
            subtitle="Baseado no consumo atual"
          />
        </View>

        <View style={styles.kpiRow}>
          <KpiCard
            icon="file-document-outline"
            iconBg={colors.kpiGreen.bg}
            iconColor={colors.kpiGreen.icon}
            statusText="Registrada"
            statusType="success"
            label="Última Fatura"
            value={data?.ultima_fatura ? `R$ ${formatReais(Number(data.ultima_fatura.valor))}` : '—'}
            subtitle="Fatura mais recente"
          />
          <KpiCard
            icon="bullseye-arrow"
            iconBg={colors.kpiAmber.bg}
            iconColor={colors.kpiAmber.icon}
            statusText={`${formatPercent(metaPct)}%`}
            statusType={metaPct >= 100 ? 'danger' : metaPct >= 80 ? 'warning' : 'success'}
            label="Meta do Mês"
            value={meta ? `${formatLitros(meta.consumo_atual)} L` : '—'}
            subtitle={meta ? `Meta: ${formatLitros(meta.meta_litros)} L` : 'Sem meta definida'}
            progress={metaPct}
          />
        </View>

        {/* ── Estatísticas Rápidas ── */}
        <EcoCard style={styles.section}>
          <Text style={styles.sectionTitle}>Estatísticas Rápidas</Text>
          <View style={styles.statsGrid}>
            <View style={[styles.statCard, { backgroundColor: colors.primary[50] }]}>
              <Text style={[styles.statValue, { color: colors.primary[900] }]}>
                {formatLitros(Number(data?.total_mes_atual ?? 0))} L
              </Text>
              <Text style={styles.statLabel}>Total no Mês</Text>
            </View>
            <View style={[styles.statCard, { backgroundColor: colors.success[50] }]}>
              <Text style={[styles.statValue, { color: colors.success[700] }]}>
                {(data?.variacao_percent ?? 0) > 0 ? '+' : ''}{formatPercent(data?.variacao_percent ?? 0)}%
              </Text>
              <Text style={styles.statLabel}>Variação</Text>
            </View>
            <View style={[styles.statCard, { backgroundColor: colors.kpiPurple.bg }]}>
              <Text style={[styles.statValue, { color: colors.kpiPurple.icon }]}>
                {formatLitros(Number(data?.projecao_mensal ?? 0))} L
              </Text>
              <Text style={styles.statLabel}>Projeção</Text>
            </View>
          </View>
        </EcoCard>

        {/* ── Gráfico 7 dias ── */}
        {data?.ultimos_7_dias && data.ultimos_7_dias.length > 0 ? (
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Consumo — Últimos 7 dias</Text>
            <LineChart
              data={[...data.ultimos_7_dias].reverse().map((item) => ({
                value: Number(item.quantidade) || 0,
                label: item.data_consumo?.slice(5) || '',
              }))}
              width={300}
              height={160}
              color={colors.primary[700]}
              thickness={2}
              dataPointsColor={colors.primary[900]}
              startFillColor={colors.primary[100]}
              endFillColor={colors.white}
              areaChart
              curved
              hideRules
              xAxisColor={colors.slate[200]}
              yAxisColor={colors.slate[200]}
              yAxisTextStyle={{ color: colors.slate[400], fontSize: 10 }}
              xAxisLabelTextStyle={{ color: colors.slate[400], fontSize: 9 }}
              noOfSections={4}
              maxValue={
                Math.max(...data.ultimos_7_dias.map((i) => Number(i.quantidade) || 0)) * 1.2 || 100
              }
            />
          </EcoCard>
        ) : null}

        {/* ── Dicas de Economia ── */}
        <EcoCard style={[styles.section, styles.lastSection]}>
          <Text style={styles.sectionTitle}>💡 Dicas de Economia</Text>
          {dicas.map((dica, i) => (
            <View key={i} style={styles.dicaRow}>
              <Text style={styles.dicaIcon}>✅</Text>
              <Text style={styles.dicaText}>{dica}</Text>
            </View>
          ))}
        </EcoCard>

      </View>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: colors.background },

  // Cabeçalho
  header: {
    paddingTop:        52,
    paddingBottom:     spacing['2xl'],
    paddingHorizontal: spacing['2xl'],
  },
  headerTop: {
    flexDirection:  'row',
    justifyContent: 'space-between',
    alignItems:     'center',
  },
  greeting: {
    fontSize:   typography.sizes['2xl'],
    fontWeight: '700',
    color:      colors.white,
  },
  dateText: {
    fontSize:  typography.sizes.sm,
    color:     'rgba(255,255,255,0.75)',
    marginTop: spacing.xs,
    textTransform: 'capitalize',
  },
  headerBtn: {
    paddingVertical:   8,
    paddingHorizontal: spacing.lg,
    backgroundColor:   'rgba(255,255,255,0.15)',
    borderColor:       'rgba(255,255,255,0.5)',
  },

  body: { padding: spacing.lg },

  // Alerta
  alert: { marginBottom: spacing.lg },

  // KPIs
  kpiRow: {
    flexDirection:  'row',
    gap:            spacing.md,
    marginBottom:   spacing.md,
  },

  // Seções
  section: {
    marginBottom: spacing.lg,
    padding:      spacing['2xl'],
  },
  lastSection: { marginBottom: spacing['4xl'] },
  sectionTitle: {
    fontSize:     typography.sizes.lg,
    fontWeight:   '700',
    color:        colors.slate[800],
    marginBottom: spacing.lg,
  },

  // Estatísticas rápidas
  statsGrid: {
    flexDirection: 'row',
    gap:           spacing.md,
  },
  statCard: {
    flex:          1,
    borderRadius:  borderRadius.md,
    padding:       spacing.md,
    alignItems:    'center',
  },
  statValue: {
    fontSize:   typography.sizes.lg,
    fontWeight: '700',
    marginBottom: spacing.xs,
  },
  statLabel: {
    fontSize:   typography.sizes.xs,
    color:      colors.slate[500],
    textAlign:  'center',
  },

  // Dicas
  dicaRow: {
    flexDirection: 'row',
    alignItems:    'flex-start',
    gap:           spacing.md,
    marginBottom:  spacing.md,
  },
  dicaIcon: { fontSize: 14, marginTop: 1 },
  dicaText: {
    flex:       1,
    fontSize:   typography.sizes.sm,
    color:      colors.slate[700],
    lineHeight: 20,
  },
});
