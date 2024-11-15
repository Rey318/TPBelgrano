/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */

package proyectos.relaciondeclases;

import java.util.ArrayList;


public class RelacionDeClases {

    public static void main(String[] args) {
        
        System.out.println("===Ventas===");
        
        Cliente cli = new Cliente(101, "pami");
        Fecha fecha = new Fecha(3, 12 ,24);
        
        ArrayList<Producto> productos = new ArrayList<>();
        productos.add(new Producto(101, "Televisor HD", 1000));
        productos.add(new Producto(105, "Consola de juegos", 800));        
        mostrarDatos(cli, fecha, productos);
    
    }
    
    public static void mostrarDatos(Cliente cli, Fecha fecha, ArrayList<Producto> productos) {
        System.out.println("El cliente " + cli.getCodigo() + " y su razon social es: " + cli.getRazonSocial() );
        System.out.println("Fecha: " + fecha.getDia() + "-" +fecha.getMes()+ "-" +fecha.getAño() );
        System.out.println("Productos: ");
        
        for (Producto producto: productos) {
            System.out.println("Codigo nro: " + producto.getCodigo() + " Descripcion: " + producto.getDescripcion() + " Precio: " + producto.getPrecio());
        }
        
        
        int totalVenta = 0;
        // calcular el total de la venta con un foreach
        for (Producto producto: productos) {
            totalVenta += producto.getPrecio();            
        }
        
        //imprimir el total       
        System.out.println("El precio total es: " + totalVenta);
        
        
    }
}
