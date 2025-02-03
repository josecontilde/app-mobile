import { Picker } from "@react-native-picker/picker";
import { useLocalSearchParams, useRouter } from "expo-router";
import * as SecureStore from "expo-secure-store";
import React, { useState } from "react";
import { Alert, Button, StyleSheet, Text, TextInput, View } from "react-native";
import { Calendar } from "react-native-calendars";

export default function CreateTaskScreen() {
  const router = useRouter();
  const { teamId } = useLocalSearchParams();
  const [taskName, setTaskName] = useState("");
  const [description, setDescription] = useState("");
  const [status, setStatus] = useState("Pendiente");
  const [priority, setPriority] = useState("Media");
  const [dueDate, setDueDate] = useState("");

  const handleCreateTask = async () => {
    if (!taskName || !description || !dueDate || !teamId) {
      Alert.alert("Error", "Todos los campos son obligatorios");
      return;
    }

    const token = await SecureStore.getItemAsync("access_token");
    if (token) {
      try {
        const response = await fetch(
          `http://192.168.0.18:8000/api/team/${teamId}/task`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
              name: taskName,
              description,
              status,
              priority,
              due_date: dueDate,
            }),
          }
        );
        const data = await response.json();

        if (data.status) {
          Alert.alert(
            "Tarea Creada",
            `Tarea "${taskName}" ha sido creada exitosamente.`
          );
          router.replace("/admin/tasks");
        } else {
          Alert.alert("Error", "No se pudo crear la tarea.");
        }
      } catch (error) {
        console.error("Error al crear la tarea:", error);
        Alert.alert("Error", "Hubo un problema al crear la tarea.");
      }
    }
  };

  const handleDateChange = (day: any) => {
    setDueDate(day.dateString);
  };

  return (
    <View style={[styles.container, { backgroundColor: "#FFFFFF" }]}>
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
      <Picker
        selectedValue={status}
        onValueChange={setStatus}
        style={styles.picker}
      >
        <Picker.Item label="Pendiente" value="pending" />
        <Picker.Item label="En progreso" value="in_progress" />
        <Picker.Item label="Completada" value="completed" />
      </Picker>

      <Text style={styles.label}>Prioridad:</Text>
      <Picker
        selectedValue={priority}
        onValueChange={setPriority}
        style={styles.picker}
      >
        <Picker.Item label="Baja" value="low" />
        <Picker.Item label="Media" value="medium" />
        <Picker.Item label="Alta" value="high" />
      </Picker>

      <Text style={styles.label}>Fecha de vencimiento:</Text>
      <Calendar
        markedDates={{
          [dueDate]: { selected: true, selectedColor: "blue" },
        }}
        onDayPress={handleDateChange}
      />

      <Button title="Crear Tarea" onPress={handleCreateTask} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: "#fff",
    justifyContent: "center",
  },
  title: {
    fontSize: 24,
    fontWeight: "bold",
    marginBottom: 20,
    textAlign: "center",
  },
  input: {
    width: "100%",
    padding: 10,
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 5,
    marginBottom: 10,
  },
  label: {
    fontSize: 16,
    fontWeight: "bold",
    marginTop: 10,
  },
  picker: {
    height: 50,
    width: "100%",
    marginBottom: 10,
  },
});
