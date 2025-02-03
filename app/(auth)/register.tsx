import { Colors } from "@/constants/Colors";
import { useRouter } from "expo-router";
import * as SecureStore from "expo-secure-store"; // Importar SecureStore
import { useState } from "react";
import {
  Alert,
  Button,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  useColorScheme,
  View,
} from "react-native";

export default function RegisterScreen() {
  const router = useRouter();
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirmation, setPasswordConfirmation] = useState(""); // Nuevo campo de confirmación de contraseña
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? "light"];

  const handleRegister = async () => {
    if (name && email && password && password_confirmation) {
      if (password !== password_confirmation) {
        Alert.alert("Error", "Las contraseñas no coinciden");
        return;
      }

      try {
        const response = await fetch("http://192.168.0.18:8000/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            name,
            email,
            password,
            password_confirmation,
          }),
        });

        const data = await response.json();

        if (response.ok) {
          const { token } = data;

          await SecureStore.setItemAsync("access_token", token);

          Alert.alert("Registro exitoso", "Ahora puedes iniciar sesión");
          router.replace("/(auth)/login");
        } else {
          Alert.alert(
            "Error",
            data.message || "Hubo un problema al registrar el usuario"
          );
        }
      } catch (error) {
        console.error("Error en el registro:", error);
        Alert.alert("Error", "Hubo un problema al registrar el usuario");
      }
    } else {
      Alert.alert("Error", "Todos los campos son obligatorios");
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: "#1E9B27" }]}>
      <Text style={styles.title}>Registrarse</Text>
      <TextInput
        style={[
          styles.input,
          { backgroundColor: theme.inputBackground, color: theme.inputText },
        ]}
        placeholder="Nombre"
        placeholderTextColor={theme.icon}
        value={name}
        onChangeText={setName}
      />
      <TextInput
        style={[
          styles.input,
          { backgroundColor: theme.inputBackground, color: theme.inputText },
        ]}
        placeholder="Correo electrónico"
        placeholderTextColor={theme.icon}
        keyboardType="email-address"
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        style={[
          styles.input,
          { backgroundColor: theme.inputBackground, color: theme.inputText },
        ]}
        placeholder="Contraseña"
        placeholderTextColor={theme.icon}
        secureTextEntry
        value={password}
        onChangeText={setPassword}
      />
      <TextInput
        style={[
          styles.input,
          { backgroundColor: theme.inputBackground, color: theme.inputText },
        ]}
        placeholder="Confirmar Contraseña"
        placeholderTextColor={theme.icon}
        secureTextEntry
        value={password_confirmation}
        onChangeText={setPasswordConfirmation}
      />
      <Button title="Registrarse" onPress={handleRegister} />

      <TouchableOpacity onPress={() => router.push("/(auth)/login")}>
        <Text style={styles.link}>¿Ya tienes cuenta? Inicia sesión</Text>
      </TouchableOpacity>
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
    color: "#FFFFFF",
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
    marginBottom: 10,
  },
  link: {
    color: "#FFFFFF",
    marginTop: 10,
    textDecorationLine: "underline",
  },
});
