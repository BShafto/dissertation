package ordergeneration;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.math.BigDecimal;
import java.util.Calendar;

/**
 * @author bshafto
 */
public class Order {
    private ArrayList<Drink> drinksOrdered = new ArrayList<Drink>(); 
    private static int count = 1;
    private int orderID = 0;
    private int noDrinks = 0;
    private BigDecimal totalCost = new BigDecimal("0.00");
    private String timeStamp = "";

    public Order(){
        orderID = count++;
        calcTimeStamp();
    }
    
    public int getOrderID(){
        return orderID;
    }
    
    public void addDrink(Drink drnk){
        noDrinks++;
        BigDecimal temp = BigDecimal.valueOf(drnk.getCurrentPrice());
        drinksOrdered.add(drnk);
        totalCost = totalCost.add(temp);
    }
 
    public void calcTimeStamp(){
        Calendar cal = Calendar.getInstance();
        cal.getTime();
        SimpleDateFormat sdf = new SimpleDateFormat("HH:mm:ss");
        timeStamp = sdf.format(cal.getTime());
    }
    
    public ArrayList<Drink> getDrinksOrdered(){
        return drinksOrdered;
    }
    
    public BigDecimal getOrderTotal(){
        return totalCost;
    }
    
    public int getNoDrinks(){
        return noDrinks;
    }
    
    public String getTimeStamp(){
        return timeStamp;
    }
    
}
