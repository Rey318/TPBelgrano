/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package proyectos.relaciondeclases;

import java.util.ArrayList;


public class Factura extends Comprobante {
     private ArrayList<Producto> mProductos;
     private  float total;
     private Cliente mcliente;

    public Factura(ArrayList<Producto> mProductos, float total, Cliente mcliente, char tipo, int numero, Fecha fecha, int dia, int mes, int año) {
        super(tipo, numero, fecha, dia, mes, año);
        this.mProductos = mProductos;
        this.total = total;
        this.mcliente = mcliente;
    }
     
     

    public Factura(char tipo, int numero, Fecha fecha, int dia, int mes, int año) {
        super(tipo, numero, fecha, dia, mes, año);
    }
     
     
}
