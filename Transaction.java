// Purpose: This class is used to create a transaction object that will be used to store transaction information.

public class Transaction {
    double transactionAmount;
    String transactionType;
    String transactionDate;
    String transactionStatus;
    int sourceAccount;
    int destinationAccount;

    // Constructor
    public Transaction(double transactionAmount, String transactionType, String transactionDate, String transactionStatus, int sourceAccount, int destinationAccount) {
        this.transactionAmount = transactionAmount;
        this.transactionType = transactionType;
        this.transactionDate = transactionDate;
        this.transactionStatus = transactionStatus;
        this.sourceAccount = sourceAccount;
        this.destinationAccount = destinationAccount;
    }

    // Getters
    public double getTransactionAmount() {
        return transactionAmount;
    }

    public String getTransactionType() {
        return transactionType;
    }

    public String getTransactionDate() {
        return transactionDate;
    }

    public String getTransactionStatus() {
        return transactionStatus;
    }

    public int getSourceAccount() {
        return sourceAccount;
    }

    public int getDestinationAccount() {
        return destinationAccount;
    }

    @Override
    public String toString(){
        return "Transaction Amount: " + transactionAmount + "\n" +
       "Transaction Type: " + transactionType + "\n" +
       "Transaction Date: " + transactionDate + "\n" +
       "Source Account: " + sourceAccount + "\n" +
       "Destination Account: " + destinationAccount + "\n" +
       "Transaction Status: " + transactionStatus;
    }
}
