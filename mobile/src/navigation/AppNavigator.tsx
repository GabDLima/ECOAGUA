import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { Text } from 'react-native';
import { useAuth } from '../contexts/AuthContext';
import Loading from '../components/Loading';
import LoginScreen from '../screens/LoginScreen';
import DashboardScreen from '../screens/DashboardScreen';
import ConsumoScreen from '../screens/ConsumoScreen';
import MetasScreen from '../screens/MetasScreen';
import theme from '../theme/theme';

const Stack = createStackNavigator();
const Tab = createBottomTabNavigator();

function TabNavigator() {
  return (
    <Tab.Navigator
      screenOptions={{
        tabBarActiveTintColor: theme.colors.primary,
        tabBarInactiveTintColor: theme.colors.textMuted,
        tabBarStyle: { backgroundColor: theme.colors.surface, borderTopColor: theme.colors.border },
        headerStyle: { backgroundColor: theme.colors.primary },
        headerTintColor: theme.colors.textWhite,
        headerTitleStyle: { fontWeight: theme.typography.fontWeight.bold as 'bold' },
      }}
    >
      <Tab.Screen
        name="Dashboard"
        component={DashboardScreen}
        options={{ title: 'Início', tabBarIcon: ({ color }) => <Text style={{ color, fontSize: 20 }}>🏠</Text> }}
      />
      <Tab.Screen
        name="Consumo"
        component={ConsumoScreen}
        options={{ title: 'Consumo', tabBarIcon: ({ color }) => <Text style={{ color, fontSize: 20 }}>💧</Text> }}
      />
      <Tab.Screen
        name="Metas"
        component={MetasScreen}
        options={{ title: 'Metas', tabBarIcon: ({ color }) => <Text style={{ color, fontSize: 20 }}>🎯</Text> }}
      />
    </Tab.Navigator>
  );
}

export default function AppNavigator() {
  const { token, loading } = useAuth();
  if (loading) return <Loading />;
  return (
    <NavigationContainer>
      <Stack.Navigator screenOptions={{ headerShown: false }}>
        {token ? (
          <Stack.Screen name="Main" component={TabNavigator} />
        ) : (
          <Stack.Screen name="Login" component={LoginScreen} />
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
}
