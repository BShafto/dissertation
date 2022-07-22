package ordergeneration;

import java.math.BigDecimal;
import java.math.RoundingMode;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.Random;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

/**
 * @author bshafto The code for the order generation should: - Simulate a random
 * amount of orders (100~200) every 5 minutes. - a timeStamp would be the first
 * minute of the 5. Then change after 5 minutes. 1. Create a 2d 'drinks' array.
 * Full of drinks names, min/max price... 1.1. Drinks prices initialise as
 * sensible prices. 1.2. Every 5 minutes the new drinks prices are stored into
 * the nested array. 1.3. The 2d drinks array is sent for trend analysis on the
 * website. 2. Create an 'order history' array (nested). 3. Create a 'current
 * orders' array. 4. Create an 'order' array. 5. Go through a loop randomly
 * selecting between 1-6 drinks from the 'drinks' array. 6. Each order is an
 * array which contains: 6.1. Drink ID 6.2. Drink name 6.3. Current price 6.4.
 * Timestamp 6.5. Total cost 7. Each order must be stored to recalculate the new
 * drinks prices in that algorithm. 8. After 5 minutes have passed: 8.1.
 * 'Current orders' array is added to 'order history' array. 8.2. 'Current
 * orders' is cleared. 8.3. Drinks prices are recalculated. 8.4. Data is sent
 * back to the database to be used for trend analysis.
 * 
 * http://www.javaguicodexample.com/javawebmysqljspjstljsf5.html
 */
public class OrderGeneration {

    public Menu m = new Menu();
    public ArrayList<Drink> drinksMenu = m.createMenu();
    public static ArrayList<Order> listOfOrders = new ArrayList<Order>();
    public static ArrayList<FiveMinOrder> all5MinOrders = new ArrayList<FiveMinOrder>();
    private int row = 2;
    private int col = drinksMenu.size();
    private double[][] drinksPrices = new double[row][col];
    private double[] movement = new double[col];
    private int[] quantityOfDrinks = new int[col];
    private int[] drinksProb = new int[500];
    private ArrayList<Integer> probabilities = new ArrayList<Integer>();
    private int[] probOfDrink = new int[col];
    private static final BigDecimal ONE_HUNDRED = new BigDecimal(100);
    private BigDecimal[] percMovement = new BigDecimal[col];

    private DecimalFormat df = new DecimalFormat("#.##");
    private int interval;
    private static final int no5Mins = 0;
    private final int maxNoDrinksInOrder = 10;
    private final int noOrdersIn5Mins = 50;
    private final int bias = 10;
    private String tableName;
    private int runSpeed = 4; 
    
