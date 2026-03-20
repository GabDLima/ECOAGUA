import React, { useState, useCallback } from 'react';
import { useFocusEffect } from '@react-navigation/native';
import {
  View, Text, StyleSheet, ScrollView, TextInput,
  TouchableOpacity, Alert, RefreshControl,
  KeyboardAvoidingView, Platform
} from 'react-native';
import api from '../api/api';
import theme from '../theme/theme';
import { notificarMetaAtingida, notificarMetaUltrapassada } from '../services/NotificationService';

const MetasScreen: React.FC = () => {
  const [meta, setMeta] = useState<any>(null);
  const [progresso, setProgresso] = useState<any>(null);
  const [metaMensal, setMetaMensal] = useState('');
  const [metaReducao, setMetaReducao] = useState('');
  const [prazo, setPrazo] = useState('');
  const [saving, setSaving] = useState(false);
  const [refreshing, setRefreshing] = useState(false);

  const fetchMetas = useCallback(async () => {
    try {
      const res = await api.get('/api/metas');
      setMeta(res.data.meta);
      setProgresso(res.data.progresso);

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
    }
  }, []);

  useFocusEffect(useCallback(() => { fetchMetas(); }, [fetchMetas]));

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchMetas();
    setRefreshing(false);
  }, [fetchMetas]);

  async function handleSalvar() {
    const mensal = parseInt(metaMensal);
    const reducao = parseInt(metaReducao);
    const prazoNum = parseInt(prazo);

    if (!metaMensal || !metaReducao || !prazo) {
      Alert.alert('Atenção', 'Preencha todos os campos.');
      return;
    }
    if (isNaN(mensal) || mensal <= 0) {
      Alert.alert('Atenção', 'Meta mensal deve ser um número positivo.');
      return;
    }
    if (isNaN(reducao) || reducao <= 0 || reducao > 100) {
      Alert.alert('Atenção', 'Redução deve ser entre 1% e 100%.');
      return;
    }
    if (isNaN(prazoNum) || prazoNum <= 0) {
      Alert.alert('Atenção', 'Prazo deve ser um número positivo.');
      return;
    }

    setSaving(true);
    try {
      await api.post('/api/metas', {
        meta_mensal: mensal,
        meta_reducao: reducao,
        prazo: prazoNum,
      });
      Alert.alert('Sucesso', 'Meta criada!');
      setMetaMensal(''); setMetaReducao(''); setPrazo('');
      fetchMetas();
    } catch {
      Alert.alert('Erro', 'Não foi possível salvar.');
    } finally {
      setSaving(false);
    }
  }

  return (
    <KeyboardAvoidingView
      style={{ flex: 1 }}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
    <ScrollView
      style={styles.container}
      keyboardShouldPersistTaps="handled"
      refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[theme.colors.primary]} />}
    >
      {progresso && (
        <View style={styles.card}>
          <Text style={styles.title}>Meta ativa</Text>
          <View style={styles.progressBar}>
            <View style={[styles.progressFill, {
              width: `${Math.min(progresso.percentual, 100)}%` as any,
              backgroundColor: progresso.alerta ? theme.colors.danger : theme.colors.success,
            }]} />
          </View>
          <Text style={styles.progressText}>
            {progresso.consumo_atual}L / {progresso.meta_litros}L ({progresso.percentual}%)
          </Text>
          {progresso.alerta && (
            <Text style={styles.alertText}>⚠️ Você atingiu 90% da sua meta!</Text>
          )}
        </View>
      )}

      <View style={styles.card}>
        <Text style={styles.title}>Nova meta</Text>
        <Text style={styles.label}>Meta mensal (litros)</Text>
        <TextInput
          style={styles.input}
          placeholder="Ex: 5000"
          placeholderTextColor={theme.colors.textLight}
          value={metaMensal}
          onChangeText={setMetaMensal}
          keyboardType="numeric"
        />
        <Text style={styles.label}>Redução desejada (%)</Text>
        <TextInput
          style={styles.input}
          placeholder="Ex: 10"
          placeholderTextColor={theme.colors.textLight}
          value={metaReducao}
          onChangeText={setMetaReducao}
          keyboardType="numeric"
        />
        <Text style={styles.label}>Prazo (meses)</Text>
        <TextInput
          style={styles.input}
          placeholder="Ex: 3"
          placeholderTextColor={theme.colors.textLight}
          value={prazo}
          onChangeText={setPrazo}
          keyboardType="numeric"
        />
        <TouchableOpacity
          style={[styles.button, saving && styles.buttonDisabled]}
          onPress={handleSalvar}
          disabled={saving}
        >
          <Text style={styles.buttonText}>{saving ? 'Salvando...' : 'Criar meta'}</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: theme.colors.background },
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
  progressBar: {
    height: theme.spacing.progressHeight,
    backgroundColor: theme.colors.border,
    borderRadius: theme.borderRadius.full,
    overflow: 'hidden',
    marginBottom: theme.spacing.sm,
  },
  progressFill: { height: '100%', borderRadius: theme.borderRadius.full },
  progressText: { fontSize: theme.typography.fontSize.sm, color: theme.colors.textMuted },
  alertText: {
    color: theme.colors.danger,
    fontSize: theme.typography.fontSize.sm,
    marginTop: theme.spacing.sm,
    fontWeight: theme.typography.fontWeight.semibold as '600',
  },
  label: {
    fontSize: theme.typography.fontSize.sm,
    color: theme.colors.textSecondary,
    fontWeight: theme.typography.fontWeight.medium as '500',
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
  buttonDisabled: { backgroundColor: theme.colors.textLight },
  buttonText: {
    color: theme.colors.textWhite,
    fontWeight: theme.typography.fontWeight.medium as '500',
    fontSize: theme.typography.fontSize.base,
  },
});

export default MetasScreen;
