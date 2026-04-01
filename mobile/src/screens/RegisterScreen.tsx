import React, { useState } from 'react';
import {
  View, Text, StyleSheet, Alert, KeyboardAvoidingView,
  Platform, ScrollView, StatusBar,
} from 'react-native';
import LinearGradient from 'react-native-linear-gradient';
import api from '../api/api';
import EcoInput from '../components/EcoInput';
import EcoButton from '../components/EcoButton';
import { colors, typography, spacing, borderRadius, gradients } from '../theme/theme';

export default function RegisterScreen({ navigation }: any) {
  const [cpf,            setCpf]            = useState('');
  const [nome,           setNome]           = useState('');
  const [email,          setEmail]          = useState('');
  const [senha,          setSenha]          = useState('');
  const [confirmarSenha, setConfirmarSenha] = useState('');
  const [loading,        setLoading]        = useState(false);
  const [errors,         setErrors]         = useState<Record<string, string>>({});

  function validate(): boolean {
    const e: Record<string, string> = {};
    if (!/^\d{11}$/.test(cpf))          e.cpf      = 'CPF deve ter 11 dígitos numéricos.';
    if (!nome.trim())                    e.nome     = 'Nome é obrigatório.';
    if (!email.includes('@'))            e.email    = 'Email inválido.';
    if (senha.length < 6)               e.senha    = 'Senha deve ter no mínimo 6 caracteres.';
    if (senha !== confirmarSenha)        e.confirmar = 'As senhas não coincidem.';
    setErrors(e);
    return Object.keys(e).length === 0;
  }

  async function handleCadastro() {
    if (!validate()) return;
    setLoading(true);
    try {
      await api.post('/api/auth/register', { cpf, nome, email, senha });
      Alert.alert(
        'Conta criada! 🎉',
        'Sua conta foi criada com sucesso. Faça login para começar.',
        [{ text: 'Entrar', onPress: () => navigation.navigate('Login') }],
      );
    } catch (error: any) {
      Alert.alert('Erro', error?.response?.data?.message ?? 'Não foi possível criar a conta.');
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
          <View style={styles.logoWrap}>
            <Text style={styles.logoEmoji}>💧</Text>
          </View>
          <Text style={styles.appName}>ECOÁGUA</Text>
          <Text style={styles.slogan}>Criar conta gratuita</Text>
        </LinearGradient>

        {/* ── Formulário ── */}
        <View style={styles.formPanel}>
          <Text style={styles.formTitle}>Cadastro</Text>
          <Text style={styles.formSubtitle}>Preencha seus dados para começar</Text>

          <EcoInput
            label="CPF"
            icon="card-account-details-outline"
            placeholder="00000000000"
            value={cpf}
            onChangeText={t => setCpf(t.replace(/\D/g, '').slice(0, 11))}
            keyboardType="numeric"
            maxLength={11}
            error={errors.cpf}
            containerStyle={styles.inputSpacing}
          />

          <EcoInput
            label="Nome Completo"
            icon="account-outline"
            placeholder="Seu nome completo"
            value={nome}
            onChangeText={setNome}
            autoCapitalize="words"
            error={errors.nome}
            containerStyle={styles.inputSpacing}
          />

          <EcoInput
            label="Email"
            icon="email-outline"
            placeholder="seu@email.com"
            value={email}
            onChangeText={setEmail}
            keyboardType="email-address"
            autoCapitalize="none"
            autoComplete="email"
            error={errors.email}
            containerStyle={styles.inputSpacing}
          />

          <EcoInput
            label="Senha"
            icon="lock-outline"
            placeholder="Mínimo 6 caracteres"
            value={senha}
            onChangeText={setSenha}
            secureTextEntry
            error={errors.senha}
            containerStyle={styles.inputSpacing}
          />

          <EcoInput
            label="Confirmar Senha"
            icon="lock-check-outline"
            placeholder="Repita a senha"
            value={confirmarSenha}
            onChangeText={setConfirmarSenha}
            secureTextEntry
            error={errors.confirmar}
            containerStyle={styles.inputSpacing}
          />

          <EcoButton
            title="Criar conta"
            icon="account-plus"
            variant="success"
            onPress={handleCadastro}
            loading={loading}
            fullWidth
            style={styles.btnCadastro}
          />

          <EcoButton
            title="Já tenho conta"
            icon="login"
            variant="secondary"
            onPress={() => navigation.navigate('Login')}
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

  hero: {
    alignItems:        'center',
    paddingTop:        50,
    paddingBottom:     36,
    paddingHorizontal: spacing['2xl'],
  },
  logoWrap: {
    width:           64,
    height:          64,
    borderRadius:    32,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent:  'center',
    alignItems:      'center',
    marginBottom:    spacing.md,
  },
  logoEmoji: { fontSize: 32 },
  appName: {
    fontSize:      typography.sizes['2xl'],
    fontWeight:    '800',
    color:         colors.white,
    letterSpacing: 4,
    marginBottom:  spacing.xs,
  },
  slogan: {
    fontSize: typography.sizes.sm,
    color:    'rgba(255,255,255,0.75)',
  },

  formPanel: {
    flex:                 1,
    backgroundColor:      colors.white,
    borderTopLeftRadius:  borderRadius.xl,
    borderTopRightRadius: borderRadius.xl,
    padding:              spacing['2xl'],
    paddingTop:           spacing['3xl'],
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
  inputSpacing: { marginBottom: spacing.md },
  btnCadastro:  { marginBottom: spacing.md },

  footer: {
    textAlign:  'center',
    fontSize:   typography.sizes.xs,
    color:      colors.slate[400],
    marginTop:  spacing['2xl'],
    lineHeight: 18,
  },
});
