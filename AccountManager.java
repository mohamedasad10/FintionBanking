import java.util.ArrayList;
import java.util.Scanner;

public class AccountManager {

    private ArrayList<Account> accounts ;

    public AccountManager(ArrayList<Account> accounts) {
        this.accounts = accounts;
    }


    public void createAccount(Scanner scanner){
        int choice = 0;
        int accountNumber = 0;
        double balance = 0.0;

        while (true) {
            System.out.println("Enter Account Type (1. Savings, 2. Current): ");
            if (scanner.hasNextInt()) {
                choice = scanner.nextInt();
                scanner.nextLine(); // Consume newline
                if (choice == 1 || choice == 2) {
                    break; // Valid input, exit loop
                } else {
                    System.out.println("Invalid choice. Please enter 1 for Savings or 2 for Current.");
                }
            } else {
                System.out.println("Invalid input. Please enter a number (1 or 2).");
                scanner.nextLine(); // Clear invalid input
            }
        }

        while (true) {
            System.out.println("Enter Account Number: ");
            if (scanner.hasNextInt()) {
                accountNumber = scanner.nextInt();
                scanner.nextLine();
                break; // Valid input, exit loop
            } else {
                System.out.println("Invalid input. Please enter a numeric account number.");
                scanner.nextLine(); // Clear invalid input
            }
        }

        System.out.println("Enter Holder Name: ");
        String holderName = scanner.nextLine();

        while (true) {
            System.out.println("Enter Initial Balance: ");
            if (scanner.hasNextDouble()) {
                balance = scanner.nextDouble();
                scanner.nextLine();
                break; // Valid input, exit loop
            } else {
                System.out.println("Invalid input. Please enter a valid number for balance.");
                scanner.nextLine(); // Clear invalid input
            }
        }

        Account account;

        
        if (choice == 1) {
            // Create SavingsAccount
            account = new SavingsAccount(accountNumber, holderName, balance, 2.5);  // For example, 2.5% interest rate
        } else {
            // Create CurrentAccount
            account = new CurrentAccount(accountNumber, holderName, balance, 1000);  // For example, minimum balance 1000
        }

        accounts.add(account);
        System.out.println("Account created successfully.");
    }


    public void listAccounts() {
        if (accounts.isEmpty()) {
            System.out.println("No accounts found.");
            return;
        }
    
        System.out.println("List of Accounts:");
        for (Account account : accounts) {
            System.out.println("Account Number: " + account.getAccountNumber() +
                               ", Holder: " + account.getHolderName() +
                               ", Balance: $" + account.getBalance());
        }
    }
    
}