import { useRouter } from 'expo-router';
import { useEffect, useState } from 'react';
import { FlatList, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

// Definir tipos explícitos
interface Task {
  id: number;
  name: string;
  priority: 'Alta' | 'Media' | 'Baja'; // Definir prioridad como string literal
}

interface Team {
  id: number;
  name: string;
}

// Datos de prueba
const mockTeam: Team = { id: 1, name: 'Equipo Alpha' };
const mockTasks: Task[] = [
  { id: 1, name: 'Revisar reportes', priority: 'Alta' },
  { id: 2, name: 'Actualizar inventario', priority: 'Media' },
  { id: 3, name: 'Responder correos', priority: 'Baja' },
];

// Ordenar tareas por prioridad
const priorityOrder = { Alta: 1, Media: 2, Baja: 3 };

export default function HomeScreen() {
  const router = useRouter();
  const [team, setTeam] = useState<Team>(mockTeam); // Tipo explícito para team
  const [tasks, setTasks] = useState<Task[]>(mockTasks); // Tipo explícito para tasks

  useEffect(() => {
    // Aquí puedes cargar datos desde una API cuando la tengas lista
  }, []);

  return (
    <View style={styles.container}>
      {/* Nombre del equipo */}
      <TouchableOpacity onPress={() => router.push('/(tabs)/teams')}>
        <Text style={styles.teamName}>🏢 {team.name}</Text>
      </TouchableOpacity>

      {/* Lista de tareas */}
      <Text style={styles.sectionTitle}>📋 Mis Tareas</Text>
      <FlatList
        data={[...tasks].sort((a, b) => priorityOrder[a.priority] - priorityOrder[b.priority])}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <View style={styles.taskItem}>
            <Text style={styles.taskName}>{item.name}</Text>
            <Text style={[styles.priority, styles[item.priority]]}>{item.priority}</Text>
          </View>
        )}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#fff',
  },
  teamName: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#007AFF',
    marginBottom: 10,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  taskItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    padding: 10,
    marginBottom: 5,
    backgroundColor: '#f9f9f9',
    borderRadius: 5,
  },
  taskName: {
    fontSize: 16,
  },
  priority: {
    fontWeight: 'bold',
  },
  Alta: { color: 'red' },
  Media: { color: 'orange' },
  Baja: { color: 'green' },
});
