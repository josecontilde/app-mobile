import { useRouter } from "expo-router";
import * as SecureStore from "expo-secure-store";
import { useEffect, useState } from "react";
import {
  ActivityIndicator,
  Button,
  StyleSheet,
  Text,
  View,
} from "react-native";

export default function DashboardScreen() {
  const router = useRouter();
  const [tasks, setTasks] = useState([]);
  const [groups, setGroups] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      const token = await SecureStore.getItemAsync("access_token");
      if (token) {
        const response = await fetch("http://192.168.0.18:8000/api/team", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        const data = await response.json();

        // Extraemos las tareas y los grupos de la respuesta
        const allTasks = data.teams.reduce((acc: any[], team: any) => {
          return [...acc, ...team.tasks];
        }, []);
        setTasks(allTasks);

        setGroups(data.teams);
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  if (loading) {
    return <ActivityIndicator size="large" />;
  }

  return (
    <View style={styles.container}>
      <Button
        title="Ver mi perfil"
        onPress={() => router.push("/admin/profile")}
      />
      <Text style={styles.title}>Dashboard</Text>
      <Text style={styles.subtitle}>Total de Tareas: {tasks.length}</Text>
      <Text style={styles.subtitle}>Total de Grupos: {groups.length}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: "bold",
  },
  subtitle: {
    fontSize: 18,
    fontWeight: "bold",
    marginTop: 20,
  },
});
