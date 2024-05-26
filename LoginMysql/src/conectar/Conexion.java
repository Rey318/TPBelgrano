package conectar;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class Conexion {

    private Connection conect;

    public Conexion() {
        String url = "jdbc:mysql://localhost:3306/usuario";
        String user = "root";
        String pass = "Rooot";

        try {
            conect = DriverManager.getConnection(url, user, pass);
//            System.out.println("Conexion exitosa");
        } catch (SQLException ex) {
            System.out.println("Conexion Fallida: " + ex.getMessage());
        }
    }
    
    // metodo de conexion
    public Connection getConexion() {
        return conect;
    }
   //metodo de consulta
    public boolean conexion(String usuario, String contraseña) {
        try {
            //consulta
            String query = "SELECT * FROM usuarios WHERE user = ? AND pass = ? ";
            
            try (PreparedStatement preparedStatement = conect.prepareStatement(query)) {
                preparedStatement.setString(1, usuario);
                preparedStatement.setString(2, contraseña);
                try (ResultSet resultSet = preparedStatement.executeQuery()) {
                    return resultSet.next();
                }
            }
        } catch (SQLException ex) {
            System.out.println("Error: " + ex.getMessage());
            return false;
        }
    }
    //metodo cerrar la conexion
    public void close() {
        try {
            if (conect != null) {
                conect.close();
            }

        } catch (SQLException ex) {
            System.out.println("Error al cerrar la conexion: " + ex.getMessage());
        }
    }
}