    private Connection conn = null;
    private PreparedStatement pstmt = null;

    
    public void addToDatabase(String tableName, int[] a){
        try{
            Class.forName("com.mysql.jdbc.Driver");
            String connectionURL = ("jdbc:mysql://localhost:3306/stockexchange?autoReconnect=true&useSSL=false");
            conn = DriverManager.getConnection(connectionURL,"root","root");
            
            pstmt = conn.prepareStatement("insert into "+tableName+" values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            pstmt.setNull(1, java.sql.Types.INTEGER);               
            for(int k=2; k<col+2;k++){
                pstmt.setString(k, Integer.toString(a[k-2]));
            }

            int k = pstmt.executeUpdate();
            if(k>0){
                System.out.println("Data has been saved to "+tableName+".");
            }else{
                System.out.println("Data has not been saved to "+tableName+".");
            }
        }catch(Exception e){
            System.out.println("Error message: " + e);
        }  
    }
    
    public void addToDatabase(String tableName, double[] a){
        try{
            Class.forName("com.mysql.jdbc.Driver");
            String connectionURL = ("jdbc:mysql://localhost:3306/stockexchange?autoReconnect=true&useSSL=false");
            conn = DriverManager.getConnection(connectionURL,"root","root");
            
            pstmt = conn.prepareStatement("insert into "+tableName+" values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            pstmt.setNull(1, java.sql.Types.INTEGER);               
            for(int k=2; k<col+2;k++){
                pstmt.setString(k, Double.toString(a[k-2]));
            }

            int k = pstmt.executeUpdate();
            if(k>0){
                System.out.println("Data has been saved to "+tableName+".");
            }else{
                System.out.println("Data has not been saved to "+tableName+".");
            }
        }catch(Exception e){
            System.out.println("Error message: " + e);
        }  
    }

    public static void main(String[] args) {
//        Timer timer = new Timer();
//        timer.schedule(new SayHello(), 0, 5000);
        
        new OrderGeneration().initialiseDrinksPrices();
        //new OrderGeneration().generate5MinValues();
        new OrderGeneration().runProgramIncrementaly();
    }

    public void calcOrderedDrinks() {
        System.out.println("Quantities of drinks");
        int[] idArray = new int[col];

        for (int i = 0; i < col; i++) {
            quantityOfDrinks[i] = 0;
            drinksProb[i] = 0;
            movement[i] = 0;
            idArray[i] = 0;
        }
        probabilities.clear();

        initialiseDrinksPrices();
        int temp = 0;
        for (int j = 0; j < listOfOrders.size(); j++) {
            for (int k = 0; k < listOfOrders.get(j).getNoDrinks(); k++) {
                temp = listOfOrders.get(j).getDrinksOrdered().get(k).getID();
                quantityOfDrinks[temp]++;
            }
        }        
        //--------------------------Update Database with quantities--------------------------------------------
        tableName = ("drink_quantities");
        addToDatabase(tableName, quantityOfDrinks);
        //-----------------------------------------------------------------------------------------------------
//        System.out.println();
//        System.out.println("Quantities of drinks bought.");
        int totalD = 0;
        for (int i = 0; i < quantityOfDrinks.length; i++) {
            totalD += quantityOfDrinks[i];
            System.out.print(quantityOfDrinks[i] + "__");
        }
        System.out.println();
        System.out.println("Total No. drinks = "+totalD);
        //-----------------------------------------------------------------------------------------------------        
        System.out.println("Percentages of drinks ordered.");

        BigDecimal totalP = new BigDecimal("0.00");
        for (int i = 0; i < quantityOfDrinks.length; i++) {
            BigDecimal quant = new BigDecimal(quantityOfDrinks[i]);
            BigDecimal totalOr = new BigDecimal(totalD);
            //round the BigDecimal to 2 d.p.
            percMovement[i] = (quant.multiply(ONE_HUNDRED).divide(totalOr, 2, RoundingMode.HALF_UP));
            totalP = totalP.add(percMovement[i]);
            System.out.print(percMovement[i] + "_");
        }
        System.out.println();
        //-----------------------------------------------------------------------------------------------------
        double[] upPr = new double[col];
        double result = 0.0;
        double perc;
        BigDecimal max = new BigDecimal("0.00");
        BigDecimal min = new BigDecimal("0.00");
        int oldMaxID = 0;
        int oldMinID = 0;
        int maxID = 0;
        int minID = 0;
        int to, probMax, probMin;
        String dir1 = "";
        String dir2 = "";
        
        for (int i = 0; i < col - 10; i++) {    //col-10 is how many times round the loop should run to change all the prices.
            if (i == 0) {
                max = percMovement[0];          //this if loop sets the first array value
                min = percMovement[0];
            } else {
                max = percMovement[minID];
                min = percMovement[maxID];
            }
            // Using percMovement, loop through each drink's % and see which has the highest % (therefore the most number 
            // of drinks) and the lowest %. Then the 2nd highest, 2nd lowest...
            
            for (int j = 0; j < col; j++) {
                int resMax, resMin, resOldMax, resOldMin;
                resMax = percMovement[j].compareTo(max);        // 1 shows left is greater than right
                resMin = percMovement[j].compareTo(min);        // -1 shows left is less than right
                //Check if the maximum j is more or equal to the last maximum j
                if (resMax == 1 || resMax == 0) {
                    if (i != 0) {
                        if (idArray[j] == 0) {
                            //Check that the j is less or equal to the last max j
                            resOldMax = percMovement[j].compareTo(percMovement[oldMaxID]);
                            if (resOldMax == -1 || resOldMax == 0) {
                                //Check if that id has already been added to idArray 
                                max = percMovement[j];
                                maxID = j;
                            }
                        }
                    } else {
                        max = percMovement[j];
                        maxID = j;
                    }
                }
                //Check if the minimum j is less or equal to the last minimum j
                if (resMin == -1 || resMin == 0) {
                    if (i != 0) {
                        //Check if that id has already been added to idArray 
                        if (idArray[j] == 0) {
                            //Check if j is greater or equal to the oldMin printed out 
                            resOldMin = percMovement[j].compareTo(percMovement[oldMinID]);
                            if (resOldMin == 1 || resOldMin == 0) {
                                min = percMovement[j];
                                minID = j;
                            }
                        }
                    } else {
                        min = percMovement[j];
                        minID = j;
                    }
                }
            }
            idArray[maxID] = 1;
            idArray[minID] = 1;
            oldMaxID = maxID;
            oldMinID = minID;
            
            
            perc = drinksPrices[1][maxID] / 100;
            result = max.doubleValue() * perc;
            result = Math.round(result * 100);
            result = result / 100;
            result = result * 1.5;
            
            upPr[maxID] = drinksPrices[1][maxID] + result;
            upPr[minID] = drinksPrices[1][minID] - result;


//            System.out.println(i+"_____"+maxID+"Max: "+upPr[maxID]+"_____________"+minID+"Min: "+upPr[minID]);
//            System.out.print(percMovement[maxID]+"_____________"+percMovement[minID]);
//            System.out.println();
            //System.out.println(i+" at "+maxID+"_____________________________"+upPr[maxID]+" === "+drinksPrices[1][maxID]+dir1+result);
            //System.out.println(i+" at "+minID+"_____________________________"+upPr[minID]+" === "+drinksPrices[1][minID]+dir2+result);

            probMax = quantityOfDrinks[minID];
            probMin = quantityOfDrinks[maxID];

            drinksProb[maxID] = quantityOfDrinks[minID];
            drinksProb[minID] = quantityOfDrinks[maxID];
            perc = 0;
        }
        
//        for(int i=0;i<col;i++){
//            System.out.print(i+"_");
//        }
//        System.out.println();

        //System.out.println("______________________________________________________________________");
        //For loop printing idArray to check every element is updated.
//        for(int i=0;i<col;i++){
//            System.out.print(idArray[i]+"_");
//        }
//        System.out.println();
        //For loop printing out the updated prices.
        //        System.out.println("Updated drinks prices:");
        //        for(int i=0;i<col;i++){
        //            System.out.print(upPr[i]+"_");
        //        }
        //        System.out.println();

        updateDrinksPrices(upPr);
        calcDrinkProbability();
        printDrinksPrices();
        calcMovement();
    }

    public void calcMovement() {
        //Method to calculate the amount of movement since the last 5 mins.
        double originalNo, newNo, result;

        for (int i = 0; i < col; i++) {
            originalNo = drinksPrices[0][i];
            newNo = drinksPrices[1][i];

            result = ((newNo - originalNo) / originalNo) * 100;

            result = Double.valueOf(df.format(result));
            movement[i] = result;
            drinksMenu.get(i).setMovement(result);
        }
        System.out.println("Movement Percentage: ");
        for (int j = 0; j < col; j++) {
            System.out.print(drinksMenu.get(j).getMovement() + "_");
        }
        System.out.println();
//--------------------------Update Database with drink prices------------------------------------------
        tableName = ("drink_movements");
        addToDatabase(tableName, movement);
//-----------------------------------------------------------------------------------------------------        
    }

    /**
     * Method to decide what drink to buy depending on price: The % closer a
     * drinks price is to its min price should make the drinks more likely to be
     * chosen. E.g. if Stella min is £3 with a max of £7 and it's currently
     * £3.60 then it should have a higher chance of being picked than wine which
     * is min £4.50, max £9 and is at £7.
     *
     * How to work that out though? - Create a drinksProb array to store the
     * probability of a drink being chosen. - Use the quantityOfDrinks array to
     * find the highest and lowest sold drink. - Like when calculating new
     * drinks prices, the amount the highest drink is sold becomes the number of
     * times the lowest drinks id will appear in drinksProb[]. - Do this for all
     * drinks. - When picking a drink to be ordered, "randomly" select it from
     * drinksProb[].
     */
    public void calcDrinkProbability() {
        //This could be where the problem lies, young benjamin...
        for (int i = 0; i < quantityOfDrinks.length; i++) {
            int id = quantityOfDrinks[i];
            for (int j = 0; j < id; j++) {
                probabilities.add(i);
            }
        }
        //System.out.println("Total Probs:  " + probabilities.size());
    }

    public void updateDrinksPrices(double[] a) {
        double[] temp2Database = new double[col];
        for (int i = 0; i < col; i++) {
            temp2Database[i] = drinksPrices[0][i];
        }

        for (int i = 0; i < col; i++) {
            drinksPrices[0][i] = drinksPrices[1][i];
        }

        for (int i = 0; i < col; i++) {
            drinksPrices[1][i] = validateNewPrice(i, a[i]);
            drinksMenu.get(i).setCurrentPrice(drinksPrices[1][i]);
            //System.out.println(i+"_____________________________"+drinksMenu.get(i).getCurrentPrice());
            
            // So when the pricesw are being re-calculated. They aren't using the altered prices. For example
            // look at id=5.  
            
        }
        //--------------------------Update Database with drink prices------------------------------------------
        tableName = ("drink_prices");
        addToDatabase(tableName, drinksPrices[1]);
        //-----------------------------------------------------------------------------------------------------    
    }

    public double validateNewPrice(int count, double upPrVal) {
        /**
         * Method sets the correct price as what it comes in as and only changes
         * if it exceeds the pre-set boundaries.
         */
        double newPrice = upPrVal;
        double tempMin, tempMax;
        tempMax = drinksMenu.get(count).getMaxPrice();
        tempMin = drinksMenu.get(count).getMinPrice();

        if (upPrVal >= tempMax) {
            newPrice = tempMax;
            System.out.println("Corrected max drink ID is: " + count+". From "+upPrVal+" --> "+newPrice);
        } else if (upPrVal <= tempMin) {
            newPrice = tempMin;
            System.out.println("Corrected min drink ID is: " + count+". From "+upPrVal+" --> "+newPrice);
        }
        return newPrice;
    }
    
        
    public void generate5MinValues() {
        //for (int i = 0; i <= no5Mins; i++) {
            System.out.println("----------------------------------------------------------------------------------------------------------------------------------------------------------");
            System.out.println(interval + "th Min");
            generate5MinOrder();
            interval += 5;
            calcOrderedDrinks();
        //}
        //Test to see the total amount from orders for the day.
        DailyOrders dO = new DailyOrders();
        dO.addOrders(all5MinOrders);
        BigDecimal x = dO.getDayOrdersTotal();
        //System.out.println("Total: "+x+" No.Orders: "+listOfOrders.get(listOfOrders.size()-1).getOrderID());
    }

    public FiveMinOrder generate5MinOrder() {
        int temp = generateRandomValue();
        listOfOrders.clear();
        for (int i = 0; i < noOrdersIn5Mins; i++) {
            generateOrder();
        }
        FiveMinOrder or = new FiveMinOrder();
        or.addOrders(listOfOrders);
        all5MinOrders.add(or);

        System.out.println("ID: " + or.getFiveMinOrderID() + ". No.Orders: " + or.getNoOrdersFor5Mins() + ". Total: £" + or.getTotalOrdersCost());
        return or;
    }

    public Order generateOrder() {
        Order ord = new Order();
        ord = addDrinksToOrder(ord);
        listOfOrders.add(ord);
        //System.out.println("---------"+ ord.getOrderID() + " + £" + ord.getOrderTotal()+ " + " + ord.getNoDrinks()+ "----------------");
        return ord;
    }

    public Order addDrinksToOrder(Order ord) {
        int temp = generateRandomValue();

        for (int i = 0; i <= temp; i++) {
            ord.addDrink(getRandomDrink());
        }
        
        //send details back to database for storage & analytics. 
        //addOrderToDatabase(ord);
        return ord;
    }

    public Drink getRandomDrink() {
        //If its the first time round, order random drinks, otherwise use probabilities array.
        int index;
        Random rand = new Random();

        if (interval == 0) {
            index = rand.nextInt(drinksMenu.size());
        } else {
            index = probabilities.get(rand.nextInt(probabilities.size()));
        }
        Drink drink = drinksMenu.get(index);
        return drink;
    }

    public int generateRandomValue() {
        int low = 1;
        int high = maxNoDrinksInOrder;
        int rand = (int) (Math.random() * (high - low)) + low;
        return rand;
    }

    public int getNumberOfOrders() {
        return listOfOrders.size();
    }

    public void printOrderedDrinks() {
        for (int i = 0; i < listOfOrders.size(); i++) {
            for (int j = 0; j < listOfOrders.get(i).getNoDrinks(); j++) {
                System.out.print(" + " + listOfOrders.get(i).getDrinksOrdered().get(j).getID());
            }
            System.out.println();
        }
    }

    public void printAllDrinks() {
        for (int i = 0; i < drinksMenu.size(); i++) {
            //Prints the drinks names and current prices
            System.out.println(drinksMenu.get(i).getID() + "........" + drinksMenu.get(i).getCurrentPrice());
        }
    }

    public void printDrinksPrices() {
        System.out.println("Drinks Prices:");
        for (int i = 0; i < row; i++) {
            for (int j = 0; j < col; j++) {
                System.out.print(drinksPrices[i][j] + " + ");
            }
            System.out.println();
        }
    }

    public void initialiseDrinksPrices() {
        for (int i = 0; i < col; i++) {
            drinksPrices[1][i] = m.getCurrentPrice(i);
            //System.out.print(drinksPrices[0][i] + " + ");
        }
    }


    public void runProgramIncrementaly(){
        ScheduledExecutorService executor = Executors.newScheduledThreadPool(1);
        executor.scheduleAtFixedRate(helloRun, 0, runSpeed, TimeUnit.SECONDS);
    }

    Runnable helloRun = new Runnable(){
        public void run(){
            generate5MinValues();
        }
    };
}
