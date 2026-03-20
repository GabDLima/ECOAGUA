import React, { useState } from 'react';
import {
  View, Text, StyleSheet, ScrollView, TextInput,
  TouchableOpacity, Alert, KeyboardAvoidingView, Platform
} from 'react-native';
import { useAuth } from '../contexts/AuthContext';
import api from '../api/api';
import theme from '../theme/theme';

const PerfilScreen: React.FC = () => {
  const { usuario, logout } = useAuth();
  const [nome, setNome] = useState(usuario?.nome || '');
  const [email, setEmail] = useState(usuario?.email || '');
  const [senhaAtual, setSenhaAtual] = useState('');
  const [novaSenha, setNovaSenha] = useState('');
  const [confirmarSenha, setConfirmarSenha] = useState('');
  const [savingPerfil, setSavingPerfil] = useState(false);
  const [savingSenha, setSavingSenha] = useState(false);

  async function handleSalvarPerfil() {
    if (!nome || !email) {
      Alert.alert('Atenção', 'Nome e email são obrigatórios.');
      return;
    }
    if (!email.includes('@')) {
      Alert.alert('Atenção', 'Email inválido.');
      return;
    }
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
      Alert.alert('Atenção', 'Preencha todos os campos.');
      return;
    }
    if (novaSenha !== confirmarSenha) {
      Alert.alert('Atenção', 'As senhas não coincidem.');
      return;
    }
    if (novaSenha.length < 6) {
      Alert.alert('Atenção', 'A nova senha deve ter pelo menos 6 caracteres.');
      return;
    }
    setSavingSenha(true);
    try {
      await api.post('/alterasenha', {
        senha_atual: senhaAtual,
        nova_senha: novaSenha,
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

  return (
    <KeyboardAvoidingView style={{ flex: 1 }} behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
      <ScrollView style={styles.container} keyboardShouldPersistTaps="handled">

        <View style={styles.header}>
          <View style={styles.avatar}>
            <Text style={styles.avatarText}>
              {usuario?.nome?.charAt(0).toUpperCase() || 'U'}
            </Text>
          </View>
          <Text style={styles.nomeHeader}>{usuario?.nome}</Text>
          <Text style={styles.emailHeader}>{usuario?.email}</Text>
        </View>

        <View style={styles.card}>
          <Text style={styles.title}>Dados pessoais</Text>
          <Text style={styles.label}>Nome</Text>
          <TextInput
            style={styles.input}
            value={nome}
            onChangeText={setNome}
            placeholder="Seu nome completo"
            placeholderTextColor={theme.colors.textLight}
          />
          <Text style={styles.label}>Email</Text>
          <TextInput
            style={styles.input}
            value={email}
            onChangeText={setEmail}
            placeholder="seu@email.com"
            keyboardType="email-address"
            autoCapitalize="none"
            placeholderTextColor={theme.colors.textLight}
          />
          <TouchableOpacity
            style={[styles.button, savingPerfil && styles.buttonDisabled]}
            onPress={handleSalvarPerfil}
            disabled={savingPerfil}
          >
            <Text style={styles.buttonText}>{savingPerfil ? 'Salvando...' : 'Salvar alterações'}</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.card}>
          <Text style={styles.title}>Alterar senha</Text>
          <Text style={styles.label}>Senha atual</Text>
          <TextInput
            style={styles.input}
            value={senhaAtual}
            onChangeText={setSenhaAtual}
            secureTextEntry
            placeholder="••••••••"
            placeholderTextColor={theme.colors.textLight}
          />
          <Text style={styles.label}>Nova senha</Text>
          <TextInput
            style={styles.input}
            value={novaSenha}
            onChangeText={setNovaSenha}
            secureTextEntry
            placeholder="••••••••"
            placeholderTextColor={theme.colors.textLight}
          />
          <Text style={styles.label}>Confirmar nova senha</Text>
          <TextInput
            style={styles.input}
            value={confirmarSenha}
            onChangeText={setConfirmarSenha}
            secureTextEntry
            placeholder="••••••••"
            placeholderTextColor={theme.colors.textLight}
          />
          <TouchableOpacity
            style={[styles.button, styles.buttonSecondary, savingSenha && styles.buttonDisabled]}
            onPress={handleAlterarSenha}
            disabled={savingSenha}
          >
            <Text style={styles.buttonText}>{savingSenha ? 'Alterando...' : 'Alterar senha'}</Text>
          </TouchableOpacity>
        </View>

        <TouchableOpacity style={styles.logoutButton} onPress={logout}>
          <Text style={styles.logoutText}>Sair da conta</Text>
        </TouchableOpacity>

      </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.background },
  header: {
    backgroundColor: theme.colors.primary,
    alignItems: 'center',
    paddingVertical: theme.spacing.xl3,
    paddingHorizontal: theme.spacing.xl,
  },
  avatar: {
    width: 80, height: 80,
    borderRadius: theme.borderRadius.full,
    backgroundColor: 'rgba(255,255,255,0.2)',
    justifyContent: 'center', alignItems: 'center',
    marginBottom: theme.spacing.md,
  },
  avatarText: {
    fontSize: theme.typography.fontSize.xl3,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.textWhite,
  },
  nomeHeader: {
    fontSize: theme.typography.fontSize.xl2,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.textWhite,
  },
  emailHeader: {
    fontSize: theme.typography.fontSize.sm,
    color: 'rgba(255,255,255,0.8)',
    marginTop: theme.spacing.xs,
  },
  card: {
    backgroundColor: theme.colors.surface,
    margin: theme.spacing.base,
    borderRadius: theme.borderRadius.xl,
    padding: theme.spacing.base,
    ...theme.shadows.card,
  },
  title: {
    fontSize: theme.typography.fontSize.xl2,
    fontWeight: theme.typography.fontWeight.bold as 'bold',
    color: theme.colors.primary,
    marginBottom: theme.spacing.base,
  },
  label: {
    fontSize: theme.typography.fontSize.sm,
    fontWeight: theme.typography.fontWeight.medium as '500',
    color: theme.colors.textSecondary,
    marginBottom: theme.spacing.xs,
    marginTop: theme.spacing.md,
  },
  input: {
    borderWidth: 2,
    borderColor: theme.colors.border,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    fontSize: theme.typography.fontSize.base,
    color: theme.colors.textSecondary,
  },
  button: {
    backgroundColor: theme.colors.primary,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    alignItems: 'center',
    marginTop: theme.spacing.xl,
    ...theme.shadows.btnPrimary,
  },
  buttonSecondary: {
    backgroundColor: theme.colors.success,
  },
  buttonDisabled: { backgroundColor: theme.colors.textLight },
  buttonText: {
    color: theme.colors.textWhite,
    fontWeight: theme.typography.fontWeight.medium as '500',
    fontSize: theme.typography.fontSize.base,
  },
  logoutButton: {
    margin: theme.spacing.base,
    marginTop: theme.spacing.xs,
    padding: theme.spacing.base,
    alignItems: 'center',
    borderRadius: theme.borderRadius.md,
    borderWidth: 1,
    borderColor: theme.colors.danger,
  },
  logoutText: {
    color: theme.colors.danger,
    fontWeight: theme.typography.fontWeight.medium as '500',
    fontSize: theme.typography.fontSize.base,
  },
});

export default PerfilScreen;
