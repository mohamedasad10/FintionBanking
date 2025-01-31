import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        ArrayList<Account> accounts = new ArrayList<>();

        // Creating example accounts
        Account account = new CurrentAccount(10, "Mohamed", 300, 10);
        accounts.add(account);
        Account account1 = new CurrentAccount(20, "Mohamed Asad", 1200, 10);
        accounts.add(account1);

        AccountManager accountManager = new AccountManager(accounts);
        Scanner scanner = new Scanner(System.in);

        while(true){
            System.out.println("Choose an option:");
            System.out.println("1. Create Account");
            System.out.println("2. Deposit Money");
            System.out.println("3. Withdraw Money");
            System.out.println("4. View Balance");
            System.out.println("5. Transfer Money");
            System.out.println("6. View Transaction History");
            System.out.println("7. View All Accounts");
            System.out.println("8. Exit");

            int userChoice = scanner.nextInt();

            // Let the user select an account for operations (for most operations, we need a specific account)
            Account selectedAccount = null;
            if (userChoice != 1 && userChoice != 7 && userChoice != 8) {  // skip selection for creating account and viewing all accounts
                System.out.println("Enter account number:");
                int accountNumber = scanner.nextInt();
                for (Account acc : accounts) {
                    if (acc.getAccountNumber() == accountNumber) {
                        selectedAccount = acc;
                        break;
                    }
                }

                if (selectedAccount == null) {
                    System.out.println("Account not found.");
                    continue; // Skip the operation if account is not found
                }
            }

            switch(userChoice){
                case 1:
                    accountManager.createAccount(scanner);
                    break;

                case 2:
                    System.out.println("Please enter the amount you would like to Deposit: ");
                    int depositAmount = scanner.nextInt();
                    selectedAccount.deposit(depositAmount);
                    break;

                case 3:
                    System.out.println("Please enter the amount you would like to Withdraw: ");
                    int withdrawalAmount = scanner.nextInt();
                    selectedAccount.withDraw(withdrawalAmount);
                    break;

                case 4:
                    selectedAccount.checkBalance();    
                    break;

                case 5:
                    selectedAccount.transfer(scanner, accounts);
                    break;    

                case 6:
                    if (selectedAccount != null) {
                        selectedAccount.viewTransactionHistory();
                    } else {
                        System.out.println("No account selected.");
                    }
                    break;
                

                case 7:
                    accountManager.listAccounts();
                    break;

                case 8:
                    System.out.println("Thank You for using our services. Goodbye");
                    System.exit(0);
                    break;

                default:
                    System.out.println("Invalid choice. Please enter a number between 1 and 8.");
                    break;
            }    
        }
    }
}

