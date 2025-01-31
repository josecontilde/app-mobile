import { useRouter } from 'expo-router';
import { useState } from 'react';
import { Alert, Button, StyleSheet, Text, TextInput, View } from 'react-native';

export default function CreateTeamScreen() {
  const router = useRouter();
  const [teamName, setTeamName] = useState('');

  const handleCreateTeam = () => {
    if (!teamName.trim()) {
      Alert.alert('Error', 'El nombre del equipo no puede estar vacío');
      return;
    }

    // Aquí deberías hacer una petición a tu backend para guardar el equipo
    console.log('Equipo creado:', teamName);

    Alert.alert('Éxito', `El equipo "${teamName}" fue creado exitosamente`);
    
    // Redirigir al panel de administración
    router.replace('/admin/manage-teams');
  };

  return (
    <View style={[styles.container, { backgroundColor: '#FFFFFF' }]}>
      <Text style={styles.title}>Crear Nuevo Equipo</Text>

      {/* Entrada del nombre del equipo */}
      <TextInput
        style={styles.input}
        placeholder="Nombre del equipo"
        value={teamName}
        onChangeText={setTeamName}
      />

      {/* Botón para crear el equipo */}
      <Button title="Crear Equipo" onPress={handleCreateTeam} />
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
  input: {
    width: '100%',
    padding: 10,
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 5,
    marginBottom: 20,
  },
});
