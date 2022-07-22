package ordergeneration;

import java.math.BigDecimal;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;

/**
 * @author bshafto
 */
public class FiveMinOrder {
    private int fiveMinOrderID = 0;
    private static int count = 0;
    private String timeStamp = "";
    private int noOrders = 0; 
    private BigDecimal totalOrdersCost = new BigDecimal("0.00");
    private ArrayList<Order> orders = new ArrayList<Order>(); 

    public FiveMinOrder(){
        fiveMinOrderID = count++;
        calcTimeStamp();
    }
 
    public void addOrders(ArrayList<Order> ord){
        noOrders = OrderGeneration.listOfOrders.size();
        BigDecimal fiveMinTotal;
        
        for(int i=0; i<noOrders;i++){
            fiveMinTotal = OrderGeneration.listOfOrders.get(i).getOrderTotal();
            totalOrdersCost = totalOrdersCost.add(fiveMinTotal);
        }
    }
    
    public void calcQuantities(){
        
    }
    
    
    
    
    
    
    
    public ArrayList<Order> getOrders(){
        return orders;
    }
    
    public int getFiveMinOrderID(){
        return fiveMinOrderID;
    }
    
    public int getNoOrdersFor5Mins(){
        return noOrders;
    }
    
    public BigDecimal getTotalOrdersCost(){
        return totalOrdersCost;
    }
    
    public void calcTimeStamp(){
        Calendar cal = Calendar.getInstance();
        cal.getTime();
        SimpleDateFormat sdf = new SimpleDateFormat("HH:mm");
        timeStamp = sdf.format(cal.getTime());
    }
    
    public String getTimeStamp(){
        return timeStamp;
    }
}
