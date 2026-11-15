import java.util.ArrayList;
import java.util.Scanner;

class Book {
    private String title;
    private String author;

    public Book(String title, String author) {
        this.title = title;
        this.author = author;
    }

    public String getTitle() { return title; }
    public String getAuthor() { return author; }

    public void display() {
        System.out.println("Title: " + title + " | Author: " + author);
    }
}

public class LibraryApp {
    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        ArrayList<Book> books = new ArrayList<>();
        int choice;

        do {
            System.out.println("\n=== LIBRARY MENU ===");
            System.out.println("1. Add book");
            System.out.println("2. View books");
            System.out.println("3. Search by title");
            System.out.println("0. Exit");
            System.out.print("Choose: ");
            choice = input.nextInt();
            input.nextLine();

            switch (choice) {
                case 1:
                    System.out.print("Book title: ");
                    String title = input.nextLine();
                    System.out.print("Author: ");
                    String author = input.nextLine();
                    books.add(new Book(title, author));
                    System.out.println("Book added.");
                    break;
                case 2:
                    if (books.isEmpty()) System.out.println("No books yet.");
                    for (Book book : books) book.display();
                    break;
                case 3:
                    System.out.print("Enter title to search: ");
                    String search = input.nextLine();
                    boolean found = false;
                    for (Book book : books) {
                        if (book.getTitle().toLowerCase().contains(search.toLowerCase())) {
                            book.display();
                            found = true;
                        }
                    }
                    if (!found) System.out.println("No matching book found.");
                    break;
                case 0:
                    System.out.println("Goodbye!");
                    break;
                default:
                    System.out.println("Invalid choice.");
            }
        } while (choice != 0);

        input.close();
    }
}
