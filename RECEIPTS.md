## Creating receipt

There are different types of receipts that can be created in the system. System simplifies 
adding receipts of Fee and Infaaq by displaying additional fields to chose linked information 
to these types of recipts.

- **Generic Receipt**
This type of receipt requires following information:
Receipt No. (auto) {no}
Period (auto) {period_id}
Site (auto) {site_id}
Date {rdate}
Department {department_id}
Type (of income) {income_id}
Title {title}
Description {description}
Amount {amount}
Payment (mode) {payment_id}
{accound_id=1}

- **Infaaq Receipt**
This type of receipt requires following information in addition to the generic fields data:
Member info {m_id}
Infaq start {fdate} and end date {tdate}.

- **Fee Receipt**
This type of receipt requires following information in addition to the generic fields data:
Student info (m_id)
Campus {department_id}
Course {account_id}
Fee start {fdate} and end date {tdate}.

**==========================**
**== ==**
**==========================**
