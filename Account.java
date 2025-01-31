

import java.time.LocalDate;

import java.util.ArrayList;
import java.util.Scanner;

public class Account {

    int accountNumber;
    String holderName;
    double balance ;

    ArrayList<Transaction> transactions; // Add a list of transactions to the account



    //Constructor
    public Account(int accountNumber,String holderName,double balance){ 
        this.accountNumber = accountNumber;
        this.holderName = holderName;
        this.balance = balance; 
        this.transactions = new ArrayList<>(); //new ArrayList because this ensures that each account has its own transaction history as soon as it's created.

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

    

    //Check Balance

    public void checkBalance(){
        System.out.println("Bank Balance: " + balance);
    }



    //Deposit Money

    public void deposit(double depositAmount){
        balance += depositAmount;
        System.out.println("You have deposited " + depositAmount + " into your account. ");
        System.out.println("Your new balance is: " + balance);
    }


    //Withdraw Money
    public void withDraw(double withdrawalAmount) {
        if (balance >= withdrawalAmount) { // Check if there are sufficient funds
            balance -= withdrawalAmount;
            System.out.println("You have withdrawn " + withdrawalAmount + " from your bank account.");
            System.out.println("Your remaining balance is: " + balance);

            // Add withdrawal transaction
            String transactionDate = LocalDate.now().toString();
            Transaction transaction = new Transaction(withdrawalAmount, "Withdrawal", transactionDate, "Success", accountNumber, -1);
            transactions.add(transaction);

        } else {
            System.out.println("Insufficient funds. Withdrawal denied.");
        } 
    }

    //Transfer Money

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

            
            // Add the transaction to the transaction history
            Transaction transaction = new Transaction(transferAmount, "Transfer", "2021-09-01", "Success", sourceAccount, destinationAccount);
            transactions.add(transaction);
        }

    }

    //View Transactions
    public void viewTransactionHistory() {
        System.out.println("Transaction History: ");
        if (transactions.isEmpty()) {
            System.out.println("No transactions found.");
        } else {
            for (Transaction transaction : transactions) {
                System.out.println(transaction);
            }

        }
    }
    
}

    

    


