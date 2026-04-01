import React, { useState, useEffect } from 'react';
import {
  View, Text, StyleSheet, ScrollView, Alert,
  KeyboardAvoidingView, Platform, Switch, TouchableOpacity, StatusBar,
} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import LinearGradient from 'react-native-linear-gradient';
import { useAuth } from '../contexts/AuthContext';
import { useTheme } from '../theme/ThemeContext';
import api from '../api/api';
import EcoCard from '../components/EcoCard';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import EcoAlert from '../components/EcoAlert';
import {
  agendarLembreteFatura,
  cancelarLembreteFatura,
  agendarDicaSemanal,
  cancelarDicaSemanal,
} from '../services/NotificationService';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';

const UNIDADES = ['L', 'mL', 'm³'];

export default function PerfilScreen() {
  const { usuario, logout } = useAuth();
  const { isDark, setDarkMode, bg, cardBg, textPrimary, textSecondary, borderColor } = useTheme();

  // Dados pessoais
  const [nome,  setNome]  = useState(usuario?.nome  ?? '');
  const [email, setEmail] = useState(usuario?.email ?? '');
  const [savingPerfil, setSavingPerfil] = useState(false);

  // Segurança
  const [senhaAtual,     setSenhaAtual]     = useState('');
  const [novaSenha,      setNovaSenha]      = useState('');
  const [confirmarSenha, setConfirmarSenha] = useState('');
  const [savingSenha,    setSavingSenha]    = useState(false);

  // Preferências de notificação
  const [notifMeta,   setNotifMeta]   = useState(true);
  const [notifFatura, setNotifFatura] = useState(true);
  const [notifDica,   setNotifDica]   = useState(false);

  // Preferências gerais
  const [unidadePadrao, setUnidadePadrao] = useState('L');
  const [loadingPrefs,  setLoadingPrefs]  = useState(true);

  // ── Carregar preferências do banco ao montar ─────────────────────────────

  useEffect(() => {
    loadPreferencias();
  }, []);

  async function loadPreferencias() {
    try {
      const res = await api.get('/api/preferencias');
      const prefs = res.data.preferencias;
      setNotifMeta(!!prefs.notif_alerta_meta);
      setNotifFatura(!!prefs.notif_lembrete_fatura);
      setNotifDica(!!prefs.notif_dicas);
      setUnidadePadrao(prefs.unidade_padrao ?? 'L');
      const darkVal = !!prefs.dark_mode;
      await setDarkMode(darkVal);
      await AsyncStorage.setItem('@ecoagua:unidade_padrao', prefs.unidade_padrao ?? 'L');
    } catch {
      // Silently use local defaults
    } finally {
      setLoadingPrefs(false);
    }
  }

  async function salvarPreferencias(
    alertaMeta: boolean,
    lembreteFatura: boolean,
    dicas: boolean,
    unidade: string,
    darkModeVal: boolean,
  ) {
    try {
      await api.post('/api/preferencias', {
        notif_alerta_meta:     alertaMeta     ? 1 : 0,
        notif_lembrete_fatura: lembreteFatura ? 1 : 0,
        notif_dicas:           dicas          ? 1 : 0,
        unidade_padrao:        unidade,
        dark_mode:             darkModeVal    ? 1 : 0,
      });
    } catch {
      // Silently fail
    }
  }

  // ── Handlers de toggle ───────────────────────────────────────────────────

  async function handleNotifMetaChange(val: boolean) {
    setNotifMeta(val);
    await salvarPreferencias(val, notifFatura, notifDica, unidadePadrao, isDark);
  }

  async function handleNotifFaturaChange(val: boolean) {
    setNotifFatura(val);
    if (val) {
      await agendarLembreteFatura();
    } else {
      await cancelarLembreteFatura();
    }
    await salvarPreferencias(notifMeta, val, notifDica, unidadePadrao, isDark);
  }

  async function handleNotifDicaChange(val: boolean) {
    setNotifDica(val);
    if (val) {
      await agendarDicaSemanal();
    } else {
      await cancelarDicaSemanal();
    }
    await salvarPreferencias(notifMeta, notifFatura, val, unidadePadrao, isDark);
  }

  async function handleUnidadeChange(u: string) {
    setUnidadePadrao(u);
    await AsyncStorage.setItem('@ecoagua:unidade_padrao', u);
    await salvarPreferencias(notifMeta, notifFatura, notifDica, u, isDark);
  }

  async function handleDarkModeChange(val: boolean) {
    await setDarkMode(val);
    await salvarPreferencias(notifMeta, notifFatura, notifDica, unidadePadrao, val);
  }

  // ── Perfil e senha ───────────────────────────────────────────────────────

  async function handleSalvarPerfil() {
    if (!nome || !email) { Alert.alert('Atenção', 'Nome e email são obrigatórios.'); return; }
    if (!email.includes('@')) { Alert.alert('Atenção', 'Email inválido.'); return; }
    setSavingPerfil(true);
    try {
      await api.post('/editarusuario', { nome, email });
      Alert.alert('Sucesso', 'Perfil atualizado!');
    } catch {
      Alert.alert('Erro', 'Não foi possível atualizar o perfil.');
    } finally {
      setSavingPerfil(false);
    }
  }

  async function handleAlterarSenha() {
    if (!senhaAtual || !novaSenha || !confirmarSenha) {
      Alert.alert('Atenção', 'Preencha todos os campos.'); return;
    }
    if (novaSenha !== confirmarSenha) { Alert.alert('Atenção', 'As senhas não coincidem.'); return; }
    if (novaSenha.length < 6) { Alert.alert('Atenção', 'A nova senha deve ter pelo menos 6 caracteres.'); return; }
    setSavingSenha(true);
    try {
      await api.post('/alterasenha', {
        senha_atual:     senhaAtual,
        nova_senha:      novaSenha,
        confirmar_senha: confirmarSenha,
      });
      Alert.alert('Sucesso', 'Senha alterada!');
      setSenhaAtual(''); setNovaSenha(''); setConfirmarSenha('');
    } catch {
      Alert.alert('Erro', 'Não foi possível alterar a senha.');
    } finally {
      setSavingSenha(false);
    }
  }

  const inicial = (usuario?.nome?.charAt(0) ?? 'U').toUpperCase();

  return (
    <KeyboardAvoidingView style={{ flex: 1 }} behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
      <ScrollView style={[styles.container, { backgroundColor: bg }]} keyboardShouldPersistTaps="handled">
        <StatusBar barStyle="light-content" backgroundColor={colors.primary[900]} />

        {/* ── Banner ── */}
        <LinearGradient colors={gradients.loginBg} style={styles.banner}>
          <View style={styles.avatar}>
            <Text style={styles.avatarText}>{inicial}</Text>
          </View>
          <Text style={styles.bannerName}>{usuario?.nome}</Text>
          <Text style={styles.bannerEmail}>{usuario?.email}</Text>
          <Text style={styles.bannerMembro}>Membro EcoÁgua</Text>
        </LinearGradient>

        <View style={styles.body}>

          {/* ── Dados Pessoais ── */}
          <EcoCard style={[styles.section, { backgroundColor: cardBg }]}>
            <Text style={[styles.sectionTitle, { color: textPrimary }]}>Dados Pessoais</Text>
            <EcoInput
              label="Nome completo"
              icon="account-outline"
              placeholder="Seu nome"
              value={nome}
              onChangeText={setNome}
              autoCapitalize="words"
            />
            <EcoInput
              label="Email"
              icon="email-outline"
              placeholder="seu@email.com"
              value={email}
              onChangeText={setEmail}
              keyboardType="email-address"
              autoCapitalize="none"
            />
            <EcoButton
              title="Salvar Alterações"
              icon="content-save-outline"
              variant="primary"
              onPress={handleSalvarPerfil}
              loading={savingPerfil}
              fullWidth
            />
          </EcoCard>

          {/* ── Segurança ── */}
          <EcoCard style={[styles.section, { backgroundColor: cardBg }]}>
            <Text style={[styles.sectionTitle, { color: textPrimary }]}>Segurança</Text>
            <EcoAlert
              type="warning"
              title="Senha"
              message="Mantenha sua conta protegida com uma senha forte e única."
              style={styles.alert}
            />
            <EcoInput
              label="Senha atual"
              icon="lock-outline"
              placeholder="••••••••"
              value={senhaAtual}
              onChangeText={setSenhaAtual}
              secureTextEntry
            />
            <EcoInput
              label="Nova senha"
              icon="lock-reset"
              placeholder="••••••••"
              value={novaSenha}
              onChangeText={setNovaSenha}
              secureTextEntry
            />
            <EcoInput
              label="Confirmar nova senha"
              icon="lock-check-outline"
              placeholder="••••••••"
              value={confirmarSenha}
              onChangeText={setConfirmarSenha}
              secureTextEntry
            />
            <EcoButton
              title="Alterar Senha"
              icon="shield-key-outline"
              variant="success"
              onPress={handleAlterarSenha}
              loading={savingSenha}
              fullWidth
            />
          </EcoCard>

          {/* ── Notificações ── */}
          <EcoCard style={[styles.section, { backgroundColor: cardBg }]}>
            <Text style={[styles.sectionTitle, { color: textPrimary }]}>Notificações</Text>

            {[
              {
                label:    'Alertas de Meta',
                sub:      'Aviso ao atingir 90% da meta mensal',
                value:    notifMeta,
                onToggle: handleNotifMetaChange,
              },
              {
                label:    'Lembrete de Fatura',
                sub:      'Notificação no dia 1 de cada mês',
                value:    notifFatura,
                onToggle: handleNotifFaturaChange,
              },
              {
                label:    'Dicas de Economia',
                sub:      'Dica semanal toda segunda-feira',
                value:    notifDica,
                onToggle: handleNotifDicaChange,
              },
            ].map((item) => (
              <View key={item.label} style={[styles.switchRow, { borderBottomColor: borderColor }]}>
                <View style={styles.switchLabels}>
                  <Text style={[styles.switchLabel, { color: textPrimary }]}>{item.label}</Text>
                  <Text style={[styles.switchSub, { color: textSecondary }]}>{item.sub}</Text>
                </View>
                <Switch
                  value={item.value}
                  onValueChange={item.onToggle}
                  trackColor={{ false: colors.slate[200], true: colors.primary[600] }}
                  thumbColor={item.value ? colors.white : colors.slate[400]}
                />
              </View>
            ))}
          </EcoCard>

          {/* ── Preferências ── */}
          <EcoCard style={[styles.section, { backgroundColor: cardBg }]}>
            <Text style={[styles.sectionTitle, { color: textPrimary }]}>Preferências</Text>

            {/* Unidade padrão */}
            <Text style={[styles.prefLabel, { color: textSecondary }]}>Unidade padrão de consumo</Text>
            <View style={styles.chipsRow}>
              {UNIDADES.map((u) => (
                <TouchableOpacity
                  key={u}
                  style={[styles.chip, unidadePadrao === u && styles.chipActive]}
                  onPress={() => handleUnidadeChange(u)}
                >
                  <Text style={[styles.chipText, unidadePadrao === u && styles.chipTextActive]}>{u}</Text>
                </TouchableOpacity>
              ))}
            </View>

            {/* Modo Escuro */}
            <View style={[styles.switchRow, { borderBottomWidth: 0 }]}>
              <View style={styles.switchLabels}>
                <Text style={[styles.switchLabel, { color: textPrimary }]}>Modo Escuro</Text>
                <Text style={[styles.switchSub, { color: textSecondary }]}>Tema escuro para uso noturno</Text>
              </View>
              <Switch
                value={isDark}
                onValueChange={handleDarkModeChange}
                trackColor={{ false: colors.slate[200], true: colors.primary[600] }}
                thumbColor={isDark ? colors.white : colors.slate[400]}
              />
            </View>
          </EcoCard>

          {/* ── Sobre ── */}
          <EcoCard style={[styles.section, { backgroundColor: cardBg }]}>
            <Text style={[styles.sectionTitle, { color: textPrimary }]}>Sobre</Text>
            <View style={[styles.sobreRow, { borderBottomColor: borderColor }]}>
              <Text style={[styles.sobreLabel, { color: textSecondary }]}>Versão do app</Text>
              <Text style={[styles.sobreValue, { color: textPrimary }]}>1.0.0</Text>
            </View>
            <View style={[styles.sobreRow, { borderBottomColor: borderColor }]}>
              <Text style={[styles.sobreLabel, { color: textSecondary }]}>Desenvolvido por</Text>
              <Text style={[styles.sobreValue, { color: textPrimary }]}>IFSP São João da Boa Vista</Text>
            </View>
            <View style={[styles.sobreRow, { borderBottomWidth: 0 }]}>
              <Text style={[styles.sobreLabel, { color: textSecondary }]}>© 2026 EcoÁgua</Text>
            </View>
          </EcoCard>

          {/* ── Sair ── */}
          <EcoButton
            title="Sair da Conta"
            icon="logout"
            variant="danger"
            onPress={() =>
              Alert.alert('Sair', 'Deseja sair da conta?', [
                { text: 'Cancelar', style: 'cancel' },
                { text: 'Sair', style: 'destructive', onPress: logout },
              ])
            }
            fullWidth
            style={styles.logoutBtn}
          />

        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1 },

  // Banner
  banner: {
    alignItems:        'center',
    paddingTop:        60,
    paddingBottom:     spacing['3xl'],
    paddingHorizontal: spacing['2xl'],
  },
  avatar: {
    width:           88,
    height:          88,
    borderRadius:    44,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent:  'center',
    alignItems:      'center',
    marginBottom:    spacing.lg,
    borderWidth:     3,
    borderColor:     'rgba(255,255,255,0.4)',
  },
  avatarText: {
    fontSize:   typography.sizes['3xl'],
    fontWeight: '700',
    color:      colors.white,
  },
  bannerName: {
    fontSize:     typography.sizes['2xl'],
    fontWeight:   '700',
    color:        colors.white,
    marginBottom: spacing.xs,
  },
  bannerEmail: {
    fontSize:     typography.sizes.sm,
    color:        'rgba(255,255,255,0.8)',
    marginBottom: spacing.sm,
  },
  bannerMembro: {
    fontSize:          typography.sizes.xs,
    color:             'rgba(255,255,255,0.7)',
    backgroundColor:   'rgba(255,255,255,0.15)',
    paddingHorizontal: spacing.md,
    paddingVertical:   spacing.xs,
    borderRadius:      borderRadius.full,
  },

  body:    { padding: spacing.lg },
  section: { marginBottom: spacing.lg, padding: spacing['2xl'] },
  sectionTitle: {
    fontSize:     typography.sizes.lg,
    fontWeight:   '700',
    marginBottom: spacing.lg,
  },
  alert: { marginBottom: spacing.lg },

  // Switch rows
  switchRow: {
    flexDirection:     'row',
    alignItems:        'center',
    justifyContent:    'space-between',
    paddingVertical:   spacing.md,
    borderBottomWidth: 1,
  },
  switchLabels: { flex: 1, marginRight: spacing.md },
  switchLabel: {
    fontSize:   typography.sizes.base,
    fontWeight: '500',
  },
  switchSub: {
    fontSize:  typography.sizes.xs,
    marginTop: 2,
  },

  // Unidade chips
  prefLabel: {
    fontSize:     typography.sizes.sm,
    fontWeight:   '500',
    marginBottom: spacing.sm,
  },
  chipsRow: {
    flexDirection:  'row',
    gap:            spacing.sm,
    marginBottom:   spacing.lg,
  },
  chip: {
    paddingHorizontal: spacing.lg,
    paddingVertical:   spacing.sm,
    borderRadius:      borderRadius.full,
    borderWidth:       1.5,
    borderColor:       colors.slate[300],
    backgroundColor:   colors.slate[50],
  },
  chipActive: {
    borderColor:     colors.primary[700],
    backgroundColor: colors.primary[100],
  },
  chipText: {
    fontSize:   typography.sizes.sm,
    fontWeight: '600',
    color:      colors.slate[500],
  },
  chipTextActive: {
    color: colors.primary[900],
  },

  // Sobre
  sobreRow: {
    flexDirection:     'row',
    justifyContent:    'space-between',
    paddingVertical:   spacing.md,
    borderBottomWidth: 1,
  },
  sobreLabel: { fontSize: typography.sizes.sm },
  sobreValue: { fontSize: typography.sizes.sm, fontWeight: '600' },

  logoutBtn: { marginBottom: spacing['4xl'] },
});
