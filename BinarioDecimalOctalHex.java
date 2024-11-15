/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */

package proyectos.binariodecimaloctalhex;

import java.util.Scanner;

/**
 *
 * @author Analia
 */
public class BinarioDecimalOctalHex {

    public static void main(String[] args) {
        String  binario;
        int cont=0;
        Scanner sc = new Scanner(System.in);
        
        System.out.println("ingrese un numero binario");
        
        binario = sc.nextLine();
        if(binario.length() != 16 ) {
            System.out.println("error");
            return;
        }
        
        int decimal = Integer.parseInt(binario, 2);        
        System.out.println("El numero "+ binario + " en decimal es: " + decimal);
        
        
        String octal = Integer.toOctalString(decimal);
        System.out.println("El numero "+ binario + " en octal es: " + octal);
        
        String hexa = Integer.toHexString(decimal);
        System.out.println("El numero "+ binario + " en hexa es: " + hexa);
        
        
//        cont = binario.length();
        
        
        //System.out.println(cont);
    }
}
