import notifee, {
  AndroidImportance,
  AndroidStyle,
  TriggerType,
  RepeatFrequency,
  type TimestampTrigger,
} from '@notifee/react-native';

const CHANNEL_ID = 'ecoagua_alertas';

const DICAS_LOCAIS = [
  'Feche a torneira ao escovar os dentes — economize até 12L por vez.',
  'Banhos de até 5 min consomem 3× menos água.',
  'Reutilize a água do ar-condicionado para regar plantas.',
  'Conserte vazamentos: um cano pingando gasta 46L por dia.',
  'Use a máquina de lavar com carga completa para economizar água.',
  'Prefira ducha a banho de banheira — usa até 80% menos água.',
];

// ── Inicialização ────────────────────────────────────────────────────────────

export async function setupNotifications(): Promise<void> {
  await notifee.requestPermission();
  await notifee.createChannel({
    id:          CHANNEL_ID,
    name:        'Alertas EcoÁgua',
    importance:  AndroidImportance.HIGH,
    vibration:   true,
    sound:       'default',
  });
}

// ── Notificações imediatas (meta) ────────────────────────────────────────────

export async function notificarMetaAtingida(percentual: number, metaLitros: number): Promise<void> {
  await notifee.displayNotification({
    title: '⚠️ Alerta de Consumo — EcoÁgua',
    body:  `Você atingiu ${percentual}% da sua meta mensal de ${metaLitros}L. Reduza o consumo para não ultrapassar o limite!`,
    android: {
      channelId:   CHANNEL_ID,
      importance:  AndroidImportance.HIGH,
      style: {
        type: AndroidStyle.BIGTEXT,
        text: `Você atingiu ${percentual}% da sua meta mensal de ${metaLitros}L. Reduza o consumo para não ultrapassar o limite!`,
      },
      pressAction: { id: 'default' },
      color:       '#1e3a8a',
      smallIcon:   'ic_launcher',
    },
  });
}

export async function notificarMetaUltrapassada(consumoAtual: number, metaLitros: number): Promise<void> {
  await notifee.displayNotification({
    title: '🚨 Meta Ultrapassada — EcoÁgua',
    body:  `Seu consumo de ${Math.round(consumoAtual)}L ultrapassou a meta de ${metaLitros}L este mês!`,
    android: {
      channelId:   CHANNEL_ID,
      importance:  AndroidImportance.HIGH,
      style: {
        type: AndroidStyle.BIGTEXT,
        text: `Seu consumo de ${Math.round(consumoAtual)}L ultrapassou a meta de ${metaLitros}L este mês!`,
      },
      pressAction: { id: 'default' },
      color:       '#ef4444',
      smallIcon:   'ic_launcher',
    },
  });
}

// ── Helpers de data ──────────────────────────────────────────────────────────

function getProximoDia1(): Date {
  const now = new Date();
  const date = new Date(now.getFullYear(), now.getMonth() + 1, 1, 9, 0, 0, 0);
  return date;
}

function getProximaSegundaFeira(): Date {
  const now = new Date();
  const day = now.getDay(); // 0=Dom … 6=Sab
  const diasAteSegunda = ((1 - day + 7) % 7) || 7;
  const next = new Date(now);
  next.setDate(now.getDate() + diasAteSegunda);
  next.setHours(10, 0, 0, 0);
  return next;
}

// ── Notificações agendadas ───────────────────────────────────────────────────

export async function agendarLembreteFatura(): Promise<void> {
  try {
    const trigger: TimestampTrigger = {
      type:            TriggerType.TIMESTAMP,
      timestamp:       getProximoDia1().getTime(),
      repeatFrequency: RepeatFrequency.NONE,
    };

    await notifee.createTriggerNotification(
      {
        id:    'lembrete-fatura',
        title: 'Hora de registrar a fatura! 💧',
        body:  'Registre a fatura de água deste mês para manter seu controle atualizado.',
        android: {
          channelId:   CHANNEL_ID,
          importance:  AndroidImportance.HIGH,
          pressAction: { id: 'default' },
          color:       '#1e3a8a',
          smallIcon:   'ic_launcher',
        },
      },
      trigger,
    );
  } catch (e) {
    console.warn('agendarLembreteFatura:', e);
  }
}

export async function cancelarLembreteFatura(): Promise<void> {
  await notifee.cancelNotification('lembrete-fatura');
}

export async function agendarDicaSemanal(): Promise<void> {
  try {
    const dica = DICAS_LOCAIS[Math.floor(Math.random() * DICAS_LOCAIS.length)];

    const trigger: TimestampTrigger = {
      type:            TriggerType.TIMESTAMP,
      timestamp:       getProximaSegundaFeira().getTime(),
      repeatFrequency: RepeatFrequency.WEEKLY,
    };

    await notifee.createTriggerNotification(
      {
        id:    'dica-semanal',
        title: 'Dica de economia de água 💧',
        body:  dica,
        android: {
          channelId:   CHANNEL_ID,
          importance:  AndroidImportance.DEFAULT,
          pressAction: { id: 'default' },
          color:       '#059669',
          smallIcon:   'ic_launcher',
        },
      },
      trigger,
    );
  } catch (e) {
    console.warn('agendarDicaSemanal:', e);
  }
}

export async function cancelarDicaSemanal(): Promise<void> {
  await notifee.cancelNotification('dica-semanal');
}
