package ordergeneration;
/**
 * @author bshafto
 */
public class Drink {
    private int ID = 0;
    private String name = "";
    private double currentPrice = 0.0;
    private double maxPrice = 0.0;
    private double minPrice = 0.0;
    private String catagory = "";
    private double movement = 0.0;
    
    public Drink(int I, String n, double cP, double mxp, double mnp, String c, double m){
        //This class has 7 constructors
        ID = I;
        name = n;
        currentPrice = cP;
        maxPrice = mxp;
        minPrice = mnp;
        catagory = c;
        movement = m;
    }
    
    public Drink(double cP){
        currentPrice = cP;
    }
    
    public int getID(){
        return ID;
    }
    
    public String getName(){
        return name;
    }
    
    public double getMaxPrice(){
        return maxPrice;
    }
    
    public double getCurrentPrice(){
        return currentPrice;
    }
    
    public double setCurrentPrice(double currentPrice){
        this.currentPrice = currentPrice;
        return this.currentPrice;
    }
    
    public double getMinPrice(){
        return minPrice;
    }
    
    public String getCatagory(){
        return catagory;
    }
    
    public double setMovement(double movement){
        this.movement = movement;
        return this.movement;
    }
    
    public double getMovement(){
        return movement;
    }
}
