package ordergeneration;

import java.math.BigDecimal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

/**
 * @author bshafto
 */
public class DailyOrders {
    private int dailyOrderID = 0;
    private static int count = 0;
    private String dayStamp = "";
    private int noOrders = 0; 
    private BigDecimal totalDayOrdersCost = new BigDecimal("0.00");
    private ArrayList<Order> orders = new ArrayList<Order>();
    private Date date = Calendar.getInstance().getTime();
    private int totalNoOrders = 0;
    
    public DailyOrders(){
        dailyOrderID = count++;
        calcTimeStamp();
    }
    
    public void addOrders(ArrayList<FiveMinOrder> ord){
        noOrders = OrderGeneration.all5MinOrders.size();
        BigDecimal dayTotal;
        
        for(int i=0; i<noOrders;i++){
            dayTotal = OrderGeneration.all5MinOrders.get(i).getTotalOrdersCost();
            totalDayOrdersCost = totalDayOrdersCost.add(dayTotal); 
            //totalNoOrders = OrderGeneration.all5MinOrders.get(all5MinOrders.size()-1).getOrders().get(listOfOrders.size()-1).getOrderID();
            //System.out.println(totalNoOrders);
        }
    }    
    
    public int getDailyOrderID(){
        return dailyOrderID;
    }
    
    public int getNoOrdersForDay(){
        return totalNoOrders;
    }
    
    public BigDecimal getDayOrdersTotal(){
        return totalDayOrdersCost;
    }
    
    public String getDayStamp(){
        return dayStamp;
    }
    
    public void calcTimeStamp(){
        Calendar cal = Calendar.getInstance();
        cal.getTime();
        DateFormat formatter = new SimpleDateFormat("dd/MM/yyyy");
        dayStamp = formatter.format(date);
    }
}
