/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package loginEInterfaz;
import conectar.Conexion;
import java.sql.PreparedStatement;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;


public class EliminarContacto {
    
    public void EliminarContacto(int id_Contacto) {
       String url = "jdbc:mysql://localhost:3306/usuario";
        String user = "root";
        String pass = "Rooot";
        
        String consulta = "DELETE FROM contactos WHERE id_Contacto = ?";
        
        try (Connection con = DriverManager.getConnection(url, user, pass);
            PreparedStatement stmt = con.prepareStatement(consulta)) {
            stmt.setInt(1, id_Contacto);
            int filaAfectada = stmt.executeUpdate();
            
            if (filaAfectada > 0) {
                JOptionPane.showMessageDialog(null, "El contacto ha sido eliminado exitosamente");
            } else {
                 JOptionPane.showMessageDialog(null, "No se encontro el contacto id");
            }
        } catch (SQLException ex) {
             JOptionPane.showMessageDialog(null, "No se puede eliminar el contacto");
        }
    }
}

