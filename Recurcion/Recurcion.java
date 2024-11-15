/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */
package aritmgeomet.recurcion;

import java.util.Scanner;

public class Recurcion {

    public static void main(String[] args) {
        // Variables
        Scanner sc = new Scanner(System.in);
        int an = 0;
        int n = 0;
        int a1 = 0;
        int x = 0;
        
        //Mensajes para llenar campos
        System.out.println("Ingrese la diferencia");
        x = sc.nextInt();

        System.out.println("Ingrese A-1");
        a1 = sc.nextInt();

        System.out.println("Ingrese N numero");

        n = sc.nextInt();

        an = generarNum(x, a1, n);

    }
// Metodo para los calculos en la recurcion
    private static int generarNum(int x, int a1, int n) {
        if (n == 0) {
            return 0;
        } else {
            int an = a1 + (n - 1) * x;
            System.out.println("an = " + an);
            //Recurcion
            an = generarNum(x, a1, n - 1);

            return an;
        }

    }
}
