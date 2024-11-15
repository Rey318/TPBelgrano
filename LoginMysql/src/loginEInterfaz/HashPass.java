/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package loginEInterfaz;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;


public class HashPass {
    
    public static String hashP(String password) {
        try {
            //Algoritmo SHA-256
            MessageDigest dg = MessageDigest.getInstance("SHA-256");
            
           byte[] hash = dg.digest(password.getBytes());
           
           // Convertimos el hash a HexaDecimal
           StringBuilder hexString = new StringBuilder();
           for (byte b: hash) {
               //convertir cada byte a HEXA
               String hex = Integer.toHexString(0xff & b);
               if (hex.length() == 1) hexString.append('0') ;
               hexString.append(hex);          
           }
             return hexString.toString();
        } catch (NoSuchAlgorithmException e) {
            
            System.out.println("Error" + e.getMessage() );
            return null;
        }
    }
}
