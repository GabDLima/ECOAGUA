import React, { useState, useCallback, useEffect } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import {
  View, Text, StyleSheet, ScrollView, TouchableOpacity,
  Alert, RefreshControl, KeyboardAvoidingView, Platform, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import MaterialCommunityIcons from 'react-native-vector-icons/MaterialCommunityIcons';
import api from '../api/api';
import EcoCard from '../components/EcoCard';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import EcoBadge from '../components/EcoBadge';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';

const TIPOS   = ['Banho', 'Cozinha', 'Lavanderia', 'Jardim', 'Outros'];
const UNIDADES = ['L', 'mL', 'm³'];

type Section = 'consumo' | 'fatura' | 'meta' | null;

interface HistoricoItem {
  data_consumo: string;
  tipo:         string;
  quantidade:   number;
  unidade:      string;
}

export default function ConsumoScreen() {
  // Seção ativa
  const [activeSection, setActiveSection] = useState<Section>('consumo');

  // Campos — Consumo
  const [quantidade, setQuantidade] = useState('');
  const [unidade,    setUnidade]    = useState('L');
  const [tipo,       setTipo]       = useState('Banho');

  // Carregar unidade padrão do AsyncStorage
  useEffect(() => {
    AsyncStorage.getItem('@ecoagua:unidade_padrao').then(val => {
      if (val && UNIDADES.includes(val)) setUnidade(val);
    });
  }, []);
  const [dataConsumo, setDataConsumo] = useState(
    new Date().toISOString().split('T')[0]
  );

  // Campos — Fatura
  const [mes,   setMes]   = useState('');
  const [valor, setValor] = useState('');

  // Campos — Meta
  const [metaMensal,  setMetaMensal]  = useState('');
  const [metaReducao, setMetaReducao] = useState('');
  const [prazo,       setPrazo]       = useState('');

  // Estado
  const [historico,  setHistorico]  = useState<HistoricoItem[]>([]);
  const [refreshing, setRefreshing] = useState(false);
  const [saving,     setSaving]     = useState(false);

  const fetchHistorico = useCallback(async () => {
    try {
      // GET /api/consumo
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

  function toggle(section: Section) {
    setActiveSection((prev) => (prev === section ? null : section));
  }

  // ── Salvar consumo ──────────────────────────────────────────────────────────
  async function handleSalvarConsumo() {
    const qtd = parseFloat(quantidade);
    if (!quantidade || isNaN(qtd) || qtd <= 0) {
      Alert.alert('Atenção', 'Informe uma quantidade válida.');
      return;
    }
    setSaving(true);
    try {
      // POST /api/consumo
      await api.post('/api/consumo', {
        data_consumo: dataConsumo,
        quantidade: qtd,
        unidade,
        tipo,
      });
      Alert.alert('Sucesso', 'Consumo registrado!');
      setQuantidade('');
      fetchHistorico();
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar o consumo.');
    } finally {
      setSaving(false);
    }
  }

  // ── Salvar fatura ───────────────────────────────────────────────────────────
  async function handleSalvarFatura() {
    if (!mes || !valor) { Alert.alert('Atenção', 'Preencha mês e valor.'); return; }
    const valorNum = parseFloat(valor.replace(',', '.'));
    if (isNaN(valorNum) || valorNum <= 0) { Alert.alert('Atenção', 'Valor inválido.'); return; }
    setSaving(true);
    try {
      // POST /api/faturas
      await api.post('/api/faturas', { mes_da_fatura: mes, valor: valorNum });
      Alert.alert('Sucesso', 'Fatura registrada!');
      setMes(''); setValor('');
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar a fatura.');
    } finally {
      setSaving(false);
    }
  }

  // ── Salvar meta ─────────────────────────────────────────────────────────────
  async function handleSalvarMeta() {
    if (!metaMensal || !metaReducao || !prazo) {
      Alert.alert('Atenção', 'Preencha todos os campos.');
      return;
    }
    const mensal  = parseInt(metaMensal, 10);
    const reducao = parseInt(metaReducao, 10);
    const prazoN  = parseInt(prazo, 10);
    if (isNaN(mensal) || mensal <= 0)    { Alert.alert('Atenção', 'Meta mensal inválida.');    return; }
    if (isNaN(reducao) || reducao <= 0 || reducao > 100) { Alert.alert('Atenção', 'Redução deve ser 1–100%.'); return; }
    if (isNaN(prazoN) || prazoN <= 0)   { Alert.alert('Atenção', 'Prazo inválido.');           return; }
    setSaving(true);
    try {
      // POST /api/metas
      await api.post('/api/metas', { meta_mensal: mensal, meta_reducao: reducao, prazo: prazoN });
      Alert.alert('Sucesso', 'Meta criada!');
      setMetaMensal(''); setMetaReducao(''); setPrazo('');
    } catch {
      Alert.alert('Erro', 'Não foi possível criar a meta.');
    } finally {
      setSaving(false);
    }
  }

  // ── Renderizar chip ─────────────────────────────────────────────────────────
  function renderChips(options: string[], selected: string, onSelect: (v: string) => void) {
    return (
      <View style={styles.chips}>
        {options.map((opt) => (
          <TouchableOpacity
            key={opt}
            style={[styles.chip, selected === opt && styles.chipActive]}
            onPress={() => onSelect(opt)}
          >
            <Text style={[styles.chipText, selected === opt && styles.chipTextActive]}>{opt}</Text>
          </TouchableOpacity>
        ))}
      </View>
    );
  }

  // ── Renderizar cabeçalho de seção expansível ────────────────────────────────
  function SectionHeader({
    id, icon, title, subtitle, color,
  }: { id: Section; icon: string; title: string; subtitle: string; color: string }) {
    const open = activeSection === id;
    return (
      <TouchableOpacity
        style={[styles.sectionHeader, open && { borderBottomLeftRadius: 0, borderBottomRightRadius: 0 }]}
        onPress={() => toggle(id)}
        activeOpacity={0.85}
      >
        <View style={[styles.sectionIconCircle, { backgroundColor: color + '20' }]}>
          <MaterialCommunityIcons name={icon} size={22} color={color} />
        </View>
        <View style={styles.sectionHeaderText}>
          <Text style={styles.sectionHeaderTitle}>{title}</Text>
          <Text style={styles.sectionHeaderSub}>{subtitle}</Text>
        </View>
        <MaterialCommunityIcons
          name={open ? 'chevron-up' : 'chevron-down'}
          size={22}
          color={colors.slate[400]}
        />
      </TouchableOpacity>
    );
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

        {/* ── Header ── */}
        <LinearGradient colors={gradients.loginBg} style={styles.header}>
          <Text style={styles.headerTitle}>Registros</Text>
          <Text style={styles.headerSub}>Gerencie faturas, metas e consumo</Text>
        </LinearGradient>

        <View style={styles.body}>

          {/* ── Seção: Consumo ── */}
          <View style={styles.expandable}>
            <SectionHeader
              id="consumo"
              icon="water"
              title="Registrar Consumo"
              subtitle="Adicionar consumo de água"
              color={colors.kpiCyan.icon}
            />
            {activeSection === 'consumo' && (
              <EcoCard style={styles.expandBody}>
                <EcoInput
                  label="Data"
                  icon="calendar-outline"
                  placeholder="YYYY-MM-DD"
                  value={dataConsumo}
                  onChangeText={setDataConsumo}
                />
                <Text style={styles.fieldLabel}>Tipo de uso</Text>
                {renderChips(TIPOS, tipo, setTipo)}

                <EcoInput
                  label="Quantidade"
                  icon="water-outline"
                  placeholder="0"
                  value={quantidade}
                  onChangeText={setQuantidade}
                  keyboardType="numeric"
                />
                <Text style={styles.fieldLabel}>Unidade</Text>
                {renderChips(UNIDADES, unidade, setUnidade)}

                <EcoButton
                  title="Registrar Consumo"
                  icon="check"
                  variant="primary"
                  onPress={handleSalvarConsumo}
                  loading={saving}
                  fullWidth
                  style={styles.saveBtn}
                />
              </EcoCard>
            )}
          </View>

          {/* ── Seção: Fatura ── */}
          <View style={styles.expandable}>
            <SectionHeader
              id="fatura"
              icon="receipt"
              title="Registrar Fatura"
              subtitle="Adicionar fatura mensal"
              color={colors.kpiGreen.icon}
            />
            {activeSection === 'fatura' && (
              <EcoCard style={styles.expandBody}>
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
                  title="Salvar Fatura"
                  icon="check"
                  variant="success"
                  onPress={handleSalvarFatura}
                  loading={saving}
                  fullWidth
                  style={styles.saveBtn}
                />
              </EcoCard>
            )}
          </View>

          {/* ── Seção: Meta ── */}
          <View style={styles.expandable}>
            <SectionHeader
              id="meta"
              icon="bullseye-arrow"
              title="Definir Meta"
              subtitle="Criar nova meta mensal"
              color={colors.kpiAmber.icon}
            />
            {activeSection === 'meta' && (
              <EcoCard style={styles.expandBody}>
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
                  onPress={handleSalvarMeta}
                  loading={saving}
                  fullWidth
                  style={styles.saveBtn}
                />
              </EcoCard>
            )}
          </View>

          {/* ── Histórico de Consumo ── */}
          <EcoCard style={[styles.section, styles.lastSection]}>
            <Text style={styles.sectionTitle}>Dados Registrados</Text>
            <View style={styles.tableHeader}>
              <Text style={[styles.tableHeaderCell, { flex: 2 }]}>DATA</Text>
              <Text style={[styles.tableHeaderCell, { flex: 2 }]}>TIPO</Text>
              <Text style={[styles.tableHeaderCell, { flex: 1, textAlign: 'right' }]}>QTD</Text>
            </View>
            {historico.length === 0 ? (
              <Text style={styles.emptyText}>Nenhum registro encontrado.</Text>
            ) : (
              historico.map((item, i) => (
                <View key={i} style={styles.tableRow}>
                  <Text style={[styles.tableCell, { flex: 2 }]}>{item.data_consumo}</Text>
                  <View style={{ flex: 2 }}>
                    <EcoBadge text={item.tipo} type="info" />
                  </View>
                  <Text style={[styles.tableCell, styles.tableCellRight, { flex: 1 }]}>
                    {item.quantidade} {item.unidade}
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
  headerTitle: {
    fontSize:   typography.sizes['2xl'],
    fontWeight: '700',
    color:      colors.white,
  },
  headerSub: {
    fontSize:  typography.sizes.sm,
    color:     'rgba(255,255,255,0.75)',
    marginTop: spacing.xs,
  },

  body: { padding: spacing.lg },

  // Seções expansíveis
  expandable:  { marginBottom: spacing.md },
  sectionHeader: {
    flexDirection:     'row',
    alignItems:        'center',
    backgroundColor:   colors.white,
    borderRadius:      borderRadius.md,
    padding:           spacing.lg,
    borderWidth:       1,
    borderColor:       colors.slate[100],
    gap:               spacing.md,
    shadowColor:       '#000',
    shadowOffset:      { width: 0, height: 1 },
    shadowOpacity:     0.06,
    shadowRadius:      3,
    elevation:         2,
  },
  sectionIconCircle: {
    width:          44,
    height:         44,
    borderRadius:   22,
    justifyContent: 'center',
    alignItems:     'center',
  },
  sectionHeaderText:  { flex: 1 },
  sectionHeaderTitle: { fontSize: typography.sizes.base, fontWeight: '600', color: colors.slate[800] },
  sectionHeaderSub:   { fontSize: typography.sizes.xs, color: colors.slate[400], marginTop: 2 },
  expandBody: {
    borderTopLeftRadius:  0,
    borderTopRightRadius: 0,
    borderTopWidth:       0,
    padding:              spacing['2xl'],
  },

  // Chips
  fieldLabel: {
    fontSize:     typography.sizes.sm,
    fontWeight:   '600',
    color:        colors.slate[700],
    marginBottom: spacing.sm,
  },
  chips: {
    flexDirection:  'row',
    flexWrap:       'wrap',
    gap:            spacing.sm,
    marginBottom:   spacing.lg,
  },
  chip: {
    paddingHorizontal: spacing.md,
    paddingVertical:   6,
    borderRadius:      borderRadius.full,
    borderWidth:       1.5,
    borderColor:       colors.slate[300],
    backgroundColor:   colors.white,
  },
  chipActive:    { backgroundColor: colors.primary[900], borderColor: colors.primary[900] },
  chipText:      { fontSize: typography.sizes.sm, color: colors.slate[500], fontWeight: '500' },
  chipTextActive: { color: colors.white, fontWeight: '600' },
  saveBtn: { marginTop: spacing.lg },

  // Histórico / Tabela
  section: { marginBottom: spacing.lg, padding: spacing['2xl'] },
  lastSection: { marginBottom: spacing['4xl'] },
  sectionTitle: {
    fontSize:     typography.sizes.lg,
    fontWeight:   '700',
    color:        colors.slate[800],
    marginBottom: spacing.lg,
  },
  tableHeader: {
    flexDirection:   'row',
    paddingVertical: spacing.sm,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[200],
    marginBottom:    spacing.sm,
  },
  tableHeaderCell: {
    fontSize:      typography.sizes.xs,
    fontWeight:    '600',
    color:         colors.slate[400],
    letterSpacing: 0.5,
  },
  tableRow: {
    flexDirection: 'row',
    alignItems:    'center',
    paddingVertical: spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[100],
  },
  tableCell: { fontSize: typography.sizes.sm, color: colors.slate[700] },
  tableCellRight: { textAlign: 'right', fontWeight: '600', color: colors.success[700] },
  emptyText: {
    textAlign:       'center',
    color:           colors.slate[400],
    fontSize:        typography.sizes.sm,
    paddingVertical: spacing.xl,
  },
});
