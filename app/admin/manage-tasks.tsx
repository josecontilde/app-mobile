import { Colors } from '@/constants/Colors';
import { useRouter } from 'expo-router';
import { useEffect, useState } from 'react';
import { ActivityIndicator, Alert, FlatList, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

// Simulación de datos de tareas
const mockTasks = [
  { id: '1', name: 'Revisión de código', status: 'Pendiente', priority: 'Alta' },
  { id: '2', name: 'Diseñar UI', status: 'En progreso', priority: 'Media' },
  { id: '3', name: 'Pruebas unitarias', status: 'Completada', priority: 'Baja' },
];

export default function ManageTasksScreen() {
  const [tasks, setTasks] = useState(mockTasks);
  const [loading, setLoading] = useState(false);
  const router = useRouter();

  useEffect(() => {
    // Simulación de carga de tareas
    setLoading(true);
    setTimeout(() => {
      setLoading(false);
    }, 1000);
  }, []);

  const handleDelete = (taskId: string) => {
    Alert.alert('Eliminar tarea', '¿Estás seguro de que quieres eliminar esta tarea?', [
      { text: 'Cancelar', style: 'cancel' },
      { text: 'Eliminar', onPress: () => setTasks(tasks.filter(task => task.id !== taskId)) },
    ]);
  };

  const handleEdit = (taskId: string) => {
    router.push(`/admin/create-task?id=${taskId}`);
  };

  return (
    <View style={[styles.container, { backgroundColor: '#FFFFFF' }]}>
      <Text style={styles.title}>Gestionar Tareas</Text>

      {loading ? (
        <ActivityIndicator size="large" color={Colors.light.tint} />
      ) : (
        <FlatList
          data={tasks}
          keyExtractor={(item) => item.id}
          renderItem={({ item }) => (
            <View style={styles.taskCard}>
              <Text style={styles.taskName}>{item.name}</Text>
              <Text style={styles.taskInfo}>Estado: {item.status}</Text>
              <Text style={styles.taskInfo}>Prioridad: {item.priority}</Text>
              
              <View style={styles.buttonContainer}>
                <TouchableOpacity style={styles.editButton} onPress={() => handleEdit(item.id)}>
                  <Text style={styles.buttonText}>Editar</Text>
                </TouchableOpacity>
                <TouchableOpacity style={styles.deleteButton} onPress={() => handleDelete(item.id)}>
                  <Text style={styles.buttonText}>Eliminar</Text>
                </TouchableOpacity>
              </View>
            </View>
          )}
        />
      )}

      <TouchableOpacity style={styles.createButton} onPress={() => router.push('/admin/create-task')}>
        <Text style={styles.buttonText}>+ Crear Nueva Tarea</Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#FFF',
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 10,
    textAlign: 'center',
  },
  taskCard: {
    backgroundColor: '#F5F5F5',
    padding: 15,
    borderRadius: 8,
    marginBottom: 10,
  },
  taskName: {
    fontSize: 18,
    fontWeight: 'bold',
  },
  taskInfo: {
    fontSize: 14,
    color: '#555',
  },
  buttonContainer: {
    flexDirection: 'row',
    marginTop: 10,
    justifyContent: 'space-between',
  },
  editButton: {
    backgroundColor: '#007BFF',
    padding: 10,
    borderRadius: 5,
  },
  deleteButton: {
    backgroundColor: '#FF3B30',
    padding: 10,
    borderRadius: 5,
  },
  buttonText: {
    color: '#FFF',
    textAlign: 'center',
  },
  createButton: {
    backgroundColor: '#28A745',
    padding: 15,
    borderRadius: 8,
    alignItems: 'center',
    marginTop: 20,
  },
});
