/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package loginEInterfaz;


public class PasswordValidator {
    
    public static boolean validar(String password) {
        if (password.length() < 12) {
            return false;
        }
        
        boolean tieneMayus = false;
        boolean tieneSimbolo = false;
        
        for  (char c : password.toCharArray()) {
            if (Character.isUpperCase(c)) {
                tieneMayus = true;
            } else if (!Character.isLetterOrDigit(c)) {
                tieneSimbolo = true;
            }
            
            if (tieneMayus && tieneSimbolo) {
                return true;
            }
        }
        return false;
    }
    
    
}
