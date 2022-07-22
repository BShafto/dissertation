package ordergeneration;
import java.util.ArrayList;
/**
 * @author bshafto
 */
public class Menu {
    private ArrayList<Drink> listOfDrinks = new ArrayList<Drink>();
    public ArrayList<Drink> createMenu() {
        Drink objt1 = new Drink(0, "Stella", 5, 8.99, 2.99,"Beer", 0.0);
        Drink objt2 = new Drink(1, "Carling", 5, 8.99, 2.99,"Beer", 0.0);
        Drink objt3 = new Drink(2, "Carlsberg", 5, 8.99, 2.99,"Beer", 0.0);
        Drink objt4 = new Drink(3, "Becks", 5, 8.99, 2.99,"Beer", 0.0);
        Drink objt5 = new Drink(4, "Mahou", 5, 8.99, 2.99,"Beer", 0.0);
        Drink objt6 = new Drink(5, "Heineken", 5, 8.99, 2.99,"Beer", 0.0);

        Drink objt7 = new Drink(6, "Strongbow", 5, 8.99, 2.99,"Cider", 0.0);
        Drink objt8 = new Drink(7, "Strongbow Dark Fruits", 5, 8.99, 2.99,"Cider", 0.0);
        Drink objt9 = new Drink(8, "Bulmers", 5, 8.99, 2.99,"Cider", 0.0);
        Drink objt10 = new Drink(9, "Magners", 5, 8.99, 2.99,"Cider", 0.0);
        Drink objt11 = new Drink(10, "Old Mout", 5, 8.99, 2.99,"Cider", 0.0);

        Drink objt12 = new Drink(11, "Vodka Coke", 5, 8.99, 2.99,"Spirits", 0.0);
        Drink objt13 = new Drink(12, "Gin Tonic", 5, 8.99, 2.99,"Spirits", 0.0);
        Drink objt14 = new Drink(13, "Rum Coke", 5, 8.99, 2.99,"Spirits", 0.0);
        Drink objt15 = new Drink(14, "Spiced Rum Coke", 5, 8.99, 2.99,"Spirits", 0.0);
        Drink objt16 = new Drink(15, "Gin Lemonade", 5, 8.99, 2.99,"Spirits", 0.0);
        Drink objt17 = new Drink(16, "Malibu Coke", 5, 8.99, 2.99,"Spirits", 0.0);

        Drink objt18 = new Drink(17, "Tequila", 5, 8.99, 2.99,"Shots", 0.0);
        Drink objt19 = new Drink(18, "Jägerbomb", 5, 8.99, 2.99,"Shots", 0.0);
        Drink objt20 = new Drink(19, "Sambuca", 5, 8.99, 2.99,"Shots", 0.0);
        Drink objt21 = new Drink(20, "Vodka", 5, 8.99, 2.99,"Shots", 0.0);
        Drink objt22 = new Drink(21, "Fireball", 5, 8.99, 2.99,"Shots", 0.0);
        Drink objt23 = new Drink(22, "Dark Rum", 5, 8.99, 2.99,"Shots", 0.0);

        Drink objt24 = new Drink(23, "Sex on the beach", 5, 8.99, 2.99,"Cocktails", 0.0);
        Drink objt25 = new Drink(24, "Mojito", 5, 8.99, 2.99,"Cocktails", 0.0);
        Drink objt26 = new Drink(25, "Long Island Iced Tea", 5, 8.99, 2.99,"Cocktails", 0.0);
        Drink objt27 = new Drink(26, "Martini",5, 8.99, 2.99,"Cocktails", 0.0);
        Drink objt28 = new Drink(27, "Daiquiri", 5, 8.99, 2.99,"Cocktails", 0.0);
        Drink objt29 = new Drink(28, "Old Fashioned", 5, 8.99, 2.99,"Cocktails", 0.0);
        
        Drink objt30 = new Drink(29, "Chardonnay", 5, 8.99, 2.99,"Wine", 0.0);
        Drink objt31 = new Drink(30, "Rioja", 5, 8.99, 2.99,"Wine", 0.0);
        Drink objt32 = new Drink(31, "Rosé", 5, 8.99, 2.99,"Wine", 0.0);
        Drink objt33 = new Drink(32, "Merlot", 5, 8.99, 2.99,"Wine", 0.0);
        Drink objt34 = new Drink(33, "Sauvignon Blanc", 5, 8.99, 2.99,"Wine", 0.0);
        Drink objt35 = new Drink(34, "Pinot Noir", 5, 8.99, 2.99,"Wine", 0.0);
        
        listOfDrinks.add(objt1);
        listOfDrinks.add(objt2);
        listOfDrinks.add(objt3);
        listOfDrinks.add(objt4);
        listOfDrinks.add(objt5);
        listOfDrinks.add(objt6);
        listOfDrinks.add(objt7);
        listOfDrinks.add(objt8);
        listOfDrinks.add(objt9);
        listOfDrinks.add(objt10);
        listOfDrinks.add(objt11);
        listOfDrinks.add(objt12);
        listOfDrinks.add(objt13);
        listOfDrinks.add(objt14);
        listOfDrinks.add(objt15);
        listOfDrinks.add(objt16);
        listOfDrinks.add(objt17);
        listOfDrinks.add(objt18);
        listOfDrinks.add(objt19);
        listOfDrinks.add(objt20);
        listOfDrinks.add(objt21);
        listOfDrinks.add(objt22);
        listOfDrinks.add(objt23);
        listOfDrinks.add(objt24);
        listOfDrinks.add(objt25);
        listOfDrinks.add(objt26);
        listOfDrinks.add(objt27);
        listOfDrinks.add(objt28);
        listOfDrinks.add(objt29);
        listOfDrinks.add(objt30);
        listOfDrinks.add(objt31);
        listOfDrinks.add(objt32);
        listOfDrinks.add(objt33);
        listOfDrinks.add(objt34);
        listOfDrinks.add(objt35);
        
        return listOfDrinks;
    }
    
    public double getCurrentPrice(int id){
        double cP = listOfDrinks.get(id).getCurrentPrice();
        return cP;
    }
    
    public void setCurrentPrice(int id){
        int sP = listOfDrinks.get(id).getID();
        listOfDrinks.get(sP).setCurrentPrice(5);
    }
}
