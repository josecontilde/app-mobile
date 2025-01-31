import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import { Alert, Button, FlatList, StyleSheet, Text, TextInput, TouchableOpacity, View } from 'react-native';

type Team = {
  id: string;
  name: string;
};

export default function ManageTeamsScreen() {
  const router = useRouter();

  // Lista de equipos (esto normalmente vendría desde un backend)
  const [teams, setTeams] = useState<Team[]>([
    { id: '1', name: 'Equipo Alpha' },
    { id: '2', name: 'Equipo Beta' },
    { id: '3', name: 'Equipo Gamma' },
  ]);

  const [editingTeamId, setEditingTeamId] = useState<string | null>(null);
  const [newTeamName, setNewTeamName] = useState('');

  const handleEditTeam = (teamId: string, currentName: string) => {
    setEditingTeamId(teamId);
    setNewTeamName(currentName);
  };

  const handleSaveEdit = () => {
    if (!newTeamName.trim()) {
      Alert.alert('Error', 'El nombre no puede estar vacío');
      return;
    }

    setTeams(prevTeams =>
      prevTeams.map(team =>
        team.id === editingTeamId ? { ...team, name: newTeamName } : team
      )
    );

    setEditingTeamId(null);
    setNewTeamName('');
    Alert.alert('Éxito', 'Equipo actualizado correctamente');
  };

  const handleDeleteTeam = (teamId: string) => {
    Alert.alert('Eliminar Equipo', '¿Estás seguro de que quieres eliminar este equipo?', [
      { text: 'Cancelar', style: 'cancel' },
      {
        text: 'Eliminar',
        onPress: () => {
          setTeams(prevTeams => prevTeams.filter(team => team.id !== teamId));
          Alert.alert('Equipo eliminado');
        },
        style: 'destructive',
      },
    ]);
  };

  return (
    <View style={[styles.container, { backgroundColor: '#FFFFFF' }]}>
      <Text style={styles.title}>Gestionar Equipos</Text>

      <FlatList
        data={teams}
        keyExtractor={team => team.id}
        renderItem={({ item }) => (
          <View style={styles.teamItem}>
            {editingTeamId === item.id ? (
              <>
                <TextInput
                  style={styles.input}
                  value={newTeamName}
                  onChangeText={setNewTeamName}
                  autoFocus
                />
                <Button title="Guardar" onPress={handleSaveEdit} />
              </>
            ) : (
              <>
                <Text style={styles.teamName}>{item.name}</Text>
                <View style={styles.buttonsContainer}>
                  <TouchableOpacity onPress={() => handleEditTeam(item.id, item.name)}>
                    <Text style={styles.editButton}>✏️ Editar</Text>
                  </TouchableOpacity>
                  <TouchableOpacity onPress={() => handleDeleteTeam(item.id)}>
                    <Text style={styles.deleteButton}>🗑 Eliminar</Text>
                  </TouchableOpacity>
                </View>
              </>
            )}
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
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  teamItem: {
    backgroundColor: '#f9f9f9',
    padding: 15,
    borderRadius: 10,
    marginBottom: 10,
  },
  teamName: {
    fontSize: 18,
    fontWeight: 'bold',
  },
  buttonsContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },
  editButton: {
    color: 'blue',
    fontSize: 16,
  },
  deleteButton: {
    color: 'red',
    fontSize: 16,
  },
  input: {
    borderBottomWidth: 1,
    borderColor: '#ccc',
    padding: 5,
    marginBottom: 10,
  },
});
