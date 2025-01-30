import { Colors } from '@/constants/Colors';
import { useRouter } from 'expo-router';
import { useState } from 'react';
import { Alert, Button, StyleSheet, Text, TextInput, TouchableOpacity, useColorScheme, View } from 'react-native';

export default function PasswordResetScreen() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? 'light'];

  const handlePasswordReset = () => {
    if (email) {
      Alert.alert('Correo enviado', 'Revisa tu correo para restablecer tu contraseña.');
      router.replace('/(auth)/login'); // Volver al login
    } else {
      Alert.alert('Error', 'Por favor ingresa tu correo electrónico');
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: '#1E9B27' }]}>
      <Text style={styles.title}>Recuperar Contraseña</Text>
      <TextInput
        style={[styles.input,{ backgroundColor: theme.inputBackground, color: theme.inputText }]}
        placeholder="Correo electrónico"
        placeholderTextColor={theme.icon}
        keyboardType="email-address"
        value={email}
        onChangeText={setEmail}
      />
      <Button title="Enviar correo" onPress={handlePasswordReset} />

      {/* Volver al login */}
      <TouchableOpacity onPress={() => router.push('/(auth)/login')}>
        <Text style={styles.link}>Volver al inicio de sesión</Text>
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
