import React, { useState } from 'react';
import {
  View, Text, StyleSheet, Alert, KeyboardAvoidingView,
  Platform, ScrollView, TouchableOpacity, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import { useAuth } from '../contexts/AuthContext';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';

export default function LoginScreen() {
  const { login } = useAuth();
  const [email,   setEmail]   = useState('');
  const [senha,   setSenha]   = useState('');
  const [loading, setLoading] = useState(false);

  async function handleLogin() {
    if (!email || !senha) {
      Alert.alert('Atenção', 'Preencha email e senha.');
      return;
    }
    setLoading(true);
    try {
      await login(email, senha);
    } catch (error: any) {
      Alert.alert('Erro', error?.response?.data?.message ?? error?.message ?? 'Erro desconhecido');
    } finally {
      setLoading(false);
    }
  }

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
      <StatusBar barStyle="light-content" backgroundColor={colors.primary[900]} />
      <ScrollView contentContainerStyle={styles.scroll} bounces={false}>

        {/* ── Cabeçalho gradiente ── */}
        <LinearGradient colors={gradients.loginBg} style={styles.hero}>
          {/* Logo */}
          <View style={styles.logoWrap}>
            <Text style={styles.logoEmoji}>💧</Text>
          </View>
          <Text style={styles.appName}>ECOÁGUA</Text>
          <Text style={styles.slogan}>Monitore · Economize · Preserve</Text>

          {/* Estatísticas */}
          <View style={styles.statsRow}>
            <View style={styles.statItem}>
              <Text style={styles.statValue}>37%</Text>
              <Text style={styles.statLabel}>água desperdiçada</Text>
            </View>
            <View style={styles.statDivider} />
            <View style={styles.statItem}>
              <Text style={styles.statValue}>200L</Text>
              <Text style={styles.statLabel}>por pessoa / dia</Text>
            </View>
          </View>
        </LinearGradient>

        {/* ── Formulário ── */}
        <View style={styles.formPanel}>
          <Text style={styles.formTitle}>Bem-vindo de volta!</Text>
          <Text style={styles.formSubtitle}>
            Acesse sua conta para monitorar seu consumo
          </Text>

          <EcoInput
            label="Email"
            icon="email-outline"
            placeholder="seu@email.com"
            value={email}
            onChangeText={setEmail}
            keyboardType="email-address"
            autoCapitalize="none"
            autoComplete="email"
            containerStyle={styles.inputSpacing}
          />

          <EcoInput
            label="Senha"
            icon="lock-outline"
            placeholder="••••••••"
            value={senha}
            onChangeText={setSenha}
            secureTextEntry
            containerStyle={styles.inputSpacing}
          />

          <TouchableOpacity style={styles.forgotLink}>
            <Text style={styles.forgotText}>Esqueci minha senha</Text>
          </TouchableOpacity>

          <EcoButton
            title="Entrar na conta"
            icon="login"
            variant="primary"
            onPress={handleLogin}
            loading={loading}
            fullWidth
            style={styles.btnPrimary}
          />

          <View style={styles.dividerRow}>
            <View style={styles.dividerLine} />
            <Text style={styles.dividerText}>ou</Text>
            <View style={styles.dividerLine} />
          </View>

          <EcoButton
            title="Criar conta gratuita"
            icon="account-plus-outline"
            variant="secondary"
            onPress={() => Alert.alert('Em breve', 'Cadastro disponível em breve.')}
            fullWidth
          />

          <Text style={styles.footer}>EcoÁgua © 2026 · IFSP São João da Boa Vista</Text>
        </View>

      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: colors.primary[900] },
  scroll:    { flexGrow: 1 },

  // Cabeçalho
  hero: {
    alignItems:      'center',
    paddingTop:      60,
    paddingBottom:   48,
    paddingHorizontal: spacing['2xl'],
  },
  logoWrap: {
    width:           72,
    height:          72,
    borderRadius:    36,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent:  'center',
    alignItems:      'center',
    marginBottom:    spacing.lg,
  },
  logoEmoji: { fontSize: 36 },
  appName: {
    fontSize:      typography.sizes['3xl'],
    fontWeight:    '800',
    color:         colors.white,
    letterSpacing: 4,
    marginBottom:  spacing.sm,
  },
  slogan: {
    fontSize:     typography.sizes.sm,
    color:        'rgba(255,255,255,0.75)',
    marginBottom: spacing['2xl'],
  },
  statsRow: {
    flexDirection: 'row',
    alignItems:    'center',
    gap:           spacing['2xl'],
  },
  statItem:   { alignItems: 'center' },
  statValue: {
    fontSize:   typography.sizes['2xl'],
    fontWeight: '700',
    color:      colors.white,
  },
  statLabel: {
    fontSize:  typography.sizes.xs,
    color:     'rgba(255,255,255,0.7)',
    marginTop: spacing.xs,
  },
  statDivider: {
    width:           1,
    height:          40,
    backgroundColor: 'rgba(255,255,255,0.3)',
  },

  // Formulário
  formPanel: {
    flex:              1,
    backgroundColor:   colors.white,
    borderTopLeftRadius:  borderRadius.xl,
    borderTopRightRadius: borderRadius.xl,
    padding:           spacing['2xl'],
    paddingTop:        spacing['3xl'],
  },
  formTitle: {
    fontSize:     typography.sizes['2xl'],
    fontWeight:   '700',
    color:        colors.slate[800],
    marginBottom: spacing.sm,
  },
  formSubtitle: {
    fontSize:     typography.sizes.sm,
    color:        colors.slate[500],
    marginBottom: spacing['2xl'],
  },
  inputSpacing: { marginBottom: spacing.lg },
  forgotLink: {
    alignSelf:    'flex-end',
    marginBottom: spacing['2xl'],
    marginTop:    -spacing.sm,
  },
  forgotText: {
    fontSize:   typography.sizes.sm,
    color:      colors.primary[600],
    fontWeight: '500',
  },
  btnPrimary: { marginBottom: spacing.lg },

  // Divisor
  dividerRow: {
    flexDirection: 'row',
    alignItems:    'center',
    gap:           spacing.md,
    marginVertical: spacing.lg,
  },
  dividerLine: {
    flex:            1,
    height:          1,
    backgroundColor: colors.slate[200],
  },
  dividerText: {
    fontSize: typography.sizes.sm,
    color:    colors.slate[400],
  },

  // Footer
  footer: {
    textAlign:  'center',
    fontSize:   typography.sizes.xs,
    color:      colors.slate[400],
    marginTop:  spacing['2xl'],
    lineHeight: 18,
  },
});
