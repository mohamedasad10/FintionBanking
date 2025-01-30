import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        ArrayList<Account> accounts = new ArrayList<>();
        
        //Creating an example Account
        Account account = new CurrentAccount(10,"Mohamed", 300,10);
        accounts.add(account); //adding the account to the ArrayList

        Account account1 = new CurrentAccount(20,"Mohamed Asad", 1200,10);
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

            switch(userChoice){
                case 1:
                    accountManager.createAccount(scanner);
                    break;

                case 2:
                    System.out.println("Please enter the amount you would like to Deposit: ");
                    int depositAmount = scanner.nextInt();
                    account.deposit(depositAmount);
                    break;

                case 3:
                    System.out.println("Please enter the amount you would like to Withdraw: ");
                    int withdrawalAmount = scanner.nextInt();
                    account.withDraw(withdrawalAmount);
                    break;

                case 4:
                    account.checkBalance();    
                    break;

                case 5:
                    account.transfer( scanner,accounts);
                    break;    

                case 7:
                    accountManager.listAccounts();
                    break;

            default:
                System.out.println("Invalid choice. Please enter a number between 1 and 8.");

                break;
            }    
        }
    }
}
