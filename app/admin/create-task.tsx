import { Picker } from '@react-native-picker/picker';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Alert, Button, StyleSheet, Text, TextInput, View } from 'react-native';

export default function CreateTaskScreen() {
  const router = useRouter();
  const [taskName, setTaskName] = useState('');
  const [description, setDescription] = useState('');
  const [status, setStatus] = useState('Pendiente');
  const [priority, setPriority] = useState('Media');
  const [dueDate, setDueDate] = useState('');
  const [selectedTeam, setSelectedTeam] = useState('');

  // Lista de equipos de prueba (simulando datos desde una API)
  const teams = [
    { id: '1', name: 'Equipo A' },
    { id: '2', name: 'Equipo B' },
    { id: '3', name: 'Equipo C' },
  ];

  const handleCreateTask = () => {
    if (!taskName || !description || !dueDate || !selectedTeam) {
      Alert.alert('Error', 'Todos los campos son obligatorios');
      return;
    }

    Alert.alert('Tarea Creada', `Tarea "${taskName}" ha sido creada exitosamente.`);
    router.replace('/admin/manage-tasks'); // Redirige al listado de tareas
  };

  return (
    <View style={[styles.container, { backgroundColor: '#FFFFFF' }]}>
      <Text style={styles.title}>Crear Nueva Tarea</Text>

      <TextInput
        style={styles.input}
        placeholder="Nombre de la tarea"
        value={taskName}
        onChangeText={setTaskName}
      />

      <TextInput
        style={styles.input}
        placeholder="Descripción"
        value={description}
        onChangeText={setDescription}
        multiline
      />

      <Text style={styles.label}>Estado:</Text>
      <Picker selectedValue={status} onValueChange={setStatus} style={styles.picker}>
        <Picker.Item label="Pendiente" value="Pendiente" />
        <Picker.Item label="En progreso" value="En progreso" />
        <Picker.Item label="Completada" value="Completada" />
      </Picker>

      <Text style={styles.label}>Prioridad:</Text>
      <Picker selectedValue={priority} onValueChange={setPriority} style={styles.picker}>
        <Picker.Item label="Baja" value="Baja" />
        <Picker.Item label="Media" value="Media" />
        <Picker.Item label="Alta" value="Alta" />
      </Picker>

      <TextInput
        style={styles.input}
        placeholder="Fecha de vencimiento (YYYY-MM-DD)"
        value={dueDate}
        onChangeText={setDueDate}
      />

      <Text style={styles.label}>Seleccionar equipo:</Text>
      <Picker selectedValue={selectedTeam} onValueChange={setSelectedTeam} style={styles.picker}>
        <Picker.Item label="Seleccione un equipo" value="" />
        {teams.map(team => (
          <Picker.Item key={team.id} label={team.name} value={team.id} />
        ))}
      </Picker>

      <Button title="Crear Tarea" onPress={handleCreateTask} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#fff',
    justifyContent: 'center',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    width: '100%',
    padding: 10,
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 5,
    marginBottom: 10,
  },
  label: {
    fontSize: 16,
    fontWeight: 'bold',
    marginTop: 10,
  },
  picker: {
    height: 50,
    width: '100%',
    marginBottom: 10,
  },
});

