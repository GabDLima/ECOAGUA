import React, { useState } from 'react';
import {
  View, Text, StyleSheet, ScrollView, Alert,
  KeyboardAvoidingView, Platform, Switch, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import { useAuth } from '../contexts/AuthContext';
import api from '../api/api';
import EcoCard from '../components/EcoCard';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import EcoAlert from '../components/EcoAlert';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';

export default function PerfilScreen() {
  const { usuario, logout } = useAuth();

  // Dados pessoais
  const [nome,  setNome]  = useState(usuario?.nome  ?? '');
  const [email, setEmail] = useState(usuario?.email ?? '');
  const [savingPerfil, setSavingPerfil] = useState(false);

  // Segurança
  const [senhaAtual,     setSenhaAtual]     = useState('');
  const [novaSenha,      setNovaSenha]      = useState('');
  const [confirmarSenha, setConfirmarSenha] = useState('');
  const [savingSenha,    setSavingSenha]    = useState(false);

  // Preferências (estado local; conecte à API conforme disponibilidade)
  const [notifMeta,     setNotifMeta]     = useState(true);
  const [notifFatura,   setNotifFatura]   = useState(true);
  const [notifDica,     setNotifDica]     = useState(false);

  async function handleSalvarPerfil() {
    if (!nome || !email) { Alert.alert('Atenção', 'Nome e email são obrigatórios.'); return; }
    if (!email.includes('@')) { Alert.alert('Atenção', 'Email inválido.'); return; }
    setSavingPerfil(true);
    try {
      // POST /editarusuario
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
      // POST /alterasenha
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
      <ScrollView style={styles.container} keyboardShouldPersistTaps="handled">
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
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Dados Pessoais</Text>
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
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Segurança</Text>
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
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Notificações</Text>

            {[
              {
                label:   'Alertas de Meta',
                sub:     'Aviso ao atingir 90% da meta mensal',
                value:   notifMeta,
                onToggle: setNotifMeta,
              },
              {
                label:   'Lembrete de Fatura',
                sub:     'Notificação para registrar fatura mensal',
                value:   notifFatura,
                onToggle: setNotifFatura,
              },
              {
                label:   'Dicas de Economia',
                sub:     'Receba dicas semanais para economizar água',
                value:   notifDica,
                onToggle: setNotifDica,
              },
            ].map((item) => (
              <View key={item.label} style={styles.switchRow}>
                <View style={styles.switchLabels}>
                  <Text style={styles.switchLabel}>{item.label}</Text>
                  <Text style={styles.switchSub}>{item.sub}</Text>
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

          {/* ── Sobre ── */}
          <EcoCard style={styles.section}>
            <Text style={styles.sectionTitle}>Sobre</Text>
            <View style={styles.sobreRow}>
              <Text style={styles.sobreLabel}>Versão do app</Text>
              <Text style={styles.sobreValue}>1.0.0</Text>
            </View>
            <View style={styles.sobreRow}>
              <Text style={styles.sobreLabel}>Desenvolvido por</Text>
              <Text style={styles.sobreValue}>IFSP São João da Boa Vista</Text>
            </View>
            <View style={[styles.sobreRow, { borderBottomWidth: 0 }]}>
              <Text style={styles.sobreLabel}>© 2026 EcoÁgua</Text>
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
  container: { flex: 1, backgroundColor: colors.background },

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
    fontSize:   typography.sizes['2xl'],
    fontWeight: '700',
    color:      colors.white,
    marginBottom: spacing.xs,
  },
  bannerEmail: {
    fontSize:  typography.sizes.sm,
    color:     'rgba(255,255,255,0.8)',
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
    color:        colors.slate[800],
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
    borderBottomColor: colors.slate[100],
  },
  switchLabels: { flex: 1, marginRight: spacing.md },
  switchLabel: {
    fontSize:   typography.sizes.base,
    fontWeight: '500',
    color:      colors.slate[700],
  },
  switchSub: {
    fontSize:  typography.sizes.xs,
    color:     colors.slate[400],
    marginTop: 2,
  },

  // Sobre
  sobreRow: {
    flexDirection:     'row',
    justifyContent:    'space-between',
    paddingVertical:   spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.slate[100],
  },
  sobreLabel: { fontSize: typography.sizes.sm, color: colors.slate[500] },
  sobreValue: { fontSize: typography.sizes.sm, fontWeight: '600', color: colors.slate[700] },

  logoutBtn: { marginBottom: spacing['4xl'] },
});
