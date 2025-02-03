import { useRouter } from "expo-router";
import * as SecureStore from "expo-secure-store";
import { useState } from "react";
import { Alert, Button, StyleSheet, Text, TextInput, View } from "react-native";

export default function CreateTeamScreen() {
  const router = useRouter();
  const [teamName, setTeamName] = useState("");
  const [loading, setLoading] = useState(false);

  const handleCreateTeam = async () => {
    if (!teamName.trim()) {
      Alert.alert("Error", "El nombre del equipo no puede estar vacío");
      return;
    }

    setLoading(true);

    try {
      const token = await SecureStore.getItemAsync("access_token");
      if (!token) {
        Alert.alert("Error", "No estás autenticado");
        return;
      }

      const response = await fetch("http://192.168.0.18:8000/api/team", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
          name: teamName,
        }),
      });

      const data = await response.json();

      if (data.status) {
        Alert.alert("Éxito", `El equipo "${teamName}" fue creado exitosamente`);
        router.replace("/admin/teams");
      } else {
        Alert.alert("Error", "Hubo un problema al crear el equipo");
      }
    } catch (error) {
      console.error("Error al crear el equipo:", error);
      Alert.alert("Error", "Hubo un error en la comunicación con el servidor");
    } finally {
      setLoading(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: "#FFFFFF" }]}>
      <Text style={styles.title}>Crear Nuevo Equipo</Text>

      <TextInput
        style={styles.input}
        placeholder="Nombre del equipo"
        value={teamName}
        onChangeText={setTeamName}
      />

      <Button
        title={loading ? "Creando..." : "Crear Equipo"}
        onPress={handleCreateTeam}
        disabled={loading}
      />
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
    marginBottom: 20,
  },
  input: {
    width: "100%",
    padding: 10,
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 5,
    marginBottom: 20,
  },
});
