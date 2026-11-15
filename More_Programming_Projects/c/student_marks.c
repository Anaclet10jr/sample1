#include <stdio.h>

int main(void) {
    int count;
    double mark, total = 0, average;

    printf("How many subjects? ");
    if (scanf("%d", &count) != 1 || count <= 0) {
        printf("Please enter a positive number of subjects.\n");
        return 1;
    }

    for (int i = 1; i <= count; i++) {
        printf("Enter mark for subject %d (0-100): ", i);
        if (scanf("%lf", &mark) != 1 || mark < 0 || mark > 100) {
            printf("Invalid mark. Enter a value from 0 to 100.\n");
            return 1;
        }
        total += mark;
    }

    average = total / count;
    printf("\nTotal: %.2f\nAverage: %.2f\n", total, average);

    if (average >= 80) printf("Grade: A\n");
    else if (average >= 70) printf("Grade: B\n");
    else if (average >= 60) printf("Grade: C\n");
    else if (average >= 50) printf("Grade: D\n");
    else printf("Grade: F\n");

    return 0;
}
