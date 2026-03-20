import notifee, { AndroidImportance, AndroidStyle } from '@notifee/react-native';

const CHANNEL_ID = 'ecoagua_alertas';

export async function setupNotifications(): Promise<void> {
  await notifee.requestPermission();
  await notifee.createChannel({
    id: CHANNEL_ID,
    name: 'Alertas EcoÁgua',
    importance: AndroidImportance.HIGH,
    vibration: true,
    sound: 'default',
  });
}

export async function notificarMetaAtingida(percentual: number, metaLitros: number): Promise<void> {
  await notifee.displayNotification({
    title: '⚠️ Alerta de Consumo — EcoÁgua',
    body: `Você atingiu ${percentual}% da sua meta mensal de ${metaLitros}L. Reduza o consumo para não ultrapassar o limite!`,
    android: {
      channelId: CHANNEL_ID,
      importance: AndroidImportance.HIGH,
      style: {
        type: AndroidStyle.BIGTEXT,
        text: `Você atingiu ${percentual}% da sua meta mensal de ${metaLitros}L. Reduza o consumo para não ultrapassar o limite!`,
      },
      pressAction: { id: 'default' },
      color: '#1e3a8a',
      smallIcon: 'ic_launcher',
    },
  });
}

export async function notificarMetaUltrapassada(consumoAtual: number, metaLitros: number): Promise<void> {
  await notifee.displayNotification({
    title: '🚨 Meta Ultrapassada — EcoÁgua',
    body: `Seu consumo de ${Math.round(consumoAtual)}L ultrapassou a meta de ${metaLitros}L este mês!`,
    android: {
      channelId: CHANNEL_ID,
      importance: AndroidImportance.HIGH,
      style: {
        type: AndroidStyle.BIGTEXT,
        text: `Seu consumo de ${Math.round(consumoAtual)}L ultrapassou a meta de ${metaLitros}L este mês!`,
      },
      pressAction: { id: 'default' },
      color: '#ef4444',
      smallIcon: 'ic_launcher',
    },
  });
}
