import { Colors } from '@/constants/Colors';
import { useRouter } from 'expo-router';
import { useState } from 'react';
import { Alert, Button, StyleSheet, Text, TextInput, TouchableOpacity, useColorScheme, View } from 'react-native';

export default function LoginScreen() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? 'light'];

  const handleLogin = () => {
    // Condición para verificar el correo y redirigir
    if (email === 'admin@admin.com' && password === 'admin') {
      Alert.alert('Login exitoso', 'Bienvenido Administrador');
      router.replace('/admin/dashboard'); // Redirigir al panel de admin
    } else if (email === 'worker@worker.com' && password === 'worker') {
      Alert.alert('Login exitoso', 'Bienvenido Trabajador');
      router.replace('/(tabs)/home'); // Redirigir a la vista de trabajadores
    } else {
      Alert.alert('Error', 'Credenciales incorrectas');
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: '#1E9B27' }]}>
      <Text style={styles.title}>Iniciar Sesión</Text>
      <TextInput
        style={[styles.input, { backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Correo electrónico"
        placeholderTextColor={theme.icon}
        keyboardType="email-address"
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        style={[styles.input, { backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Contraseña"
        placeholderTextColor={theme.icon}
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />
      <Button title="Ingresar" onPress={handleLogin} />
      
      {/* Olvidé mi contraseña */}
      <TouchableOpacity onPress={() => router.push('/(auth)/password')}>
        <Text style={styles.link}>¿Olvidaste tu contraseña?</Text>
      </TouchableOpacity>

      {/* Enlace a registro */}
      <TouchableOpacity onPress={() => router.push('/(auth)/register')}>
        <Text style={styles.link}>¿No tienes cuenta? Regístrate</Text>
      </TouchableOpacity>
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
    color: '#FFFFFF',
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  input: {
    width: '100%',
    padding: 10,
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 5,
    marginBottom: 10,
  },
  link: {
    marginTop: 10,
    color: '#FFFFFF',
    textDecorationLine: 'underline',
  },
});
