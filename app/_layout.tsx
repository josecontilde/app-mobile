import { DarkTheme, DefaultTheme, ThemeProvider } from '@react-navigation/native';
import { useFonts } from 'expo-font';
import { Stack, useRouter } from 'expo-router';
import * as SplashScreen from 'expo-splash-screen';
import { StatusBar } from 'expo-status-bar';
import { useEffect, useState } from 'react';
import 'react-native-reanimated';

import { useColorScheme } from '@/hooks/useColorScheme';

// Simulación de autenticación (esto luego se reemplazará con lógica real)
const checkAuth = async () => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve(false); // Cambia a true si el usuario está autenticado
    }, 1000);
  });
};

// Evita que la pantalla de carga se oculte antes de que los assets se carguen completamente
SplashScreen.preventAutoHideAsync();

export default function RootLayout() {
  const colorScheme = useColorScheme();
  const [loaded] = useFonts({
    SpaceMono: require('../assets/fonts/SpaceMono-Regular.ttf'),
  });
  const [isAuthenticated, setIsAuthenticated] = useState<boolean | null>(null);
  const router = useRouter();

  useEffect(() => {
    async function checkUser() {
      const auth = await checkAuth();
      setIsAuthenticated(auth);
    }
    checkUser();
  }, []);

  useEffect(() => {
    if (isAuthenticated !== null) {
      if (isAuthenticated) {
        router.replace('/(tabs)/home'); // Si está autenticado, lo manda al home
      } else {
        router.replace('/(auth)/login'); // Si no, lo manda al login
      }
    }
  }, [isAuthenticated]);

  useEffect(() => {
    if (loaded) {
      SplashScreen.hideAsync();
    }
  }, [loaded]);

  if (!loaded || isAuthenticated === null) {
    return null;
  }

  return (
    <ThemeProvider value={colorScheme === 'dark' ? DarkTheme : DefaultTheme}>
      <Stack>
        {/* Rutas de autenticación */}
        <Stack.Screen name="(auth)" options={{ headerShown: false }} />

        {/* Rutas principales (tabs) */}
        <Stack.Screen name="(tabs)" options={{ headerShown: false }} />

        {/* Rutas de administración */}
        <Stack.Screen name="admin" options={{ headerShown: false }} />

        {/* Pantalla de error */}
        <Stack.Screen name="+not-found" />
      </Stack>
      <StatusBar style="auto" />
    </ThemeProvider>
  );
}
