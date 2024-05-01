# Billie

Example of Domain Driven Design implementation in PHP using Symfony framework.

An invoice is a document issued by a seller (creditor) to the buyer (debtor). It provides details
about a sale or services, including the quantities, costs. Factoring is a process where a company (creditor) sells its
invoice to a third-party factoring company (Billie). The factoring company then takes care of collecting the money from
the debtor. Since there is always the risk that a debtor won’t pay their invoices, Billie sets a debtor limit for each
company. This means that Billie won’t accept the invoice if the debtor’s total amount of open invoices reaches the
limit.

## Bounded Contexts
For simplicity, we will consider two main bounded contexts:

- Invoicing Context - Deals with creating and managing invoices.
- Company Management Context - Handles company-related operations.

## Core Domain Models
- Company
Attributes: Company ID, Name, Type, Address
Methods: UpdateDetails()
- Invoice
Attributes: Invoice ID, Debtor ID, Creditor ID, Amount, Issue Date, Due Date, Status
Methods: MarkAsPaid()
- Debtor Limit
Attributes: Debtor ID, Limit Amount, Current Utilized Amount
Methods: UpdateLimit(), CalculateRemainingCredit(), CanAcceptInvoice()

## Running the Project

To launch the platform locally, run:

```bash
make run
```

Navigate to http://localhost in your web browser to view the project.
