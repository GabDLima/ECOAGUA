import React, { useState } from 'react';
import {
  View, Text, TextInput, TouchableOpacity,
  StyleSheet, Alert, KeyboardAvoidingView, Platform, ScrollView
} from 'react-native';
import { useAuth } from '../contexts/AuthContext';
import theme from '../theme/theme';

const LoginScreen: React.FC = () => {
  const { login } = useAuth();
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
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
      console.log('Erro completo:', JSON.stringify(error?.response?.data));
      console.log('Status:', error?.response?.status);
      console.log('Message:', error?.message);
      Alert.alert('Erro', `${error?.response?.data?.message || error?.message || 'Erro desconhecido'}`);
    } finally {
      setLoading(false);
    }
  }

  return (
    <KeyboardAvoidingView style={styles.container} behavior={Platform.OS === 'ios' ? 'padding' : undefined}>
      <ScrollView contentContainerStyle={styles.scroll}>
        <View style={styles.header}>
          <View style={styles.logoContainer}>
            <Text style={styles.logoText}>💧</Text>
          </View>
          <Text style={styles.title}>ECOÁGUA</Text>
          <Text style={styles.subtitle}>Monitore seu consumo de água</Text>
        </View>
        <View style={styles.form}>
          <Text style={styles.label}>Email</Text>
          <TextInput
            style={styles.input}
            placeholder="seu@email.com"
            placeholderTextColor={theme.colors.textLight}
            value={email}
            onChangeText={setEmail}
            keyboardType="email-address"
            autoCapitalize="none"
          />
          <Text style={styles.label}>Senha</Text>
          <TextInput
            style={styles.input}
            placeholder="••••••••"
            placeholderTextColor={theme.colors.textLight}
            value={senha}
            onChangeText={setSenha}
            secureTextEntry
          />
          <TouchableOpacity
            style={[styles.button, loading && styles.buttonDisabled]}
            onPress={handleLogin}
            disabled={loading}
          >
            <Text style={styles.buttonText}>{loading ? 'Entrando...' : 'Entrar'}</Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.backgroundAlt },
  scroll: { flexGrow: 1, justifyContent: 'center', padding: theme.spacing.xl },
  header: { alignItems: 'center', marginBottom: theme.spacing.xl3 },
  logoContainer: {
    width: 72,
    height: 72,
    borderRadius: theme.borderRadius.full,
    backgroundColor: theme.colors.primary,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: theme.spacing.md,
    ...theme.shadows.login,
  },
  logoText: { fontSize: 36 },
  title: {
    fontSize: theme.typography.fontSize.xl2,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.primary,
    letterSpacing: theme.typography.tracking.wide,
  },
  subtitle: {
    fontSize: theme.typography.fontSize.sm,
    color: theme.colors.textMuted,
    marginTop: theme.spacing.xs,
  },
  form: {
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.xl,
    ...theme.shadows.login,
  },
  label: {
    fontSize: theme.typography.fontSize.sm,
    fontWeight: theme.typography.fontWeight.medium as '500',
    color: theme.colors.textSecondary,
    marginBottom: theme.spacing.sm,
    marginTop: theme.spacing.md,
  },
  input: {
    borderWidth: 2,
    borderColor: theme.colors.border,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    fontSize: theme.typography.fontSize.base,
    color: theme.colors.textSecondary,
    backgroundColor: theme.colors.surface,
  },
  button: {
    backgroundColor: theme.colors.primary,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.base,
    alignItems: 'center',
    marginTop: theme.spacing.xl,
    ...theme.shadows.btnPrimary,
  },
  buttonDisabled: { backgroundColor: theme.colors.textLight },
  buttonText: {
    color: theme.colors.textWhite,
    fontSize: theme.typography.fontSize.base,
    fontWeight: theme.typography.fontWeight.medium as '500',
  },
});

export default LoginScreen;
