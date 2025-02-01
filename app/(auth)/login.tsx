import { Colors } from "@/constants/Colors";
import { useRouter } from "expo-router";
import * as SecureStore from "expo-secure-store";
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

export default function LoginScreen() {
  const router = useRouter();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const colorScheme = useColorScheme();
  const theme = Colors[colorScheme ?? "light"];

  const handleLogin = async () => {
    if (email && password) {
      try {
        const response = await fetch("http://192.168.0.18:8000/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({ email, password }),
        });

        const data = await response.json();
        if (response.ok) {
          const { token, user } = data;
          // Guardar token en SecureStore
          await SecureStore.setItemAsync("access_token", token);
          Alert.alert("Login exitoso", `Bienvenido ${user.name}`);
          router.replace("/admin/dashboard"); // Redirigir a todos al dashboard
        } else {
          Alert.alert("Error", "Credenciales incorrectas");
        }
      } catch (error) {
        Alert.alert("Error", "Hubo un problema con la conexión");
      }
    } else {
      Alert.alert("Error", "Por favor, ingresa tus credenciales");
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: "#1E9B27" }]}>
      <Text style={styles.title}>Iniciar Sesión</Text>
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
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />
      <Button title="Ingresar" onPress={handleLogin} />
      <TouchableOpacity onPress={() => router.push("/(auth)/register")}>
        <Text style={styles.link}>¿No tienes cuenta? Regístrate</Text>
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
    marginTop: 10,
    color: "#FFFFFF",
    textDecorationLine: "underline",
  },
});
