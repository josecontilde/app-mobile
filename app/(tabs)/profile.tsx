import { Colors } from '@/constants/Colors';
import { useRouter } from 'expo-router';
import { useState } from 'react';
import { Button, StyleSheet, Text, useColorScheme, View } from 'react-native';

export default function ProfileScreen() {
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? 'light'];
  const router = useRouter();

  const [user, setUser] = useState({
    name: 'Juan Pérez',
    email: 'juan.perez@trabajo.com',
    role: 'Trabajador', // Este campo podría cambiar si el usuario es admin o trabajador
  });

  const handleLogout = () => {
    // Aquí puedes manejar el cierre de sesión, por ejemplo, limpiando el estado o usando un sistema de autenticación
    router.replace('/(auth)/login'); // Redirige a la pantalla de login
  };

  return (
    <View style={[styles.container, { backgroundColor: theme.background }]}>
      <Text style={[styles.title, { color: theme.text }]}>Mi Perfil</Text>

      <View style={styles.infoContainer}>
        <Text style={[styles.label, { color: theme.text }]}>Nombre:</Text>
        <Text style={[styles.value, { color: theme.text }]}>{user.name}</Text>

        <Text style={[styles.label, { color: theme.text }]}>Correo Electrónico:</Text>
        <Text style={[styles.value, { color: theme.text }]}>{user.email}</Text>

        <Text style={[styles.label, { color: theme.text }]}>Rol:</Text>
        <Text style={[styles.value, { color: theme.text }]}>{user.role}</Text>
      </View>

      {/* Botón para cerrar sesión */}
      <Button title="Cerrar sesión" onPress={handleLogout} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  infoContainer: {
    width: '100%',
    marginBottom: 20,
  },
  label: {
    fontSize: 16,
    marginVertical: 5,
  },
  value: {
    fontSize: 16,
    marginBottom: 10,
  },
});
