/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package botones;

import java.sql.Connection;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JTextField;
import Persona.Contactos;
import conectar.Conexion;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class agregarBoton implements ActionListener {

    private JTextField dniField;
    private JTextField nomField;
    private JTextField apeField;
    private JTextField direField;
    private JTextField correoField;
    private JTextField localField;
    private Conexion conect;

   public agregarBoton(JTextField dniField, JTextField nombre, JTextField apellido, JTextField direccion, JTextField correo, JTextField localidad, Conexion conect) {
        this.dniField = dniField;
        this.nomField = nombre;
        this.apeField = apellido;
        this.direField = direccion;
        this.correoField = correo;
        this.localField = localidad;
        this.conect = conect;
    }

    @Override
    public void actionPerformed(ActionEvent e) {

        try {
             
            int dni = Integer.parseInt(dniField.getText());
            String nombre = nomField.getText();
            String apellido = apeField.getText();
            String direccion = direField.getText();
            String correo = correoField.getText();
            String localidad = localField.getText();

            Contactos pers = new Contactos(8, dni, nombre, apellido, direccion, correo, localidad);

            guardarBaseDatos(pers);
            
           
        } catch (Exception ex) {
            System.out.println("Error");
        }

    }

    private void guardarBaseDatos(Contactos pers) {

        // Consulta
        String query = "INSERT INTO contactos ( dni, nombre, apellido, direccion,correo, localidad) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        try (PreparedStatement stmt = conect.getConexion().prepareStatement(query)) {
           
            stmt.setInt(1, pers.getDni());
            stmt.setString(2, pers.getNombre());
            stmt.setString(3, pers.getApellido());
            stmt.setString(4, pers.getDireccion());
            stmt.setString(5, pers.getCorreo());
            stmt.setString(6, pers.getLocalidad());

           int filasOcupada = stmt.executeUpdate();
            System.out.println("Se cargo exitosamente los datos " + filasOcupada);
            stmt.close();
           
            
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Error");
        }
    }

}
