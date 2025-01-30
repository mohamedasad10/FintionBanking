import java.util.ArrayList;
import java.util.Scanner;

public class Account {

    int accountNumber;
    String holderName;
    double balance ;

    public Account(int accountNumber,String holderName,double balance){
        this.accountNumber = accountNumber;
        this.holderName = holderName;
        this.balance = balance;
    }

    // Getters for accessing private fields
    public int getAccountNumber() {
        return accountNumber;
    }

    public String getHolderName() {
        return holderName;
    }

    public double getBalance() {
        return balance;
    }

    

    public void checkBalance(){
        System.out.println("Bank Balance: " + balance);
    }

    public void deposit(double depositAmount){
        balance += depositAmount;
        System.out.println("You have deposited " + depositAmount + " into your account. ");
        System.out.println("Your new balance is: " + balance);
    }

    public void withDraw(double withdrawalAmount){
        balance -= withdrawalAmount;
        System.out.println("You have withdrew " + withdrawalAmount + " from your bank account.");
        System.out.println("Your remaining balance is: " + balance);
    }

    public void transfer(Scanner scanner, ArrayList<Account> accounts) {
        System.out.println("Transfer Money");
        System.out.println("Enter the source account (from which money is being transferred)");
        int sourceAccount = scanner.nextInt();
        scanner.nextLine();
    
        ////////////////////////////////////////////////////
        // Check if source account exists in the accounts list
        boolean sourceExists = false;
        for (Account acc : accounts) {
            if (acc.getAccountNumber() == sourceAccount) {
                sourceExists = true;
                break;
            }
        }
    
        if (!sourceExists) {
            System.out.println("Invalid source account number. Transfer failed.");
            return;
        }

        ///////////////////////////////////////////////
    
        
        // Proceed with the rest of the transfer logic
        System.out.println("Enter the destination account to which money is being transferred");
        int destinationAccount = scanner.nextInt();
        scanner.nextLine();

    
        ////////////////////////////////////////////////////
        // Check if destination account exists
        boolean destinationExists = false;
        for (Account acc : accounts) {
            if (acc.getAccountNumber() == destinationAccount) {
                destinationExists = true;
                break;
            }
        }
    
        // Check if destination account does not exist
        if (!destinationExists) {
            System.out.println("Invalid destination account number. Transfer failed.");
            return;
        }
        ///////////////////////////////////////////////////
    
        // Check if destination is the same as source account
        if (destinationAccount == sourceAccount) {
            System.out.println("Invalid destination account (cannot transfer to the same account).");
            return;
        }
    
        // Transfer the amount after all the above checks are completed
        System.out.println("Enter the amount you would like to transfer: ");
        double transferAmount = scanner.nextDouble();
        scanner.nextLine();
    
        // Check if there are sufficient funds
        if (balance - transferAmount < 0) {
            System.out.println("Insufficient funds. Transfer denied.");
        } else {
            balance -= transferAmount;
            System.out.println("Transfer successful! New balance: " + balance);
    
            // Find the destination account and deposit the amount
            for (Account acc : accounts) {
                if (acc.getAccountNumber() == destinationAccount) {
                    acc.balance += transferAmount;
                    System.out.println("Transfer of " + transferAmount + " to account " + destinationAccount + " successful.");
                    break;
                }
            }
        }
    }
    
}

    

    


