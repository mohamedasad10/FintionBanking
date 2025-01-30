
public class CurrentAccount extends Account {

    int minBalance = 10;

    public CurrentAccount(int accountNumber,String holderName,double balance, int minBalance){
        super(accountNumber,holderName,balance);
        this.minBalance = minBalance;

    }

    //account must have a minimum balance of 10
    @Override
    public void withDraw(double amount) {
        if (balance - amount < minBalance) {
            System.out.println("Withdrawal denied! Minimum balance of " + minBalance + " must be maintained.");
        } else {
            balance -= amount;
            System.out.println("Withdrawal successful! New balance: " + balance);
        }
    }


    
}


    



    

  
