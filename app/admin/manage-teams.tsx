import { useRouter } from "expo-router";
import { useEffect, useState } from "react";
import { FlatList, StyleSheet, Text, View } from "react-native";

// Definir los tipos
type TaskPriority = "Alta" | "Media" | "Baja";

interface Task {
  id: number;
  name: string;
  assigneeId: number;
  priority: TaskPriority;
}

interface Member {
  id: number;
  name: string;
  role: string;
}

// Datos simulados
const mockTeamMembers: Member[] = [
  { id: 1, name: "Juan Pérez", role: "Desarrollador" },
  { id: 2, name: "Ana Gómez", role: "Diseñadora" },
  { id: 3, name: "Carlos Díaz", role: "Tester" },
];

const mockTasks: Task[] = [
  { id: 1, name: "Revisar código", assigneeId: 1, priority: "Alta" },
  { id: 2, name: "Diseñar interfaz", assigneeId: 2, priority: "Media" },
  { id: 3, name: "Probar funcionalidad", assigneeId: 3, priority: "Baja" },
];

export default function TeamsScreen() {
  const router = useRouter();
  const [members, setMembers] = useState<Member[]>(mockTeamMembers); // Miembros del equipo
  const [tasks, setTasks] = useState<Task[]>(mockTasks); // Tareas del equipo

  useEffect(() => {
    // Aquí cargarías los datos de los miembros del equipo y tareas desde tu API
  }, []);

  const getTasksForMember = (memberId: number) => {
    return tasks.filter((task) => task.assigneeId === memberId);
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Miembros del Equipo</Text>
      <FlatList
        data={members}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => {
          const assignedTasks = getTasksForMember(item.id); // Obtener tareas para el miembro
          return (
            <View style={styles.memberItem}>
              <Text style={styles.memberName}>{item.name}</Text>
              <Text style={styles.memberRole}>{item.role}</Text>

              {/* Tareas asignadas al miembro */}
              {assignedTasks.length > 0 && (
                <FlatList
                  data={assignedTasks}
                  keyExtractor={(task) => task.id.toString()}
                  renderItem={({ item: task }) => (
                    <View style={styles.taskItem}>
                      <Text style={styles.taskName}>{task.name}</Text>
                      <Text style={[styles.priority, styles[task.priority]]}>
                        {task.priority}
                      </Text>
                    </View>
                  )}
                />
              )}
            </View>
          );
        }}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: "#fff",
  },
  title: {
    fontSize: 22,
    fontWeight: "bold",
    marginBottom: 20,
  },
  memberItem: {
    padding: 15,
    backgroundColor: "#f9f9f9",
    marginBottom: 10,
    borderRadius: 5,
  },
  memberName: {
    fontSize: 18,
    fontWeight: "bold",
  },
  memberRole: {
    fontSize: 14,
    color: "gray",
    marginBottom: 10,
  },
  taskItem: {
    flexDirection: "row",
    justifyContent: "space-between",
    padding: 10,
    backgroundColor: "#e9e9e9",
    marginBottom: 5,
    borderRadius: 5,
  },
  taskName: {
    fontSize: 16,
  },
  priority: {
    fontWeight: "bold",
  },
  Alta: { color: "red" },
  Media: { color: "orange" },
  Baja: { color: "green" },
  viewDetails: {
    marginTop: 10,
    color: "#007AFF",
    textDecorationLine: "underline",
  },
});
