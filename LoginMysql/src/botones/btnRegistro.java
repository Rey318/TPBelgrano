/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package botones;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import javax.swing.JOptionPane;
import loginEInterfaz.HashPass;
import loginEInterfaz.Login;
import conectar.Conexion; 
import loginEInterfaz.RegistroFrame;


public class btnRegistro {
    //Constante de conexion
    private final Conexion conect;
    
    public btnRegistro() {
        conect = new Conexion();
    }
    public void registrarUsuario(String usuario, String contraseña, RegistroFrame registroFrame) {
        try {
            // Hashear la contraseña antes de almacenarla
            String contraseñaHasheada = HashPass.hashP(contraseña); //Hash tiene validaciones
            if (contraseñaHasheada == null) {
                JOptionPane.showMessageDialog(null, "Error al insertar la contraseña");
                return;
            }

            // Consulta SQL para insertar el nuevo usuario
            String query = "INSERT INTO usuarios (user, pass) VALUES (?, ?)";
                 try (Connection connection = conect.getConexion(); 
                 PreparedStatement preparedStatement = connection.prepareStatement(query)) {
                // Preparamos la consulta     
                preparedStatement.setString(1, usuario);
                preparedStatement.setString(2, contraseñaHasheada);
                preparedStatement.executeUpdate();

                JOptionPane.showMessageDialog(null, "Usuario registrado correctamente");

                // Cerrar la ventana de registro
                registroFrame.dispose();

                // Abrir una nueva ventana de inicio de sesión
                Login login = new Login();
                login.setVisible(true);
            }
        } catch (SQLException ex) {
            JOptionPane.showMessageDialog(null, "Error al registrar usuario: " + ex.getMessage());
            ex.printStackTrace();
        } finally {
            conect.close();
        }
    }
}
