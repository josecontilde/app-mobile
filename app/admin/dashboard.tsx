import { useRouter } from 'expo-router';
import { useEffect, useState } from 'react';
import { Button, StyleSheet, Text, View } from 'react-native';

export default function AdminDashboard() {
  const router = useRouter();
  const [stats, setStats] = useState({
    usersCount: 0,
    teamsCount: 0,
    tasksCount: 0,
  });

  // Simular obtención de datos
  useEffect(() => {
    // Aquí debes obtener los datos reales de tu backend o base de datos.
    // Este es solo un ejemplo con valores simulados.
    setStats({
      usersCount: 5, // Cambiar por el valor real
      teamsCount: 3, // Cambiar por el valor real
      tasksCount: 12, // Cambiar por el valor real
    });
  }, []);

  const handleCreateTeam = () => {
    router.push('/admin/create-team'); // Redirigir a la creación de equipo
  };

  const handleCreateTask = () => {
    router.push('/admin/create-task'); // Redirigir a la creación de tarea
  };

  const handleManageTeams = () => {
    router.push('/admin/manage-teams'); // Redirigir a la gestión de usuarios
  };

  const handleManageTasks = () => {
    router.push('/admin/manage-tasks'); // Redirigir a la gestión de tareas
  };

  return (
    <View style={[styles.container, { backgroundColor: '#FFFFFF' }]}>
      <Text style={styles.title}>¡Bienvenido, Administrador!</Text>
      <View style={styles.stats}>
        <Text style={styles.statText}>Usuarios: {stats.usersCount}</Text>
        <Text style={styles.statText}>Equipos: {stats.teamsCount}</Text>
        <Text style={styles.statText}>Tareas Pendientes: {stats.tasksCount}</Text>
      </View>

      <View style={styles.buttons}>
        <Button title="Crear Equipo" onPress={handleCreateTeam} />
        <Button title="Crear Tarea" onPress={handleCreateTask} />
        <Button title="Gestionar Equipos" onPress={handleManageTeams} />
        <Button title="Gestionar Tareas" onPress={handleManageTasks} />
      </View>
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
  stats: {
    marginBottom: 20,
  },
  statText: {
    fontSize: 18,
    marginBottom: 10,
  },
  buttons: {
    width: '100%',
    marginTop: 20,
  },
});
