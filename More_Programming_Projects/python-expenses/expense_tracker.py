from datetime import date

expenses = []

print("PERSONAL EXPENSE TRACKER")
print("Enter an expense. Type 'done' when finished.")

while True:
    name = input("\nExpense description: ").strip()
    if name.lower() == "done":
        break
    if not name:
        print("Description cannot be empty.")
        continue

    try:
        amount = float(input("Amount: "))
        if amount < 0:
            print("Amount cannot be negative.")
            continue
    except ValueError:
        print("Please enter a valid number.")
        continue

    expenses.append({"name": name, "amount": amount, "date": date.today()})
    print("Expense saved.")

print("\n--- EXPENSE REPORT ---")
for item in expenses:
    print(f"{item['date']} | {item['name']} | {item['amount']:.2f}")

total = sum(item["amount"] for item in expenses)
print(f"Total expenses: {total:.2f}")
print(f"Number of expenses: {len(expenses)}")
