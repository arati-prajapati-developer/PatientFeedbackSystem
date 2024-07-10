## Overview

This project is designed to store patient feedback records. The admin interface includes functionalities to view, edit, and delete patient feedback records, and the admin can do login and logout operations.

## Setup Instructions
### Prerequisites
- PHP 
- SQL Server
- IIS
- Composer

## Installation Steps
#### 1. Clone the Repository:
```bash
- Go to your IIS server root folder
- git clone https://github.com/arati-prajapati-developer/PatientFeedbackSystem.git
- cd PatientFeedbackSystem
- Composer install
```

#### 2. Database Setup
- Open a SQL server
- Open PatientFeedbackSystem/database/database.sql
- Update the database_name
```bash
IF NOT EXISTS (
    SELECT name 
    FROM master.dbo.sysdatabases 
    WHERE name = '<database_name>'
)
BEGIN
    CREATE DATABASE <database_name>;
END
GO

-- use this database for the next coming command | execution
USE <database_name>;
GO

```
- In the SQL server run the above object and create a database.

#### 3. Configuration
- Open the.env file
- Configure the database configuration

```bash
# DATABASE CONFIGURATION
DB_SERVER=<server_name>
DB_NAME=<database_name>
DB_USERNAME=<username>
DB_PASSWORD=<password>
```

#### 4. Running the Application
- Navigate to the application URL in your web browser (e.g., `http://localhost/PatientFeedbackSystem` OR `http://localhost/PatientFeedbackSystem/index.php`).
#### Title: Patient feedback information form For Patient (User)
![Neuromodulation](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/9a059293-7b82-4169-9901-565fca50c5da)

# Usage
## Admin Login
- Access the admin interface using `http://localhost/PatientFeedbackSystem/login.php`.
- Use the following credentials to log in: 
  - Email: admin@mailinator.com
  - Password: Admin@123

#### Title: Admin Login Page
![Login](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/35edffe6-c3b9-4953-9eb8-af47f9b33956)

## Admin Dashboard
- After logging in, you will be redirected to the patient feedback dashboard (`admin.php`).
- Here, you can view patient feedback records.
- See detailed patient feedback information on the "View" button.
- Click on the "Edit" button to update patient details.
- Click on the "Delete" button to remove a patient record.

#### Title: Patient feedback information view page
![Admin](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/66c40448-e3c9-4d53-b31c-d960f6f4035a)

#### Title: Patient feedback information read-only mode
![Edit-Neuromodulation](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/cdbfc5ae-c74d-4028-a270-bc30f5ae5044)

#### Title: Patient feedback information edit mode
![Update-Neuromodulation](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/74523083-b37d-4e21-919f-430d1e3abeae)

#### Title: After Patient feedback information
![After Update Record Admin](https://github.com/arati-prajapati-developer/PatientFeedbackSystem/assets/175064831/2ee28f3d-e063-406e-beda-e469e0c07923)


## Logout
- Click the "Logout" link in the header to log out from the admin interface.
