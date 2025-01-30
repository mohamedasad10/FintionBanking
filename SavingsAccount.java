public class SavingsAccount extends Account {
    double interestRate;

    public SavingsAccount(int accountNumber,String holderName,double balance,double interestRate){
        super(accountNumber,holderName,balance);
        this.interestRate = interestRate;
        

    }

    
}
