import React, { useState, useCallback } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import {
  View, Text, StyleSheet, ScrollView, Alert, RefreshControl,
  KeyboardAvoidingView, Platform, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import api from '../api/api';
import Loading from '../components/Loading';
import EcoCard from '../components/EcoCard';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import EcoAlert from '../components/EcoAlert';
import KpiCard from '../components/KpiCard';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';
import { notificarMetaAtingida, notificarMetaUltrapassada } from '../services/NotificationService';

interface Meta {
  meta_mensal?:  number;
  meta_reducao?: number;
  prazo?:        number;
}

interface Progresso {
  percentual:    number;
  meta_litros:   number;
  consumo_atual: number;
  alerta:        boolean;
}

export default function MetasScreen() {
  const [meta,         setMeta]         = useState<Meta | null>(null);
  const [progresso,    setProgresso]    = useState<Progresso | null>(null);
  const [loadingData,  setLoadingData]  = useState(true);
  const [refreshing,   setRefreshing]   = useState(false);
  const [showForm,     setShowForm]     = useState(false);
  const [saving,       setSaving]       = useState(false);

  // Campos formulário
  const [metaMensal,  setMetaMensal]  = useState('');
  const [metaReducao, setMetaReducao] = useState('');
  const [prazo,       setPrazo]       = useState('');

  const fetchMetas = useCallback(async () => {
    try {
      // GET /api/metas
      const res = await api.get('/api/metas');
      setMeta(res.data.meta ?? null);
      setProgresso(res.data.progresso ?? null);

      if (res.data.progresso) {
        const { percentual, meta_litros, consumo_atual } = res.data.progresso;
        if (percentual >= 100) {
          await notificarMetaUltrapassada(consumo_atual, meta_litros);
        } else if (percentual >= 90) {
          await notificarMetaAtingida(percentual, meta_litros);
        }
      }
    } catch {
      Alert.alert('Erro', 'Não foi possível carregar as metas.');
    } finally {
      setLoadingData(false);
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchMetas(); }, [fetchMetas]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchMetas();
    setRefreshing(false);
  }, [fetchMetas]);

  async function handleSalvar() {
    const mensal  = parseInt(metaMensal, 10);
    const reducao = parseInt(metaReducao, 10);
    const prazoN  = parseInt(prazo, 10);
    if (!metaMensal || !metaReducao || !prazo) { Alert.alert('Atenção', 'Preencha todos os campos.'); return; }
    if (isNaN(mensal) || mensal <= 0)    { Alert.alert('Atenção', 'Meta mensal deve ser um número positivo.'); return; }
    if (isNaN(reducao) || reducao <= 0 || reducao > 100) { Alert.alert('Atenção', 'Redução deve ser entre 1% e 100%.'); return; }
    if (isNaN(prazoN) || prazoN <= 0)   { Alert.alert('Atenção', 'Prazo inválido.'); return; }
    setSaving(true);
    try {
      // POST /api/metas
      await api.post('/api/metas', { meta_mensal: mensal, meta_reducao: reducao, prazo: prazoN });
      Alert.alert('Sucesso', 'Meta criada!');
      setMetaMensal(''); setMetaReducao(''); setPrazo('');
      setShowForm(false);
      fetchMetas();
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar.');
    } finally {
      setSaving(false);
    }
  }

  if (loadingData) return <Loading />;

  const pct       = progresso?.percentual ?? 0;
  const metaL     = progresso?.meta_litros ?? 0;
  const consumoL  = progresso?.consumo_atual ?? 0;
  const restante  = Math.max(0, metaL - consumoL);
  const economia  = meta?.meta_reducao ?? 0;

  function statusLabel(): string {
    if (!progresso) return 'Sem meta';
    if (pct >= 100) return 'Excedida';
    if (pct >= 80)  return 'Próximo';
    return 'OK';
  }
  function statusType(): 'success' | 'info' | 'warning' | 'danger' {
    if (!progresso) return 'info';
    if (pct >= 100) return 'danger';
    if (pct >= 80)  return 'warning';
    return 'success';
  }

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
          <Text style={styles.headerTitle}>Metas de Consumo</Text>
          <Text style={styles.headerSub}>Acompanhe seu progresso mensal</Text>
        </LinearGradient>

        <View style={styles.body}>

          {/* ── KPIs 2×2 ── */}
          <View style={styles.kpiRow}>
            <KpiCard
              icon="bullseye-arrow"
              iconBg={colors.kpiAmber.bg}
              iconColor={colors.kpiAmber.icon}
              label="Meta Atual"
              value={metaL > 0 ? `${metaL} L` : '—'}
              subtitle={`Redução: ${economia}%`}
              statusText={meta ? 'Ativa' : 'Sem meta'}
              statusType={meta ? 'success' : 'info'}
            />
            <KpiCard
              icon="water"
              iconBg={colors.kpiCyan.bg}
              iconColor={colors.kpiCyan.icon}
              label="Consumido"
              value={consumoL > 0 ? `${consumoL} L` : '—'}
              subtitle={pct > 0 ? `${pct}% da meta` : '—'}
              statusText={pct > 0 ? `${pct}%` : '—'}
              statusType={statusType()}
            />
          </View>

          <View style={styles.kpiRow}>
            <KpiCard
              icon="leaf"
              iconBg={colors.kpiGreen.bg}
              iconColor={colors.kpiGreen.icon}
              label="Economia Esperada"
              value={metaL > 0 ? `${Math.round(metaL * (economia / 100))} L` : '—'}
              subtitle="Economia mensal esperada"
              statusText="Projeção"
              statusType="info"
            />
            <KpiCard
              icon="shield-check-outline"
              iconBg={pct >= 100 ? colors.kpiRed.bg : colors.kpiGreen.bg}
              iconColor={pct >= 100 ? colors.kpiRed.icon : colors.kpiGreen.icon}
              label="Status Geral"
              value={statusLabel()}
              subtitle={pct > 0 ? `${pct}% utilizado` : 'Sem dados'}
              statusText={statusLabel()}
              statusType={statusType()}
            />
          </View>

          {/* ── Alerta ── */}
          {progresso && pct >= 90 ? (
            <EcoAlert
              type={pct >= 100 ? 'danger' : 'warning'}
              title={pct >= 100 ? 'Meta Excedida!' : 'Atenção — Próximo ao Limite'}
              message={
                pct >= 100
                  ? `Você consumiu ${consumoL}L, ultrapassando a meta de ${metaL}L.`
                  : `Você está a ${100 - pct}% de atingir sua meta mensal!`
              }
              style={styles.alert}
            />
          ) : progresso && pct < 80 ? (
            <EcoAlert
              type="success"
              title="Dentro da Meta"
              message={`Você consumiu ${consumoL}L de ${metaL}L. Ainda tem ${restante}L disponíveis.`}
              style={styles.alert}
            />
          ) : null}

          {/* ── Progresso detalhado ── */}
          {progresso ? (
            <EcoCard style={styles.section}>
              <Text style={styles.sectionTitle}>Progresso da Meta Atual</Text>

              <View style={styles.progressMiniCards}>
                {[
                  { label: 'Meta', value: `${metaL} L`,     color: colors.primary[900] },
                  { label: 'Consumido', value: `${consumoL} L`, color: pct >= 100 ? colors.danger[600] : colors.warning[600] },
                  { label: 'Restante',  value: `${restante} L`, color: colors.success[700] },
                ].map((item) => (
                  <View key={item.label} style={[styles.miniCard, { backgroundColor: colors.slate[50] }]}>
                    <Text style={[styles.miniCardValue, { color: item.color }]}>{item.value}</Text>
                    <Text style={styles.miniCardLabel}>{item.label}</Text>
                  </View>
                ))}
              </View>

              {/* Barra de progresso */}
              <View style={styles.progressTrack}>
                <LinearGradient
                  colors={pct >= 100 ? gradients.danger : pct >= 80 ? [colors.warning[600], colors.warning[500]] : gradients.success}
                  start={{ x: 0, y: 0 }}
                  end={{ x: 1, y: 0 }}
                  style={[styles.progressFill, { width: `${Math.min(pct, 100)}%` as any }]}
                />
              </View>
              <Text style={styles.progressPct}>{pct}% utilizado</Text>
            </EcoCard>
          ) : null}

          {/* ── Nova Meta ── */}
          <EcoButton
            title={showForm ? 'Cancelar' : '+ Nova Meta'}
            variant={showForm ? 'secondary' : 'primary'}
            icon={showForm ? 'close' : 'plus'}
            onPress={() => setShowForm((v) => !v)}
            fullWidth
            style={styles.newMetaBtn}
          />

          {showForm ? (
            <EcoCard style={styles.section}>
              <Text style={styles.sectionTitle}>Nova Meta</Text>
              <EcoInput
                label="Meta mensal (litros)"
                icon="water-outline"
                placeholder="Ex: 5000"
                value={metaMensal}
                onChangeText={setMetaMensal}
                keyboardType="numeric"
              />
              <EcoInput
                label="Redução desejada (%)"
                icon="trending-down"
                placeholder="Ex: 10"
                value={metaReducao}
                onChangeText={setMetaReducao}
                keyboardType="numeric"
              />
              <EcoInput
                label="Prazo (meses)"
                icon="clock-outline"
                placeholder="Ex: 3"
                value={prazo}
                onChangeText={setPrazo}
                keyboardType="numeric"
              />
              <EcoButton
                title="Criar Meta"
                icon="check"
                variant="success"
                onPress={handleSalvar}
                loading={saving}
                fullWidth
              />
            </EcoCard>
          ) : null}

          <View style={styles.bottomSpacer} />
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

  kpiRow: { flexDirection: 'row', gap: spacing.md, marginBottom: spacing.md },

  alert: { marginBottom: spacing.lg },

  section: { marginBottom: spacing.lg, padding: spacing['2xl'] },
  sectionTitle: {
    fontSize:     typography.sizes.lg,
    fontWeight:   '700',
    color:        colors.slate[800],
    marginBottom: spacing.lg,
  },

  // Mini cards de progresso
  progressMiniCards: { flexDirection: 'row', gap: spacing.md, marginBottom: spacing.lg },
  miniCard: {
    flex:          1,
    borderRadius:  borderRadius.md,
    padding:       spacing.md,
    alignItems:    'center',
  },
  miniCardValue: { fontSize: typography.sizes.base, fontWeight: '700', marginBottom: spacing.xs },
  miniCardLabel: { fontSize: typography.sizes.xs, color: colors.slate[500] },

  // Barra de progresso
  progressTrack: {
    height:          10,
    backgroundColor: colors.slate[200],
    borderRadius:    5,
    overflow:        'hidden',
    marginBottom:    spacing.sm,
  },
  progressFill: { height: '100%', borderRadius: 5 },
  progressPct: {
    fontSize:  typography.sizes.sm,
    color:     colors.slate[500],
    textAlign: 'right',
  },

  newMetaBtn:   { marginBottom: spacing.lg },
  bottomSpacer: { height: spacing['4xl'] },
});
