import { Colors } from '@/constants/Colors';
import { useRouter } from 'expo-router';
import { useState } from 'react';
import { Alert, Button, StyleSheet, Text, TextInput, TouchableOpacity, useColorScheme, View } from 'react-native';

export default function RegisterScreen() {
  const router = useRouter();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? 'light'];

  const handleRegister = () => {
    if (name && email && password) {
      Alert.alert('Registro exitoso', 'Ahora puedes iniciar sesión');
      router.replace('/(auth)/login'); // Redirigir al login después del registro
    } else {
      Alert.alert('Error', 'Todos los campos son obligatorios');
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: '#1E9B27' }]}>
      <Text style={styles.title}>Registrarse</Text>
      <TextInput
        style={[styles.input,{ backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Nombre"
        placeholderTextColor={theme.icon}
        value={name}
        onChangeText={setName}
      />
      <TextInput
        style={[styles.input,{ backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Correo electrónico"
        placeholderTextColor={theme.icon}
        keyboardType="email-address"
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        style={[styles.input,{ backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Contraseña"
        placeholderTextColor={theme.icon}
        secureTextEntry
        value={password}
        onChangeText={setPassword}
      />
      <Button title="Registrarse" onPress={handleRegister} />
      
      {/* Enlace para volver al login */}
      <TouchableOpacity onPress={() => router.push('/(auth)/login')}>
        <Text style={styles.link}>¿Ya tienes cuenta? Inicia sesión</Text>
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
    color: '#FFFFFF',
    marginTop: 10,
    textDecorationLine: 'underline',
  },
});
