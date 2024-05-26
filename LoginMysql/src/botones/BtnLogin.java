/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package botones;

import conectar.Conexion;
import java.sql.Connection;
import java.sql.SQLException;
import javax.swing.JOptionPane;
import loginEInterfaz.AgendaFrame;
import loginEInterfaz.HashPass;
import loginEInterfaz.Login;

public class BtnLogin {   
    // Constantes privadas
    private final Conexion conec;
    private final Login loginFrame;
    
   // Constructor hacer referencia esta ventana por si tenemos que quitarla o volverla a poner
    public BtnLogin(Login loginFrame) {
        this.loginFrame = loginFrame;
        conec = new Conexion();
    } 

    public void iniciarSesion(String usuario, String contraseña) {
        try {            
            // Hashear el password con la clase que cree para hashear
            String contraseñaHasheada = HashPass.hashP(contraseña);
            if (contraseñaHasheada == null) {
                JOptionPane.showMessageDialog(null, "Error al inserta la contraseña");
                return;
            }            
            if (conec.conexion(usuario, contraseña)) {
                System.out.println("Sesion Iniciada correctamente");
                AgendaFrame af = new AgendaFrame();
                af.setVisible(true);
                
                // Cerra la ventana de login  
                 loginFrame.dispose();

            } else {
                //Mensaje de error y limpieza de campos
                JOptionPane.showMessageDialog(null, "El usuario o la contraseña son incorrectas");
                loginFrame.limpiarCampos();
                
            }
        } catch (Exception e) {
            System.out.println("Error al iniciar sesion" + e.getMessage());
            e.printStackTrace();
        } finally {
            conec.close();
        }
    }
    
    

}
